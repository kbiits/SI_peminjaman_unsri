<?php
$this->extend('layout/app');
$this->section('content');

$user_role = session('user')['role'];

?>

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Buku</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Buku</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/books">Daftar Buku</a></li>
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
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Buku</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>ISBN</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>ISBN</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php $i = 1;
                        foreach ($books as $book) : ?>
                            <tr>
                                <td><?= esc($i) ?></td>
                                <td><?= $book->isbn ?></td>
                                <td><?= $book->title ?></td>
                                <td><?= $book->category ?></td>
                                <td><?= $book->stock ?> </td>
                                <td>
                                    <span class="badge badge-<?= $book->stock <= 0 ? 'danger' : 'success' ?>">
                                    <?= $book->getStatusString() ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($user_role === '0') : ?>
                                        <a href="/books/<?= $book->isbn ?>/pinjam">
                                            <button type="button"
                                                    class="btn btn-sm btn-info" <?= $book->stock <= 0 ? 'disabled' : '' ?>>
                                                Pinjam
                                            </button>
                                        </a>
                                    <?php else : ?>
                                        <!-- Modal Edit -->
                                        <?php include('modal_edit_books.php') ?>
                                        <div class="btn-group mr-2 mb-2 mb-md-0">
                                            <button type="button" class="btn btn-sm btn-warning modalEditBtn"
                                                    data-toggle="modal"
                                                    data-target="#modalEdit<?= esc($i); ?>"
                                                    id="modalEditButton">
                                                Edit
                                            </button>
                                        </div>
                                        <!-- Modal Edit -->

                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-danger" href="javascript:void(0);"
                                               data-toggle="modal"
                                               data-target="#modalDelete<?= $i; ?>">
                                                Hapus
                                            </a>
                                        </div>

                                        <form id="form-delete-<?= $i; ?>" action="/books/<?= $book->isbn ?>"
                                              method="POST">
                                            <input type="hidden" name="<?= csrf_token() ?>"
                                                   value="<?= csrf_hash() ?>"/>
                                            <input type="hidden" name="_method" value="DELETE"/>
                                        </form>

                                        <?php include __DIR__ . '/../modal_delete.php' ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $i++ ?>
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
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/vendor/datatables/responsive.dataTables.min.css" rel="stylesheet">

<?php
$this->endSection();
$this->section('script');

?>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/vendor/datatables/dataTables.responsive.min.js"></script>
<script src="/vendor/datatables/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/jszip.min.js"></script>
<script src="/vendor/datatables/pdfmake.min.js"></script>
<script src="/vendor/datatables/vfs_fonts.js"></script>
<script src="/vendor/datatables/buttons.html5.min.js"></script>

<!-- Page level custom scripts -->
<script>
    $(document).ready(function () {

        let table = $('#dataTableHover').DataTable({
            columns: [
                {width: "3%"},
                null,
                null,
                null,
                null,
                null,
                null,
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                    title: "Daftar Buku UNSRI",
                    className: 'btn btn-info btn-sm mr-2',
                    download: 'open',
                    pageSize: 'A4',
                    messageTop: 'Daftar Buku',
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                    title: "Daftar Buku UNSRI",
                    className: 'btn btn-info btn-sm mr-2',
                    sheetName: 'Daftar Buku',
                }
            ],
        }); // ID From dataTable with Hover
    });
</script>

<?php
$this->endSection();
?>
