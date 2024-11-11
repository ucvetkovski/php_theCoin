<?php
if (($_SESSION['sessionHolder']->role_id == 1)):
    ?>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-center mb-5">
                    <br />
                    <h2>User administration</h2>
                    <br />
                    <div>
                        <?php
                        global $connection;
                        echo ("<h2>Welcome "
                            . $_SESSION['sessionHolder']->first_name . "!" . "<br/><br/><div id='admin'><h3>User list:</h3></div><br/>");

                        $query = "SELECT * FROM users u INNER JOIN user_roles ur ON u.user_role = ur.role_id ORDER BY u.registration_date ASC";
                        $users = $connection->query($query)->fetchAll();
                        echo ("<div id='admin'><table class='table table-striped'><thead><tr><td>#</td><td>Username</td><td>E-mail</td><td>First Name</td><td>Last Name</td><td>Role</td><td>Ban user</td><td>Edit user data</td><td>Remove user</td></tr></thead>");
                        $i = 1;
                        foreach ($users as $user) {
                            echo ("<tr><td>$i</td><td>$user->username</td><td>$user->email</td><td>$user->first_name</td><td>$user->last_name</td>
                        <td>$user->description</td>");
                            if ($user->ban_status == 0) {
                                echo ("<td><input type='button' id='$user->user_id' class='btn btn-danger ban' value='Ban'/></td>");
                            } else {
                                echo ("<td><input type='button' id='$user->user_id' class='btn btn-success unban' value='Unban'/></td>");
                            }
                            echo ("
                        <td><input type='button' id='$user->user_id' class='btn btn-warning edit' value='Edit'/></td>
                        <td><input type='button' id='$user->user_id' data-id = '$user->role_id' class='btn btn-danger delUser' value='Remove'/></td></tr>");
                            $i++;
                        }
                        echo ("</table></div>");
                        ?>
                        <!-- Modal -->
                        <div id="editModal" class="modal">
                            <div class="modal-content">
                                <span class='close'>&times;</span>
                                <h2>Edit User</h2>
                                <form id='editForm' class='form form-control editReply' method="post"
                                    action="models/saveUserChanges.php">
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