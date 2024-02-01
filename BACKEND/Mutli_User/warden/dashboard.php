<?php
$current_page = "dashboard"; // Change this variable for each page
?>

<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "visitors";

$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// SQL query to count users in the 'users' table
$userSql = "SELECT COUNT(*) as userCount FROM users";
$userResult = $conn->query($userSql);

if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $userCount = $userRow["userCount"];
} else {
    $userCount = 0;
}

// SQL query to count invites in the 'invites' table
$inviteSql = "SELECT COUNT(*) as inviteCount FROM invites";
$inviteResult = $conn->query($inviteSql);

if ($inviteResult->num_rows > 0) {
    $inviteRow = $inviteResult->fetch_assoc();
    $inviteCount = $inviteRow["inviteCount"];
} else {
    $inviteCount = 0;
}

$recentInvitesSql = "SELECT username, visitor_name, invite_date, visitor_email FROM invites ORDER BY invite_date DESC LIMIT 10";
$recentInvitesResult = $conn->query($recentInvitesSql);

if ($recentInvitesResult === false) {
    echo "Error: " . $conn->error; // Print the error message for debugging
} else {
    while ($row = $recentInvitesResult->fetch_assoc()) {
        $userName = $row["username"];
        $visitorName = $row["visitor_name"];
        $inviteDate = $row["invite_date"];
        $visitorEmail = $row["visitor_email"];
    }
}

//INSERT INTO scanned_qr (username, invite_date, visitor_name, visitor_email, visitor_phone, visitor_id, parking_reserved, time_in) 
//VALUES ('$username', '$invite_date', '$visitor_name', '$visitor_email', '$visitor_phone', '$visitor_id', '$parking_reserved', NOW())";
//SQL query to count checked in visitors in the 'scanned_qr' table
$checkedInSql = "SELECT COUNT(*) as checkedInCount FROM scanned_qr";
$checkedInResult = $conn->query($checkedInSql);

if($checkedInResult->num_rows > 0) {
    $checkedInRow = $checkedInResult->fetch_assoc();
    $checkedInCount = $checkedInRow["checkedInCount"];
} else {
    $checkedInCount = 0;
}

// SQL query to count checked out visitors in the 'scanned_qr' table
$checkedOutSql = "SELECT COUNT(*) as checkedOutCount FROM scanned_qr WHERE checkout_time IS NOT NULL";
$checkedOutResult = $conn->query($checkedOutSql);

if ($checkedOutResult->num_rows > 0) {
    $checkedOutRow = $checkedOutResult->fetch_assoc();
    $checkedOutCount = $checkedOutRow["checkedOutCount"];
} else {
    $checkedOutCount = 0;
}


?>

<?php include 'include/header.php'; ?>
<?php include 'include/navigation.php'; ?>



            <!--MAIN CARDS-->
            <div class="cardBox">
                <!--Card 1-->
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $userCount; ?></div>
                        <div class="cardName">Number of Users</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="people-outline"></ion-icon>
                    </div>
                </div>
                <!--Card 2-->
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $inviteCount; ?></div>
                        <div class="cardName">Number of Invites</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="push-outline"></ion-icon>
                    </div>
                </div>
                <!--Card 3-->
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $checkedInCount; ?></div>
                        <div class="cardName">Number of Checked in Visitors</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="qr-code-outline"></ion-icon>
                    </div>
                </div>
                <!--Card 4-->
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $checkedOutCount; ?></div>
                        <div class="cardName">Number of Checked out Students</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="walk-outline"></ion-icon>
                    </div>
                </div>
            </div>
            <!---END OF CARDS-->

            <!--Details-->
            <div class="details">
                <!--details list-->
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Invites</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    
                    <!--Start of table-->
                    <table>
                        <!--Start of table head-->
                        <thead>
                            <tr>
                                <td>Username</td>
                                <td>Visitors Name</td>
                                <td>Invite Date</td>
                                <td>Visitor Email</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <!--End of table head-->

                        <!--Start of table body-->
                        <tbody>
                            <tr>
                                <td><?php echo $userName; ?></td>
                                <td><?php echo $visitorName; ?></td>
                                <td><?php echo $inviteDate; ?></td>
                                <td><span><?php echo $visitorEmail; ?></span></td>
                                <td><span class="status pending">Checked In</span></td>        
                            </tr>
                        </tbody>
                        <!--End of table body-->

                    </table>
                    <!--End of table--> 
                </div>
                <!--End of detail list-->


                <!--details list-->
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Messages</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    
                    <!--Start of table-->
                    <table>
                        <!--Start of table head-->
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Message</td>
                            </tr>
                        </thead>
                        <!--End of table head-->

                        <!--Start of table body-->
                        <tbody>
                            <tr>
                                <td><?php echo $name; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $communication; ?></td>
                            </tr>
                        </tbody>
                        <!--End of table body-->
                        <?php
                        // Close the database connection
                        $conn->close();
                        ?>
                    </table>
                    <!--End of table--> 
                </div>
                <!--End of detail list-->
            </div>
            <!---End of Details-->

        </div>
        <!--END OF MAIN CONTENT-->
 </div>


<?php include 'include/footer.php'; ?>