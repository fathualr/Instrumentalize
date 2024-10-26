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

    $orders_total = count(query("SELECT * FROM orders"));
    $page = ceil($orders_total / 10);
    $current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
    $first_data = (10 * $current_page) - 10;
    
    $orders = query("SELECT * FROM orders WHERE order_user = '$id_pengguna' ORDER BY order_id DESC LIMIT $first_data,10");
    
    $carts = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $id_pengguna");
    $cart_total = mysqli_num_rows($carts);

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
    <title>Profile - Status</title>
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
                            <a href="profile-status.php" class="nav-link mb-3 active">
                                Status Pesanan
                            </a>
                        </li>
                        <li>
                            <a href="profile-notification.php" class="nav-link mb-3">
                                Notifikasi
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!--PROFILE CONTENT-->
            <div class="container-fluid d-flex flex-column p-0" id="profile-content">
                <p class="h2 text-center py-4"><b>Pesanan Saya</b></p>
                <hr>
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

                </div>
                <div class="overflow-x-scroll">
                    <table class="table table-hover text-center align-middle mb-0" id="profile-table-status">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Alamat</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Waktu Pemesanan</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach($orders as $odr):?>
                                <?php if ($odr['order_payment'] == 'Transfer' && $odr['order_proof'] == '') : ?>
                                    <tr >
                                        <td colspan="5" class="p-0" style="height:auto">
                                            <p class="bg-danger text-light p-1 mb-0" style="font-size:10px">
                                                <a href="" id="link-order-proof" data-bs-toggle="modal" data-bs-target="#order-proof-modal-<?= $odr['order_id']?>">Pesanan #<?= $odr['order_id'] ?> menggunakan pembayaran <b>transfer</b>, silahkan kirim bukti pembayaran agar pesanan #<?= $odr['order_id'] ?> dapat diproses</a>
                                            </p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <tr data-bs-toggle="modal" data-bs-target="#order-modal-<?= $odr['order_id']?>">
                                <td>#<?= $odr['order_id'] ?></td>
                                <td><?= $odr['order_address'] ?></td>
                                <td>Rp. <?= number_format($odr['order_total'],0,',','.') ?></td>
                                <td><?= $odr['order_status'] ?></td>
                                <td><?= $odr['order_datetime'] ?></td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

                <!--Pagination-->
                <div class="container-fluid mt-auto">
                    <ul class="list-unstyled d-flex justify-content-end mb-0 py-3" id="pagination-profile-table">
                        <li>
                            <?php if ($current_page == 1): ?>
                            <button class="bg-secondary-subtle pe-none" id="nav">
                                <i class="fa-solid fa-chevron-left" style="color: #000000;"></i>
                            </button>
                            <?php else: ?>
                            <a href="?page=<?= $current_page - 1 ?>">
                                <button class="btn btn-light" id="nav">
                                    <i class="fa-solid fa-chevron-left" style="color: #000000;"></i>
                                </button>
                            </a>
                            <?php endif; ?>
                        </li>
                        <li>
                            <a>
                                <input class="text-center" type="text" name="" id="" placeholder="<?= $current_page ?>" disabled>
                            </a>
                        </li>
                        <li>
                            <?php if ($current_page == $page): ?>
                            <button class="bg-secondary-subtle pe-none" id="nav">
                                <i class="fa-solid fa-chevron-right" style="color: #000000;"></i>
                            </button>
                            <?php else: ?>
                            <a href="?page=<?= $current_page + 1 ?>">
                                <button class="btn btn-light" id="nav">
                                    <i class="fa-solid fa-chevron-right" style="color: #000000;"></i>
                                </button>
                            </a>
                            <?php endif; ?>
                            
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!--ORDERS MODAL-->
    <?php foreach($orders as $odr):?>
    <div class="modal fade order-modal" id="order-modal-<?= $odr['order_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <p class="h3 mb-0"><b>Detail Orderan #<?= $odr['order_id']?></b></p>
                </div>
                <div class="modal-body">
                    <?php if ($odr['order_payment'] == 'Transfer') : ?>
                        <?php if ($odr['order_status'] == 'Antrian') : ?>
                            <div class="row mb-sm-2 mb-md-4">
                                <div class="col">
                                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#order-proof-modal-<?= $odr['order_id']?>">Kirim bukti pembayaran</button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row mb-sm-2 mb-md-4">
                            <label class="col-sm-3 col-form-label text-sm-start">Bukti pembayaran:</label>
                            <div class="col-sm-9 d-flex justify-content-center" id="image-box">
                                <img src="<?= $odr['order_proof']?>" alt="">
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Order ID:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="#<?= $odr['order_id']?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Email:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="<?= $odr['order_user']?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Produk:</label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-light w-100" id="order-modal-button" data-bs-toggle="modal" data-bs-target="#order-item-modal-<?= $odr['order_id']?>">Lihat produk dipesan</button>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Alamat:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="<?= $odr['order_address']?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">No Telepon:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="<?= $odr['order_phone']?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Total:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="Rp. <?= number_format($odr['order_total'],0,',','.') ?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Pembayaran:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="<?= $odr['order_payment']?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Status:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="<?= $odr['order_status']?>">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label text-sm-start">Waktu Order:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="<?= $odr['order_datetime']?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <!--x-->

    <!--ORDERS ITEMS MODAL-->
    <?php foreach($orders as $odr):?>
    <div class="modal fade" id="order-item-modal-<?= $odr['order_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <p class="h3 mb-0"><b>Produk Dipesan</b></p>
                </div>
                <div class="modal-body">
                    <table class="container-fluid text-center mb-3">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle table-group-divider text-center">

                            <?php 
                            $order_item = query("SELECT *, P.product_name AS pdtname FROM order_item O JOIN product P ON O.product_id = P.product_id WHERE order_id = '" . $odr['order_id'] . "'");
                            foreach($order_item as $odri): ?>
                            <tr>
                                <td class="text-start">
                                    <h6 class="mb-0"><?= $odri["pdtname"] ?></h6>
                                </td>
                                <td>
                                    <?= $odri["order_item_quantity"] ?>
                                </td>
                                <td class="text-end">
                                    Rp. <?= number_format($odri["order_item_total_price"],0,',','.') ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    <hr class="mb-0">
                    <div class="row">
                        <dt class="col-6">Ongkos kirim:</dt>
                        <dd class="col-6 text-end">
                            <?php if ($odr['order_payment'] == 'Transfer') : ?>
                                Rp. 500.000
                            <?php else: ?>
                                RP. 1.000.000
                            <?php endif; ?>
                        </dd>
                        <dt class="col-6">Total:</dt>
                        <dd class="col-6 text-end">Rp. <?= number_format($odr['order_total'],0,',','.') ?></dd>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#order-modal-<?= $odr['order_id']?>">Kembali</button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <!--x-->

    <!--ORDERS PROOF MODAL-->
    <?php foreach($orders as $odr):?>
    <div class="modal fade" id="order-proof-modal-<?= $odr['order_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <p class="h4 mb-0"><b>Bukti pembayaran</b></p>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="">
                        <div class="container-fluid d-flex justify-content-center">
                            <img src="images/receipt.png" alt="receipt-example" height="250px">
                        </div>
                        <p class="text-danger mb-0" style="font-size:10px">*Silahkan kirim bukti pembayaran pesanan, seperti contoh yang tertera.</p>
                        <input type="hidden" value="<?= $odr['order_id']?>" name="order_id" id="order_id">
                        <input type="file" class="form-control" name="order_proof_img" id="order_proof_img" required>
                    </div>
                    <div class="modal-footer py-0">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#order-modal-<?= $odr['order_id']?>">Kembali</button>
                        <button type="submit" class="btn btn-primary" name="send_order_proof">Kirim Bukti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
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