<!-- Facts Start -->
<div class="container-fluid bg-img py-5 mb-5">
    <div class="container py-3">
        <div class="row gx-3 gy-4 d-flex justify-content-around">
            <div class="col-lg-2 col-md-6">
                <div class="d-flex">
                    <div class="bg-primary border-inner d-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fa fa-users text-white"></i>
                    </div>
                    <div class="ps-3">
                        <h6 class="text-primary text-uppercase">Journalists</h6>
                        <?php
                        $journalistCount = count($connection->query("SELECT * FROM users where user_role = 3")->fetchAll());
                        echo ("<h1 class='display-5 text-white mb-0' data-toggle='counter-up'>$journalistCount</h1>");
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="d-flex">
                    <div class="bg-primary border-inner d-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fa fa-check text-white"></i>
                    </div>
                    <div class="ps-3">
                        <h6 class="text-primary text-uppercase">Posts</h6>
                        <?php
                        $postCount = count($connection->query("SELECT * FROM posts")->fetchAll());
                        echo ("<h1 class='display-5 text-white mb-0' data-toggle='counter-up'>$postCount</h1>");
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="d-flex">
                    <div class="bg-primary border-inner d-flex align-items-center justify-content-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fa fa-mug-hot text-white"></i>
                    </div>
                    <div class="ps-3">
                        <h6 class="text-primary text-uppercase">Users</h6>

                        <?php
                        $userCount = count($connection->query("SELECT * FROM users where user_role = 2")->fetchAll());
                        echo ("<h1 class='display-5 text-white mb-0' data-toggle='counter-up'>$userCount</h1>");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Facts End -->