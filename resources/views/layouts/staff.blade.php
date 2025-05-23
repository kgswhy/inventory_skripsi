<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Staff Dashboard')</title>
    @vite('resources/css/app.css')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        @include('components.staff_sidebar')
        <div class="flex-1 flex flex-col">
            @include('components.staff_header')
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>
    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html> 