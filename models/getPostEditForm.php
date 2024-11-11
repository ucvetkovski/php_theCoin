<?php
include('../config/functions.php');

$id = $_POST['id'];

$query = "SELECT * FROM posts p INNER JOIN users u ON p.author_id = u.user_id WHERE post_id = $id";

$post = $connection->query($query)->fetch();


$categoriesQuery = "SELECT * FROM categories";
$categories = $connection->query($categoriesQuery)->fetchAll();

$subQuery = "SELECT * FROM subcategories";
$subcats = $connection->query($subQuery)->fetchAll();
echo ("
    <input type='hidden' value='$post->post_id' id='$post->post_id' name='id'/>
    <div class='form-group'>
        <label for='editTitle'>Title:</label>
        <input class='form-control' type='text' id='editTitle' name='editTitle' required value='$post->post_name'/>
        <label for='author'>Author:</label>
         <input disabled class='form-control' type='text' id='author' name='author' value='$post->username'/>
    </div>

    <div class='form-group'>
    <label for='categoryEditSelect'>Category:</label><select id='categoryEditSelect' name='categoryEditSelect' class='form-control'>");

foreach ($categories as $category) {
    echo ("<option value='$category->category_id'>$category->category_name</option>");
}
echo ("</select>
</div>


<br/><input class='form-control btn btn-outline-warning' type='submit' value='Save changes'>")

    ?>


</form>