<?php
session_start();
require_once '../../controller/journalController.php';
if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}
if ($_SESSION['role'] !== 'dosen') {
  header("Location: ../403.php");
  exit;
}
$successMsg = $_SESSION["success"] ?? null;
unset($_SESSION["success"], $_SESSION["error"]);
if (isset($_POST['submit'])) {
  if (update_dosen($_POST["update_id"]) > 0) {
    $_SESSION["success"] = "Journal Berhasil di Update ";
    $successMsg = $_SESSION["success"];
    header("Location: journalAnda.php");
  } else {
    $_SESSION["error"] = "Journal Gagal di Update";
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
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/2.3.1/css/dataTables.bootstrap5.css" />
  <link rel="stylesheet" href="../../assets/css/dashboard.css" />
  <link rel="stylesheet" href="../../assets/fontawesome-free/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>



<body>
  <div class="container">
    <?php include '../component/dosen/sidebar.php' ?>
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
              <th>Nama Mahasiswa</th>
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
              <th>Nama Mahasiswa</th>
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
  <!-- DataTables + Bootstrap 5 integration -->
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.1/js/dataTables.bootstrap5.min.js"></script>
  <!-- <script src="../../assets/js/RoleUser/journalanda.js"></script> -->
  <script>
    var id = new URLSearchParams(window.location.search).get("id");

    $(document).ready(function() {
      var t = $("#example").DataTable({
        ajax: {
          url: "../../controller/datatableControllerJournalDosen.php",
          type: "GET",
          data: function(d) {
            d.id = id; // kirim parameter id ke PHP
            d.date = $('#filter-date').val(); // Kirim tanggal ke server
          }
        },
        processing: true,
        serverSide: true,
        "columnDefs": [{
          "searchable": false,
          "orderable": false,
          "targets": 0
        }],
      });
      $('#filter-form').on('change', function(e) {
        e.preventDefault();
        t.ajax.reload(); // reload DataTables saat user klik cari
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
  <script>
    $(document).ready(function() {
      $('#example').on('click', '.update-status', function() {
        const jurnalId = $(this).data('document-id');
        const newStatus = $(this).val();

        $.ajax({
          url: '../../controller/journalController.php',
          method: 'POST',
          data: {
            id: jurnalId,
            status_update: newStatus
          },
          success: function(response) {
            // Bisa tampilkan notifikasi atau reload DataTable
            toastr.success('Status Berhasil diperbarui');

            $('#example').DataTable().ajax.reload(null, false); // reload tanpa reset pagination
          },
          error: function(xhr, status, error) {
            toastr.error("Status Gagal diperbarui");
          }
        });
      });
    });
  </script>



</body>

</html>