<?php

if ($validator = session('validator')) {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/img/logo-unsri.png" rel="icon">
    <title>UNSRI - Register</title>
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
    <!-- Register Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7 col-md-10 col-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Daftar</h1>
                                    </div>
                                    <form action="/register" method="POST">
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                        <div class="form-group">
                                            <label for="nim">NIM</label>
                                            <input type="number" class="form-control <?= isset($validator) && $validator->hasError('nim') ? 'is-invalid' : '' ?>" id="nim" name="nim" placeholder="Masukkan NIM Anda" value="<?= old('nim'); ?>">
                                            <?php if (isset($validator) && $validator->hasError('nim')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $validator->getError('nim'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <small id="nimHelp" class="form-text text-warning">NIM tidak bisa diubah, harap
                                                pastikan anda memasukkannya dengan benar</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control <?= isset($validator) && $validator->hasError('name') ? 'is-invalid' : '' ?>" id="name" name="name" placeholder="Masukkan Nama Anda" value="<?= old('name'); ?>">
                                            <?php if (isset($validator) && $validator->hasError('name')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $validator->getError('name'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control <?= isset($validator) && $validator->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" aria-describedby="emailHelp" placeholder="Masukkan Email Anda" value="<?= old('email'); ?>">
                                            <?php if (isset($validator) && $validator->hasError('email')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $validator->getError('email'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control <?= isset($validator) && $validator->hasError('password') ? 'is-invalid' : '' ?>" id="exampleInputPassword" name="password" placeholder="Password">
                                            <?php if (isset($validator) && $validator->hasError('password')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $validator->getError('password'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label id="password_confirm">Konfirmasi Password</label>
                                            <input type="password" class="form-control <?= isset($validator) && $validator->hasError('password_confirm') ? 'is-invalid' : '' ?>" id="password_confirm" name="password_confirm" placeholder="Ulangi Password">
                                            <?php if (isset($validator) && $validator->hasError('password_confirm')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $validator->getError('password_confirm'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Alamat</label>
                                            <input type="text" class="form-control <?= isset($validator) && $validator->hasError('address') ? 'is-invalid' : '' ?>" id="address" name="address" placeholder="Masukkan Alamat Anda" value="<?= old('address'); ?>">
                                            <?php if (isset($validator) && $validator->hasError('address')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $validator->getError('address'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="gender">Jenis Kelamin</label><br />
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="male" name="gender" value="1" class="custom-control-input <?= isset($validator) && $validator->hasError('gender') ? 'is-invalid' : '' ?>">
                                                <label for="male" class="custom-control-label">&nbsp&nbspLaki-laki</label><br />
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="female" name="gender" value="0" class="custom-control-input <?= isset($validator) && $validator->hasError('gender') ? 'is-invalid' : '' ?>">
                                                <label for="female" class="custom-control-label">&nbsp&nbspPerempuan</label>
                                                <?php if (isset($validator) && $validator->hasError('gender')) : ?>
                                                    <div class="invalid-feedback">
                                                        <?= $validator->getError('gender'); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="faculty_id">Fakultas</label>
                                            <select class="form-control <?= isset($validator) && $validator->hasError('faculty_id') ? 'is-invalid' : '' ?>" name="faculty_id" id="faculty_id">
                                                <option value="" selected>Pilih Fakultas</option>
                                                <?php foreach ($faculties as $f) : ?>
                                                    <option value="<?= esc($f->id) ?>"><?= esc($f->faculty); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if (isset($validator) && $validator->hasError('faculty_id')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $validator->getError('faculty_id'); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="major_id">Jurusan</label>
                                            <select class="form-control <?= isset($validator) && $validator->hasError('major_id') ? 'is-invalid' : '' ?>" name="major_id" id="major_id">
                                                <option value="" selected>Pilih Jurusan</option>
                                            </select>
                                            <?php if (isset($validator) && $validator->hasError('major_id')) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $validator->getError('major_id'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <small id="emailHelp" class="form-text text-muted">Pilih Fakultas terlebih
                                                dahulu
                                                sebelum memilih jurusan</small>
                                        </div>
                                        <div class="form-group mt-4 mb-3">
                                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                                        </div>
                                        <hr>
                                    </form>
                                    <div class="text-center mt-3">
                                        <small>Sudah punya akun ? <a class="font-weight-bold" href="/login">Login
                                                Sekarang !</a></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Content -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="/js/ruang-admin.min.js"></script>
    <script>
        $(document).ready(function() {

            let majors = <?= json_encode($majors) ?>;
            $('#faculty_id').on('change', function(e) {
                let facultyId = e.target.value;
                let majorsData = majors.filter((m) => m.faculty_id == facultyId);
                let majorSelectElement = document.getElementById('major_id');
                // Delete all child
                while (majorSelectElement.firstChild) {
                    majorSelectElement.firstChild.remove();
                }
                majorsData.forEach((m) => {
                    let temp = document.createElement('option');
                    temp.value = m.id;
                    temp.innerHTML = m.major;
                    majorSelectElement.appendChild(temp);
                });
            });

        });
    </script>
</body>

</html>