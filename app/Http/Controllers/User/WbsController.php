<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KategoriUmum;
use App\Models\WbsReport;
use App\Models\WilayahUmum;
use App\Services\TextCensorService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WbsController extends Controller
{
    /**
     * Tampilkan daftar laporan WBS.
     */
    public function index()
    {
        $user = auth()->user();
        $wbsReports = collect();

        if ($user) {
            if ($user->role === 'admin') {
                // ambil kategori yang di-handle oleh admin ini
                $kategoriIds = $user->kategori->pluck('id')->toArray();

                $wbsReports = WbsReport::with(['pelapor', 'wilayah', 'kategori'])
                    ->whereIn('kategori_id', $kategoriIds)
                    ->latest()
                    ->get();

            } elseif ($user->role === 'superadmin') {
                // superadmin bisa lihat semua
                $wbsReports = WbsReport::with(['pelapor', 'wilayah', 'kategori'])
                    ->latest()
                    ->get();

            } else {
                // user biasa hanya bisa lihat laporan yang dia buat
                $wbsReports = WbsReport::with(['pelapor', 'wilayah', 'kategori'])
                    ->where('user_id', $user->id_user)
                    ->latest()
                    ->get();
            }
        }

        // ambil kategori & wilayah umum untuk form input
        $kategoriUmum = KategoriUmum::all();
        $wilayahUmum = WilayahUmum::all();

        return view('portal.wbs.index', compact('wbsReports', 'user', 'kategoriUmum', 'wilayahUmum'));
    }

    /**
     * Simpan laporan baru.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi form
        $validated = $request->validate([
            'is_anonim' => 'nullable|boolean',
            'nama_pengadu' => 'nullable|string|max:255',
            'email_pengadu' => 'nullable|email|max:255',
            'telepon_pengadu' => 'nullable|string|max:20',
            'nama_terlapor' => 'required|string|max:255',
            'wilayah_id' => 'required|exists:wilayah_umum,id',
            'kategori_id' => 'required|exists:kategori_umum,id',
            'tanggal_kejadian' => 'required|date',
            'waktu_kejadian' => 'required|date_format:H:i',
            'lokasi_kejadian' => 'required|string|max:100',
            'uraian' => 'required|string',
            'lampiran' => 'nullable|array|max:3',
            'lampiran.*' => 'nullable|file|max:10240', // max 10MB/file
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $isAnonim = $request->boolean('is_anonim');

        // Jika tidak anonim → wajib isi data pengadu
        if (! $isAnonim) {
            $request->validate([
                'nama_pengadu' => 'required|string|max:255',
                'email_pengadu' => 'required|email|max:255',
                'telepon_pengadu' => 'required|string|max:20',
            ]);
        } else {
            $validated['nama_pengadu'] = null;
            $validated['email_pengadu'] = null;
            $validated['telepon_pengadu'] = null;
        }

        // Gabungkan tanggal dan waktu
        $waktuKejadian = Carbon::parse(
            $validated['tanggal_kejadian'].' '.$validated['waktu_kejadian']
        );

        // Moderasi AI (gabungkan teks yang diperiksa)
        try {
            $censor = app(TextCensorService::class);
            $user = auth()->user();

            $textToCheck =
                "=== DATA LAPORAN WBS ===\n".
                "Nama Terlapor: {$validated['nama_terlapor']}\n".
                "Lokasi Kejadian: {$validated['lokasi_kejadian']}\n".
                "Uraian: {$validated['uraian']}\n";

            $result = $censor->hasForbiddenWords($textToCheck);

            if ($result['forbidden']) {

                Log::warning(' WBS Report Blocked (AI Moderation)', [
                    'user_id' => $user->id_user ?? null,
                    'alasan' => $result['reason'] ?? 'Konten tidak diperbolehkan',
                    'potongan' => mb_substr($validated['uraian'], 0, 100),
                ]);

                return back()
                    ->withErrors([
                        'uraian' => 'Laporan ditolak oleh Sistem Moderasi AI.',
                    ])
                    ->with('ai_reason', $result['reason'])
                    ->with('ai_decision', 'Ditolak')
                    ->withInput();
            }

            // 🔍 Jika tidak diblok → tetap censor kata sensitif
            $validated['nama_terlapor'] = $censor->censor($validated['nama_terlapor']);
            $validated['lokasi_kejadian'] = $censor->censor($validated['lokasi_kejadian']);
            $validated['uraian'] = $censor->censor($validated['uraian']);

        } catch (\Throwable $e) {

            Log::error('AI moderation failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id() ?? null,
            ]);
        }

        // Handle upload lampiran (max total 30 MB)
        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            $totalSize = collect($request->file('lampiran'))->sum->getSize();
            if ($totalSize > 30 * 1024 * 1024) {
                return back()
                    ->withErrors(['lampiran' => 'Total ukuran semua lampiran tidak boleh lebih dari 30 MB.'])
                    ->withInput();
            }

            $destinationPath = public_path('lampiran');
            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('lampiran') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $lampiranPaths[] = 'lampiran/'.$filename;
            }
        }

        // Generate tracking ID unik
        do {
            $trackingId = 'WBS-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (WbsReport::where('tracking_id', $trackingId)->exists());

        // Simpan ke database
        WbsReport::create([
            'tracking_id' => $trackingId,
            'user_id' => $user->id_user ?? null,
            'is_anonim' => $isAnonim,
            'nama_pengadu' => $validated['nama_pengadu'],
            'email_pengadu' => $validated['email_pengadu'],
            'telepon_pengadu' => $validated['telepon_pengadu'],
            'nama_terlapor' => $validated['nama_terlapor'],
            'wilayah_id' => $validated['wilayah_id'],
            'kategori_id' => $validated['kategori_id'],
            'waktu_kejadian' => $waktuKejadian,
            'lokasi_kejadian' => $validated['lokasi_kejadian'],
            'uraian' => $validated['uraian'],
            'lampiran' => $lampiranPaths,
            'status' => 'Diajukan',
        ]);

        return redirect()
            ->route('user.aduan.riwayatwbs')
            ->with('success', 'Laporan WBS berhasil dikirim.');
    }

    /**
     * Pantau laporan berdasarkan tracking_id.
     */
    public function track(Request $request)
    {
        $trackingId = $request->get('tracking_id');

        $report = WbsReport::where('tracking_id', $trackingId)->first();

        if (! $report) {
            return redirect()
                ->route('wbs.index', ['tab' => 'riwayat'])
                ->with('error', 'Kode unik tidak ditemukan.');
        }

        return view('portal.wbs.track', compact('report'));
    }
}
