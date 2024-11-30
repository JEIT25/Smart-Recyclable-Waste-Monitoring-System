@extends('layouts.app')

@section('css')
    <style>
        .main-content {
            margin-left: 0;
        }
        /* Login Container */
        .login-container {
            display: flex;
            height: 90vh;
            /* Full viewport height */
            background-color: #f9f9f9;
            color: #333;
        }

        /* Login Image Section */
        .login-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-image img {
            max-width: 100%;
            height: 100%;
            /* Ensure it covers the full height */
            object-fit: contain;
            /* Maintain aspect ratio */
            border-radius: 0;
            /* Optional: Remove the rounded edges if needed */
        }

        /* Login Form Section */
        .login-form {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #fff;
            border-radius: 0;
            /* Match the image styling */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Form Title */
        .form-title {
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            color: #000201;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Button */
        .btn-submit {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .login-image {
                height: 50%;
                /* Half height for smaller screens */
            }

            .login-image img {
                height: auto;
            }

            .login-form {
                flex: none;
                padding: 20px;
            }
        }
    </style>
@endsection

@section('main-content')
    <div class="login-container">
        <div class="login-image">
            <img src="{{ asset('images/covers/login_cover3.gif') }}" alt="Login Cover">
        </div>
        <div class="login-form">
            <h1 class="form-title">Login</h1>
            <form action="{{ route('login') }}" method="POST" class="modern-form">
                @csrf
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="error-message" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    @error('password')
                        <div class="error-message" style="color: red;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-group text-center">
                    <button type="submit" class="btn-submit">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
