<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <style>
        body {
            font-family: sans-serif;
            background: #f7fafc;
            text-align: center;
            padding-top: 100px;
        }
    </style>
</head>
<body>
    <h1>Laravel</h1>

    @if (Route::has('login'))
        <div>
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a> |
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    @endif
</body>
</html>
