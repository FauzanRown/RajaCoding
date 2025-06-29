<?php
session_start();
require_once '../../controller/journalController.php';
require_once '../../controller/bimbinganController.php';
if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}
if ($_SESSION['role'] !== 'dosen') {
  header("Location: ../403.php");
  exit;
}
if (isset($_POST["submit"])) {
  if (tambahMhsBimbingan() > 0) {
    $_SESSION["success"] = "Berhasil Tambah Mahasiswa Bimbingan ";
    $successMsg = $_SESSION["success"];
    unset($_SESSION["success"]);
  } else {
    $_SESSION["error"] = "Gagal Tambah Mahasiswa Bimbingan";
    $errorMsg = $_SESSION["error"];
    unset($_SESSION["error"]);
  }
}
if (isset($_POST["delete"])) {
  if (hapusMhsBimbingan() > 0) {
    $_SESSION["success"] = "Berhasil Hapus Mahasiswa Bimbingan ";
    $successMsg = $_SESSION["success"];
    unset($_SESSION["success"]);
  } else {
    $_SESSION["error"] = "Gagal Hapus Mahasiswa Bimbingan";
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
    <?php include '../component/dosen/sidebar.php' ?>
    <div id="content">

      <div class="bg-white p-2 mt-4">
        <button type="button" class="btn btn-success my-2 " data-bs-toggle="modal"
          data-bs-target="#modalBimbinganMahasiswa">
          Tambah Mahasiswa Bimbingan <i class="ml-1 fas fa-plus"></i>
        </button>
        <table id="example" class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
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
  <div class="modal" id="modalBimbinganMahasiswa" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Masukan Nama Mahasiswa</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" class="w-100">
          <div class="modal-body">
            <div class="form-group w-100">
              <label>Nama Mahasiswa</label>
              <select name="mahasiswa" style="width: 100%;" id="mahasiswa" required></select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

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
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script>

  <!-- DataTables + Bootstrap 5 integration -->
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.min.js"></script>


  <!-- <script src="../../assets/js/RoleUser/journalanda.js"></script> -->
  <script>
    //Initialize Select2 Elements
    $('#mahasiswa').select2({
      theme: 'bootstrap-5',
      placeholder: "Pilih Mahasiswa",

      ajax: {
        url: '../../controller/bimbinganController.php?action=getMhs',
        dataType: 'json',
        delay: 250,
        data: function(params) {
          return {
            search: params.term
          };
        },
        processResults: function(data) {
          return {
            results: data
          };
        },
        cache: true,
        minimumInputLength: 1,
        theme: "bootstrap5",

      }
    });
    $(document).ready(function() {
      var t = $("#example").DataTable({
        ajax: "../../controller/datatableControllerMhsDosen.php",
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