<?php
header('Content-Type: application/json');

require __DIR__ . '/vendor/autoload.php';  
$dotenv = Dotenv\Dotenv::createImmutable('/var/www/visit-card/');
$dotenv->load();

$password = getenv('PASSWORD'); 

if (!$password) {
    echo json_encode(['error' => 'Переменная PASSWORD не найдена']);
    exit;
}

$output = shell_exec("echo " . escapeshellarg($password));

if (!$output) {
    echo json_encode(['error' => 'shell_exec() не вернул данных']);
    exit;
}

echo json_encode(['output' => trim($output)]);
?>
