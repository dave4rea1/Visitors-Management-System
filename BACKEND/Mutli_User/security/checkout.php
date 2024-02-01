<?php
$current_page = "checkout"; 
$host = "localhost";
$username = "root";
$password = "";
$database = "visitors";

// Establish database connection
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ''; 

// Handle the POST request from the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $visitor_id = $_POST['visitor_id'];

    // Prepare the SELECT statement
    $stmt = $conn->prepare("SELECT * FROM scanned_qr WHERE visitor_id = ? AND checkout_time IS NULL");
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    $stmt->bind_param("s", $visitor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Prepare the UPDATE statement
        $updateStmt = $conn->prepare("UPDATE scanned_qr SET checkout_time = NOW() WHERE visitor_id = ?");
        if (!$updateStmt) {
            echo "Error preparing update statement: " . $conn->error;
            exit;
        }
        $updateStmt->bind_param("s", $visitor_id);
        $updateStmt->execute();
        $updateStmt->close();
        $message = "Checkout successful.";
    } else {
        $message = "No valid check-in record found or already checked out.";
    }

    $stmt->close();
    $conn->close();
    echo "<script type='text/javascript'>alert('$message');</script>";
}
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
        <div class="camera-wrapper">
            <div id="camera-container">
                <video id="preview"></video>
            </div>
        </div>
        <form action="" method="post" name="myForm">
            <div class="form-group">
                <label>Visitor ID</label>
                <input type="text" name="visitor_id" id="visitor_id" readonly="" class="form-control" placeholder="Visitor ID">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Checkout" class="btn btn-primary form-control">
            </div>
        </form>
        <button onclick="goBack()" class="btn btn-primary form-control">Go Back</button>
    </div>
</div>

<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
            scanner.start(cameras[0]);
        } else {
            console.error("No cameras found");
            alert("No cameras found. Please check your device settings.");
        }
    }).catch(function (e) {
        console.error(e);
        alert("An error occurred while trying to access the camera.");
    });

    scanner.addListener('scan', function (c) {
        let codeContents = c.split("\n");
        if (codeContents[5] && codeContents[5].trim() !== '') {
            document.getElementById('visitor_id').value = codeContents[5];
        } else {
            alert('Invalid QR Code. Please try again with a valid code.');
        }
    });
</script>

<script>
    function goBack() {
        window.location.href = "register.php";
    }
</script>

<?php include 'include/footer.php'; ?>
