<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

function sendStatus($status) {
    echo "data: " . json_encode(["status" => $status]) . "\n\n";
    ob_flush();
    flush();
}

$command = "/var/www/visit-card/run";
$process = popen($command, 'r');

if ($process) {
    while (!feof($process)) {
        $line = fgets($process);
        if ($line) {
            sendStatus(trim($line));
            ob_flush();
            flush(); 
        }
        usleep(50000); 
    }

    sendStatus("Скрипт завершен!");
    flush();

    pclose($process);
}

?>
