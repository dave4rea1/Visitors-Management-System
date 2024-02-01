<!-- <?php require_once("Include/Styles.css"); ?>  -->
<?php require_once("Include/Session.php")?>
<?php require_once("Include/Functions.php")?>
<?php require_once("Include/DB.php"); ?>
<?php

// login page in bootstrap
if (isset($_POST["Submit"])) {
    // Initialize variables
   
    $Email = "";
    $Password = "";

    // Check if POST variables are set and assign them
    
    if (isset($_POST["Email"])) {
        $Email = mysqli_real_escape_string($Connection, $_POST["Email"]);
    }
    if (isset($_POST["Password"])) {
        $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    }
   
    // Validation checks
    if (empty($Email) || empty($Password)) {
        $_SESSION["message"] = "All fields must be filled out";
        Redirect_to("Login.php");
    } 
    else{
        if(ConfirmingAccountActiveStatus()){
             
        $Found_Account=Login_Attempt($Email,$Password);
        if($Found_Account){
            $_SESSION["User_Id"]=$Found_Account["id"];
            $_SESSION["Username"]=$Found_Account["username"];
            $_SESSION["Email"]=$Found_Account["email"];

            if (isset($_POST["remember"])) {
                $ExpireTime=time()+86400;
                setcookie("email",$Email,$ExpireTime);
                setcookie("password",$Password,$ExpireTime);
                setcookie("username",$Username,$ExpireTime);
            }
            Redirect_to("Profile.php");
        }
        else{
            $_SESSION["message"]="Invalid Email/Password";
            Redirect_to("Login.php");
        }
    } else{
        $_SESSION["message"]="Account Confirmation Required";
        Redirect_to("Login.php");
    }
    }

}




?>
<?php ?>

<!DOCTYPE html>

<html>
    <head>
        <title>Login</title> 
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="Include/Styles.css">
    </head>
    <body>
        <div>
        <?php echo Message(); ?>
        <?php echo SuccessMessage(); ?>
        </div>

        <!-- signup page in bootstrap -->
        <div>
        <form action="Login.php" method="post" >
            <div class="container" >
                <div class="row" >
                    <div class="col-sm-3" id="centerpage" >
                        <h1>Login</h1>
                        <p>Fill up the form with correct values.</p>
                        <hr class="mb-3">
                       

                        <label for="email"><b>Email Address</b></label>
                        <input class="form-control" id="email" type="email" name="Email" required>

                        <label for="password"><b>Password</b></label>
                        <input class="form-control" id="password" type="password" name="Password" required>

                        <hr class="mb-3">
                        <!-- don't have an account? signup -->
                        <p>Don't have an account? <a href="User_Registration.php">Sign Up</a></p>
                        <!-- remember me -->
                        <input type="checkbox" checked="checked" name="remember"> Remember me <br>
                        <!-- forgot password -->
                        <span class="psw">Forgot <a href="Recover_Account.php">password?</a></span>
                        <br><br>
                        
    
                        <input class="btn btn-primary" type="submit" id="register" name="Submit" value="Login">
                    </div>
                </div>
            </div>
        </form>

        </div>


</body>

</html>