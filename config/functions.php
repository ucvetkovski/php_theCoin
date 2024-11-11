<?php
include("connection.php");
function addUser($firstName, $lastName, $email, $username, $encryptedPassword, $token)
{
    global $connection;

    $query = "INSERT INTO users(first_name,last_name,email,username,password,user_role) VALUES (:firstName,:lastName,:email,:username,:password,:role)";

    $userRoleId = 2;
    $standby = $connection->prepare($query);
    $standby->bindParam(':firstName', $firstName);
    $standby->bindParam(':lastName', $lastName);
    $standby->bindParam(':email', $email);
    $standby->bindParam(':username', $username);
    $standby->bindParam(':password', $encryptedPassword);
    $standby->bindParam(':role', $userRoleId);

    $execution = $standby->execute();

    $lastId = $connection->lastInsertId();

    $tokenQuery = "INSERT INTO verifications(user_id,token) VALUES (:lastId,:token)";
    $tokenStandby = $connection->prepare($tokenQuery);
    $tokenStandby->bindParam(':lastId', $lastId);
    $tokenStandby->bindParam(':token', $token);

    $tokenExecute = $tokenStandby->execute();

    $pfpQuery = "INSERT INTO profile_pictures (user_id) VALUES (:lastId)";
    $pfpStandby = $connection->prepare($pfpQuery);
    $pfpStandby->bindParam(':lastId', $lastId);

    $pfpExecute = $pfpStandby->execute();

    $message = "Hello $firstName! You have successfully created your account for theCoin! Activate Your account here: http://localhost/PRAKTIKUM_PHP/theCoin/models/activation.php?token=$token";

    // mail($email, 'Activate Account', $message, 'From: activation@thecoin.com');


    return ($execution && $tokenExecute && $pfpExecute);
}

function tryLogin($username, $encryptedPassword)
{
    global $connection;

    $query = "SELECT * FROM users JOIN user_roles ON users.user_role = user_roles.role_id INNER JOIN verifications v ON v.user_id = users.user_id INNER JOIN profile_pictures pp ON pp.user_id = users.user_id  WHERE (users.email = :username OR users.username = :username) AND users.password = :password";

    $standby = $connection->prepare($query);
    $standby->bindParam(':username', $username);
    $standby->bindParam(':password', $encryptedPassword);

    $standby->execute();

    $execution = $standby->fetch();
    return $execution;
}
function generateRecommendations($id)
{
    global $connection;
    $array = [];
    $length = 7;
    $startRange = 1;


    $total = ($connection->query("SELECT post_id FROM posts")->fetchAll());
    $max = array();

    foreach ($total as $one) {
        $max[] = $one->post_id;
    }
    for ($i = $startRange; $i <= $length; $i++) {
        $randomNumber = $max[array_rand($max)];

        if (!in_array($randomNumber, $array) && $randomNumber != $id) {
            $array[] = $randomNumber;
        }
    }
    return $array;
}



function checkName($username)
{
    global $connection;
    $query = "SELECT * FROM users WHERE username = :username OR email = :username";

    $standby = $connection->prepare($query);
    $standby->bindParam(':username', $username);
    $standby->execute();

    $execution = $standby->fetch();
    return $execution;
}

function getPost($id)
{
    global $connection;
    $query = "SELECT * FROM posts p INNER JOIN categories c ON p.category_id = c.category_id INNER JOIN  users u ON p.author_id = u.user_id INNER JOIN texts t ON t.post_id = p.post_id INNER JOIN images i ON i.post_id = p.post_id WHERE p.post_id = $id";
    $result = $connection->query($query)->fetch();
    return $result;
}

function countVisits($log, $time)
{
    $index = 0;
    $new = 0;
    $sports = 0;
    $health = 0;
    $culture = 0;
    $esports = 0;
    $horoscope = 0;
    $life = 0;
    $login = 0;
    $register = 0;
    $adminPanel = 0;
    $logout = 0;
    $profile = 0;
    $createPost = 0;

    foreach ($log as $logline) {
        if ($logline['3'] >= $time && $logline['3'] <= time()) {
            $visited = explode("/", $logline['4'])['5'];
            if ($visited == "index.php") {
                $index++;
            }
            if ($visited == "index.php?page=new") {
                $new++;
            }
            if ($visited == "index.php?page=sports") {
                $sports++;
            }
            if ($visited == "index.php?page=health") {
                $health++;
            }
            if ($visited == "index.php?page=culture") {
                $culture++;
            }
            if ($visited == "index.php?page=esports") {
                $esports++;
            }
            if ($visited == "index.php?page=horoscope") {
                $horoscope++;
            }
            if ($visited == "index.php?page=life") {
                $life++;
            }
            if ($visited == "index.php?page=login") {
                $login++;
            }
            if ($visited == "index.php?page=registration") {
                $register++;
            }
            if ($visited == "index.php?page=adminPanel") {
                $adminPanel++;
            }
            if ($visited == "index.php?page=logout") {
                $logout++;
            }
            if ($visited == "index.php?page=profile") {
                $profile++;
            }
            if ($visited == "index.php?page=createPost") {
                $createPost++;
            }
        }
    }
    $all = $adminPanel + $sports + $health + $culture + $esports + $horoscope + $life + $login + $register + $logout + $profile + $createPost + $new + $index;
    $adminPanelPercentage = round(($adminPanel / $all) * 100);
    $sportsPercentage = round(($sports / $all) * 100);
    $healthPercentage = round(($health / $all) * 100);
    $culturePercentage = round(($culture / $all) * 100);
    $esportsPercentage = round(($esports / $all) * 100);
    $horoscopePercentage = round(($horoscope / $all) * 100);
    $lifePercentage = round(($life / $all) * 100);
    $loginPercentage = round(($login / $all) * 100);
    $registerPercentage = round(($register / $all) * 100);
    $logoutPercentage = round(($logout / $all) * 100);
    $profilePercentage = round(($profile / $all) * 100);
    $createPostPercentage = round(($createPost / $all) * 100);
    $indexPercentage = round(($index / $all) * 100);
    $newPercentage = round(($new / $all) * 100);

    echo '<div id="admin"><h3><i>Total clicks </i> per page (in %)</h3><table class="table table-striped"><thead><tr>
<td>Index</td>
<td>New</td>
<td>Sports</td>
<td>Health</td>
<td>Culture</td>
<td>Esports</td>
<td>Horoscope</td>
<td>Life</td>
<td>Login</td><td>Register</td>
<td>Admin panel</td><td>Profile</td><td>Logout</td><td>Create post</td></tr></thead>
<tr>
<td>' . $indexPercentage . '%</td>
<td>' . $newPercentage . '%</td>
<td>' . $sportsPercentage . '%</td>
<td>' . $healthPercentage . '%</td>
<td>' . $culturePercentage . '%</td>
<td>' . $esportsPercentage . '%</td>
<td>' . $horoscopePercentage . '%</td>
<td>' . $lifePercentage . '%</td>
<td>' . $loginPercentage . '%</td>
<td>' . $registerPercentage . '%</td>
<td>' . $adminPanelPercentage . '%</td>
<td>' . $profilePercentage . '%</td>
<td>' . $logoutPercentage . '%</td>
<td>' . $createPostPercentage . '%</td>
</tr></table></div>';
}
function countVisitsNum($log, $time)
{
    $index = 0;
    $new = 0;
    $sports = 0;
    $health = 0;
    $culture = 0;
    $esports = 0;
    $horoscope = 0;
    $life = 0;
    $login = 0;
    $register = 0;
    $adminPanel = 0;
    $logout = 0;
    $profile = 0;
    $createPost = 0;

    foreach ($log as $logline) {
        if ($logline['3'] >= $time && $logline['3'] <= time()) {
            $visited = explode("/", $logline['4'])['5'];
            if ($visited == "index.php") {
                $index++;
            }
            if ($visited == "index.php?page=new") {
                $new++;
            }
            if ($visited == "index.php?page=sports") {
                $sports++;
            }
            if ($visited == "index.php?page=health") {
                $health++;
            }
            if ($visited == "index.php?page=culture") {
                $culture++;
            }
            if ($visited == "index.php?page=esports") {
                $esports++;
            }
            if ($visited == "index.php?page=horoscope") {
                $horoscope++;
            }
            if ($visited == "index.php?page=life") {
                $life++;
            }
            if ($visited == "index.php?page=login") {
                $login++;
            }
            if ($visited == "index.php?page=registration") {
                $register++;
            }
            if ($visited == "index.php?page=adminPanel") {
                $adminPanel++;
            }
            if ($visited == "index.php?page=logout") {
                $logout++;
            }
            if ($visited == "index.php?page=profile") {
                $profile++;
            }
            if ($visited == "index.php?page=createPost") {
                $createPost++;
            }
        }
    }
    $all = $adminPanel + $sports + $health + $culture + $esports + $horoscope + $life + $login + $register + $logout + $profile + $createPost + $new + $index;

    echo '<div id="admin"><h3><i>Total clicks </i> per page</h3><table class="table table-striped"><thead><tr>
<td>Index</td>
<td>New</td>
<td>Sports</td>
<td>Health</td>
<td>Culture</td>
<td>Esports</td>
<td>Horoscope</td>
<td>Life</td>
<td>Login</td><td>Register</td>
<td>Admin panel</td><td>Profile</td><td>Logout</td><td>Create post</td></tr></thead>
<tr>
<td>' . $index . '</td>
<td>' . $new . '</td>
<td>' . $sports . '</td>
<td>' . $health . '</td>
<td>' . $culture . '</td>
<td>' . $esports . '</td>
<td>' . $horoscope . '</td>
<td>' . $life . '</td>
<td>' . $login . '</td>
<td>' . $register . '</td>
<td>' . $adminPanel . '</td>
<td>' . $profile . '</td>
<td>' . $logout . '</td>
<td>' . $createPost . '</td>
</tr></table></div>';
}

function countUserVisits($log, $time)
{
    $index = 0;
    $new = 0;
    $sports = 0;
    $health = 0;
    $culture = 0;
    $esports = 0;
    $horoscope = 0;
    $life = 0;
    $logout = 0;
    $profile = 0;
    echo '<div id="admin"><h3><i>Total user clicks </i> per page (in %)</h3><table class="table table-striped"><thead><tr>
<td>Index</td>
<td>New</td>
<td>Sports</td>
<td>Health</td>
<td>Culture</td>
<td>Esports</td>
<td>Horoscope</td>
<td>Life</td>
<td>Profile edits</td>
<td># of users that logged in</td></tr></thead>';

    foreach ($log as $logline) {
        if ($logline['3'] >= $time && $logline['3'] <= time()) {
            $visited = explode("/", $logline['4'])['5'];
            if ($logline['5'] == '2') {
                if ($visited == "index.php") {
                    $index++;
                }
                if ($visited == "index.php?page=new") {
                    $new++;
                }
                if ($visited == "index.php?page=sports") {
                    $sports++;
                }
                if ($visited == "index.php?page=health") {
                    $health++;
                }
                if ($visited == "index.php?page=culture") {
                    $culture++;
                }
                if ($visited == "index.php?page=esports") {
                    $esports++;
                }
                if ($visited == "index.php?page=horoscope") {
                    $horoscope++;
                }
                if ($visited == "index.php?page=life") {
                    $life++;
                }
                if ($visited == "index.php?page=editProfile") {
                    $profile++;
                }
                if ($visited == "index.php?page=logout") {
                    $logout++;
                }
            }
        }
    }

    $all = $sports + $health + $culture + $esports + $horoscope + $life + $profile + $index + $new;
    if ($all != 0) {
        $sportsPercentage = round(($sports / $all) * 100);
        $healthPercentage = round(($health / $all) * 100);
        $culturePercentage = round(($culture / $all) * 100);
        $esportsPercentage = round(($esports / $all) * 100);
        $horoscopePercentage = round(($horoscope / $all) * 100);
        $lifePercentage = round(($life / $all) * 100);
        $indexPercentage = round(($index / $all) * 100);
        $newPercentage = round(($new / $all) * 100);
        $profilePercentage = round(($profile / $all) * 100);

        echo '<tr>
<td>' . $indexPercentage . '%</td>
<td>' . $newPercentage . '%</td>
<td>' . $sportsPercentage . '%</td>
<td>' . $healthPercentage . '%</td>
<td>' . $culturePercentage . '%</td>
<td>' . $esportsPercentage . '%</td><td>' . $horoscopePercentage . '%</td>
<td>' . $lifePercentage . '%</td><td>' . $profilePercentage . '%</td><td>' . $logout . '</td></tr></table></div>';

    } else {
        echo '<tr>
<td>No data</td>
<td>No data</td>
<td>No data</td>
<td>No data</td>
<td>No data</td>
<td>No data</td>
<td>No data</td>
<td>No data</td>
<td>No data</td>
<td>' . $logout . '</td></tr></table></div>';
    }
}

function showLogData($log, $time)
{
    echo '<div id="admin"><h3>User access history</h3><table class="table table-striped" id="admin">';
    echo ('<thead><tr>');
    echo '<th>IP Address</th>';
    echo '<th>User</th>';
    echo '<th>User Email</th>';
    echo '<th>Date & Time</th>';
    echo '<th>Visited</th>';
    echo '</tr></thead>';

    foreach ($log as $logline) {
        if ($logline['3'] >= $time && $logline['3'] <= time()) {
            echo '<tr>';
            echo '<td>' . $logline['0'] . '</td>';
            echo '<td>' . ($logline['1']) . '</td>';
            echo '<td>' . ($logline['2']) . '</td>';
            echo '<td>' . date('D, d.m.Y H:i:s', $logline['3']) . '</td>';
            echo '<td>' . explode("/", $logline['4'])['5'] . '</td>';
            echo '</tr>';
        }
    }

    echo '</table></div>';
}
// function writeTable($time)
// {
//     $logfile = "data/log.txt";
//     if (file_exists($logfile)) {
//         $handle = fopen($logfile, "r");
//         $log = fread($handle, filesize($logfile));
//         fclose($handle);
//     } else {
//         die("Log file doesn't exist.");
//     }
//     $log = explode("\n", trim($log));
//     for ($i = 0; $i < count($log); $i++) {
//         $log[$i] = trim($log[$i]);
//         $log[$i] = explode('|', $log[$i]);
//     }
//     echo '<table class="table table-striped" id="admin">';
//     echo ('<thead><tr>');
//     echo '<th>IP Address</th>';
//     echo '<th>User</th>';
//     echo '<th>User Email</th>';
//     echo '<th>Date & Time</th>';
//     echo '<th>Visited</th>';
//     echo '</tr></thead>';
//     foreach ($log as $logline) {
//         if ($logline['3'] >= $time && $logline['3'] <= time()) {
//             echo '<tr>';
//             echo '<td>' . $logline['0'] . '</td>';
//             echo '<td>' . ($logline['1']) . '</td>';
//             echo '<td>' . ($logline['2']) . '</td>';
//             echo '<td>' . date('D, d.m.Y H:i:s', $logline['3']) . '</td>';
//             echo '<td>' . explode("/", $logline['4'])['5'] . '</td>';
//             echo '</tr>';
//         }
//     }
//     echo '</table>';
// }

function insertProduct($productName, $productCategory, $productPrice)
{
    global $connection;

    $query = "INSERT INTO posts(,category_id,price) VALUES (:productName,:productCategory,:productPrice)";

    $standby = $connection->prepare($query);
    $standby->bindParam(":productName", $productName);
    $standby->bindParam(":productCategory", $productCategory);
    $standby->bindParam(":productPrice", $productPrice);

    $execution = $standby->execute();
    return $execution;
}

function getSubCategories($id)
{
    global $connection;

    $query = "SELECT * FROM subcategories WHERE cat_id = $id";

    $execution = $connection->query($query)->fetchAll();
    return $execution;
}

function insertPost($userID, $title, $category, $subcat, $image, $text)
{

    global $connection;

    if ($subcat == 0) {
        $query = "INSERT INTO posts (author_id,post_name,category_id) VALUES (:auth,:name,:cat)";

        $standby = $connection->prepare($query);
        $standby->bindParam(":auth", $userID);
        $standby->bindParam(":name", $title);
        $standby->bindParam(":cat", $category);

        $execution = $standby->execute();

        $lastId = $connection->lastInsertId();

        $imageQuery = "INSERT INTO images (img_src,post_id) VALUES (:img,:id)";
        $imageQueryStandby = $connection->prepare($imageQuery);
        $imageQueryStandby->bindParam(":img", $image);
        $imageQueryStandby->bindParam(":id", $lastId);

        $textQuery = "INSERT INTO texts (text,post_id) VALUES (:text,:id)";
        $textQueryStandby = $connection->prepare($textQuery);
        $textQueryStandby->bindParam(":text", $text);
        $textQueryStandby->bindParam(":id", $lastId);

        $imageExec = $imageQueryStandby->execute();
        $textExec = $textQueryStandby->execute();

        return ($execution && $imageExec && $textExec);

    } else {
        $query = "INSERT INTO posts (author_id,post_name,category_id,subcategory_id) VALUES (:auth,:name,:cat,:subcat)";

        $standby = $connection->prepare($query);
        $standby->bindParam(":auth", $userID);
        $standby->bindParam(":name", $title);
        $standby->bindParam(":cat", $category);
        $standby->bindParam(":subcat", $subcat);

        $execution = $standby->execute();

        $lastId = $connection->lastInsertId();

        $imageQuery = "INSERT INTO images (img_src,post_id) VALUES (:img,:id)";
        $imageQueryStandby = $connection->prepare($imageQuery);
        $imageQueryStandby->bindParam(":img", $image);
        $imageQueryStandby->bindParam(":id", $lastId);

        $textQuery = "INSERT INTO texts (text,post_id) VALUES (:text,:id)";
        $textQueryStandby = $connection->prepare($textQuery);
        $textQueryStandby->bindParam(":text", $text);
        $textQueryStandby->bindParam(":id", $lastId);

        $imageExec = $imageQueryStandby->execute();
        $textExec = $textQueryStandby->execute();

        return ($execution && $imageExec && $textExec);
    }

}

function deletePost($id)
{
    global $connection;
    $imagesQuery = "DELETE FROM images WHERE post_id = :id";
    $textsQuery = "DELETE FROM texts WHERE post_id = :id";
    $commentsQuery = "DELETE FROM comments WHERE post_id = :id";
    $postsQuery = "DELETE FROM posts WHERE post_id = :id";


    $imageStandby = $connection->prepare($imagesQuery);
    $textStandby = $connection->prepare($textsQuery);
    $commentsStandby = $connection->prepare($commentsQuery);
    $postStandby = $connection->prepare($postsQuery);

    $imageStandby->bindParam(":id", $id);
    $textStandby->bindParam(":id", $id);
    $commentsStandby->bindParam(":id", $id);
    $postStandby->bindParam(":id", $id);

    $iExec = $imageStandby->execute();
    $tExec = $textStandby->execute();
    $cExec = $commentsStandby->execute();
    $pExec = $postStandby->execute();

    return ($tExec && $iExec && $pExec && $cExec);
}

function deleteUser($id, $role)
{
    global $connection;

    switch ($role) {
        case '1': {
                $delQuery = "DELETE FROM users WHERE user_id = :id";

                $delStandby = $connection->prepare($delQuery);

                $delStandby->bindParam(":id", $id);

                $del = $delStandby->execute();
                break;
            }
        case '2': {
                $findCommentsQ = "SELECT * FROM comments WHERE user_id = $id";
                $fc = ($connection->query($findCommentsQ)->fetchAll());
                $findComments = count($fc);

                if ($findComments > 0) {
                    $delComQuery = "DELETE FROM comments WHERE user_id = :id";
                    $delImgQuery = "DELETE FROM profile_pictures WHERE user_id = :id";
                    $delQuery = "DELETE FROM users WHERE user_id = :id";

                    $delImgStandby = $connection->prepare($delImgQuery);
                    $delComStandby = $connection->prepare($delComQuery);
                    $delStandby = $connection->prepare($delQuery);

                    $delImgStandby->bindParam(":id", $id);
                    $delComStandby->bindParam(":id", $id);
                    $delStandby->bindParam(":id", $id);

                    $del = ($delComStandby->execute() && $delImgStandby->execute() && $delStandby->execute());
                    break;
                } else {
                    $delImgQuery = "DELETE FROM profile_pictures WHERE user_id = :id";
                    $delQuery = "DELETE FROM users WHERE user_id = :id";


                    $delImgStandby = $connection->prepare($delImgQuery);
                    $delStandby = $connection->prepare($delQuery);


                    $delImgStandby->bindParam(":id", $id);
                    $delStandby->bindParam(":id", $id);

                    $del = ($delImgStandby->execute() && $delStandby->execute());
                    break;
                }
            }
        case '3': {
                try {
                    $connection->beginTransaction();

                    $delImgQuery = "DELETE FROM profile_pictures WHERE user_id = :id";
                    $delJourQuery = "UPDATE posts SET author_id = NULL WHERE author_id = :id";
                    $delQuery = "DELETE FROM users WHERE user_id = :id";

                    $delImgStandby = $connection->prepare($delImgQuery);
                    $delImgStandby->bindParam(":id", $id);
                    $delImgStandby->execute();

                    $delJourStandby = $connection->prepare($delJourQuery);
                    $delJourStandby->bindParam(":id", $id);
                    $delJourStandby->execute();

                    $delStandby = $connection->prepare($delQuery);
                    $delStandby->bindParam(":id", $id);
                    $delStandby->execute();

                    $connection->commit();
                } catch (PDOEXCEPTION $e) {
                    $connection->rollback();
                    echo ("error");
                }

                break;
            }
    }
}

function banUser($id)
{
    global $connection;
    $query = "UPDATE users SET ban_status = 1 WHERE user_id = :id";

    $standby = $connection->prepare($query);
    $standby->bindParam(":id", $id);

    $execution = $standby->execute();

    return $execution;
}

function unbanUser($id)
{
    global $connection;
    $query = "UPDATE users SET ban_status = 0 WHERE user_id = :id";

    $standby = $connection->prepare($query);
    $standby->bindParam(":id", $id);

    $execution = $standby->execute();

    return $execution;
}

function getRole($id, $role)
{

    global $connection;

    $query = "SELECT user_role FROM users WHERE user_id = $id";
    $row = $connection->query($query)->fetch();

    if ($role == $row->user_role) {
        return "selected";
    }

}

function saveUserChanges($id, $firstName, $lastName, $username, $email, $password, $role, $dbLocation)
{
    if ($dbLocation == 0 && $role != 0) {
        try {
            global $connection;
            if ($password == '') {
                $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, username = :username, email = :email, user_role = :role WHERE user_id = :id";

                $standby = $connection->prepare($query);

                $standby->bindParam(":firstName", $firstName);
                $standby->bindParam(":lastName", $lastName);
                $standby->bindParam(":username", $username);
                $standby->bindParam(":email", $email);
                $standby->bindParam(":role", $role);
                $standby->bindParam(":id", $id);

                $execution = $standby->execute();

                return $execution;

            } else {
                $encPassword = md5($password);
                $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, username = :username, email = :email, password = :password, user_role = :role WHERE user_id = :id";

                $standby = $connection->prepare($query);

                $standby->bindParam(":firstName", $firstName);
                $standby->bindParam(":lastName", $lastName);
                $standby->bindParam(":username", $username);
                $standby->bindParam(":email", $email);
                $standby->bindParam(":password", $encPassword);
                $standby->bindParam(":role", $role);
                $standby->bindParam(":id", $id);

                $execution = $standby->execute();

                return $execution;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    } else if ($dbLocation == 0 && $role == 0) {
        try {
            global $connection;
            if ($password == '') {
                $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, username = :username, email = :email WHERE user_id = :id";

                $standby = $connection->prepare($query);

                $standby->bindParam(":firstName", $firstName);
                $standby->bindParam(":lastName", $lastName);
                $standby->bindParam(":username", $username);
                $standby->bindParam(":email", $email);
                $standby->bindParam(":id", $id);

                $execution = $standby->execute();

                if ($execution) {
                    $_SESSION['sessionHolder']->first_name = $firstName;
                    $_SESSION['sessionHolder']->last_name = $lastName;
                    $_SESSION['sessionHolder']->username = $username;
                    $_SESSION['sessionHolder']->email = $email;
                }

                return $execution;

            } else {
                $encPassword = md5($password);
                $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, username = :username, email = :email, password = :password WHERE user_id = :id";

                $standby = $connection->prepare($query);

                $standby->bindParam(":firstName", $firstName);
                $standby->bindParam(":lastName", $lastName);
                $standby->bindParam(":username", $username);
                $standby->bindParam(":email", $email);
                $standby->bindParam(":password", $encPassword);
                $standby->bindParam(":id", $id);

                $execution = $standby->execute();

                if ($execution) {
                    $_SESSION['sessionHolder']->first_name = $firstName;
                    $_SESSION['sessionHolder']->last_name = $lastName;
                    $_SESSION['sessionHolder']->username = $username;
                    $_SESSION['sessionHolder']->email = $email;
                    $_SESSION['sessionHolder']->password = $encPassword;
                }

                return $execution;
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    } else {
        try {
            global $connection;
            if ($password == '') {
                $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, username = :username, email = :email WHERE user_id = :id";

                $standby = $connection->prepare($query);

                $standby->bindParam(":firstName", $firstName);
                $standby->bindParam(":lastName", $lastName);
                $standby->bindParam(":username", $username);
                $standby->bindParam(":email", $email);
                $standby->bindParam(":id", $id);

                $execution = $standby->execute();

                $pfpQuery = "UPDATE profile_pictures SET img_src = :image WHERE user_id = :id";
                $pfpStandby = $connection->prepare($pfpQuery);

                $pfpStandby->bindParam(":image", $dbLocation);
                $pfpStandby->bindParam(":id", $id);

                $pfpUpdate = $pfpStandby->execute();

                if ($execution && $pfpUpdate) {
                    $_SESSION['sessionHolder']->first_name = $firstName;
                    $_SESSION['sessionHolder']->last_name = $lastName;
                    $_SESSION['sessionHolder']->username = $username;
                    $_SESSION['sessionHolder']->email = $email;
                    $_SESSION['sessionHolder']->img_src = $dbLocation;
                }

                return ($execution && $pfpUpdate);

            } else {
                $encPassword = md5($password);
                $query = "UPDATE users SET first_name = :firstName, last_name = :lastName, username = :username, email = :email, password = :password WHERE user_id = :id";

                $standby = $connection->prepare($query);

                $standby->bindParam(":firstName", $firstName);
                $standby->bindParam(":lastName", $lastName);
                $standby->bindParam(":username", $username);
                $standby->bindParam(":email", $email);
                $standby->bindParam(":password", $encPassword);
                $standby->bindParam(":id", $id);

                $execution = $standby->execute();


                $pfpQuery = "UPDATE profile_pictures SET img_src = :image WHERE user_id = :id";
                $pfpStandby = $connection->prepare($pfpQuery);


                $pfpStandby->bindParam(":image", $dbLocation);
                $pfpStandby->bindParam(":id", $id);

                $pfpUpdate = $pfpStandby->execute();

                if ($execution && $pfpUpdate) {
                    $_SESSION['sessionHolder']->first_name = $firstName;
                    $_SESSION['sessionHolder']->last_name = $lastName;
                    $_SESSION['sessionHolder']->username = $username;
                    $_SESSION['sessionHolder']->email = $email;
                    $_SESSION['sessionHolder']->password = $encPassword;
                    $_SESSION['sessionHolder']->img_src = $dbLocation;
                }

                return ($execution && $pfpUpdate);
            }
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
}

function addComment($userId, $postId, $text)
{
    global $connection;

    $query = "INSERT INTO comments (user_id,post_id,comment) VALUES (:user_id,:post_id,:comment)";

    $standby = $connection->prepare($query);
    $standby->bindParam(":user_id", $userId);
    $standby->bindParam(":post_id", $postId);
    $standby->bindParam(":comment", $text);

    $execution = $standby->execute();

    return $execution;

}

function createThumbnails($sourceImage, $type)
{
    $add = "../assets/img/upload/" . $sourceImage;

    $n_width = 200;
    $n_height = 200;

    $p_width = 500;
    $p_height = 500;

    $tsrc = "../assets/img/upload/thumbnails/" . $sourceImage;
    $rsrc = "../assets/img/upload/resize/" . $sourceImage;

    if ($type == "image/jpeg") {
        $im = imagecreatefromjpeg($add);
        $width = ImageSx($im); // Original picture width is stored
        $height = ImageSy($im); // Original picture height is stored
        //$n_height=($n_width/$width) * $height; 

        $resizedImage = imagecreatetruecolor($p_width, $p_height);
        imageCopyResized($resizedImage, $im, 0, 0, 0, 0, $p_width, $p_height, $width, $height);
        imagejpeg($resizedImage, $rsrc);

        $newimage = imagecreatetruecolor($n_width, $n_height);
        imageCopyResized($newimage, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height);
        imagejpeg($newimage, $tsrc);
    }

    if ($type == "image/png") {
        $im = imagecreatefrompng($add);
        $width = ImageSx($im); // Original picture width is stored
        $height = ImageSy($im); // Original picture height is stored
        //$n_height=($n_width/$width) * $height; 

        $resizedImage = imagecreatetruecolor($p_width, $p_height);
        imageCopyResized($resizedImage, $im, 0, 0, 0, 0, $p_width, $p_height, $width, $height);
        imagejpeg($resizedImage, $rsrc);

        $newimage = imagecreatetruecolor($n_width, $n_height);
        imageCopyResized($newimage, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height);
        imagepng($newimage, $tsrc);
    }
}

function writePosts($catId)
{
    global $connection;
    if ($catId) {
        $response = '';
        $posts = $connection->query("SELECT * FROM posts p INNER JOIN categories c ON p.category_id = c.category_id INNER JOIN texts t ON t.post_id = p.post_id LEFT JOIN images i ON p.post_id = i.post_id WHERE c.category_id = $catId ORDER BY RAND()")->fetchAll();
        foreach ($posts as $post) {
            $subcat = 0;
            if ($post->subcategory_id != NULL) {
                $subcat = $connection->query("SELECT * from subcategories s INNER JOIN categories c ON s.category_id = c.category_id WHERE s.sub_id = $post->subcategory_id")->fetchAll();
            }
            $response .= "<div class='col-lg-10 col-md-2 col-sm-5'>
                                <div class='d-flex h-100 shadow p-3 mb-5 bg-white rounded'>
                                    <div class='flex-shrink-0'>
                                        <a href='index.php?page=postPage&id=$post->post_id'><img src='$post->img_src' alt='' style='width: 375px; height: 225px;'/></a>
                                    </div>
                                    <div class='d-flex flex-column justify-content-center text-start px-4 full'>
                                        <a href='index.php?page=postPage&id=$post->post_id'><h5 class='text-uppercase'>$post->post_name</h5></a>";
            if ($subcat) {
                foreach ($subcat as $s) {
                    $response .= "<p>$s->category_name</p>";
                    $response .= "<p>Tag: $s->sub_name</p>";
                }
            } else {
                $response .= "<p>$post->category_name</p>";
            }
            $response .= "<div><a class='btn btn-secondary' href='index.php?page=postPage&id=$post->post_id'><button type='button' id='$post->post_id' class='btn btn-secondary'>Read more</button></a></div>
                                    </div>
                                </div>
                            </div>";
        }
        return $response;
    } else {
        $response = '';
        $posts = $connection->query("SELECT * FROM posts p INNER JOIN categories c ON p.category_id = c.category_id INNER JOIN texts t ON t.post_id = p.post_id LEFT JOIN images i ON p.post_id = i.post_id ORDER BY p.publication_date DESC")->fetchAll();
        foreach ($posts as $post) {
            $subcat = 0;
            if ($post->subcategory_id != NULL) {
                $subcat = $connection->query("SELECT * from subcategories s INNER JOIN categories c ON s.category_id = c.category_id WHERE s.sub_id = $post->subcategory_id")->fetchAll();
            }
            $response .= "<div class='col-lg-10 col-md-2 col-sm-5'>
                                <div class='d-flex h-100 shadow p-3 mb-5 bg-white rounded'>
                                    <div class='flex-shrink-0'>
                                        <a href='index.php?page=postPage&id=$post->post_id'><img src='$post->img_src' alt='' style='width: 375px; height: 225px;'/></a>
                                    </div>
                                    <div class='d-flex flex-column justify-content-center text-start px-4 full'>
                                        <a href='index.php?page=postPage&id=$post->post_id'><h5 class='text-uppercase'>$post->post_name</h5></a>";
            if ($subcat) {
                foreach ($subcat as $s) {
                    $response .= "<p>$s->category_name</p>";
                    $response .= "<p>Tag: $s->sub_name</p>";
                }
            } else {
                $response .= "<p>$post->category_name</p>";
            }
            $response .= "<div><a class='btn btn-secondary' href='index.php?page=postPage&id=$post->post_id'><button type='button' id='$post->post_id' class='btn btn-secondary'>Read more</button></a></div>
                                    </div>
                                </div>
                            </div>";
        }
        return $response;
    }
}