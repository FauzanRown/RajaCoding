<?php
require 'function.php';
$errors = ['name' => '', 'email' => '', 'img' => '', 'file' => '', 'password' => '', 'confirm_password' => ''];
function register()
{
  global $errors;

  $data = $_POST;
  global $conn;
  // menghilangkan strip di string
  $name = htmlspecialchars(string: $data["name"]);
  $email =  htmlspecialchars($data["email"]);

  // memungkinkan user untuk memasukan tanda kutip ke syntax mysql
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["confirm_password"]);
  // cek name udah ada atau belum
  // validasi user
  if (empty($name)) {
    $errors['name'] = "Nama wajib diisi.";
  } 
  $result = query("SELECT email FROM user WHERE email = '$email'");

  // Validasi Email
  if (empty($email)) {
    $errors['email'] = "Email wajib diisi.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Format email tidak valid.";
  } elseif(count($result) > 0){
    $errors["email"] = "Email sudah terdaftar";
  }else {
    if (substr($email, -14) === '@tif.uad.ac.id') {
      $role = 'dosen';
    } elseif (substr($email, -18) === '@webmail.uad.ac.id') {
      $role = 'mahasiswa';
    } else {
      $errors['email'] = "Harus menggunakan email UAD";
    }
  }

    // validasi password
    if (empty($password) || empty($password2)) {
    (empty($password)) ? $errors['password'] = "Password wajib di isi." : $errors['confirm_password'] = "Konfirmasi Password wajib di isi.";
  } else if (strlen($password) < 8) {
    $errors["password"] = "password minimal 8 karakter";
  } else if ($password !== $password2) {
    $errors["confirm_password"] = "Konfirmasi password tidak valid";
  }
  $namaFile = $_FILES['img']['name'];
  $ukuranFile = $_FILES['img']['size'];
  $error = $_FILES['img']['error'];
  $tmpName = $_FILES['img']['tmp_name'];
  // cek apakah tidak ada gambar yang di upload
  $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
  if ($error == 4) {
    $errors['gambar'] = "Gambar wajib diupload.";
  } elseif (!in_array($ekstensiGambar, ['jpg', 'jpeg', 'png'])) {
    $errors['gambar'] = "Format gambar harus JPG, JPEG, atau PNG.";
  } elseif ($ukuranFile > (20 * 1024 * 1024)) {
    $errors['gambar'] = "Ukuran file maksimal adalah 20 MB.";
  }
  if (!array_filter($errors)) {
    $gambar = upload();
    $created_at = date('Y-m-d H:i:s');
    // enkripsi password
    // PASSWORD APA YANG MAU DI HASH , ALGORITMA APA YANG DIGUNAKANK
    $password = password_hash($password, PASSWORD_DEFAULT); //bcrypt algorithm
    // tambahkan userbaru ke database
    $query = "INSERT INTO user VALUES(NULL,'$name','$email','$password','$role','$gambar','$created_at');";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
  } else {
    return false;
  }
}
function upload()
{

  global $errors;

  $namaFile = $_FILES['img']['name'];
  $ukuranFile = $_FILES['img']['size'];
  $error = $_FILES['img']['error'];
  $tmpName = $_FILES['img']['tmp_name'];
  // cek apakah tidak ada gambar yang di upload
  $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
  if ($error == 4) {
    $errors['gambar'] = "Gambar wajib diupload.";
  } elseif (!in_array($ekstensiGambar, ['jpg', 'jpeg', 'png'])) {
    $errors['gambar'] = "Format gambar harus JPG, JPEG, atau PNG.";
  } elseif ($ukuranFile > (20 * 1024 * 1024)) {
    $errors['gambar'] = "Ukuran file maksimal adalah 20 MB.";
  }
  $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
  move_uploaded_file($tmpName, '../public/images/' . $namaFileBaru);
  return $namaFileBaru;
}
