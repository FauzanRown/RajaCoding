<?php
require '../controller/registerController.php';
if (isset($_POST["register"])) {
  if (register() > 0) {
    echo "
    <script>
      alert('Berhasil registrasi');
    </script>
    ";
    header("Location: login.php");
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
  <title>Register Page</title>
  <link rel="stylesheet" href="../assets/css/loginstyle.css" />
</head>

<body>
  <div class="container">
    <div class="back-link">
      <a href="index.php">← Back</a>
    </div>
    <div class="content">
      <div>
        <h1>Register</h1>
        <hr />
        <p>Masukan Username dan Password Anda</p>

        <form action="" method="post" enctype="multipart/form-data">
          <input type="text" placeholder="Username" name="name" required />
          <span style="color:red;"><?= $errors['name'] ?></span><br>
          <input type="email" placeholder="Email" name="email" required />
          <span style="color:red;"><?= $errors['email'] ?></span><br>
          <input type="password" placeholder="Password" name="password" required />
          <span style="color:red;"><?= $errors['password'] ?></span><br>
          <input type="password" placeholder="Confirm Password" name="confirm_password" required />
          <span style="color:red;"><?= $errors['confirm_password'] ?></span><br>
          <button type="submit" name="register">Daftar</button>
          <p>Sudah Punya Akun? <a href="login.php">Masuk</a></p>
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