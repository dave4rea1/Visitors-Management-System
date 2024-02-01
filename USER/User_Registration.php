<!-- <?php require_once("Include/Styles.css"); ?>  -->
<?php require_once("Include/Session.php")?>
<?php require_once("Include/Functions.php")?>
<?php require_once("Include/DB.php"); ?>
<?php

if (isset($_POST["Submit"])) {
    // Initialize variables
    $Username = "";
    $Email = "";
    $Password = "";
    $ConfirmPassword = "";
    $Token = bin2hex(openssl_random_pseudo_bytes(40));

    // Check if POST variables are set and assign them
    if (isset($_POST["Username"])) {
        $Username = mysqli_real_escape_string($Connection, $_POST["Username"]);
    }
    if (isset($_POST["Email"])) {
        $Email = mysqli_real_escape_string($Connection, $_POST["Email"]);
    }
    if (isset($_POST["Password"])) {
        $Password = mysqli_real_escape_string($Connection, $_POST["Password"]);
    }
    if (isset($_POST["ConfirmPassword"])) {
        $ConfirmPassword = mysqli_real_escape_string($Connection, $_POST["ConfirmPassword"]);
    }

    // Validation checks
    if (empty($Username) || empty($Email) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION["message"] = "All fields must be filled out";
        Redirect_to("User_Registration.php");
    } elseif ($Password !== $ConfirmPassword) {
        $_SESSION["message"] = "Both passwords must match";
        Redirect_to("User_Registration.php");
    } 
     elseif (strlen($Password) < 4) {
        $_SESSION["message"] = "Password should be greater than 3 characters";
        Redirect_to("User_Registration.php");
   
    }  // check if email already exists
   elseif (CheckEmailExistsOrNot($Email)) {
        $_SESSION["message"] = "Email already exists";
        Redirect_to("User_Registration.php");
    }


    else {
        // Insert user data into the database
        global $ConnectingDB;
        $Hashed_Password = Password_Encryption($Password);
        $Query = "INSERT INTO users (username, email, password,token,active) 
                  VALUES ('$Username', '$Email', '$Hashed_Password', '$Token', 'OFF')";
        $Execute = mysqli_query($Connection, $Query);

        if ($Execute) {
            //send email to activate account
            
            $subject="Confirm Account";
            $body="Hello " .$Username. ",\n\nYou have successfully registered on our website. 
            Please click on the link below to activate your 
            account:\n\nhttp://localhost/visitapp/Activate.php?token=".$Token;
            $SenderEmail="From:kingdayve07@gmail.com";

            if (mail($Email, $subject, $body, $SenderEmail)) {
                $_SESSION["SuccessMessage"] = "Check your email for activation link";
                Redirect_to("Login.php");
            } else {
                $_SESSION["message"] = "Something went wrong. Try again!";
                Redirect_to("User_Registration.php");
            }


        } else {
            $_SESSION["message"] = "Something went wrong. Try again!";
            Redirect_to("User_Registration.php");
        }
    }
}


?>
<?php ?>

<!DOCTYPE html>

<html>
    <head>
        <title>Sign Up</title> 
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
        <form action="User_Registration.php" method="post" >
            <div class="container" >
                <div class="row" >
                    <div class="col-sm-3" id="centerpage" >
                        <h1>Sign Up</h1>
                        <p>Fill up the form with correct values.</p>
                        <hr class="mb-3">
                        <label for="username"><b>Username</b></label>
                        <input class="form-control" id="username" type="text" name="Username" required>

                        <label for="email"><b>Email Address</b></label>
                        <input class="form-control" id="email" type="email" name="Email" required>
                        <!-- <small class="text-muted">We'll never share your email with anyone else.</small>
                        <br> -->

                        <label for="password"><b>Password</b></label>
                        <input class="form-control" id="password" type="password" name="Password" required>

                        <label for="confirm_password"><b>Confirm Password</b></label>
                        <input class="form-control" id="confirm_password" type="password" name="ConfirmPassword" required>
                        <hr class="mb-3">
                        <!-- agree to terms and conditions -->
                        <input type="checkbox" name="checkbox" value="check" required> I agree to the 
                        <a href="Terms_and_Conditions.php">Terms and Conditions</a><br>
                        <!-- login link -->
                        <p>Already have an account? <a href="Login.php">Login</a></p>
    
                        <input class="btn btn-primary" type="submit" id="register" name="Submit" value="Sign Up">
                    </div>
                </div>
            </div>
        </form>

        </div>


</body>

</html>