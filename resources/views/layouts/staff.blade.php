<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Staff Dashboard')</title>
    @vite('resources/css/app.css')
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
    @stack('scripts')
</body>
</html> 