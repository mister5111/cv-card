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
error_log("Получено: " . json_encode(["status" => $status]));
if ($process) {
    while (!feof($process)) {
        $line = fgets($process);
        if ($line) {
            sendStatus(trim($line));
        }
    }
    pclose($process);
}

?>
