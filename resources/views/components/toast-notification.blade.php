{{-- Toast Notification Container --}}
<div id="toast-container" class="fixed top-24 right-5 z-[9999] space-y-3 pointer-events-none"></div>

{{-- Toast Template --}}
<template id="toast-template">
    <div class="toast-notification pointer-events-auto transform translate-x-full opacity-0 transition-all duration-500 ease-out
                max-w-sm w-full bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-start p-4">
            {{-- Icon --}}
            <div class="flex-shrink-0">
                <div class="toast-icon w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="toast-icon-class text-lg"></i>
                </div>
            </div>
            
            {{-- Content --}}
            <div class="ml-3 flex-1 min-w-0">
                <p class="toast-title text-sm font-semibold text-gray-900"></p>
                <p class="toast-message mt-1 text-sm text-gray-600 line-clamp-2"></p>
                <a href="#" class="toast-link mt-2 inline-flex items-center text-sm font-medium text-red-600 hover:text-red-700">
                    Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
            
            {{-- Close Button --}}
            <button class="toast-close ml-2 flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        {{-- Progress Bar --}}
        <div class="h-1 bg-gray-100">
            <div class="toast-progress h-full bg-red-500 origin-left" style="animation: toast-progress 5s linear forwards;"></div>
        </div>
    </div>
</template>

<style>
    @keyframes toast-progress {
        from { transform: scaleX(1); }
        to { transform: scaleX(0); }
    }
    
    .toast-notification.toast-show {
        transform: translateX(0);
        opacity: 1;
    }
    
    .toast-notification.toast-hide {
        transform: translateX(100%);
        opacity: 0;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // Toast Notification System
    window.ELaporToast = {
        show: function(options) {
            const container = document.getElementById('toast-container');
            const template = document.getElementById('toast-template');
            
            if (!container || !template) return;
            
            const clone = template.content.cloneNode(true);
            const toast = clone.querySelector('.toast-notification');
            
            // Set content
            toast.querySelector('.toast-title').textContent = options.title || 'Notifikasi';
            toast.querySelector('.toast-message').textContent = options.message || '';
            
            // Set icon based on type
            const iconWrapper = toast.querySelector('.toast-icon');
            const iconEl = toast.querySelector('.toast-icon-class');
            
            const types = {
                success: { bg: 'bg-green-100', icon: 'fas fa-check text-green-600' },
                info: { bg: 'bg-blue-100', icon: 'fas fa-info text-blue-600' },
                warning: { bg: 'bg-yellow-100', icon: 'fas fa-exclamation text-yellow-600' },
                error: { bg: 'bg-red-100', icon: 'fas fa-times text-red-600' },
                update: { bg: 'bg-purple-100', icon: 'fas fa-sync text-purple-600' },
                followup: { bg: 'bg-indigo-100', icon: 'fas fa-reply text-indigo-600' }
            };
            
            const type = types[options.type] || types.info;
            iconWrapper.classList.add(type.bg);
            iconEl.className = 'toast-icon-class ' + type.icon;
            
            // Set link
            if (options.url) {
                toast.querySelector('.toast-link').href = options.url;
            } else {
                toast.querySelector('.toast-link').style.display = 'none';
            }
            
            // Close handler
            toast.querySelector('.toast-close').addEventListener('click', () => {
                this.hide(toast);
            });
            
            // Add to container
            container.appendChild(toast);
            
            // Trigger animation
            requestAnimationFrame(() => {
                toast.classList.add('toast-show');
            });
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                this.hide(toast);
            }, 5000);
            
            // Play sound (optional)
            if (options.sound !== false) {
                this.playSound();
            }
        },
        
        hide: function(toast) {
            toast.classList.remove('toast-show');
            toast.classList.add('toast-hide');
            setTimeout(() => toast.remove(), 500);
        },
        
        playSound: function() {
            // Simple notification sound using Web Audio API
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.value = 800;
                oscillator.type = 'sine';
                gainNode.gain.value = 0.1;
                
                oscillator.start();
                oscillator.stop(audioContext.currentTime + 0.1);
            } catch (e) {
                // Audio not supported
            }
        }
    };
    
    // Example usage:
    // window.ELaporToast.show({
    //     type: 'success',
    //     title: 'Laporan Diupdate',
    //     message: 'Status laporan Anda telah berubah menjadi Direspon',
    //     url: '/daftar-aduan/123/detail'
    // });
</script>
