<?php
session_start();
require 'function.php';

$product = query("SELECT *, C.category_name as catname FROM product P, category C WHERE P.product_category = C.category_id");
$category = query("SELECT * FROM category");

if(isset($_POST["search_result"])){
    $product = search_result($_POST["search_keyword"]);
}

if(isset($_SESSION["user_email"])) {
    $id_pengguna = $_SESSION["user_id"];
    $carts = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $id_pengguna");
    $cart_total = mysqli_num_rows($carts);
}
if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] == "Seller") {
    $redirect_page = isset($_SESSION["previous_page"]) ? $_SESSION["previous_page"] : "admin-dashboard.php";
    
    header("Location: $redirect_page");
    exit;
}
$_SESSION["previous_page"] = $_SERVER["REQUEST_URI"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSTRUMENTALIZE - Tentang</title>
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
        <div class="p-lg-5 p-4" id="wrapper-section">

            <!--Content About-->
            <div class="p-3" id="main-box-about">
                <h3><b>Tentang</b></h3>
                <dl class="row mt-4">
                    <dt class="font-20 mb-sm-4 col-sm-3">
                        Judul Proyek
                    </dt>
                    <dd class="font-20 mb-4 col-sm-9">
                        Aplikasi Web Penjualan Alat Musik
                    </dd>
                    <dt class="font-20 mb-sm-4 col-sm-3">
                        Deskripsis Umum
                    </dt>
                    <dd class="font-20 mb-4 col-sm-9" id="word-justify">
                        INSTRUMENTALIZE merupakan aplikasi berbasis web yang memiliki konsep e-commerce. Aplikasi web ini akan meneyediakan berbagai alat musik yang memiliki kualitas unggul serta harga yang cukup terjangkau. Dengan hadirnya aplikasi web ini, diharapkan dapat memudahkan para peminat di bidang musik untuk memenuhi kebutuhannya.
                    </dd>
                    <dt class="font-20 mb-sm-4 col-sm-3">
                        Manager Proyek
                    </dt>
                    <dd class="font-20 mb-4 col-sm-9">
                        Muhammad Idris S.Tr., M.Tr.Kom
                    </dd>
                    <dt class="font-20 col-sm-3">
                        Anggota Kelompok
                    </dt>
                    <dd class="font-20 col-sm-9">
                        <ul>
                            <li>3312301098 - Muhammad Fathu Al Razi</li>
                            <li>3312301097 - Muhammad Adib Fakhri Siregar</li>
                            <li>3312301109 - Boni Mahanaim Siahaan</li>
                            <li>3312301115 - Azvinarti</li>
                            <li>3312301121 - Maria Zesi Versia Hutabarat</li>
                        </ul>
                    </dd>
                </dl>
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