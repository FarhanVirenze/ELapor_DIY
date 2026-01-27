@auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const vapidPublicKey = '{{ config('webpush.vapid.public_key') }}';

            function urlBase64ToUint8Array(base64String) {
                const padding = '='.repeat((4 - base64String.length % 4) % 4);
                const base64 = (base64String + padding)
                    .replace(/\-/g, '+')
                    .replace(/_/g, '/');
                const rawData = window.atob(base64);
                const outputArray = new Uint8Array(rawData.length);
                for (let i = 0; i < rawData.length; ++i) {
                    outputArray[i] = rawData.charCodeAt(i);
                }
                return outputArray;
            }

            // Register Service Worker
            if ('serviceWorker' in navigator && 'PushManager' in window) {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(function(registration) {
                        console.log('Service Worker registered with scope:', registration.scope);
                        
                        // Subscribe User
                        registration.pushManager.getSubscription().then(function(subscription) {
                            if (subscription) {
                                return subscription;
                            }
                            
                            const convertedVapidKey = urlBase64ToUint8Array(vapidPublicKey);
                            return registration.pushManager.subscribe({
                                userVisibleOnly: true,
                                applicationServerKey: convertedVapidKey
                            });
                        }).then(function(subscription) {
                            console.log('User is subscribed:', subscription);

                            // Send subscription to server
                            fetch('{{ route('notifications.subscribe') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(subscription)
                            });
                        }).catch(function(err) {
                            console.log('Failed to subscribe the user: ', err);
                        });
                    });
            }

            // Fallback Polling (tetap aktif untuk update real-time saat tab terbuka)
            if (!("Notification" in window)) {
                console.log("Browser tidak mendukung notifikasi desktop.");
                return;
            }

            // Meminta izin jika belum diberikan
            if (Notification.permission !== "granted" && Notification.permission !== "denied") {
                Notification.requestPermission();
            }

            // Fungsi Polling Notifikasi
            function checkNotifications() {
                // Ambil ID notifikasi terakhir dari storage
                const lastId = localStorage.getItem('last_notification_id') || 0;

                fetch(`{{ route('notifications.check') }}?last_id=${lastId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update badge jumlah di UI header (opsional, jika ada element ID ini)
                        const badge = document.getElementById('notification-badge');
                        if (badge) {
                            if (data.count > 0) {
                                badge.classList.remove('hidden');
                                badge.innerText = data.count > 99 ? '99+' : data.count;
                            } else {
                                badge.classList.add('hidden');
                            }
                        }

                        // Jika ada notifikasi baru & permission granted
                        if (data.latest && data.latest.id != lastId) {
                            // Simpan ID terakhir agar tidak notif ulang
                            localStorage.setItem('last_notification_id', data.latest.id);

                            if (Notification.permission === "granted") {
                                const notification = new Notification(data.latest.title, {
                                    body: data.latest.body,
                                    icon: "{{ asset('images/logo-diy.png') }}", 
                                    tag: data.latest.id 
                                });

                                notification.onclick = function() {
                                    window.focus();
                                    window.location.href = data.latest.url;
                                };
                                
                                // Play sound effect (optional)
                                const audio = new Audio('{{ asset("sounds/notification.mp3") }}'); 
                                // Note: Audio might be blocked by browser policy without user interaction first
                            }
                        }
                    })
                    .catch(error => console.error('Gagal memuat notifikasi:', error));
            }

            // Jalankan polling setiap 10 detik
            setInterval(checkNotifications, 10000);
            
            // Jalankan sekali saat load
            checkNotifications();
        });
    </script>
@endauth
