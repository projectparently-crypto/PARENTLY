<?php
header("Content-Type: application/json; charset=utf-8");

ini_set('display_errors', 0);
error_reporting(0);

include "db.php";

$result = $conn->query("SELECT * FROM foros");

if (!$result) {
    echo json_encode([
        "error" => true,
        "data" => []
    ]);
    exit;
}

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
exit;