<?php
require '../function.php';
$input_search_orders = $_GET['inputSearchOrders'];
$orderss = query("SELECT *, U.user_email AS odruser FROM orders O JOIN user U ON O.order_user = U.user_id WHERE order_id LIKE '%$input_search_orders%' OR U.user_email LIKE '%$input_search_orders%'");
?>
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

        <!--template row orders table-->
        <?php foreach($orderss as $odr): ?>
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
<?php foreach($orderss as $odr):?>
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
<?php foreach($orderss as $odr):?>
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
                        $order_items = query("SELECT *, P.product_name AS pdtname FROM order_item O JOIN product P ON O.product_id = P.product_id WHERE order_id = '" . $odr['order_id'] . "'");
                        foreach($order_items as $odri): ?>
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
<?php foreach($orderss as $odr):?>
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
<?php foreach($orderss as $odr):?>
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
<?php foreach($orderss as $odr):?>
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