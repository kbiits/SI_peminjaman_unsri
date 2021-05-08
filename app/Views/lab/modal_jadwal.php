<!-- Modal Detail -->
<div class="modal fade" id="modalDetail<?= esc($i); ?>" tabindex="-1" role="dialog"
     aria-labelledby="modalDetailTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailTitle">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <span class="font-weight-bold">Nama Lab</span>
                    <p><?= esc($lab->name); ?></p>
                    <span class="font-weight-bold">Fakultas</span>
                    <p><?= esc($lab->faculty); ?></p>
                    <span class="font-weight-bold">Jurusan</span>
                    <p><?= esc($lab->major ?? '-'); ?></p>
                    <span class="font-weight-bold"><?= isset($title) ? esc($title) : esc('Jadwal yang sudah direservasi'); ?></span>
                    <div class="table-responsive">
                        <table class="table align-items-center table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <?= isset($title) ? '<th>Status</th>' : '' ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $j = 1;
                            foreach ($lab->jadwals as $jadwal) : ?>
                                <?php if (!isset($title)) : ?>
                                    <?php if ($jadwal->tanggal >= date('Y-m-d')) : ?>
                                        <tr>
                                            <td><?= esc($j++); ?></td>
                                            <td><?= $jadwal->tanggal ?></td>
                                            <td><?= $jadwal->jam_masuk ?></td>
                                            <td><?= $jadwal->jam_keluar ?></td>

                                        </tr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <tr>
                                        <td><?= esc($j++); ?></td>
                                        <td><?= $jadwal->tanggal ?></td>
                                        <td><?= $jadwal->jam_masuk ?></td>
                                        <td><?= $jadwal->jam_keluar ?></td>
                                        <?php
                                        $message = $jadwal->tanggal >= date('Y-m-d') && $jadwal->jam_keluar > date('H:i') ? 'Masih dalam reservasi' : 'Selesai';
                                        $badgeType = $jadwal->tanggal >= date('Y-m-d') && $jadwal->jam_keluar > date('H:i') ? 'danger' : 'success';
                                        ?>
                                        <td>
                                                <span class="badge badge-<?= esc($badgeType) ?> py-1 px-2">
                                                    <?= $message ?>
                                                </span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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