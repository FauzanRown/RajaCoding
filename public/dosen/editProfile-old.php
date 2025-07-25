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
require_once '../../controller/userController.php';
if (isset($_POST["submit"])) {
  if (update($_SESSION["id"]) > 0) {
    echo "
    <script>
      alert('Data berhasil di hapus');
    </script>
    ";
  } else {
    echo "
    <script>
      alert('Data gagal di hapus');
    </script>
    ";
  }
  header("Location: editProfile.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Edit Profile</title>
  <link rel="stylesheet" href="../../assets/css/dashboard.css" />
</head>

<body>
  <div class="container">
    <?php include '../component/dosen/sidebar.php' ?>
    <div id="content">
      <div class="form-container">
        <h1>EDIT PROFILE</h1>
        <p>Perbarui Profile Anda</p>
        <form method="post" action="" enctype="multipart/form-data">
          <input type="hidden" value="<?= $userData["image"] ?>" name="gambarLama" />

          <div class="form-flex">
            <div class="form-group">
              <label for="name">Nama</label>
             <input type="text" required placeholder="Masukkan Nama Anda" name="name" id="name" value="<?= $userData["name"] ?>" />
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" required placeholder="Masukkan Email Anda" name="email" id="email" value="<?= $userData["email"] ?>" />
            </div>
          </div>
          <label for="img">Foto Profile</label>
          <input type="file" name="img" id="img" />
          <div class="submit-button">
            <button type="submit" name="submit">Update</button>
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
</body>

</html>