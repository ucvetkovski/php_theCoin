<?php
if (($_SESSION['sessionHolder']->role_id == 1)):
    ?>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-center mb-5">
                    <br />
                    <h2>Post administration</h2>
                    <br />
                    <div>
                        <?php
                        global $connection;
                        echo ("<h2>Welcome "
                            . $_SESSION['sessionHolder']->first_name . "!" . "<br/><br/><div id='admin'><h3>Post list:</h3></div><br/>");

                        $query = "SELECT * FROM posts p INNER JOIN categories c ON p.category_id = c.category_id INNER JOIN users u ON p.author_id = u.user_id INNER JOIN images i ON p.post_id = i.post_id";
                        $posts = $connection->query($query)->fetchAll();
                        echo ("<div id='admin'><table class='table table-striped'><thead><tr><td>#</td><td>Thumbnail</td><td>Post Title</td><td>Author</td><td>Date created</td><td>Category</td><td>Subcategory</td><td>Text</td><td>Edit post</td><td>Remove post</td></tr></thead>");
                        $i = 1;
                        foreach ($posts as $post) {
                            $subcat = 0;
                            if ($post->subcategory_id != NULL) {
                                $subcat = $connection->query("SELECT * from subcategories s INNER JOIN categories c ON s.category_id = c.category_id WHERE s.sub_id = $post->subcategory_id")->fetchAll();
                            }
                            $time = strtotime($post->publication_date);
                            $date = date("d/M/Y H:i:s", $time);
                            echo ("<tr><td>$i</td><td><a href='index.php?page=postPage&id=$post->post_id'><img src='$post->img_src' width=275px; height=150px;></a></td><td>$post->post_name</td><td>$post->username</td><td>$date</td>
                        <td>$post->category_name</td>");
                            if ($subcat) {
                                foreach ($subcat as $s) {
                                    echo ("<td>$s->sub_name</td>");
                                }
                            } else {
                                echo ("<td>n/a</td>");
                            }
                            echo ("<td><input class='showPostText btn btn-success' id='$post->post_id' type='button' value='Show text'/></td><td><input type='button' id='$post->post_id' class='btn btn-warning editPost' value='Edit'/></td>
                        <td><input type='button' id='$post->post_id' class='btn btn-danger delPost' value='Remove'/></td></tr>");
                            $i++;
                        }
                        echo ("</table></div>");
                        ?>
                        <!-- Modal -->
                        <div id="editModal" class="modal">
                            <div class="modal-content">
                                <span class='close'>&times;</span>
                                <h2>Edit Post</h2>
                                <form id='editForm' class='form form-control editReply' method="post"
                                    action="models/changePost.php">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php
endif;
?>
<?php
if (($_SESSION['sessionHolder']->role_id != 1)) {
    header("Location: index.php?page=403");
}
?>