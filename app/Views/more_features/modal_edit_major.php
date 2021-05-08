<!-- Modal Edit Major -->
<div class="modal fade" id="modalEditMajor<?= esc($i); ?>" tabindex="-1" role="dialog"
     aria-labelledby="modalMajorTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMajorTitle">Edit Jurusan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/majors/<?= esc($major->id); ?>" method="POST"
                      id="form-edit-major-<?= esc($i); ?>">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                    <input type="hidden" name="_method" value="PUT"/>
                    <div class="form-group">
                        <label for="major">Jurusan</label>
                        <input type="text"
                               class="form-control <?= isset($validator) && $validator->hasError('major') ? esc('is-invalid') : '' ?>"
                               aria-describedby="emailHelp" placeholder="Masukkan Fakultas"
                               name="major" value="<?= esc($major->major) ?>">
                        <?php if (isset($validator) && $validator->hasError('major')) : ?>
                            <div class="invalid-feedback">
                                <?= $validator->getError('major') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="faculty_id">Fakultas</label>
                        <select
                                class="form-control <?= isset($validator) && $validator->hasError('faculty_id') ? esc('is-invalid') : '' ?>"
                                id="faculty_major_form" aria-describedby="emailHelp"
                                name="faculty_id">
                            <option value="">Pilih Fakultas</option>
                            <?php foreach ($faculties as $faculty) : ?>
                                <option <?= $major->faculty_id == $faculty->id ? esc('selected') : esc(''); ?>
                                        value="<?= esc($faculty->id); ?>"
                                >
                                    <?= esc($faculty->faculty); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($validator) && $validator->hasError('faculty_id')) : ?>
                            <div class="invalid-feedback">
                                <?= $validator->getError('faculty_id') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn-submit-form-edit-major"
                        onclick="(e) => e.preventDefault(); document.getElementById('form-edit-major-<?= esc($i); ?>').submit();">
                    Perbarui Data
                </button>
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail -->