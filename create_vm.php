<?php
require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Загружаем переменные окружения из .env
$dotenv = Dotenv::createImmutable('/var/www/visit-card');
$dotenv->load();


var_dump($_ENV);
var_dump(getenv('TOKEN'));
var_dump($_SERVER['TOKEN']);
// Получаем токен из переменных окружения
$token = $_ENV['TOKEN'] ?? null;

if (!$token) {
    die(json_encode(['error' => 'TOKEN не найден в .env']));
}

// Отправляем запрос в GitHub API
$payload = json_encode(['ref' => 'main']);
$ch = curl_init('https://api.github.com/repos/mister5111/Gcloud-VM/actions/workflows/destroy.yml/dispatches');

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/vnd.github.v3+json',
    "Authorization: token $token",
    'User-Agent: PHP-CURL',
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo json_encode([
    'status' => $http_code,
    'response' => json_decode($response, true)
]);
?>
