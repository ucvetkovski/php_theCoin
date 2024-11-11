<?php
include("../config/functions.php");

$idToDelete = $_POST['id'];
$deleted = deletePost($idToDelete);
header('Location: ../index.php?page=postAdmin');
?>