<?php

// เปิด Error Reporting

error_reporting(E_ALL);

ini_set('display_errors', 1);

// เชื่อมต่อฐานข้อมูล

$servername = "localhost";

$username = "root";

$password = "";

$dbname = "restaurant_dbb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {

   die("Connection failed: " . $conn->connect_error);

}

// ดึงข้อมูลล่าสุด

$sql = "SELECT * FROM reservations ORDER BY id DESC LIMIT 1";

$result = $conn->query($sql);

$row = $result->fetch_assoc();

$conn->close();

?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Reservation Report</title>
</head>
<body>
<h2>REPORT of SANYA's Restaurant</h2>
<?php if ($row): ?>

   Customer Name: <?php echo $row["customer_name"]; ?><br>

   Phone Number: <?php echo $row["phone_number"]; ?><br>

   Number of Guests: <?php echo $row["guests"]; ?><br>

   Reservation Date: <?php echo $row["reservation_date"]; ?><br>

   Arrival Time: <?php echo $row["arrival_time"]; ?><br>

   Are you a member? <?php echo $row["member"]; ?><br>

   Deposit Payment Amount: <?php echo $row["deposit"]; ?> BAHT<br>

   Choose Recommended Dishes: <?php echo $row["dishes"]; ?><br>
<?php 

   // เช็คเงื่อนไขส่วนลด

   if ($row["arrival_time"] > "20:10") {

       echo "<p>Please, arrive before 20:10, receive a 10% discount on the total bill.</p>";

   }

   // คำนวณจำนวนโต๊ะ

   $tables_reserved = ceil($row["guests"] / 4);

   echo "<p>Reserve $tables_reserved Tables</p>";

   ?>
<?php else: ?>
<p>No reservation found.</p>
<?php endif; ?>
</body>
</html>
 