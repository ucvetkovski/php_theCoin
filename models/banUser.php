<?php
include("../config/functions.php");

$idToBan = $_POST['id'];
$ban = banUser($idToBan);
if ($ban) {
    return "../index.php?page=userAdmin";
}
?>