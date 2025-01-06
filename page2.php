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

// ดึงข้อมูลทั้งหมด
$sql = "SELECT book_number, date, `from`, from_other, `to`, to_other, subject, note FROM book_entries";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางข้อมูล</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>
    <div class="container">
        <h1>ทะเบียนเลขหนังสือ (การตอบกลับ)</h1>
        <!-- ช่องค้นหา -->
        <div class="search-container">
            <label for="searchInput">ค้นหา: </label>
            <input type="text" id="searchInput" placeholder="พิมพ์คำที่ต้องการค้นหา...">
        </div>
        <table id="dataTable">
            <thead>
                <tr>
                    <th>เลขที ขบตน.2(ปน.)</th>
                    <th>วันที่</th>
                    <th>จาก</th>
                    <th>เรียน/ถึง</th>
                    <th>เรื่อง</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['book_number'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['from'];
                        if (!empty($row['from_other'])) {
                            echo " (" . $row['from_other'] . ")";
                        }
                        echo "</td>";
                        echo "<td>" . $row['to'];
                        if (!empty($row['to_other'])) {
                            echo " (" . $row['to_other'] . ")";
                        }
                        echo "</td>";
                        echo "<td>" . $row['subject'] . "</td>";
                        echo "<td>" . $row['note'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center;'>ไม่มีข้อมูล</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="index.html" class="back-button">กลับ</a>
    </div>
    <script>
    // ฟังก์ชันการค้นหา (เหมือนเดิม)
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let table = document.getElementById("dataTable");
        let rows = table.getElementsByTagName("tr");
        let found = false;

        for (let i = 1; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName("td");
            let rowText = "";
            for (let j = 0; j < cells.length; j++) {
                rowText += cells[j].textContent.toLowerCase();
            }
            if (rowText.indexOf(filter) > -1) {
                rows[i].style.display = "";
                found = true;
            } else {
                rows[i].style.display = "none";
            }
        }

        // แสดงข้อความเมื่อไม่พบข้อมูล
        if (!found) {
            if (!document.getElementById("noResults")) {
                let noResults = document.createElement("tr");
                noResults.id = "noResults";
                noResults.innerHTML = `<td colspan="6" style="text-align: center; color: red;">ไม่พบข้อมูลที่ค้นหา</td>`;
                table.appendChild(noResults);
            }
        } else {
            let noResults = document.getElementById("noResults");
            if (noResults) {
                noResults.remove();
            }
        }
    });
    </script>
</body>
</html>
<?php
?>
