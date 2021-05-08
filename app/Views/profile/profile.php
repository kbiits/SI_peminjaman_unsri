<?php

$this->extend('layout/app');
$this->section('content');

if ($avatarValidator = session()->getFlashdata('avatarValidator')) {
}
$avatar = $user['avatar'];
if (is_null($avatar)) {
    $avatar = $user['gender'] == '0' ? '/img/girl.png' : '/img/boy.png';
}

?>

<?php if ($avatarValidator) : ?>
    <div class="container">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <?= esc($avatarValidator['avatar']); ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($msg = session()->getFlashdata('msg')) : ?>
    <div class="container">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <?= esc($msg); ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($validator = session()->getFlashdata('validator')) : ?>
    <?php foreach ($validator->getErrors() as $k => $v) : ?>
        <div class="container">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?= esc($v); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php if ($success = session()->getFlashdata('success')) : ?>
    <div class="container">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <?= esc($success); ?>
        </div>
    </div>
<?php endif; ?>

<div class="container emp-profile">
    <div class="row">
        <div class="col-md-4">
            <div class="profile-img">
                <img src='<?= esc($avatar) ?>'
                     alt="avatar"/>
                <form action="/users/<?= esc($user['nim']) ?>/avatar" method="post" id="form-avatar"
                      enctype="multipart/form-data">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                    <div class="file btn btn-lg btn-primary">
                        Change Photo
                        <input type="file" name="avatar" id="input-avatar"/>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="profile-head">
                <h5>
                    <?= $user['name'] ?>
                </h5>
                <h6>
                    <?= $user['nim'] ?>
                </h6>
                <p class="proile-rating"></p>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                           aria-controls="home" aria-selected="true">About</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content profile-tab" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <label>NIM</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user['nim'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nama</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user['name'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Email</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user['email'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Alamat</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user['address'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Jenis Kelamin</label>
                        </div>
                        <div class="col-md-6">
                            <p><?= $user['gender'] == 0 ? 'Perempuan' : 'Laki-laki' ?></p>
                        </div>
                    </div>
                    <?php if ($user['role'] === '0') : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Fakultas</label>
                            </div>
                            <div class="col-md-6">
                                <p><?= $user['faculty'] ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Jurusan</label>
                            </div>
                            <div class="col-md-6">
                                <p><?= $user['major'] ?></p>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Role</label>
                            </div>
                            <div class="col-md-6">
                                <p>Admin</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-light profile-edit-btn" data-toggle="modal"
                    data-target="#editProfileModal">Edit Profile
            </button>
        </div>
    </div>
</div>


<!-- Modal Edit Profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog"
     aria-labelledby="editProfileModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/users/<?= esc($user['nim']) ?>" method="POST">
                    <input name="_method" value="PUT" type="hidden"/>
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name"
                               placeholder="Nama"
                               name="name"
                               value="<?= esc($user['name']) ?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email"
                               aria-describedby="emailHelp" placeholder="Email"
                               name="email"
                               value="<?= esc($user['email']) ?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control" id="address"
                               placeholder="Alamat" name="address"
                               value="<?= esc($user['address']) ?>"
                        >
                    </div>
                    <div class="form-group">
                        <label for="gender">Jenis Kelamin</label>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="laki-laki" name="gender"
                                   class="custom-control-input" value="1"
                                <?= $user['gender'] == '1' ? esc('checked') : '' ?>
                            >
                            <label class="custom-control-label" for="laki-laki">Laki-laki</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="perempuan" name="gender"
                                   class="custom-control-input" value="0"
                                <?= $user['gender'] == '0' ? esc('checked') : '' ?>
                            >
                            <label class="custom-control-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                    <?php if ($user['role'] === '0') : ?>
                        <div class="form-group">
                            <label for="faculty" class="d-block">Fakultas</label>
                            <select class="faculty-form form-control" name="faculty"
                                    id="faculty">
                                <option value="">Pilih Fakultas</option>
                                <?php foreach ($faculties as $faculty) : ?>
                                    <option value="<?= esc($faculty->id) ?>"><?= esc($faculty->faculty) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="major" class="d-block">Jurusan</label>
                            <select class="major-form form-control" name="major"
                                    id="major">
                                <option value="">Pilih Jurusan</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Update data</button>
                    </div>
                    <hr>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit Profile -->


<?php
$this->endSection();
$this->section('css');
?>
<!-- Select2 -->
<link href="/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/css/profile.css">
<style>
    .select2-search input:focus {
        outline: none;
    }
</style>

<?php
$this->endSection();
$this->section('script');
?>
<!-- Select2 -->
<script src="/vendor/select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#input-avatar').on('change', function () {
            $('#form-avatar').submit();
        });

        // Select2 Single with placeholder
        $('.faculty-form').select2({
            placeholder: "Pilih Fakultas",
            allowClear: true,
            width: '100%'
        });

        // Select2 Single  with Placeholder
        $('.major-form').select2({
            placeholder: "Pilih Jurusan",
            allowClear: true,
            width: '100%'
        });
        // Get majors data
        let majors = <?= json_encode($majors) ?>;

        // Function for update majors by faculty
        $('.faculty-form').on('change', function (e) {
            let facultyId = e.target.value;
            let majorsData = majors.filter((m) => m.faculty_id == facultyId);
            let majorSelectElement = document.getElementById('major');
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

        // Set old user faculty
        $('.faculty-form').val(<?= $user['faculty_id'] ?>).change();
        // Trigger change event for displaying majors by faculty
        $('.faculty-form').trigger('change');
        // Set old user major
        $('.major-form').val(<?= $user['major_id'] ?>).change();
    });

</script>

<?php
$this->endSection();
?>

