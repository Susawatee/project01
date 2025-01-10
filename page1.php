<?php
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

$currentNumber = 1; // เลขเริ่มต้น
if ($result && $row = $result->fetch_assoc()) {
    $currentNumber = isset($row['last_number']) ? $row['last_number'] + 1 : 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ทะเบียนเลขหนังสือ</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ทะเบียนเลขหนังสือ</h1>
            <h2>ศูนย์ขายและวิศวกรรม</h2>
        </div>
        <form action="save.php" method="POST">
            <div class="form-group">
                <label for="unit">เลขที่ ขบตน.2(ปน.):</label>
                <select id="unit" name="book_number">
                <option value="<?php echo $currentNumber; ?>"><?php echo $currentNumber; ?></option>
                </select>

            </div>
            <div class="form-group">
                <label for="date">วันที่:</label>
                <input type="date" id="date" name="date">
            </div>
            <div class="form-group">
                <label>จาก:</label>
                <div class="radio-group">
                    <label><input type="radio" name="from" value="ขบตน.2(ปน.)"> ขบตน.2(ปน.)</label>
                    <label><input type="radio" name="from" value="" id="fromOtherRadio">อื่นๆ </label>
                </div>
                <div id="fromOtherInputContainer" style="display: none;">
                    <input type="text" id="fromOtherInput" name="from_other" placeholder="ระบุข้อมูล">
                </div>
            </div>
            <div class="form-group">
                <label>เรียน/ถึง:</label>
                <div class="radio-group">
                    <label><input type="radio" name="to" value="ผส.บตน.2(ปน.)"> ผส.บตน.2(ปน.)</label>
                    <label><input type="radio" name="to" value="ปฏิบัติการ.ผส.บตน.2(ปน.)"> ปฏิบัติการ.ผส.บตน.2(ปน.)</label>
                    <label><input type="radio" name="to" value="ช.ผส.บตน.2(ปน.)"> ช.ผส.บตน.2(ปน.)</label>
                    <label><input type="radio" name="to" value="" id="toOtherRadio">อื่นๆ</label>
                </div>
                <div id="toOtherInputContainer" style="display: none;">
                    <input type="text" id="toOtherInput" name="to_other" placeholder="ระบุข้อมูล">
                </div>
            </div>
            <div class="form-group">
                <label for="subject">เรื่อง:</label>
                <input type="text" id="subject" name="subject" placeholder="คำตอบของคุณ">
            </div>
            <div class="form-group">
                <label for="reason">หมายเหตุ:</label>
                <input type="text" id="reason" name="note" placeholder="คำตอบของคุณ">
            </div>
            <div class="form-group button">
                <button type="submit">ส่ง</button>
            </div>            
        </form>
        <a href="index.html" class="back-button">กลับ</a>
    </div>

    <script>
        const fromOtherRadio = document.getElementById('fromOtherRadio');
        const toOtherRadio = document.getElementById('toOtherRadio');
        const fromOtherInputContainer = document.getElementById('fromOtherInputContainer');
        const toOtherInputContainer = document.getElementById('toOtherInputContainer');

        fromOtherRadio.addEventListener('change', function() {
            if (this.checked) {
                fromOtherInputContainer.style.display = 'block';
            } else {
                fromOtherInputContainer.style.display = 'none';
            }
        });

        toOtherRadio.addEventListener('change', function() {
            if (this.checked) {
                toOtherInputContainer.style.display = 'block';
            } else {
                toOtherInputContainer.style.display = 'none';
            }
        });
        document.querySelector("form").addEventListener("submit", function(event) {
    let isValid = true;

    // ตรวจสอบวันที่
    const dateInput = document.getElementById("date");
    if (!dateInput.value) {
        isValid = false;
        alert("กรุณากรอกข้อมูล");
    }

    // ถ้าไม่ครบทุกข้อมูลจะไม่ส่งฟอร์ม
    if (!isValid) {
        event.preventDefault();
    }
});
    </script>
</body>
</html>
