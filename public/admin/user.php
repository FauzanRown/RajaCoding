<?php
session_start();
require_once '../../controller/userController.php';
if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}
if ($_SESSION['role'] !== 'admin') {
  header("Location: ../403.php");
  exit;
}
if (isset($_POST["submit"])) {
  if ($hasil = createUser() > 0) {
    $_SESSION["success"] = "Berhasil Tambah User  ";
    $successMsg = $_SESSION["success"];
    unset($_SESSION["success"]);
  } else {
    $_SESSION["error"] = "Gagal Tambah User ";
    $errorMsg = $_SESSION["error"];
    unset($_SESSION["error"]);
  }
}
if (isset($_POST["delete"])) {
  if ($hasil = deleteUser(id: $_POST["hapus_id"]) > 0) {
    $_SESSION["success"] = "Berhasil Hapus User  ";
    $successMsg = $_SESSION["success"];
    unset($_SESSION["success"]);
  } else {
    $_SESSION["error"] = "Gagal Hapus User ";
    $errorMsg = $_SESSION["error"];
    unset($_SESSION["error"]);
  }
}
if (isset($_POST["update"])) {
  if ($hasil = updateUser($_POST["user_id"]) > 0) {
    $_SESSION["success"] = "Berhasil Update User  ";
    $successMsg = $_SESSION["success"];
    unset($_SESSION["success"]);
  } else {
    $_SESSION["error"] = "Gagal Update User ";
    $errorMsg = $_SESSION["error"];
    unset($_SESSION["error"]);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Journal Anda</title>
  <!-- Select2 CSS & JS -->

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.css" />
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

  <link rel="stylesheet" href="../../assets/css/dashboard.css" />
  <link rel="stylesheet" href="../../assets/fontawesome-free/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


</head>



<body>
  <div class="container">
    <?php include '../component/admin/sidebar.php' ?>
    <div id="content">

      <div class="bg-white p-2 mt-4">
        <button type="button" class="btn btn-success my-2 " data-bs-toggle="modal"
          data-bs-target="#modalAddUser">
          Tambah User <i class="ml-1 fas fa-plus"></i>
        </button>
        <table id="example" class="table table-striped" border="1">
          <thead>
            <tr>
              <th>No</th>
              <th>Email</th>
              <th>Nama</th>
              <th>Role</th>
              <th>Image</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>No</th>
              <th>Email</th>
              <th>Nama</th>
              <th>Role</th>
              <th>Image</th>
              <th>Aksi</th>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="copyright">
        All Rights Reserved • Copyright StudentLogbook by RajaCoding 2025 in
        Yogyakarta
      </p>
    </div>
  </div>
  <!-- modal  tambah tempat tugas-->
  <div class="modal fade modal-lg" id="modalAddUser" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Masukan Data User</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" class="w-100" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group w-100">
              <label>Nama User</label>
              <input type="text" placeholder="Username" name="name" />
              <span style="color:red;"><?= $errors['name'] ?></span>
              <label class="mt-2">Email User</label>
              <input type="email" placeholder="Email" name="email" />
              <span style="color:red;"><?= $errors['email'] ?></span><br>
              <label class="mt-2">Image User</label>
              <input class="form-control" type="file" name="img">
              <span style="color:red;"><?= $errors['img'] ?></span><br>
              <label class="mt-2">Role User</label>
              <select name="role">
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="dosen">Dosen</option>
                <option value="mahasiswa">Mahasiswa</option>
              </select>
              <span style="color:red;"><?= $errors['role'] ?></span><br>
              <label class="mt-2">Password User</label>
              <input type="password" placeholder="Password" name="password" />
              <span style="color:red;"><?= $errors['password'] ?></span><br>
              <label class="mt-2">Confirm Password</label>
              <input type="password" placeholder="Confirm Password" name="confirm_password" />
              <span style="color:red;"><?= $errors['confirm_password'] ?></span><br>
              <!-- <select name="kateogri" style="width: 100%;" id="kateogri"></select> -->
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" name="submit">Sumbit</button>

          </div>
        </form>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script>

  <!-- DataTables + Bootstrap 5 integration -->
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.min.js"></script>

  <!-- Toastr JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    <?php if (!empty($successMsg)) : ?>
      toastr.success("<?= $successMsg ?>");

    <?php endif; ?>

    <?php if (!empty($errorMsg)) : ?>
      toastr.error("<?= $errorMsg ?>");


    <?php endif; ?>
  </script>
  <!-- <script src="../../assets/js/RoleUser/journalanda.js"></script> -->
  <script>
    //Initialize Select2 Elements
    // $('#kateogri').select2({
    //   theme: 'bootstrap-5',
    //   placeholder: "Pilih kateogri",

    //   ajax: {
    //     url: '../../controller/categoryController.php?action=getCategory',
    //     dataType: 'json',
    //     delay: 250,
    //     data: function(params) {
    //       return {
    //         search: params.term
    //       };
    //     },
    //     processResults: function(data) {
    //       return {
    //         results: data
    //       };
    //     },
    //     cache: true,
    //     minimumInputLength: 1,
    //     theme: "bootstrap5",

    //   }
    // });
    $(document).ready(function() {
      var t = $("#example").DataTable({
        ajax: "../../controller/datatableUserControllerAdmin.php",
        processing: true,
        serverSide: true,
        "columnDefs": [{
          "searchable": false,
          "orderable": false,
          "targets": 0
        }]
      });
      t.on('draw.dt', function() {
        var pageInfo = t.page.info();
        t.column(0, {
          page: 'current'
        }).nodes().each(function(cell, i) {
          cell.innerHTML = pageInfo.start + i + 1;
        });
      });
    });
  </script>
</body>

</html>