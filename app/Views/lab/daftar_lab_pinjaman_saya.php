<?php
$this->extend('layout/app');
$this->section('content');
?>


<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pinjaman Lab <?= session('user')['name'] ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Lab</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/labs/show">Pinjaman Lab Saya</a></li>
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

    <?php if ($warning = session()->getFlashdata('warning')) : ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <?= $warning ?>
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
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Pinjaman Lab</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Lab</th>
                            <th>Fakultas</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama Lab</th>
                            <th>Fakultas</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Aksi</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        $i = 1;
                        foreach ($pinjaman as $lab) : ?>
                            <?php
                            $lab->jam_masuk = date('H:i', strtotime($lab->jam_masuk));
                            $lab->jam_keluar = date('H:i', strtotime($lab->jam_keluar));
                            ?>
                            <tr>
                                <td><?= esc($i); ?></td>
                                <td><?= $lab->name ?></td>
                                <td><?= $lab->faculty ?></td>
                                <td><?= $lab->major ?></td>
                                <td>
                                    <?php if ($lab->jam_keluar > date('H:i')) {
                                        $statusBadge = 'danger';
                                        $messageStatus = 'Masih dalam reservasi';
                                    } else {
                                        $statusBadge = 'success';
                                        $messageStatus = 'Telah selesai';
                                    }
                                    ?>
                                    <span class="badge badge-<?= esc($statusBadge) ?>">
                                        <?= $messageStatus ?>
                                    </span>
                                </td>
                                <td><?= esc($lab->tanggal); ?></td>
                                <td><?= esc($lab->jam_masuk); ?></td>
                                <td><?= esc($lab->jam_keluar); ?></td>
                                <td>
                                    <div class="btn-group mb-2 mb-md-0">
                                        <button type="button" class="btn btn-warning" data-toggle="modal"
                                                data-target="#modalEditPinjaman<?= esc($i); ?>"
                                                id="#modalEditPinjamanBtn">Edit
                                        </button>
                                    </div>
                                    <?php include('modal_edit_pinjaman_lab.php') ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#modalDelete"
                                                id="#modalDeleteBtn">Hapus
                                        </button>
                                    </div>
                                    <form action="/labs/<?= $lab->jadwal_id ?>/pinjam" method="POST" id="form-delete-<?= esc($i); ?>">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                                        <input type="hidden" name="_method" value="DELETE"/>
                                    </form>
                                    <!-- Modal Delete -->
                                    <?php include(__DIR__ . '/../modal_delete.php'); ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        endforeach; ?>
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
<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Bootstrap DatePicker -->
<link href="/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
<!-- ClockPicker -->
<link href="/vendor/clock-picker/clockpicker.css" rel="stylesheet">

<?php
$this->endSection();
$this->section('script');

?>

<!-- Page level plugins -->
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<!-- ClockPicker -->
<script src="/vendor/clock-picker/clockpicker.js"></script>
<!-- Bootstrap Datepicker -->
<script src="/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>


<!-- Page level custom scripts -->
<script>
    $(document).ready(function () {
        $('#dataTableHover').DataTable({
            columns: [
                {width: "3%"},
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ],
        }); // ID From dataTable with Hover
        $('a.nav-link.collapsed').on('click', function (e) {
            e.preventDefault();
        });

        // Bootstrap Date Picker
        $('#simple-date1 .input-group.date').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: 'linked',
            todayHighlight: true,
            autoclose: true,
        });

        let input1 = $('.clockPicker3').clockpicker({
            autoclose: true,
            'default': 'now',
            placement: 'bottom',
            align: 'left',
            min: '08:00',
            max: '17:00',
        });
        let input2 = $('.clockPicker4').clockpicker({
            autoclose: true,
            'default': 'now',
            placement: 'bottom',
            align: 'left',
            min: '08:00',
            max: '17:00',
        });

        $('.check-minutes1').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            input1.clockpicker('show').clockpicker('toggleView', 'minutes');
        });

        $('.check-minutes2').click(function (e) {
            e.stopPropagation();
            e.preventDefault();
            input2.clockpicker('show').clockpicker('toggleView', 'minutes');
        });

        $("#btn-submit-form-edit-pinjaman").click(function () {
            $("#form-edit-pinjaman").submit();
        });
    });
</script>

<?php
$this->endSection();
?>

