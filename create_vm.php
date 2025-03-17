<?php
header('Content-Type: application/json');
$output = shell_exec('
$password = getenv('PASSWORD');
');
echo json_encode(['output' => $output]);
?>
