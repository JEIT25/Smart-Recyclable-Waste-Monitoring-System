@extends('layouts.app')

@section('page-title', 'Home')

@section('main-content')
    <style>
        /* Ensure the parent container takes full height and width */
        .main-content {
            margin: 0;
            padding: 0;
            height: 100vh; /* Full viewport height */
            width: 100vw; /* Full viewport width */
        }

        .landing-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%; /* Full container height */
            padding: 2rem;
            background-color: #f9f9f9;
            box-sizing: border-box;
        }

        /* Left Section: Header Text */
        .header-text {
            flex: 1;
            padding: 2rem;
        }

        .header-text h1 {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 1rem;
        }

        .header-text p {
            font-size: 1.2rem;
            color: #333;
            line-height: 1.6;
        }

        .header-text .cta-button {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .header-text .cta-button:hover {
            background-color: #218838;
        }

        /* Right Section: Image */
        .landing-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .landing-image img {
            max-width: 100%;
            max-height: 90%;
            object-fit: contain;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .landing-container {
                flex-direction: column;
                text-align: center;
            }

            .header-text {
                padding: 1rem;
            }

            .header-text h1 {
                font-size: 2.5rem;
            }

            .header-text p {
                font-size: 1rem;
            }

            .landing-image {
                margin-top: 1.5rem;
            }

            .landing-image img {
                max-width: 80%;
                max-height: 50%;
            }
        }
    </style>

    <div class="landing-container">
        <!-- Left Section: Header Text -->
        <div class="header-text">
            <h1>Welcome to CBR Smart Recyclable Waste Monitoring System</h1>
            <p>
                Revolutionizing recycling with smarter waste monitoring solutions.
                Join us in creating a cleaner, greener future through innovative technology.
            </p>
            <a href="{{ route('login') }}" class="cta-button">Get Started</a>
        </div>

        <!-- Right Section: Image -->
        <div class="landing-image">
            <img src="{{ asset('images/covers/landing_page_cover.png') }}" alt="Landing Page Cover">
        </div>
    </div>
@endsection
