<?php
$this->extend('layout/app');
$this->section('content');
?>


<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Riwayat Peminjaman Buku</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Buku</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/books/all">Data Riwayat Peminjaman
                    Buku</a></li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Pinjaman Buku</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>ISBN</th>
                                <th>Judul Buku</th>
                                <th>Kategori Buku</th>
                                <th>Status</th>
                                <th>Detail Data Peminjam</th>
                                <th>Dipinjam Pada</th>
                                <th>Dikembalikan Pada</th>
                                <th>Dikonfirmasi Pada</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>ISBN</th>
                                <th>Judul Buku</th>
                                <th>Kategori Buku</th>
                                <th>Status</th>
                                <th>Detail Data Peminjam</th>
                                <th>Dipinjam Pada</th>
                                <th>Dikembalikan Pada</th>
                                <th>Dikonfirmasi Pada</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $i = 1;
                            foreach ($pinjaman as $p) : ?>
                                <tr>
                                    <td><?= esc($i); ?></td>
                                    <td><?= esc($p->book_isbn); ?></td>
                                    <td><?= esc($p->title); ?></td>
                                    <td><?= esc($p->category); ?></td>
                                    <td>
                                        <?php if ($p->status === '0') {
                                            $statusBadge = 'danger';
                                            $messageStatus = 'Masih dipinjam';
                                        } else if ($p->status === '1') {
                                            $statusBadge = 'success';
                                            $messageStatus = 'Telah dikembalikan';
                                        } else {
                                            $statusBadge = 'warning';
                                            $messageStatus = 'Menunggu konfirmasi admin';
                                        }
                                        ?>
                                        <span class="badge badge-<?= esc($statusBadge) ?>">
                                            <?= $messageStatus ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalDetailUser" id="modalDetailUserBtn">
                                                Lihat
                                            </button>
                                        </div>
                                        <?php include(__DIR__ . '/../modal_detail_user.php'); ?>
                                    </td>
                                    <td><?= $p->dipinjam_pada ?></td>
                                    <td><?= $p->dikembalikan_pada ?? '-----' ?></td>
                                    <td><?= $p->dikonfirmasi_pada ?? '-----' ?></td>
                                </tr>
                            <?php $i++;
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
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 6, 7, 8],
                    },
                    title: "Daftar Riwayat Pinjaman Buku UNSRI",
                    className: 'btn btn-info btn-sm mr-2',
                    download: 'open',
                    pageSize: 'A4',
                    messageTop: 'Daftar Riwayat Pinjaman Buku',
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 6, 7, 8],
                    },
                    title: "Daftar Riwayat Pinjaman Buku UNSRI",
                    className: 'btn btn-info btn-sm mr-2',
                    sheetName: 'Daftar Riwayat Pinjaman Buku',
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