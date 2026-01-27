<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $notifications = $user->notifications()->paginate(5);
        $role = $user->role;

        // Tentukan layout berdasarkan peran
        $layout = match ($role) {
            'admin' => 'admin.layouts.app',
            'superadmin' => 'superadmin.layouts.app',
            'wbs_admin' => 'wbs_admin.layouts.app',
            default => 'portal.layouts.app',
        };

        return view('notifications.index', compact('notifications', 'layout'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect($notification->data['url'] ?? '#');
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai dibaca.');
    }

    public function checkNewNotifications(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['count' => 0, 'latest' => null]);
        }

        $unread = $user->unreadNotifications;
        $count = $unread->count();
        $latest = $unread->first();

        $clientLastId = $request->query('last_id');

        $notify = null;
        // Jika ada notif baru yang beda ID-nya dengan yang terakhir klien tahu
        if ($latest && $latest->id != $clientLastId) {
            $message = $latest->data['message'] ?? 'Anda memiliki notifikasi baru.';

            // Custom title based on type
            $title = 'E-Lapor DIY';
            $type = $latest->type;

            if (str_contains($type, 'ReportStatusChanged')) {
                $title = '📌 Update Status Laporan';
            } elseif (str_contains($type, 'NewComment')) {
                $title = '💬 Komentar Baru';
            } elseif (str_contains($type, 'NewFollowUp')) {
                $title = '⚡ Tindak Lanjut Baru';
            }

            $notify = [
                'id' => $latest->id,
                'title' => $title,
                'body' => $message,
                'url' => route('notifications.read', $latest->id), // Link direct ke markAsRead
            ];
        }

        return response()->json([
            'count' => $count,
            'latest' => $notify
        ]);
    }

    /**
     * Simpan Subscription Web Push
     */
    public function storePushSubscription(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required'
        ]);

        $user = auth()->user();
        if ($user) {
            $user->updatePushSubscription(
                $request->endpoint,
                $request->keys['p256dh'],
                $request->keys['auth']
            );
        }

        return response()->json(['success' => true]);
    }
}
