<?php
// ຕັ້ງຄ່າການເຊື່ອມຕໍ່ຖານຂໍ້ມູນ
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "documents_system_number";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນຜິດພາດ: " . $conn->connect_error);
}

$record_date = $_POST["record_date"];
$document_name = $_POST["document_name"];
$signer = $_POST["signer"];
$department = $_POST["department"];
$approver = $_POST["approver"];
$file_path = "";
$uploadOk = 1;
$upload_error_message = ""; // ເພີ່ມຕົວແປສໍາລັບເກັບຂໍ້ຄວາມຜິດພາດ

if (isset($_FILES["document_file"])) {
    if ($_FILES["document_file"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["document_file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array("pdf", "docx", "doc", "jpg", "jpeg", "png");
        if (!in_array($file_type, $allowed_types)) {
            $upload_error_message = "ຂໍອະໄພ, ໄຟລ໌ປະເພດນີ້ບໍ່ໄດ້ຮັບອະນຸຍາດ.";
            $uploadOk = 0;
        }

        if ($_FILES["document_file"]["size"] > 5000000) {
            $upload_error_message = "ຂໍອະໄພ, ໄຟລ໌ຂອງທ່ານໃຫຍ່ເກີນໄປ.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["document_file"]["tmp_name"], $target_file)) {
                $file_path = $target_file;
            } else {
                $upload_error_message = "ຂໍອະໄພ, ມີຂໍ້ຜິດພາດໃນການອັບໂຫຼດໄຟລ໌.";
                $uploadOk = 0;
            }
        }
    } else {
        $upload_error_message = "ເກີດຂໍ້ຜິດພາດໃນການອັບໂຫຼດໄຟລ໌: " . $_FILES["document_file"]["error"];
        $uploadOk = 0;
    }
} else {
    // ບໍ່ມີໄຟລ໌ຖືກເລືອກ
}

// ສ້າງເລກທີເອກະສານອັດຕະໂນມັດ
// ດຶງເລກທີຫຼ້າສຸດຈາກຖານຂໍ້ມູນ
$sql_last_number = "SELECT document_number FROM document_log WHERE document_number LIKE 'LXH/%' ORDER BY id DESC LIMIT 1";
$result_last_number = $conn->query($sql_last_number);

$next_number = 1;
if ($result_last_number->num_rows > 0) {
    $row_last_number = $result_last_number->fetch_assoc();
    $last_number = str_replace("LXH/", "", $row_last_number["document_number"]);
    if (is_numeric($last_number)) {
        $next_number = intval($last_number) + 1;
    }
}

// ຈັດຮູບແບບເລກທີໃໝ່
$document_number = "LXH/" . sprintf("%04d", $next_number); // LXH/0001, LXH/0002, ...

// ບັນທຶກຂໍ້ມູນເຂົ້າຖານຂໍ້ມູນ
$sql = "INSERT INTO document_log (record_date, document_number, document_name, signer, department, approver, file_path)
VALUES ('$record_date', '$document_number', '$document_name', '$signer', '$department', '$approver', '$file_path')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('ບັນທຶກຂໍ້ມູນສໍາເລັດ!'); window.location.href='index.php';</script>";
} else {
    echo "ເກີດຂໍ້ຜິດພາດໃນການບັນທຶກຂໍ້ມູນ: " . $conn->error;
}

if (!empty($upload_error_message)) {
    echo "<script>alert('" . $upload_error_message . "');</script>";
}

$conn->close();
?>