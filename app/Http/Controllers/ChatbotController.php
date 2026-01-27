<?php

namespace App\Http\Controllers;

use App\Models\KategoriUmum;
use App\Models\Report;
use App\Services\TextCensorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    protected TextCensorService $censorService;

    public function __construct(TextCensorService $censorService)
    {
        $this->censorService = $censorService;
    }

    /**
     * Handle chatbot message
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = strtolower(trim($request->message));
        $userId = Auth::check() ? Auth::user()->id_user : null;

        // 1. Quick actions - keyword matching
        $quickResponse = $this->handleQuickActions($message, $userId);
        if ($quickResponse) {
            return response()->json($quickResponse);
        }

        // 2. AI-powered response
        try {
            $stats = [];
            try {
                // Aggregate Data for Context (Wrapped in try-catch to prevent crash if DB fails)
                // Aggregate Data for Context (Mirip Dashboard Superadmin)
                $stats = [
                    'total_reports' => Report::count(),
                    'reports_today' => Report::whereDate('created_at', now())->count(),
                    'status_counts' => Report::selectRaw('status, count(*) as total')
                        ->groupBy('status')
                        ->pluck('total', 'status')
                        ->toArray(),
                    'priority_counts' => Report::selectRaw('priority, count(*) as total')
                        ->whereNotNull('priority')
                        ->where('priority', '!=', '')
                        ->groupBy('priority')
                        ->pluck('total', 'priority')
                        ->toArray(),
                    'top_categories' => Report::select('kategori_id')
                        ->selectRaw('count(*) as total')
                        ->groupBy('kategori_id')
                        ->orderByDesc('total')
                        ->take(5)
                        ->with('kategori')
                        ->get()
                        ->map(fn($r) => ($r->kategori->nama ?? 'Lainnya') . " ({$r->total})")
                        ->implode(', '),
                    'top_instansi' => Report::whereNotNull('admin_id')
                        ->selectRaw('admin_id, COUNT(*) as total')
                        ->groupBy('admin_id')
                        ->orderByDesc('total')
                        ->take(5)
                        ->with('admin')
                        ->get()
                        ->map(fn($r) => ($r->admin->name ?? 'Admin') . " ({$r->total})")
                        ->implode(', '),
                    'wilayah_stats' => Report::selectRaw('wilayah_id, COUNT(*) as total')
                        ->groupBy('wilayah_id')
                        ->with('wilayah')
                        ->orderByDesc('total')
                        ->take(3)
                        ->get()
                        ->map(fn($r) => ($r->wilayah->nama ?? 'Lainnya') . " ({$r->total})")
                        ->implode(', '),
                    'completion_rate' => function () {
                        $total = Report::count();
                        $completed = Report::where('status', 'Selesai')->count();
                        return $total > 0 ? round(($completed / $total) * 100, 1) . '%' : '0%';
                    }
                ];
                // Resolve closure value
                $stats['completion_rate'] = is_callable($stats['completion_rate']) ? $stats['completion_rate']() : $stats['completion_rate'];
            } catch (\Exception $dbEx) {
                // Log DB error but continue AI chat without stats
                \Illuminate\Support\Facades\Log::error('Chatbot Stats Error: ' . $dbEx->getMessage());
            }

            $aiResponse = $this->censorService->chatbotResponse($message, $userId, $stats);

            return response()->json([
                'type' => 'ai',
                'message' => $aiResponse,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Chatbot Controller Error: ' . $e->getMessage());
            return response()->json([
                'type' => 'error',
                'message' => 'Maaf, saya mengalami kendala teknis. Silakan coba lagi nanti.',
            ], 500);
        }
    }

    /**
     * Handle quick keyword-based actions
     */
    private function handleQuickActions(string $message, ?int $userId): ?array
    {
        // Tracking laporan
        if (preg_match('/(?:cek|track|lacak|status).*?(\d{10})/', $message, $matches)) {
            return $this->trackReport($matches[1]);
        }

        // Kategori info
        if (str_contains($message, 'kategori') || str_contains($message, 'jenis aduan')) {
            return $this->getCategories();
        }

        // Cara melapor
        if (str_contains($message, 'cara melapor') || str_contains($message, 'cara lapor') || str_contains($message, 'bagaimana melapor')) {
            return $this->howToReport();
        }

        // Laporan saya
        if ((str_contains($message, 'laporan saya') || str_contains($message, 'aduan saya')) && $userId) {
            return $this->myReports($userId);
        }

        // Bantuan / menu
        if (str_contains($message, 'bantuan') || str_contains($message, 'help') || str_contains($message, 'menu')) {
            return $this->getHelp();
        }

        return null;
    }

    /**
     * Track report by tracking ID
     */
    private function trackReport(string $trackingId): array
    {
        $report = Report::where('tracking_id', $trackingId)->first();

        if (!$report) {
            return [
                'type' => 'not_found',
                'message' => "Maaf, laporan dengan nomor tracking **{$trackingId}** tidak ditemukan. Pastikan nomor yang Anda masukkan benar.",
            ];
        }

        $statusEmoji = [
            'Diajukan' => '📝',
            'Dibaca' => '👁️',
            'Direspon' => '💬',
            'Selesai' => '✅',
            'Revisi' => '🔄',
            'Arsip' => '📁',
        ];

        $emoji = $statusEmoji[$report->status] ?? '📋';

        return [
            'type' => 'tracking',
            'message' => "**Laporan #{$trackingId}**\n\n" .
                "📌 **Judul:** {$report->judul}\n" .
                "{$emoji} **Status:** {$report->status}\n" .
                "📅 **Tanggal:** " . $report->created_at->format('d M Y') . "\n\n" .
                "🔗 [Lihat Detail Laporan](/daftar-aduan/{$report->id}/detail)",
            'data' => [
                'id' => $report->id,
                'tracking_id' => $report->tracking_id,
                'judul' => $report->judul,
                'status' => $report->status,
            ],
        ];
    }

    /**
     * Get all categories
     */
    private function getCategories(): array
    {
        $categories = KategoriUmum::where('tipe', 'non_wbs_admin')->get();

        $list = $categories->map(fn($cat) => "• {$cat->nama}")->join("\n");

        return [
            'type' => 'categories',
            'message' => "**Kategori Aduan yang Tersedia:**\n\n{$list}\n\n💡 Pilih kategori yang paling sesuai dengan masalah yang ingin Anda laporkan.",
        ];
    }

    /**
     * How to report guide
     */
    private function howToReport(): array
    {
        return [
            'type' => 'guide',
            'message' => "**Cara Membuat Aduan di E-Lapor:**\n\n" .
                "1️⃣ **Login** ke akun E-Lapor Anda\n" .
                "2️⃣ Klik tombol **\"Buat Aduan Cepat\"** di halaman utama\n" .
                "3️⃣ Isi **Judul** aduan (minimal 10 kata)\n" .
                "4️⃣ Jelaskan **Kronologi** dengan lengkap (minimal 20 kata)\n" .
                "5️⃣ Pilih **Kategori** dan **Wilayah**\n" .
                "6️⃣ Lampirkan **Foto/Dokumen** pendukung (opsional)\n" .
                "7️⃣ Klik **Kirim Aduan**\n\n" .
                "✅ Anda akan mendapat **Tracking ID** untuk memantau status laporan.",
        ];
    }

    /**
     * Get user's reports summary
     */
    private function myReports(int $userId): array
    {
        $reports = Report::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        if ($reports->isEmpty()) {
            return [
                'type' => 'my_reports',
                'message' => "Anda belum memiliki laporan. Silakan buat aduan baru melalui menu **Buat Aduan Cepat**.",
            ];
        }

        $list = $reports->map(fn($r) => "• **{$r->tracking_id}** - {$r->judul} ({$r->status})")->join("\n");

        return [
            'type' => 'my_reports',
            'message' => "**5 Laporan Terakhir Anda:**\n\n{$list}\n\n📋 [Lihat Semua Riwayat](/user/riwayat-aduan)",
        ];
    }

    /**
     * Get help menu
     */
    private function getHelp(): array
    {
        return [
            'type' => 'help',
            'message' => "**🤖 Halo! Saya Asisten Virtual E-Lapor**\n\n" .
                "Saya bisa membantu Anda dengan:\n\n" .
                "📍 **Cek Status Laporan**\n_Ketik: \"cek status 1234567890\"_\n\n" .
                "📝 **Cara Melapor**\n_Ketik: \"cara melapor\"_\n\n" .
                "📂 **Daftar Kategori**\n_Ketik: \"kategori aduan\"_\n\n" .
                "📋 **Laporan Saya**\n_Ketik: \"laporan saya\"_\n\n" .
                "💬 **Tanya Jawab Lainnya**\n_Langsung ketik pertanyaan Anda!_\n\n" .
                "---\n" .
                "Atau klik tombol di bawah untuk aksi cepat! 👇",
            'quick_actions' => [
                ['label' => '📝 Cara Melapor', 'action' => 'cara melapor'],
                ['label' => '📂 Kategori', 'action' => 'kategori aduan'],
                ['label' => '🔍 Cek Laporan', 'action' => 'cek status'],
            ],
        ];
    }
}
