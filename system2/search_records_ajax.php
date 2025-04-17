<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "documents_system_number";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນຜິດພາດ: " . $conn->connect_error);
}

$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT id, record_date, document_number, document_name, signer, department, approver, file_path FROM document_log";
$where_clause = array();
$params = array();
$data_types = "";

if (!empty($keyword)) {
    $where_clause[] = "(document_number LIKE ? OR document_name LIKE ? OR signer LIKE ? OR department LIKE ? OR approver LIKE ?)";
    $params = array_merge($params, array("%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%"));
    $data_types .= "sssss";
}

if (!empty($where_clause)) {
    $sql .= " WHERE " . implode(" AND ", $where_clause);
}

$sql .= " ORDER BY record_date DESC LIMIT ?, ?";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($data_types . "ii", ...array_merge($params, [$offset, $limit]));
} else {
    $stmt->bind_param("ii", $offset, $limit);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<thead><tr><th>ລໍາດັບ</th><th>ວັນທີ</th><th>ເລກທີເອກະສານ</th><th>ຊື່ເອກະສານ</th><th>ຜູ້ຮອງ</th><th>ພະແນກ</th><th>ຜູ້ອະນຸມັດ</th><th>ໄຟລ໌</th><th>ການກະທຳ</th></tr></thead>";
    echo "<tbody>";
    $row_number = ($page - 1) * $limit + 1;
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row_number . "</td>";
        echo "<td>" . $row["record_date"] . "</td>";
        echo "<td>" . $row["document_number"] . "</td>";
        echo "<td>" . $row["document_name"] . "</td>";
        echo "<td>" . $row["signer"] . "</td>";
        echo "<td>" . $row["department"] . "</td>";
        echo "<td>" . $row["approver"] . "</td>";
        echo "<td>";
        if (!empty($row["file_path"])) {
            echo "<a href='" . $row["file_path"] . "' target='_blank'>ເບິ່ງໄຟລ໌</a>";
        } else {
            echo "-";
        }
        echo "</td>";
        echo "<td>";
        echo "<a href='edit_record.php?id=" . $row["id"] . "' class='btn btn-sm btn-warning'>ແກ້ໄຂ</a> ";
        echo "<a href='delete_record.php?id=" . $row["id"] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"ທ່ານແນ່ໃຈບໍວ່າຕ້ອງການລຶບບັນທຶກນີ້?\")'>ລົບ</a>";
        echo "</td>";
        echo "</tr>";
        $row_number++;
    }
    echo "</tbody></table>";
} else {
    echo "<p>ບໍ່ພົບຂໍ້ມູນ.</p>";
}

$stmt->close();
$conn->close();
?>