<?php
if (isset($_FILES["document_file"]) && $_FILES["document_file"]["error"] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["document_file"]["name"]);
    $uploadOk = 1;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = array("pdf", "docx", "doc", "jpg", "jpeg", "png");
    if (!in_array($file_type, $allowed_types)) {
        echo "ຂໍອະໄພ, ໄຟລ໌ປະເພດນີ້ບໍ່ໄດ້ຮັບອະນຸຍາດ.";
        $uploadOk = 0;
    }

    if ($_FILES["document_file"]["size"] > 5000000) {
        echo "ຂໍອະໄພ, ໄຟລ໌ຂອງທ່ານໃຫຍ່ເກີນໄປ.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["document_file"]["tmp_name"], $target_file)) {
            echo "ໄຟລ໌ " . htmlspecialchars(basename($_FILES["document_file"]["name"])) . " ໄດ້ຖືກອັບໂຫຼດສຳເລັດ.";
        } else {
            echo "ຂໍອະໄພ, ມີຂໍ້ຜິດພາດໃນການອັບໂຫຼດໄຟລ໌.";
        }
    }

} else {
    echo "ບໍ່ມີໄຟລ໌ຖືກອັບໂຫຼດ ຫຼືມີຂໍ້ຜິດພາດ: " . $_FILES["document_file"]["error"];
}
?>