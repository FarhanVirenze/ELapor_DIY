<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->input('role');
        $search = $request->input('search');

        $users = User::when($role, function ($query) use ($role) {
            return $query->where('role', $role);
        })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('nomor_telepon', 'like', "%{$search}%");
                });
            })
            ->whereIn('role', ['user', 'admin', 'superadmin']) // sekarang tampilkan juga superadmin
            ->paginate(8)
            ->appends([
                'role' => $role,
                'search' => $search,
            ]);

        return view('superadmin.kelola-user.index', compact('users', 'role', 'search'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldData = $user->only(['name', 'email', 'role']);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'nik' => 'required',
            'nomor_telepon' => 'required',
            'role' => 'required|in:user,admin,superadmin', // hanya boleh ubah role ke user/admin
        ]);

        $user->update($request->only(['name', 'email', 'nik', 'nomor_telepon', 'role']));
        $newData = $user->only(['name', 'email', 'role']);

        // === LOG AKTIVITAS ===
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'UPDATE_USER',
            'model' => 'User',
            'model_id' => $user->id_user,
            'description' => "Superadmin mengubah data user: {$user->email}. Perubahan: " . json_encode(['from' => $oldData, 'to' => $newData]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('superadmin.kelola-user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userEmail = $user->email;

        $user->delete();

        // === LOG AKTIVITAS ===
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'DELETE_USER',
            'model' => 'User',
            'model_id' => $id,
            'description' => "Superadmin menghapus user: {$userEmail}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('superadmin.kelola-user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
