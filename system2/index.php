<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ລະບົບບັນທຶກເອກະສານ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Lao+Looped:wght@100..900&family=Noto+Serif+Lao:wght@100..900&display=swap');
*{
    box-sizing: border-box;
}
body{
    font-family: "Noto Sans Lao Looped", sans-serif;
}
</style>

<body>
<div class="container">
        <h1>ລະບົບບັນທຶກເອກະສານ</h1>
        <form action="process_record.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6 ">
                    <div>
                        <label for="record_date" class="form-label">ວັນທີບັນທຶກ:</label>
                        <input type="date" id="record_date" name="record_date" value="<?php echo date('Y-m-d'); ?>" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <label for="document_number" class="form-label">ເລກທີເອກະສານ:</label>
                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "documents_system_number";

                        $conn_auto_num = new mysqli($servername, $username, $password, $dbname);
                        if ($conn_auto_num->connect_error) {
                            die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນຜິດພາດ: " . $conn_auto_num->connect_error);
                        }
                        $sql_last_number = "SELECT document_number FROM document_log WHERE document_number LIKE 'LXH/%' ORDER BY id DESC LIMIT 1";
                        $result_last_number = $conn_auto_num->query($sql_last_number);
                        $next_number = 1;
                        if ($result_last_number->num_rows > 0) {
                            $row_last_number = $result_last_number->fetch_assoc();
                            $last_number = str_replace("LXH/", "", $row_last_number["document_number"]);
                            if (is_numeric($last_number)) {
                                $next_number = intval($last_number) + 1;
                            }
                        }
                        $auto_document_number = "LXH/" . sprintf("%04d", $next_number);
                        $conn_auto_num->close();
                        ?>
                        <input type="text" id="document_number" name="document_number" value="<?php echo $auto_document_number; ?>" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div>
                        <label for="document_name" class="form-label">ຊື່ເອກະສານ:</label>
                        <input type="text" id="document_name" name="document_name" class="form-control" required>
                    </div>
                </div>
                
            </div>
            <div class="row mb-3">
            <div class="col-md-4">
                    <div>
                        <label for="signer" class="form-label">ຜູ້ຮອງ:</label>
                        <input type="text" id="signer" name="signer" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <label for="department" class="form-label">ພະແນກ:</label>
                        <input type="text" id="department" name="department" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <label for="approver" class="form-label">ຜູ້ອະນຸມັດ:</label>
                        <input type="text" id="approver" name="approver" class="form-control">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <label for="document_file" class="form-label">ໄຟລ໌ເອກະສານ (PDF, DOCX, etc.):</label>
                        <input type="file" id="document_file" name="document_file" class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">ບັນທຶກ</button>
        </form>

        <hr>
                    </div>

                    <div style="max-width: 90%; margin: 0 auto;">                
                    <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>ລາຍການບັນທຶກ</h2>
            <form id="searchForm" class="d-flex align-items-center">
                <div class="me-2">
                    <label for="search_keyword" class="form-label visually-hidden">ຄົ້ນຫາ:</label>
                    <input type="text" class="form-control" id="search_keyword" name="search_keyword" onkeyup="searchRecords()" placeholder="ຄົ້ນຫາ...">
                </div>
                <!-- <button type="button" class="btn btn-primary me-2" onclick="searchRecords()">ຄົ້ນຫາ</button> -->
                <button type="button" class="btn btn-success" onclick="clearSearch()">ລ້າງການຄົ້ນຫາ</button>
            </form>
        </div>

        <hr>

    <hr>

    <div id="searchResults" style="padding-left: 15px; padding-right: 15px;">
    
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "documents_system_number";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("ການເຊື່ອມຕໍ່ຖານຂໍ້ມູນຜິດພາດ: " . $conn->connect_error);
    }

    $sql = "SELECT id, record_date, document_number, document_name, signer, department, approver, file_path FROM document_log";
    $where_clause = array();
    $params = array();
    $data_types = "";

    if (isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) {
        $keyword = mysqli_real_escape_string($conn, $_GET['search_keyword']);
        $where_clause[] = "(document_number LIKE ? OR document_name LIKE ? OR signer LIKE ? OR department LIKE ? OR approver LIKE ?)";
        $params = array_merge($params, array("%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%", "%".$keyword."%"));
        $data_types .= "sssss";
    }

    if (!empty($where_clause)) {
        $sql .= " WHERE " . implode(" AND ", $where_clause);
    }

    $sql .= " ORDER BY record_date DESC";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($data_types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table class='table table-hover'>";
        echo "<thead><tr><th>ລໍາດັບ</th><th>ວັນທີ</th><th>ເລກທີເອກະສານ</th><th>ຊື່ເອກະສານ</th><th>ຜູ້ຮອງ</th><th>ພະແນກ</th><th>ຜູ້ອະນຸມັດ</th><th>ໄຟລ໌</th><th>ການກະທຳ</th></tr></thead>";
        echo "<tbody>";
        $row_number = 1;
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
    
    </div> 
    
    
    <div  class="mt-3 d-flex justify-content-start align-items-center">
            <!-- <label for="recordsPerPage" class="form-label me-2">ສະແດງ:</label> -->
            <select class="form-select form-select-sm w-auto" id="recordsPerPage" onchange="changeRecordsPerPage(this.value)">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="ms-2">ແຖວ</span>
        </div> 
        </div>

    <script>
function searchRecords() {
    var keyword = document.getElementById("search_keyword").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("searchResults").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "search_records_ajax.php?keyword=" + keyword, true);
    xhttp.send();
}

function clearSearch() {
    document.getElementById("search_keyword").value = "";
    searchRecords(); // ເພື່ອສະແດງຂໍ້ມູນທັງໝົດຄືນໃໝ່
}

//ກຳຂົດຈຳນວນແຖວຕາຕະລາງ
let currentPage = 1;
        let recordsPerPage = document.getElementById("recordsPerPage").value;

        function changeRecordsPerPage(newValue) {
            recordsPerPage = newValue;
            currentPage = 1; // Reset to the first page when changing records per page
            loadRecords(currentPage, recordsPerPage, document.getElementById("search_keyword").value);
        }

        function searchRecords() {
            currentPage = 1; // Reset to the first page on new search
            loadRecords(currentPage, recordsPerPage, document.getElementById("search_keyword").value);
        }

        function clearSearch() {
            document.getElementById("search_keyword").value = "";
            currentPage = 1; // Reset to the first page after clearing search
            loadRecords(currentPage, recordsPerPage, "");
        }

        function loadRecords(page, limit, keyword) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("searchResults").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "search_records_ajax.php?page=" + page + "&limit=" + limit + "&keyword=" + keyword, true);
            xhttp.send();
        }

        // Load initial records
        loadRecords(currentPage, recordsPerPage, "");
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>