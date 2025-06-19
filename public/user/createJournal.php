<?php
session_start();
require '../../controller/journalController.php';
if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}
if (isset($_POST["submit"])) {
  if (create() > 0) {
    echo "
    <script>
      alert('Berhasil registrasi');
    </script>
    ";
  } else {
    echo mysqli_error($conn);
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

</head>

<body>
  <div class="container">
    <?php include '../component/user/sidebar.php' ?>

    <div id="content">
      <div class="form-container tambahin">
        <h1>TAMBAH JOURNAL</h1>
        <p>Kelola Semua Journal Anda</p>

        <form action="" method="post">
          <div class="form-group">
            <label>Judul</label>
            <input name="title" type="text" placeholder="Masukkan judul jurnal" />
          </div>

          <div class="form-group">
            <label>Tanggal</label>
            <div class="input-icon">
              <input type="date" name="date" />
              <span>📅</span>
            </div>
          </div>

          <div class="form-group">
            <label>Kategori</label>
            <select name="category" id="category"></select>
          </div>
          <label>Deskripsi</label>

          <textarea id="summernote" name="description"></textarea>

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
  <script>
    $('#category').select2({
      placeholder: "Pilih kategori",
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