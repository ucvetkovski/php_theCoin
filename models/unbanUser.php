<?php
include("../config/functions.php");

$id = $_POST['id'];
$unban = unbanUser($id);
if ($unban) {
    return "../index.php?page=userAdmin";
}
?>