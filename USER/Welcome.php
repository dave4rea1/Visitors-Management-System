<?php require_once("Include/Session.php") ?>
<?php require_once("Include/Functions.php") ?>
<?php Confirm_Login(); ?>
<!DOCTYPE html>

<html>
    <head>
        <title>Welcome</title> 
    </head>
    <body>
        <h1>Welcome</h1><hr>
       <?php 
       if (isset($_SESSION["User_Id"])) {
         echo "My ID is" .$_SESSION["User_Id"]. "with the 
         name of " .$_SESSION["Username"]. " and email of " 
         .$_SESSION["Email"]. "";   
        }
        if (isset($_COOKIE["email"])) {
            echo "My email is " .$_COOKIE["email"]. "";
        }
        if (isset($_COOKIE["username"])) {
            echo "My username is " .$_COOKIE["username"]. "";
        }

       ?>
       <br>
         <a href="Logout.php">Logout</a>
    </body>
</html>