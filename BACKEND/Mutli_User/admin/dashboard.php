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

$recentInvitesSql = "SELECT username, visitor_name, invite_date, visitor_email FROM invites ORDER BY invite_date ASC LIMIT 10";
$recentInvitesResult = $conn->query($recentInvitesSql);

$recentMessagesSql = "SELECT name, email, communication FROM contact_form LIMIT 10";
$recentMessagesResult = $conn->query($recentMessagesSql);


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
?>

<?php include 'include/header.php'; ?>
<?php include 'include/navigation.php'; ?>

<!--MAIN CARDS-->
<div class="cardBox">
                <!--Card 1-->
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $userCount; ?></div>
                        <div class="cardName">Number of Students</div>
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
                        <div class="cardName">Number of Checked in Students</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="qr-code-outline"></ion-icon>
                    </div>
                </div>
                <!--Card 4-->
                <div class="card">
                    <div>
                        <div class="numbers">0</div>
                        <div class="cardName">Number of Checked out Students</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="walk-outline"></ion-icon>
                    </div>
                </div>
            </div>
            <!---END OF CARDS-->

<!-- Details -->
<div class="details">
    <!-- Recent Invites -->
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Recent Invites</h2>
            <a href="report.php" class="btn">View All</a>
        </div>

        <!-- Start of table -->
        <table>
            <thead>
                <tr>
                    <td>Username</td>
                    <td>Visitors Name</td>
                    <td>Invite Date</td>
                    <td>Visitor Email</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $recentInvitesResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["visitor_name"] . "</td>";
                    echo "<td>" . $row["invite_date"] . "</td>";
                    echo "<td><span class='status pending'>" . $row["visitor_email"] . "</span></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <!-- End of table -->
    </div>

</div>


    <div class="details">
        
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Recent Messages</h2>
            <a href="#" class="btn">View All</a>
        </div>

       
        <table>
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Message</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $recentMessagesResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["communication"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
       
    </div>-->
</div>
<!-- END OF DETAILS -->

<?php
// Close the database connection
$conn->close();
?>

<?php include 'include/footer.php'; ?>
