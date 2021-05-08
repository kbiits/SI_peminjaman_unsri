<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?= esc($i); ?>" tabindex="-1" role="dialog" aria-labelledby="modalPinjamTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPinjamTitle">Edit Lab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/labs/<?= esc($lab->id); ?>" method="POST" id="form-edit-lab-<?= esc($i); ?>">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                    <input type="hidden" name="_method" value="PUT"/>
                    <div class="form-group">
                        <label for="name">Nama Laboratorium</label>
                        <input type="text"
                               class="form-control <?= isset($validator) && $validator->hasError('name') ? esc('is-invalid') : '' ?>"
                               aria-describedby="emailHelp" placeholder="Masukkan Nama Laboratorium"
                               name="name" value="<?= esc($lab->name) ?>">
                        <?php if (isset($validator) && $validator->hasError('name')) : ?>
                            <div class="invalid-feedback">
                                <?= $validator->getError('name') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="faculty">Fakultas</label>
                        <?php if (isset($validator) && $validator->hasError('faculty_id')) : ?>
                            <select class="faculty-form form-control is-invalid" name="faculty_id">
                                <option value="">Pilih Fakultas</option>
                                <?php foreach ($faculties as $faculty) : ?>
                                    <option value="<?= esc($faculty->id) ?>"><?= esc($faculty->faculty) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validator->getError('faculty_id') ?>
                            </div>
                        <?php else : ?>
                            <select class="faculty-form form-control" name="faculty_id">
                                <option value="">Pilih Fakultas</option>
                                <?php foreach ($faculties as $faculty) : ?>
                                    <option value="<?= esc($faculty->id) ?>"><?= esc($faculty->faculty) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="major">Jurusan</label>
                        <?php if (isset($validator) && $validator->hasError('major_id')) : ?>
                            <select class="major-form form-control is-invalid" name="major_id">
                                <option value="">Pilih Jurusan</option>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">Pilih Fakultas terlebih dahulu
                                sebelum memilih jurusan</small>
                            <div class="invalid-feedback">
                                <?= $validator->getError('major_id') ?>
                            </div>
                        <?php else : ?>
                            <select class="major-form form-control" name="major_id">
                                <option value="">Pilih Jurusan</option>
                            </select>
                            <small id="emailHelp" class="form-text text-muted">Pilih Fakultas terlebih dahulu
                                sebelum memilih jurusan</small>

                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="status_lab">Status</label>
                        <?php if (isset($validator) && $validator->hasError('status_lab')) : ?>
                            <select class="form-control is-invalid status-lab-form" name="status_lab">
                                <option value="0">Tersedia</option>
                                <option value="1">Sedang dalam perbaikan</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validator->getError('major_id') ?>
                            </div>
                        <?php else : ?>
                            <select class="form-control status-lab-form" name="status_lab">
                                <option value="0">Tersedia</option>
                                <option value="1">Sedang dalam perbaikan</option>
                            </select>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn-submit-form-pinjam"
                        onclick="(e) => e.preventDefault(); document.getElementById('form-edit-lab-<?= esc($i); ?>').submit();">
                    Submit
                </button>
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail -->