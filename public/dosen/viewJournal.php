<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: ../login.php");
  exit;
}
if ($_SESSION['role'] !== 'dosen') {
  header("Location: ../403.php");
  exit;
}
require_once '../../controller/journalController.php';
if (isset($_GET["id"])) {
  $data = view($_GET["id"]);
} else {
  header("Location: journalAnda.php");
  exit;
}
$idUser = $_SESSION['id'];
$idJurnal = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Cek apakah jurnal dimiliki oleh mahasiswa tersebut
$cek = mysqli_query($conn, "SELECT j.id 
  FROM jurnal j
  JOIN pembimbing p ON j.pembimbing_id = p.id
  WHERE j.id = $idJurnal AND p.dosen_id = $idUser
");

if (mysqli_num_rows($cek) === 0) {
  // Tidak ditemukan atau bukan milik user
  header("Location: ../403.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../assets/css/dashboard.css" />

</head>

<body>
  <div class="container">
    <?php include '../component/dosen/sidebar.php' ?>
    <div id="content">
      <div class="form-container">
        <h1><?= $data["title"] ?></h1>
        <p class="text-center">Kelola Semua Journal Anda</p>
        <div class="form-flex">
          <div class="form-group">
            <label>Nama Mahasiswa:</label>
            <p><?= $data["mahasiswa_name"] ?></p>
          </div>
          <div class="form-group">
            <label>Nama Dosen:</label>
            <p><?= $data["dosen_name"] ?></p>
          </div>
        </div>
        <div class="form-flex">
          <div class="form-group">
            <label>Nama Jurnal:</label>
            <p><?= $data["title"] ?></p>
          </div>
          <div class="form-group">
            <label>Tanggal :</label>
            <p><?= $data["date_format"] ?></p>
          </div>
        </div>
        <div class="form-flex">
          <div class="form-group">
            <label>Kategori :</label>
            <p><?= $data["category"] ?></p>
          </div>
          <div class="form-group">
            <label>Status :</label>
            <?php
            if ($data["status"] == "Valid") {
              echo '<p class="btn btn-success text-white">' . $data["status"] . '</p>';
            } else if ($data["status"] == "Tidak Valid") {
              echo '<p class="btn btn-danger text-white">' . $data["status"] . '</p>';
            } else if ($data["status"] == "Belum Di Review") {
              echo '<p class="btn btn-secondary text-white">' . $data["status"] . '</p>';
            }
            ?>
          </div>
        </div>
        <div class="form-flex">
          <div class="form-group">
            <label>Revisi :</label>
            <?php
            if (empty($data["revision"])) {
              echo "<p>-</p>";
            } else {
              echo "<p>" . $data["revision"] . "</p>";
            }
            ?>
          </div>
        </div>
        <div class="form-flex">
          <div class="form-group">
            <label>Catatan :</label>
            <?php
            echo $data["note"];
            ?>
          </div>
        </div>
      </div>

      <p class="copyright">
        All Rights Reserved • Copyright StudentLogbook by RajaCoding 2025 in
        Yogyakarta
      </p>
    </div>
  </div>

  <script src="../../assets/js/RoleUser/tambahjournal.js"></script>

</body>

</html>