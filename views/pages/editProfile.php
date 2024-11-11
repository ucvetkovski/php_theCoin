<?php
$user = $_GET['id'];
if ($_SESSION['sessionHolder']->user_id != $user) {

    echo ($_SESSION['sessionHolder']->user_id);
    header("Location: index.php?page=403");
} else {
    include("models/getProfileForm.php");
}
?>