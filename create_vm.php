<?php
$config = include('/usr/secure/config.php');
$password = $config['password'];

header('Content-Type: application/json');
$output = shell_exec('
echo $password
');
echo json_encode(['output' => $output]);
?>
