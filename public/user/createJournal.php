<?php
session_start();
require '../../controller/journalController.php';
if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}
// Validasi role dan kepemilikan jurnal
if ($_SESSION['role'] !== 'mahasiswa') {
  header("Location: ../403.php");
  exit;
}


if (isset($_POST["submit"])) {
  if (create() > 0) {
    $_SESSION["success"] = "Berhasil Tambah Journal";
    $successMsg = $_SESSION["success"];
    unset($_SESSION["success"]);
  } else {
    $_SESSION["error"] = "Gagal Tambah Journal";
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
  <title>Dashboard | Tambah Journal</title>
  <link rel="stylesheet" href="../../assets/css/dashboard.css" />
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

  <link
    href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css"
    rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
  <!-- Select2 CSS & JS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>
  <div class="container">
    <?php include '../component/user/sidebar.php' ?>

    <div id="content">
      <div class="form-container tambahin">
        <h1>TAMBAH JOURNAL</h1>
        <p class="text-center">Kelola Semua Journal Anda</p>

        <form action="" method="post">
          <div class="form-group">
            <label>Judul</label>
            <input name="title" type="text" placeholder="Masukkan judul jurnal" required />
          </div>

          <div class="form-group">
            <label>Tanggal</label>
            <div class="input-icon">
              <input type="date" name="date" required />
              <span>📅</span>
            </div>
          </div>

          <div class="form-group">
            <label>Kategori</label>
            <select name="category" id="category" required></select>
          </div>
          <label>Deskripsi</label>
          <div class="summernote-custom" style="text-align: left;">
            <textarea id="summernote" name="description" required></textarea>
          </div>
          <div class="submit-button">
            <button type="submit" name="submit">Submit</button>
          </div>
        </form>
      </div>
      <p class="copyright">
        All Rights Reserved • Copyright StudentLogbook by RajaCoding 2025 in
        Yogyakarta
      </p>
    </div>
  </div>

  <script src="../../assets/js/RoleUser/tambahjournal.js"></script>

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

  <script>
    $('#category').select2({
      placeholder: "Pilih Kategori",
      ajax: {
        url: '../../controller/journalController.php?action=getCategories',
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
        placeholder: 'Search for a user...',
        minimumInputLength: 1

      }
    });
  </script>

</body>


</html>