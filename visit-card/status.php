<?php
header('Content-Type: application/json');

$statusFile = '/var/www/visit-card/status.txt';

if (file_exists($statusFile)) {
    echo json_encode(["status" => trim(file_get_contents($statusFile))]);
} else {
    echo json_encode(["status" => "idle"]);
}
?>
