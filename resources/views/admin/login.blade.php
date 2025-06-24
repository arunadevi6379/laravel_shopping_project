<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .background-image {
            background-image: url('{{ asset('downloade.jpg') }}');
            background-size: cover;
            background-position: center;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.8); /* White with some transparency */
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px); /* Blur effect */
            width: 250px; /* Set a fixed width for the form container */
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-button {
            width: 100%; /* Match the width of input fields */
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            background-color: green; /* Green button */
            color: white;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="background-image">
        <div class="form-container">
            <h1>Admin Login</h1>
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" placeholder="Email" required>
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="login-button">Login</button>
            </form>
            @if(session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif
        </div>
    </div>
</body>
</html>
