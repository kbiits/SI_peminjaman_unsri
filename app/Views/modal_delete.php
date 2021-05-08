<!-- Modal Delete -->
<div class="modal fade" id="modalDelete<?= $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exModalDelete"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exModalDelete">Ohh Tidak!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apa kamu yakin ingin menghapus data tersebut ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                <a href="javascript:void(0);"
                   onclick="(e) => e.preventDefault(); document.getElementById('form-delete-<?= esc($i); ?>').submit();"
                   class="btn btn-primary">Hapus</a>
            </div>
        </div>
    </div>
</div>