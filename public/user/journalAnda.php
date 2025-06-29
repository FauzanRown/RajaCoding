<?php
session_start();
require_once '../../controller/journalController.php';
if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}
$successMsg = $_SESSION["success"] ?? null;
unset($_SESSION["success"], $_SESSION["error"]);
if (isset($_POST['delete'])) {
  if (hapus($_POST["hapus_id"]) > 0) {
    $_SESSION["success"] = "Journal Berhasil di Hapus ";
    $successMsg = $_SESSION["success"];
    header("Location: $currentUrl");
  } else {
    $_SESSION["error"] = "Journal Gagal di Hapus";
    $errorMsg = $_SESSION["error"];
    unset($_SESSION["error"]);
  }
}
// Validasi role dan kepemilikan jurnal
if ($_SESSION['role'] !== 'mahasiswa') {
  header("Location: ../403.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Journal Anda</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" />

  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.css" />
  <link rel="stylesheet" href="../../assets/css/dashboard.css" />
  <link rel="stylesheet" href="../../assets/fontawesome-free/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>



<body>
  <div class="container">
    <?php include '../component/user/sidebar.php' ?>
    <div id="content">
      <div class="searchBar">
        <form id="filter-form">

          <label>Cari Tanggal Jurnal : </label>
          <input id="filter-date" type="date" name="date" required />
        </form>
      </div>
      <div class="bg-white p-2 mt-4">

        <table id="example" class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Tanggal</th>
              <th>Status</th>
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

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.js"></script>
  <!-- jQuery (wajib untuk DataTables 2.x saat ini) -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    <?php if (!empty($successMsg)) : ?>
      toastr.success("<?= $successMsg ?>");

    <?php endif; ?>

    <?php if (!empty($errorMsg)) : ?>
      toastr.error("<?= $errorMsg ?>");


    <?php endif; ?>
  </script>
  <!-- DataTables + Bootstrap 5 integration -->
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.min.js"></script>
  <!-- <script src="../../assets/js/RoleUser/journalanda.js"></script> -->
  <script>
    $(document).ready(function() {
      var t = $("#example").DataTable({
        ajax: {
          url: "../../controller/datatableControllerJournal.php",
          type: "GET",
          data: function(d) {
            d.date = $('#filter-date').val(); // Kirim tanggal ke server
          }
        },
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
      $('#filter-form').on('change', function(e) {
        e.preventDefault();
        t.ajax.reload(); // reload DataTables saat user klik cari
      });
    });
  </script>
</body>

</html>