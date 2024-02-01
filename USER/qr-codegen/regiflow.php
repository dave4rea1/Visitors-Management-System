<?php
session_start(); // Add session_start to start a session

include('libs/phpqrcode/qrlib.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sandbox";

$qrImageData = ''; // Define these variables outside the if block to ensure they are always available
$codeContents = '';

if (isset($_POST['submit'])) {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $inviteDate = $_POST['invite_date'];
    $visitorName = $_POST['visitor_name'];
    $visitorEmail = $_POST['visitor_email'];
    $visitorPhone = $_POST['visitor_phone'];
    $visitorID = $_POST['visitor_id'];
    $parkingReserved = isset($_POST['parking_reserved']) ? 1 : 0;

    // Generate the QR code and store it in a variable
    $codeContents = "Username: $username\nInvite Date: $inviteDate\nVisitor Name: $visitorName\nVisitor Email: $visitorEmail\nVisitor Phone: $visitorPhone\nVisitor ID: $visitorID\nParking Reserved: $parkingReserved";
    ob_start();
    QRcode::png($codeContents, null, QR_ECLEVEL_L, 5);
    $qrImageData = ob_get_contents();
    ob_end_clean();

    // Insert data into the database, including the QR code image
    $sql = "INSERT INTO invites (username, invite_date, visitor_name, visitor_email, visitor_phone, visitor_id, parking_reserved, qrcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssb", $username, $inviteDate, $visitorName, $visitorEmail, $visitorPhone, $visitorID, $parkingReserved, $qrImageData);
    $stmt->send_long_data(7, $qrImageData);

        // Send email with QR code as attachment
        if ($stmt->execute()) {
            echo "Data and QR code image inserted successfully.";

            // Send email with QR code as attachment
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'kingdayve07@gmail.com'; // Your SMTP username
                $mail->Password = 'npotmiobccoqvuvl'; // Your SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->setFrom('kingdayve07@gmail.com', 'Regiflow'); // Your email and name

                // Recipient
                $mail->addAddress($visitorEmail); // Email entered in the form

            // Attach the QR code as an image
            $qrImageFileName = 'qr-code.png';
            $mail->addStringAttachment($qrImageData, $qrImageFileName, 'base64', 'image/png', 'inline', 'qrcode' );
            
            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Invitation to Residence';
            $mail->Body = '<html>
            <head></head>
            <body>
            <h1>Invitation to Residence</h1>
            <p>Dear ' . $visitorName . ',</p>
            <p>You are invited to my residence on ' . $inviteDate . '. Below is the invitation details:</p>
            <ul>
            <li>Visit Date: ' . $inviteDate . '</li>
            <li>Visitor Name: ' . $visitorName . '</li>
            <li>Email: ' . $visitorEmail . '</li>
            <li>Phone Number: ' . $visitorPhone . '</li>
            <li>ID Number: ' . $visitorID . '</li>
            <li>Parking Reservation: ' . ($parkingReserved === 1 ? 'Yes' : 'No') . '</li>
            </ul>
            <p>Here is your QR code for entry:</p>

            <img src="cid:qr-code" alt="QR Code"> 

            <p>We look forward to seeing you at our residence.</p>
            <p>Best regards,<br>' . $username . '</p>
            </body>
            </html>';
                $mail->send();
                echo 'Email has been sent.';
            } catch (Exception $e) {
                echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
            }
        } else {
            echo "Error: " . $stmt->error;
        }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Quick Response (QR) Code Generator</title>
    <link rel="icon" href="img/favicon.ico" type="image/png">
    <link rel="stylesheet" href="libs/css/bootstrap.min.css">
    <link rel="stylesheet" href="libs/style.css">
    <script src="libs/navbarclock.js"></script>
</head>
<body onload="startTime()">
    <nav class="navbar-inverse" role="navigation">
        <div id="clockdate">
            <div class="clockdate-wrapper">
                <div id="clock"></div>
                <div id="date"><?php echo date('l, F j, Y'); ?></div>
            </div>
        </div>
    </nav>
    <div class="myoutput">
        <h3><strong>Quick Response (QR) Code Generator</strong></h3>
        <div class="input-field">
            <h3>Please Fill-out All Fields</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" style="width:20em;" placeholder="Enter your Username" required />
                    </div>
                    <div class="form-group">
                        <label>Invite Date</label>
                        <input type="date" class="form-control" name="invite_date" style="width:20em;" required />
                    </div>
                    <div class="form-group">
                        <label>Visitor Name</label>
                        <input type="text" class="form-control" name="visitor_name" style="width:20em;" placeholder="Enter Visitor's Name" required />
                    </div>
                    <div class="form-group">
                        <label>Visitor Email</label>
                        <input type="email" class="form-control" name="visitor_email" style="width:20em;" placeholder="Enter Visitor's Email" required />
                    </div>
                    <div class="form-group">
                        <label>Visitor Phone</label>
                        <input type="tel" class="form-control" name="visitor_phone" style="width:20em;" placeholder="Enter Visitor's Phone" required />
                    </div>
                    <div class="form-group">
                        <label>Visitor ID</label>
                        <input type="text" class="form-control" name="visitor_id" style="width:20em;" placeholder="Enter Visitor's ID" required />
                    </div>
                    <div class="form-group">
                        <label>Parking Reserved</label>
                        <input type="checkbox" name="parking_reserved" value="1" style="margin-left: 5px;" />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary submitBtn" style="width:20em; margin:0;" />
                    </div>
            </form>
        </div>
        <div class="qr-field">
            <h2 style="text-align:center">QR Code Result: </h2>
            <center>
                <div class="qrframe" style="border:2px solid black; width:210px; height:210px;">
                <?php
                   // Update this line to display the QR code with the plain text data
                   echo '<img src="data:image/png;base64,' . base64_encode($qrImageData) . '" style="width:200px; height:200px;" alt="' . $codeContents . '"><br>';
                   ?>
                    
                </div>
                <a class="btn btn-primary submitBtn" style="width:210px; margin:5px 0;" href="download.php?file=<?php echo $filename; ?>.png">Download QR Code</a>
            </center>
        </div>
    </div>
</body>
</html>


