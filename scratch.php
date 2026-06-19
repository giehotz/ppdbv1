<?php
$db = new PDO('mysql:host=localhost;dbname=spmb_db', 'root', '');
$stmt = $db->query('SELECT status_verifikasi, COUNT(*) as count FROM tbl_siswa GROUP BY status_verifikasi');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
