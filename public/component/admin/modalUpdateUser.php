  <!-- modal  tambah tempat tugas-->

  <div class="modal fade modal-lg" id="<?= 'modalUpdateUser' . $row[0] ?>" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Masukan Data User</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" class="w-100" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" value="<?= $row[0] ?>" name="user_id" />
            <input type="hidden" value="<?= $row[4] ?>" name="gambarLama" />
            <div class="form-group w-100">
              <label>Nama User</label>
              <input type="text" value="<?= $row[1] ?>" placeholder="Username" name="name" required />
              <label class="mt-2">Email User</label>
              <input type="email" value="<?= $row[2] ?>" placeholder="Email" name="email" required />
              <label class="mt-2">Image User</label>
              <input class="form-control" type="file" name="img">
              <label class="mt-2">Role User</label>
              <select name="role" required>
                <option value="">Pilih Role</option>
                <option value="admin" <?= ($row[3] == 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="dosen" <?= ($row[3] == 'dosen') ? 'selected' : '' ?>>Dosen</option>
                <option value="mahasiswa" <?= ($row[3] == 'mahasiswa') ? 'selected' : '' ?>>Mahasiswa</option>
              </select>
              <span style="color:red;"></span><br>
              <label class="mt-2">Password User</label>
              <input type="password" required placeholder="Password" name="password" />
              <label class="mt-2">Confirm Password</label>
              <input type="password" required placeholder="Confirm Password" name="confirm_password" />
              <!-- <select name="kateogri" style="width: 100%;" id="kateogri"></select> -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" name="update">Submit</button>

          </div>
        </form>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>