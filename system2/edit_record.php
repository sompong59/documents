<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "documents_system_number";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນຜິດພາດ: " . $conn->connect_error);
}

$id = $_GET["id"];
$sql = "SELECT id, record_date, document_number, document_name, signer, department, approver FROM document_log WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ແກ້ໄຂບັນທຶກເອກະສານ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>ແກ້ໄຂບັນທຶກເອກະສານ</h1>

    <form action="update_record.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
        <div>
            <label for="record_date">ວັນທີບັນທຶກ:</label>
            <input type="date" id="record_date" name="record_date" value="<?php echo $row["record_date"]; ?>" required>
        </div>
        <br>
        <div>
            <label for="document_number">ເລກທີເອກະສານ:</label>
            <input type="text" id="document_number" name="document_number" value="<?php echo $row["document_number"]; ?>">
        </div>
        <br>
        <div>
            <label for="document_name">ຊື່ເອກະສານ:</label>
            <input type="text" id="document_name" name="document_name" value="<?php echo $row["document_name"]; ?>" required>
        </div>
        <br>
        <div>
            <label for="signer">ຜູ້ຮອງ:</label>
            <input type="text" id="signer" name="signer" value="<?php echo $row["signer"]; ?>">
        </div>
        <br>
        <div>
            <label for="department">ພະແນກ:</label>
            <input type="text" id="department" name="department" value="<?php echo $row["department"]; ?>">
        </div>
        <br>
        <div>
            <label for="approver">ຜູ້ອະນຸມັດ:</label>
            <input type="text" id="approver" name="approver" value="<?php echo $row["approver"]; ?>">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">ອັບເດດ</button>
        <a href="index.php" class="btn btn-secondary">ຍົກເລີກ</a>
    </form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>