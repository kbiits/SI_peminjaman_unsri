<?php

namespace Config;

// Create a new instance of our RouteCollection class.

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Middleware Auth
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('/', 'HomeController::index');

    // Form Add Faculty or Major
    $routes->get('add-faculty-major', 'UniversityController::show_create_faculty_major', ['filter' => 'admin']);

    // Daftar Fakultas dan Jurusan
    $routes->get('faculties-majors', 'UniversityController::show', ['filter' => 'admin']);

    // Add Faculty
    $routes->post('faculties', 'UniversityController::store_faculty', ['filter' => 'admin']);

    // Update Faculty
    $routes->put('faculties/(:segment)', 'UniversityController::update_faculty/$1', ['filter' => 'admin']);

    // Delete Faculty
    $routes->delete('faculties/(:segment)', 'UniversityController::delete_faculty/$1', ['filter' => 'admin']);

    // Add Major
    $routes->post('majors', 'UniversityController::store_major', ['filter' => 'admin']);

    // Update Major
    $routes->put('majors/(:segment)', 'UniversityController::update_major/$1', ['filter' => 'admin']);

    // Delete Major
    $routes->delete('majors/(:segment)', 'UniversityController::delete_major/$1', ['filter' => 'admin']);

    // About
    $routes->get('/about', 'HomeController::about');

    $routes->group('users', function ($routes) {
        // Update user avatar
        $routes->post('(:segment)/avatar', 'UserController::change_avatar/$1');

        // Update user data
        $routes->put('(:segment)', 'UserController::update/$1');

        // Show add admin form
        $routes->get('add-admin', 'UserController::show_add_admin', ['filter' => 'admin']);

        // Create Admin
        $routes->post('admin', 'UserController::store_admin', ['filter' => 'admin']);
    });


    // Labs
    $routes->group('labs', function ($routes) {
        // Show All Labs
        $routes->get('/', 'LabController::index');

        // Lihat data pinjaman yg sedang user pinjam skrg
        $routes->get('show', 'LabController::show_by_user', ['filter' => 'user']);

        // Daftar Riwayat Pinjaman Lab
        $routes->get('history', 'LabController::history', ['filter' => 'user']);

        // Pinjam Lab : Segment => Id Lab
        $routes->post('(:segment)/pinjam', 'LabController::pinjam/$1', ['filter' => 'user']);

        // Kembalikan Alat : Segment 1 => Id lab
        $routes->get('(:segment)/kembalikan/', 'LabController::kembalikan/$1', ['filter' => 'user']);

        // Daftar Riwayat Semua Pinjaman (Only Admin)
        $routes->get('all', 'LabController::history_all', ['filter' => 'admin']);

        // Show Form Create Lab
        $routes->get('create-labs', 'LabController::show_create_form', ['filter' => 'admin']);

        // Buat Lab
        $routes->post('/', 'LabController::store', ['filter' => 'admin']);

        // Update Lab
        $routes->put('(:segment)', 'LabController::update/$1', ['filter' => 'admin']);

        // Delete Lab
        $routes->delete('(:segment)', 'LabController::destroy/$1', ['filter' => 'admin']);

        // Edit Pinjaman : Segment 1 => ID Lab, Segment 2 => ID Jadwal
        $routes->put('(:segment)/pinjam/(:segment)', 'LabController::update_pinjaman/$1/$2', ['filter' => 'user']);

        // Delete Pinjaman : Segment 1 => ID Jadwal
        $routes->delete('(:segment)/pinjam', 'LabController::delete_pinjaman/$1', ['filter' => 'user']);
    });

    // Tools
    $routes->group('tools', function ($routes) {
        // Show All Tools
        $routes->get('/', 'ToolController::index');

        // Lihat data pinjaman yg sedang user pinjam skrg
        $routes->get('show', 'ToolController::show_by_user', ['filter' => 'user']);

        // Daftar Riwayat Pinjaman Alat per User
        $routes->get('history', 'ToolController::history', ['filter' => 'user']);

        // Pinjam Alat : Segment => Id Alat
        $routes->get('(:segment)/pinjam', 'ToolController::pinjam/$1', ['filter' => 'user']);

        // Kembalikan Alat : Segment 1 => Id alat, Segment 2 => Id data peminjaman
        $routes->get('(:segment)/kembalikan/(:segment)', 'ToolController::kembalikan/$1/$2', ['filter' => 'user']);

        // Daftar Riwayat Semua Pinjaman (Only Admin)
        $routes->get('all', 'ToolController::history_all', ['filter' => 'admin']);

        // Konfirmasi pengembalian alat : Segment 1 => Id alat
        $routes->get('(:segment)/konfirmasi/(:segment)', 'ToolController::konfirmasi/$1/$2', ['filter' => 'admin']);

        // Show Konfirmasi Data
        $routes->get('show-konfirmasi', 'ToolController::show_data_konfirmasi', ['filter' => 'admin']);

        // Show Form Create Alat
        $routes->get('create-tools', 'ToolController::show_create_form', ['filter' => 'admin']);

        // Buat Alat
        $routes->post('', 'ToolController::store', ['filter' => 'admin']);

        // Update Alat
        $routes->put('(:segment)', 'ToolController::update/$1', ['filter' => 'admin']);

        // Delete Alat
        $routes->delete('(:segment)', 'ToolController::destroy/$1', ['filter' => 'admin']);
    });

    // Books
    $routes->group('books', function ($routes) {
        // Show All Books
        $routes->get('/', 'BookController::index');

        // Show by User
        $routes->get('show', 'BookController::show_by_user');

        // Daftar Riwayat Pinjaman Buku
        $routes->get('history', 'BookController::history');

        // Pinjam Buku : Segment => ISBN buku
        $routes->get('(:segment)/pinjam', 'BookController::pinjam/$1');

        // Kembalikan Buku : Segment 1 => ISBN buku, Segment 2 => ID data peminjaman
        $routes->get('(:segment)/kembalikan/(:segment)', 'BookController::kembalikan/$1/$2');

        // Konfirmasi pengembalian buku : Segment 1 => ISBN Buku, Segment 2 => Id Peminjaman
        $routes->get('(:segment)/konfirmasi/(:segment)', 'BookController::konfirmasi/$1/$2', ['filter' => 'admin']);

        // Show Konfirmasi Data
        $routes->get('show-konfirmasi', 'BookController::show_data_konfirmasi', ['filter' => 'admin']);

        // Show Form Create Buku
        $routes->get('create-books', 'BookController::show_create_form', ['filter' => 'admin']);

        // Daftar Riwayat Semua Pinjaman (Only Admin)
        $routes->get('all', 'BookController::history_all', ['filter' => 'admin']);

        // Buat Buku
        $routes->post('/', 'BookController::store', ['filter' => 'admin']);

        // Update Buku : Segment 1 => ISBN Book
        $routes->put('(:segment)', 'BookController::update/$1', ['filter' => 'admin']);

        // Delete Buku
        $routes->delete('(:segment)', 'BookController::destroy/$1', ['filter' => 'admin']);
    });

    // Logout
    $routes->get('/logout', 'HomeController::logout');

    // Simple Tables
    $routes->get('/simple-tables', 'Login::tables');


    $routes->get('/pinjaman', function () {
        return view('pinjaman/show_pinjaman.php');
    });
});

$routes->group('', ['filter' => 'guest'], function ($routes) {
    // Register
    $routes->get('/register', 'Register::index');
    $routes->post('/register', 'Register::save');

    // Login
    $routes->get('/login', 'Login::index');
    $routes->post('/login', 'Login::login');
});

$routes->get('(:any)', function () {
    if (session()->has('user')) {
        return view('others/404.php');
    }

    return view('errors/html/error_404.php');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
