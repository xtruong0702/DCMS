<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>403 Truy cập bị từ chối - Nha Khoa Smile</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700;800&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css'])
        <style>
            html, body, h1, h2, p, a { font-family: 'Be Vietnam Pro', sans-serif !important; }
        </style>
    </head>
    <body class="antialiased bg-gray-50 flex items-center justify-center min-h-screen text-slate-800">
        <div class="max-w-xl px-4 py-8 mx-auto text-center">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 text-yellow-600 rounded-full mb-8">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-6xl font-extrabold text-blue-600 mb-4 tracking-tight">403</h1>
            <p class="text-2xl font-bold mb-4">Truy cập bị từ chối!</p>
            <p class="text-gray-500 mb-8">Bạn không có quyền truy cập vào trang này. Vui lòng liên hệ Quản trị viên nếu bạn cho rằng đây là lỗi.</p>
            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full transition-colors duration-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Trở về Dashboard
            </a>
        </div>
    </body>
</html>
