<?php
require '../controller/loginController.php';
session_start();
if (isset($_POST['login'])) {
  login();
}
if (isset($_SESSION["login"]) && $_SESSION["role"] == "mahasiswa") {
  header("Location: user/journalAnda.php");
  exit;
} else if (isset($_SESSION["login"]) && $_SESSION["role"] == "admin") {
  header("Location: admin/user.php");
  exit;
} else if (isset($_SESSION["login"]) && $_SESSION["role"] == "dosen") {
  header("Location: dosen/journalAnda.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register Page</title>
  <link rel="stylesheet" href="../assets/css/loginstyle.css" />
</head>

<body>
  <div class="container">
    <div class="content">
      <div>
        <h1>Login</h1>
        <hr />
        <p>Masukan Email dan Password Anda</p>

        <form action="" method="post">
          <input type="email" placeholder="Email" name="email"/>
          <span style="color:red;"><?= $errors['email'] ?></span><br>
          <input type="password" placeholder="Password" name="password" />
          <span style="color:red;"><?= $errors['password'] ?></span><br>
          <button type="submit" name="login">Login</button>
          <p>
            Belum Punya Akun? <a href="register.php">Klik Disini</a>
          </p>
        </form>
      </div>

      <div>
        <img src="../assets/img/Login Image.png" alt="" />
      </div>
    </div>
    <p class="copyright">
      All Rights Reserved • Copyright StudentLogbook by RajaCoding 2025 in
      Yogyakarta
    </p>
  </div>
</body>

</html>