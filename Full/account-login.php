<?php
session_start();
require 'function.php';

if(isset($_POST["search_result"])){
    $product = search_result($_POST["search_keyword"]);
}

if (isset($_SESSION["user_email"])) {
    $redirect_page = isset($_SESSION["previous_page"]) ? $_SESSION["previous_page"] : "index.php";
        
    header("Location: $redirect_page");
    exit;
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSTRUMENTALIZE - Login</title>
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
                <div class="container-fluid px-0 d-flex mb-3 mb-lg-0 gap-3">
                    <form class="col d-flex ms-lg-5 justify-content-lg-end" action="search-result.php" method="get">
                        <input class="d-flex form-control no-hover" id="input-search" type="text" name="search_keyword" placeholder="Cari di INSTRUMENTALIZE" aria-label="Search" autocomplete="off">
                        <button class="btn" id="btn-search" type="submit" name="search_result">
                            <i class="fa-solid fa-magnifying-glass" style="color: #fdfffd;"></i>
                        </button>
                    </form>
                    <ul class="d-lg-flex navbar-nav my-auto me-lg-5" id="user-navigation">
                        <li class="nav-item">
                            <?php 
                            if(isset($_SESSION["user_email"])){
                            echo"<a class='nav-link' href='profile-cart.php'>
                                <i class='fa-solid fa-cart-shopping' style='color: #fdfffd;'></i>
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
    <div class="container-fluid d-flex align-items-center" id="wrapper-box-account">

        <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
            <symbol id="check-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <symbol id="info-fill" viewBox="0 0 16 16">
                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
            </symbol>
            <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
        </svg>

        <div class="container" id="container-account">
            <div class="col">
                <div class="text-center mt-3 my-lg-3">
                    <span class="font-40"><b>Login Akun</b></span>
                </div>
            </div>
            <div class="d-flex flex-column mt-4 mt-lg-5">
                <div class="container mt-auto" id="container-account-form">
                    <form action="" method="post" id="login-user-form">
                        <div class="container-fluid p-0" id="alert">

                            <!--RESPOND MESSAGE-->
                            <?php if(isset($_SESSION['status_failed'])){ ?>
                            <div class="alert alert-danger d-flex align-items-center p-2 mb-1" role="alert">
                                <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                <div>
                                    <?= $_SESSION['status_failed']; ?>
                                </div>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['status_failed']); } ?>

                        </div>
                        <div class="form-floating mb-2 mx-3 mx-lg-0">
                            <input type="email" class="form-control focus-ring focus-ring-secondary account-input" name="user_email" id="user_email" placeholder="name@example.com" required>
                            <label for="user_email">Email</label>
                        </div>
                        <div class="form-floating mb-2 mx-3 mx-lg-0">
                            <input type="password" class="form-control focus-ring focus-ring-secondary account-input" name="user_password" id="user_pass" placeholder="Password" required>
                            <label for="user_password">Password</label>
                            <i class="fa-solid fa-eye" id="show_user_pass" onclick="show_password('user_pass')"></i>
                        </div>
                        <div class="d-flex justify-content-between my-2 mx-4 m-lg-2">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input focus-ring focus-ring-secondary " id="">
                                <label class="form-check-label" for="exampleCheck1">Ingat saya</label>
                            </div>
                            <a href="" class="text-end" id="" data-bs-toggle="modal" data-bs-target="#forgot-password-modal">
                                Lupa password?
                            </a>
                        </div>
                        <div class="d-flex justify-content-center" >
                            <button class="btn btn-light account-submit p-0" type="submit" name="login_user">Masuk</button>
                        </div>
                    </form>
                </div>
                <div class="d-flex flex-column align-items-center m-3" id="user-footer">
                    <hr class="account-grid">
                    <div class="text-center text-dark text-opacity-75">
                        Belum punya akun? klik
                        <a class="text-opacity-75" href="account-register.php">Daftar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--FORGOT PASSWORD MODAL-->
    <div class="modal fade" id="forgot-password-modal" tabindex="-1" aria-labelledby="forgot-password-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h1 class="modal-title fs-5"><b>Perhatian!</b></h1>
                </div>
                <div class="modal-body">
                    Kamu melupakan passwordmu? Silahkan hubungi admin untuk masalah tersebut.
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
    <!--x-->

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