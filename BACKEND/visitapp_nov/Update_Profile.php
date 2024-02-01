<?php require_once("Include/Session.php") ?>
<?php require_once("Include/Functions.php") ?>
<?php require_once("Include/DB.php"); ?>

<?php 

   // Check if the user is logged in
   if (isset($_SESSION["User_Id"])) {
    $username = $_SESSION["Username"];

    // Query to fetch user details based on username
    $query = "SELECT fullname, email, idnumber, campus, residence, block FROM users WHERE username = '$username'";
    $result = mysqli_query($Connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userFullname = $row['fullname'];
        $userEmail = $row['email'];
        $userId = $row['idnumber'];
        $userCampus = $row['campus'];
        $userResidence = $row['residence'];
        $userBlock = $row['block'];

        // Store these values in session for later use (optional)
        $_SESSION["UserFullname"] = $userFullname;
        $_SESSION["UserEmail"] = $userEmail;
        $_SESSION["UserId"] = $userId;
        $_SESSION["UserCampus"] = $userCampus;
        $_SESSION["UserResidence"] = $userResidence;
        $_SESSION["UserBlock"] = $userBlock;
    }
  }
   if (isset($_POST["update"])) {
    // Establish a database connection
    $Connection = mysqli_connect('localhost', 'root', '', 'visitors');

    if (!$Connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Retrieve form data
    $Fullname = mysqli_real_escape_string($Connection, $_POST["Fullname"]);
    $Email = mysqli_real_escape_string($Connection, $_POST["Email"]);
    $Phone = mysqli_real_escape_string($Connection, $_POST["Phone"]);
    $Idnumber = mysqli_real_escape_string($Connection, $_POST["Idnumber"]);
    $Campus = mysqli_real_escape_string($Connection, $_POST["Campus"]);
    $Residence = mysqli_real_escape_string($Connection, $_POST["Residence"]);
    $Block = mysqli_real_escape_string($Connection, $_POST["Block"]);
    $Room = mysqli_real_escape_string($Connection, $_POST["Room"]);
    $Username = $_SESSION["Username"]; // Get the username from the session

    // Update database record
    $Query = "UPDATE users SET fullname='$Fullname', email='$Email', phone='$Phone', campus='$Campus', residence='$Residence', block='$Block', room='$Room' WHERE username='$Username'";

    $Execute = mysqli_query($Connection, $Query);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Profile Updated Successfully";
        header("Location: Update_Profile.php");
        exit();
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong. Try Again!";
        header("Location: Profile.php");
        exit();
    }

    mysqli_close($Connection);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Include/Styles_Profile.css">
    <link rel="stylesheet" href="css/bootstrap.css"> 
    <!-- <link rel="stylesheet" href="Include/Styles.css"> -->
    <title>Update Profile</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');


        body {
            margin: 0;
            background: #9c88ff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: space-between;
            padding: 5mm;
        }

        .profile-image-section {
            width: 4.5cm;
            height: 10cm;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-right: 5mm;
        }

        .profile-image-section img {
            width: 90px;
            height: 90px;
            border-radius: 100px;
            margin: 10px 0;
        }

        .profile-image-section h5.user-name {
            margin: 0;
        }

        .profile-image-section h6.user-email {
            margin: 0;
            font-size: 0.8rem;
            font-weight: 400;
            color: #9fa8b9;
        }

        .profile-image-section .about {
            margin-top: 2rem;
        }

        .profile-image-section .about h5 {
            margin: 0 0 15px 0;
            color: #007ae1;
        }

        .profile-image-section .about p {
            font-size: 0.825rem;
        }

        .user-data-section {
            width: 15cm;
            height: 10cm;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .user-data-section h6.text-primary {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            border: 1px solid #cfd1d8;
            border-radius: 2px;
            font-size: .825rem;
            background: #ffffff;
            color: #2e323c;
        }

        .card {
            background: #ffffff;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
        }

        .text-right button {
            margin-left: 10px;
        }

        .account-settings .about {
            margin: 2rem 0 0 0;
            text-align: center;
        }
        .account-settings .about h5 {
            margin: 0 0 15px 0;
            color: #007ae1;
        }
        .account-settings .about p {
            font-size: 0.825rem;
        }

        /* Styles for user profile */
      .user-profile {
          text-align: center;
      }

      .user-avatar {
          position: relative;
          display: inline-block;
      }

      .avatar-container {
          width: 150px;
          height: 150px;
          overflow: hidden;
          border-radius: 50%;
          border: 2px solid #ccc;
          position: relative;
      }

      #user-image {
          width: 100%;
          height: 100%;
          object-fit: cover;
      }

      .custom-file-upload {
          display: inline-block;
          cursor: pointer;
          padding: 10px 20px;
          background-color: #007ae1;
          color: #fff;
          border-radius: 5px;
          font-size: 16px;
          transition: background-color 0.3s;
      }

      .custom-file-upload i {
          margin-right: 8px;
      }

      .custom-file-upload:hover {
          background-color: #0056b3;
      }

      /* Hide the default file input */
      #file-upload {
          display: none;
      }
     
    </style>

<!-- javascript code to display profile picture -->
<script>
        function displayImage(input) {
            const userImage = document.getElementById('user-image');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    userImage.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        }
    </script>

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

<!-- edit/update profile page using bootstrap-->
<form method="post" action="Update_Profile.php">

<div class="container">
<div class="row gutters">
  <!-- left column - user profile -->
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
  <!-- user profile content -->
<div class="card h-100">
	<div class="card-body">
		<div class="account-settings">
    <div class="user-profile">
      <!-- update image -->
        <div class="user-avatar">
            <div class="avatar-container">
                <img id="user-image" src="https://img.myloview.com/murals/default-avatar-profile-image-vector-social-media-user-icon-400-228654854.jpg" alt="User Image">
            </div><br>
            <label for="file-upload" class="custom-file-upload">
                <i class="fas fa-cloud-upload-alt"></i> Upload Image
            </label>
            <input type="file" id="file-upload" accept="image/*" onchange="displayImage(this)">
        </div>
        <h5 class="user-name"><?php echo $_SESSION["UserFullname"]; ?></h5>
        <h6 class="user-email"><?php echo $_SESSION["UserEmail"]; ?></h6>
    </div>
    <!-- about -->

			<div class="about">
      <h5>About</h5>
    <?php if (isset($_SESSION["UserId"])) : ?>
        <p>User ID: <?php echo $_SESSION["UserId"]; ?></p>
        <p>Campus: <?php echo $_SESSION["UserCampus"]; ?></p>
        <p>Residence: <?php echo $_SESSION["UserResidence"]; ?></p>
        <p>Block: <?php echo $_SESSION["UserBlock"]; ?></p>
    <?php else : ?>
        <p>User details not available.</p>
    <?php endif; ?>
			</div>

		</div>
	</div>
</div>
</div>

<!-- Profile details -->
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
<div class="card h-100">
	<div class="card-body">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mb-2 text-primary">Personal Details</h6>
			</div>
      <!-- names -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="fullName">Full Name</label>
					<input type="text" class="form-control" id="fullName" name="Fullname" placeholder="Enter full name" required>
				</div>
			</div>
      <!-- email -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="eMail">Email</label>
					<input type="email" class="form-control" id="eMail" name="Email" placeholder="Enter email" required>
				</div>
			</div>
      <!-- phone number -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" class="form-control" id="phone" name="Phone" placeholder="Enter phone number" required>
				</div>
			</div>
      <!-- ID number -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="idnumber">ID/Student Number</label>
					<input type="text" class="form-control" id="idnumber" name="Idnumber" placeholder="ID/Student number" required>
				</div>
			</div>
		</div>
    <!-- Address -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mt-3 mb-2 text-primary">Address</h6>
			</div>
      <!-- campus -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Campus">Campus</label>
					<input type="name" class="form-control" id="Campus" name="Campus" placeholder="Enter Campus" required>
				</div>
			</div>
      <!-- residence -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Residence">Residence</label>
					<input type="name" class="form-control" id="residence" name="Residence" placeholder="Enter Residence" required>
				</div>
			</div>
      <!-- block number -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Block">Block</label>
					<input type="text" class="form-control" id="block" name="Block" placeholder="Enter Block Number" required>
				</div>
			</div>
      <!-- room number -->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Room">Room</label>
					<input type="text" class="form-control" id="room" name="Room" placeholder="Room Number" required>
				</div> 
			</div>

		</div>
    <!-- submit button -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="text-right">
					<button type="submit" id="submit" name="submit" class="btn btn-secondary">Cancel</button>
					<button type="submit" id="submit" name="update" class="btn btn-primary">Update</button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>

</form>


  
    
</body>
</html>


<!--  -->



