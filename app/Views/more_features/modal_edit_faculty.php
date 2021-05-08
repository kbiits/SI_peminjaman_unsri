<!-- Modal Edit -->
<div class="modal fade" id="modalEditFaculty<?= esc($i); ?>" tabindex="-1" role="dialog"
     aria-labelledby="modalFacultyTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFacultyTitle">Edit Fakultas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/faculties/<?= esc($faculty->id); ?>" method="POST"
                      id="form-edit-faculty-<?= esc($i); ?>">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                    <input type="hidden" name="_method" value="PUT"/>
                    <div class="form-group">
                        <label for="faculty">Fakultas</label>
                        <input type="text"
                               class="form-control <?= isset($validator) && $validator->hasError('faculty') ? esc('is-invalid') : '' ?>"
                               aria-describedby="emailHelp" placeholder="Masukkan Fakultas"
                               name="faculty" value="<?= esc($faculty->faculty) ?>">
                        <?php if (isset($validator) && $validator->hasError('faculty')) : ?>
                            <div class="invalid-feedback">
                                <?= $validator->getError('faculty') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn-submit-form-edit-faculty"
                        onclick="(e) => e.preventDefault(); document.getElementById('form-edit-faculty-<?= esc($i); ?>').submit();">
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