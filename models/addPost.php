<?php
session_start();
include("../config/functions.php");

$userID = $_SESSION['sessionHolder']->user_id;
$title = $_POST['postTitle'];
$category = $_POST['cat'];
if (isset($_POST['subCat'])) {
    $subcategory = $_POST['subCat'];
} else {
    $subcategory = 0;
}
$text = $_POST['postText'];
$filename = $_FILES['file']['name'];


/* Location */
$dbLocation = "assets/img/upload/" . time() . $filename;
$location = "../assets/img/upload/" . time() . $filename;
$filenameToAdd = time() . $_FILES['file']['name'];
$uploadOk = 1;
$imageFileType = pathinfo($location, PATHINFO_EXTENSION); /* Valid Extensions */
$valid_extensions = array("jpg", "jpeg", "png");
/* Check file extension */
if (!in_array(strtolower($imageFileType), $valid_extensions)) {
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo 0;
} else {
    /* Upload file */
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        insertPost($userID, $title, $category, $subcategory, $dbLocation, $text);
        header('Location: ../index.php?page=posts');
        exit();
    } else {
        return 0;
    }
}
?>