<?php
require '../function.php';
$input_search_product = $_GET['inputSearchProduct'];
$products = query("SELECT *, C.category_name as catname FROM product P JOIN category C ON P.product_category = C.category_id WHERE (P.product_id LIKE '%$input_search_product%' OR P.product_name LIKE '%$input_search_product%') AND P.is_deleted = false");
$category = query("SELECT * FROM category");
?>
<table class="table table-striped align-middle mb-auto" id="admin-table-editable">
    <thead class="text-center">
        <tr>
            <th scope="col">Produk ID</th>
            <th scope="col" colspan="2">Nama Produk</th>
            <th scope="col">Kategori</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Stok</th>
            <th scope="col">Harga</th>
            <th scope="col" colspan="3">Aksi</th>
        </tr>
    </thead>
    <tbody class="table-group-divider text-center">

        <!--template row product table-->
        <?php foreach($products as $pdt): ?>
        <tr>
            <td>#<?= $pdt["product_id"] ?></td>
            <td>
                <img src="<?= $pdt["product_img"] ?>" alt="<?= $pdt["product_name"] ?>" id="image">
            </td>
            <td class="text-start">
                <?= $pdt["product_name"] ?>
            </td>
            <td><?= $pdt["catname"] ?></td>
            <td class="text-start"><?= $pdt["product_desc"] ?></td>
            <td><?= $pdt["product_stock"] ?></td>
            <td class="text-start">Rp.<?= number_format($pdt["product_price"],'0',',','.') ?></td>
            <td>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#product-modal-<?= $pdt["product_id"] ?>">
                    Lihat
                </button>
            </td>
            <td>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-product-modal-<?= $pdt["product_id"] ?>">
                    <i class="fa-solid fa-pen-to-square" style="color: #fdfffd;"></i>
                </button>
            </td>
            <td>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-product-modal-<?= $pdt["product_id"] ?>">
                    <i class="fa-solid fa-trash-can" style="color: #fdfffd;"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>

<!--PRODUCT MODAL-->
<?php foreach($products as $pdt): ?>
<div class="modal fade" id="product-modal-<?= $pdt["product_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Detail Produk #<?= $pdt["product_id"] ?></b></p>
            </div>
            <div class="modal-body">
                <div class="d-flex">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center justify-content-center" id="modal-picture">
                            <img src="<?= $pdt["product_img"] ?>" alt="<?= $pdt["product_name"] ?>">
                        </div>
                        <p class="p-2 h6 text-center mb-0" id="product-modal-price">Stok: <?= $pdt["product_stock"] ?></p>
                    </div>
                    <div class="col d-flex flex-column justify-content-between px-3">
                        <h4 class="d-flex align-items-center justify-content-center text-center" id="product-modal-title"><?= $pdt["product_name"] ?></h4>
                        <p class="p-2 h6 text-center" id="product-modal-id">Produk ID: #<?= $pdt["product_id"] ?></p>
                        <p class="p-2 h6" id="product-modal-category"><span type="button" class="btn btn-outline-secondary w-100" disabled><?= $pdt["catname"] ?></span></p>
                        <p class="p-2 h6 text-center" id="product-modal-price">Rp. <?= number_format($pdt["product_price"],'0',',','.') ?></p>
                        <p class="p-2 h6 mb-0" id="product-modal-desc"><?= $pdt["product_desc"] ?></p>
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

<!--CREATE PRODUCT MODAL-->
<div class="modal fade create-modal" id="create-product-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Tambah Produk</b></p>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="" enctype="multipart/form-data">
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Gambar:</label>
                        <div class="col-sm-8">
                            <input type="file" class="focus-ring focus-ring-secondary form-control" name="product_img" id="product_img" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Nama:</label>
                        <div class="col-sm-8">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" name="product_name" id="product_name" placeholder="Nama" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Kategori:</label>
                        <div class="col-sm-8">
                            <select class="form-select form-control focus-ring focus-ring-secondary" name="product_category" id="product_category" required>
                                <option value="" selected disabled hidden>Kategori</option>

                                <!--template for category-->
                                <?php foreach($category as $ctg): ?>
                                <option value="<?= $ctg["category_id"] ?>"><?= $ctg["category_name"] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Deskripsi:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control focus-ring focus-ring-secondary" rows="3" name="product_desc" id="product_desc" placeholder="Deskripsi" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Stok:</label>
                        <div class="col-sm-8">
                            <input type="number" class="focus-ring focus-ring-secondary form-control" name="product_stock" id="product_stock" placeholder="Stok" required>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label text-sm-start">Harga:</label>
                        <div class="col-sm-8 input-group w-auto">
                            <span class="input-group-text" id="rupiah">Rp.</span>
                            <input type="number" class="focus-ring focus-ring-secondary form-control" aria-describedby="rupiah" name="product_price" id="product_price" placeholder="Harga" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" name="create_product">Tambahkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--x-->

<!--EDIT PRODUCT MODAL--> 
<?php foreach($products as $pdt): ?>
<div class="modal fade" id="edit-product-modal-<?= $pdt["product_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Edit Produk #<?= $pdt["product_id"] ?></b></p>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="product_id" value="<?= $pdt["product_id"] ?>">
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Foto:</label>
                        <div class="col-sm-8">
                            <input type="file" class="focus-ring focus-ring-secondary form-control" name="product_img" id="product_img">
                            <input type="hidden" name="current_product_img" value="<?= $pdt["product_img"] ?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Nama:</label>
                        <div class="col-sm-8">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" name="product_name" id="product_name" value="<?= $pdt["product_name"] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Kategori:</label>
                        <div class="col-sm-8">
                            <select class="form-select form-control focus-ring focus-ring-secondary" name="product_category" id="product_category" required>

                                <!--template for category-->
                                <?php foreach($category as $ctg): ?>
                                <option value="<?= $ctg["category_id"] ?>" <?php if($pdt["product_category"] === $ctg["category_id"]) echo "selected"; ?>><?= $ctg["category_name"] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Deskripsi:</label>
                        <div class="col-sm-8">
                            <textarea class="form-control focus-ring focus-ring-secondary" rows="3"  name="product_desc" id="product_desc" value="" required><?= $pdt["product_desc"] ?></textarea>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Stok:</label>
                        <div class="col-sm-8">
                            <input type="number" class="focus-ring focus-ring-secondary form-control" name="product_stock" id="product_stock" value="<?= $pdt["product_stock"] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start">Harga:</label>
                        <div class="col-sm-8 input-group w-auto">
                            <span class="input-group-text" id="rupiah">Rp.</span>
                            <input type="number" class="focus-ring focus-ring-secondary form-control" aria-describedby="rupiah" name="product_price" id="product_price" value="<?= $pdt["product_price"] ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary" name="edit_product">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!--x-->

<!--DELETE PRODUCT MODAL-->
<?php foreach($products as $pdt): ?>
<div class="modal fade" id="delete-product-modal-<?= $pdt["product_id"] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Hapus Produk #<?= $pdt["product_id"] ?></b></p>
            </div>
            <div class="modal-body">
                Apakah kamu yakin akan menghapus produk ini?
            </div>
            <div class="modal-footer py-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-light" data-bs-target="#delete-product-modal2-<?= $pdt["product_id"] ?>" data-bs-toggle="modal">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-product-modal2-<?= $pdt["product_id"] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                Tekan tombol <b>hapus</b> untuk menghapus produk #<?= $pdt["product_id"] ?>.
            </div>
            <div class="modal-footer py-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="delete-data.php?product_id=<?= $pdt["product_id"] ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!--x-->