<?php

define("dbname", "coin");
define("host", "127.0.0.1");
define("username", "root");
define("password", "");

try {
    $connection = new PDO("mysql:host=" . host . ";dbname=" . dbname . ";charset=utf8", username);

    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo ($exception->getMessage());
}

?>