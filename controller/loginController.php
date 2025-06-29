<?php
require 'function.php';
$errors = ['email' => '', 'password' => ''];

function login()
{
  global $errors;

  $email = $_POST['email'];
  $password = $_POST['password'];

  if (empty($email)) {
    $errors['email'] = "Email wajib diisi.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Format email tidak valid.";
  }

  // Ambil user berdasarkan email
  $result = query("SELECT * FROM user WHERE email = '$email'");

  if (count($result) === 1) {
    $user = $result[0];

    // Hanya lakukan validasi domain email jika BUKAN admin
    if ($user["role"] !== "admin" && !preg_match('/@(tif|webmail)\.uad\.ac\.id$/', $email)) {
      $errors['email'] = "Harus menggunakan email UAD";
      return;
    }

    if (password_verify($password, $user["password"])) {
      $_SESSION["login"] = true;
      $_SESSION["id"] = $user["id"];
      $_SESSION["role"] = $user["role"];

      // Redirect sesuai role
      if ($user["role"] === "mahasiswa") {
        header("Location: user/journalAnda.php");
        exit;
      } elseif ($user["role"] === "admin") {
        header("Location: admin/user.php");
        exit;
      } elseif ($user["role"] === "dosen") {
        header("Location: dosen/journalAnda.php");
        exit;
      }
    } else {
      $errors['password'] = "Password tidak valid";
    }
  } else {
    $errors['email'] = "Email tidak terdaftar.";
  }
}
