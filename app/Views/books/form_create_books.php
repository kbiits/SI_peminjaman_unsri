<?php
$this->extend('layout/app');
$this->section('content');

if ($validator = session()->getFlashdata('validator')) {
}

?>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Menambahkan Buku Baru</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item">Alat</li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/books/create-books">Tambahkan Buku
                        Baru</a>
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
                        <h6 class="m-0 font-weight-bold text-primary">Menambahkan Buku Baru</h6>
                    </div>
                    <div class="card-body">
                        <form action="/books" method="POST">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                            <div class="form-group">
                                <label for="isbn">ISBN</label>
                                <input type="text"
                                       class="form-control <?= isset($validator) && $validator->hasError('isbn') ? esc('is-invalid') : '' ?>"
                                       id="isbn" aria-describedby="emailHelp" placeholder="Masukkan ISBN Buku"
                                       name="isbn">
                                <?php if (isset($validator) && $validator->hasError('isbn')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validator->getError('isbn') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="title">Judul Buku</label>
                                <input type="text"
                                       class="form-control <?= isset($validator) && $validator->hasError('title') ? esc('is-invalid') : '' ?>"
                                       id="title" aria-describedby="emailHelp" placeholder="Masukkan Nama Buku"
                                       name="title">
                                <?php if (isset($validator) && $validator->hasError('title')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validator->getError('title') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="category">Kategori Buku</label>
                                <input type="text"
                                       class="form-control <?= isset($validator) && $validator->hasError('category') ? esc('is-invalid') : '' ?>"
                                       id="category" aria-describedby="emailHelp" placeholder="Masukkan Kategori Buku"
                                       name="category">
                                <?php if (isset($validator) && $validator->hasError('category')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validator->getError('category') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="stock">Stok Buku</label>
                                <input type="number"
                                       class="form-control <?= isset($validator) && $validator->hasError('stock') ? esc('is-invalid') : '' ?>"
                                       id="stock" aria-describedby="stock" placeholder="Masukkan Banyak Stok Buku"
                                       name="stock">
                                <?php if (isset($validator) && $validator->hasError('stock')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validator->getError('stock') ?>
                                    </div>
                                <?php endif; ?>
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
        $(document).ready(function () {

        });
    </script>

<?php
$this->endSection();
?>