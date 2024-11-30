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
                @auth
                    <!-- Show Logout button if the user is authenticated -->
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="login-button">Logout</button>
                    </form>
                @else
                    <!-- Check if it's the login form -->
                    @if (isset($isLoginForm) && $isLoginForm)
                        <a href="{{ route('landing-page') }}" class="login-button">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="login-button">Login</a>
                    @endif
                @endauth

            </div>
        </div>
    </nav>
@auth
    @if (!isset($isHomePage) || !$isHomePage)
        <aside class="sidebar">
            <div class="user-info">
                <!-- Display User Image -->
                <div class="user-avatar">
                    <img src="{{ auth()->user()->profile_image ?? asset('images/logos/admin_logo.png') }}"
                        alt="User Avatar">
                </div>

                <!-- Display User Name -->
                <h2>{{ auth()->user()->fname }} {{ auth()->user()->lname }}</h2>
            </div>

            <!-- Navigation Links -->
            <ul>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="{{ route('waste-categories.create') }}">Add Waste and Category</a></li>
                <li><a href="{{ route('fact-waste-collections.create') }}">New Waste Collection</a></li>
            </ul>
        </aside>
    @endif
@endauth



    <main class="main-content">
        <!-- Success Modal -->
        @if (session('success'))
            <div class="modal-overlay" id="success-modal">
                <div class="modal-content">
                    <img src="{{ asset('images/logos/success.gif') }}" alt="Success" class="success-icon">
                    <p class="success-text">{{ session('success') }}</p>
                    <button class="close-button" onclick="closeModal()">Close</button>
                </div>
            </div>
        @endif
        @yield('main-content')
    </main>


    <footer class="footer">
        <div class="footer-container">
            <!-- Left Section: Logo and App Name -->
            <div class="footer-logo">
                <img src="{{ asset('images/logos/Cabadbaran_city_seal.png') }}" alt="Logo"
                    class="footer-logo-image">
                <span class="footer-app-name">CBR Smart Recyclable Waste Monitoring System</span>
            </div>

            <!-- Right Section: Copyright -->
            <div class="footer-copyright">
                © {{ date('Y') }} CBR Smart Recyclable Waste. All rights reserved.
            </div>
        </div>
    </footer>


    @yield('other-scripts')

    <script>
        function closeModal() {
            const modal = document.getElementById('success-modal');
            modal.style.display = 'none';
        }
    </script>

</body>

</html>
