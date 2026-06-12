<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=spmbm-online', 'root', '');
$stmt = $db->query("SHOW COLUMNS FROM tbl_siswa LIKE 'status_keluarga'");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($result)) {
    echo "COLUMN DOES NOT EXIST";
} else {
    echo "COLUMN EXISTS: " . print_r($result, true);
}
