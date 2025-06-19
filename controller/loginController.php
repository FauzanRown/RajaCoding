<?php
require 'function.php';
$errors = ['email'=>'', 'password'=>''];
function login (){
  global $errors;
  $email = $_POST['email'];
  $password = $_POST['password'];
   if (empty($email)) {
    $errors['email'] = "Email wajib diisi.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Format email tidak valid.";
  }else if (!preg_match('/@(tif|webmail)\.uad\.ac\.id$/', $email)) {
    $errors['email'] = "Harus menggunakan email UAD";
  }
    
  $result = query("SELECT * FROM user WHERE email = '$email' ");

  if (count($result)==1) {
    if (password_verify($password,$result[0]["password"])) {
      $_SESSION["login"] = true;
      $_SESSION["id"] = $result[0]["id"];
      header("Location: index.php");
    }else{
      $errors['password'] = "Password tidak valid";
    }
  }
}