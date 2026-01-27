<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - E-Lapor DIY</title>
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        red: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            200: '#fecdd3',
                            300: '#fda4af',
                            400: '#fb7185',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            800: '#9f1239',
                            900: '#881337',
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="relative min-h-screen flex items-center justify-center p-6 overflow-hidden bg-gray-50">

    {{-- Abstract Background Shapes --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-red-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-red-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-red-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>

    {{-- Main Container --}}
    <div class="relative z-10 w-full max-w-2xl bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-white/50 text-center">
        
        {{-- Logo --}}
        <div class="mb-8 animate-float">
            <div class="inline-flex p-4 rounded-full bg-red-50 mb-2 shadow-inner">
                <img src="{{ asset('images/logo-diy.png') }}" alt="Logo DIY" class="h-20 md:h-24 w-auto object-contain drop-shadow-lg">
            </div>
        </div>

        {{-- Content --}}
        <div class="space-y-6">
            {{-- Error Code --}}
            <h1 class="text-[8rem] md:text-[10rem] leading-none font-black text-transparent bg-clip-text bg-gradient-to-b from-red-500 to-red-900 tracking-tighter drop-shadow-sm select-none">
                @yield('code')
            </h1>

            {{-- Message --}}
            <h2 class="text-2xl md:text-4xl font-bold text-gray-800 tracking-tight">
                @yield('message')
            </h2>

            {{-- Description --}}
            <p class="text-gray-500 text-lg md:text-xl font-medium max-w-lg mx-auto leading-relaxed">
                @yield('description', 'Terjadi kesalahan yang tidak terduga.')
            </p>

            {{-- Illustration Area (Optional) --}}
            <div class="py-4 flex justify-center opacity-80">
                <div class="text-red-500">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @yield('icon')
                    </svg>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
                <a href="{{ url('/') }}" 
                   class="group relative inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-white transition-all duration-200 bg-gradient-to-r from-red-600 to-red-800 rounded-2xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 hover:shadow-lg hover:shadow-red-500/30 hover:-translate-y-1 overflow-hidden w-full sm:w-auto">
                    <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                    <span class="relative flex items-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Kembali ke Beranda
                    </span>
                </a>

                @if(url()->previous() != url()->current())
                <button onclick="history.back()" 
                        class="group inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-red-700 transition-all duration-200 bg-red-50 hover:bg-red-100 border border-red-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 hover:-translate-y-1 w-full sm:w-auto">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </span>
                </button>
                @endif
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-12 text-sm font-medium text-gray-400">
            &copy; {{ date('Y') }} E-Lapor DIY. All rights reserved.
        </div>
    </div>

</body>
</html>
