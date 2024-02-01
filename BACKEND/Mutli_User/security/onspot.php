<?php
$current_page = "on spot registration"; // Change this variable for each page
?>


<?php include 'include/header.php'; ?>
<?php include 'include/navigation.php'; ?>
        <style>
            /* Style the container for the form and cards */
            .cardBox, #registerContent {
                display: flex;
                justify-content: center; /* Center horizontally */
                align-items: center; /* Center vertically */
                flex-direction: column; /* Stack children vertically */
                min-height: 100vh; /* Minimum height to take full viewport height */
            }


            /* Style the table */
            table {
                width: 100%; /* Full width to stretch within the form */
            }

            /* Optional: Hide the table by default */
            table {
                display: none;
            }

            /* Style the Go Back button */
            #goBack {
                /* Your styles for go back button */
                margin-top: 20px; /* Add some space above the button */
                align-self: center; /* Align button in the center */
            }

            /* Additional centering for the camera wrapper */
            .camera-wrapper {
                display: flex;
                justify-content: center;
                width: 100%; /* Ensure it spans the full width of its parent */
            }

            /* Ensure center-content class affects direct children only */
            .center-content > * {
                margin: 10px 0; /* Adds margin to top and bottom of each child */
            }

                /* Ensure the container takes up the full width */
            .center-content .container {
                width: 100%; /* Full width to allow centering of children */
                display: flex; /* Use flexbox for centering */
                flex-direction: column; /* Stack children vertically */
                align-items: center; /* Center children horizontally */
                justify-content: center; /* Center children vertically if there's space */
            }

            /* Style the camera container */
            #camera-container {
                width: 300px;
                height: 300px;
                border: 2px solid #ddd;
                border-radius: 10px;
                overflow: hidden;
                margin-bottom: 20px; /* Add margin to separate camera from form */
            }

            /* Style the camera video */
            #preview {
                width: 100%;
                height: 100%;
            }

            /* Style the form */
            /* You may also adjust the width of the form to ensure it doesn't stretch too much on larger screens */
            /* Style the form itself */
            form {
                width: 100%; /* Full width of its parent */
                max-width: 500px; /* Maximum width of the form */
                padding: 20px; /* Padding inside the form */
                margin: 20px; /* Margin around the form */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Box shadow for styling */
                background-color: #fff; /* Background color for the form */
                border-radius: 10px; /* Rounded corners for the form */
            }

            /* Style the form labels */
            label {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 8px; /* Add margin below labels */
                display: block; /* Ensure labels are on a new line */
            }

            /* Style the form inputs */
            .form-control {
                font-size: 16px;
                padding: 10px;
                margin-bottom: 15px; /* Increase margin between input fields */
                width: 100%; /* Make inputs full width */
            }

            /* Style the form submit button */
            .btn-primary {
                font-size: 18px;
                width: 100%; /* Make the button full width */
            }

            /* Style the Go Back button */
            .btn-secondary {
                margin-top: 15px; /* Add margin to the top of the button */
                width: 100%; /* Make the button full width */
            }
        </style>    
        
        <div class="center-content">
            <div class="container">
                
            <form action="your_combined_page.php" method="post" name="myForm">
            <!-- Your form content remains unchanged -->

            <!-- Add margin between form groups for better spacing -->
            <div class="form-group">
                <label>SCAN RESULT</label>
                <input type="hidden" name="text" id="text"  class="form-control" placeholder="Scan Result">
            </div>

            <!-- Repeat the same structure for other form groups -->
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" id="username"  class="form-control" placeholder="Username">
            </div>

            <div class="form-group">
                <label>Invite Date</label>
                <input type="date" name="invite_date" id="invite_date"  class="form-control" placeholder="Invite Date">
            </div>

            <div class="form-group">
                <label>Visitor Name</label>
                <input type="text" name="visitor_name" id="visitor_name"  class="form-control" placeholder="Visitor Name">
            </div>

            <div class="form-group">
                <label>Visitor Email</label>
                <input type="text" name="visitor_email" id="visitor_email"  class="form-control" placeholder="Visitor Email">
            </div>

            <div class="form-group">
                <label>Visitor Phone</label>
                <input type="text" name="visitor_phone" id="visitor_phone"  class="form-control" placeholder="Visitor Phone">
            </div>

            <div class="form-group">
                <label>Visitor ID</label>
                <input type="text" name="visitor_id" id="visitor_id"  class="form-control" placeholder="Visitor ID">
            </div>

            <div class="form-group">
                <label>Reserve Parking</label>
                <input type="text" name="parking_reserved" id="parking_reserved"  class="form-control" placeholder="Parking Reserved">
            </div>

            <!-- ... Repeat for other form groups ... -->
            <div class="form-group">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary form-control">
            </div>

        </form>
        <button onclick="goBack()" class="btn btn-primary form-control">Go Back</button>
    </div>
</div>

<!-- Javascript code to scan QR code -->
<!-- Javascript code to scan QR code -->


<script>
    function goBack() {
        // Redirect to the previous page (you can specify the URL here)
        window.location.href = "register.php";
    }
</script>
<?php include 'include/footer.php'; ?>



