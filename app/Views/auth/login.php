<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/img/logo-unsri.png" rel="icon">
    <title>RuangAdmin - Register</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<?php
if ($validator = session('validator'))
?>

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
                                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>
                                <form action="/login" method="post" id="form-login">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                                    <div class="form-group">
                                        <label for="email_or_nim">Email atau NIM</label>
                                        <input type="text"
                                               class="form-control <?= isset($validator) && $validator->hasError('email_or_nim') ? 'is-invalid' : '' ?>"
                                               id="email_or_nim"
                                               aria-describedby="emailHelp" name="email_or_nim"
                                               placeholder="Masukkan Email atau NIM"
                                        >
                                        <?php if (isset($validator) && $validator->hasError('email_or_nim')) : ?>
                                            <div class="invalid-feedback">
                                                <?= $validator->getError('email_or_nim'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control <?= isset($validator) && $validator->hasError('password') ? 'is-invalid' : '' ?>" id="password"
                                               placeholder="Password">
                                        <?php if (isset($validator) && $validator->hasError('password')) : ?>
                                            <div class="invalid-feedback">
                                                <?= $validator->getError('password'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"
                                                class="btn btn-primary btn-block" id="btn-submit">Login
                                        </button>
                                    </div>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <small>Belum punya akun ? <a class="font-weight-bold" href="/register">Daftar
                                            Sekarang!</a></small>
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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="/js/ruang-admin.min.js"></script>
<script>
    $(document).ready(function () {
    });
</script>
</body>

</html>