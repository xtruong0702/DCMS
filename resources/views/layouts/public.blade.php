<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Nha Khoa Smile - Hệ Thống Chăm Sóc Răng Miệng Chuẩn Y Khoa')</title>

        <!-- Google Fonts: Playfair Display (Serif Luxury) & Plus Jakarta Sans (Modern Geometric Sans) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts & Tailwind -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --color-luxury-green: #063B30;
                --color-luxury-gold: #C5A880;
                --color-luxury-cream: #FBF9F5;
            }
            body, .font-sans-luxury {
                font-family: 'Plus Jakarta Sans', 'Be Vietnam Pro', -apple-system, BlinkMacSystemFont, sans-serif !important;
                -webkit-font-smoothing: antialiased;
                background-color: #FBF9F5;
                color: #1A2421;
            }
            .font-serif-luxury {
                font-family: 'Playfair Display', Georgia, serif !important;
                letter-spacing: -0.02em;
            }
            .glassmorphism-luxury {
                background: rgba(251, 249, 245, 0.94);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(197, 168, 128, 0.2);
            }
            .border-luxury-gold {
                border-color: rgba(197, 168, 128, 0.35);
            }
            .bg-luxury-green {
                background-color: #063B30;
            }
            .text-luxury-green {
                color: #063B30;
            }
            .text-luxury-gold {
                color: #A37F4E;
            }
        </style>
        @stack('styles')
    </head>
    <body class="antialiased selection:bg-[#063B30] selection:text-[#FBF9F5] flex flex-col min-h-screen pb-20 md:pb-0">
        
        <!-- Header / Navigation Bar -->
        <header class="fixed w-full z-50 glassmorphism-luxury transition-all duration-300 shadow-2xs" id="navbar">
            <div class="h-0.5 w-full bg-gradient-to-r from-[#C5A880]/20 via-[#063B30] to-[#C5A880]/20"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    
                    <!-- Logo / Brand Identity -->
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-[#063B30] rounded-xl flex items-center justify-center text-white shadow-sm shadow-[#063B30]/30 group-hover:scale-105 transition-transform border border-[#C5A880]/40">
                            <svg class="w-5 h-5 text-[#E6D5B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2l2.4 4.8 5.3.8-3.8 3.7.9 5.3-4.8-2.5-4.8 2.5.9-5.3-3.8-3.7 5.3-.8L12 2z"/>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-serif-luxury font-bold text-2xl tracking-tight text-[#063B30] leading-none">Nha Khoa Smile</span>
                            <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#A37F4E] mt-1">Hệ Thống Nha Khoa Kỹ Thuật Số DCMS</span>
                        </div>
                    </a>

                    <!-- Desktop Luxury Menu -->
                    <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
                        <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('home') ? 'bg-[#063B30] text-[#FBF9F5]' : 'text-[#1A2421] hover:text-[#063B30] hover:bg-white/80' }}">
                            Trang Chủ
                        </a>
                        
                        <!-- Dịch vụ mũi nhọn -->
                        <div class="relative group">
                            <a href="{{ route('public.services') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors flex items-center gap-1.5 {{ request()->routeIs('public.service*') ? 'bg-[#063B30] text-[#FBF9F5]' : 'text-[#1A2421] group-hover:text-[#063B30] group-hover:bg-white/80' }}">
                                <span>Dịch Vụ & Bảng Giá</span>
                                <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </a>
                            <div class="absolute left-0 top-full mt-2 w-72 bg-white rounded-2xl shadow-xl border border-[#EAE5DD] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top scale-95 group-hover:scale-100 z-50 p-2 space-y-1">
                                <a href="{{ route('public.services') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-[#063B30] bg-[#EBF4F0] block hover:bg-[#D9ECE4] transition">
                                    ✦ Xem Toàn Bộ Bảng Giá Niêm Yết
                                </a>
                                <a href="{{ route('public.service.detail', 'rang-su-chuyen-sau') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-[#063B30] hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Dán Sứ Veneer Emax</span>
                                    <span class="text-[10px] text-[#A37F4E] font-bold">Thụy Sĩ</span>
                                </a>
                                <a href="{{ route('public.service.detail', 'implant-chuyen-sau') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-[#063B30] hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Cấy Ghép Implant Straumann</span>
                                    <span class="text-[10px] text-[#A37F4E] font-bold">Thượng hạng</span>
                                </a>
                                <a href="{{ route('public.service.detail', 'nieng-rang') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-[#063B30] hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Niềng Răng Invisalign Diamond</span>
                                    <span class="text-[10px] text-emerald-700 font-bold">Hoa Kỳ</span>
                                </a>
                                <a href="{{ route('public.service.detail', 'tay-trang-rang') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-[#063B30] hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Tẩy Trắng Laser Whitening</span>
                                    <span class="text-[10px] text-amber-700 font-bold">-40%</span>
                                </a>
                                <a href="{{ route('public.service.detail', 'nho-rang-khon') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-[#063B30] hover:bg-slate-50 flex items-center justify-between transition">
                                    <span>Nhổ Răng Khôn Piezotome</span>
                                    <span class="text-[10px] text-slate-500">Êm ái</span>
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('public.doctors') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('public.doctors') ? 'bg-[#063B30] text-[#FBF9F5]' : 'text-[#1A2421] hover:text-[#063B30] hover:bg-white/80' }}">
                            Đội Ngũ Bác Sĩ
                        </a>
                        <a href="{{ route('public.about') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('public.about') ? 'bg-[#063B30] text-[#FBF9F5]' : 'text-[#1A2421] hover:text-[#063B30] hover:bg-white/80' }}">
                            Về Nha Khoa Smile
                        </a>
                        <a href="{{ route('public.lookup') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('public.lookup') ? 'bg-[#063B30] text-[#FBF9F5]' : 'text-[#1A2421] hover:text-[#063B30] hover:bg-white/80' }}">
                            Tra Cứu Lịch Hẹn
                        </a>
                        <a href="{{ route('public.contact') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition-colors {{ request()->routeIs('public.contact') ? 'bg-[#063B30] text-[#FBF9F5]' : 'text-[#1A2421] hover:text-[#063B30] hover:bg-white/80' }}">
                            Liên Hệ & Đón Tiếp
                        </a>
                    </nav>

                    <!-- Desktop Actions -->
                    <div class="hidden sm:flex items-center gap-3">
                        @auth
                            @if(strtolower(auth()->user()->role->name ?? '') === 'patient')
                                <div class="relative group">
                                    <button class="px-3.5 py-2 rounded-xl border border-[#EAE5DD] bg-white text-xs font-bold text-[#063B30] flex items-center gap-2 hover:border-[#063B30] transition shadow-2xs">
                                        <span class="w-6 h-6 rounded-lg bg-[#063B30] text-[#FBF9F5] flex items-center justify-center text-[10px]">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                                        <span>{{ auth()->user()->name }}</span>
                                    </button>
                                    <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-[#EAE5DD] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100 z-50 p-2 space-y-1">
                                        <a href="{{ route('patient.dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-[#063B30] hover:bg-[#EBF4F0] block transition">📊 Bảng điều khiển cá nhân</a>
                                        <a href="{{ route('patient.history') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-[#063B30] hover:bg-[#EBF4F0] block transition">📋 Lịch sử khám & Bệnh án</a>
                                        <a href="{{ route('patient.invoices') }}" class="px-3.5 py-2 rounded-xl text-xs font-medium text-slate-700 hover:text-[#063B30] hover:bg-[#EBF4F0] block transition">🧾 Hóa đơn & VietQR</a>
                                        <div class="border-t border-slate-100 my-1"></div>
                                        <form method="POST" action="{{ route('patient.logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-3.5 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition">🚪 Đăng xuất</button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ url('/dashboard') }}" class="px-3.5 py-2 rounded-xl border border-[#063B30]/30 bg-[#EBF4F0] text-xs font-bold text-[#063B30] hover:bg-[#D9ECE4] transition">
                                    ⚙️ Cổng Quản Trị
                                </a>
                            @endif
                        @else
                            <a href="{{ route('patient.login') }}" class="p-2 rounded-xl border border-[#EAE5DD] bg-white text-slate-700 hover:text-[#063B30] hover:border-[#063B30] transition flex items-center justify-center shadow-2xs" title="Đăng nhập tài khoản">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </a>
                        @endauth

                        <a href="{{ route('public.booking') }}" class="bg-[#063B30] hover:bg-[#042A22] text-[#FBF9F5] px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider shadow-sm transition flex items-center gap-2 border border-[#C5A880]/30">
                            <span>📅 Đặt Lịch Khám Online</span>
                        </a>
                    </div>

                    <!-- Mobile Right Icons (Bell & User) -->
                    <div class="flex sm:hidden items-center gap-2.5">
                        <a href="{{ route('public.lookup') }}" class="p-2 rounded-xl text-slate-700 hover:bg-white" title="Tra cứu lịch hẹn">
                            <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </a>
                        <a href="{{ route('patient.login') }}" class="w-8 h-8 rounded-full bg-[#063B30] text-[#E6D5B8] flex items-center justify-center font-bold text-xs shadow-2xs border border-[#C5A880]/40">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow pt-20">
            @yield('content')
        </main>

        <!-- Sticky Mobile Bottom Navigation Dock -->
        <div class="sm:hidden fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-md border-t border-[#EAE5DD] z-50 py-1.5 px-3 flex justify-around items-center shadow-lg">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 text-center py-1 px-2 {{ request()->routeIs('home') ? 'text-[#063B30] font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('home') ? 'text-[#063B30]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] tracking-tight">Trang Chủ</span>
            </a>

            <a href="{{ route('public.services') }}" class="flex flex-col items-center gap-0.5 text-center py-1 px-2 {{ request()->routeIs('public.service*') ? 'text-[#063B30] font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('public.service*') ? 'text-[#063B30]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span class="text-[10px] tracking-tight">Dịch Vụ</span>
            </a>

            <!-- Elevated Center Booking Button -->
            <a href="{{ route('public.booking') }}" class="-mt-4 flex flex-col items-center justify-center w-12 h-12 rounded-full bg-[#063B30] text-[#E6D5B8] shadow-md shadow-[#063B30]/40 border-2 border-[#C5A880]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </a>

            <a href="{{ route('public.doctors') }}" class="flex flex-col items-center gap-0.5 text-center py-1 px-2 {{ request()->routeIs('public.doctors') ? 'text-[#063B30] font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('public.doctors') ? 'text-[#063B30]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="text-[10px] tracking-tight">Bác Sĩ</span>
            </a>

            <a href="{{ route('public.lookup') }}" class="flex flex-col items-center gap-0.5 text-center py-1 px-2 {{ request()->routeIs('public.lookup') ? 'text-[#063B30] font-bold' : 'text-slate-500' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('public.lookup') ? 'text-[#063B30]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span class="text-[10px] tracking-tight">Tra Cứu</span>
            </a>
        </div>

        <!-- Luxury Clinic Footer -->
        <footer class="bg-[#04241D] text-slate-300 py-16 border-t border-[#C5A880]/30 mt-auto" x-data="{ legalModal: null }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12 border-b border-white/10 pb-12">
                    <div class="col-span-1 md:col-span-1 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#063B30] rounded-xl flex items-center justify-center text-white border border-[#C5A880]/50 shadow-sm">
                                <svg class="w-5 h-5 text-[#E6D5B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 2l2.4 4.8 5.3.8-3.8 3.7.9 5.3-4.8-2.5-4.8 2.5.9-5.3-3.8-3.7 5.3-.8L12 2z"/></svg>
                            </div>
                            <span class="font-serif-luxury font-bold text-2xl text-white">Nha Khoa Smile</span>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Hệ thống nha khoa kỹ thuật số hiện đại. Chăm sóc nụ cười chuẩn Y khoa với sơ đồ răng 32 răng chuẩn FDI, bác sĩ chuyên khoa giàu kinh nghiệm và thanh toán VietQR minh bạch.
                        </p>
                        <div class="pt-2">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#063B30] border border-[#C5A880]/40 text-[#E6D5B8] text-[11px] font-bold">
                                ✦ CHUẨN Y KHOA QUỐC TẾ
                            </span>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-serif-luxury text-base font-bold text-white mb-4 uppercase tracking-wider text-xs">Dịch Vụ Nổi Bật</h4>
                        <ul class="space-y-2.5 text-xs text-slate-300">
                            <li><a href="{{ route('public.service.detail', 'rang-su-chuyen-sau') }}" class="hover:text-[#E6D5B8] transition">Dán Sứ Veneer Emax Siêu Mỏng</a></li>
                            <li><a href="{{ route('public.service.detail', 'implant-chuyen-sau') }}" class="hover:text-[#E6D5B8] transition">Cấy Ghép Implant Straumann Thụy Sĩ</a></li>
                            <li><a href="{{ route('public.service.detail', 'nieng-rang') }}" class="hover:text-[#E6D5B8] transition">Niềng Răng Invisalign Diamond</a></li>
                            <li><a href="{{ route('public.service.detail', 'tay-trang-rang') }}" class="hover:text-[#E6D5B8] transition">Tẩy Trắng Răng Laser Whitening</a></li>
                            <li><a href="{{ route('public.service.detail', 'nho-rang-khon') }}" class="hover:text-[#E6D5B8] transition">Nhổ Răng Khôn Sóng Siêu Âm Piezotome</a></li>
                            <li><a href="{{ route('public.services') }}" class="text-[#C5A880] hover:underline font-bold inline-block pt-1">&rarr; Toàn bộ bảng giá niêm yết</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-serif-luxury text-base font-bold text-white mb-4 uppercase tracking-wider text-xs">Thông Tin Liên Hệ</h4>
                        <ul class="space-y-3 text-xs text-slate-300">
                            <li class="flex items-start gap-2.5">
                                <span class="text-[#C5A880] text-sm">📍</span>
                                <span>123 Đường Nguyễn Huệ, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-[#C5A880] text-sm">📞</span>
                                <div>
                                    <span class="text-slate-400">Hotline Tư Vấn & Hẹn Khám:</span>
                                    <a href="tel:19001234" class="font-bold text-white hover:text-[#C5A880] ml-1">1900 1234</a>
                                </div>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-[#C5A880] text-sm">⏰</span>
                                <span>08:00 – 20:00 (Thứ 2 – Chủ Nhật)</span>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <span class="text-[#C5A880] text-sm">✉️</span>
                                <span>contact@nhakhoasmile.vn</span>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-serif-luxury text-base font-bold text-white mb-4 uppercase tracking-wider text-xs">Đặt Lịch Nhanh Chóng</h4>
                        <p class="text-xs text-slate-300 leading-relaxed mb-4">
                            Đặt lịch trực tuyến trước để được chọn Bác sĩ phụ trách và ưu tiên vào khám đúng giờ không cần chờ đợi.
                        </p>
                        <a href="{{ route('public.booking') }}" class="block w-full py-2.5 px-4 bg-gradient-to-r from-[#C5A880] to-[#A37F4E] hover:from-[#D4AF37] hover:to-[#B39366] text-[#063B30] text-center font-bold text-xs uppercase tracking-wider rounded-xl shadow-sm transition">
                            Đặt Lịch Khám Online
                        </a>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 gap-4">
                    <p>&copy; {{ date('Y') }} Nha Khoa Smile. All rights reserved. Hệ thống Nha khoa Kỹ thuật số DCMS.</p>
                    <div class="flex items-center gap-5">
                        <a href="{{ route('patient.login') }}" class="text-[#C5A880] hover:underline font-bold">🔐 Cổng Bệnh Nhân</a>
                        <button type="button" @click="legalModal = 'privacy'" class="hover:text-white transition">Chính sách bảo mật</button>
                        <button type="button" @click="legalModal = 'terms'" class="hover:text-white transition">Cam kết dịch vụ</button>
                    </div>
                </div>
            </div>

            <!-- Modal Chính sách -->
            <div x-show="legalModal !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs" @keydown.escape.window="legalModal = null">
                <div @click.away="legalModal = null" class="bg-white text-slate-800 rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[85vh] overflow-y-auto">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <h3 class="text-xl font-bold font-serif-luxury text-[#063B30]" x-text="legalModal === 'privacy' ? '✦ Chính Sách Bảo Mật Hồ Sơ Bệnh Án' : '✦ Cam Kết Chất Lượng Dịch Vụ Nha Khoa Smile'"></h3>
                        <button type="button" @click="legalModal = null" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold flex items-center justify-center">✕</button>
                    </div>
                    <div x-show="legalModal === 'privacy'" class="space-y-3 text-xs text-slate-600 leading-relaxed">
                        <p><strong>1. Bảo mật tuyệt đối:</strong> Mọi hồ sơ bệnh án, hình ảnh nụ cười, phim 3D CT ConeBeam đều được bảo mật cấp độ cao nhất theo tiêu chuẩn y tế quốc tế.</p>
                        <p><strong>2. Quyền riêng tư:</strong> Khám và điều trị tại phòng VIP riêng biệt, không tiếp xúc chung, giữ trọn vẹn sự riêng tư cho thượng khách.</p>
                    </div>
                    <div x-show="legalModal === 'terms'" class="space-y-3 text-xs text-slate-600 leading-relaxed">
                        <p><strong>1. 100% Vật liệu chính hãng:</strong> Trụ Straumann Thụy Sĩ, sứ Emax Ivoclar Vivadent Đức, khay Invisalign Hoa Kỳ có thẻ bảo hành điện tử chính hãng toàn cầu.</p>
                        <p><strong>2. Bảo hành trọn đời:</strong> Đối với các dịch vụ thẩm mỹ răng sứ và cấy ghép Implant cao cấp.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                        <button type="button" @click="legalModal = null" class="px-5 py-2 rounded-xl bg-[#063B30] text-white text-xs font-bold transition">Đã hiểu</button>
                    </div>
                </div>
            </div>
        </footer>
        @stack('scripts')
    </body>
</html>
