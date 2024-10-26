<?php
require '../function.php';
$input_search_user = $_GET['inputSearchUser'];
$users = query("SELECT * FROM user WHERE user_id LIKE '%$input_search_user%' OR user_name LIKE '%$input_search_user%' OR user_email LIKE '%$input_search_user%'");
?>
<table class="table table-striped mb-auto" id="admin-table-editable">
    <thead class="text-center">
        <tr>
            <th scope="col">User ID</th>
            <th scope="col">Nama</th>
            <th scope="col">Email</th>
            <th scope="col">Tanggal Lahir</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Nomor Telepon</th>
            <th scope="col">Role</th>
            <th scope="col" colspan="3">Aksi</th>
        </tr>
    </thead>
    <tbody class="table-group-divider align-middle text-center">

        <!--Template for user table row-->
        <?php foreach($users as $usr): ?>
        <tr>
            <td>#<?= $usr["user_id"] ?></td>
            <td class="text-start"><?= $usr["user_name"] ?></td>
            <td class="text-start"><?= $usr["user_email"] ?></td>
            <td><?= $usr["user_birthday"] ?></td>
            <td><?= $usr["user_gender"] ?></td>
            <td class="text-start"><?= $usr["user_phone"] ?></td>
            <td><?= $usr["user_role"] ?></td>
            <td>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#user-modal-<?= $usr["user_id"] ?>">
                    Lihat
                </button>
            </td>
            <td>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit-user-modal-<?= $usr["user_id"] ?>">
                    <i class="fa-solid fa-pen-to-square" style="color: #fdfffd;"></i>
                </button>
            </td>
            <td>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-user-modal-<?= $usr["user_id"] ?>">
                    <i class="fa-solid fa-trash-can" style="color: #fdfffd;"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>

<!--USER MODAL-->
<?php foreach($users as $usr): ?>
<div class="modal fade" id="user-modal-<?= $usr["user_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Detail Pengguna #<?= $usr["user_id"] ?></b></p>
            </div>
            <div class="modal-body">
                <form class="" action="" id="">
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Nama:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" readonly value="<?= $usr["user_name"] ?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Email:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" readonly value="<?= $usr["user_email"] ?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Tanggal Lahir:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" readonly value="<?= $usr["user_birthday"] ?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Jenis Kelamin:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" readonly value="<?= $usr["user_gender"] ?>">
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start">Nomor Telepon:</label>
                        <div class="col-sm-9">
                            <input type="number" class="focus-ring focus-ring-secondary form-control" readonly value="<?= $usr["user_phone"] ?>">
                        </div>
                    </div> 
                    <div class="row">
                        <label class="col-sm-3 col-form-label text-sm-start">Role:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" readonly value="<?= $usr["user_role"] ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!--x-->

<!--CREATE USER MODAL-->
<div class="modal fade" id="create-user-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Tambah Pengguna</b></p>
            </div>
            <div class="modal-body">
                <form class="" action="" method="post" id="">
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start" for="user_name">Nama:</label>
                        <div class="col-sm-8">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" name="user_name" id="user_name" placeholder="Nama" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start" for="user_email">Email:</label>
                        <div class="col-sm-8">
                            <input type="email" class="focus-ring focus-ring-secondary form-control" name="user_email" id="user_email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start" for="user_birthday">Tanggal Lahir:</label>
                        <div class="col-sm-8">
                            <input type="date" class="focus-ring focus-ring-secondary form-control" name="user_birthday" id="user_birthday" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start" for="user_gender">Jenis Kelamin:</label>
                        <div class="col-sm-8">
                            <select class="form-select form-control focus-ring focus-ring-secondary" name="user_gender" id="user_gender" required>
                                <option value="" selected disabled hidden>Jenis Kelamin</option>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start" for="user_phone">Nomor Telepon:</label>
                        <div class="col-sm-8">
                            <input type="number" class="focus-ring focus-ring-secondary form-control" name="user_phone" id="user_phone" placeholder="Nomor Telepon" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-4 col-form-label text-sm-start" for="user_password">Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="focus-ring focus-ring-secondary form-control" name="user_password" id="user_password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label text-sm-start" for="user_role">Role:</label>
                        <div class="col-sm-8">
                            <select class="form-select form-control focus-ring focus-ring-secondary" name="user_role" id="user_role" required>
                                <option value="" selected disabled hidden>Role</option>
                                <option value="Buyer">Buyer</option>
                                <option value="Seller">Seller</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" name="create_user">Tambahkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--x-->

<!--EDIT USER MODAL-->
<?php foreach($users as $usr): ?>
<div class="modal fade" id="edit-user-modal-<?= $usr["user_id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Edit Pengguna #<?= $usr["user_id"] ?></b></p>
            </div>
            <div class="modal-body">
                <form class="" action="" method="post" id="">
                    <input type="hidden" name="user_id" value="<?= $usr["user_id"] ?>">
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start" for="user_name">Nama:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" name="user_name" id="user_name" value="<?= $usr["user_name"] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start" for="user_email">Email:</label>
                        <div class="col-sm-9">
                            <input type="text" class="focus-ring focus-ring-secondary form-control" name="user_email" id="user_email" value="<?= $usr["user_email"] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start" for="user_birthday">Tanggal Lahir:</label>
                        <div class="col-sm-9">
                            <input type="date" class="focus-ring focus-ring-secondary form-control" name="user_birthday" id="user_birthday" value="<?= $usr["user_birthday"] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start" for="user_gender">Jenis Kelamin:</label>
                        <div class="col-sm-9">
                            <select class="form-select form-control focus-ring focus-ring-secondary" name="user_gender" id="user_gender" required>
                            <option value="" selected disabled hidden>Jenis Kelamin</option>
                                <option value="Pria" <?php if($usr["user_gender"] === "Pria") echo "selected"; ?>>Pria</option>
                                <option value="Wanita" <?php if($usr["user_gender"] === "Wanita") echo "selected"; ?>>Wanita</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start" for="user_phone">Nomor Telepon:</label>
                        <div class="col-sm-9">
                            <input type="number" class="focus-ring focus-ring-secondary form-control" name="user_phone" id="user_phone" value="<?= $usr["user_phone"] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-sm-2 mb-md-4">
                        <label class="col-sm-3 col-form-label text-sm-start" for="user_password">Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="focus-ring focus-ring-secondary form-control" name="user_password" id="user_password">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label text-sm-start" for="user_role">Role:</label>
                        <div class="col-sm-9">
                            <select class="form-select form-control focus-ring focus-ring-secondary" name="user_role" id="user_role" required>
                                <option value="" selected disabled hidden>Role</option>
                                <option value="Buyer" <?php if($usr["user_role"] === "Buyer") echo "selected"; ?>>Buyer</option>
                                <option value="Seller" <?php if($usr["user_role"] === "Seller") echo "selected"; ?>>Seller</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary" name="edit_user">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!--x-->

<!--DELETE USER MODAL-->
<?php foreach($users as $usr): ?>
<div class="modal fade" id="delete-user-modal-<?= $usr["user_id"] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <p class="h3 mb-0"><b>Hapus Pengguna #<?= $usr["user_id"] ?></b></p>
            </div>
            <div class="modal-body">
                Apakah kamu yakin akan menghapus pengguna ini?
            </div>
            <div class="modal-footer py-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-light" data-bs-target="#delete-user-modal2-<?= $usr["user_id"] ?>" data-bs-toggle="modal">Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete-user-modal2-<?= $usr["user_id"] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                Tekan tombol <b>hapus</b> untuk menghapus pengguna #<?= $usr["user_id"] ?>.
            </div>
            <div class="modal-footer py-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="delete-data.php?user_id=<?= $usr["user_id"] ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!--x-->