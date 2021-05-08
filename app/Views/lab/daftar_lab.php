<?php
$this->extend('layout/app');
$this->section('content');

$user_role = session('user')['role'];
?>

<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Lab</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Lab</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/labs">Daftar Lab</a></li>
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

    <?php if ($success = session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <?= $success ?>
        </div>
    <?php endif; ?>

    <!-- Row -->
    <div class="row">
        <!-- DataTable with Hover -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Lab</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                        <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Lab</th>
                            <th>Fakultas</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Aksi</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Fakultas</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Aksi</th>

                        </tr>
                        </tfoot>
                        <tbody>
                        <?php $i = 1;
                        foreach ($labs as $key => $lab) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $lab->name ?></td>
                                <td><?= $lab->faculty ?></td>
                                <td><?= $lab->major ?? '-' ?> </td>
                                <td>
                                    <?php if ($lab->status_lab === '0') {
                                        $statusBadge = 'success';
                                        $messageStatus = 'Tersedia';
                                    } else {
                                        $statusBadge = 'warning';
                                        $messageStatus = 'Sedang dalam perbaikan';
                                    }
                                    ?>
                                    <span class="badge badge-<?= esc($statusBadge) ?> py-1 px-2">
                                            <?= $messageStatus ?>
                                        </span>
                                </td>
                                <?php if ($lab->status_lab === '0') : ?>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modalDetail<?= esc($i); ?>"
                                                    id="#modalDetailButton">Detail
                                            </button>
                                        </div>
                                        <?php include('modal_jadwal.php') ?>
                                    </td>
                                    <?php if ($user_role === '0') : ?>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                        data-target="#modalPinjam<?= esc($i); ?>"
                                                        id="#modalPinjamButton">
                                                    Pinjam
                                                </button>
                                            </div>
                                            <?php include('modal_pinjam_lab.php') ?>
                                        </td>
                                    <?php else : ?>
                                        <td>
                                            <!-- Modal Edit -->
                                            <?php include('modal_edit_lab.php') ?>
                                            <div class="btn-group mr-2 mb-2 mb-md-0">
                                                <button type="button" class="btn btn-sm btn-warning modalEditBtn"
                                                        data-toggle="modal"
                                                        data-target="#modalEdit<?= esc($i); ?>"
                                                        id="modalEditButton"
                                                        onclick="">
                                                    Edit
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-danger" href="javascript:void(0);"
                                                   data-toggle="modal"
                                                   data-target="#modalDelete<?= $i; ?>">
                                                    Hapus
                                                </a>
                                            </div>
                                            <form id="form-delete-<?= $i; ?>" action="labs/<?= $lab->id ?>"
                                                  method="POST">
                                                <input type="hidden" name="<?= csrf_token() ?>"
                                                       value="<?= csrf_hash() ?>"/>
                                                <input type="hidden" name="_method" value="DELETE"/>
                                            </form>

                                            <!-- Modal Delete -->
                                            <?php include __DIR__ . ' /../modal_delete.php' ?>
                                        </td>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if ($user_role === '0') : ?>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#modalDetail<?= esc($i); ?>"
                                                        id="#modalDetailButton" disabled>Detail
                                                </button>
                                            </div>
                                            <?php include('modal_jadwal.php') ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                                        data-target="#modalPinjam<?= esc($i); ?>"
                                                        id="#modalPinjamButton" disabled>
                                                    Pinjam
                                                </button>
                                            </div>
                                        </td>
                                    <?php else : ?>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#modalDetail<?= esc($i); ?>"
                                                        id="#modalDetailButton">Detail
                                                </button>
                                            </div>
                                            <?php include('modal_jadwal.php') ?>
                                        </td>
                                        <td>
                                            <!-- Modal Edit -->
                                            <?php include('modal_edit_lab.php') ?>
                                            <div class="btn-group mr-2 mb-2 mb-md-0">
                                                <button type="button" class="btn btn-sm btn-warning modalEditBtn"
                                                        data-toggle="modal"
                                                        data-target="#modalEdit<?= esc($i); ?>"
                                                        id="modalEditButton"
                                                        onclick="">
                                                    Edit
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-danger" href="javascript:void(0);"
                                                   data-toggle="modal"
                                                   data-target="#modalDelete<?= esc($i); ?>">
                                                    Hapus
                                                </a>
                                            </div>

                                            <?php include __DIR__ . '/../modal_delete.php' ?>
                                        </td>
                                        <form id="form-delete-<?= $i; ?>" action="labs/<?= $lab->id ?>"
                                              method="POST">
                                            <input type="hidden" name="<?= csrf_token() ?>"
                                                   value="<?= csrf_hash() ?>"/>
                                            <input type="hidden" name="_method" value="DELETE"/>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
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
            columns: [{
                width: '3%'
            },
                null,
                null,
                null,
                null,
                null,
                null,
            ]
        }); // ID From dataTable with Hover

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

        let majors = <?= json_encode($majors) ?>;
        $('.faculty-form').on('change', function (e) {
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
        let statusForms = $('.status-lab-form');
        <?php $idx = 0; foreach ($labs as $l) : ?>

        var targetFaculty = facultyForms['<?= $idx; ?>'];
        targetFaculty.value = '<?= $l->faculty_id ?>';

        // Dispatch change event
        targetFaculty.dispatchEvent(changeEvent);

        var targetMajor = majorForms['<?= $idx; ?>'];
        targetMajor.value = '<?= $l->major_id ?? 'null' ?>';

        var targetStatus = statusForms['<?= $idx; ?>'];
        targetStatus.value = '<?= esc($l->status_lab); ?>';

        <?php $idx++; endforeach; ?>

    });

</script>

<?php
$this->endSection();
?>
