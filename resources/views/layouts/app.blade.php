<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @yield('css')
</head>
<body>
    <div id="app">
        <div class="container mx-auto">
            <div class="flex items-center justify-center h-full-w-full">
                @yield('content')
            </div>
        </div>
    </div>
    @yield('js')
</body>
</html>