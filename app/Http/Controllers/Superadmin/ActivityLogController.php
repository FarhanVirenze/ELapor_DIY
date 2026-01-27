<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by Admin/User
        if ($request->filled('filter_user') && $request->filter_user !== 'all') {
            if ($request->filter_user === 'superadmin') {
                $query->whereHas('user', function ($q) {
                    $q->where('role', 'superadmin');
                });
            } else {
                $query->where('user_id', $request->filter_user);
            }
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%");
                    });
            });
        }

        $logs = $query->latest()->paginate(8)->appends($request->query());

        // Get list of Admins for filter
        $admins = \App\Models\User::where('role', '=', 'admin')->get();

        return view('superadmin.activity-logs.index', compact('logs', 'admins'));
    }
}
