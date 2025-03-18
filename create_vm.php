<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

$statusFile = '/var/www/visit-card/status.txt';

function sendStatus($status) {
    global $statusFile;
    file_put_contents($statusFile, $status); // Сохраняем статус
    echo "data: " . json_encode(["status" => $status]) . "\n\n";
    ob_flush();
    flush();
}

// Если скрипт уже запущен, просто отдаем текущий статус
if (file_exists($statusFile)) {
    $currentStatus = trim(file_get_contents($statusFile));
    if ($currentStatus !== "completed") {
        sendStatus($currentStatus);
        exit;
    }
}

// Начало выполнения
sendStatus("queued");
sleep(2);

sendStatus("in_progress");
sleep(10); // Симуляция выполнения

// Запускаем Bash-скрипт
$command = "/var/www/visit-card/run";
$process = popen($command, 'r');

if ($process) {
    while (!feof($process)) {
        $line = fgets($process);
        if ($line) {
            sendStatus(trim($line));
        }
    }
    pclose($process);
}

// Завершение работы
sendStatus("completed");
unlink($statusFile); // Удаляем файл статуса
?>

