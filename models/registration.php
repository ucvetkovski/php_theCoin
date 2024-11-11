<?php
header("Content-type: application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../config/functions.php');


    try {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passworkCheck = $_POST['passwordCheck'];

        $nameRegEx = '/^[A-Z -ŠĐŽČĆ][a-z -šđžčć]*(([,.] |[ \'-])[A-Za-z -ŠĐŽČĆšđžčć][a-zšđžčć]*)*(\.?)$/';
        $mailRegEx = '/^[a-zA-Z0-9\.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/';
        $passRegEx = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';


        if (preg_match($nameRegEx, $firstName) && preg_match($nameRegEx, $lastName) && preg_match($mailRegEx, $email) && preg_match($passRegEx, $password) && $password == $passworkCheck) {
            $encryptedPassword = md5($password);
            $token = bin2hex(openssl_random_pseudo_bytes(32));
            $addedUser = addUser($firstName, $lastName, $email, $username, $encryptedPassword, $token);
            if ($addedUser) {
                $reply = ["reply" => "Registration successful. Check Your email for an account activation link."];
                echo json_encode($reply);
                http_response_code(201);
            } else {
                $reply = ["reply" => "An account with this username/email already exists."];
                echo json_encode($reply);
                http_response_code(500);
            }
        } else {
            $reply = ["reply" => "Invalid data."];
            echo json_encode($reply);
            http_response_code(503);
        }
    } catch (PDOException $exception) {
        $reply = ["reply" => "An account with this username/email already exists."];
        echo json_encode($reply);
        http_response_code(500);
    }
} else {
    header('Location: ../models/404.php');
}
?>