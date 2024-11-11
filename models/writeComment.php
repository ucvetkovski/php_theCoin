<?php
session_start();
if (isset($_POST['userId'])) {
    $user = $_POST['userId'];
}
if (isset($_POST['postId'])) {
    $post = $_POST['postId'];
}
if (isset($_POST['comment'])) {
    $text = $_POST['comment'];
}

include("../config/functions.php");

if (isset($_SESSION['sessionHolder'])) {
    if (isset($user)) {
        $added = addComment($user, $post, $text);
        if ($added) {
            header('Location: ../index.php?page=postPage&id=' . $post . "#comments");
        } else {
            $reply = ["reply" => "Could not add Your comment."];
            echo json_encode($reply);
            http_response_code(500);
        }
    }
} else {
    header('Location: ../index.php?page=login');

}

?>