<?php
// validate_login.php

require_once "db.php";

$username = $_POST["username"];
$password = $_POST["password"];
$role = $_POST["role"];

$sql = "SELECT * FROM admin WHERE username='$username' AND password='$password' AND role='$role'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    session_start();
    $_SESSION["role"] = $role;

    // Define the dashboard directory for each role
    $dashboardDirectory = "";
    switch ($role) {
        case "admin":
            $dashboardDirectory = "admin/";
            break;
        case "security":
            $dashboardDirectory = "security/";
            break;
        case "warden":
            $dashboardDirectory = "warden/";
            break;
        default:
            // Handle invalid roles here
            break;
    }

    // Redirect to the appropriate dashboard
    header("Location: " . $dashboardDirectory . "dashboard.php");
} else {
    session_start();
    $_SESSION["error"] = "Login failed. Please check your credentials.";
    header("Location: login.php"); // Redirect back to the login form
}

$conn->close();
?>
