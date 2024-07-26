<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
</head>
<body>
    <header>
        <h1>my laravel app</h1>
    </header>

    <nav>
        <ul>
            {{-- <li><a href="/home">home</a></li>
            <li><a href="/profile">profile</a></li>
            <li><a href="/about">about</a></li> --}}
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li><a href="{{ url('/profile') }}">Profile</a></li>
            <li><a href="{{ url('/about') }}">About</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2024 My Laravel App</p>
    </footer>


    
    @stack('scripts')

</body>
</html>
