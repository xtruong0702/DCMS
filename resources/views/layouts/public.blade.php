<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark-clinic">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Nha Khoa Smile - Phòng Khám Răng Hàm Mặt Chuẩn Y Khoa')</title>

        <!-- Google Fonts chuẩn Tiếng Việt đồng nhất toàn hệ thống: Be Vietnam Pro & Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&family=Inter:wght@400;500;600;700&subset=vietnamese&display=swap" rel="stylesheet">

        <!-- Scripts & Tailwind -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Prevent Flash of Unstyled Theme (Ưu tiên mặc định Chế độ Tối) -->
        <script>
            (function () {
                try {
                    const saved = localStorage.getItem('dcms_clinic_theme');
                    if (saved === 'light') {
                        document.documentElement.classList.remove('dark-clinic');
                    } else {
                        document.documentElement.classList.add('dark-clinic');
                    }
                } catch (e) {}
            })();
        </script>

        <style>
            :root {
                --clinic-canvas: #effcf9;
                --clinic-surface: #ffffff;
                --clinic-accent: #0f3e36;
                --clinic-gold: #d4af37;
                --clinic-gold-light: #f3e5ab;
            }
            body, .font-sans-clinic {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                font-size: 0.875rem;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                text-rendering: optimizeLegibility;
                background-color: #effcf9 !important;
                color: #334155 !important;
            }
            .font-heading-clinic, .font-serif-luxury {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
                letter-spacing: -0.02em;
            }
            .tabular-nums, .font-mono, .price, .phone, .time, [data-numeric] {
                font-variant-numeric: tabular-nums !important;
                font-feature-settings: "tnum" 1 !important;
            }
        </style>
        @stack('styles')
    </head>
    <body class="clinic-scrollbar antialiased bg-slate-50 text-slate-700 selection:bg-teal-600 selection:text-white flex flex-col min-h-screen pb-20 md:pb-0 relative">

        <!-- Scroll Progress Bar (Medical Teal) -->
        <div id="scroll-progress" class="scroll-progress-bar" aria-hidden="true"></div>

        <!-- Top Clinic Info Bar (Desktop - Serene Deep Teal #0f3e36) -->
        <div class="hidden lg:block bg-[#0f3e36] text-[#effcf9] text-xs py-2 relative z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="pulse-dot pulse-dot-emerald"></span>
                        <span class="font-medium text-white">Đang mở cửa:</span>
                        <span class="tabular-nums text-teal-100">08:00 – 20:00 (Thứ 2 – Chủ Nhật)</span>
                    </span>
                    <span class="text-teal-300/60">|</span>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=204+Tr%E1%BA%A7n+Duy+H%C6%B0ng,+Y%C3%AAn+H%C3%B2a,+C%E1%BA%A7u+Gi%E1%BA%A5y,+H%C3%A0+N%E1%BB%99i" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-teal-100 hover:text-white transition" title="Mở chỉ đường Google Maps">
                        <svg class="w-3.5 h-3.5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội</span>
                    </a>
                </div>
                <div class="flex items-center gap-5">
                    <a href="tel:0775761388" class="inline-flex items-center gap-1.5 font-semibold text-white hover:text-teal-200 transition tabular-nums">
                        <svg class="w-3.5 h-3.5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>Hotline Cấp Cứu & Đặt Hẹn: 0775 761 388</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Clinical Navigation Bar -->
        <header class="sticky top-0 w-full z-40 clinic-header transition-all duration-300" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-18 py-3">

                    <!-- Clinic Brand Logo -->
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-[#0f3e36] rounded-xl flex items-center justify-center text-[#f3e5ab] shadow-md shadow-[#0f3e36]/15 group-hover:scale-105 transition-transform">
                            <!-- Clean Dental/Medical Cross Icon -->
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-heading-clinic font-bold text-xl tracking-tight text-[#0f3e36] leading-none group-hover:opacity-85 transition-opacity">Nha Khoa Smile</span>
                            <span class="text-[10px] font-semibold uppercase tracking-wider text-[#0f3e36]/70 mt-1">Phòng Khám Răng Hàm Mặt • DCMS</span>
                        </div>
                    </a>

                    <!-- Desktop Medical Navigation (Single-row nowrap) -->
                    <nav class="hidden lg:flex items-center gap-0.5 xl:gap-1 whitespace-nowrap">
                        <a href="{{ route('home') }}" class="nav-link-clinic whitespace-nowrap px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('home') ? 'bg-teal-50 text-teal-800' : 'text-slate-600 hover:text-teal-700 hover:bg-slate-100/80' }}">
                            Trang Chủ
                        </a>

                        <!-- Dịch vụ & Bảng giá Dropdown -->
                        <div class="relative group">
                            <a href="{{ route('public.services') }}" class="nav-link-clinic whitespace-nowrap px-3 py-2 rounded-lg text-xs font-semibold transition-all flex items-center gap-1 {{ request()->routeIs('public.service*') ? 'bg-teal-50 text-teal-800' : 'text-slate-600 group-hover:text-teal-700 group-hover:bg-slate-100/80' }}">
                                <span>Dịch Vụ</span>
                                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 group-hover:rotate-180 group-hover:text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </a>
                            <div class="absolute left-0 top-full mt-2 w-72 bg-white rounded-2xl shadow-xl border border-slate-200/40 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top scale-95 group-hover:scale-100 z-50 p-2 space-y-1">
                                <a href="{{ route('public.services') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-bold text-teal-800 bg-teal-50 block hover:bg-teal-100/80 transition">
                                    📋 Xem Toàn Bộ Bảng Giá Niêm Yết
                                </a>
                                <a href="{{ route('public.service.detail', 'rang-su-chuyen-sau') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-teal-800 hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Dán Sứ Veneer Emax</span>
                                    <span class="text-[10px] text-teal-700 bg-teal-50 px-2 py-0.5 rounded-full font-semibold">Thẩm mỹ</span>
                                </a>
                                <a href="{{ route('public.service.detail', 'implant-chuyen-sau') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-teal-800 hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Cấy Ghép Implant Straumann</span>
                                    <span class="text-[10px] text-sky-700 bg-sky-50 px-2 py-0.5 rounded-full font-semibold">Phục hình</span>
                                </a>
                                <a href="{{ route('public.service.detail', 'nieng-rang') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-teal-800 hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Niềng Răng Invisalign</span>
                                    <span class="text-[10px] text-teal-700 bg-teal-50 px-2 py-0.5 rounded-full font-semibold">Chỉnh nha</span>
                                </a>
                                <a href="{{ route('public.service.detail', 'tay-trang-rang') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-teal-800 hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Tẩy Trắng Laser Whitening</span>
                                    <span class="text-[10px] text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full font-semibold">45 phút</span>
                                </a>
                                <a href="{{ route('public.service.detail', 'nho-rang-khon') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-teal-800 hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Nhổ Răng Khôn Piezotome</span>
                                    <span class="text-[10px] text-slate-600 bg-slate-100 px-2 py-0.5 rounded-full font-semibold">Không đau</span>
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('public.doctors') }}" class="nav-link-clinic whitespace-nowrap px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('public.doctors') ? 'bg-teal-50 text-teal-800' : 'text-slate-600 hover:text-teal-700 hover:bg-slate-100/80' }}">
                            Bác Sĩ
                        </a>
                        <a href="{{ route('public.about') }}" class="nav-link-clinic whitespace-nowrap px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('public.about') ? 'bg-teal-50 text-teal-800' : 'text-slate-600 hover:text-teal-700 hover:bg-slate-100/80' }}">
                            Giới Thiệu
                        </a>
                        <a href="{{ route('public.lookup') }}" class="nav-link-clinic whitespace-nowrap px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('public.lookup') ? 'bg-teal-50 text-teal-800' : 'text-slate-600 hover:text-teal-700 hover:bg-slate-100/80' }}">
                            Tra Cứu
                        </a>
                        <a href="{{ route('public.contact') }}" class="nav-link-clinic whitespace-nowrap px-3 py-2 rounded-lg text-xs font-semibold transition-all {{ request()->routeIs('public.contact') ? 'bg-teal-50 text-teal-800' : 'text-slate-600 hover:text-teal-700 hover:bg-slate-100/80' }}">
                            Liên Hệ
                        </a>
                    </nav>

                    <!-- Desktop Actions -->
                    <div class="hidden sm:flex items-center gap-2 shrink-0 whitespace-nowrap">
                        <!-- Nút Chuyển Giao Diện Sáng / Tối -->
                        <button type="button" data-theme-toggle aria-label="Chuyển giao diện Sáng / Tối" title="Chuyển giao diện Sáng / Tối"
                            class="theme-toggle-btn w-9 h-9 rounded-xl border border-slate-200/40 bg-white text-slate-600 hover:text-teal-700 hover:border-teal-400 flex items-center justify-center shadow-sm">
                            <!-- Icon Mặt Trăng (hiện khi đang ở Sáng -> bấm để sang Tối) -->
                            <svg class="w-4 h-4 theme-icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <!-- Icon Mặt Trời (hiện khi đang ở Tối -> bấm để sang Sáng) -->
                            <svg class="w-4 h-4 theme-icon-sun hidden text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        @auth
                            @if(strtolower(auth()->user()->role->name ?? '') === 'patient')
                                <div class="relative group">
                                    <button class="px-3 py-2 rounded-xl border border-slate-200/40 bg-white text-xs font-semibold text-slate-800 flex items-center gap-2 hover:border-teal-500 transition shadow-sm">
                                        <span class="w-6 h-6 rounded-lg bg-teal-600 text-white flex items-center justify-center text-[10px] font-bold">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                                        <span>{{ auth()->user()->name }}</span>
                                    </button>
                                    <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200/40 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100 z-50 p-2 space-y-1">
                                        <a href="{{ route('patient.dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-teal-800 hover:bg-teal-50 block transition">📊 Bảng điều khiển cá nhân</a>
                                        <a href="{{ route('patient.history') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-teal-800 hover:bg-teal-50 block transition">📋 Lịch sử khám & Bệnh án</a>
                                        <a href="{{ route('patient.invoices') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-teal-800 hover:bg-teal-50 block transition">🧾 Hóa đơn & VietQR</a>
                                        <div class="border-t border-slate-100/70 my-1"></div>
                                        <form method="POST" action="{{ route('patient.logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-3.5 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition">🚪 Đăng xuất</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ url('/dashboard') }}" class="px-3.5 py-2 rounded-xl border border-teal-500/15 bg-teal-50 text-xs font-semibold text-teal-800 hover:bg-teal-100 transition">
                                    ⚙️ Cổng Quản Trị
                                </a>
                            @endif
                        @else
                            <a href="{{ route('patient.login') }}" class="px-3 py-2 rounded-xl border border-slate-200/40 bg-white text-slate-600 hover:text-teal-700 hover:border-teal-400 transition flex items-center gap-1.5 text-xs font-semibold whitespace-nowrap" title="Đăng nhập">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Đăng Nhập</span>
                            </a>
                        @endauth

                        <a href="{{ route('public.booking') }}" class="btn-press btn-shimmer btn-clinic-primary px-4 py-2.5 rounded-xl text-xs flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Đặt Lịch Khám</span>
                        </a>
                    </div>

                    <!-- Mobile Right Icons -->
                    <div class="flex sm:hidden items-center gap-2">
                        <button type="button" data-theme-toggle aria-label="Chuyển giao diện Sáng / Tối"
                            class="theme-toggle-btn p-2 rounded-xl bg-white text-slate-600 border border-slate-200/40">
                            <svg class="w-5 h-5 theme-icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg class="w-5 h-5 theme-icon-sun hidden text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>
                        <a href="tel:0775761388" class="p-2 rounded-xl bg-teal-50 text-teal-700 border border-teal-500/15" title="Gọi Hotline 0775 761 388">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </a>
                        <a href="{{ route('patient.login') }}" class="p-2 rounded-xl bg-white text-slate-600 border border-slate-200/40" title="Cổng Bệnh Nhân">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Sticky Mobile Bottom Navigation Dock (Frosted Glassmorphism) -->
        <div class="sm:hidden fixed bottom-0 inset-x-0 clinic-tab-bar shadow-[0_-4px_20px_rgba(15,62,54,0.06)] z-50 py-1.5 px-3 flex justify-around items-center">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 text-center py-1 px-2 transition-transform active:scale-95 {{ request()->routeIs('home') ? 'text-teal-700 font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px]">Trang Chủ</span>
            </a>

            <a href="{{ route('public.services') }}" class="flex flex-col items-center gap-0.5 text-center py-1 px-2 transition-transform active:scale-95 {{ request()->routeIs('public.service*') ? 'text-teal-700 font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span class="text-[10px]">Dịch Vụ</span>
            </a>

            <!-- Elevated Center Booking Button (Medical Teal) -->
            <a href="{{ route('public.booking') }}" class="btn-press btn-clinic-primary -mt-5 flex flex-col items-center justify-center w-12 h-12 rounded-full shadow-lg ring-1 ring-slate-900/5 relative">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </a>

            <a href="{{ route('public.doctors') }}" class="flex flex-col items-center gap-0.5 text-center py-1 px-2 transition-transform active:scale-95 {{ request()->routeIs('public.doctors') ? 'text-teal-700 font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[10px]">Bác Sĩ</span>
            </a>

            <a href="{{ route('public.lookup') }}" class="flex flex-col items-center gap-0.5 text-center py-1 px-2 transition-transform active:scale-95 {{ request()->routeIs('public.lookup') ? 'text-teal-700 font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span class="text-[10px]">Tra Cứu</span>
            </a>
        </div>

        <!-- Clean Medical Clinic Footer (Deep Serene Teal in Light / Obsidian in Dark) -->
        <footer class="bg-[#0f3e36] dark:bg-[#050d0c] text-[#d9ebe7] py-14 mt-auto relative" x-data="{ legalModal: null }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10 border-b border-slate-800/50 pb-10">
                    <div class="col-span-1 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center text-white shadow-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div>
                                <span class="font-heading-clinic font-bold text-xl text-white block leading-none">Nha Khoa Smile</span>
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-teal-400">Hệ Thống Nha Khoa DCMS</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Phòng khám Răng Hàm Mặt chuẩn Y khoa. Ứng dụng bệnh án điện tử DCMS, sơ đồ 32 răng chuẩn FDI, đội ngũ bác sĩ chuyên khoa giàu kinh nghiệm và thanh toán VietQR minh bạch.
                        </p>
                        <div class="pt-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-950 border border-teal-700/60 text-teal-300 text-[11px] font-semibold">
                                ✓ Đạt Chuẩn Vô Trùng Bộ Y Tế
                            </span>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-heading-clinic font-bold text-white mb-4 uppercase tracking-wider text-xs">Chuyên Khoa & Dịch Vụ</h4>
                        <ul class="space-y-2.5 text-xs text-slate-400">
                            <li><a href="{{ route('public.service.detail', 'rang-su-chuyen-sau') }}" class="hover:text-teal-300 transition">Dán Sứ Veneer Emax</a></li>
                            <li><a href="{{ route('public.service.detail', 'implant-chuyen-sau') }}" class="hover:text-teal-300 transition">Cấy Ghép Implant Straumann</a></li>
                            <li><a href="{{ route('public.service.detail', 'nieng-rang') }}" class="hover:text-teal-300 transition">Niềng Răng Invisalign</a></li>
                            <li><a href="{{ route('public.service.detail', 'tay-trang-rang') }}" class="hover:text-teal-300 transition">Tẩy Trắng Răng Laser Whitening</a></li>
                            <li><a href="{{ route('public.service.detail', 'nho-rang-khon') }}" class="hover:text-teal-300 transition">Nhổ Răng Khôn Piezotome</a></li>
                            <li><a href="{{ route('public.services') }}" class="text-teal-400 hover:underline font-semibold inline-block pt-1">&rarr; Xem toàn bộ bảng giá</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-heading-clinic font-bold text-white mb-4 uppercase tracking-wider text-xs">Thông Tin Phòng Khám</h4>
                        <ul class="space-y-3 text-xs text-slate-400">
                            <li class="flex items-start gap-2.5">
                                <span class="text-teal-400">📍</span>
                                <a href="https://www.google.com/maps/dir/?api=1&destination=204+Tr%E1%BA%A7n+Duy+H%C6%B0ng,+Y%C3%AAn+H%C3%B2a,+C%E1%BA%A7u+Gi%E1%BA%A5y,+H%C3%A0+N%E1%BB%99i" target="_blank" rel="noopener noreferrer" class="hover:text-teal-300 transition">
                                    204 Trần Duy Hưng, Yên Hòa, Cầu Giấy, Hà Nội
                                    <span class="block text-[11px] text-teal-300 underline mt-0.5">🗺️ Xem chỉ đường Google Maps &rarr;</span>
                                </a>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-teal-400">📞</span>
                                <div>
                                    <span>Hotline Đặt Hẹn:</span>
                                    <a href="tel:0775761388" class="font-bold text-white hover:text-teal-300 ml-1 tabular-nums">0775 761 388</a>
                                </div>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-teal-400">⏰</span>
                                <span class="tabular-nums">08:00 – 20:00 (Thứ 2 – Chủ Nhật)</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-teal-400">✉️</span>
                                <span>contact@nhakhoasmile.vn</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-heading-clinic font-bold text-white mb-4 uppercase tracking-wider text-xs">Đặt Lịch Khám Online</h4>
                        <p class="text-xs text-slate-400 leading-relaxed mb-4">
                            Đặt lịch trước để chủ động chọn Bác sĩ phụ trách, không cần chờ đợi tại quầy lễ tân.
                        </p>
                        <a href="{{ route('public.booking') }}" class="btn-press btn-shimmer btn-clinic-primary block w-full py-2.5 px-4 text-center text-xs rounded-xl">
                            📅 Đặt Lịch Khám Ngay
                        </a>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                    <p>&copy; {{ date('Y') }} Nha Khoa Smile. Hệ thống Quản lý Phòng khám Nha khoa Kỹ thuật số DCMS.</p>
                    <div class="flex items-center gap-5">
                        <a href="{{ route('patient.login') }}" class="text-teal-400 hover:underline font-semibold">🔐 Cổng Bệnh Nhân</a>
                        <button type="button" @click="legalModal = 'privacy'" class="hover:text-white transition">Chính sách bảo mật</button>
                        <button type="button" @click="legalModal = 'terms'" class="hover:text-white transition">Cam kết y khoa</button>
                    </div>
                </div>
            </div>

            <!-- Modal Chính sách (Clean White Medical Modal) -->
            <div x-show="legalModal !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" @keydown.escape.window="legalModal = null">
                <div @click.away="legalModal = null" class="bg-white text-slate-700 rounded-2xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200/40 max-h-[85vh] overflow-y-auto">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200/40 mb-4">
                        <h3 class="text-lg font-bold font-heading-clinic text-slate-900" x-text="legalModal === 'privacy' ? 'Chính Sách Bảo Mật Hồ Sơ Bệnh Án' : 'Cam Kết Chất Lượng Y Khoa - Nha Khoa Smile'"></h3>
                        <button type="button" @click="legalModal = null" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold flex items-center justify-center">✕</button>
                    </div>
                    <div x-show="legalModal === 'privacy'" class="space-y-3 text-xs text-slate-600 leading-relaxed">
                        <p><strong class="text-slate-900">1. Bảo mật hồ sơ y tế:</strong> Mọi thông tin bệnh án, phim X-Quang 3D CT ConeBeam và lịch sử điều trị đều được mã hóa và bảo mật theo tiêu chuẩn ngành y tế.</p>
                        <p><strong class="text-slate-900">2. Quyền riêng tư bệnh nhân:</strong> Thăm khám 1 bác sĩ : 1 ghế nha khoa riêng biệt, đảm bảo riêng tư và vô trùng tuyệt đối.</p>
                    </div>
                    <div x-show="legalModal === 'terms'" class="space-y-3 text-xs text-slate-600 leading-relaxed">
                        <p><strong class="text-slate-900">1. 100% Vật liệu nha khoa chính hãng:</strong> Trụ Implant Straumann Thụy Sĩ, sứ Emax Đức, khay Invisalign Hoa Kỳ có thẻ bảo hành chính hãng.</p>
                        <p><strong class="text-slate-900">2. Minh bạch chi phí:</strong> Bác sĩ tư vấn rõ phác đồ và đơn giá niêm yết trước khi thực hiện điều trị, không phát sinh chi phí ẩn.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-200/40 flex justify-end">
                        <button type="button" @click="legalModal = null" class="btn-press btn-clinic-primary px-5 py-2 rounded-xl text-xs">Đã hiểu</button>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Floating Quick Action Dock (Desktop/Tablet: Hotline + Back to Top) -->
        <div class="hidden sm:flex flex-col items-end gap-2.5 fixed bottom-6 right-6 z-40">
            <a href="tel:0775761388" class="group flex items-center gap-2 bg-white/95 backdrop-blur-md pl-3.5 pr-4 py-2.5 rounded-full shadow-lg shadow-teal-900/10 hover:shadow-xl hover:shadow-teal-700/20 transition-all hover:-translate-y-0.5 clinic-pulse" title="Gọi Hotline Phòng Khám 0775 761 388">
                <span class="w-8 h-8 rounded-full bg-teal-600 text-white flex items-center justify-center phone-ring-subtle shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </span>
                <span class="text-xs font-bold text-teal-900 tabular-nums">0775 761 388</span>
            </a>

            <button type="button" id="back-to-top" aria-label="Lên đầu trang"
                class="back-to-top-btn w-10 h-10 rounded-full bg-white/95 backdrop-blur-md text-slate-600 hover:bg-teal-600 hover:text-white shadow-lg shadow-slate-900/10 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 15l7-7 7 7"/></svg>
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const revealElements = document.querySelectorAll('.reveal-item, .reveal-scale');
                if ('IntersectionObserver' in window) {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('active');
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.08, rootMargin: '0px 0px -20px 0px' });
                    revealElements.forEach(el => observer.observe(el));
                } else {
                    revealElements.forEach(el => el.classList.add('active'));
                }

                // Animated Stat Counters ([data-count-to])
                const counters = document.querySelectorAll('[data-count-to]');
                if (counters.length && 'IntersectionObserver' in window) {
                    const countObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (!entry.isIntersecting) return;
                            const el = entry.target;
                            const target = parseInt(el.getAttribute('data-count-to'), 10);
                            const suffix = el.getAttribute('data-count-suffix') || '';
                            const duration = 1200;
                            const start = performance.now();
                            const step = (now) => {
                                const progress = Math.min(1, (now - start) / duration);
                                const eased = 1 - Math.pow(1 - progress, 4);
                                const current = Math.round(target * eased);
                                el.textContent = current.toLocaleString('vi-VN') + suffix;
                                if (progress < 1) requestAnimationFrame(step);
                            };
                            requestAnimationFrame(step);
                            countObserver.unobserve(el);
                        });
                    }, { threshold: 0.35 });
                    counters.forEach(c => countObserver.observe(c));
                }

                // Scroll Progress Bar, Sticky Header Elevation & Back to Top
                const progressBar = document.getElementById('scroll-progress');
                const navbar = document.getElementById('navbar');
                const backToTop = document.getElementById('back-to-top');
                const handleScroll = () => {
                    const scrollTop = window.scrollY || document.documentElement.scrollTop;
                    const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                    if (progressBar && docHeight > 0) {
                        progressBar.style.width = Math.min(100, (scrollTop / docHeight) * 100) + '%';
                    }
                    if (navbar) {
                        navbar.classList.toggle('navbar-scrolled', scrollTop > 24);
                    }
                    if (backToTop) {
                        backToTop.classList.toggle('visible', scrollTop > 380);
                    }
                };
                window.addEventListener('scroll', handleScroll, { passive: true });
                handleScroll();

                if (backToTop) {
                    backToTop.addEventListener('click', () => {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                }

                // Light / Dark Clinic Theme Toggle
                const syncThemeIcons = () => {
                    const isDark = document.documentElement.classList.contains('dark-clinic');
                    document.querySelectorAll('.theme-icon-moon').forEach(el => el.classList.toggle('hidden', isDark));
                    document.querySelectorAll('.theme-icon-sun').forEach(el => el.classList.toggle('hidden', !isDark));
                };
                syncThemeIcons();

                document.querySelectorAll('[data-theme-toggle]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const isDark = document.documentElement.classList.toggle('dark-clinic');
                        try {
                            localStorage.setItem('dcms_clinic_theme', isDark ? 'dark' : 'light');
                        } catch (e) {}
                        syncThemeIcons();
                    });
                });
            });
        </script>
        <x-dental-ai-chat />
        @stack('scripts')
    </body>
</html>
