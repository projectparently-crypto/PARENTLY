<?php

header("Content-Type: application/json");
include "db.php";
error_reporting(0);

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

echo json_encode($data ?: []);

exit;