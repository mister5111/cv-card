<?php
header('Content-Type: application/json');
$output = shell_exec('curl -p 2ip.ua');
echo json_encode(['output' => $output]);
?>
