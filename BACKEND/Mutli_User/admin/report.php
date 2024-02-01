<?php
$current_page = "report"; // Change this variable for each page
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
?>

<?php
$residenceListSql = "SELECT Residence_ID, Name, Number_of_Blocks, Room_Numbers FROM Residence ORDER BY Residence_ID ASC";
$residenceListResult = $conn->query($residenceListSql);

$checkedInStudents = "SELECT username, invite_date, visitor_name, visitor_email, time_in, checkout_time FROM scanned_qr ORDER BY time_in ASC";
$checkedInResult = $conn->query($checkedInStudents);

// Start including the header and navigation here
include 'include/header.php';
include 'include/navigation.php';
?>

<!--Details for Residences-->
<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Residences</h2>
            <button onclick="printTable('residenceTable')">Print Residences</button>
        </div>

        <!-- Start of table -->
        <table id="residenceTable">
            <thead>
                <tr>
                    <td>Residence Number</td>
                    <td>Residence Name</td>
                    <td>Number of Blocks</td>
                    <td>Number of Rooms</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $residenceListResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["Residence_ID"] . '</td>';
                    echo '<td>' . $row["Name"] . '</td>';
                    echo '<td>' . $row["Number_of_Blocks"] . '</td>';
                    echo '<td>' . $row["Room_Numbers"] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- End of table -->
    </div>
</div>
<!-- End of Residences Details -->

<!--Details for Visitors Log-->
<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Visitors Log</h2>
            <button onclick="printTable('visitorsLogTable')">Print Visitors Log</button>
        </div>

        <!--Start of table-->
        <table id="visitorsLogTable">
            <thead>
                <tr>
                    <td>Username</td>
                    <td>Visitors Name</td>
                    <td>Invite Date</td>
                    <td>Visitor Email</td>
                    <td>Checked_In</td>
                    <td>Checked_Out</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $checkedInResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["username"] . '</td>';
                    echo '<td>' . $row["visitor_name"] . '</td>';
                    echo '<td>' . $row["invite_date"] . '</td>';
                    echo '<td><span>' . $row["visitor_email"] . '</span></td>';
                    echo '<td><span class="status pending">' . $row["time_in"] . '</span></td>'; 
                    echo '<td><span class="status checkout">' . $row["checkout_time"] . '</span></td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <!--End of table--> 
    </div>
</div>
<!---End of Visitors Log Details-->

<script>
// JavaScript function for printing a table
function printTable(tableId) {
    var printContents = document.getElementById(tableId).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<?php
// Include the footer
include 'include/footer.php';
?>
