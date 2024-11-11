<?php

include("../config/functions.php");
session_start();

if (isset($_POST['editProfile'])) {
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
    if (isset($_POST['newPassword'])) {
        $newPassword = $_POST['newPassword'];
    }
    if (isset($_FILES['file'])) {
        $filename = $_FILES['file']['name'];
    }

    try {
        if ($filename != '') {
            /* Location */
            $dbLocation = time() . $filename;
            $location = "../assets/img/upload/" . time() . $filename;
            $filenameToAdd = time() . $_FILES['file']['name'];
            $uploadOk = 1;
            $imageFileType = pathinfo($location, PATHINFO_EXTENSION); /* Valid Extensions */
            $valid_extensions = array("jpg", "jpeg", "png");
            if (!in_array(strtolower($imageFileType), $valid_extensions)) {
                $uploadOk = 1;
            }
            if ($uploadOk == 0) {
            } else {
                if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {

                    saveUserChanges($id, $firstName, $lastName, $username, $email, $newPassword, 0, $dbLocation);
                    createThumbnails($dbLocation, $_FILES['file']['type']);
                    header('Location: ../index.php?page=profile');
                    exit();
                } else {
                    return 0;
                }
            }
        } else {
            $dbLocation = 0;
            saveUserChanges($id, $firstName, $lastName, $username, $email, $newPassword, 0, $dbLocation);
            header('Location: ../index.php?page=profile');
        }
    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
    }
} else {

    $nameRegEx = '/^[A-Z -ŠĐŽČĆ][a-z -šđžčć]*(([,.] |[ \'-])[A-Za-z -ŠĐŽČĆšđžčć][a-zšđžčć]*)*(\.?)$/';
    $mailRegEx = '/^[a-zA-Z0-9\.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/';
    $passRegEx = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/';


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

    try {
        if (preg_match($nameRegEx, $firstName) && preg_match($nameRegEx, $firstName) && preg_match($mailRegEx, $email)) {
            saveUserChanges($id, $firstName, $lastName, $username, $email, $password, $role, 0);
            header("Location: ../index.php?page=userAdmin");
        }

    } catch (PDOException $e) {
        $errorMessage = $e->getMessage();
    }
}
?>