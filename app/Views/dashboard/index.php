<?php
$this->extend('layout/app');
$this->section('content');
$user_role = session('user')['role'];
?>


<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
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

    <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Aktivitas Peminjaman Lab Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($count_lab) ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <?php if ($p_lab > 0) : ?>
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= esc($p_lab); ?>%</span>
                                <?php elseif ($p_lab == 0) : ?>
                                    <span class="text-warning mr-2"><i class="fa fa-chart-line"></i> <?= esc($p_lab); ?>%</span>
                                <?php else : ?>
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> <?= esc($p_lab); ?>%</span>
                                <?php endif; ?>
                                <span>Sejak bulan lalu</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vials fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Aktivitas Peminjaman Alat Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($count_alat) ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <?php if ($p_alat > 0) : ?>
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= esc($p_alat); ?>%</span>
                                <?php elseif ($p_alat == 0) : ?>
                                    <span class="text-warning mr-2"><i class="fa fa-chart-line"></i> <?= esc($p_alat); ?>%</span>
                                <?php else : ?>
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> <?= esc($p_alat); ?>%</span>
                                <?php endif; ?>
                                <span>Sejak bulan lalu</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vials fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New User Card Example -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Aktivitas Peminjaman Buku Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($count_buku) ?></div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <?php if ($p_buku > 0) : ?>
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> <?= esc($p_buku); ?>%</span>
                                <?php elseif ($p_buku == 0) : ?>
                                    <span class="text-warning mr-2"><i class="fa fa-chart-line"></i> <?= esc($p_buku); ?>%</span>
                                <?php else : ?>
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> <?= esc($p_buku); ?>%</span>
                                <?php endif; ?>
                                <span>Sejak bulan lalu</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-vials fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Area Chart -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Aktivitas <?= $user_role === '1' ? 'Website' : session('user')['name'] ?> per Bulan</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Row-->

</div>
<!---Container Fluid-->

<?php
$this->endSection();
$this->section('script');
?>

<script src="/vendor/chart.js/Chart.min.js"></script>
<?php include(__DIR__ . '/../../../public/js/demo/chart-area-user.php') ?>

<?php
$this->endSection();
?>