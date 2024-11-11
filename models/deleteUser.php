<?php
include("../config/functions.php");

$idToDelete = $_POST['id'];
$userRole = $_POST['role'];
echo (deleteUser($idToDelete, $userRole));
?>