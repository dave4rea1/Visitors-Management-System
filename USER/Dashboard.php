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

 
if (isset($_POST['invite_again_id'])) {
  $inviteID = $_POST['invite_again_id'];
  $stmt = $Connection->prepare("SELECT * FROM invites WHERE invite_id = ?");
  $stmt->bind_param("i", $inviteID);
  $stmt->execute();
  $inviteDetails = $stmt->get_result()->fetch_assoc();
  $stmt->close();

  if ($inviteDetails) {
      $Username = $_SESSION["Username"];
      $InviteDate = $inviteDetails['invite_date'];
      $VisitorName = $inviteDetails['visitor_name'];
      $VisitorEmail = $inviteDetails['visitor_email'];
      $VisitorPhone = $inviteDetails['visitor_phone'];
      $VisitorID = $inviteDetails['visitor_id'];
      $Parking = $inviteDetails['parking_reserved'];

      // Prepare the QR code content from the invite details
      $codeContents = $Username . "\n" . $InviteDate . "\n" . $VisitorName . "\n" . $VisitorEmail . "\n"
      . $VisitorPhone . "\n" . $VisitorID . "\n" . $Parking;
      ob_start();
      QRcode::png($codeContents, null, QR_ECLEVEL_L, 5);
      $qrImageData = ob_get_contents();
      ob_end_clean();

      // Set up PHPMailer and send the email
      $mail = new PHPMailer(true);
      try {
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'kingdayve07@gmail.com';
          $mail->Password = 'npotmiobccoqvuvl';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
          $mail->Port = 465;

          $mail->setFrom('kingdayve07@gmail.com', 'Regiflow');
          $mail->addAddress($VisitorEmail);
          $mail->addStringAttachment($qrImageData, 'qr-code.png', 'base64', 'image/png');
          $mail->isHTML(true);
          $mail->Subject = 'Your Invitation to Residence';
          $mail->Body = "<html><body><h1>Invitation to Residence</h1><p>Dear " . htmlspecialchars($VisitorName) . ",</p><p>You are invited to my residence on " . htmlspecialchars($InviteDate) . ". Below is the invitation details:</p><ul><li>Visit Date: " . htmlspecialchars($InviteDate) . "</li><li>Visitor Name: " . htmlspecialchars($VisitorName) . "</li><li>Email: " . htmlspecialchars($VisitorEmail) . "</li><li>Phone Number: " . htmlspecialchars($VisitorPhone) . "</li><li>ID Number: " . htmlspecialchars($VisitorID) . "</li><li>Parking Reservation: " . htmlspecialchars($Parking) . "</li></ul><p>Here is your QR code for entry:</p><img src='cid:qr-code' alt='QR Code'><p>We look forward to seeing you at our residence.</p><p>Best regards,<br>" . htmlspecialchars($Username) . "</p></body></html>";

          $mail->send();
          $_SESSION["SuccessMessage"] = "Invite sent successfully again.";
      } catch (Exception $e) {
          $_SESSION["ErrorMessage"] = "Failed to send the invite again. Error: " . $mail->ErrorInfo;
      }
  } else {
      $_SESSION["ErrorMessage"] = "Invite not found.";
  }

  header("Location: Dashboard.php");
  exit();
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
    <title>Dashboard</title>

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
        font-family: Arial, sans-serif;
        color: #333;
      }

      /* Sidebar and main content layout */
      /* #nav-bar {
        position: fixed;
        width: 250px;
        height: 100%;
        background: #342b4e;
        color: white;
      } */

      #dashboard-content {
        margin-left: 250px; /* Same as sidebar width */
        padding: 20px;
        min-height: 100vh; /* Minimum height to take full viewport height */
      }

      /* Dashboard sections */
      .dashboard-section {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
        margin-left: 20px;
        width: calc(100% - 40px); /* Adjusted width considering padding */
      }

      /* Section headers */
      .dashboard-section h2 {
        margin-bottom: 15px;
        
      }

      /* List styles */
      .dashboard-section ul {
        list-style: none;
        padding: 0;
      }

      .dashboard-section li {
        background-color: #f2f2f2;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      /* Invite again button */
      .invite-again-btn {
        padding: 5px 10px;
        background-color: #6c5ce7;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
      }

      .invite-again-btn:hover {
        background-color: #5a4cb1;
      }

      /* Adjusting the alignment of items */
      .invite-info {
        flex-grow: 1; /* Allow the invite info to fill the space */
      }

      /* Message styles */
      .success-message, .error-message {
        color: #fff;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
      }

      .success-message {
        background-color: #28a745;
      }

      .error-message {
        background-color: #dc3545;
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
      <!-- <div class="nav-button">
        <a href="Messages.php">
            <i class="fas fa-envelope"></i><span>Messages</span>
        </a>
   </div> -->

   <!-- <div class="nav-button">
      <a href="Recents.php">
          <i class="fas fa-fire"></i><span>Recent Invites</span>
      </a>
   </div> -->
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

  <!-- Dashboard Content -->
  <div id="dashboard-content">
  <h1 style="color: #020a1f; margin-left: 20px;">Welcome, <?php echo $_SESSION["Username"]; ?></h1>


        <!-- Total Invites Section -->
        <div class="dashboard-section">
            <h2>Total Invites Sent</h2>
            <!-- PHP code to fetch and display total invites -->
            <?php
            $username = $_SESSION["Username"];
            // Query to get the total number of invites for the logged-in user
            $stmt = $Connection->prepare("SELECT COUNT(*) FROM invites WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($totalInvites);
            $stmt->fetch();
            $stmt->close();
            ?>
            <p>Total Invites Sent: <?php echo $totalInvites; ?></p>
        </div>

        

        <!-- Recent Invites Section -->
        <div class="dashboard-section">
            <h2>Recent Invites</h2>
            <ul>
                <?php
                $stmt = $Connection->prepare("SELECT invite_id, visitor_name, invite_date FROM invites WHERE username = ? ORDER BY invite_date DESC LIMIT 3");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($invite = $result->fetch_assoc()) {
                ?>
                <li>
                    <div class="invite-info">
                        <strong>Visitor:</strong> <?php echo htmlspecialchars($invite['visitor_name']); ?><br>
                        <strong>Date:</strong> <?php echo htmlspecialchars($invite['invite_date']); ?>
                    </div>
                    <form method="post" action="Dashboard.php">
                        <input type="hidden" name="invite_again_id" value="<?php echo $invite['invite_id']; ?>">
                        <button type="submit" name="invite_again" class="invite-again-btn">Invite Again</button>
                    </form>
                </li>
                <?php
                }
                $stmt->close();
                ?>
            </ul>
        </div>


        <!-- Curfew Clock Section -->
        <div class="dashboard-section">
            <h2>Visitor Curfew</h2>
            <p>Curfew Time: 23:59</p>
            <p>Hours Left to Curfew: <span id="countdown">calculating...</span></p>
        </div>


    </div>

  </div>
      
  <script>
      function getTimeRemaining(endtime) {
        const total = Date.parse(endtime) - Date.parse(new Date());
        const seconds = Math.floor((total / 1000) % 60);
        const minutes = Math.floor((total / 1000 / 60) % 60);
        const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
        const days = Math.floor(total / (1000 * 60 * 60 * 24));
        return {
          total,
          days,
          hours,
          minutes,
          seconds
        };
      }

      function initializeClock(id, endtime) {
        const countdown = document.getElementById(id);
        const timeinterval = setInterval(() => {
          const t = getTimeRemaining(endtime);
          countdown.innerHTML = t.hours + ' hours ' +
                                t.minutes + ' minutes ' +
                                t.seconds + ' seconds';

          if (t.total <= 0) {
            clearInterval(timeinterval);
            countdown.innerHTML = 'Curfew time!';
          } else if (t.total <= 900000 && !countdown.dataset.almostCurfew) {
            // Show a warning 15 minutes before the curfew time
            countdown.dataset.almostCurfew = 'true';
            alert('Curfew is almost here. Please prepare to conclude your activities.');
          }
        }, 1000);
      }

      // Set the curfew time to today's date at 00:00
      const curfewTime = new Date();
      curfewTime.setHours(24, 0, 0, 0); // This is equivalent to 00:00 of the next day

      // Start the countdown
      initializeClock('countdown', curfewTime);
</script>



</body>