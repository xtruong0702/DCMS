<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Nha Khoa Smile - Hệ thống Quản lý DCMS') }}</title>

        <!-- Fonts chuẩn Tiếng Việt (Be Vietnam Pro & Inter) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html, body, .font-sans, button, input, select, textarea {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                -webkit-font-smoothing: antialiased;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Be Vietnam Pro', 'Inter', sans-serif !important;
                letter-spacing: -0.01em;
            }
            .font-mono {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                font-variant-numeric: tabular-nums;
                letter-spacing: 0.01em;
            }
            /* Đồng bộ bảng biểu, thẻ và form trong toàn hệ thống theo chuẩn Stitch UI */
            main table th {
                font-weight: 700 !important;
                color: #64748b !important;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                font-size: 0.6875rem !important;
                background-color: #f8fafc !important;
            }
            main table td {
                color: #0f172a;
                line-height: 1.5;
            }
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
                font-size: 0.8125rem !important;
                line-height: 1.4 !important;
                background-color: #ffffff !important;
            }
            main input:focus, main select:focus, main textarea:focus {
                border-color: #0D7A68 !important;
                box-shadow: 0 0 0 3px rgba(13, 122, 104, 0.14) !important;
            }
            /* Stitch UI Buttons & Badges Helper */
            .btn-teal {
                background-color: #0D7A68 !important;
                color: #ffffff !important;
                border-radius: 0.75rem !important;
                font-weight: 700 !important;
                font-size: 0.75rem !important;
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
