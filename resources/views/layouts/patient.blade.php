<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Cổng Bệnh Nhân - Nha Khoa Smile')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html, body, .font-sans, button, input, select, textarea {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                background-color: #f8fafc;
                -webkit-font-smoothing: antialiased;
                line-height: 1.6;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Be Vietnam Pro', 'Inter', sans-serif !important;
                letter-spacing: -0.015em;
            }
            
            /* Glassmorphism utilities */
            .glass-header {
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.92);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(226, 232, 240, 0.9);
                box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
            }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>
        @stack('styles')
    </head>
    <body class="antialiased text-slate-800 selection:bg-blue-500 selection:text-white relative">
        
        <!-- Abstract Background blobs -->
        <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 transform -translate-y-1/2"></div>
            <div class="absolute bottom-0 left-1/4 w-[30rem] h-[30rem] bg-cyan-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 transform translate-y-1/3"></div>
        </div>

        <!-- Header / Top Taskbar -->
        <header class="glass-header sticky top-0 z-40 shadow-xs transition-all duration-300">
            <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Brand + Top Quick Navigation -->
                    <div class="flex items-center gap-6">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 via-indigo-600 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-extrabold text-base leading-none tracking-tight text-slate-900">Nha Khoa <span class="text-indigo-600">Smile</span></span>
                                <span class="text-[11px] font-semibold text-slate-400 mt-1 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-cyan-500"></span>
                                    Cổng Thông Tin Bệnh Nhân
                                </span>
                            </div>
                        </a>

                        <div class="hidden md:block h-6 w-px bg-slate-200"></div>

                        <!-- Top Quick Navigation Pills -->
                        <nav class="hidden md:flex items-center gap-1.5">
                            <a href="{{ route('patient.dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('patient.dashboard') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                📊 Tổng quan
                            </a>
                            <a href="{{ route('patient.history') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('patient.history') || request()->routeIs('patient.appointments') || request()->routeIs('patient.medical_records.*') || request()->routeIs('patient.prescriptions.*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                📋 Lịch sử & Bệnh án
                            </a>
                            <a href="{{ route('patient.invoices') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('patient.invoices*') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                🧾 Hóa đơn & VietQR
                            </a>
                            <a href="{{ route('patient.profile') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('patient.profile') ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                👤 Hồ sơ
                            </a>
                        </nav>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="{{ route('home') }}" class="hidden lg:inline-flex items-center gap-1 text-xs font-bold text-slate-600 hover:text-indigo-600 px-3 py-2 rounded-xl hover:bg-slate-100 transition">
                            🌐 Trang chủ
                        </a>

                        <div class="relative group">
                            <button class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-xl border border-slate-200/90 bg-slate-50/80 hover:bg-white hover:border-indigo-300 transition-all focus:outline-none">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4F46E5&color=ffffff&bold=true" alt="Avatar" class="w-7 h-7 rounded-lg object-cover">
                                <div class="hidden sm:block text-left">
                                    <p class="text-xs font-extrabold text-slate-800 leading-none truncate max-w-[130px]">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-semibold mt-0.5 leading-none">Khách hàng / Bệnh nhân</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                            <!-- Dropdown -->
                            <div class="absolute right-0 mt-2 w-60 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-200/80 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100 py-2 z-50">
                                <div class="px-4 py-2.5 border-b border-slate-100 bg-slate-50/70">
                                    <p class="text-xs font-extrabold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-slate-500 truncate mt-0.5">{{ Auth::user()->email ?? Auth::user()->phone }}</p>
                                </div>
                                <a href="{{ route('patient.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                    <span>📊</span> Bảng điều khiển cá nhân
                                </a>
                                <a href="{{ route('patient.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                    <span>👤</span> Hồ sơ cá nhân
                                </a>
                                <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs font-bold text-slate-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                    <span>🌐</span> Về trang chủ phòng khám
                                </a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <form method="POST" action="{{ route('patient.logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2.5 w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors">
                                        <span>🚪</span> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- Floating Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-28">
                        <nav class="glass-card rounded-[2rem] p-3 space-y-1.5 flex flex-row lg:flex-col overflow-x-auto lg:overflow-x-visible no-scrollbar">
                            <a href="{{ route('patient.dashboard') }}" class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all whitespace-nowrap {{ request()->routeIs('patient.dashboard') ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-white/60 hover:text-blue-600 hover:shadow-sm' }}">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('patient.dashboard') ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-500 group-hover:bg-blue-100' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                </div>
                                Tổng quan
                            </a>
                            
                            <a href="{{ route('patient.profile') }}" class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all whitespace-nowrap {{ request()->routeIs('patient.profile') ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-white/60 hover:text-blue-600 hover:shadow-sm' }}">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('patient.profile') ? 'bg-white/20 text-white' : 'bg-indigo-50 text-indigo-500 group-hover:bg-indigo-100' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                Hồ sơ cá nhân
                            </a>
                            
                            <a href="{{ route('patient.history') }}" class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all whitespace-nowrap {{ request()->routeIs('patient.history') || request()->routeIs('patient.medical_records.*') || request()->routeIs('patient.prescriptions.*') ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-white/60 hover:text-blue-600 hover:shadow-sm' }}">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('patient.history') || request()->routeIs('patient.medical_records.*') || request()->routeIs('patient.prescriptions.*') ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-100' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                Lịch sử & Bệnh án
                            </a>
                            
                            <a href="{{ route('patient.invoices') }}" class="group flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold transition-all whitespace-nowrap {{ request()->routeIs('patient.invoices*') ? 'bg-gradient-to-r from-blue-600 to-cyan-500 text-white shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-white/60 hover:text-blue-600 hover:shadow-sm' }}">
                                <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors {{ request()->routeIs('patient.invoices*') ? 'bg-white/20 text-white' : 'bg-amber-50 text-amber-500 group-hover:bg-amber-100' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                                </div>
                                Hóa đơn & Thanh toán
                            </a>
                        </nav>

                        <div class="mt-6 hidden lg:block">
                            <a href="{{ route('public.booking') }}" class="flex items-center justify-center gap-2 w-full bg-slate-800 text-white hover:bg-slate-900 px-4 py-4 rounded-2xl font-bold shadow-xl shadow-slate-900/20 hover:shadow-slate-900/40 hover:-translate-y-1 transition-all duration-300">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Đặt Lịch Khám Mới
                            </a>
                        </div>
                    </div>
                </aside>

                <!-- Main Section -->
                <main class="lg:col-span-3">
                    <div class="space-y-6">
                        @if (session('success'))
                            <div class="bg-green-50/90 backdrop-blur-sm border-l-4 border-green-500 text-green-700 p-4 rounded-2xl shadow-sm flex items-start gap-3" role="alert">
                                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="block sm:inline font-medium mt-0.5">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="bg-red-50/90 backdrop-blur-sm border-l-4 border-red-500 text-red-700 p-4 rounded-2xl shadow-sm flex items-start gap-3" role="alert">
                                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="block sm:inline font-medium mt-0.5">{{ session('error') }}</span>
                            </div>
                        @endif
                        
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
