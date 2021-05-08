<?php
$this->extend('layout/app');
$this->section('content');

if ($validator = session()->getFlashdata('validator')) {
}

?>

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Menambahkan Lab Baru</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item">Lab</li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/labs/create-labs">Tambahkan Lab
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
                        <h6 class="m-0 font-weight-bold text-primary">Menambahkan Lab Baru</h6>
                    </div>
                    <div class="card-body">
                        <form action="/labs" method="POST">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                            <div class="form-group">
                                <label for="name">Nama Laboratorium</label>
                                <input type="text"
                                       class="form-control <?= isset($validator) && $validator->hasError('name') ? esc('is-invalid') : '' ?>"
                                       id="name" aria-describedby="emailHelp" placeholder="Masukkan Nama Laboratorium"
                                       name="name">
                                <?php if (isset($validator) && $validator->hasError('name')) : ?>
                                    <div class="invalid-feedback">
                                        <?= $validator->getError('name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="faculty">Fakultas</label>
                                <?php if (isset($validator) && $validator->hasError('faculty_id')) : ?>
                                    <select class="faculty-form form-control is-invalid" name="faculty_id" id="faculty">
                                        <option value="">Pilih Fakultas</option>
                                        <?php foreach ($faculties as $faculty) : ?>
                                            <option value="<?= esc($faculty->id) ?>"><?= esc($faculty->faculty) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= $validator->getError('faculty_id') ?>
                                    </div>
                                <?php else : ?>
                                    <select class="faculty-form form-control" name="faculty_id" id="faculty">
                                        <option value="">Pilih Fakultas</option>
                                        <?php foreach ($faculties as $faculty) : ?>
                                            <option value="<?= esc($faculty->id) ?>"><?= esc($faculty->faculty) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="major">Jurusan</label>
                                <?php if (isset($validator) && $validator->hasError('major_id')) : ?>
                                    <select class="major-form form-control is-invalid" name="major_id" id="major">
                                        <option value="">Pilih Jurusan</option>
                                    </select>
                                    <small id="emailHelp" class="form-text text-muted">Pilih Fakultas terlebih dahulu
                                        sebelum memilih jurusan</small>
                                    <div class="invalid-feedback">
                                        <?= $validator->getError('major_id') ?>
                                    </div>
                                <?php else : ?>
                                    <select class="major-form form-control" name="major_id" id="major">
                                        <option value="">Pilih Jurusan</option>
                                    </select>
                                    <small id="emailHelp" class="form-text text-muted">Pilih Fakultas terlebih dahulu
                                        sebelum memilih jurusan</small>

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

            let majors = <?= json_encode($majors) ?>;
            $('.faculty-form').on('change', function (e) {
                let facultyId = e.target.value;
                let majorsData = majors.filter((m) => m.faculty_id == facultyId);
                let majorSelectElement = document.getElementById('major');
                // Delete all child
                while (majorSelectElement.firstChild) {
                    majorSelectElement.firstChild.remove();
                }
                // Default value
                let temp = document.createElement('option');
                temp.value = "null";
                temp.innerHTML = "Tidak ada jurusan";
                temp.setAttribute('selected', '');
                majorSelectElement.appendChild(temp);


                majorsData.forEach((m) => {
                    let temp = document.createElement('option');
                    temp.value = m.id;
                    temp.innerHTML = m.major;
                    majorSelectElement.appendChild(temp);
                });
            });

        });
    </script>

<?php
$this->endSection();
?>