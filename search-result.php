<?php
session_start();
require 'function.php';
$_SESSION["previous_page"] = $_SERVER["REQUEST_URI"];

$product = query("SELECT *, C.category_name as catname FROM product P JOIN category C ON P.product_category = C.category_id WHERE P.is_deleted = false ORDER BY P.product_id DESC");
$category = query("SELECT * FROM category");

$category_id = isset($_GET['category']) ? $_GET['category'] : null;
$search_keyword = isset($_GET["search_keyword"]) ? $_GET["search_keyword"] : '';
$product = search_result($search_keyword, $category_id);

if (isset($_SESSION["user_email"])) {
    $id_pengguna = $_SESSION["user_id"];
    $carts = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $id_pengguna");
    $cart_total = mysqli_num_rows($carts);

    if(isset($_POST["add_to_cart"])){
        add_to_cart($_POST);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
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
        <div class="p-lg-5 p-4 text-center" id="wrapper-section">

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

            <div class="p-2" id="search-result-box">
                <div class="dropdown-center mb-4">
                    <button class="container-fluid btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </button>
                    <ul class="dropdown-menu text-center">

                        <!--template for category dropdown-->
                        <?php foreach($category as $ctg): ?>
                        <li><a class="dropdown-item" href="search-result.php?category=<?= $ctg["category_id"] ?>"><?= $ctg["category_name"] ?></a></li>
                        <?php endforeach; ?>
                        <!--x-->

                    </ul>
                </div>

                <?php if(isset($_GET["search_result"])){
                    echo '<p class="h4"><b>Menampilkan hasil pencarian "' . $_GET["search_keyword"] . '"</b></p>';
                } 
                ?>

                <div class="container-fluid py-0" id="alert">

                    <!--RESPOND MESSAGE-->
                    <?php if(isset($_SESSION['status_success'])){ ?>
                    <div class="alert alert-success d-flex align-items-center p-2 mb-1" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>
                            <?= $_SESSION['status_success']; ?>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['status_success']); } ?>

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

                <!--LIST PRODUK-->
                <div class="container-fluid mt-4" id="search-result-box-product">
                    <div class="row">

                    <?php if (!empty($product)) : ?>
                        <?php foreach ($product as $pdt) : ?>
                            <div class="col-lg-3 col-6 mb-3">
                                <button class="card p-0 align-items-center" id="product" data-bs-toggle="modal" data-bs-target="#product-modal-<?= $pdt["product_id"] ?>">
                                    <div class="d-flex align-items-center justify-content-center <?php if ($pdt['product_stock'] == 0) echo "opacity-50" ?>" id="image-box">
                                        <img src="<?= $pdt["product_img"] ?>" alt="<?= $pdt["product_name"] ?>">
                                    </div>
                                    <div class="card-body d-flex flex-column p-1">
                                        <p class="card-text"><b><?= $pdt["product_name"] ?></b></p>
                                        <p class="card-text mt-auto">Rp. <?= number_format($pdt["product_price"],'0',',','.') ?></p>
                                    </div>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12">
                            <p class="h4">Produk tidak tersedia.</p>
                        </div>
                    <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--PRODUCT MODAL-->
    <?php foreach($product as $pdt): ?>
    <div class="modal fade product-modal" id="product-modal-<?= $pdt["product_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-center" id="product-modal-picture">
                                <img src="<?= $pdt["product_img"] ?>" alt="<?= $pdt["product_name"] ?>">
                            </div>
                            <p class="p-2 h6 text-center mb-0" id="product-modal-price">Stok: <?= $pdt["product_stock"] ?></p>
                        </div>
                        <div class="col d-flex flex-column justify-content-between px-3">
                            <h4 class="d-flex align-items-center justify-content-center text-center" id="product-modal-title"><?= $pdt["product_name"] ?></h4>
                            <p class="p-2 h6 text-center" id="product-modal-id">ID: #<?= $pdt["product_id"] ?></p>
                            <p class="p-2 h6 d-flex align-items-center gap-3" id="product-modal-category"><span type="button" class="btn btn-outline-secondary w-100" id disabled><?= $pdt["catname"] ?></span></p>
                            <p class="p-2 h6 text-center" id="product-modal-price">Rp. <?= number_format($pdt["product_price"],'0',',','.') ?></p>
                            <p class="p-2 h6 overflow-y-scroll" id="product-modal-desc"><?= $pdt["product_desc"] ?></p>
                            <form action="" method="post" class="d-flex" id="product-modal-form">
                                <input type="hidden" name="product_id" id="product_id" value="<?= $pdt["product_id"] ?>">
                                <input type="hidden" name="product_img" id="product_img" value="<?= $pdt["product_img"] ?>">
                                <input type="hidden" name="product_price_total" id="product_price_total" value="<?= $pdt["product_price"] ?>">
                                <button type="button" class="btn btn-light <?php if ($pdt["product_stock"] <= 0) echo"d-none" ?>" id="kurang">
                                    <i class="fa-solid fa-minus" style="color: #000000;"></i>
                                </button>
                                <input type="number" class="text-center <?php if ($pdt["product_stock"] <= 0) echo"d-none" ?>" id="product_quantity" name="product_quantity" value="1" readonly min="1" max="<?= $pdt["product_stock"] ?>">
                                <button type="button" class="btn btn-light <?php if ($pdt["product_stock"] <= 0) echo"d-none" ?>" id="tambah">
                                    <i class="fa-solid fa-plus" style="color: #000000;"></i>
                                </button>
                                <?php if ($pdt["product_stock"] > 0) : ?>
                                    <?php if (isset($_SESSION["user_email"])): ?>
                                    <button type="submit" class="btn btn-light" name="add_to_cart" id="add_to_cart">Tambahkan ke keranjang</button>
                                    <?php else: ?>
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#main-modal" id="add_to_cart">Tambahkan ke keranjang</button>
                                    <?php endif; ?>
                                <?php else : ?>
                                <p class="h5 p-2 text-center bg-dark text-light mb-0 container-fluid">Stok habis.</p>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <!--x-->

    <!--MAIN MODAL-->
    <div class="modal fade main-modal" id="main-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img class="my-3" src="images/INSTRUMENTALIZE_logo.png" alt="" width="150px" height="150px">
                    <p class="h3 mb-4">Sebelum memulai, apakah kamu sudah punya akun?</p>
                    <div class="d-flex justify-content-evenly text-light">
                        <a href="account-register.php" class="btn btn-danger px-4" style="font-size: 1rem; width: 150px;">
                            Belum
                            <hr>
                            Buat akun
                        </a>
                        <a href="account-login.php" class="btn btn-success px-4" style="font-size: 1rem; width: 150px;">
                            Sudah
                            <hr>
                            Login akun
                        </a>
                    </div>
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