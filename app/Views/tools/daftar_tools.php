<?php
$this->extend('layout/app');
$this->section('content');

$user_role = session('user')['role'];

?>

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Alat</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Alat</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/tools">Daftar Alat</a></li>
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
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Alat</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Alat</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Alat</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Pinjam</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $i = 1;
                            foreach ($tools as $tool) : ?>
                                <tr>
                                    <td><?= esc($i); ?></td>
                                    <td><?= $tool->name ?></td>
                                    <td><?= $tool->faculty ?></td>
                                    <td><?= $tool->major ?? '-' ?> </td>
                                    <td><?= esc($tool->stock); ?> </td>
                                    <td>
                                        <span class="badge badge-<?= $tool->stock <= 0 ? 'danger' : 'success' ?>">
                                            <?= $tool->getStatusString() ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($user_role === '0') : ?>
                                            <a href="/tools/<?= $tool->id ?>/pinjam">
                                                <button type="button" class="btn btn-sm btn-info" <?= $tool->stock <= 0 ? 'disabled' : '' ?>>
                                                    Pinjam
                                                </button>
                                            </a>
                                        <?php else : ?>
                                            <!-- Modal Edit -->
                                            <?php include('modal_edit_tools.php') ?>
                                            <div class="btn-group mr-2 mb-2 mb-md-0">
                                                <button type="button" class="btn btn-sm btn-warning modalEditBtn" data-toggle="modal" data-target="#modalEdit<?= esc($i); ?>" id="modalEditButton">
                                                    Edit
                                                </button>
                                            </div>
                                            <!-- Modal Edit -->

                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-danger" href="javascript:void(0);" data-toggle="modal" data-target="#modalDelete<?= $i; ?>">
                                                    Hapus
                                                </a>
                                            </div>

                                            <form id="form-delete-<?= $i; ?>" action="tools/<?= $tool->id ?>" method="POST">
                                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                                <input type="hidden" name="_method" value="DELETE" />
                                            </form>

                                            <?php include __DIR__ . '/../modal_delete.php' ?>

                                        <?php endif; ?>
                                    </td>
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
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="/vendor/datatables/responsive.dataTables.min.css" rel="stylesheet">

<?php
$this->endSection();
$this->section('script');

?>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
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
                    width: '3%'
                },
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
                    title: "Daftar Alat UNSRI",
                    className: 'btn btn-info btn-sm mr-2',
                    download: 'open',
                    pageSize: 'A4',
                    messageTop: 'Daftar Alat',
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                    },
                    title: "Daftar Alat UNSRI",
                    className: 'btn btn-info btn-sm mr-2',
                    sheetName: 'Daftar Alat',
                }
            ],
        }); // ID From dataTable with Hover

        let majors = <?= json_encode($majors) ?>;
        $('.faculty-form').on('change', function(e) {
            let facultyId = e.target.value;
            let majorsData = majors.filter((m) => m.faculty_id == facultyId);
            // Get target faculty form, and find the parent which is form group and find next siblings to find major select element
            let majorSelectElement = e.target.parentElement.nextElementSibling.children[1];

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


        let changeEvent = new Event('change');
        let facultyForms = $('.faculty-form');
        let majorForms = $('.major-form');

        <?php $idx = 0;
        foreach ($tools as $l) : ?>

            var targetFaculty = facultyForms['<?= $idx; ?>'];
            targetFaculty.value = '<?= $l->faculty_id ?>';

            // Dispatch change event
            targetFaculty.dispatchEvent(changeEvent);

            var targetMajor = majorForms['<?= $idx; ?>'];
            targetMajor.value = '<?= $l->major_id ?? 'null' ?>';

        <?php $idx++;
        endforeach; ?>
    });
</script>

<?php
$this->endSection();
?>