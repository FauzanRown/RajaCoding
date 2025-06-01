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
  }else if (substr($email, -14) !== '@tif.uad.ac.id' || substr($email, -18) !== '@webmail.uad.ac.id') {
    $errors['email'] = "Harus menggunakan email UAD";
  }
    
  $result = query("SELECT * FROM user WHERE email = '$email' ");
  if (count($result)==1) {
    if (password_verify($password,$result[0]["password"])) {
      $_SESSION["login"] = true;
      header("Location: index.php");
    }else{
      $errors['password'] = "Password tidak valid";
    }
  }
}