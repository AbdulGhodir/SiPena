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
                <h1 class="text-2xl font-bold text-[#173F35]">@yield('header_title', 'Dashboard Administrator')</h1>
                <p class="text-xs text-[#52796F] font-medium mt-0.5">@yield('header_subtitle', 'Pantau aktivitas dan kelola sirkulasi perpustakaan')</p>
            </div>

            <div class="flex items-center gap-5">
                <div class="flex items-center gap-2 text-sm text-[#52796F] font-medium bg-[#FCFAF5] px-3.5 py-2 rounded-xl border border-gray-200/60">
                    <i data-lucide="calendar" class="w-4 h-4 text-[#173F35]"></i>
                    <span>Sabtu, 17 Oktober 2026</span>
                </div>

                <div class="relative group">
                    <button type="button" class="flex items-center gap-3 cursor-pointer py-1 focus:outline-none">
                        <div class="w-10 h-10 rounded-full bg-[#173F35] text-[#F4E8CD] font-bold flex items-center justify-center text-sm shadow-sm ring-2 ring-[#52796F]/20">
                            AP
                        </div>
                        <div class="hidden md:flex flex-col text-left">
                            <span class="text-sm font-semibold text-[#173F35]">Petugas Admin</span>
                            <span class="text-xs text-[#52796F]">Administrator</span>
                        </div>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 group-hover:text-[#173F35] transition-colors"></i>
                    </button>

                    <div class="absolute right-0 top-full pt-2 w-48 hidden group-hover:block z-50">
                        <div class="bg-white rounded-xl shadow-xl border border-gray-100 py-2">
                            <a href="#" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-[#FCFAF5] hover:text-[#173F35] font-medium transition-colors">
                                <i data-lucide="user" class="w-4 h-4 text-[#52796F]"></i>
                                <span>Profil Saya</span>
                            </a>
                            <div class="my-1 border-t border-gray-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors cursor-pointer text-left">
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

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>