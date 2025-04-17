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
$sql = "DELETE FROM document_log WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<script>alert('ລົບບັນທຶກສໍາເລັດ!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('ເກີດຂໍ້ຜິດພາດໃນການລົບບັນທຶກ: " . $conn->error . "'); window.location.href='index.php';</script>";
}

$stmt->close();
$conn->close();
?>