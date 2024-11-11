<?php
include('../config/functions.php');

$id = $_POST['id'];

$query = "SELECT * FROM users WHERE user_id = $id";

$user = $connection->query($query)->fetch();


$rolesQuery = "SELECT role_id,description FROM user_roles";
$roles = $connection->query($rolesQuery)->fetchAll();

echo ("
    <input type='hidden' value='$user->user_id' id='$user->user_id' name='id'/>
    <div class='form-group'>
        <label for='editName'>Name:</label>
        <input class='form-control' type='text' id='editName' name='editName' required value='$user->first_name'/>
    </div>

    <div class='form-group'>
        <label for='editLastName'>Last name:</label>
        <input class='form-control' type='text' id='editLastName' name='editLastName' required value='$user->last_name'/>
    </div>

    <div class='form-group'>
        <label for='editUsername'>Username:</label>
        <input class='form-control' type='text' id='editUsername' name='editUsername' required value='$user->username'/>
    </div>

    <div class='form-group'>
        <label for='editEmail'>E-mail:</label>
        <input class='form-control' type='text' id='editEmail' name='editEmail' required value='$user->email'/>
    </div>
    <div class='form-group'>
        <label for='editPassword'>Password:</label>
        <input class='form-control' type='password' id='editPassword' name='editPassword' placeholder='*****'/>
    </div>

    <div class='form-group'>
    <label for='editRole'>Role:</label><select id='roleSelect' name='roleSelect' class='form-control' >");

foreach ($roles as $role) {
    echo ("<option ") . getRole($user->user_id, $role->role_id);
    echo (" value='$role->role_id'>$role->description</option>");
}
echo ("</select></div><br/><input class='form-control btn btn-outline-warning' type='submit' value='Save changes'>")

    ?>


</form>