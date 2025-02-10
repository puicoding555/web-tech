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
// ตรวจสอบการส่งฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $customer_name = $_POST["customer_name"];
       $phone_number = $_POST["phone_number"];
       $guests = $_POST["guests"];
       $reservation_date = $_POST["reservation_date"];
       $arrival_time = $_POST["arrival_time"];
       $member = $_POST["member"];
       $deposit = $_POST["deposit"];
       $dishes = isset($_POST["dishes"]) ? implode(", ", $_POST["dishes"]) : "";
       $sql = "INSERT INTO reservations (customer_name, phone_number, guests, reservation_date, arrival_time, member, deposit, dishes)
           VALUES ('$customer_name', '$phone_number', $guests, '$reservation_date', '$arrival_time', '$member', $deposit, '$dishes')";
       if ($conn->query($sql) === TRUE) {
              header("Location: report.php");
              exit();
       } else {
              echo "Error: " . $conn->error;
       }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="th">

<head>
       <meta charset="UTF-8">
       <title>Reserve Table</title>
</head>

<body>
       <h2>SANYA's Restaurant - Table Reserving</h2>
       <form action="" method="post">
              Customer Name: <input type="text" name="customer_name" required><br>
              Phone Number: <input type="text" name="phone_number" required><br>
              Number of Guests: <input type="number" name="guests" required><br>
              Reservation Date: <input type="date" name="reservation_date" required><br>
              Arrival Time: <input type="time" name="arrival_time" required><br>
              Are you a member?
              <input type="radio" name="member" value="YES" required> YES
              <input type="radio" name="member" value="NO" required> NO<br>
              </select><br>
              Deposit Payment Amount: <input type="number" name="deposit" required> BAHT<br>
              <p>Choose Recommended Dishes:</p>
              <input type="checkbox" name="dishes[]" value="Premium Beef Steak"> Premium Beef Steak<br>
              <input type="checkbox" name="dishes[]" value="Healthy Salad"> Healthy Salad<br>
              <input type="checkbox" name="dishes[]" value="Cheeseburger"> Cheeseburger<br>
              <input type="checkbox" name="dishes[]" value="Barbecue"> Barbecue<br>
              <input type="checkbox" name="dishes[]" value="Fried Chicken"> Fried Chicken<br>
              <input type="checkbox" name="dishes[]" value="Cheesesteak Sandwich"> Cheesesteak Sandwich<br>
              <input type="checkbox" name="dishes[]" value="Buffalo Wings"> Buffalo Wings<br>
              <input type="checkbox" name="dishes[]" value="Pepperoni Pizza"> Pepperoni Pizza<br>
              <button type="submit">Reserve Table</button>
              <button type="submit">Reset</button>
       </form>
</body>

</html>
