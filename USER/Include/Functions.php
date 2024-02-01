<?php require_once("Include/DB.php"); ?>
<?php ?>

<?php

    function Redirect_to($New_Location) {
        // Check for any output
        if (ob_get_contents()) {
            ob_clean(); // Clean output buffer
        }

        // Perform the redirection
        header("Location: " . $New_Location);
        exit; // Terminate script execution
    }


    function Password_Encryption($password){
        $BlowFish_Hash_Format="$2y$10$";
        $Salt_Length=22;
        $salt=Generate_Salt($Salt_Length);
        $Formatting_Blowfish_With_Salt=$BlowFish_Hash_Format.$salt;
        $hash=crypt($password,$Formatting_Blowfish_With_Salt);
        return $hash;
    }

    function Generate_Salt($length){
        $Unique_Random_String=md5(uniqid(mt_rand(),true));
        $Base64_String=base64_encode($Unique_Random_String);
        $Modified_Base64_String=str_replace('+','.',$Base64_String);
        $salt=substr($Modified_Base64_String,0,$length);
        return $salt;
    }

    function Password_Check($password, $Existing_Hash){
        $hash=crypt($password,$Existing_Hash);
        if($hash === $Existing_Hash){
            return true;
        }else{
            return false;
        }
    }

 
    function CheckEmailExistsOrNot($Email){
        global $Connection;
        $Query="SELECT * FROM users WHERE email='$Email'";
        $Execute=mysqli_query($Connection,$Query);
        if(mysqli_num_rows($Execute)>0){
            return true;
        }else{
            return false;
        }

    }

    function Login_Attempt($Email,$Password){
        global $Connection;
        $Query="SELECT * FROM users WHERE email='$Email'";
        $Execute=mysqli_query($Connection,$Query);
        if($admin=mysqli_fetch_assoc($Execute)){
            if(Password_Check($Password,$admin["password"])){
                return $admin;
            }else{
                return null;
            }
        }
    }

    function ConfirmingAccountActiveStatus(){
        global $Connection;
        $Query="SELECT * FROM users WHERE active='ON'";
        $Execute=mysqli_query($Connection,$Query);
        if(mysqli_num_rows($Execute)>0){
            return true;
        }else{
            return false;
        }
    }
    
    function login(){
        if(isset($_SESSION["User_Id"]) || isset($_COOKIE["email"])){
            return true;
        }
    }

    function Confirm_Login(){
        if(!login()){
            $_SESSION["message"]="Login Required";
            Redirect_to("Login.php");
        }
    }

    

    
    
    
    
?> 