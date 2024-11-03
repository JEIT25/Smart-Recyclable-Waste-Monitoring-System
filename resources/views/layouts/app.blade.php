<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/pages/app/index.css') }}">
    @yield('css')
    @yield('scripts')
    <title>@yield('page-title')</title>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img src="{{ asset('images/logos/Cabadbaran_city_seal.png') }}" alt="Logo" class="logo-image">
                <div class="logo-text">
                    <p class="logo-text">CBR Smart Recyclable Waste</p>
                    <p class="logo-text">Monitoring System</p>
                </div>
            </div>
            <div class="login">
                <a href="/login" class="login-button">Login</a>
            </div>
        </div>
    </nav>

    <aside class="sidebar">
        <h2></h2>
        <ul>
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </aside>

    <main class="main-content">
        @yield('main-content')
    </main>

    @yield('other-scripts')
</body>

</html>
