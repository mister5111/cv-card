<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

function sendStatus($status) {
    echo "data: " . json_encode(["status" => $status]) . "\n\n";
    ob_flush();
    flush();
}

sendStatus("queued");
sleep(2);

sendStatus("in_progress");
sleep(10);

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

sendStatus("completed");
?>
