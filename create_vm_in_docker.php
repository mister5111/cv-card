<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

function sendStatus($status) {
    echo "data: " . json_encode(["status" => $status]) . "\n\n";
    ob_flush();
    flush();
}

$command = "/var/www/visit-card/script/run_vm_docker";
$process = popen($command, 'r');

if ($process) {
    while (!feof($process)) {
        $line = fgets($process);
        if ($line) {
            if (strpos($line, 'status=true') !== false) {
                sendStatus("✅ Status ON");
            } elseif (strpos($line, 'status=false') !== false) {
                sendStatus("✅ Status OFF");
            } else {
                sendStatus(trim($line));
            }

            sendStatus(trim($line));
            ob_flush();
            flush(); 
        }
        usleep(50000);
    }

    sendStatus("Destroy complete!");
    flush();

    pclose($process);
} else {
    sendStatus("Error: Unable to start the process.");
}
?>
