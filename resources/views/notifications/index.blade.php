@extends($layout)

@section('content')
    <div class="container mx-auto px-4 pt-24 pb-12">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-800">
                    Notifikasi
                    @if (auth()->user()->unreadNotifications->count() > 0)
                        <span class="ml-2 bg-red-600 text-white text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->unreadNotifications->count() }} Baru
                        </span>
                    @endif
                </h2>

                @if (auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.readAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 hover:underline transition">
                            Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($notifications as $notification)
                    <div
                        class="p-5 hover:bg-gray-50 transition flex items-start gap-4 {{ $notification->read_at ? 'opacity-70' : 'bg-red-50/30' }}">
                        <!-- Icon based on type -->
                        <div class="flex-shrink-0 mt-1">
                            @if ($notification->type === 'App\Notifications\NewReportSubmitted')
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shadow-sm transition-transform hover:scale-110">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            @elseif ($notification->type === 'App\Notifications\ReportStatusChanged')
                                <div
                                    class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 shadow-sm transition-transform hover:scale-110">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                            @elseif ($notification->type === 'App\Notifications\ReportCreateFailed')
                                <div
                                    class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 shadow-sm transition-transform hover:scale-110">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            @elseif ($notification->type === 'App\Notifications\NewCommentNotification')
                                <div
                                    class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 shadow-sm transition-transform hover:scale-110">
                                    <i class="fas fa-comment-dots"></i>
                                </div>
                            @elseif ($notification->type === 'App\Notifications\NewFollowUpNotification')
                                <div
                                    class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 shadow-sm transition-transform hover:scale-110">
                                    <i class="fas fa-reply-all"></i>
                                </div>
                            @elseif ($notification->type === 'App\Notifications\ProfileUpdatedNotification')
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm transition-transform hover:scale-110">
                                    <i class="fas fa-user-edit"></i>
                                </div>
                            @else
                                <div
                                    class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 shadow-sm">
                                    <i class="fas fa-bell"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <a href="{{ route('notifications.read', $notification->id) }}" class="focus:outline-none">
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <p class="text-xs text-gray-400 mt-2">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </a>
                        </div>

                        @if (!$notification->read_at)
                            <div class="flex-shrink-0">
                                <span class="inline-block w-3 h-3 bg-red-600 rounded-full"></span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-10 text-center text-gray-500">
                        <i class="fas fa-bell-slash text-4xl mb-4 text-gray-300"></i>
                        <p>Belum ada notifikasi.</p>
                    </div>
                @endforelse
            </div>

            @if ($notifications->hasPages())
                <div
                    class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-bold text-gray-800">{{ $notifications->firstItem() }}</span>
                        sampai <span class="font-bold text-gray-800">{{ $notifications->lastItem() }}</span>
                        dari <span class="font-bold text-gray-800">{{ $notifications->total() }}</span> notifikasi.
                    </p>
                    <div class="pagination-wrapper">
                        {{ $notifications->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
