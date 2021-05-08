<?php
$this->extend('layout/app');
$this->section('content');

if ($validator = session()->getFlashdata('validator')) {
}

?>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Fakultas atau Jurusan</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/add-faculty-major">Tambah Fakultas atau Jurusan</a>
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
                        <h6 class="m-0 font-weight-bold text-primary">Menambahkan Fakultas</h6>
                    </div>
                    <div class="card-body">
                        <div id="form-add-faculty">
                            <form action="/faculties" method="POST">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                                <div class="form-group">
                                    <label for="faculty">Nama Fakultas</label>
                                    <input type="text"
                                           class="form-control <?= isset($validator) && $validator->hasError('faculty') ? esc('is-invalid') : '' ?>"
                                           id="faculty" aria-describedby="emailHelp"
                                           placeholder="Masukkan Nama Fakultas"
                                           name="faculty">
                                    <?php if (isset($validator) && $validator->hasError('faculty')) : ?>
                                        <div class="invalid-feedback">
                                            <?= $validator->getError('faculty') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Tambahkan Fakultas</button>
                            </form>
                        </div>
                    </div>
                    <hr class="sidebar-divider"/>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Menambahkan Jurusan</h6>
                    </div>
                    <div class="card-body">
                        <div id="form-add-major">
                            <form action="/majors" method="POST">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                                <div class="form-group">
                                    <label for="major">Nama Jurusan</label>
                                    <input type="text"
                                           class="form-control <?= isset($validator) && $validator->hasError('major') ? esc('is-invalid') : '' ?>"
                                           id="major" aria-describedby="emailHelp" placeholder="Masukkan Nama Jurusan"
                                           name="major">
                                    <?php if (isset($validator) && $validator->hasError('major')) : ?>
                                        <div class="invalid-feedback">
                                            <?= $validator->getError('major') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="faculty_id">Fakultas</label>
                                    <select
                                            class="form-control <?= isset($validator) && $validator->hasError('faculty_id') ? esc('is-invalid') : '' ?>"
                                            id="faculty_id" aria-describedby="emailHelp"
                                            name="faculty_id">
                                        <option value="">Pilih Fakultas</option>
                                        <?php foreach ($faculties as $faculty) : ?>
                                            <option value="<?= esc($faculty->id); ?>"><?= esc($faculty->faculty); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if (isset($validator) && $validator->hasError('faculty_id')) : ?>
                                        <div class="invalid-feedback">
                                            <?= $validator->getError('faculty_id') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Tambahkan Jurusan</button>
                            </form>
                        </div>
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