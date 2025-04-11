<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

function sendStatus($status) {
    echo "data: " . json_encode(["status" => $status]) . "\n\n";
    ob_flush();
    flush();
}

$var1a = isset($_GET["var1a"]) ? escapeshellarg($_GET["var1a"]) : '';
if (!$var1a) {
    sendStatus("Error: VM name is required!");
    exit;
}

$command = "/var/www/visit-card/script/run_vm " . $var1a;
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

    sendStatus("Destroy complete!");
    flush();

    pclose($process);
}

?>
