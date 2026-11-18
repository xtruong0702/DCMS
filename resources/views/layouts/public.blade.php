<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Nha Khoa Smile - Chăm sóc răng miệng chuyên nghiệp')</title>

        <!-- Fonts chuẩn Tiếng Việt (Be Vietnam Pro & Inter) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts & Tailwind -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html, body, .font-sans, button, input, select, textarea {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                -webkit-font-smoothing: antialiased;
                line-height: 1.6;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Be Vietnam Pro', 'Inter', sans-serif !important;
                letter-spacing: -0.015em;
                line-height: 1.25 !important;
            }
            .glassmorphism {
                background: rgba(255, 255, 255, 0.94);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            }
        </style>
        @stack('styles')
    </head>
    <body class="antialiased bg-gray-50 text-gray-800 selection:bg-blue-500 selection:text-white flex flex-col min-h-screen">
        
        <!-- Header / Navigation -->
        <header class="fixed w-full z-50 glassmorphism transition-all duration-300 shadow-xs" id="navbar">
            <div class="h-1 w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3 cursor-pointer group">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 via-indigo-600 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl leading-none tracking-tight text-slate-900">Nha Khoa <span class="text-indigo-600">Smile</span></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mt-1">Chăm sóc nụ cười Việt</span>
                        </div>
                    </a>

                    <!-- Desktop Menu -->
                    <nav class="hidden md:flex items-center gap-1.5 lg:gap-2">
                        <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wide transition-colors {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-100/80' }}">Trang chủ</a>
                        
                        <!-- Dropdown Về chúng tôi -->
                        <div class="relative group">
                            <button class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wide transition-colors flex items-center gap-1 {{ request()->routeIs('public.about') || request()->routeIs('public.doctors') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 group-hover:text-indigo-600 group-hover:bg-slate-100/80' }}">
                                Giới thiệu <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute left-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200/80 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top scale-95 group-hover:scale-100 z-50">
                                <div class="relative bg-white z-10 flex flex-col py-2 rounded-2xl">
                                    <a href="{{ route('public.about') }}" class="px-4 py-2.5 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors flex items-center gap-2"><span>🏥</span> Giới thiệu Nha khoa Smile</a>
                                    <a href="{{ route('public.doctors') }}" class="px-4 py-2.5 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors flex items-center gap-2"><span>🩺</span> Đội ngũ Bác sĩ chuyên gia</a>
                                </div>
                            </div>
                        </div>

                        <!-- Dropdown Dịch vụ -->
                        <div class="relative group">
                            <button class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wide transition-colors flex items-center gap-1 {{ request()->routeIs('public.service*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 group-hover:text-indigo-600 group-hover:bg-slate-100/80' }}">
                                Dịch vụ <svg class="w-3.5 h-3.5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute left-0 top-full mt-2 w-64 bg-white rounded-2xl shadow-xl border border-slate-200/80 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top scale-95 group-hover:scale-100 z-50">
                                <div class="relative bg-white z-10 flex flex-col py-2 rounded-2xl">
                                    <a href="{{ route('public.services') }}" class="px-4 py-2 text-xs font-extrabold text-indigo-600 bg-indigo-50/50 hover:bg-indigo-100/70 transition-colors border-b border-slate-100">📋 Xem toàn bộ Dịch vụ & Bảng giá</a>
                                    <a href="{{ route('public.service.detail', 'implant-chuyen-sau') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">Trồng răng Implant chuyên sâu</a>
                                    <a href="{{ route('public.service.detail', 'rang-su-chuyen-sau') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">Răng sứ thẩm mỹ chuyên sâu</a>
                                    <a href="{{ route('public.service.detail', 'nieng-rang') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">Niềng răng thẩm mỹ</a>
                                    <a href="{{ route('public.service.detail', 'nho-rang-khon') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">Nhổ răng khôn không đau</a>
                                    <a href="{{ route('public.service.detail', 'tay-trang-rang') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">Tẩy trắng răng Laser</a>
                                    <a href="{{ route('public.service.detail', 'dieu-tri-tuy') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">Điều trị tủy răng</a>
                                    <a href="{{ route('public.service.detail', 'lay-cao-rang') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">Cạo vôi & Đánh bóng răng</a>
                                    <a href="{{ route('public.service.detail', 'tram-rang') }}" class="px-4 py-2 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">Trám răng thẩm mỹ</a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('public.knowledge') }}" class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wide transition-colors {{ request()->routeIs('public.knowledge') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-100/80' }}">Kiến thức</a>
                        <a href="{{ route('public.careers') }}" class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wide transition-colors {{ request()->routeIs('public.careers') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-100/80' }}">Tuyển dụng</a>
                        <a href="{{ route('public.contact') }}" class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wide transition-colors {{ request()->routeIs('public.contact') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-100/80' }}">Liên hệ</a>
                        <a href="{{ route('public.lookup') }}" class="px-3.5 py-2 rounded-xl text-xs font-extrabold uppercase tracking-wide transition-colors {{ request()->routeIs('public.lookup') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-700 hover:text-indigo-600 hover:bg-slate-100/80' }}">🔍 Tra cứu</a>
                    </nav>

                    <!-- Auth Links -->
                    <div class="hidden md:flex items-center gap-3">
                        @auth
                            @if(strtolower(auth()->user()->role->name ?? '') === 'patient')
                                <!-- Patient Dropdown -->
                                <div class="relative group">
                                    <button class="px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-50/80 hover:bg-white text-xs font-extrabold text-slate-700 hover:text-indigo-600 transition-all flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-[11px]">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                                        <span>{{ auth()->user()->name }}</span>
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div class="absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-200/80 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right scale-95 group-hover:scale-100 z-50">
                                        <div class="relative bg-white z-10 flex flex-col py-2 rounded-2xl">
                                            <a href="{{ route('patient.dashboard') }}" class="px-4 py-2.5 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">📊 Bảng điều khiển cá nhân</a>
                                            <a href="{{ route('patient.history') }}" class="px-4 py-2.5 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">📋 Lịch sử khám & Bệnh án</a>
                                            <a href="{{ route('patient.invoices') }}" class="px-4 py-2.5 text-xs font-bold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/70 transition-colors">🧾 Hóa đơn & VietQR</a>
                                            <div class="border-t border-slate-100 my-1"></div>
                                            <form method="POST" action="{{ route('patient.logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 transition-colors">🚪 Đăng xuất</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ url('/dashboard') }}" class="px-3.5 py-2 rounded-xl border border-indigo-200 bg-indigo-50/80 text-xs font-extrabold text-indigo-700 hover:bg-indigo-100 transition-colors">
                                    ⚙️ Bảng quản trị
                                </a>
                            @endif
                        @else
                            <a href="{{ route('patient.login') }}" class="px-3.5 py-2 rounded-xl text-xs font-extrabold text-slate-700 hover:text-indigo-600 hover:bg-slate-100 transition-colors">Đăng nhập</a>
                        @endauth
                        <a href="{{ route('public.booking') }}" class="bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-5 py-2.5 rounded-xl text-xs font-extrabold uppercase tracking-wide shadow-md shadow-indigo-500/25 transform hover:-translate-y-0.5 transition-all duration-200">
                            📅 Đặt lịch khám
                        </a>
                    </div>

                    <!-- Mobile Hamburger Button -->
                    <div class="flex sm:hidden items-center">
                        <button type="button" onclick="document.getElementById('publicMobileMenu').classList.toggle('hidden')" class="p-2 rounded-xl text-gray-700 hover:bg-gray-100 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Navigation Panel -->
                <div id="publicMobileMenu" class="hidden md:hidden pb-4 pt-2 border-t border-gray-100 space-y-1">
                    <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600">Trang chủ</a>
                    <a href="{{ route('public.about') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600">Giới thiệu Nha khoa Smile</a>
                    <a href="{{ route('public.doctors') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600">Đội ngũ Bác sĩ</a>
                    <a href="{{ route('public.services') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600">Dịch vụ & Bảng giá</a>
                    <a href="{{ route('public.knowledge') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600">Kiến thức nha khoa</a>
                    <a href="{{ route('public.careers') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600">Tuyển dụng</a>
                    <a href="{{ route('public.contact') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-600">Liên hệ</a>
                    <a href="{{ route('public.lookup') }}" class="block px-4 py-2 rounded-lg text-sm font-semibold text-indigo-700 bg-indigo-50/60 hover:bg-indigo-100">🔍 Tra cứu lịch hẹn & hóa đơn</a>
                    <a href="{{ route('public.booking') }}" class="block px-4 py-2.5 rounded-lg text-sm font-extrabold text-white bg-indigo-600 text-center">📅 Đặt lịch khám ngay</a>
                    <div class="pt-2 border-t border-gray-100 flex items-center justify-between px-4">
                        @auth
                            @if(strtolower(auth()->user()->role->name ?? '') === 'patient')
                                <a href="{{ route('patient.dashboard') }}" class="text-sm font-bold text-blue-600">Tài khoản: {{ auth()->user()->name }}</a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-blue-600">Vào hệ thống quản lý</a>
                            @endif
                        @else
                            <a href="{{ route('patient.login') }}" class="text-sm font-bold text-blue-600">Đăng nhập</a>
                            <a href="{{ route('patient.register') }}" class="text-sm font-semibold text-gray-600">Đăng ký</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow pt-20">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-400 py-12 mt-auto" x-data="{ legalModal: null }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-4 gap-8 mb-8 border-b border-slate-800 pb-8">
                    <div class="col-span-2 md:col-span-1">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4 group">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white font-bold group-hover:bg-blue-400 transition">NK</div>
                            <span class="font-bold text-xl text-white">Nha Khoa Smile</span>
                        </a>
                        <p class="text-sm mb-4">Hệ thống phòng khám nha khoa tiêu chuẩn quốc tế, mang lại nụ cười hoàn mỹ cho người Việt.</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('public.booking') }}" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition">📅 Đặt lịch</a>
                            <a href="{{ route('public.lookup') }}" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold border border-slate-700 transition">🔍 Tra cứu SĐT</a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Dịch Vụ Mũi Nhọn</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('public.service.detail', 'implant-chuyen-sau') }}" class="hover:text-blue-400 transition-colors">Trồng răng implant chuyên sâu</a></li>
                            <li><a href="{{ route('public.service.detail', 'rang-su-chuyen-sau') }}" class="hover:text-blue-400 transition-colors">Răng sứ thẩm mỹ chuyên sâu</a></li>
                            <li><a href="{{ route('public.service.detail', 'nieng-rang') }}" class="hover:text-blue-400 transition-colors">Niềng răng thẩm mỹ</a></li>
                            <li><a href="{{ route('public.service.detail', 'nho-rang-khon') }}" class="hover:text-blue-400 transition-colors">Nhổ răng khôn không đau</a></li>
                            <li><a href="{{ route('public.service.detail', 'tay-trang-rang') }}" class="hover:text-blue-400 transition-colors">Tẩy trắng răng Laser</a></li>
                            <li><a href="{{ route('public.services') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">→ Xem bảng giá đầy đủ</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Liên Hệ & Hỗ Trợ</h4>
                        <ul class="space-y-2.5 text-sm">
                            <li>
                                <a href="{{ route('public.contact') }}" class="hover:text-white transition-colors">📍 123 Đường Nguyễn Văn Cừ, Quận 5, TP.HCM</a>
                            </li>
                            <li>
                                <a href="tel:19001234" class="hover:text-emerald-400 transition-colors font-semibold">📞 Hotline: 1900 1234 (Bấm để gọi)</a>
                            </li>
                            <li>
                                <a href="mailto:cskh@nhakhoasmile.vn" class="hover:text-blue-400 transition-colors">✉️ Email: cskh@nhakhoasmile.vn</a>
                            </li>
                            <li>
                                <a href="{{ route('public.doctors') }}" class="hover:text-blue-400 transition-colors">👨‍⚕️ Đội ngũ Bác sĩ chuyên khoa</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Giờ Làm Việc</h4>
                        <ul class="space-y-2 text-sm">
                            <li>Thứ 2 - Chủ Nhật: 08:00 - 20:00</li>
                            <li class="text-xs text-slate-400">Khám trong ngày: Đến trực tiếp không cần đặt lịch trước</li>
                            <li class="pt-2">
                                <a href="{{ route('public.contact') }}" class="inline-flex items-center gap-1.5 text-blue-400 hover:text-blue-300 font-semibold">
                                    💬 Gửi câu hỏi tư vấn trực tuyến →
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-between items-center text-sm">
                    <p>&copy; {{ date('Y') }} Nha Khoa Smile. Hệ thống Quản lý Phòng khám Nha khoa (DCMS).</p>
                    <div class="space-x-5 mt-4 md:mt-0">
                        <button type="button" @click="legalModal = 'privacy'" class="hover:text-white transition-colors underline decoration-slate-700 underline-offset-4">Chính sách bảo mật</button>
                        <button type="button" @click="legalModal = 'terms'" class="hover:text-white transition-colors underline decoration-slate-700 underline-offset-4">Điều khoản sử dụng</button>
                    </div>
                </div>
            </div>

            <!-- Modal Chính sách bảo mật & Điều khoản sử dụng -->
            <div x-show="legalModal !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/75 backdrop-blur-xs" @keydown.escape.window="legalModal = null">
                <div @click.away="legalModal = null" class="bg-white text-slate-800 rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[85vh] overflow-y-auto">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                        <h3 class="text-xl font-black text-slate-900" x-text="legalModal === 'privacy' ? '🔒 Chính Sách Bảo Mật Thông Tin Bệnh Nhân' : '📋 Điều Khoản Sử Dụng Hệ Thống DCMS'"></h3>
                        <button type="button" @click="legalModal = null" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold flex items-center justify-center">✕</button>
                    </div>
                    <div x-show="legalModal === 'privacy'" class="space-y-3 text-sm text-slate-600 leading-relaxed">
                        <p><strong>1. Bảo mật hồ sơ bệnh án điện tử:</strong> Toàn bộ thông tin cá nhân, số điện thoại, lịch sử khám chữa bệnh, phim chụp X-quang và sơ đồ răng của quý khách được mã hóa và lưu trữ nội bộ theo quy định của Bộ Y Tế.</p>
                        <p><strong>2. Mục đích sử dụng thông tin:</strong> Số điện thoại và họ tên của quý khách chỉ được sử dụng để xác nhận lịch hẹn, nhắc lịch tái khám, tra cứu hóa đơn và bảo hành dịch vụ răng sứ / Implant.</p>
                        <p><strong>3. Cam kết không chia sẻ bên thứ ba:</strong> Nha Khoa Smile cam kết tuyệt đối không mua bán, trao đổi hoặc tiết lộ thông tin bệnh nhân cho bất kỳ tổ chức thứ ba nào.</p>
                    </div>
                    <div x-show="legalModal === 'terms'" class="space-y-3 text-sm text-slate-600 leading-relaxed">
                        <p><strong>1. Quy định đặt lịch hẹn trực tuyến:</strong> Hệ thống nhận đặt lịch hẹn trước từ ngày mai trở đi trong khung giờ 08:00 – 20:00. Đối với nhu cầu khám ngay trong ngày, quý khách vui lòng đến trực tiếp phòng khám để Lễ tân tiếp nhận vào hàng đợi.</p>
                        <p><strong>2. Minh bạch chi phí điều trị:</strong> Mọi dịch vụ khám, thủ thuật nha khoa và đơn thuốc kèm theo đều được niêm yết giá rõ ràng và thông báo trước khi thực hiện. Thuế GTGT (VAT) áp dụng theo mức chuẩn 10%.</p>
                        <p><strong>3. Chính sách bảo hành:</strong> Khách hàng thực hiện bọc răng sứ, trồng răng Implant được kích hoạt bảo hành điện tử theo đúng mã hồ sơ bệnh nhân (`BN...`).</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                        <button type="button" @click="legalModal = null" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-extrabold transition">Đã hiểu & Đóng</button>
                    </div>
                </div>
            </div>
        </footer>
        @stack('scripts')
    </body>
</html>
