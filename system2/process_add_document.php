<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $document_name = trim($_POST["document_name"]);

    // ສ້າງເລກທີເອກະສານ (ຕົວຢ່າງ: YYYY-ລຳດັບ)
    $current_year = date("Y");
    $sql_count = "SELECT COUNT(*) AS total FROM documents WHERE YEAR(created_at) = :year";
    $stmt_count = $pdo->prepare($sql_count);
    $stmt_count->bindParam(":year", $current_year);
    $stmt_count->execute();
    $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
    $next_number = str_pad($row_count['total'] + 1, 3, '0', STR_PAD_LEFT); // ໃຫ້ມີ 3 ຕົວເລກສະເໝີ
    $document_number = $current_year . "-" . $next_number;

    // ບັນທຶກຂໍ້ມູນລົງໃນຖານຂໍ້ມູນ
    $sql_insert = "INSERT INTO documents (document_number, document_name) VALUES (:doc_num, :doc_name)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->bindParam(":doc_num", $document_number);
    $stmt_insert->bindParam(":doc_name", $document_name);

    if ($stmt_insert->execute()) {
        header("location: index.php"); // ກັບໄປໜ້າຫຼັກຫຼັງຈາກບັນທຶກສຳເລັດ
        exit();
    } else {
        echo "ເກີດຂໍ້ຜິດພາດໃນການບັນທຶກ.";
    }
}
?>