<?php
session_start();
require 'function.php';

$orders_total = count(query("SELECT * FROM orders"));
$page = ceil($orders_total / 10);
$current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
$first_data = (10 * $current_page) - 10;

$orders = query("SELECT *, U.user_email AS odruser FROM orders O JOIN user U ON O.order_user = U.user_id ORDER BY order_id DESC LIMIT $first_data,10");

if(!isset($_SESSION["user_email"])){
    header("Location: account-login.php");
    exit;
}
$pengguna = $_SESSION['user_name'];

if (!isset($_SESSION["user_email"])) {
    header("Location: account-login.php");
    exit;
} else {
    if (isset($_SESSION["user_role"]) && $_SESSION["user_role"] == "Buyer") {
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
    <title>Admin - Orders</title>
    <!--Logo Website-->
    <link rel="icon" type="image/x-icon" href="images/favicon-32x32.png">
    <!--Framework Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!--Custom CSS & JS-->
    <link rel="stylesheet" href="style-admin.css">
    <script src="script.js"></script>
    <!--FontAwesome Icon-->
    <script src="https://kit.fontawesome.com/a28c4a206b.js" crossorigin="anonymous"></script>
    <!--Poppins Font-->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>    
</head>
<body>

    <!--HEADER-->
    <header class="container-fluid" id="">
        <div class="d-flex align-items-center justify-content-between mx-lg-5" id="admin-box-header">
            <button class="btn btn-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-navbar" aria-controls="offcanvasExample">
                <i class="h1 fa-solid fa-bars m-0" style="color: #000000;"></i>
            </button>
            <img src="images/INSTRUMENTALIZE_logo.png" class="ml-5" alt="instrumentalize-logo">
            <h3 class="d-none d-lg-block mb-0">Selamat datang, Admin</h3>
            <div class="dropdown-center">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="h1 fa-regular fa-user m-0" style="color: #000"></i>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!--MID WRAPPER-->
    <div class="d-flex" id="wrapper-content">

        <!--SIDEBAR NAVIGATION-->
        <div class="offcanvas-lg offcanvas-start bg-black text-light" tabindex="-1" id="offcanvas-navbar" aria-labelledby="offcanvasExampleLabel">
            <div class="container text-dark p-4">
                <div class="d-flex bg-light align-items-center p-2 gap-2" id="profile-admin-box">
                    <i class="fa-solid fa-user mb-0"></i>
                    <p class="text-dark mb-0"><?php echo $pengguna;?></p>
                </div>
            </div>
            <nav class="d-lg-flex flex-column text-white px-4" id="admin-box-navigation">
                <ul class="h4 navbar-nav">
                    <li class="nav-item active">
                        <a href="admin-dashboard.php" class="nav-link mb-3">
                            <i class="fa-solid fa-chart-simple"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="admin-editor.php" class="nav-link mb-3">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Editor
                        </a>
                    </li>
                    <li>
                        <a href="admin-category.php" class="nav-link mb-3">
                            <i class="fa-solid fa-tags"></i>
                            Category
                        </a>
                    </li>
                    <li>
                        <a href="admin-product.php" class="nav-link mb-3">
                            <i class="fa-solid fa-table"></i>
                            Product
                        </a>
                    </li>
                    <li>
                        <a href="admin-orders.php" class="nav-link mb-3">
                            <i class="fa-solid fa-file-invoice"></i>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a href="admin-user.php" class="nav-link mb-3">
                            <i class="fa-solid fa-id-card"></i>
                            User
                        </a>
                    </li>
                    <li>
                        <a href="admin-reports.php" class="nav-link mb-3">
                            <i class="fa-solid fa-message"></i>
                            Reports
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!--CONTENT-->
        <section class="text-light p-3" id="admin-box-content">

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

            <h2><b>Orders</b></h2>
            <div class="container-fluid d-flex flex-column text-dark p-2" id="content-box-wrapper">
                <div class="container-fluid d-flex justify-content-between py-2 px-0">
                    <h3 class="mb-0">Orderan</h3>
                    <form class="mb-0" action="">
                        <input type="text" class="form-control focus-ring focus-ring-secondary" id="inputSearchOrders" placeholder="Cari..." autocomplete="off">
                    </form>
                    <div class="" style="color:#d9d9d9; width:90px">x</div>
                </div>
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
                <div class="overflow-x-scroll" id="boxTableOrders">
                    <table class="table table-striped mb-auto" id="admin-table-editable">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Total</th>
                                <th scope="col">Pembayaran</th>
                                <th scope="col">Status</th>
                                <th scope="col">Waktu Order</th>
                                <th scope="col" colspan="3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider align-middle text-center">

                            <!--template row product table-->
                            <?php foreach($orders as $odr): ?>
                            <tr>
                                <td>#<?= $odr['order_id'] ?></td>
                                <td class="text-start"><?= $odr['odruser'] ?></td>
                                <td class="text-start"><?= $odr['order_address'] ?></td>
                                <td>Rp. <?= number_format($odr['order_total'],0,',','.') ?></td>
                                <td>
                                    <?php if ($odr['order_payment'] == 'Transfer') : ?>
                                        <?php if ($odr['order_proof'] == '') : ?>
                                        <i class="fa-solid fa-circle text-danger"></i>
                                        <?php else: ?>
                                        <i class="fa-solid fa-circle text-success"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?= $odr['order_payment'] ?>
                                </td>
                                <td><?= $odr['order_status'] ?></td>
                                <td><?= $odr['order_datetime'] ?></td>
                                <td>
                                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#order-modal-<?= $odr['order_id']?>">
                                        Lihat
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-order-modal-<?= $odr['order_id']?>">
                                        <i class="fa-solid fa-pen-to-square" style="color: #fdfffd;"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-order-modal-<?= $odr['order_id']?>">
                                        <i class="fa-solid fa-trash-can" style="color: #fdfffd;"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>

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
                    <?php if ($odr['order_proof'] == '') : ?>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Bukti pembayaran:</label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-danger w-100">Bukti pembayaran belum dikirim.</button>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Bukti pembayaran:</label>
                        <div class="col-sm-9">
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#order-proof-modal-<?= $odr['order_id']?>">Lihat bukti pembayaran</button>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="row mb-sm-2 mb-md-4">
                    <label class="col-sm-3 col-form-label text-sm-start">Produk:</label>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-light w-100" id="order-modal-button" data-bs-toggle="modal" data-bs-target="#order-item-modal-<?= $odr['order_id']?>">Lihat produk dipesan</button>
                    </div>
                </div>
                <div class="row mb-sm-2 mb-md-4">
                    <label class="col-sm-3 col-form-label text-sm-start">Order ID:</label>
                    <div class="col-sm-9">
                        <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="#<?= $odr['order_id']?>">
                    </div>
                </div>
                <div class="row mb-sm-2 mb-md-4">
                    <label class="col-sm-3 col-form-label text-sm-start">Email:</label>
                    <div class="col-sm-9">
                        <input type="text" class="focus-ring focus-ring-secondary form-control" disabled value="<?= $odr['odruser']?>">
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
                <p class="h3"><b>Bukti pembayaran</b></p>
            </div>
            <div class="modal-body">
                <div class="container-fluid d-flex justify-content-center" id="image-box">
                    <img src="<?= $odr['order_proof']?>" alt="" height="250px">
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

<!--EDIT ORDER MODAL-->
<?php foreach($orders as $odr):?>
<div class="modal fade" id="edit-order-modal-<?= $odr['order_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header justify-content-center">
                    <p class="h3 mb-0"><b>Ubah Status Orderan #<?= $odr['order_id']?></b></p>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?= $odr['order_id']?>">
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Order ID:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" value="#<?= $odr['order_id']?>" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label text-sm-start">Status:</label>
                        <div class="col-sm-9">
                            <select class="form-select form-control focus-ring focus-ring-secondary" name="order_status" id="order_status" required>
                                <option value="" hidden disabled <?php if($odr["order_status"] === "Antrian") echo "selected"; ?>>Antrian</option>
                                <option value="Dalam Proses" <?php if($odr["order_status"] === "Dalam Proses") echo "selected"; ?>>Dalam Proses</option>
                                <option value="Dikirim" <?php if($odr["order_status"] === "Dikirim") echo "selected"; ?>>Dikirim</option>
                                <option value="Selesai" <?php if($odr["order_status"] === "Selesai") echo "selected"; ?>>Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary" name="update_order">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!--x-->

<!--DELETE ORDER MODAL-->
<?php foreach($orders as $odr):?>
<div class="modal fade" id="delete-order-modal-<?= $odr['order_id']?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Hapus Orderan #<?= $odr['order_id']?></b></p>
            </div>
            <div class="modal-body">
                Apakah kamu yakin akan menghapus orderan ini?
            </div>
            <div class="modal-footer py-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-light" type="button" data-bs-target="#delete-order-modal2-<?= $odr['order_id']?>" data-bs-toggle="modal">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-order-modal2-<?= $odr['order_id']?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                Tekan tombol <b>hapus</b> untuk menghapus orderan #<?= $odr['order_id']?>.
            </div>
            <div class="modal-footer py-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="delete-data.php?order_id=<?= $odr['order_id']?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!--x-->
                </div>

                <!--Pagination-->
                <div class="container-fluid mt-auto">
                    <ul class="list-unstyled d-flex justify-content-end mb-0 py-3" id="pagination-table">
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
        </section>
    </div>

    <!--FOOTER-->
    <footer class="container-fluid justify-content-center d-flex align-items-end" id="">
        ©2023 INSTRUMENTALIZE
    </footer>
</body>
</html>