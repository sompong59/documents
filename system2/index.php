<?php
require_once 'config.php';

$sql = "SELECT * FROM documents ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>ບັນທຶກເລກທີເອກະສານ</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>ບັນຊີລາຍການເອກະສານ</h1>
    <p><a href="add_document.php">ເພີ່ມເອກະສານໃໝ່</a></p>

    <?php if (!empty($documents)): ?>
        <table>
            <thead>
                <tr>
                    <th>ເລກທີເອກະສານ</th>
                    <th>ຊື່ເອກະສານ</th>
                    <th>ວັນທີສ້າງ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documents as $document): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($document['document_number']); ?></td>
                        <td><?php echo htmlspecialchars($document['document_name']); ?></td>
                        <td><?php echo htmlspecialchars($document['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>ບໍ່ມີເອກະສານໃນລະບົບ.</p>
    <?php endif; ?>
</body>
</html>