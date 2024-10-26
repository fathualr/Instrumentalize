<?php
session_start();
require 'function.php';

$product = query("SELECT *, C.category_name AS catname FROM product P, category C WHERE P.product_category = C.category_id");
$category = query("SELECT * FROM category");

if(isset($_POST["search_result"])){
    $product = search_result($_POST["search_keyword"]);
}

if (!isset($_SESSION["user_email"])) {
    header("Location: account-login.php");
    exit;
} else {
    $id_pengguna = $_SESSION['user_id'];
    $phone_pengguna = $_SESSION['user_phone'];

    $carts = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $id_pengguna");
    $cart_total = mysqli_num_rows($carts);
    $cart = query("SELECT *, P.product_name AS pdtname FROM cart C JOIN product P ON C.product_id = P.product_id WHERE C.user_id = '$id_pengguna'");

    if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] == "Seller") {
        $redirect_page = isset($_SESSION["previous_page"]) ? $_SESSION["previous_page"] : "admin-dashboard.php";
        
        header("Location: $redirect_page");
        exit;
    }
}
$_SESSION["previous_page"] = $_SERVER["REQUEST_URI"];

if (isset($_POST["create_order"])) {
    create_order();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Cart</title>
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
        <div class="p-lg-5 p-4 text-center" id="wrapper-profile">
            <form action="" method="" class="d-flex flex-column justify-content-between p-2" id="profile-box-cart">
                <div class="overflow-x-scroll">

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

                    <div class="container-fluid p-0" id="alert">

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
                    <table class="table mb-0" id="profile-table-cart">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th colspan="2">Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle table-group-divider text-center">

                            <?php
                            $price_total = 0;
                            
                            foreach ($cart as $crt) :
                                $price_total += $crt["product_price_total"];
                            ?>
                            <tr>
                                <td>
                                    <form action="">
                                        <input class="form-check-input" type="checkbox" value="<?= $crt["cart_id"] ?>" name="checkbox<?= $crt["cart_id"] ?>" id="checkbox<?= $crt["cart_id"] ?>">
                                    </form>
                                </td>
                                <td style="width:120px">
                                    <div class="d-flex align-items-center justify-content-center" id="image-box">
                                        <img src="<?= $crt["product_img"] ?>" alt="" id="image">
                                    </div>
                                </td>
                                <td class="text-start">
                                    <h6><?= $crt["pdtname"] ?></h6>
                                </td>
                                <td>
                                    <?= $crt["product_quantity"] ?>
                                </td>
                                <td>
                                    Rp. <?= number_format($crt["product_price_total"],0,',','.') ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    
                    <?php if (empty($cart)){
                        echo "<p class='mt-5 h5'>Tidak ada produk yang tersimpan.</p>";
                    } ?>

                </div>
                <hr class="mt-auto">
                <div class="input-group mb-3">
                    <div class="input-group-text bg-danger border-danger">
                        <input class="form-check-input mt-0" type="checkbox" value="" name="checkbox_delete" id="checkbox_delete">
                    </div>
                    <a href="#" class="btn btn-danger opacity-75" id="delete_selected_button">Hapus item yang dipilih</a>
                </div>
                <div class="d-flex justify-content-between" id="profile-indicator-cart">
                    <div class="d-flex align-items-center">
                        <p class="h3 mb-0 mx-2"><b>Total:</b></p>
                        <input type="text" class="text-center" id="total-cart-price" placeholder="Rp. <?= number_format($price_total,0,',','.') ?>" disabled readonly>
                    </div>
                    <button type="button" class="btn btn-light" id="" data-bs-toggle="modal" data-bs-target="#checkout-modal" <?php if ($cart_total <= 0) { echo "disabled"; } ?>>
                        <h2 class="mb-0">Checkout</h2>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!--CHECKOUT MODAL-->
    <div class="modal fade checkout-modal" id="checkout-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <p class="h3"><b>Konfirmasi Pemesanan</b></p>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="profile-form-checkout">
                        <div>
                            <input type="hidden" name="order_user" id="order_user" value="<?= $id_pengguna ?>">
                            <p class="text-center"><b>Alamat Pengiriman</b></p>
                            <div class="input-group mb-3">
                                <span class="input-group-text d-flex justify-content-center align-items-center" id="basic-addon1">
                                    <i class="fa-solid fa-location-dot" style="color: #000000;"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Alamat" name="order_address" id="order_address" autocomplete="off" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text d-flex justify-content-center align-items-center" id="basic-addon1">
                                    <i class="fa-solid fa-phone" style="color: #000000;"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Nomor Telepon" name="order_phone" id="order_phone" autocomplete="off" value="<?= $phone_pengguna ?>" required>
                            </div>
                            <div class="overflow-x-scroll">
                                <table class="table table-striped align-middle text-center mb-0" id="profile-table-checkout">

                                    <?php foreach($cart as $crt): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= $crt["product_img"] ?>" alt="" id="image">
                                        </td>
                                        <td class="text-start">
                                            <h6 class="mb-0"><?= $crt["pdtname"] ?></h6>
                                        </td>
                                        <td>
                                            <?= $crt["product_quantity"] ?>
                                        </td>
                                        <td>
                                            Rp. <?= number_format($crt["product_price_total"],0,',','.') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>

                                </table>
                            </div>
                        </div>
                        <div class="container-fluid text-center mt-3">
                            <p><b>Metode Pembayaran</b></p>
                            <div class="container-fluid btn-group p-0" id="payment-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="payment" id="payment-transfer" value="Transfer" autocomplete="off" data-bs-toggle="collapse" data-bs-target="#collapse-payment:not(.show)" required>
                                <label class="btn btn-outline-dark" for="payment-transfer">Transfer</label>
                            
                                <input type="radio" class="btn-check" name="payment" id="payment-cod" value="COD" autocomplete="off" data-bs-toggle="collapse" data-bs-target="#collapse-payment.show" required>
                                <label class="btn btn-outline-dark" for="payment-cod">Cash On Delivery</label>
                            </div>
                            <div class="collapse" id="collapse-payment">
                                <select class="form-select form-select-sm focus-ring focus-ring-secondary text-center mt-2" aria-label="Small select example">
                                    <option selected hidden disabled>Pilih Bank</option>
                                    <option value="1">Mandiri</option>
                                    <option value="2">BCA</option>
                                    <option value="3">BNI</option>
                                </select>
                            </div>
                            <div class="container-fluid mt-3" id="price-information">
                                <div class="row d-flex ms-auto w-50">
                                    <dl class="mb-0">
                                        <dt class="col text-start">Subtotal produk:</dt>
                                        <dd class="col text-end" id="price-cost">Rp. <?= number_format($price_total,0,',','.') ?></dd>
                                        <input type="hidden" value="<?= $price_total ?>" name="price_total" id="price_total">
                                        <dt class="col text-start">Biaya ongkos kirim:</dt>
                                        <dd class="col text-end" id="shipping-cost">Rp. </dd>
                                        <input type="hidden" value="" name="shipping_total" id="shipping_total">
                                        <dt class="col text-start">Total pembayaran:</dt>
                                        <dd class="col text-end" id="total-cost">Rp. </dd>
                                        <input type="hidden" value="" name="order_total" id="order_total">
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" name="create_order">Buat pesanan</button>
                    </div>
                </form>
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