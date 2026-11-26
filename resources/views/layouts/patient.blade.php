<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Cổng Bệnh Nhân - Nha Khoa Smile')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html, body, .font-sans, button, input, select, textarea {
                font-family: 'Inter', 'Be Vietnam Pro', system-ui, -apple-system, sans-serif !important;
                background-color: #F8FAFC;
                -webkit-font-smoothing: antialiased;
            }
            .glass-header {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            }
            ::-webkit-scrollbar { width: 5px; height: 5px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>
        @stack('styles')
    </head>
    <body class="antialiased text-slate-800 selection:bg-[#0D7A68] selection:text-white min-h-screen flex flex-col justify-between">
        
        <div>
            <!-- Accent gradient line on top -->
            <div class="h-1 w-full bg-gradient-to-r from-[#095246] via-[#0D7A68] to-[#14B8A6]"></div>

            <!-- Header / Top Taskbar -->
            <header class="glass-header sticky top-0 z-40 transition-all duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Brand + Top Quick Navigation -->
                        <div class="flex items-center gap-6">
                            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                                <div class="w-9 h-9 rounded-xl bg-[#0D7A68] flex items-center justify-center text-white shadow-xs group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.5 2 6 4.5 6 8c0 2 .5 3.5 1 5.5.7 2.8 1.5 6.5 2.5 8.5.4.8 1.4 1 2 .5.7-.6 1.3-2 1.5-3 .2-1 .5-1 .7-1s.5 0 .7 1c.2 1 .8 2.4 1.5 3 .6.5 1.6.3 2-.5 1-2 1.8-5.7 2.5-8.5.5-2 1-3.5 1-5.5 0-3.5-2.5-6-6-6zm0 2c2.5 0 4 1.8 4 4.5 0 1.5-.4 2.8-.8 4.5-.7 2.8-1.5 6-2.2 7.5-.3-.5-.7-1.3-.9-2.2-.4-1.8-1.2-2.3-2.1-2.3s-1.7.5-2.1 2.3c-.2.9-.6 1.7-.9 2.2-.7-1.5-1.5-4.7-2.2-7.5-.4-1.7-.8-3-.8-4.5C8 5.8 9.5 4 12 4z"/>
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-base leading-none tracking-tight text-slate-900">Nha Khoa Smile</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#D1FAE5] text-[#065F46] border border-emerald-200">
                                            Bệnh nhân
                                        </span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 font-medium mt-1">
                                        Cổng tra cứu hồ sơ & Lịch hẹn
                                    </span>
                                </div>
                            </a>

                            <div class="hidden md:block h-6 w-px bg-slate-200"></div>

                            <!-- Top Quick Navigation Pills -->
                            <nav class="hidden md:flex items-center gap-1.5">
                                <a href="{{ route('patient.dashboard') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('patient.dashboard') ? 'bg-slate-100 text-slate-900 font-bold border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Tổng quan
                                </a>
                                <a href="{{ route('patient.history') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('patient.history') || request()->routeIs('patient.appointments') || request()->routeIs('patient.medical_records.*') || request()->routeIs('patient.prescriptions.*') ? 'bg-slate-100 text-slate-900 font-bold border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Lịch sử & Bệnh án
                                </a>
                                <a href="{{ route('patient.invoices') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('patient.invoices*') ? 'bg-slate-100 text-slate-900 font-bold border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Hóa đơn & VietQR
                                </a>
                                <a href="{{ route('patient.profile') }}" class="px-3 py-1.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('patient.profile') ? 'bg-slate-100 text-slate-900 font-bold border border-slate-200/80' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                    Hồ sơ cá nhân
                                </a>
                            </nav>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <a href="{{ route('home') }}" class="hidden lg:inline-flex items-center gap-1 text-xs font-semibold text-slate-600 hover:text-[#0D7A68] px-3 py-1.5 rounded-xl hover:bg-slate-100 transition">
                                Trang chủ
                            </a>

                            <div class="relative group">
                                <button class="flex items-center gap-2 pl-2 pr-3 py-1 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 transition-all focus:outline-none shadow-xs">
                                    <div class="w-7 h-7 rounded-lg bg-[#0D7A68] text-white flex items-center justify-center font-bold text-xs">
                                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="hidden sm:block text-left">
                                        <p class="text-xs font-bold text-slate-800 leading-none truncate max-w-[130px]">{{ Auth::user()->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium mt-0.5 leading-none">Bệnh nhân</p>
                                    </div>
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                                <!-- Dropdown -->
                                <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200/90 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-2 z-50">
                                    <div class="px-4 py-2 border-b border-slate-100 bg-slate-50/70">
                                        <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ Auth::user()->email ?? Auth::user()->phone }}</p>
                                    </div>
                                    <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0D7A68] transition">
                                        Bảng điều khiển cá nhân
                                    </a>
                                    <a href="{{ route('patient.profile') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0D7A68] transition">
                                        Hồ sơ cá nhân
                                    </a>
                                    <a href="{{ route('home') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 hover:text-[#0D7A68] transition">
                                        Về trang chủ phòng khám
                                    </a>
                                    <div class="border-t border-slate-100 my-1"></div>
                                    <form method="POST" action="{{ route('patient.logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition">
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    
                    <!-- Floating Sidebar -->
                    <aside class="lg:col-span-1">
                        <div class="sticky top-24 space-y-4">
                            <nav class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-3 space-y-1 flex flex-row lg:flex-col overflow-x-auto lg:overflow-x-visible">
                                <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs font-bold transition {{ request()->routeIs('patient.dashboard') ? 'bg-[#0D7A68] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <span>📊</span> Tổng quan
                                </a>
                                
                                <a href="{{ route('patient.profile') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs font-bold transition {{ request()->routeIs('patient.profile') ? 'bg-[#0D7A68] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <span>👤</span> Hồ sơ cá nhân
                                </a>
                                
                                <a href="{{ route('patient.history') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs font-bold transition {{ request()->routeIs('patient.history') || request()->routeIs('patient.medical_records.*') || request()->routeIs('patient.prescriptions.*') ? 'bg-[#0D7A68] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <span>📋</span> Lịch sử & Bệnh án
                                </a>
                                
                                <a href="{{ route('patient.invoices') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-xs font-bold transition {{ request()->routeIs('patient.invoices*') ? 'bg-[#0D7A68] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <span>🧾</span> Hóa đơn & VietQR
                                </a>
                            </nav>

                            <div class="hidden lg:block">
                                <a href="{{ route('public.booking') }}" class="flex items-center justify-center gap-2 w-full bg-[#0D7A68] hover:bg-[#0B6858] text-white px-4 py-3.5 rounded-2xl text-xs font-bold shadow-xs transition">
                                    <span>+ Đặt Lịch Khám Mới</span>
                                </a>
                            </div>
                        </div>
                    </aside>

                    <!-- Main Section -->
                    <main class="lg:col-span-3">
                        <div class="space-y-6">
                            @if (session('success'))
                                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl shadow-xs flex items-center gap-2 text-xs font-semibold" role="alert">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span>{{ session('success') }}</span>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl shadow-xs flex items-center gap-2 text-xs font-semibold" role="alert">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <span>{{ session('error') }}</span>
                                </div>
                            @endif
                            
                            @yield('content')
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- Global Stitch UI Footer -->
        <footer class="mt-auto border-t border-slate-200/90 bg-white py-3.5 px-6 text-xs text-slate-500">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
                <div>
                    Nha Khoa Smile DCMS • Hệ thống Quản lý Nha khoa Thông minh & Điều phối tiếp đón
                </div>
                <div class="flex items-center gap-3 text-[11px] text-slate-400">
                    <span>Phiên bản v2.4.0-stable</span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1 text-[#0D7A68] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0D7A68] animate-pulse"></span>
                        Hệ thống hoạt động bình thường
                    </span>
                </div>
            </div>
        </footer>

        @stack('scripts')
    </body>
</html>
