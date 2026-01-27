<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TextCensorService
{
    /**
     * API dan Model AI Moderation
     */
    protected string $apiUrl = 'https://openrouter.ai/api/v1/chat/completions';

    protected string $model = 'meta-llama/llama-3.3-70b-instruct:free';

    /**
     * Deteksi apakah teks mengandung kata tidak pantas, SARA, atau konten negatif.
     */
    public function hasForbiddenWords(string $text): array
    {
        $cacheKey = 'ai_moderation_' . md5($text);

        // Gunakan cache supaya tidak memanggil API berulang
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . config('services.openrouter.key'),
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'E-Lapor-DIY-Moderation',
            ])->post($this->apiUrl, [
                        'model' => $this->model,
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => <<<'EOT'
Kamu sistem moderasi teks. Jawab HARUS:
BARIS 1: "YA" (berbahaya) atau "TIDAK" (aman)
BARIS 2: Alasan singkat.

YA jika mengandung: Seksual, Kekerasan/Ancaman, Makian Kasar (anjing, dsb), SARA, Pelecehan.
TIDAK jika aman.
EOT
                            ],
                            ['role' => 'user', 'content' => $text],
                        ],
                    ]);

            if ($response->failed()) {
                throw new \Exception("Moderation API Error: " . $response->status());
            }

            $raw = trim($response->json('choices.0.message.content') ?? "TIDAK\nTeks aman.");
            $lines = explode("\n", $raw, 2);
            $answer = strtoupper(trim($lines[0] ?? 'TIDAK'));
            $reason = trim($lines[1] ?? 'Teks aman.');

            $result = [
                'forbidden' => str_contains($answer, 'YA'),
                'reason' => $reason,
            ];

            Cache::put($cacheKey, $result, now()->addHours(6));

            Log::info("AI Moderation Result", [
                'result' => $answer,
                'reason' => $reason,
            ]);
            return $result;

        } catch (\Throwable $e) {

            Log::error('AI moderation error: ' . $e->getMessage(), [
                'excerpt' => mb_substr($text, 0, 150) . '...'
            ]);

            return [
                'forbidden' => false,
                'reason' => 'Fallback AI Error — dianggap aman',
            ];
        }
    }

    /**
     * Analisis mendalam laporan menggunakan AI:
     * - Priority (Low, Medium, High, Emergency)
     * - Sentiment (Positive, Neutral, Negative)
     */
    public function analyzeReport(string $text): array
    {
        $textLower = strtolower($text);

        // ============================
        // HARD EMERGENCY RULE
        // ============================
        $emergencyKeywords = [
            'kebakaran',
            'api besar',
            'asap tebal',
            'kecelakaan',
            'tabrakan',
            'darah',
            'luka parah',
            'begal',
            'perampokan',
            'pembunuhan',
            'senjata',
            'banjir',
            'gempa',
            'longsor',
            'pohon tumbang',
            'serangan jantung',
            'pingsan'
        ];

        foreach ($emergencyKeywords as $keyword) {
            if (preg_match("/\b{$keyword}\b/i", $textLower)) {

                Log::warning('AI Analysis Emergency Triggered', [
                    'mode' => 'emergency_rule',
                    'keyword' => $keyword,
                    'text_excerpt' => mb_substr($text, 0, 120) . '...',
                ]);

                return [
                    'priority' => 'Emergency',
                    'sentiment' => 'Negative',
                    'suggested_category_id' => null,
                    'ai_summary' => 'Situasi darurat terdeteksi otomatis.',
                    'analysis_mode' => 'emergency_rule',
                    'analysis_reason' => "Keyword emergency terdeteksi: $keyword",
                ];
            }
        }

        try {
            Log::info('AI Analysis Started (Optimized)', [
                'mode' => 'ai_request',
                'text_excerpt' => mb_substr($text, 0, 120) . '...',
            ]);

            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . config('services.openrouter.key'),
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'E-Lapor-DIY-Analysis',
            ])->post($this->apiUrl, [
                        'model' => $this->model,
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => <<<EOT
AI Klasifikasi Laporan. Cepat & Akurat.
Hasilkan JSON:
{
 "priority": "Low|Medium|High|Emergency",
 "sentiment": "Positive|Neutral|Negative",
 "ai_summary": "Ringkasan sangat singkat (max 15 kata)"
}
EOT
                            ],
                            ['role' => 'user', 'content' => $text],
                        ],
                    ]); // Remove response_format to avoid 400 Value Error with Llama 3.3

            if ($response->failed()) {
                throw new \Exception("API Error: " . $response->status() . " - " . $response->body());
            }

            $raw = $response->json('choices.0.message.content');

            if (!$raw) {
                Log::error('AI Empty Response', ['body' => $response->body()]);
                throw new \Exception('AI Response is empty');
            }

            // Extract JSON from response if AI added extra text
            if (preg_match('/\{.*\}/s', $raw, $matches)) {
                $raw = $matches[0];
            }

            $result = json_decode($raw, true);

            // LOG RAW RESPONSE
            Log::info('AI Raw Response', [
                'mode' => 'ai_raw',
                'raw' => $raw
            ]);

            if (!is_array($result)) {
                throw new \Exception('Invalid AI JSON');
            }

            $final = [
                'priority' => in_array($result['priority'] ?? '', ['Low', 'Medium', 'High', 'Emergency'])
                    ? $result['priority'] : 'Low',

                'sentiment' => in_array($result['sentiment'] ?? '', ['Positive', 'Neutral', 'Negative'])
                    ? $result['sentiment'] : 'Neutral',

                'suggested_category_id' => null,
                'ai_summary' => $result['ai_summary'] ?? '',

                'analysis_mode' => 'ai',
                'analysis_reason' => 'AI classification success',
            ];

            Log::info('AI Analysis Completed', $final);

            return $final;

        } catch (\Throwable $e) {

            Log::error('AI Analysis failed', [
                'mode' => 'fallback',
                'error' => $e->getMessage(),
                'text_excerpt' => mb_substr($text, 0, 120) . '...',
            ]);

            // === SMART FALLBACK (Local Keyword Check) ===
            $fallbackPriority = 'Low';
            $fallbackReason = $e->getMessage();

            // 1. EMERGENCY KEYWORDS (Life-threatening, Crime, Disaster)
            $emergencyKeywords = [
                'kebakaran',
                'api besar',
                'meledak',
                'ledakan',
                'kecelakaan',
                'tabrakan',
                'berdarah',
                'luka parah',
                'pingsan',
                'serangan jantung',
                'sekarat',
                'pembunuhan',
                'perampokan',
                'begal',
                'senjata',
                'tawuran',
                'bacok',
                'banjir bandang',
                'gempa',
                'tsunami',
                'longsor',
                'angin puting beliung',
                'tenggelam',
                'hanyut',
                'terjebak',
                'darurat',
                'tolong'
            ];

            // 2. HIGH KEYWORDS (Urgent, Dangerous, Infrastructure Failure)
            $highKeywords = [
                'jalan putus',
                'jalan amblas',
                'jembatan rusak',
                'jembatan putus',
                'pohon tumbang',
                'pohon miring',
                'tiang listrik miring',
                'kabel putus',
                'kabel menjuntai',
                'tersengat',
                'banjir',
                'genangan tinggi',
                'tanggul jebol',
                'luapan',
                'pipa bocor',
                'gas bocor',
                'bau gas',
                'rawan',
                'mencurigakan',
                'ancaman',
                'preman',
                'lampu merah mati',
                'trafic light mati',
                'macet total'
            ];

            // 3. MEDIUM KEYWORDS (Service Disruption, Nuisance)
            $mediumKeywords = [
                'sampah',
                'bau',
                'menyengat',
                'kotor',
                'limbah',
                'macet',
                'antrean',
                'parkir liar',
                'trotoar rusak',
                'lampu mati',
                'pju mati',
                'gelap',
                'jalan berlubang',
                'aspal rusak',
                'polisi tidur',
                'air mati',
                'air keruh',
                'air kotor',
                'ledeng mati',
                'pelayanan',
                'lambat',
                'kasar',
                'pungli',
                'birokrasi',
                'berisik',
                'gangguan',
                'knalpot brong'
            ];

            // Check Emergency
            foreach ($emergencyKeywords as $kw) {
                if (stripos($text, $kw) !== false) {
                    $fallbackPriority = 'Emergency';
                    $fallbackReason = "Fallback Rule: Priority Keyword '$kw' detected";
                    break;
                }
            }

            // Check High (if not Emergency)
            if ($fallbackPriority === 'Low') {
                foreach ($highKeywords as $kw) {
                    if (stripos($text, $kw) !== false) {
                        $fallbackPriority = 'High';
                        $fallbackReason = "Fallback Rule: Priority Keyword '$kw' detected";
                        break;
                    }
                }
            }

            // Check Medium (if not High/Emergency)
            if ($fallbackPriority === 'Low') {
                foreach ($mediumKeywords as $kw) {
                    if (stripos($text, $kw) !== false) {
                        $fallbackPriority = 'Medium';
                        $fallbackReason = "Fallback Rule: Priority Keyword '$kw' detected";
                        break;
                    }
                }
            }

            return [
                'priority' => $fallbackPriority,
                'sentiment' => 'Negative', // Asumsi aduan biasanya negatif/keluhan
                'suggested_category_id' => null,
                'ai_summary' => 'Analisis otomatis terkendala, menggunakan deteksi kata kunci darurat.',
                'analysis_mode' => 'fallback_smart_v2',
                'analysis_reason' => $fallbackReason,
            ];
        }
    }

    /**
     * Sensor manual kata kasar (fallback lokal)
     */
    public function censor(string $text): string
    {
        $forbidden = [
            'anjing',
            'bangsat',
            'bodoh',
            'tolol',
            'goblok',
            'babi',
            'kafir',
            'setan',
        ];

        foreach ($forbidden as $word) {
            $pattern = "/\b" . preg_quote($word, '/') . "\b/i";
            $text = preg_replace($pattern, str_repeat('*', strlen($word)), $text);
        }

        return $text;
    }

    /**
     * AI Chatbot Response - untuk menjawab pertanyaan warga tentang E-Lapor
     */
    public function chatbotResponse(string $message, ?int $userId, array $stats = []): string
    {
        try {
            $context = $userId ? "User sudah login (ID: {$userId})" : "User belum login (guest)";

            // Format statistik untuk AI
            $statsText = "";
            if (!empty($stats)) {
                $statusText = isset($stats['status_counts'])
                    ? collect($stats['status_counts'])->map(fn($v, $k) => "$k: $v")->implode(', ')
                    : '-';

                $prioText = isset($stats['priority_counts'])
                    ? collect($stats['priority_counts'])->map(fn($v, $k) => "$k: $v")->implode(', ')
                    : '-';

                $instansiText = $stats['top_instansi'] ?? '-';
                $wilayahText = $stats['wilayah_stats'] ?? '-';
                $completionRate = $stats['completion_rate'] ?? '0%';

                $statsText = <<<STATS
DATA DASHBOARD REAL-TIME:
- Laporan Hari Ini: {$stats['reports_today']}
- Total Laporan Masuk: {$stats['total_reports']}
- Tingkat Penyelesaian: {$completionRate}
- Statistik Status: {$statusText}
- Statistik Urgensi: {$prioText}
- Topik Terpopuler: {$stats['top_categories']}
- Instansi Teraktif: {$instansiText}
- Wilayah Terbanyak: {$wilayahText}
STATS;
            }

            $response = Http::timeout(30)->withHeaders([
                'Authorization' => 'Bearer ' . config('services.openrouter.key'),
                'Content-Type' => 'application/json',
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'E-Lapor-DIY-Chatbot',
            ])->post($this->apiUrl, [
                        'model' => $this->model,
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => "Asisten E-Lapor DIY. Bantu warga ramah. Stats: $statsText. Konteks: $context"
                            ],
                            ['role' => 'user', 'content' => $message],
                        ],
                        'max_tokens' => 400,
                    ]);

            if ($response->failed()) {
                throw new \Exception("Chatbot API Error: " . $response->status());
            }

            $content = $response->json('choices.0.message.content');

            return $content ?? 'Maaf, saya tidak dapat memproses pertanyaan Anda saat ini.';

        } catch (\Throwable $e) {
            Log::error('Chatbot AI Error: ' . $e->getMessage());
            return 'Maaf, layanan chatbot sedang mengalami gangguan. Silakan coba lagi nanti atau hubungi admin.';
        }
    }
}

