<?php
session_start();
require 'function.php';

if(isset($_POST["search_result"])){
    $product = search_result($_POST["search_keyword"]);
}

if (!isset($_SESSION["user_email"])) {
    header("Location: account-login.php");
    exit;
} else {
    $id_pengguna = $_SESSION['user_id'];
    
    $cart = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $id_pengguna");
    $cart_total = mysqli_num_rows($cart);
    
    if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] == "Seller") {
        $redirect_page = isset($_SESSION["previous_page"]) ? $_SESSION["previous_page"] : "admin-dashboard.php";
        
        header("Location: $redirect_page");
        exit;
    }
}
$_SESSION["previous_page"] = $_SERVER["REQUEST_URI"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Notification</title>
    <!--Logo Website-->
    <link rel="icon" type="image/x-icon" href="images/favicon-32x32.png">
    <!--Framework Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!--Custom CSS & JS-->
    <link rel="stylesheet" href="stylex.css">
    <script src="script.js"></script>
    <!--FontAwesome Icon-->
    <script src="https://kit.fontawesome.com/a28c4a206b.js" crossorigin="anonymous"></script>
    <!--Poppins Font-->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>    
</head>
<body>

    <!--Navigation Bar-->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container-fluid" id="container-navbar-item">
            <a class="navbar-brand ms-lg-5" id="navbar-brand" href="index.php">
                <img src="images/INSTRUMENTALIZE_logo.png" alt="INSTRUMENTALIZE_logo" id="instrumentalize-logo" width="100px" height="100px">
            </a>
            <button class="btn navbar-toggler" id="toggler-button" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars h1 mb-0"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav my-3  my-lg-0" id="home-navigation">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#category-path">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact-path" data-bs-offset="100">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="main-tentang.php#">Tentang</a>
                    </li>
                </ul>
                <div class="container-fluid px-0 d-flex mb-3 mb-lg-0 gap-3 gap-lg-0">
                    <form class="col d-flex ms-lg-5 justify-content-lg-end" action="search-result.php" method="get">
                        <input class="d-flex form-control no-hover" id="input-search" type="text" name="search_keyword" placeholder="Cari di INSTRUMENTALIZE" aria-label="Search" autocomplete="off">
                        <button class="btn" id="btn-search" type="submit" name="search_result">
                            <i class="fa-solid fa-magnifying-glass" style="color: #fdfffd;"></i>
                        </button>
                    </form>
                    <ul class="d-flex gap-3 gap-lg-0 navbar-nav my-auto me-lg-5" id="user-navigation">
                        <li class="nav-item">
                            <?php 
                            if(isset($_SESSION["user_email"])){
                            echo"
                            <a class='nav-link' href='profile-cart.php'>
                                <i class='fa-solid fa-cart-shopping' style='color: #fdfffd;'></i>
                                <div class='position-relative'>
                                    <div class='bg-danger text-light text-center d-flex align-items-center justify-content-center' id='cart-counter'>
                                        $cart_total
                                    </div>
                                </div>
                            </a>";
                            }
                            ?>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle mb-0 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-center text-center">
                                <?php 
                                if(isset($_SESSION["user_email"])){
                                    echo "<li><a class='dropdown-item m-0 p-0' href='profile-information.php'>Profile</a></li>
                                    <li><a class='dropdown-item m-0 p-0' href='logout.php'>Log out</a></li>";
                                } else {
                                    echo "<li><a class='dropdown-item m-0 p-0' href='account-login.php'>Login</a></li>
                                    <li><a class='dropdown-item m-0 p-0' href='account-register.php'>Daftar</a></li>";
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!--Content-->
    <section class="container-fluid px-0 d-flex justify-content-center align-items-center" id="wrapper-content">
        <div class="p-3 d-flex justify-content-evenly" id="wrapper-profile">
            <!--PROFILE NAVIGATION-->
            <nav class="text-center" id="profile-navigation">
                <div class="d-flex align-items-center justify-content-center" id="profile-box-photo">
                    <img src="images/testprofile.png" alt="">
                </div>
                <div class="d-lg-flex flex-column text-dark" id="profile-box-navigation">
                    <ul class="h5 navbar-nav">
                        <li>
                            <a href="profile-information.php" class="nav-link mb-3">
                                Informasi Akun
                            </a>
                        </li>
                        <li>
                            <a href="profile-status.php" class="nav-link mb-3">
                                Status Pesanan
                            </a>
                        </li>
                        <li>
                            <a href="profile-notification.php" class="nav-link mb-3 active">
                                Notifikasi
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!--PROFILE CONTENT-->
            <div class="container-fluid d-flex flex-column p-0" id="profile-content">
                <p class="h2 text-center py-4"><b>Notifikasi</b></p>
                <hr>
                <div class="container-fluid text-start" id="profile-box-notification">
                    <button class="btn btn-light container-fluid my-1" id="notification-card">
                        <table class="container">
                            <tr>
                                <td>$notification</td>
                            </tr>
                        </table>
                    </button>
                </div>
                <div class="container-fluid mt-auto">
                    <ul class="list-unstyled d-flex justify-content-end mb-0 py-4" id="pagination-profile-table">
                        <li>
                            <a>
                                <button class="btn btn-light" id="nav">
                                    <i class="fa-solid fa-chevron-left" style="color: #000000;"></i>
                                </button>
                            </a>
                        </li>
                        <li>
                            <a>
                                <input class="text-center" type="text" name="" id="" placeholder="1">
                            </a>
                        </li>
                        <li>
                            <a>
                                <button class="btn btn-light" id="nav">
                                    <i class="fa-solid fa-chevron-right" style="color: #000000;"></i>
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!--Footer-->
    <footer class="">
        <div class="container-fluid">
            <div class="d-lg-flex">
                <div class="text-lg-start text-center">
                    <a class="navbar-brand" id="navbar-brand" href="#">
                        <img src="images/INSTRUMENTALIZE_logo.png" alt="INSTRUMENTALIZE_logo" id="instrumentalize-logo-footer" width="200px" height="200px">
                    </a>
                </div>
                
                <div class="col container-fluid text-lg-start text-center">
                    <div class="row">
                        <div class="col-lg-4 mt-3">
                            <ul class="list-unstyled">
                                <li class="mb-2" id="footer-head">Hubungi Kami</li>
                                <li class="mb-1" id="footer-body">
                                    <b>Email : </b>
                                    pblifd03.2023@gmail.com</li>
                                <li class="mb-1" id="footer-body">
                                    <b>Alamat :</b>
                                    Jl. Ahmad Yani Batam Kota. kota Batam, Kepulauan Riau, Indonesia
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <ul class="list-unstyled" id="footer-pintasan">
                                <li class="mb-2" id="footer-head">
                                    Pintasan
                                </li>
                                <li class="mb-1" id="footer-body">
                                    <a href="index.php#">Beranda</a>
                                </li>
                                <li class="mb-1" id="footer-body">
                                    <a href="index.php#category-path">Kategori</a>
                                </li>
                                <li class="mb-1" id="footer-body">
                                    <a href="index.php#contact-path">Kontak</a>
                                </li>
                                <li class="mb-1" id="footer-body">
                                    <a href="main-tentang.php#">Tentang</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 mt-3">
                            <div class="h1" id="footer-social-media">
                                <div class="mb-2" id="footer-head">
                                    Temukan Kami
                                </div>
                                <div class="d-inline-flex">
                                    <div class="mx-2 mb-1">
                                        <a href="#">
                                            <i class="fa-brands fa-square-facebook"></i>
                                        </a>
                                    </div>
                                    <div class="mx-2 mb-1">
                                        <a href="#">
                                            <i class="fa-brands fa-instagram"></i>
                                        </a>
                                    </div>
                                    <div class="mx-2 mb-1">
                                        <a href="#">
                                            <i class="fa-brands fa-x-twitter"></i>
                                        </a>
                                    </div>
                                    <div class="mx-2 mb-1">
                                        <a href="#">
                                            <i class="fa-brands fa-tiktok"></i>
                                        </a>
                                    </div>
                                    <div class="mx-2 mb-1">
                                        <a href="#">
                                            <i class="fa-brands fa-youtube"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center text-light" id="footer-copyright">
            ©2023 INSTRUMENTALIZE
        </div>
    </footer>
</body>
</html>