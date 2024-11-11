<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow-sm py-3 py-lg-0 px-3 px-lg-0">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto mx-lg-auto py-0">

            <?php
            if (isset($_GET['id'])) {
                $active = $_GET['id'];
            } else {
                $active = '';
            }
            $result = $connection->query("SELECT * FROM navigation")->fetchAll();
            foreach ($result as $row) {
                echo ("<a href='$row->item_path' class='nav-item nav-link");
                if (count($activePage = explode("=", $row->item_path)) > 2) {
                    if ($active == $activePage[2]) {
                        echo (" active");
                    }
                }
                echo ("'>$row->nav_item</a>");
            }
            ?>
        </div>
        <div class="navbar-nav ms-auto mx-lg-auto py-0">
            <?php
            if (!isset($_SESSION['sessionHolder'])):
                ?>
                <a href='index.php?page=registration' class='nav-item nav-link'>Register</a>
                <a href='index.php?page=login' class='nav-item nav-link'>Login</a>
                <?php
            endif;
            ?>
            <?php
            if (isset($_SESSION['sessionHolder']) && ($_SESSION['sessionHolder']->role_id == 3 || $_SESSION['sessionHolder']->role_id == 1)):
                ?>
                <a href='index.php?page=createPost' class='nav-item nav-link'>Create new post</a>
                <?php
            endif;
            ?>
            <?php
            if (isset($_SESSION['sessionHolder']) && $_SESSION['sessionHolder']->role_id == 1):
                ?>
                <a href='index.php?page=adminPanel' class='nav-item nav-link'>Admin Panel</a>
                <a href='index.php?page=userAdmin' class='nav-item nav-link'>User adminstration</a>
                <a href='index.php?page=postAdmin' class='nav-item nav-link'>Post adminstration</a>
                <?php
            endif;
            ?>
            <?php
            if (isset($_SESSION['sessionHolder'])):
                ?>
                <a href=' index.php?page=profile' class='nav-item nav-link'>Profile</a>
                <a href='models/logout.php' class='nav-item nav-link'>Logout</a>

                <?php
            endif;
            ?>
        </div>
    </div>
    </div>
</nav>