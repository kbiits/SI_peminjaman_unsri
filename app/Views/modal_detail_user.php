<!-- Modal Detail User -->
<div class="modal fade" id="modalDetailUser" tabindex="-1" role="dialog" aria-labelledby="modalTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Detail Peminjam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-hover">
                        <tr>
                            <th>Nama Peminjam</th>
                            <td><?= esc($p->user_name); ?></td>
                        </tr>
                        <tr>
                            <th>NIM Peminjam</th>
                            <td><?= esc($p->user_nim); ?></td>
                        </tr>
                        <tr>
                            <th>Email Peminjam</th>
                            <td><?= esc($p->user_email); ?></td>
                        </tr>
                        <tr>
                            <th>Alamat Peminjam</th>
                            <td><?= esc($p->user_address); ?></td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin Peminjam</th>
                            <td><?= esc($p->user_gender === '0' ? 'Perempuan' : 'Laki-laki'); ?></td>
                        </tr>
                        <tr>
                            <th>Fakultas Peminjam</th>
                            <td><?= esc($p->user_faculty); ?></td>
                        </tr>
                        <tr>
                            <th>Jurusan Peminjam</th>
                            <td><?= esc($p->user_major); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail -->