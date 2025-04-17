<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "documents_system_number";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນຜິດພາດ: " . $conn->connect_error);
}

$id = $_POST["id"];
$record_date = $_POST["record_date"];
$document_number = $_POST["document_number"]; // ຮັບເລກທີເອກະສານ
$document_name = $_POST["document_name"];
$signer = $_POST["signer"];
$department = $_POST["department"];
$approver = $_POST["approver"];

// ປັບປຸງຄໍາສັ່ງ SQL ເພື່ອລວມເອົາ document_number
$sql = "UPDATE document_log SET record_date = ?, document_number = ?, document_name = ?, signer = ?, department = ?, approver = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi", $record_date, $document_number, $document_name, $signer, $department, $approver, $id);

if ($stmt->execute()) {
    echo "<script>alert('ອັບເດດບັນທຶກສໍາເລັດ!'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('ເກີດຂໍ້ຜິດພາດໃນການອັບເດດບັນທຶກ: " . $conn->error . "'); window.location.href='index.php';</script>";
}

$stmt->close();
$conn->close();
?>