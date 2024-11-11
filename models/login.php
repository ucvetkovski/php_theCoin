<?php
session_start();
header("Content-type: application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../config/functions.php');
    try {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $passRegEx = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';
        if (preg_match($passRegEx, $password)) {
            $encryptedPassword = md5($password);
            $login = tryLogin($username, $encryptedPassword);
            if ($login) {
                if ($login->activation_status == 1 && $login->ban_status == 0) {
                    $_SESSION['sessionHolder'] = $login;
                    $reply = ["reply" => "index.php"];
                    echo json_encode($reply);
                    http_response_code(200);
                }
            } else if (!checkName($username)) {
                $reply = ["reply" => "There is no such user with the given email/username."];
                echo json_encode($reply);
                http_response_code(500);
            } else {
                $reply = ["reply" => "Something's amiss, check Your credentials."];
                echo json_encode($reply);
                http_response_code(500);
            }
        }
    } catch (PDOException $exception) {
        $reply = ["reply" => "An error occured while trying to connect to the database."];
        echo json_encode($reply);
        http_response_code(500);
    }
}
?>