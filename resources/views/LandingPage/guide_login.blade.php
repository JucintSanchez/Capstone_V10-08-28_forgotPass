@extends('LandingPage.layouts.layout')

@section('title', 'Registration Page')

@section('content')

@include('LandingPage.modals.regfailsuccessCSS')
    <style>
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
            background-color: rgba(255, 255, 255, 0.8); /* Adjust opacity for frosted effect */
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        }

        h2,h5 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
            font-family: 'Roboto', sans-serif;
        }

        p {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.row {
            display: flex;
            justify-content: space-between;
        }

        .form-group.row .form-control {
            width: 48%;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9); /* Adjust to match form background */
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #80cbc4;
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 12px 20px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            background-color: #059212;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #006600;
        }

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
            <h2>Registration</h2>
            <h5>Let's Get Started!</h5>
        <p>Please point out primary information to continue your registration</p>

        <form method="POST" action="{{ route('guidereg.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" required>
                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <input type="text" id="address" name="address" class="form-control" placeholder="Address" required>
                    @error('address')
                        <div class="alertmsg">* {{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group row">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    <input type="text" id="contact_num" name="contact_num" class="form-control" placeholder="Contact Number" required>
                </div>
                <div class="form-group">
                    <label for="proof" style="font-weight:bold; margin-bottom: 3px;">Proof of Residency</label>
                    <input type="file" id="proof" name="proof" class="form-control" required>
                    @error('proof')
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