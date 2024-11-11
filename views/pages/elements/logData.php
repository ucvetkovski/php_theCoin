<?php
$last5mins = time() - 300;
$last30mins = time() - 30 * 60;
$last12h = time() - 172800 / 4;
$last24h = time() - 172800 / 2;
$last48h = time() - 172800;
$time = '';



$logfile = "data/log.txt";
if (file_exists($logfile)) {
    $handle = fopen($logfile, "r");
    $log = fread($handle, filesize($logfile));
    fclose($handle);
} else {
    die("Log file doesn't exist.");
}
$log = explode("\n", trim($log));
for ($i = 0; $i < count($log); $i++) {
    $log[$i] = trim($log[$i]);
    $log[$i] = explode('|', $log[$i]);
}


countVisits($log, $last24h);
countVisitsNum($log, $last24h);
countUserVisits($log, $last24h);
showLogData($log, $last24h);

// switch ($logTime) {
//     case '12h':
//         $time = $last12h;
//         writeTable($time);
//         break;
//     case '24h':
//         $time = $last24h;
//         writeTable($time);
//         break;
//     case '48h':
//         $time = $last48h;
//         writeTable($time);
//         break;
//     default:
//         $time = $last12h;
//         writeTable($time);
// }

?>