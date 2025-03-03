<?php // Developed by 66315498 เสกสรร ธิจร
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";  // แก้ไขตามข้อมูลเซิร์ฟเวอร์ของคุณ
$password = "";  // แก้ไขตามข้อมูลเซิร์ฟเวอร์ของคุณ
$dbname = "myCarDb";  // ชื่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบค่าค้นหา
$search = "";
$whereClause = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $whereClause = "WHERE Car.CarID LIKE '%$search%'
                    OR Car.CarName LIKE '%$search%'
                    OR Car.CarPrice LIKE '%$search%'
                    OR CarBrand.BrandName LIKE '%$search%'
                    OR CarType.CarTypeName LIKE '%$search%'";
}

// คำสั่ง SQL ดึงข้อมูลรถยนต์โดย JOIN 3 ตาราง
$sql = "SELECT Car.CarID, Car.CarName, Car.CarPrice, CarBrand.BrandName, CarType.CarTypeName
       FROM Car
       JOIN CarBrand ON Car.BrandID = CarBrand.BrandID
       JOIN CarType ON Car.CarTypeID = CarType.CarTypeID
       $whereClause
       ORDER BY Car.CarID ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาข้อมูลรถยนต์</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .search-box {
            margin-bottom: 15px;
        }

        .search-box {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            /* เพิ่มระยะห่างระหว่างช่อง input และปุ่ม */
            margin-bottom: 15px;
        }


        button[name="Search"] {
            background-color: #28a745;
            color: white;
            
        }

        button[name="reset"] {
            background-color: #ff9800;
            color: white;
        }
    </style>
</head>

<body>
    <h1>ค้นหาข้อมูลรถยนต์</h1>
    <form method="GET" class="search-box">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
            placeholder="ค้นหาด้วยชื่อรถ หรือ ยี่ห้อ">
        <button type="submit" name="Search">Search</button>
        <button type="submit" name="reset">Reset</button></a>
    </form>
    <table>
        <tr>
            <th>CarID</th>
            <th>CarName</th>
            <th>CarPrice</th>
            <th>BrandName</th>
            <th>CarTypeName</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
<td>{$row['CarID']}</td>
<td>{$row['CarName']}</td>
<td>" . number_format($row['CarPrice']) . "</td>
<td>{$row['BrandName']}</td>
<td>{$row['CarTypeName']}</td>
</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>ไม่พบข้อมูล</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>

</html>