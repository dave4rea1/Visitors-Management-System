<?php
session_start();
if (!isset($_SESSION['username']) && !isset($_SESSION['id'])) {
    include "login.php";
} else {
    header("Location: home.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Landing</title>

    <!-- Web page CSS -->
    <link rel="stylesheet" href="style.css" />
</head>

<body class="header">
<header class="header">
    <div class="brand-box">
        <span class="brand">Regiflow</span>
    </div>
    
    <div class="text-box">
        <h1 class="heading-primary">
            <span class="heading-primary-main">Welcome to the Visitor Management System</span>
            <span class="heading-primary-sub">If you are an admin, security personnel, or warden, please click the button below to log in:</span>
        </h1>
        <a href="login.php" class="btn btn-white btn-animated">Login</a>
    </div>
</header>


</body>
</html>
