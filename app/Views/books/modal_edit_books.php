<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?= esc($i); ?>" tabindex="-1" role="dialog" aria-labelledby="modalPinjamTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPinjamTitle">Edit Buku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/books/<?= esc($book->isbn); ?>" method="POST" id="form-edit-tool-<?= esc($i); ?>">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>"/>
                    <input type="hidden" name="_method" value="PUT"/>
                    <div class="form-group">
                        <label for="name">ISBN</label>
                        <input type="text"
                               class="form-control <?= isset($validator) && $validator->hasError('isbn') ? esc('is-invalid') : '' ?>"
                               aria-describedby="emailHelp" placeholder="Masukkan ISBN Buku"
                               name="isbn" value="<?= esc($book->isbn) ?>">
                        <?php if (isset($validator) && $validator->hasError('isbn')) : ?>
                            <div class="invalid-feedback">
                                <?= $validator->getError('isbn') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="title">Judul Buku</label>
                        <input type="text"
                               class="form-control <?= isset($validator) && $validator->hasError('title') ? esc('is-invalid') : '' ?>"
                               aria-describedby="emailHelp" placeholder="Masukkan Judul Buku"
                               name="title" value="<?= esc($book->title) ?>">
                        <?php if (isset($validator) && $validator->hasError('title')) : ?>
                            <div class="invalid-feedback">
                                <?= $validator->getError('title') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="name">Kategori Buku</label>
                        <input type="text"
                               class="form-control <?= isset($validator) && $validator->hasError('category') ? esc('is-invalid') : '' ?>"
                               aria-describedby="emailHelp" placeholder="Masukkan Kategori Buku"
                               name="category" value="<?= esc($book->category) ?>">
                        <?php if (isset($validator) && $validator->hasError('category')) : ?>
                            <div class="invalid-feedback">
                                <?= $validator->getError('category') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock Buku</label>
                        <input type="number"
                               class="form-control <?= isset($validator) && $validator->hasError('stock') ? esc('is-invalid') : '' ?>"
                               aria-describedby="emailHelp" placeholder="Masukkan Banyak Stock Buku"
                               name="stock" value="<?= esc($book->stock) ?>">
                        <?php if (isset($validator) && $validator->hasError('stock')) : ?>
                            <div class="invalid-feedback">
                                <?= $validator->getError('stock') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn-submit-form-pinjam"
                        onclick="(e) => e.preventDefault(); document.getElementById('form-edit-tool-<?= esc($i); ?>').submit();">
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