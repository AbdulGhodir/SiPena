<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans flex min-h-screen bg-[#FCFAF5] text-[#26352F]">
    @include('components.admin_sidebar')

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
        
        <header class="bg-white border-b border-gray-200/60 px-8 py-4 flex justify-between items-center shrink-0 z-20">
            <div>
                <h1 class="text-2xl font-bold text-[#173F35]">@yield('header_title')</h1>
                <p class="text-xs text-[#52796F] font-medium mt-0.5">@yield('header_subtitle')</p>
            </div>

            <div class="flex items-center gap-5">
                <div class="flex items-center gap-2 text-sm text-[#52796F] font-medium bg-[#FCFAF5] px-3.5 py-2 rounded-xl border border-gray-200/60">
                    <i data-lucide="calendar" class="w-4 h-4 text-[#173F35]"></i>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                </div>

                <div class="relative group">
                    <button type="button" class="flex items-center gap-3 cursor-pointer py-1 focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-[#173F35] text-[#F4E8CD] font-bold flex items-center justify-center text-sm shadow-sm ring-2 ring-[#52796F]/20">
                            {{ strtoupper(substr(auth()->user()->nama ?? 'AD', 0, 2)) }}
                        </div>
                        <div class="hidden md:flex flex-col text-left">
                            <span class="text-sm font-semibold text-[#173F35]">{{ auth()->user()->nama ?? 'Administrator' }}</span>
                            <span class="text-xs text-[#52796F] capitalize">{{ auth()->user()->role ?? 'Admin' }}</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 group-hover:text-[#173F35] transition-colors"></i>
                    </button>

                    <div class="absolute right-0 top-full pt-2 w-40 hidden group-hover:block z-50">
                        <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-1.5">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors cursor-pointer text-left">
                                    <i data-lucide="log-out" class="w-4 h-4 text-red-500"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-8 overflow-y-auto bg-[#FCFAF5]">
            @yield('content')
        </main>
    </div>

    <div class="fixed bottom-8 right-8 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none">
        @if (session('success'))
            <div id="toastNotification" class="pointer-events-auto flex items-center justify-between gap-3 p-4 bg-emerald-600 text-white rounded-2xl shadow-xl transform translate-x-full transition-transform duration-300 ease-out">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                        <i data-lucide="check-circle" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xs font-semibold leading-relaxed">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="closeToast()" class="text-white/80 hover:text-white cursor-pointer p-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @elseif (session('error') || $errors->any())
            <div id="toastNotification" class="pointer-events-auto flex items-center justify-between gap-3 p-4 bg-red-600 text-white rounded-2xl shadow-xl transform translate-x-full transition-transform duration-300 ease-out">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                        <i data-lucide="alert-circle" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-xs font-semibold leading-relaxed">{{ session('error') ?? $errors->first() }}</span>
                </div>
                <button type="button" onclick="closeToast()" class="text-white/80 hover:text-white cursor-pointer p-1">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif
    </div>

    <script>
        function closeToast() {
            const toast = document.getElementById('toastNotification');
            if (toast) {
                toast.classList.add('translate-x-full');
                setTimeout(() => toast.remove(), 300);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const toast = document.getElementById('toastNotification');
            if (toast) {
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);

                setTimeout(() => {
                    closeToast();
                }, 4000);
            }
        });
    </script>

    <x-lucide />
</body>
</html>