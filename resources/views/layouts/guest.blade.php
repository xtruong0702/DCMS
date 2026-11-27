<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Đăng nhập - Nha Khoa Smile') }}</title>

        <!-- Fonts chuẩn Tiếng Việt (Be Vietnam Pro cho tiêu đề & Inter cho nội dung) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=Inter:wght@400;500;600;700&subset=vietnamese&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            html, body, .font-sans, button, input, select, textarea {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
                font-size: 0.875rem;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                text-rendering: optimizeLegibility;
            }
            h1, h2, h3, h4 {
                font-family: 'Be Vietnam Pro', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
                font-weight: 700;
                letter-spacing: -0.015em;
            }
        </style>
    </head>
    <body class="font-sans text-slate-800 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-50 via-blue-50/40 to-cyan-50/50 px-4">
            <div class="w-full sm:max-w-md mt-4 px-8 py-8 bg-white shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors">
                    &larr; Quay về trang chủ Nha Khoa Smile
                </a>
            </div>
        </div>
    </body>
</html>
