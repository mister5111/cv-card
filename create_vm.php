<?php
header('Content-Type: application/json');
$output = shell_exec('
sudo /var/www/visit-card/run
');
echo json_encode(['output' => $output]);
?>