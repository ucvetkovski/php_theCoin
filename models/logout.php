<?php
session_start();
if (isset($_SESSION['sessionHolder'])) {
    unset($_SESSION['sessionHolder']);
    // function redirect($url)
    // {
    //     if (!headers_sent()) {
    //         header('Location: ' . $url);
    //         exit;
    //     } else {
    //         echo '<script type="text/javascript">';
    //         echo 'window.location.href="' . $url . '";';
    //         echo '</script>';
    //         echo '<noscript>';
    //         echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
    //         echo '</noscript>';
    //         exit;
    //     }
    // }
    // redirect('index.php?page=new');
    header("Location: ../index.php?page=new");
}
?>