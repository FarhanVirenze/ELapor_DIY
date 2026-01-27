@extends('superadmin.layouts.app')

@section('content')
<div class="p-6">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        {{-- Header & Filters --}}
        <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas</h1>
                <p class="text-gray-500 text-sm mt-1">Pantau semua aktivitas sistem dan tindakan admin secara real-time.</p>
            </div>
            
            <form action="{{ route('superadmin.activity-logs.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                {{-- Filter Admin --}}
                <div class="relative">
                    <select name="filter_user" onchange="this.form.submit()" 
                        class="w-full md:w-64 appearance-none border border-gray-300 rounded-xl px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition shadow-sm bg-white">
                        <option value="all" {{ request('filter_user') == 'all' ? 'selected' : '' }}>Semua Admin</option>
                        <option value="superadmin" {{ request('filter_user') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        
                        <optgroup label="Admin OPD">
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id_user }}" {{ request('filter_user') == $admin->id_user ? 'selected' : '' }}>
                                    {{ $admin->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                {{-- Search --}}
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari aktivitas..." 
                        class="w-full md:w-64 border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>

                <button type="submit" class="hidden md:block bg-gradient-to-r from-red-600 to-red-700 text-white px-5 py-2 rounded-xl hover:from-red-700 hover:to-red-800 transition shadow-md font-medium text-sm">
                    Filter
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center w-12">No</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                    <tr class="hover:bg-red-50/30 transition duration-200">
                        <td class="p-4 text-sm text-gray-600 text-center font-medium align-top">
                            {{ $logs->firstItem() + $loop->index }}
                        </td>
                        <td class="p-4 text-sm text-gray-600 whitespace-nowrap align-top">
                            <div class="font-medium text-gray-800">
                                {{ $log->created_at->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
                            </div>
                            <div class="text-xs text-gray-400 mt-0.5">
                                {{ $log->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}
                            </div>
                        </td>
                        <td class="p-4 align-top">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 shadow-sm border border-gray-100">
                                    @if($log->user && $log->user->foto)
                                        <img src="{{ asset($log->user->foto) }}" class="w-full h-full object-cover" alt="{{ $log->user->name }}">
                                    @elseif($log->user && $log->user->avatar)
                                        <img src="{{ $log->user->avatar }}" class="w-full h-full object-cover" alt="{{ $log->user->name }}">
                                    @else
                                        <div class="w-full h-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-xs uppercase">
                                            {{ substr($log->user->name ?? '?', 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-gray-800">{{ $log->user->name ?? 'Guest' }}</span>
                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md w-fit mt-1">
                                        {{ ucfirst($log->user->role ?? '-') }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 align-top">
                            @php
                                $badgeConfig = match($log->action) {
                                    'CREATE', 'STORE_USER' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-plus'],
                                    'UPDATE', 'UPDATE_STATUS', 'UPDATE_USER' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-edit'],
                                    'DELETE', 'DELETE_USER' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-trash'],
                                    'DISPOSISI' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'icon' => 'fa-share'],
                                    default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-circle']
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-bold uppercase {{ $badgeConfig['bg'] }} {{ $badgeConfig['text'] }}">
                                <i class="fas {{ $badgeConfig['icon'] }} text-[10px]"></i>
                                {{ str_replace('_', ' ', $log->action) }}
                            </span>
                        </td>
                        <td class="p-4 text-sm text-gray-600 min-w-[350px] align-top leading-relaxed">
                            {{ $log->description }}
                        </td>
                        <td class="p-4 text-xs text-gray-400 font-mono align-top">
                            {{ $log->ip_address }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                                    <i class="fas fa-history text-2xl"></i>
                                </div>
                                <p class="font-medium text-lg">Belum ada aktivitas tercatat.</p>
                                <p class="text-sm mt-1 opacity-70">Aktivitas sistem akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50/50">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
