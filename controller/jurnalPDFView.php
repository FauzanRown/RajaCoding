<?php

require_once 'journalController.php';
  $data = view($_GET["id"]);


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
  <link rel="stylesheet" href="../assets/css/dashboard.css" />


</head>

<body style="background-color: white;">
  <div class="container " style="background-color: white;">
    <div id="content" style="background-color: white;">
      <div class="form-container">
        <h1><?= $data["title"] ?></h1>
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
              echo '<p>' . $data["status"] . '</p>';
            } else if ($data["status"] == "Tidak Valid") {
              echo '<p>' . $data["status"] . '</p>';
            } else if ($data["status"] == "Belum Di Review") {
              echo '<p>' . $data["status"] . '</p>';
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
          <div class="form-group">
            <label>Catatan :</label>
            <?php
            echo $data["note"];
            ?>
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