<?php
session_start();
require 'function.php';

if(!isset($_SESSION["user_name"])){
    header("Location: account-login.php");
    exit;
}
$pengguna = $_SESSION['user_name'];

$category_total = count(query("SELECT * FROM category"));
$page = ceil($category_total / 5);
$current_page = (isset($_GET["page"])) ? $_GET["page"] : 1;
$first_data = (5 * $current_page) - 5;

$category = query("SELECT * FROM category LIMIT $first_data,5");

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
    <title>Admin - Category</title>
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

            <h2><b>Category</b></h2>
            <div class="container-fluid d-flex flex-column text-dark p-2" id="content-box-wrapper">
                <div class="container-fluid d-flex justify-content-between py-2 px-0">
                    <h3 class="mb-0">Kategori</h3>
                    <button class="btn btn-light d-flex align-items-center p-1" id="button-table-add" data-bs-toggle="modal" data-bs-target="#create-category-modal">
                        <i class="fa-solid fa-plus" style="color: #000000;"></i>
                        <p class="m-0">Tambah</p>
                    </button>
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
                <div class="overflow-x-scroll" id="table-box-product">
                    <table class="table table-striped align-middle mb-auto" id="admin-table-editable">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Gambar Kategori</th>
                                <th>Nama</th>
                                <th colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider text-center">

                            <!--Template for category table row-->
                            <?php 
                            $no = ($current_page - 1) * 5 + 1;
                            foreach($category as $ctg): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <img src="<?= $ctg["category_img"] ?>" alt="<?= $ctg["category_name"] ?>">
                                </td>
                                <td><?= $ctg["category_name"] ?></td>
                                <td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-category-modal-<?= $ctg["category_id"] ?>">
                                        <i class="fa-solid fa-pen-to-square" style="color: #fdfffd;"></i>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-category-modal-<?= $ctg["category_id"] ?>">
                                        <i class="fa-solid fa-trash-can" style="color: #fdfffd;"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
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

        <!--CREATE CATEGORY MODAL-->
        <div class="modal fade" id="create-category-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="" method="post" id="" enctype="multipart/form-data">
                        <div class="modal-header justify-content-center">
                            <p class="h3 mb-0"><b>Tambah Kategori</b></p>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-sm-2 mb-md-4">
                                <label class="col-sm-4 col-form-label text-sm-start" for="category_name">Nama:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="focus-ring focus-ring-secondary form-control" name="category_name" id="category_name" required>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label text-sm-start" for="category_img">Gambar:</label>
                                <div class="col-sm-8">
                                    <input type="file" class="focus-ring focus-ring-secondary form-control" name="category_img" id="category_img" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success" name="create_category">Tambahkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--x-->
    
        <!--EDIT CATEGORY MODAL-->
        <?php foreach($category as $ctg): ?>
        <div class="modal fade" id="edit-category-modal-<?= $ctg["category_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <form action="" method="post" id="" enctype="multipart/form-data">
                        <div class="modal-header justify-content-center">
                            <p class="h3 mb-0"><b>Edit Kategori</b></p>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="category_id" value="<?= $ctg["category_id"] ?>">
                            <div class="row mb-sm-2 mb-md-4">
                                <label class="col-sm-4 col-form-label text-sm-start" for="category_name">Nama:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="focus-ring focus-ring-secondary form-control" name="category_name" id="category_name" value="<?= $ctg["category_name"] ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label text-sm-start" for="category_img">Gambar:</label>
                                <div class="col-sm-8">
                                    <input type="file" class="focus-ring focus-ring-secondary form-control" name="category_img" id="category_img">
                                    <input type="hidden" name="current_category_img" value="<?= $ctg["category_img"] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer py-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary" name="edit_category">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <!--x-->

        <!--DELETE CATEGORY MODAL-->
        <?php foreach($category as $ctg): ?>
        <div class="modal fade" id="delete-category-modal-<?= $ctg["category_id"] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <p class="h3 mb-0"><b>Hapus kategori</b></p>
                    </div>
                    <div class="modal-body">
                        Apakah kamu yakin akan menghapus kategori ini?
                    </div>
                    <div class="modal-footer py-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-light" data-bs-target="#delete-category-modal2-<?= $ctg["category_id"] ?>" data-bs-toggle="modal">Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="delete-category-modal2-<?= $ctg["category_id"] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        Tekan tombol <b>hapus</b> untuk menghapus kategori.
                    </div>
                    <div class="modal-footer py-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <a href="delete-data.php?category_id=<?= $ctg["category_id"] ?>" class="btn btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <!--x-->

    <!--FOOTER-->
    <footer class="container-fluid justify-content-center d-flex align-items-end" id="">
        ©2023 INSTRUMENTALIZE
    </footer>
</body>
</html>