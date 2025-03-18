<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

$command = "/var/www/visit-card/run";
$process = popen($command, 'r');

if ($process) {
    while (!feof($process)) {
        $line = fgets($process);
        if ($line) {
            echo "data: " . json_encode(["status" => trim($line)]) . "\n\n";
            ob_flush();
            flush();
        }
    }
    pclose($process);
}

echo "data: " . json_encode(["status" => "completed"]) . "\n\n";
flush();
?>
