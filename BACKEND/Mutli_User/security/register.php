<?php
$current_page = "register visitor"; // Change this variable for each page
?>

<?php include 'include/header.php'; ?>
<?php include 'include/navigation.php'; ?>


<!-- Two buttons to choose to register on spot or scan_qr code-->
    <!--MAIN CARDS-->
    <style>


        .cardBox, #registerContent {
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            flex-direction: column; /* Stack children vertically */
            min-height: 100vh; /* Minimum height to take full viewport height */
        }

    .card {
    margin: 10px; /* Optional: Add some space between cards */
    }
    </style>
    <div class="cardBox">
        <!--Card 1-->
        <div class="card" id="card1">
            <div>
                <div class="cardName">Register User On Spot</div>
            </div>
            <div class="iconBox">
                <ion-icon name="people-outline"></ion-icon>
            </div>
        </div>
        <!--Card 2-->
        <div class="card" id="card2">
            <div>
                <div class="cardName">Register User By Scanning QR</div>
            </div>
            <div class="iconBox">
                <ion-icon name="push-outline"></ion-icon>
            </div>
        </div>
    </div>


    <!--Register on spot-->
<script>
    // Get references to the elements
    const card1 = document.getElementById("card1");
    const card2 = document.getElementById("card2");
    const registerContent = document.getElementById("registerContent");
    const goBackButton = document.getElementById("goBack");

    // Add click event listeners to the cards
    card1.addEventListener("click", () => {
        // Redirect to onspot.php when card 1 is clicked
        window.location.href = "onspot.php";
    });

    card2.addEventListener("click", () => {
        // Redirect to scan.php when card 2 is clicked
        window.location.href = "scan.php";
    });

    

</script>

</script>
<?php include 'include/footer.php'; ?>