<?php
if (($_SESSION['sessionHolder']->role_id == 1) || ($_SESSION['sessionHolder']->role_id == 3)):
    ?>
    <div class="col-md-12">
        <div class="col-md-7 my-5 postCreate" id="backLogReg">
            <h2>Create new post</h2>
            <br />
            <form class="form-control d-flex flex-column p-3" id="postCreateForm" action="models/addPost.php" method="POST"
                enctype="multipart/form-data">
                <div id="response"></div>
                <div class="form-group">
                    <label for="postTitle">Post title:</label>
                    <input class="form-control" type="text" name="postTitle" id="postTitle" placeholder="Title" />
                    <span id="postTitleError"></span>
                </div>
                <div class="form-group">
                    <label for="cat">Category:</label>
                    <select class='form-control' name='cat' id='cat'>
                        <option selected disabled id=0>Select a category</option>
                        <?php
                        include("../config/connection.php");
                        global $connection;
                        $query = "SELECT * FROM categories";
                        $result = $connection->query($query)->fetchAll();
                        foreach ($result as $row) {
                            echo "<option value='$row->category_id'>$row->category_name</option>";
                        }
                        ?>
                    </select>
                    <span id="catError"></span>
                </div>

                <div class='form-group' id="subCatDiv">
                    <label for='subCat'>Subcategory:</label>
                    <select class='form-control' id='subCat' name='subCat'>;
                    </select>
                    <span id='subCatError'></span>
                </div>

                <div class="form-group">
                    <label for="postText">Text:</label>
                    <textarea class="form-control" name="postText" id="postText" style="font-size:13px;" rows="10"
                        maxlength="10000"></textarea>
                    <span id="postTextError"></span>
                </div>
                <div class="form-group">
                    <br /><br />
                    <img id="preview" src="#" alt="Image preview:" style=" max-width: 200px; max-height: 200px;">
                    <br /><br />
                    <input class="form-control" type="file" name="file" onchange="previewImage(event)" />
                    <br />
                    <span id="postImageError"></span>
                </div>
                <input type="submit" id="postDataSubmit" class="btn btn-warning" value="Create" />
            </form>
        </div>
    </div>
    <?php
endif;
?>
<?php
if ($_SESSION['sessionHolder']->role_id == 2) {
    header("Location: index.php?page=403");
}
?>