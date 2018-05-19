<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @yield('css')
</head>
<body class="h-full w-full bg-grey-light">
    <div id="app" class="h-full">
        <div class="container mx-auto h-full">
            <div class="flex items-center justify-center h-full w-full">
                @yield('content')
            </div>
        </div>
    </div>
    @yield('js')
</body>
</html>