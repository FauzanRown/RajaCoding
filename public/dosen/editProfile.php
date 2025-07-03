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
$successMsg = $_SESSION["success"] ?? null;
unset($_SESSION["success"], $_SESSION["error"]);
if (isset($_POST["submit"])) {
  if (update($_SESSION["id"]) > 0) {
    $_SESSION["success"] = "Profile Berhasil di Update ";
    $successMsg = $_SESSION["success"];
    header("Location: editProfile.php");
  } else {
    $_SESSION["error"] = "Profil Gagal di Update";
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
  <title>Dashboard | Edit Profile</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../../assets/css/dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>
  <div class="container">
    <?php include '../component/dosen/sidebar.php' ?>
    <div id="content">
      <div class="form-container  ">
        <h1>PROFILE</h1>
        <img class="text-center mx-auto rounded-circle" style="width: 128px; display:block" src="<?= $userData['image'] == "user.png" ? "../../assets/img/user.png" : "../images/" . $userData['image'] ?>" alt="" />
        <div class="form-container">
          <div class="form-flex">
            <div class="form-group">
              <label>Nama :</label>
              <p class=" text-start"><?= $userData["name"] ?></p>
            </div>
            <div class="form-group">
              <label>Email :</label>
              <p class=" text-start"><?= $userData["email"] ?></p>
            </div>
          </div>
          <hr>
          <h1 class="text-start mb-2">Update Profile : </h1>
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
            <input type="file" class=" form-control" name="img" id="img" />
            <div class="submit-button ">
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
</body>

</html>