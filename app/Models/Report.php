<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_id',   // <--- Tambahkan ini
        'user_id',
        'admin_id',
        'updated_by',
        'likes',
        'dislikes',
        'is_anonim',
        'is_revisi',
        'is_arsip',
        'nama_pengadu',
        'email_pengadu',
        'telepon_pengadu',
        'nik',
        'judul',
        'isi',
        'kategori_id',
        'wilayah_id',
        'file',
        'lokasi',        // alamat
        'latitude',      // lintang
        'longitude',     // bujur
        'status',
        'is_wbs_admin',
        'priority',
        'sentiment',
        'ai_analysis',
        'suggested_kategori_id',
        'komentar_revisi',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'is_revisi' => 'boolean',
        'is_arsip' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'file' => 'array',
    ];

    public const STATUS_DIAJUKAN = 'Diajukan';
    public const STATUS_DIBACA = 'Dibaca';
    public const STATUS_DIRESPON = 'Direspon';
    public const STATUS_SELESAI = 'Selesai';
    public const STATUS_REVISI = 'Revisi';
    public const STATUS_ARSIP = 'Arsip';

    public static function getStatuses()
    {
        return [
            self::STATUS_DIAJUKAN,
            self::STATUS_DIBACA,
            self::STATUS_DIRESPON,
            self::STATUS_SELESAI,
            self::STATUS_REVISI,
            self::STATUS_ARSIP,
        ];
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriUmum::class, 'kategori_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(WilayahUmum::class, 'wilayah_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'report_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'report_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id_user');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id_user');
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function likedBy($userId)
    {
        return $this->votes()->where('user_id', $userId)->where('vote_type', 'like')->exists();
    }

    public function dislikedBy($userId)
    {
        return $this->votes()->where('user_id', $userId)->where('vote_type', 'dislike')->exists();
    }

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // === ACCESSORS FOR STANDARDIZED LOGIC ===

    /**
     * Get Urgency (Priority) with Smart Fallback
     */
    public function getEffectivePriorityAttribute()
    {
        $priority = $this->priority ?: 'Low';
        $text = strtolower($this->judul . ' ' . $this->isi);

        // Keywords that trigger HIGH priority
        $highKeywords = ['kebakaran', 'darurat', 'kecelakaan', 'bencana', 'gempa', 'banjir', 'nyawa', 'kritis'];
        foreach ($highKeywords as $kW) {
            if (str_contains($text, $kW)) {
                return 'Emergency';
            }
        }

        return $priority;
    }

    /**
     * Get Sentiment with Smart Fallback
     */
    public function getEffectiveSentimentAttribute()
    {
        $sentiment = $this->sentiment ?: 'Neutral';
        $text = strtolower($this->judul . ' ' . $this->isi);

        // Keywords that trigger NEGATIVE sentiment
        $negKeywords = ['kebakaran', 'rusak', 'sampah', 'bau', 'macet', 'pencurian', 'begal', 'narkoba', 'korupsi', 'pungli'];
        foreach ($negKeywords as $kW) {
            if (str_contains($text, $kW)) {
                return 'Negative';
            }
        }

        return $sentiment;
    }

    /**
     * Get SLA Status
     */
    public function getSlaStatusAttribute()
    {
        if (in_array($this->status, [self::STATUS_DIRESPON, self::STATUS_SELESAI, self::STATUS_ARSIP])) {
            return 'Normal';
        }

        $daysLimit = 3;
        $diffInDays = $this->created_at->diffInDays(now());

        if ($diffInDays >= $daysLimit) {
            return 'Terlambat';
        } elseif ($diffInDays >= ($daysLimit - 1)) {
            return 'Warning';
        }

        return 'Normal';
    }

    /**
     * Get SLA Deadline
     */
    public function getSlaDeadlineAttribute()
    {
        return $this->created_at->copy()->addDays(3);
    }

    // (Opsional) Generate tracking_id otomatis jika belum diset
    protected static function booted()
    {
        static::creating(function ($report) {
            if (empty($report->tracking_id)) {
                do {
                    $tanggal = now()->format('dmy'); // 6 digit, misalnya 270725
                    $acak = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT); // 4 digit
                    $report->tracking_id = $tanggal . $acak; // Total 10 digit
                } while (self::where('tracking_id', $report->tracking_id)->exists());
            }

            // Jika  true → set status Arsip
            if (!isset($report->status)) {
                $report->status = $report->is_arsip ? self::STATUS_ARSIP : self::STATUS_DIAJUKAN;
            }
        });
    }
}
