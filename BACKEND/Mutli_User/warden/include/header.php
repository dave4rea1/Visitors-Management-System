<?php
session_start();
if (!isset($_SESSION["role"])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Test</title>
    
    <link rel="stylesheet" href="include/style.css">
</head>
<body>