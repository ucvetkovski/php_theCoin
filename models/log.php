<?php

function iif($tst, $cmp, $bad)
{
    return (($tst == $cmp) ? $cmp : $bad);
}

$ipaddress = $_SERVER['REMOTE_ADDR'];
$user = '';
$userEmail = '';
if (isset($_SESSION['sessionHolder'])) {
    $user = $_SESSION['sessionHolder']->username;
    $userEmail = $_SESSION['sessionHolder']->email;
    $userRole = $_SESSION['sessionHolder']->user_role;
} else {
    $user = 'Guest';
    $userEmail = 'Guest';
    $userRole = '2';
}

$page = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
$page .= iif(
    !empty($_SERVER['QUERY_STRING']),
    "?{$_SERVER['QUERY_STRING']}",
    ""
);
$datetime = time();
// $datetime = mktime($now);


$logline = $ipaddress . '|' . $user . '|' . $userEmail . '|' . $datetime
    . '|' . $page . '|' . $userRole . "\n";
// Write to log file:
$logfile = 'data/log.txt';
// Open the log file in "Append" mode
if (!$handle = fopen($logfile, 'a+')) {
    die("Failed to open log file");
}
// Write $logline to our logfile.
if (fwrite($handle, $logline) === FALSE) {
    die("Failed to write to log file");
}
fclose($handle);
?>