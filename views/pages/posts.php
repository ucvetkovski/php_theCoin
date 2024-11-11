<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = 0;
}
?>
<div class="container-fluid about py-5">
    <div class="container  d-flex flex-row">
        <div class="row g-3 col-md-9">
            <div class='col-md-12'>
                <?php
                echo (writePosts($id));
                ?>
            </div>
        </div>
        <div class="row g-3 col-md-3">
            <div class='col-md-12'>
                <div id="weatherRow"></div>
            </div>
        </div>
    </div>
</div>
<!-- Products End -->