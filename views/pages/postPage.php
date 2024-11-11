<?php
$id = $_GET['id'];

$result = getPost($id);

if (isset($_SESSION['sessionHolder'])) {
    $user = $_SESSION['sessionHolder']->user_id;
} else {
    $user = 0;
}

$recommendations = generateRecommendations($id);
$recArray = [];
foreach ($recommendations as $post) {
    $recArray[] = getPost($post);
}

$timePub = strtotime($result->publication_date);
$datePub = date("d/M/Y H:i:s", $timePub);
echo ("
    <div class='col-md-12 col-lg-12 d-flex flex-row justify-content-between postClassPage'>
        <div class='row col-md-10'>
            <div class='col-lg-10 col-md-12 d-flex flex-column'>
                <div class='d-flex flex-column p-5 col-md-12'>
                    <div class='col-md-12' id='backLogReg'><img src='$result->img_src' width=100%; height=400px;/><br/><br/><br/></div>
                    <div class='col-md-12 text-center' id='backLogReg'>
                        <h1>$result->post_name</h1>
                    </div>

                    <div class='col-md-12 text-wrap my-5' id='postText'>
                        <p>$result->text</p>
                    </div> 
                    <div class='col-md-12 text-wrap mb-5' id='postText'>
                        <p>Written by: $result->first_name $result->last_name</p>
                        <p>Published: $datePub</p>
                    </div>
                    <div class='col-md-10' id='backLogReg'>
                        <h3>Comment section</h3>
                        <form id='comments' class='form form-control' action='models/writeComment.php' method='post'>
                        <input type='hidden' value='$id' name='postId'/>
                        <input type='hidden' value='$user' name='userId'/>
                            <textarea placeholder='Your comment here..' class='form-control' name='comment'></textarea>
                            <br/>
                            <input class='form-control' type='submit' name='submitComment' value='Comment'/>
                        </form>");

$query = "SELECT * FROM comments c INNER JOIN users u ON c.user_id = u.user_id INNER JOIN posts p ON c.post_id = p.post_id INNER JOIN profile_pictures pp ON u.user_id = pp.user_id WHERE c.post_id = $id ORDER BY c.comment_added DESC";
$comments = $connection->query($query)->fetchAll();
foreach ($comments as $comment) {
    $time = strtotime($comment->comment_added);
    $date = date("d/M/Y H:i:s", $time);
    echo ("<div class='comment-section'><div class='comment'><p class='author'><img src='assets/img/upload/thumbnails/$comment->img_src' alt=avatar width=60px; height=60px;/>");
    echo ("\t");
    echo ("$comment->first_name  $comment->last_name (@$comment->username)</p><p class='timestamp'>$date</p><p class='content'>$comment->comment</p>
    <div class='actions'>
    </div>
    </div></div>");
}
echo ("</div>
                    </div>
                </div>
            </div>
    
        <div class='row'>
            <div class='col-lg-12 col-md-12 border'>
                <div class='d-flex flex-column p-5 postClassRecs' id='sidebar'>
                    <div id='backLogReg'>
                        <h2>See also:</h2>
                    </div><div id='backLogReg'>");
foreach ($recArray as $rec) {
    if ($rec) {

        echo ("
                    <div class='my-3 col-sm-12 col-md-12'><a href='index.php?page=postPage&id=$rec->post_id'>
                        <div>
                            <img src='$rec->img_src' width='100%' height='100px'/>
                        </div>
                        <div class='text-wrap p-2' id='sidebarText'>
                            <h4>$rec->post_name</h4>
                    </div></a></div>");
    }
}
echo ("</div></div></div></div></div>");
?>