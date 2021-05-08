<?php
$this->extend('layout/app');
$this->section('content');

if ($validator = session()->getFlashdata('validator')) {
}

?>

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Admin</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/users/add-admin">Tambah Admin</a>
            </li>
        </ol>
    </div>

    <?php if ($msg = session()->getFlashdata('msg')) : ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <?php if ($success = session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <?= $success ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col">
            <div class="card px-3 py-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Menambahkan Admin</h6>
                </div>
                <div class="card-body">
                    <form action="/users/admin" method="POST">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="form-group">
                            <label for="nim">No. Identitas / NIK / NIP</label>
                            <input type="number" class="form-control <?= isset($validator) && $validator->hasError('nim') ? esc('is-invalid') : '' ?>" id="nim" aria-describedby="emailHelp" placeholder="Masukkan No. Identitas" name="nim">
                            <?php if (isset($validator) && $validator->hasError('nim')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validator->getError('nim') ?>
                                </div>
                            <?php endif; ?>
                            <small id="nimHelp" class="form-text text-warning">No. Identitas tidak bisa diubah, harap pastikan anda memasukkannya dengan benar</small>
                        </div>

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control <?= isset($validator) && $validator->hasError('name') ? esc('is-invalid') : '' ?>" id="name" aria-describedby="emailHelp" placeholder="Masukkan Nama" name="name">
                            <?php if (isset($validator) && $validator->hasError('name')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validator->getError('name') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control <?= isset($validator) && $validator->hasError('email') ? esc('is-invalid') : '' ?>" id="email" aria-describedby="emailHelp" placeholder="Masukkan Email" name="email">
                            <?php if (isset($validator) && $validator->hasError('email')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validator->getError('email') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control <?= isset($validator) && $validator->hasError('password') ? esc('is-invalid') : '' ?>" id="password" aria-describedby="emailHelp" placeholder="Masukkan Password" name="password">
                            <?php if (isset($validator) && $validator->hasError('password')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validator->getError('password') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">Konfirmasi Password</label>
                            <input type="password" class="form-control <?= isset($validator) && $validator->hasError('password_confirm') ? esc('is-invalid') : '' ?>" id="password_confirm" aria-describedby="emailHelp" placeholder="Masukkan Kembali Password Anda" name="password_confirm">
                            <?php if (isset($validator) && $validator->hasError('password_confirm')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validator->getError('password_confirm') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <input type="text" class="form-control <?= isset($validator) && $validator->hasError('address') ? esc('is-invalid') : '' ?>" id="address" aria-describedby="alamat" placeholder="Masukkan Alamat" name="address">
                            <?php if (isset($validator) && $validator->hasError('address')) : ?>
                                <div class="invalid-feedback">
                                    <?= $validator->getError('address') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="gender">Jenis Kelamin</label>
                            <select class="form-control" name="gender" id="gender">
                                <option value="" selected>Pilih Jenis Kelamin</option>
                                <option value="0">Perempuan</option>
                                <option value="1">Laki-laki</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!---Container Fluid-->

<?php

$this->endSection();
$this->section('css');

?>

<?php
$this->endSection();
$this->section('script');

?>

<!-- Page level custom scripts -->
<script>
    $(document).ready(function() {

    });
</script>

<?php
$this->endSection();
?>