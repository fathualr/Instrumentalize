<?php
session_start();
require 'function.php';

$user = mysqli_query($conn, "SELECT * FROM user");
$user_total = mysqli_num_rows($user);
$product = mysqli_query($conn, "SELECT * FROM product");
$product_total = mysqli_num_rows($product);
$orders = mysqli_query($conn, "SELECT * FROM orders");
$orders_total = mysqli_num_rows($orders);
$incomeResult = query("SELECT SUM(order_total) AS total_income FROM orders");

$last_user = query("SELECT * FROM user ORDER BY user_id DESC LIMIT 1");
$last_orders = query("SELECT *, U.user_email AS odruser FROM orders O JOIN user U ON O.order_user = U.user_id ORDER BY order_id DESC LIMIT 1");
$last_product = query("SELECT *, C.category_name as catname FROM product P, category C WHERE P.product_category = C.category_id ORDER BY P.product_id DESC LIMIT 1");

if (!isset($_SESSION["user_email"])) {
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
$_SESSION["previous_page"] = $_SERVER["REQUEST_URI"];?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Dashboard</title>
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

    <!--Mid WRAPPER-->
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
            <h2><b>Dashboard</b></h2>
            <div class="container-fluid text-dark text-center">

                <div class="d-flex flex-column gap-3">
                    <div class="row gap-3 p-0">
                        <div class="col-md px-0" id="content-box-total">
                            <div class="d-flex justify-content-center align-items-center" id="box-content-head">
                                <b>Jumlah Produk</b>
                            </div>
                            <table>
                                <tr>
                                    <td><a href="admin-product.php" class="h1"><?= $product_total; ?></a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md offset-md-0 px-0" id="content-box-total">
                            <div class="d-flex justify-content-center align-items-center" id="box-content-head">
                                <b>Jumlah Pengguna</b>
                            </div>
                            <table>
                                <tr>
                                    <td><a href="admin-user.php" class="h1"><?= $user_total; ?></a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md px-0" id="content-box-total">
                            <div class="d-flex justify-content-center align-items-center" id="box-content-head">
                                <b>Jumlah Orderan</b>
                            </div>
                            <table>
                                <tr>
                                    <td><a href="admin-orders.php" class="h1"><?= $orders_total; ?></a></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md offset-md-0 px-0" id="content-box-total">
                            <div class="d-flex justify-content-center align-items-center" id="box-content-head">
                                <b>Jumlah Pendapatan</b>
                            </div>
                            <table>
                                <tr>
                                    <td><a href="admin-orders.php" class="h4">Rp. <?= number_format($incomeResult[0]['total_income'],0,',','.'); ?></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row gap-3">
                        <div class="col-md px-0 d-flex flex-column gap-3">
                            <div class="col px-0" id="content-box-newest">
                                <div class="d-flex justify-content-center align-items-center" id="box-content-head">
                                    <b>Pengguna Terbaru</b>
                                </div>
                                <div class="">
                                <table>

                                    <tr>
                                        <td>#<?= $last_user[0]['user_id'] ?></td>
                                        <td><?= $last_user[0]['user_name'] ?></td>
                                        <td><?= $last_user[0]['user_email'] ?></td>
                                    </tr>

                                </table>
                                </div>
                            </div>
                            <div class="col px-0" id="content-box-newest">
                                <div class="d-flex justify-content-center align-items-center" id="box-content-head">
                                    <b>Orderan Terbaru</b>
                                </div>
                                <table >

                                    <tr>
                                        <td>#<?= $last_orders[0]['order_id'] ?></td>
                                        <td><?= $last_orders[0]['odruser'] ?></td>
                                        <td><?= $last_orders[0]['order_address'] ?></td>
                                        <td>Rp. <?= number_format($last_orders[0]['order_total'],0,',','.'); ?></td>
                                        <td><?= $last_orders[0]['order_datetime'] ?></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="col-md px-0 justify-content-between">
                            <div class="mx-auto" id="content-box-top-sold">
                            <div class="d-flex justify-content-center align-items-center" id="box-content-head">
                                <b>Produk Penjualan Teratas</b>
                            </div>
                            <div class="overscrollflow-x-">
                            <table>
                                <tr>
                                    <td>$product_photo</td>
                                    <td>$product_name</td>
                                    <td>$product_sold</td>
                                </tr>
                                <tr>
                                    <td>$product_photo</td>
                                    <td>$product_name</td>
                                    <td>$product_sold</td>
                                </tr>
                                <tr>
                                    <td>$product_photo</td>
                                    <td>$product_name</td>
                                    <td>$product_sold</td>
                                </tr>
                            </table>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col px-0" id="content-box-new-product">
                            <div class="d-flex justify-content-center align-items-center" id="box-content-head">
                                <b>Produk Terbaru</b>
                            </div>
                            <div class="">
                            <table>

                                <tr>
                                    <td>#<?= $last_product[0]['product_id'] ?></td>
                                    <td><img src="<?= $last_product[0]["product_img"] ?>" alt="<?= $last_product[0]["product_name"] ?>"></td>
                                    <td><?= $last_product[0]['product_name'] ?></td>
                                    <td><?= $last_product[0]['catname'] ?></td>
                                    <td><?= $last_product[0]['product_stock'] ?> Pcs.</td>
                                    <td>Rp. <?= number_format($last_product[0]['product_price'],0,',','.'); ?></td>
                                </tr>

                            </table>
                            </div>
                        </div>
                    </div>
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