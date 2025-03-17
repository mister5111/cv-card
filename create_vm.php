<?php
header('Content-Type: application/json');

$password = getenv('PASSWORD');

$escaped_password = escapeshellarg($password);

$output = shell_exec("echo $escaped_password");

echo json_encode(['output' => trim($output)]);
?>