<?php
session_start();
$order_id = rand(1000, 9999); // Generate a random order ID
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            overflow: hidden; /* Prevent scrolling */
            display: flex; /* Use flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full height */
        }
        
        .color-paper {
            position: absolute;
            width: 30px; /* Smaller width for small papers */
            height: 30px; /* Smaller height for small papers */
            animation: fall 5s linear infinite; /* Animation to fall */
            opacity: 0.8; /* Slight transparency */
        }

        @keyframes fall {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100vh); }
        }

        .confirmation-box {
            background-color: #28a745; /* Green color */
            color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            max-width: 400px; /* Limit the width */
            position: relative; /* Position relative for stacking */
            z-index: 1; /* Ensure it stays above the falling boxes */
        }

        .tick-icon {
            font-size: 40px; /* Bigger tick icon */
            margin-bottom: 15px; /* Space for better appearance */
        }
    </style>
</head>
<body>
     @include('navbar') <!-- Add your navbar here -->

<!-- Colorful falling boxes -->
<div id="color-papers-container"></div>

<div class="confirmation-box">
    <div class="tick-icon">&#10004;</div> <!-- Tick icon -->
    <h2>Congratulations!</h2>
    <p>Your order has been confirmed.</p>
    <p>Order ID: {{ $order_id }}</p> <!-- Display the dynamically passed order_id -->
</div>

<script>
    const colors = ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#FFDB33', '#33FFF8', '#F833FF']; // Array of colors
    const container = document.getElementById('color-papers-container');

    // Function to create and animate color papers
    function createColorPaper() {
        const colorPaper = document.createElement('div');
        colorPaper.className = 'color-paper';
        colorPaper.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)]; // Random color
        colorPaper.style.left = Math.random() * 100 + 'vw'; // Random horizontal position
        container.appendChild(colorPaper);

        // Remove the paper after the animation to prevent memory leaks
        setTimeout(() => {
            colorPaper.remove();
        }, 5000); // Match with animation duration
    }

    // Create color papers at intervals
    setInterval(createColorPaper, 300); // Create a paper every 300ms
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>