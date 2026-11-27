<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Nha Khoa Smile - Hệ thống Quản lý DCMS') }}</title>

        <!-- Fonts chuẩn Tiếng Việt (Be Vietnam Pro cho tiêu đề & Inter cho nội dung/bảng biểu) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&family=Inter:wght@400;500;600;700&subset=vietnamese&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html, body, .font-sans, button, input, select, textarea {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
                font-size: 0.875rem; /* 14px chuẩn văn bản nội dung */
                font-weight: 400;
                line-height: 1.5;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                text-rendering: optimizeLegibility;
            }
            h1, .h1 {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
                font-size: 1.625rem !important; /* 26px (chuẩn 24px - 28px) */
                font-weight: 700 !important;
                line-height: 1.3 !important;
                letter-spacing: -0.02em;
                color: #0f172a;
            }
            h2, .h2 {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
                font-size: 1.125rem !important; /* 18px tiêu đề khối / card */
                font-weight: 600 !important;
                line-height: 1.35 !important;
                letter-spacing: -0.015em;
                color: #0f172a;
            }
            h3, .h3 {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
                font-size: 1rem !important; /* 16px tiêu đề card nhỏ */
                font-weight: 600 !important;
                line-height: 1.4 !important;
                letter-spacing: -0.01em;
                color: #0f172a;
            }
            h4, h5, h6 {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
                font-size: 0.875rem !important; /* 14px */
                font-weight: 600 !important;
                line-height: 1.4 !important;
            }
            /* Bảng biểu & Ô dữ liệu chuẩn 14px, nhãn 12px */
            main table th {
                font-family: 'Inter', sans-serif !important;
                font-weight: 700 !important;
                color: #64748b !important;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                font-size: 0.75rem !important; /* 12px nhãn bảng */
                background-color: #f8fafc !important;
                line-height: 1.4;
            }
            main table td {
                color: #0f172a;
                font-size: 0.875rem !important; /* 14px chuẩn ô bảng */
                font-weight: 400;
                line-height: 1.5;
            }
            /* Tabular Numbers cho toàn bộ số tiền, giờ khám, SĐT, thống kê */
            .tabular-nums,
            .font-mono,
            .price,
            .currency,
            .phone,
            .time,
            .date,
            .stat-number,
            .stat-value,
            .stat-count,
            main table td.text-right,
            main input[type="number"],
            main input[type="tel"],
            main input[type="time"],
            main input[type="date"],
            main input[type="datetime-local"] {
                font-variant-numeric: tabular-nums !important;
                font-feature-settings: "tnum" 1 !important;
            }
            /* Form inputs, selects, textareas đồng nhất 14px */
            main input[type="text"],
            main input[type="tel"],
            main input[type="email"],
            main input[type="number"],
            main input[type="date"],
            main input[type="time"],
            main input[type="datetime-local"],
            main select,
            main textarea {
                border-radius: 0.75rem !important;
                border-color: #e2e8f0 !important;
                font-size: 0.875rem !important; /* 14px */
                line-height: 1.45 !important;
                background-color: #ffffff !important;
                color: #0f172a;
            }
            main input:focus, main select:focus, main textarea:focus {
                border-color: #0D7A68 !important;
                box-shadow: 0 0 0 3px rgba(13, 122, 104, 0.14) !important;
            }
            /* Nhãn phụ & Badge chuẩn 12px font-weight 500-600 */
            .badge-sub,
            .text-sub,
            .label-sub {
                font-size: 0.75rem !important; /* 12px */
                font-weight: 600 !important;
                line-height: 1.25 !important;
            }
            /* Stitch UI Buttons & Badges Helper */
            .btn-teal {
                background-color: #0D7A68 !important;
                color: #ffffff !important;
                border-radius: 0.75rem !important;
                font-weight: 600 !important;
                font-size: 0.8125rem !important;
                padding: 0.5rem 1rem !important;
                display: inline-flex !important;
                align-items: center !important;
                gap: 0.375rem !important;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
                transition: all 150ms ease-in-out !important;
            }
            .btn-teal:hover {
                background-color: #0B6858 !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-800 bg-[#F8FAFC]">
        <div class="min-h-screen bg-[#F8FAFC] flex flex-col justify-between">
            <div>
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white border-b border-slate-200/80 shadow-xs">
                        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            <!-- Global Footer (Designed to match Stitch UI) -->
            <footer class="mt-12 border-t border-slate-200 bg-white py-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-2">
                    <div>
                        Nha Khoa Smile DCMS • Hệ thống Quản lý Nha khoa Thông minh & Điều phối tiếp đón
                    </div>
                    <div class="flex items-center gap-2">
                        <span>Phiên bản v2.4.0-stable</span>
                        <span>•</span>
                        <span class="inline-flex items-center gap-1.5 text-slate-600 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Hệ thống hoạt động bình thường
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
