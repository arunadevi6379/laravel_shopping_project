<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <style>
        /* Your styles here */
        
    body {
        font-family: Arial, sans-serif;
        background-image: url('{{ asset('downloadin.jpg') }}'); 

        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        width: 300px;
    }

    .signup-form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 15px;
        color: white;
    }

    label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
    }

    input:focus {
        border-color: #007bff;
    }

    .btn-primary {
        background-color: darkviolet;
        color: white;
        border: darkviolet;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        width:100%;
    }

    .btn-primary:hover {
        background-color: green;
    }

    h2 {
        text-align: center;
        color: white;
    }
    

    </style>
</head>
<body>

    <div class="container">
    <form action="{{ url('/signup') }}" method="POST">
    @csrf
    <h2>SIGN UP</h2>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="Enter your address" required>
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Your password" required>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
    </div>

    <button type="submit" class="btn-primary">Sign Up</button>
</form>

    </div>
</body>
</html>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
