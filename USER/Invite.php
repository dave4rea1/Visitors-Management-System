<?php require_once("Include/Session.php") ?>
<?php require_once("Include/Functions.php") ?>
<?php require_once("Include/DB.php"); ?>
<?php Confirm_Login(); ?>

<?php 
include('qr-codegen/libs/phpqrcode/qrlib.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Include/PHPMailer/src/Exception.php';
require 'Include/PHPMailer/src/PHPMailer.php';
require 'Include/PHPMailer/src/SMTP.php';

if (isset($_POST["Submit"])) {
    // Establish the database connection (already loaded in DB.php)
    global $Connection;
    
    $Username = $_SESSION["Username"];
    $InviteDate = mysqli_real_escape_string($Connection, $_POST["date"]);
    $VisitorName = mysqli_real_escape_string($Connection, $_POST["name"]);
    $VisitorEmail = mysqli_real_escape_string($Connection, $_POST["email"]);
    $VisitorPhone = mysqli_real_escape_string($Connection, $_POST["phone"]);
    $VisitorID = mysqli_real_escape_string($Connection, $_POST["id-number"]);
    $ReasonForVisit = mysqli_real_escape_string($Connection, $_POST["reason"]); 
    $Parking = isset($_POST["parking-toggle"]) ? "Yes" : "No";

    // Generate the QR code and store it in a variable
    $codeContents = $Username . "\n" . $InviteDate . "\n" . $VisitorName . "\n" . $VisitorEmail . "\n"
                    . $VisitorPhone . "\n" . $VisitorID . "\n" . $ReasonForVisit . "\n" . $Parking;
    ob_start();
    QRcode::png($codeContents, null, QR_ECLEVEL_L, 5);
    $qrImageData = ob_get_contents();
    ob_end_clean();

    // sql to insert details into database
    $sql = "INSERT INTO invites (username, invite_date, visitor_name, visitor_email, visitor_phone, visitor_id, reason, parking_reserved, qrcode) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $Connection->prepare($sql);
    $stmt->bind_param("ssssssssb", $Username, $InviteDate, $VisitorName, $VisitorEmail, $VisitorPhone, $VisitorID, $ReasonForVisit, $Parking, $qrImageData);
    $stmt->send_long_data(8, $qrImageData);


    if ($stmt->execute()) {
        $_SESSION["SuccessMessage"] = "Invite sent successfully";

        // Send email with QR code as an attachment
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'Phantoms1514@gmail.com'; // Your SMTP username
            $mail->Password = 'zgieuflnofzvnvhz'; // Your SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender
            $mail->setFrom('Phantoms1514@gmail.com', 'Regiflow'); 

            // Recipient
            $mail->addAddress($VisitorEmail); // Email entered in the form

            // Attach the QR code as an image
            $qrImageFileName = 'qr-code.png';
            $mail->addStringAttachment($qrImageData, $qrImageFileName, 'base64', 'image/png', 'inline', 'qrcode');
            
            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Invitation to Residence';
            $mail->Body = '<html>
            <head></head>
            <body>
                <h1>Invitation to Residence</h1>
                <p>Dear ' . $VisitorName . ',</p>
                <p>You are invited to my residence on ' . $InviteDate . '. Below is the invitation details:</p>
                <ul>
                    <li>Visit Date: ' . $InviteDate . '</li>
                    <li>Visitor Name: ' . $VisitorName . '</li>
                    <li>Email: ' . $VisitorEmail . '</li>
                    <li>Phone Number: ' . $VisitorPhone . '</li>
                    <li>ID Number: ' . $VisitorID . '</li>
                    <li>Reason for visit: ' . $ReasonForVisit . '</li>
                    <li>Parking Reservation: ' . ($Parking === 1 ? 'Yes' : 'No') . '</li>
                </ul>
                <p>Here is your QR code for entry:</p>
                <img src="cid:qr-code" alt="QR Code">
                <p>Do not forget to come along with your physical ID card for verification.</p>
                <p>We look forward to seeing you at our residence.</p>
                <p>Best regards,<br>' . $Username . '</p>
            </body>
            </html>';

            $mail->send();
            echo 'Email has been sent.';
        } catch (Exception $e) {
            echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
        }
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try again!";
    }

    // Redirect back to the invite page or any other page
    header("Location: Invite.php");
    exit(); // Ensure no further code execution
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Include/Styles_Profile.css">
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <link rel="stylesheet" href="Include/Styles.css">
    <script src="javascript/Functions.js"></script>
    <!-- <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script> -->

    <!-- <script src="javascript/qrcode.min.js"></script> -->

    <title>Invite</title>

<style>
              /* Reset some default styles */
        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        /* Apply a background color to the entire page */
        body {
          background-color: #f5f5f5; 
          /* You can change this color */
          font-family: Arial, sans-serif;
        }

        /* Center the form vertically and horizontally */
        .center-content {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh; /* This ensures the form takes up the full viewport height */
        }

        /* Style the form */
        .invite-form {
          background-color: #fff; /* Background color for the form */
          padding: 20px;
          border-radius: 5px;
          box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow */
          max-width: 400px; /* Adjust this width as needed */
          width: 100%;
          text-align: center;
        }

        /* Style form labels */
        label {
          display: block;
          margin-bottom: 8px;
          font-weight: bold;
        }

        /* Style form inputs and select dropdown */
        input[type="date"],
        input[type="time"],
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            box-sizing: border-box; /* to make sure padding and border are included in the width */
            -webkit-appearance: none; /* Removes default styling on iOS */
            -moz-appearance: none; /* Removes default styling on Firefox */
            appearance: none; /* Removes default arrow icon in some browsers */
        }

        /* Optional: add an arrow icon with CSS */
        select {
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="14" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            background-size: 14px 12px;
        }

        /* Style for select dropdown when user clicks on it */
        select:focus {
            outline: none;
            border-color: #777;
        }

        /* Style for the submit button */
        .submit-button {
          background-color: #007bff; /* Button background color */
          color: #fff; /* Button text color */
          padding: 10px 20px; /* Button padding */
          border: none; /* Remove button border */
          border-radius: 5px; /* Add border radius */
          cursor: pointer; /* Add pointer cursor */
          width: 100%;

          /* Add a transition for smooth hover effect */
          transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* Hover effect for the submit button */
        .submit-button:hover {
          background-color: #0056b3; /* New background color on hover */
          transform: scale(1.05); /* Scale the button slightly on hover */
          box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); /* Add a subtle shadow on hover */
        }

        /* Focus effect for the submit button */
        .submit-button:focus {
          outline: none; /* Remove the default focus outline */
          box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); /* Add a subtle shadow on focus */
        }

        /* Style for the toggle switch container */
        .toggle-switch {
          display: flex;
          align-items: center;
        }

        /* Hide the default checkbox input */
        .toggle-checkbox {
          display: none;
        }

        /* Style for the toggle switch label */
        .toggle-label {
          width: 40px; /* Width of the switch track */
          height: 20px; /* Height of the switch track */
          background-color: #ccc; /* Default background color of the switch track */
          border-radius: 10px; /* Rounded corners of the switch track */
          position: relative;
          margin-right: 10px; /* Spacing between the switch and label text */
          cursor: pointer;
        }

        /* Style for the toggle switch indicator */
        .toggle-label::before {
          content: "";
          width: 20px; /* Width of the switch indicator */
          height: 20px; /* Height of the switch indicator */
          background-color: #fff; /* Default background color of the indicator */
          border-radius: 50%; /* Make it a circle */
          position: absolute;
          left: 0;
          transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
        }

        /* Style for the label text container */
        .toggle-text {
          display: flex;
          align-items: center;
          font-weight: bold;
        }

        /* Style for the "Reserve Parking" label */
        .reserve-label {
          display: inline;
          transition: opacity 0.2s ease-in-out; /* Add opacity transition */
        }

        /* Style for the "Parking Reserved" label */
        .reserved-label {
          display: none;
          transition: opacity 0.2s ease-in-out; /* Add opacity transition */
        }

        /* When the checkbox is checked, change the background color and move the indicator */
        .toggle-checkbox:checked + .toggle-label::before {
          left: 50%; /* Move the indicator to the right */
          transform: translateX(-50%);
          background-color: #007bff; /* Change the background color when checked */
        }

        /* When the checkbox is checked, hide the "Reserve Parking" label and show "Parking Reserved" */
        .toggle-checkbox:checked + .toggle-label + .toggle-text .reserve-label {
          opacity: 0;
          display: none;
        }

        .toggle-checkbox:checked + .toggle-label + .toggle-text .reserved-label {
          opacity: 1;
          display: inline;
        }

        /* hide qrcode */
        .qrcode {
        display: none;
    }

    </style>


</head>
<body>

       <div>
        <?php echo Message(); ?>
        <?php echo SuccessMessage(); ?>
        </div>
    <!-- user profile page in bootstrap -->
    <!-- code for sidebar -->
    <!-- partial:index.partial.html -->
<div id="nav-bar">
    <input id="nav-toggle" type="checkbox"/>
    <div id="nav-header"><a id="nav-title" href="#" target="_blank">RegiFlow</a>
      <label for="nav-toggle"><span id="nav-toggle-burger"></span></label>
      <hr/>
    </div>
    <div id="nav-content">
      <!-- <div class="nav-button"><i class="fas fa-palette"></i><span>Create Invite</span></div> -->
      <div  class="nav-button">
      <a href="Profile.php">
          <i class="fas fa-palette"></i><span>Create Invite</span>
      </a>
  </div>

      <!-- <div class="nav-button"><i class="fas fa-images"></i><span>Update Profile</span></div> -->
      <div class="nav-button">
      <a href="Update_Profile.php">
          <i class="fas fa-images"></i><span>Update Profile</span>
      </a>
    </div>

      <div class="nav-button">
        <a href="Dashboard.php">
            <i class="fas fa-thumbtack"></i><span>Dashboard</span>
        </a>
    </div>

      <hr/>
      <div class="nav-button">
        <a href="Messages.php">
            <i class="fas fa-envelope"></i><span>Messages</span>
        </a>
   </div>

   <div class="nav-button">
      <a href="Recents.php">
          <i class="fas fa-fire"></i><span>Recent Invites</span>
      </a>
   </div>

      <!-- <div class="nav-button"><i class="fas fa-magic"></i><span>Spark</span></div>
      <hr/>
      <div class="nav-button"><i class="fas fa-gem"></i><span> Pro</span></div>
      <div id="nav-content-highlight"></div> -->
    </div>
    <input id="nav-footer-toggle" type="checkbox"/>
    <div id="nav-footer">
      <div id="nav-footer-heading">
        <div id="nav-footer-avatar"><img src="https://st3.depositphotos.com/19428878/36416/v/450/depositphotos_364169666-stock-illustration-default-avatar-profile-icon-vector.jpg"/></div>
        <div id="nav-footer-titlebox"><a id="nav-footer-title" href="Profile.php" 
        ><?php 

        if (isset($_SESSION["User_Id"])) {
          echo $_SESSION["Username"];   
        }
        
        ?></a><span id="nav-footer-subtitle">User</span></div>
        <label for="nav-footer-toggle"><i class="fas fa-caret-up"></i></label>
      </div>
      <div id="nav-footer-content">
          <Lorem>Thanks for using our platform.</Lorem>
        <div class="nav-button">
            <a href="Logout.php">
                <i class="fas fa-heart"></i><span>Logout</span>
            </a>
        </div>

      </div>
    </div>
</div>
<!-- partial -->

<!-- page content using bootsrap-->

<!-- Centered form -->
<div id="content-invite" class="center-content">

<div id="qrcode" class="qrcode"></div>

<form method="post" class="invite-form" id="qr-form" onsubmit="return validateForm()">
    <h1>Let's Invite Someone</h1>
    <label for="date">Invite Date</label>
    <input type="date" id="date" name="date" required>

    <div class="visitor-details">
        <label for="name">Visitor Name</label>
        <input type="text" id="name" name="name" placeholder="Name & Surname" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required>

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" placeholder="Phone Number" required>

        <label for="id-number">ID Number</label>
        <input type="text" id="id-number" name="id-number" placeholder="Enter ID Number" required>

        <label for="reason">Reason for Visit</label>
        <select id="reason" name="reason" required>
            <option value="">--Please choose an option--</option>
            <option value="study">Study</option>
            <option value="social">Social</option>
            <option value="family">Family</option>
        </select>
    </div>

    <div class="toggle-switch">
        <input type="checkbox" id="parking-toggle" class="toggle-checkbox">
        <label for="parking-toggle" class="toggle-label"></label>
        <span class="toggle-text">
            <span class="reserve-label">Reserve Parking</span>
            <span class="reserved-label">Parking Reserved</span>
        </span>
    </div>

    <br>

    <input type="hidden" id="qr-code-data" name="qr-code-data" value="">
    <!-- <img id="qrcode-img" src="" alt="QR Code"> -->

    <input type="submit" name="Submit" value="Send Invite" class="submit-button">
</form>

</div>

<script>
    // validate id form
    function validateForm() {
        const idNumber = document.getElementById('id-number').value;
        if (!isValidSouthAfricanID(idNumber)) {
            alert('Invalid South African ID number.');
            return false;
        }
        return true;
    }
</script>

</body>

</html>


