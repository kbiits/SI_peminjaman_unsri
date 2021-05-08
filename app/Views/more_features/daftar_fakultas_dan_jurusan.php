<?php
$this->extend('layout/app');
$this->section('content');

?>

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Fakultas dan Jurusan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/faculties-majors">Daftar Fakultas dan
                    Jurusan</a></li>
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

    <?php if ($errors = session()->getFlashdata('validation')) : ?>
        <?php foreach ($errors as $e) : ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?= $e ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Row -->
    <div class="row">
        <!-- Simple Table -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Fakultas</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Fakultas</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach ($faculties as $faculty) : ?>
                            <tr>
                                <td><?= esc($i++); ?></td>
                                <td><?= esc($faculty->faculty); ?></td>
                                <td>
                                    <a href="javascipt:void(0);" class="btn btn-sm btn-warning"
                                       data-toggle="modal"
                                       data-target="#modalEditFaculty<?= esc($i); ?>"
                                    >
                                        Edit
                                    </a>

                                    <?php include('modal_edit_faculty.php'); ?>

                                    <a href=" javascipt:void(0);" class="btn btn-sm btn-danger"
                                       data-toggle="modal"
                                       data-target="#modalDeleteFaculty<?= esc($i); ?>"
                                    >
                                        Hapus
                                    </a>

                                    <form id="form-delete-faculty-<?= $i; ?>" action="/faculties/<?= $faculty->id ?>"
                                          method="POST">
                                        <input type="hidden" name="<?= csrf_token() ?>"
                                               value="<?= csrf_hash() ?>"/>
                                        <input type="hidden" name="_method" value="DELETE"/>
                                    </form>

                                    <!-- Modal Delete -->
                                    <div class="modal fade" id="modalDeleteFaculty<?= $i; ?>" tabindex="-1"
                                         role="dialog" aria-labelledby="exModalDelete"
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exModalDelete">Ohh Tidak!</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apa kamu yakin ingin menghapus data tersebut ?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-primary"
                                                            data-dismiss="modal">Cancel
                                                    </button>
                                                    <a href="javascript:void(0);"
                                                       onclick="(e) => e.preventDefault(); document.getElementById('form-delete-faculty-<?= esc($i); ?>').submit();"
                                                       class="btn btn-primary">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->

    <!-- Row -->
    <div class="row">
        <!-- Simple Table -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Jurusan</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="table-jurusan">
                        <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Jurusan</th>
                            <th>Fakultas</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach ($majors as $major) : ?>
                            <tr>
                                <td><?= esc($i++); ?></td>
                                <td><?= esc($major->major); ?></td>
                                <td><?= esc($major->faculty); ?></td>
                                <td>
                                    <a href="javascipt:void(0);" class="btn btn-sm btn-warning"
                                       data-toggle="modal"
                                       data-target="#modalEditMajor<?= esc($i); ?>"
                                    >
                                        Edit
                                    </a>

                                    <?php include('modal_edit_major.php'); ?>

                                    <a href="javascipt:void(0);" class="btn btn-sm btn-danger"
                                       data-toggle="modal"
                                       data-target="#modalDelete<?= esc($i); ?>"
                                    >
                                        Hapus
                                    </a>

                                    <form id="form-delete-<?= $i; ?>" action="/majors/<?= $major->id ?>"
                                          method="POST">
                                        <input type="hidden" name="<?= csrf_token() ?>"
                                               value="<?= csrf_hash() ?>"/>
                                        <input type="hidden" name="_method" value="DELETE"/>
                                    </form>

                                    <?php include __DIR__ . '/../modal_delete.php' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->

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
