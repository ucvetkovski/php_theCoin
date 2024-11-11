<?php

if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['editName'])) {
    $firstName = $_POST['editName'];
}
if (isset($_POST['editLastName'])) {
    $lastName = $_POST['editLastName'];
}
if (isset($_POST['editUsername'])) {
    $username = $_POST['editUsername'];
}
if (isset($_POST['editEmail'])) {
    $email = $_POST['editEmail'];
}
if (isset($_POST['editPassword'])) {
    $password = $_POST['editPassword'];
}
if (isset($_POST['roleSelect'])) {
    $role = $_POST['roleSelect'];
}

include('../config/functions.php');

$insert = saveUserChanges($id, $firstName, $lastName, $username, $email, $password, $role, $dbLocation);

if ($insert) {
    header("Location: ../index.php?page=postAdmin");
    exit;
} else {

    $reply = ["reply" => "An error occured."];
    echo json_encode($reply);
    http_response_code(500);
}

?>