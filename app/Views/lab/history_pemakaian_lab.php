<?php
$this->extend('layout/app');
$this->section('content');
?>


<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Pemakaian Lab <?= session('user')['name'] ?></h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Lab</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/labs/history">Riwayat Pemakaian Lab</a></li>
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

    <!-- Row -->
    <div class="row">
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Pemakaian Lab</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Lab</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Lab</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Detail</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($pinjaman as $lab) : ?>
                                <tr>
                                    <td><?= esc($i); ?></td>
                                    <td><?= $lab->name ?></td>
                                    <td><?= $lab->faculty ?></td>
                                    <td><?= $lab->major ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetail<?= esc($i); ?>" id="#modalDetailButton">Detail
                                            </button>
                                        </div>
                                        <?php $title = "Riwayat Pemakaian Lab";
                                        include('modal_jadwal.php'); ?>
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
<link href="/vendor/datatables/responsive.dataTables.min.css" rel="stylesheet">

<?php
$this->endSection();
$this->section('script');

?>

<!-- Page level plugins -->
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/vendor/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/jszip.min.js"></script>
<script src="/vendor/datatables/pdfmake.min.js"></script>
<script src="/vendor/datatables/vfs_fonts.js"></script>
<script src="/vendor/datatables/buttons.html5.min.js"></script>
<!-- Page level custom scripts -->
<script>
    $(document).ready(function() {
        $('#dataTableHover').DataTable({
            columns: [{
                    width: "3%"
                },
                null,
                null,
                null,
                null,
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                    className: 'btn btn-info btn-sm mr-2',
                    title: "Riawat Pemakaian Lab <?= session('user')['name'] ?>",
                    download: 'open',
                    pageSize: 'A4',
                    messageTop: 'Riwayat Pemakaian Lab',
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3],
                    },
                    title: "Riawat Pemakaian Lab <?= session('user')['name'] ?>",
                    className: 'btn btn-info btn-sm mr-2',
                    sheetName: 'Riwayat Pemakaian Lab',
                }
            ],
        }); // ID From dataTable with Hover
        $('a.nav-link.collapsed').on('click', function(e) {
            e.preventDefault();
        });
    });
</script>

<?php
$this->endSection();
?>