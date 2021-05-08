<!DOCTYPE html>
<html lang="en">

<!-- Header -->
<head>
    <?php

    echo $this->include('layout/_partials/header');
    $this->renderSection('css');
    ?>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/js/ruang-admin.min.js" defer></script>
</head>

<body id="page-top">

<div id="wrapper">
    <!-- Sidebar -->
    <?= $this->include('layout/_partials/sidebar') ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <!-- Topbar -->
            <?= $this->include('layout/_partials/topbar') ?>

            <!-- Content Here -->
            <?= $this->renderSection('content') ?>
        </div>

        <!-- Modal Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh Tidak!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apa kamu yakin ingin logout ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                        <a href="/logout" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?= $this->include('layout/_partials/footer') ?>
    </div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?= $this->renderSection('script') ?>

</body>
</html>
