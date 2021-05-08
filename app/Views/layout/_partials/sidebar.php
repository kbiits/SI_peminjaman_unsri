<?php $user_role = session('user')['role']; ?>

<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="/img/logo-unsri.png">
        </div>
        <div class="sidebar-brand-text mx-3">UNSRI</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item <?= uri_string() == '/' ? 'active' : '' ?>">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Features
    </div>
    <li class="nav-item <?= uri_string() == 'about' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="/about" onclick="window.open('/about', '_top')">
            <i class="fas fa-fw fa-address-card"></i>
            <span>About</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLab" aria-expanded="true" aria-controls="collapseLab">
            <i class="fas fa-fw fa-vials"></i>
            <span>Peminjaman Lab Komputer</span>
        </a>
        <div id="collapseLab" class="collapse <?= (strpos(uri_string(), 'labs') !== false) ? esc('show') : esc('') ?>" aria-labelledby="headingForm" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Peminjaman Lab Komputer</h6>
                <a class="collapse-item <?= uri_string() == 'labs' ? esc('active') : esc('') ?>" href="/labs">Daftar
                    Lab</a>
                <?php if ($user_role === '0') : ?>
                    <a class="collapse-item <?= uri_string() == 'labs/show' ? esc('active') : esc('') ?>" href="/labs/show">Pinjaman
                        Saya</a>
                    <a class="collapse-item <?= uri_string() == 'labs/history' ? esc('active') : esc('') ?>" href="/labs/history">Riwayat Pemakaian Lab</a>
                <?php else : ?>
                    <a class="collapse-item <?= uri_string() == 'labs/create-labs' ? esc('active') : esc('') ?>" href="/labs/create-labs">Tambahkan Lab Baru</a>
                    <a class="collapse-item <?= uri_string() == 'labs/all' ? esc('active') : esc('') ?>" href="/labs/all">Data Riwayat Peminjaman Lab</a>
                <?php endif; ?>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTool" aria-expanded="true" aria-controls="collapseTool">
            <i class="fas fa-fw fa-tools"></i>
            <span>Peminjaman Alat</span>
        </a>
        <div id="collapseTool" class="collapse <?= (strpos(uri_string(), 'tools') !== false) ? esc('show') : esc('') ?>" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Peminjaman Alat</h6>
                <a class="collapse-item <?= uri_string() == 'tools' ? esc('active') : esc('') ?>" href="/tools">Daftar
                    Alat</a>
                <?php if ($user_role === '0') : ?>
                    <a class="collapse-item <?= uri_string() == 'tools/show' ? esc('active') : esc('') ?>" href="/tools/show">Pinjaman Alat Saya</a>
                    <a class="collapse-item <?= uri_string() == 'tools/history' ? esc('active') : esc('') ?>" href="/tools/history">Riwayat Pinjaman Alat Saya</a>
                <?php else : ?>
                    <a class="collapse-item <?= uri_string() == 'tools/show-konfirmasi' ? esc('active') : esc('') ?>" href="/tools/show-konfirmasi">Konfirmasi Pengembalian Alat</a>
                    <a class="collapse-item <?= uri_string() == 'tools/create-tools' ? esc('active') : esc('') ?>" href="/tools/create-tools">Tambahkan Alat Baru</a>
                    <a class="collapse-item <?= uri_string() == 'tools/all' ? esc('active') : esc('') ?>" href="/tools/all">Data Riwayat Peminjaman Alat</a>
                <?php endif; ?>

            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBook">
            <i class="fas fa-fw fa-book"></i>
            <span>Peminjaman Buku</span>
        </a>
        <div id="collapseBook" class="collapse <?= (strpos(uri_string(), 'books') !== false) ? esc('show') : esc('') ?>" aria-labelledby="headingBook" data-parent="#accordionSidebar" aria-expanded="true" aria-controls="collapseBook">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Peminjaman Buku</h6>
                <a class="collapse-item <?= uri_string() == 'books' ? esc('active') : esc('') ?>" href="/books">Daftar
                    Buku</a>
                <?php if ($user_role === '0') : ?>
                    <a class="collapse-item <?= uri_string() == 'books/show' ? esc('active') : esc('') ?>" href="/books/show">Pinjaman Buku Saya</a>
                    <a class="collapse-item <?= uri_string() == 'books/history' ? esc('active') : esc('') ?>" href="/books/history">Riwayat Pinjaman Buku Saya</a>
                <?php else : ?>
                    <a class="collapse-item <?= uri_string() == 'books/show-konfirmasi' ? esc('active') : esc('') ?>" href="/books/show-konfirmasi">Konfirmasi Pengembalian Buku</a>
                    <a class="collapse-item <?= uri_string() == 'books/create-books' ? esc('active') : esc('') ?>" href="/books/create-books">Tambahkan Buku Baru</a>
                    <a class="collapse-item <?= uri_string() == 'books/all' ? esc('active') : esc('') ?>" href="/books/all">Data Riwayat Peminjaman Buku</a>
                <?php endif; ?>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <?php if ($user_role === '1') : ?>
        <div class="sidebar-heading">
            More Features
        </div>
        <li class="nav-item <?= uri_string() == 'users/add-admin' ? esc('active') : esc('') ?>">
            <a class="nav-link" href="/users/add-admin">
                <i class="fas fa-fw fa-users"></i>
                <span>Tambah Admin</span>
            </a>
        </li>
        <li class="nav-item <?= uri_string() == 'add-faculty-major' ? esc('active') : esc('') ?>">
            <a class="nav-link" href="/add-faculty-major">
                <i class="fas fa-fw fa-plus"></i>
                <span>Tambah Fakultas atau Jurusan</span>
            </a>
        </li>
        <li class="nav-item <?= uri_string() == 'faculties-majors' ? esc('active') : esc('') ?>">
            <a class="nav-link" href="/faculties-majors">
                <i class="fas fa-fw fa-list"></i>
                <span>Daftar Fakultas dan Jurusan</span>
            </a>
        </li>
        <hr class="sidebar-divider">
    <?php endif; ?>
    <div class="version" id="version-ruangadmin">Developed By Kelompok ?</div>
</ul>
<!-- Sidebar -->