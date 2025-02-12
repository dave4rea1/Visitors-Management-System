<?php
include('libs/phpqrcode/qrlib.php');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sandbox";

function getUsernameFromEmail($email) {
    $find = '@';
    $pos = strpos($email, $find);
    $username = substr($email, 0, $pos);
    return $username;
}

if (isset($_POST['submit'])) {
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['mail'];
    $subject = $_POST['subject'];
    $body = $_POST['msg'];// Modify this line to generate QR code with form data
	$codeContents = "Email: " . $email . "\nSubject: " . $subject . "\nMessage: " . $body;
	

    // Generate the QR code and store it in a variable
    ob_start();
    QRcode::png($codeContents, null, QR_ECLEVEL_L, 5);
    $qrImageData = ob_get_contents();
    ob_end_clean();

    // Insert data into the database, including the QR code image
    $sql = "INSERT INTO qr_codes (email, subject, message, qr_image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssb", $email, $subject, $body, $qrImageData);
    $stmt->send_long_data(3, $qrImageData);
    
    if ($stmt->execute()) {
        echo "Data and QR code image inserted successfully.";
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
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
					<div class="form-group">
						<label>Email</label>
						<input type="email" class="form-control" name="mail" style="width:20em;" placeholder="Enter your Email" value="<?php echo @$email; ?>" required />
					</div>
					<div class="form-group">
						<label>Subject</label>
						<input type="text" class="form-control" name="subject" style="width:20em;" placeholder="Enter your Email Subject" value="<?php echo @$subject; ?>" required pattern="[a-zA-Z .]+" />
					</div>
					<div class="form-group">
						<label>Message</label>
						<input type="text" class="form-control" name="msg" style="width:20em;" value="<?php echo @$body; ?>" required pattern="[a-zA-Z0-9 .]+" placeholder="Enter your message"></textarea>
					</div>
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary submitBtn" style="width:20em; margin:0;" />
					</div>
				</form>
			</div>
			<?php
			if(!isset($filename)){
				$filename = "author";
			}
			?>
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