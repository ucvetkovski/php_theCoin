<div class="container">
    <div class="row d_flex justify-content-between p-5 my-5">
        <div class="col-md-6">
            <?php
            $user = $_SESSION['sessionHolder'];

            echo ("<input type='hidden' id='userID' name='$user->user_id' value='$user->user_id'>");
            echo ("<h3>Name: " . $user->first_name);
            echo ("<h3>Last name: " . $user->last_name);
            echo ("<h3>Username: " . $user->username);
            echo ("<h3>Email: " . $user->email);
            echo ("<h3>Registration date: " . $user->registration_date);
            echo ("<br/><br/><br/><a href='index.php?page=editProfile&id=$user->user_id'>Edit profile</a>");
            ?>
        </div>
        <div class="col-md-4">
            <?php
            echo ("<img src='assets/img/upload/resize/$user->img_src' width='100%';/>");
            ?>
        </div>

    </div>
</div>