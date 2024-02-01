<?php
include('config.php');

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = $_POST['number'];
    $communication = $_POST['communication'];

    $insert = mysqli_query($conn, "INSERT INTO `contact_form`(name, email, number, communication) 
    VALUES('$name', '$email', '$number', '$communication')") or die('query failed');

    if($insert){
        $message[] = 'thank you for contacting us!';
        header('Location: thank_you_page.php');
        exit();
    } else {
        $message[] = 'contact failed';
    }
}
?>
