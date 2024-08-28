@extends('LandingPage.layouts.layout')

@section('title', 'Registration Page')

@section('content')

@include('LandingPage.modals.regfailsuccessCSS')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap');

    /* Background and Container Styles */
    .background-container {
        background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/img/login.jpg');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .container {
        max-width: 500px;
        background-color: rgba(255, 255, 255, 0.7); /* Adjust opacity for frosted effect */
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
    }

    /* Typography and Header Styles */
    h2 {
        text-align: center;
        margin-bottom: 10px;
        color: #333;
        font-family: 'Roboto', sans-serif;
        font-size: 24px;
    }

    p {
        text-align: center;
        margin-bottom: 30px;
        color: #666;
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
    }

    /* Form Group and Input Styles */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-family: 'Roboto', sans-serif;
        color: #333;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="file"] {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ccc; /* Add border */
        border-radius: 5px;
        background-color: rgba(255, 255, 255, 0.9); /* Adjust opacity for input background */
        color: #333; /* Text color */
        transition: background-color 0.3s ease;
        font-family: 'Roboto', sans-serif; /* Apply Roboto font */
    }

    input[type="text"]::placeholder,
    input[type="password"]::placeholder,
    input[type="email"]::placeholder {
        font-family: 'Roboto', sans-serif; /* Apply Roboto font */
        color: #999; /* Placeholder color */
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="email"]:focus,
    input[type="file"]:focus {
        outline: none;
        background-color: rgba(255, 255, 255, 1); /* Adjust opacity for focused input background */
        border-color: #666; /* Change border color on focus */
    }

    /* Button Styles */
    .btn-primary {
        display: block;
        width: 100%;
        padding: 12px 20px;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        background-color: #059212; /* Button background color */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #006600; /* Darker background color on hover */
    }

    /* Alert Styles */
    .alertmsg {
        padding: 5px;
        border-radius: 5px;
        font-family: 'Roboto', sans-serif, italic;
        font-style: italic;
        font-size: 15px;
        color: red;
    }
</style>

<div class="background-container">
    <div class="container">
        <h2>Let's Get Started!</h2>
        <p>Please point out primary information to continue your registration</p>

        <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="text" id="org_name" name="org_name" class="form-control" placeholder="Organization Name" required>
                @error('org_name')
                    <div class="alertmsg">* {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" id="logo" name="logo" class="form-control">
                @error('logo')
                    <div class="alertmsg">* {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" id="address" name="address" class="form-control" placeholder="Address" required>
                @error('address')
                    <div class="alertmsg">* {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" id="email" name="email" class="form-control" placeholder="Email" required>
                @error('email')
                    <div class="alertmsg">* {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                @error('username')
                    <div class="alertmsg">* {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                @error('password')
                    <div class="alertmsg">* {{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <input type="checkbox" required> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        @if (Session::has('message'))
            <script>
                swal("Registered!", "{{Session::get('message')}}", "success")
                .then (function () {
                    window.location.href = '{{ route("login") }}';
                })      
            </script>
        @endif
    </div>
</div>

@endsection
