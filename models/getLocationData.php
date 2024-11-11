<?php
$myIp = '188.120.116.240';
if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
    $ip = $_SERVER['REMOTE_ADDR'];
    echo json_encode(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip)));
} else {
    echo json_encode(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $myIp)));
}

?>