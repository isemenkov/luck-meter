<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        @stack('scripts')
    </head>
    <body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-6 bg-gray-800 rounded-xl shadow-lg space-y-6">
            <h2 class="text-2xl font-bold text-center mb-6">@yield('title')</h2>
            @yield('content')
        </div>
    </body>
</html>
