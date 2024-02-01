<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />

    <style>
        .error-message {
            color: red; /* Set the text color to red */
        }
    </style>
</head>
<body class="header">

<div class="login-container"> <!-- Container for the login form -->
    <form method="post" action="validate_login.php">

        <h3>Login Here</h3>
         <!--- Error Message --->
         <?php

        if (isset($_SESSION["error"])) {
            echo '<div class="error-message">';
            echo $_SESSION["error"];
            echo '</div>';
            unset($_SESSION["error"]); // Clear the error message
        }
        ?>

        <label for="username">Username</label>
        <input type="text" placeholder="Username" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password" required>

        <label for="role">Select Role:</label>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="security">Security Personnel</option>
            <option value="warden">Warden</option>
        </select>

        <button type="submit">Log In</button>
        
    </form>
</div> <!-- Close the container -->
</body>
</html>
