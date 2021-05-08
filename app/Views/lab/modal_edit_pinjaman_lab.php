<!-- Modal Detail -->
<div class="modal fade" id="modalEditPinjaman<?= esc($i); ?>" tabindex="-1" role="dialog" aria-labelledby="modalPinjamTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPinjamTitle">Edit Data Peminjaman
                    Lab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <form action="/labs/<?= esc($lab->lab_id); ?>/pinjam/<?= esc($lab->jadwal_id) ?>" method="POST" id="form-edit-pinjaman-<?= esc($i); ?>">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <input type="hidden" name="_method" value="PUT" />
                        <div class="form-group" id="simple-date1">
                            <label for="tanggal">Masukkan Tanggal Reservasi</label>
                            <div class="input-group date">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control" value="<?= esc($lab->tanggal); ?>" id="tanggal" name="tanggal">
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="form-group">
                            <label for="clockPicker-1">Jam Masuk</label>
                            <div class="input-group clockPicker3" id="clockPicker3">
                                <input class="form-control" placeholder="Jam Masuk" value="<?= esc($lab->jam_masuk); ?>" name="jam_masuk" id="clockPicker-1">
                                <div class="input-group-append">
                                    <button class="btn btn-primary check-minutes1" id="check-minutes1" onclick="(e) => e.preventDefault();">Ubah Menit
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="form-group">
                            <label for="clockPicker-2">Jam Keluar</label>
                            <div class="input-group clockPicker4" id="clockPicker4">
                                <?php
                                $an_hour = strtotime(date('H:i')) + 60 * 60;
                                $time = date('H:i', $an_hour);
                                ?>
                                <input class="form-control" placeholder="Jam Keluar" value="<?= esc($lab->jam_keluar); ?>" name="jam_keluar" id="clockPicker-2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary check-minutes2" id="check-minutes2" onclick="(e) => e.preventDefault();">Ubah Menit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btn-submit-form-edit-pinjaman" onclick="document.getElementById('form-edit-pinjaman-<?= esc($i); ?>').submit();">Submit</button>
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail -->