@extends('superadmin.layouts.app')

@section('page_title', 'Superadmin Dashboard')

@section('content')
    <div class="container py-4">
        {{-- Flash Message --}}
        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div id="alert-success"
                class="fixed top-5 right-5 z-50 flex items-center justify-between gap-4 
                                               w-[420px] max-w-[90vw] px-6 py-4 rounded-2xl shadow-2xl border border-red-400 
                                               bg-gradient-to-r from-red-600 to-red-500/90 backdrop-blur-md text-white 
                                               transition-all duration-500 opacity-100 animate-fade-in">

                <!-- Ikon -->
                <div id="success-icon-wrapper" class="flex-shrink-0">
                    <!-- Spinner -->
                    <svg id="success-spinner" class="w-6 h-6 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <!-- Check -->
                    <svg id="success-check" class="w-6 h-6 text-white hidden scale-75" fill="none" viewBox="0 0 24 24">
                        <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- Pesan -->
                <span class="flex-1 font-medium tracking-wide">{{ session('success') }}</span>

                <!-- Tombol Close -->
                <button onclick="document.getElementById('alert-success').remove()"
                    class="text-white/70 hover:text-white font-bold transition-colors">
                    ✕
                </button>

                <!-- Progress Bar -->
                <div
                    class="absolute bottom-0 left-0 h-[3px] bg-white/70 w-full origin-left scale-x-0 animate-progress rounded-b-xl">
                </div>
            </div>

            <style>
                @keyframes fade-in {
                    from {
                        opacity: 0;
                        transform: translateY(-12px) scale(0.98);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0) scale(1);
                    }
                }

                @keyframes progress {
                    from {
                        transform: scaleX(0);
                    }

                    to {
                        transform: scaleX(1);
                    }
                }

                @keyframes pop {
                    from {
                        transform: scale(0.6);
                        opacity: 0;
                    }

                    to {
                        transform: scale(1);
                        opacity: 1;
                    }
                }

                .animate-fade-in {
                    animation: fade-in 0.4s ease-out;
                }

                .animate-progress {
                    animation: progress 3s linear forwards;
                }

                .animate-pop {
                    animation: pop 0.3s ease-out;
                }
            </style>

            <script>
                // Ganti spinner jadi centang dengan animasi pop
                setTimeout(() => {
                    document.getElementById('success-spinner').classList.add('hidden');
                    const check = document.getElementById('success-check');
                    check.classList.remove('hidden');
                    check.classList.add('animate-pop');
                }, 800);

                // Auto hide notif setelah 3.5 detik
                setTimeout(() => {
                    const alert = document.getElementById('alert-success');
                    if (alert) {
                        alert.classList.add('opacity-0', 'translate-y-2');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3500);
            </script>
        @endif

        <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">Dashboard Superadmin</h2>

        {{-- 🤖 AI EXECUTIVE INSIGHT & URGENSI ANALYTICS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- AI Analysis --}}
            <div
                class="bg-gradient-to-br from-red-700 to-rose-800 rounded-3xl p-5 shadow-2xl relative overflow-hidden text-white flex flex-col h-full min-h-[250px]">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <i class="fas fa-robot text-8xl"></i>
                </div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl border border-white/30 shadow-sm">
                                <i class="fas fa-brain text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-[10px] font-black uppercase tracking-widest opacity-80">AI Executive Insight</h3>
                                <p class="text-base font-bold leading-tight">Trend Laporan Minggu Ini</p>
                            </div>
                        </div>
                        <button id="btnGenerateAI" onclick="generateAISummary()" 
                            class="bg-white/20 hover:bg-white/30 backdrop-blur-md text-white text-xs font-bold px-4 py-2 rounded-xl border border-white/30 transition-all flex items-center gap-2">
                            <i class="fas fa-magic"></i> Generate
                        </button>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/10 shadow-inner flex-1 flex items-center justify-center">
                        <p class="text-xs sm:text-sm leading-relaxed italic font-medium opacity-95 text-center" id="aiTrendSummary">
                            <i class="fas fa-lightbulb mr-2 text-yellow-300"></i> Klik tombol "Generate" untuk menganalisis trend laporan terbaru.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Urgency Stats Chart --}}
            <div class="bg-white rounded-3xl p-5 shadow-xl border border-gray-100 flex flex-col h-full min-h-[250px] justify-center relative overflow-hidden">
                 <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
                    <i class="fas fa-chart-pie text-8xl text-red-500"></i>
                </div>
                
                <div class="flex items-center gap-3 mb-2 relative z-10">
                    <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-600 shadow-sm">
                        <i class="fas fa-chart-pie text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Urgency Analytics</h3>
                        <p class="text-base font-bold text-gray-800 leading-tight">Visualisasi Urgensi</p>
                    </div>
                </div>
                
                <div class="relative h-[160px] w-full flex-1 flex items-center justify-center">
                    <canvas id="urgencyChart"></canvas>
                </div>
            </div>
        </div>

        <script>
            const aiTopics = @json($trendingTopics);
            let aiGenerated = false;

            function generateAISummary() {
                if (aiGenerated) return;
                
                const btn = document.getElementById('btnGenerateAI');
                const summaryEl = document.getElementById('aiTrendSummary');
                
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-sync fa-spin"></i> Loading...';
                summaryEl.innerHTML = '<i class="fas fa-sync fa-spin mr-2"></i> Menganalisis trend laporan terbaru...';

                const prompt = `Ringkas trend utama dari daftar laporan ini dalam 1-2 kalimat yang sangat profesional dan informatif: ${aiTopics}`;

                fetch('https://openrouter.ai/api/v1/chat/completions', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer {{ config('services.openrouter.key') }}',
                        'Content-Type': 'application/json',
                        'HTTP-Referer': '{{ config('app.url') }}',
                        'X-Title': 'E-Lapor-DIY-Dashboard'
                    },
                    body: JSON.stringify({
                        'model': 'meta-llama/llama-3.3-70b-instruct:free',
                        'messages': [
                            { 'role': 'system', 'content': 'Kamu adalah analis data cerdas. Berikan ringkasan eksekutif sangat singkat dalam Bahasa Indonesia.' },
                            { 'role': 'user', 'content': prompt }
                        ]
                    })
                })
                .then(res => res.json())
                .then(data => {
                    const summary = data.choices[0].message.content;
                    summaryEl.innerText = summary;
                    btn.innerHTML = '<i class="fas fa-check"></i> Done';
                    btn.classList.remove('hover:bg-white/30');
                    btn.classList.add('bg-green-500/30', 'cursor-not-allowed');
                    aiGenerated = true;
                })
                .catch(err => {
                    summaryEl.innerText = "Gagal memuat analisis trend. Silakan coba lagi.";
                    btn.innerHTML = '<i class="fas fa-magic"></i> Retry';
                    btn.disabled = false;
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Urgency Chart
                const urgencyCtx = document.getElementById('urgencyChart').getContext('2d');
                new Chart(urgencyCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Emergency', 'High', 'Medium', 'Low'],
                        datasets: [{
                            data: [
                                {{ $priorityStats['Emergency'] ?? 0 }},
                                {{ $priorityStats['High'] ?? 0 }},
                                {{ $priorityStats['Medium'] ?? 0 }},
                                {{ $priorityStats['Low'] ?? 0 }}
                            ],
                            backgroundColor: [
                                '#b91c1c', // Emergency - Red 700
                                '#ef4444', // High - Red 500
                                '#f97316', // Medium - Orange 500
                                '#22c55e'  // Low - Green 500
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: { size: 10, family: 'Inter', weight: '600' },
                                    boxWidth: 8,
                                    padding: 15,
                                    color: '#4b5563'
                                }
                            },
                             tooltip: {
                                backgroundColor: '#fff',
                                titleColor: '#111',
                                bodyColor: '#333',
                                borderColor: '#e5e7eb',
                                borderWidth: 1,
                                padding: 10,
                                cornerRadius: 8,
                                displayColors: true,
                                boxPadding: 4
                            }
                        },
                        layout: {
                            padding: {
                                right: 10,
                                left: 10
                            }
                        }
                    }
                });
            });
        </script>

        {{-- Kartu Statistik --}}
        @php
            $cards = [
                ['title' => 'Total Pengguna', 'count' => $totalUsers, 'icon' => 'bi-people-fill', 'bg' => 'bg-primary'],
                ['title' => 'Total User', 'count' => $userCount, 'icon' => 'bi-person-circle', 'bg' => 'bg-info'],
                [
                    'title' => 'Total Admin',
                    'count' => $adminCount,
                    'icon' => 'bi-shield-lock-fill',
                    'bg' => 'bg-danger',
                ],
                [
                    'title' => 'Total Aduan',
                    'count' => $totalReports,
                    'icon' => 'bi-file-earmark-text-fill',
                    'bg' => 'bg-success',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($cards as $card)
                <div
                    class="p-4 text-white text-center rounded-2xl shadow-lg transition-transform duration-300 hover:scale-105 {{ $card['bg'] ?? 'bg-gradient-to-br from-[#2962FF] to-[#0039CB]' }}">
                    <i class="bi {{ $card['icon'] }} text-3xl mb-2"></i>
                    <h6 class="text-sm font-medium opacity-90">{{ $card['title'] }}</h6>
                    <h3 class="text-3xl font-bold">{{ $card['count'] }}</h3>
                </div>
            @endforeach
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 mt-6">

            {{-- Distribusi Role & Jenis Pelapor --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Distribusi Role & Jenis Aduan</h5>
                <div class="relative h-[325px]">
                    <canvas id="gabunganUserPelaporChart"></canvas>
                </div>
            </div>

            {{-- Status Aduan --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Distribusi Status Aduan</h5>
                <div class="relative h-[325px]">
                    <canvas id="reportStatusChart"></canvas>
                </div>
            </div>

            {{-- Wilayah --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Distribusi Wilayah</h5>
                <div class="relative h-[325px]">
                    <canvas id="wilayahChart"></canvas>
                </div>
            </div>

            {{-- Statistik Kategori Aduan --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <h5 id="kategoriUmumTitle" class="text-[#37474F] font-semibold">Top 10 Kategori Aduan</h5>
                    <select id="kategoriUmumFilter"
                        class="border-gray-300 rounded-md text-sm text-[#37474F] shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="top10">Top 10</option>
                        <option value="all">Semua</option>
                    </select>
                </div>
                <div class="relative h-[355px]">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>

            {{-- Grafik Aktivitas --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                    <h5 id="judulAktivitas" class="text-[#37474F] font-semibold">
                        Grafik Aktivitas Aduan
                    </h5>
                    <div class="w-full sm:w-auto">
                        <select id="rangeSelector"
                            class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="today">Hari Ini</option>
                            <option value="7">1 Minggu</option>
                            <option value="30">1 Bulan</option>
                            <option value="60">2 Bulan</option>
                            <option value="90">3 Bulan</option>
                            <option value="180">6 Bulan</option>
                            <option value="365">1 Tahun</option>
                            <option value="730">2 Tahun</option>
                            <option value="all" selected>Semua Waktu</option>
                        </select>
                    </div>
                </div>
                <div class="relative h-[350px] w-full">
                    <canvas id="aktivitasChart" class="w-full h-full"></canvas>
                </div>
            </div>

            {{-- Top Admin Penerima --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                    <h5 class="text-[#37474F] font-semibold text-base" id="judulTopAdmin">Top 10 Admin Penerima Aduan</h5>
                    <form class="w-full sm:w-auto">
                        <select id="topAdminFilter"
                            class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="top10" selected>Top 10</option>
                            <option value="semua">Semua</option>
                        </select>
                    </form>
                </div>
                <div class="relative h-[350px]">
                    <canvas id="topAdminChart"></canvas>
                </div>
            </div>

            {{-- Kategori per Admin --}}
            <div class="bg-white rounded-xl p-5 shadow-md sm:col-span-2 xl:col-span-3">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                    <h5 id="kategoriPerAdminTitle" class="text-[#37474F] font-semibold text-base">
                        Top 10 Kategori Aduan per Admin
                    </h5>
                    <form class="w-full sm:w-auto">
                        <select id="adminFilter"
                            class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="top10" selected>Top 10</option>
                            <option value="all">Semua</option>
                        </select>
                    </form>
                </div>
                <div class="relative h-[450px]">
                    <canvas id="kategoriPerAdminChart"></canvas>
                </div>
            </div>

            {{-- 🗺️ SEBARAN ADUAN (HEATMAP) --}}
            <div class="bg-white rounded-xl p-5 shadow-md sm:col-span-2 xl:col-span-3 mt-4">
                <style>
                    #heatmap {
                        height: 500px;
                        width: 100%;
                        border-radius: 12px;
                        z-index: 1;
                    }

                    .priority-pulse {
                        width: 12px;
                        height: 12px;
                        border-radius: 50%;
                        display: inline-block;
                        margin-right: 5px;
                    }
                </style>
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-[#37474F] font-semibold text-lg flex items-center gap-2">
                        <i class="fas fa-map-marked-alt text-red-600"></i>
                        Peta Panas (Heatmap) Sebaran Aduan
                    </h5>
                    <div class="flex gap-4 text-xs font-bold text-gray-600">
                        <span class="flex items-center gap-1"><span
                                class="w-3 h-3 rounded-full bg-red-700 animate-pulse border border-white shadow-sm"></span>
                            Emergency</span>
                        <span class="flex items-center gap-1"><span
                                class="w-3 h-3 rounded-full bg-red-500 border border-white shadow-sm"></span> High</span>
                        <span class="flex items-center gap-1"><span
                                class="w-3 h-3 rounded-full bg-orange-500 border border-white shadow-sm"></span>
                            Medium</span>
                        <span class="flex items-center gap-1"><span
                                class="w-3 h-3 rounded-full bg-green-500 border border-white shadow-sm"></span> Low</span>
                    </div>
                </div>
                <div id="heatmap" class="border border-gray-200"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://leaflet.github.io/Leaflet.heat/dist/leaflet-heat.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const materialPalette = ['#1E88E5', '#D32F2F', '#43A047', '#FB8C00', '#8E24AA', '#FDD835', '#00ACC1',
                '#6D4C41', '#C2185B', '#7CB342'
            ];

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: 20
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#37474F',
                            font: {
                                family: 'Inter, sans-serif',
                                size: 14,
                                weight: '500'
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#212121',
                        bodyColor: '#37474F',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        usePointStyle: true
                    }
                },
                elements: {
                    bar: {
                        borderRadius: 8,
                        borderSkipped: false
                    },
                    point: {
                        radius: 5,
                        hoverRadius: 7,
                        pointStyle: 'circle'
                    }
                }
            };

            // === GABUNGAN USER/PELAPOR ===
            new Chart(document.getElementById('gabunganUserPelaporChart'), {
                type: 'bar',
                data: {
                    labels: ['User (Role)', 'Admin (Role)', 'Anonim (Pelapor)', 'Terdaftar (Pelapor)'],
                    datasets: [{
                        label: 'Jumlah Role & Jenis Aduan',
                        data: [{{ $userCount }}, {{ $adminCount }}, {{ $anonimCount }},
                            {{ $registeredCount }}
                        ],
                        backgroundColor: materialPalette.slice(0, 4)
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        ...chartOptions.plugins,
                        legend: {
                            display: true, // Menampilkan label 'Jumlah' dengan kotak warna
                            position: 'bottom',
                            labels: {
                                boxWidth: 16,
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            ...chartOptions.plugins.tooltip,
                            callbacks: {
                                label: function(ctx) {
                                    const value = ctx.raw;
                                    return `${ctx.label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#37474F',
                                stepSize: 1
                            },
                            grid: {
                                color: '#e0e0e0',
                                borderDash: [4, 4]
                            }
                        }
                    }
                }
            });

            // === KATEGORI PER ADMIN ===
            const kategoriAdminDataTop10 = @json($kategoriAdminDataTop10);
            const kategoriAdminDataAll = @json($kategoriAdminDataAll);

            const ctxKategori = document.getElementById('kategoriPerAdminChart').getContext('2d');
            const titleKategori = document.getElementById('kategoriPerAdminTitle');
            const adminFilter = document.getElementById('adminFilter');

            let kategoriChart;

            function generateKategoriChartData(data) {
                const adminLabels = data.map(item => item.admin);
                const kategoriLabels = [...new Set(data.flatMap(item => Object.keys(item.kategori)))];

                const datasets = kategoriLabels.map((kategori, i) => ({
                    type: 'bar',
                    label: kategori,
                    data: data.map(item => item.kategori[kategori] || 0),
                    backgroundColor: materialPalette[i % materialPalette.length],
                    stack: 'stack1'
                }));

                return {
                    labels: adminLabels,
                    datasets
                };
            }

            function renderKategoriChart(data) {
                const chartData = generateKategoriChartData(data);
                if (kategoriChart) kategoriChart.destroy();

                kategoriChart = new Chart(ctxKategori, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: chartData.datasets
                    },
                    options: {
                        ...chartOptions,
                        responsive: true,
                        plugins: {
                            ...chartOptions.plugins,
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    boxWidth: 16,
                                    color: '#37474F',
                                    font: {
                                        weight: '500'
                                    }
                                }
                            },
                            tooltip: {
                                ...chartOptions.plugins.tooltip,
                                callbacks: {
                                    label: function(ctx) {
                                        const label = ctx.dataset.label || '';
                                        const value = ctx.raw;
                                        return `${label}: ${value}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                                ticks: {
                                    color: '#37474F',
                                    font: {
                                        weight: '500'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                ticks: {
                                    color: '#37474F',
                                    font: {
                                        weight: '500'
                                    },
                                    stepSize: 1
                                },
                                grid: {
                                    color: '#e0e0e0',
                                    borderDash: [4, 4]
                                }
                            }
                        }
                    }
                });
            }

            adminFilter.addEventListener('change', function() {
                const selected = this.value;

                if (selected === 'all') {
                    renderKategoriChart(kategoriAdminDataAll);
                    titleKategori.innerText = 'Semua Kategori Aduan per Admin';
                } else {
                    renderKategoriChart(kategoriAdminDataTop10);
                    titleKategori.innerText = 'Top 10 Kategori Aduan per Admin';
                }
            });

            // Inisialisasi awal
            renderKategoriChart(kategoriAdminDataTop10);

            // === TOP ADMIN ===
            const adminData = @json($adminData);
            const ctxTopAdmin = document.getElementById('topAdminChart').getContext('2d');

            let topAdminChart = new Chart(ctxTopAdmin, {
                type: 'bar',
                data: {
                    labels: adminData.top10.labels,
                    datasets: [{
                        label: 'Jumlah Admin Penerima Aduan',
                        data: adminData.top10.data,
                        backgroundColor: materialPalette,
                    }]
                },
                options: {
                    ...chartOptions,
                    indexAxis: 'y',
                    plugins: {
                        ...chartOptions.plugins,
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 16,
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            ...chartOptions.plugins.tooltip,
                            callbacks: {
                                label: function(ctx) {
                                    return `${ctx.dataset.label}: ${ctx.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            reverse: true,
                            ticks: {
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            },
                            grid: {
                                color: '#e0e0e0',
                                borderDash: [4, 4]
                            }
                        },
                        y: {
                            ticks: {
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            document.getElementById('topAdminFilter').addEventListener('change', function() {
                const selected = this.value;
                topAdminChart.data.labels = adminData[selected].labels;
                topAdminChart.data.datasets[0].data = adminData[selected].data;
                document.getElementById('judulTopAdmin').innerText =
                    selected === 'top10' ? 'Top 10 Admin Penerima Aduan' : 'Semua Admin Penerima Aduan';
                topAdminChart.update();
            });

            // === KATEGORI UMUM ===
            const kategoriUmumData = {
                top10: {
                    labels: {!! json_encode($kategoriUmumData['top10']['labels']) !!},
                    counts: {!! json_encode($kategoriUmumData['top10']['counts']) !!}
                },
                all: {
                    labels: {!! json_encode($kategoriUmumData['all']['labels']) !!},
                    counts: {!! json_encode($kategoriUmumData['all']['counts']) !!}
                }
            };

            const ctxKategoriUmum = document.getElementById('kategoriChart').getContext('2d');
            let kategoriUmumChart = new Chart(ctxKategoriUmum, {
                type: 'bar',
                data: {
                    labels: kategoriUmumData.top10.labels,
                    datasets: [{
                        label: 'Jumlah Kategori Aduan',
                        data: kategoriUmumData.top10.counts,
                        backgroundColor: materialPalette
                    }]
                },
                options: {
                    ...chartOptions,
                    indexAxis: 'y',
                    plugins: {
                        ...chartOptions.plugins,
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 16,
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            ...chartOptions.plugins.tooltip,
                            callbacks: {
                                label: function(ctx) {
                                    return `${ctx.dataset.label}: ${ctx.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            },
                            grid: {
                                color: '#e0e0e0',
                                borderDash: [4, 4]
                            }
                        },
                        y: {
                            ticks: {
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            document.getElementById('kategoriUmumFilter').addEventListener('change', function() {
                const selected = this.value;

                // Update data chart
                kategoriUmumChart.data.labels = kategoriUmumData[selected].labels;
                kategoriUmumChart.data.datasets[0].data = kategoriUmumData[selected].counts;
                kategoriUmumChart.update();

                // Update judul chart
                const title = selected === 'top10' ? 'Top 10 Kategori Aduan' : 'Semua Kategori Aduan';
                document.getElementById('kategoriUmumTitle').textContent = title;
            });

            // === WILAYAH DOUGHNUT ===
            new Chart(document.getElementById('wilayahChart'), {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($wilayahLabels) !!},
                    datasets: [{
                        data: {!! json_encode($wilayahCounts) !!},
                        backgroundColor: materialPalette,
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...chartOptions,
                    cutout: '60%', // Ukuran lubang tengah (bisa sesuaikan)
                    plugins: {
                        ...chartOptions.plugins,
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });

            // === STATUS PIE ===
            new Chart(document.getElementById('reportStatusChart'), {
                type: 'pie',
                data: {
                    labels: ['Belum Dicek', 'Disetujui', 'Revisi', 'Direspon', 'Selesai', 'Arsip'],
                    datasets: [{
                        data: [
                            {{ $pendingCount }},
                            {{ $readCount }},
                            {{ $revisiCount }},
                            {{ $respondedCount }},
                            {{ $completedCount }},
                            {{ $arsipCount }}
                        ],
                        backgroundColor: [
                            '#F44336', // Diajukan - Merah
                            '#2196F3', // Dibaca - Biru
                            '#FF9800', // Revisi - Oranye 🟠
                            '#FFC107', // Direspon - Kuning
                            '#4CAF50', // Selesai - Hijau
                            '#9C27B0' // Arsip - Ungu 🟣
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        ...chartOptions.plugins,
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        tooltip: {
                            ...chartOptions.plugins.tooltip,
                            callbacks: {
                                label: function(ctx) {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = ctx.raw;
                                    const percent = ((value / total) * 100).toFixed(1);
                                    return `${ctx.label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // === DATA GRAFIK SEMUA RANGE ===
            const aktivitasData = {!! json_encode($aktivitasSemuaRange) !!};
            const aktivitasHariIni = {!! json_encode($aktivitasHariIni) !!};

            // Tambahkan data 'all' (Gunakan 2 tahun sebagai 'all' jika belum ada khusus)
            aktivitasData['all'] = aktivitasData['730'];

            // Label Range
            const labelRange = {
                'today': 'Hari Ini',
                '7': '1 Minggu',
                '30': '1 Bulan',
                '60': '2 Bulan',
                '90': '3 Bulan',
                '180': '6 Bulan',
                '365': '1 Tahun',
                '730': '2 Tahun',
                'all': 'Semua Waktu'
            };

            const defaultRange = document.getElementById('rangeSelector').value;
            document.getElementById('judulAktivitas').innerText = `Grafik Aktivitas Aduan (${labelRange[defaultRange]})`;

            const ctx = document.getElementById('aktivitasChart');

            function getChartData(range) {
                if (range === 'today') {
                    return {
                        labels: aktivitasHariIni.jam,
                        data: aktivitasHariIni.jumlah
                    };
                }
                return {
                    labels: aktivitasData[range]?.tanggal || [],
                    data: aktivitasData[range]?.jumlah || []
                };
            }

            const initialData = getChartData(defaultRange);

            const aktivitasChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: initialData.labels,
                    datasets: [{
                        label: 'Grafik Aktivitas Aduan',
                        data: initialData.data,
                        borderColor: '#2962FF',
                        backgroundColor: 'rgba(41, 98, 255, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#2962FF'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 16,
                                color: '#37474F',
                                font: {
                                    weight: '500'
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#37474F'
                            },
                            grid: {
                                color: '#f0f0f0'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#37474F',
                                stepSize: 1
                            },
                            grid: {
                                color: '#e0e0e0',
                                borderDash: [4, 4]
                            }
                        }
                    }
                }
            });

            // Ganti range (dropdown listener)
            document.getElementById('rangeSelector').addEventListener('change', function() {
                const selectedRange = this.value;
                const newData = getChartData(selectedRange);

                document.getElementById('judulAktivitas').innerText = `Grafik Aktivitas Aduan (${labelRange[selectedRange]})`;

                aktivitasChart.data.labels = newData.labels;
                aktivitasChart.data.datasets[0].data = newData.data;
                aktivitasChart.update();
            });

            // === Flash message ===
            const spinner = document.getElementById('success-spinner');
            const check = document.getElementById('success-check');
            setTimeout(() => {
                if (spinner && check) {
                    spinner.classList.add('hidden');
                    check.classList.remove('hidden');
                    check.classList.add('scale-100', 'transition-transform', 'duration-300');
                }
            }, 1000);

            setTimeout(() => {
                const el = document.getElementById('alert-success');
                if (el) {
                    el.classList.remove('opacity-100');
                    el.classList.add('opacity-0');
                    setTimeout(() => el.style.display = 'none', 500);
                }
            }, 3000);

            // === 🗺️ HEATMAP INITIALIZATION ===
            const reportsData = @json($heatmapData);

            // Fokus ke DIY
            const map = L.map('heatmap').setView([-7.8014, 110.3731], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const heatPoints = [];
            const markers = L.layerGroup().addTo(map);

            reportsData.forEach(function(report) {
                if (report.latitude && report.longitude) {
                    let intensity = 0.5;
                    let markerColor = '#4CAF50'; // Default Low (Green)
                    let zIndex = 100;

                    if (report.priority === 'Emergency') {
                        intensity = 1.0;
                        markerColor = '#ef4444'; // Red
                        zIndex = 400;
                    } else if (report.priority === 'High') {
                        intensity = 0.8;
                        markerColor = '#f97316'; // Orange
                        zIndex = 300;
                    } else if (report.priority === 'Medium') {
                        intensity = 0.6;
                        markerColor = '#eab308'; // Yellow
                        zIndex = 200;
                    } else {
                        markerColor = '#22c55e'; // Green (Low)
                        intensity = 0.4;
                    }

                    heatPoints.push([report.latitude, report.longitude, intensity]);

                    // Create Custom Marker for ALL reports
                    const isEmergency = report.priority === 'Emergency';
                    const markerHtml = `
                        <div style="position: relative; width: 24px; height: 34px;">
                            <svg viewBox="0 0 24 36" style="width: 24px; height: 34px; filter: drop-shadow(0 2px 3px rgba(0,0,0,0.3));">
                                <path d="M12 0C5.4 0 0 5.4 0 12c0 9 12 24 12 24s12-15 12-24C24 5.4 18.6 0 12 0z" fill="${markerColor}"/>
                                <circle cx="12" cy="12" r="6" fill="white"/>
                                <circle cx="12" cy="12" r="3" fill="${markerColor}"/>
                            </svg>
                            ${isEmergency ? `<div style="position:absolute; top:0; left:0; width:100%; height:100%; border-radius:50%; animation: pulse 1.5s infinite; background: ${markerColor}40; z-index:-1;"></div>` : ''}
                        </div>
                    `;

                    const customIcon = L.divIcon({
                        html: markerHtml,
                        className: '',
                        iconSize: [24, 34],
                        iconAnchor: [12, 34],
                        popupAnchor: [0, -34]
                    });

                    L.marker([report.latitude, report.longitude], {
                            icon: customIcon,
                            zIndexOffset: zIndex
                        })
                        .bindPopup(
                            `<div class="font-sans text-sm">
                            <strong class="block mb-1 text-gray-800">${report.judul}</strong>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">Prioritas:</span>
                                <span style="color:${markerColor}; font-weight:bold">${report.priority}</span>
                            </div>
                        </div>`
                        )
                        .addTo(markers);
                }
            });

            // Add CSS for pulse animation
            const style = document.createElement('style');
            style.innerHTML = `
                @keyframes pulse {
                    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(211, 47, 47, 0.7); }
                    70% { transform: scale(1.5); box-shadow: 0 0 0 10px rgba(211, 47, 47, 0); }
                    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(211, 47, 47, 0); }
                }
            `;
            document.head.appendChild(style);

            L.heatLayer(heatPoints, {
                radius: 25,
                blur: 15,
                maxZoom: 17,
                gradient: {
                    0.4: 'blue',
                    0.65: 'lime',
                    1: 'red'
                }
            }).addTo(map);

        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
        // ⚙️ Konfigurasi default NProgress
        NProgress.configure({
            showSpinner: false,
            trickleSpeed: 200,
            minimum: 0.08
        });

        // 🔹 1. Tangkap klik semua link internal
        document.addEventListener("click", function(e) {
            const link = e.target.closest("a");
            if (link && link.href && link.origin === window.location.origin) {
                NProgress.start();
                setTimeout(() => NProgress.set(0.9), 150);
            }
        });

        // 🔹 2. Patch untuk XMLHttpRequest
        (function(open) {
            XMLHttpRequest.prototype.open = function() {
                NProgress.start();
                this.addEventListener("loadend", function() {
                    NProgress.set(1.0);
                    setTimeout(() => NProgress.done(), 300);
                });
                open.apply(this, arguments);
            };
        })(XMLHttpRequest.prototype.open);

        // 🔹 3. Patch untuk Fetch API
        const originalFetch = window.fetch;
        window.fetch = function() {
            NProgress.start();
            return originalFetch.apply(this, arguments).finally(() => {
                NProgress.set(1.0);
                setTimeout(() => NProgress.done(), 300);
            });
        };

        // 🔹 4. Saat halaman selesai load
        window.addEventListener("pageshow", () => {
            NProgress.set(1.0);
            setTimeout(() => NProgress.done(), 300);
        });

        // 🔹 5. Tangkap submit form (SAMAIN dengan klik link)
        document.addEventListener("submit", function(e) {
            const form = e.target;
            if (form.tagName === "FORM") {
                NProgress.start();
                setTimeout(() => NProgress.set(0.9), 150);
            }
        }, true);
    </script>
@endpush
