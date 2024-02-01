<?php
include('include/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="css/style.css"> 
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .thank-you-message {
            text-align: center;
        }

        .thank-you-message a {
            display: inline-block;
            margin-top: 20px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="thank-you-message">
            <h1>Thank You!</h1>
            <p>We have received your message and will get back to you soon.</p>
            <a href="index.php" class="link-btn">Go Back to Home</a>
        </div>
    </div>
</body>
</html>
