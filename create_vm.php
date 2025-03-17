<?php
header('Content-Type: application/json');
$output = shell_exec('
ls -la
');
echo json_encode(['output' => $output]);
?>
