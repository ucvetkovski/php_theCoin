<?php

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE user_id = $id";

$user = $connection->query($query)->fetch();


echo ("<div class='container'>
    <div class='col-md-8 my-5' id='backLogReg'>

            <form class='form form-control' method='post' action='models/saveUserChanges.php' enctype='multipart/form-data'>
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
                    <label for='editPassword'>Old password:</label>
                    <input class='form-control' type='password' id='editPassword' name='editPassword' placeholder='*****'/>
                </div>
                <div class='form-group'>
                    <label for='newPassword'>New password:</label>
                    <input class='form-control' type='password' id='newPassword' name='newPassword' placeholder='*****'/>
                </div>
                <br/>

                <div class='form-group'>
                    <label for='file'>Upload profile picture</label>
                    <input class='form-control' type='file' id='file' name='file'/>
                </div>

                <br/>
                <input type='hidden' value='editProfile' name='editProfile'/>
                <input class='form-control btn btn-outline-warning' type='submit' value='Save changes'>
            </form>
        </div>
    </div>");

?>