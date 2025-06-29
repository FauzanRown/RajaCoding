  <!-- modal  tambah tempat tugas-->
  <div class="modal" id="modalUpdateKateogri<?= $row[0] ?>" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Masukan Nama Kategori</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" class="w-100">
          <div class="modal-body">
            <div class="form-group w-100">
              <label>Nama Kategori</label>
              <input type="hidden" value="<?= $row[0] ?>" name="edit_id" />
              <input type="text" name="kategori" id="kategori" value="<?= $row[1] ?>">
              <!-- <select name="kateogri" style="width: 100%;" id="kateogri"></select> -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="update" class="btn btn-primary">Save changes</button>
          </div>
        </form>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>