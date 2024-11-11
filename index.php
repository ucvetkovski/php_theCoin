<?php
include("views/fixed/head.php");
include("views/fixed/header.php");
include("views/fixed/nav.php");
?>

<body>
    <?php
    if (!isset($_GET['page'])) {
        include 'views/pages/posts.php';
    } else {
        switch ($_GET['page']) {
            case 'login':
                include "views/pages/login.php";
                break;
            case 'registration':
                include "views/pages/registration.php";
                break;
            case 'postPage':
                include "views/pages/postPage.php";
                break;
            case 'createPost':
                include "views/pages/createPost.php";
                break;
            case 'adminPanel':
                include "views/pages/adminPanel.php";
                break;
            case 'userAdmin':
                include "views/pages/userAdmin.php";
                break;
            case 'postAdmin':
                include "views/pages/postAdmin.php";
                break;
            case 'profile':
                include "views/pages/userProfile.php";
                break;
            case 'editProfile':
                include "views/pages/editProfile.php";
                break;
            case '403':
                include "views/fixed/403.php";
                break;
            case 'horoscope':
                include "views/pages/horoscope.php";
                break;
            default:
                include "views/pages/posts.php";
        }
    }
    include 'views/fixed/footer.php';
    ?>


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-inner py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>