<?php
$config = include('/usr/secure/config.php');
$password = escapeshellarg($config['password']);

header('Content-Type: application/json');

$output = shell_exec("
echo "test"
");
echo json_encode(['output' => trim($output)]);
?>