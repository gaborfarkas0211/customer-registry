<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body>
<div class="page-wrap">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="javascript:void(0)">{{ config('app.name') }}</a>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</div>
</body>

@vite(['resources/js/app.js'])
@yield('script')
</html>
