<?php
header('Content-Type: application/json');
$output = shell_exec('
echo "test"
');
echo json_encode(['output' => $output]);
?>
