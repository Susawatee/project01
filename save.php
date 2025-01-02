<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_register";

// การเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงเลขล่าสุดจากฐานข้อมูล
$sql = "SELECT MAX(book_number) AS last_number FROM book_entries";
$result = $conn->query($sql);

$currentNumber = 1; // เริ่มต้นเลขที่ 1
if ($result && $row = $result->fetch_assoc()) {
    $currentNumber = $row['last_number'] + 1; // เพิ่มเลขถัดไป
}

// รับข้อมูลจากฟอร์ม
$date = $_POST['date'];
$from = $_POST['from'];
$from_other = isset($_POST['from_other']) ? $_POST['from_other'] : NULL;
$to = $_POST['to'];
$to_other = isset($_POST['to_other']) ? $_POST['to_other'] : NULL;
$subject = $_POST['subject'];
$note = $_POST['note'];

// SQL Statement
$sql = "INSERT INTO book_entries (book_number, date, `from`, from_other, `to`, to_other, subject, note)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $currentNumber, $date, $from, $from_other, $to, $to_other, $subject, $note);

// ดำเนินการ
if ($stmt->execute()) {
    echo "บันทึกข้อมูลเรียบร้อย!";
    header("Location: page2.php"); // เปลี่ยนไปยังหน้า page2.php
    exit();
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
