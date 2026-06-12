<?php
$db = new mysqli('localhost', 'root', '', 'spmb_db');
if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}
$r = $db->query('DESCRIBE tbl_berkas');
if (!$r) {
    die('Error: ' . $db->error);
}
echo "Columns in tbl_berkas:\n";
while ($row = $r->fetch_assoc()) {
    echo "  " . $row['Field'] . " - " . $row['Type'] . " - " . $row['Null'] . " - " . $row['Key'] . "\n";
}
$db->close();
