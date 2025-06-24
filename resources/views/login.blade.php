<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "toys");  // Database connection

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check for admin credentials
    if ($email === "admin@gmail.com" && $password === "admin") {
        header("Location: ui5.php"); // Redirect to the admin page
        exit();
    }

    // Check if the user exists in the database
    $sql = "SELECT * FROM page WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Compare plain text passwords
        if ($user['password'] == $password) {
            // If the account is not blocked
            if ($user['is_blocked']) {
                echo "<div class='error-message'>Your email ID is currently blocked by the admin.</div>";
            } else {
                // Store the username in session and redirect to the user dashboard
                $_SESSION['username'] = $user['username'];
                header("Location: ui4.php"); // Redirect to the user dashboard
                exit();
            }
        } else {
            echo "<div class='error-message'>Incorrect password.</div>";
        }
    } else {
        echo "<div class='error-message'>No user found with that email.</div>";
    }
    mysqli_close($conn);  // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background-image: url('downloade.jpg'); /* Adjust the path based on your project */
            background-size: cover;
            background-position: center;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 250px;
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
        .login-button, .signup-button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-button {
            background-color: green;
            color: white;
        }
        .signup-button {
            border: 2px solid blue;
            background-color: transparent;
            color: blue;
            margin-top: 10px;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .admin-login {
            position: absolute;
            top: 10px;
            right: 10px;
            color: blue;
            text-decoration: none;
            font-weight: bold;
        }
        .admin-login:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="background-image">
        <div class="form-container">
            <h1><i class="fas fa-key"></i>LOGIN</h1>
            <form method="POST" action="{{ route('login') }}">
            @csrf
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" placeholder="Email" required>
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="login-button">Login</button>
                <button type="button" class="signup-button" onclick="location.href='{{ route('signup.form') }}'">Sign Up</button>
            </form>
            <!-- Error message will appear here if login fails -->
        </div>
        <a href="{{ route('admin.login') }}" class="admin-login"><i class="fas fa-user"></i> Admin Login</a>
    </div>
</body>
</html>