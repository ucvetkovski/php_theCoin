<?php
if ($_SESSION['sessionHolder']->role_id == 1):
    ?>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-center mb-5">
                    <br />
                    <h2>Admin Panel</h2>
                    <br />
                    <div>
                        <?php
                        echo ("<h2>Welcome "
                            . $_SESSION['sessionHolder']->first_name . "!" . "<br/><br/><div id='admin'> Activity log <br/><br/>Showing activity for the last: 24 hours</div><br/><br/>");
                        include("views/pages/elements/logData.php")
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
endif;
?>
<?php
if ($_SESSION['sessionHolder']->role_id != 1) {
    header("Location: index.php?page=403");
}
?>