<?php
require 'function.php';
$errors = ['name' => '', 'email' => '', 'img' => '', 'file' => '', 'password' => '', 'confirm_password' => '', 'role' => ''];

function update($id)
{
  global $conn, $errors;
  $data = $_POST;

  $name = htmlspecialchars($data["name"]);
  $email = htmlspecialchars($data["email"]);
  $gambarLama = htmlspecialchars($data["gambarLama"]);

  if (empty($name)) {
    $errors['name'] = "Nama wajib diisi.";
  }

  $userLama = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM user WHERE id = $id"));
  $emailLama = $userLama['email'];

  if (empty($email)) {
    $errors['email'] = "Email wajib diisi.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "Format email tidak valid.";
  } elseif ($email !== $emailLama) {
    $cekEmail = mysqli_query($conn, "SELECT id FROM user WHERE email = '$email' AND id != $id");
    if (mysqli_num_rows($cekEmail) > 0) {
      $errors['email'] = "Email sudah terdaftar oleh pengguna lain.";
    }
  }

  if (array_key_exists("password", $data) && ($data["password"] !== '' || $data["confirm_password"] !== '')) {
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["confirm_password"]);

    if (empty($password)) {
      $errors['password'] = "Password wajib di isi.";
    } elseif (strlen($password) < 8) {
      $errors["password"] = "Password minimal 8 karakter.";
    } elseif ($password !== $password2) {
      $errors["confirm_password"] = "Konfirmasi password tidak valid.";
    }
  }

  $gambar = $gambarLama;
  if ($_FILES['img']['error'] !== 4) {
    $uploadResult = upload();
    if (isset($uploadResult['error'])) {
      $errors['gambar'] = $uploadResult['error'];
    } else {
      if (file_exists('../images/' . $gambarLama)) {
        unlink('../images/' . $gambarLama);
      }
      $gambar = $uploadResult['filename'];
    }
  }

  if (!array_filter($errors)) {
    $query = "UPDATE user SET name = '$name', email = '$email', image = '$gambar'";

    if (!empty($password)) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $query .= ", password = '$hashedPassword'";
    }

    $query .= " WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
  }

  return 0;
}



function upload()
{
  $namaFile = $_FILES['img']['name'];
  $ukuranFile = $_FILES['img']['size'];
  $error = $_FILES['img']['error'];
  $tmpName = $_FILES['img']['tmp_name'];

  $ekstensiValid = ['jpg', 'jpeg', 'png'];
  $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

  if (!in_array($ekstensiGambar, $ekstensiValid)) {
    return ['error' => "Format gambar harus JPG, JPEG, atau PNG."];
  }

  if ($ukuranFile > (20 * 1024 * 1024)) {
    return ['error' => "Ukuran file maksimal adalah 20 MB."];
  }

  $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
  $uploadPath = '../images/' . $namaFileBaru;

  if (!move_uploaded_file($tmpName, $uploadPath)) {
    return ['error' => "Gagal mengupload gambar."];
  }

  return ['filename' => $namaFileBaru];
}

function deleteUser($id)
{
  global $conn;

  // Ambil data user untuk mengetahui gambar
  $result = mysqli_query($conn, "SELECT image FROM user WHERE id = $id");
  $user = mysqli_fetch_assoc($result);

  // Hapus gambar jika bukan default
  if ($user && isset($user['image']) && $user['image'] !== 'default.jpg') {
    $imagePath = '../images/' . $user['image'];
    if (file_exists($imagePath)) {
      unlink($imagePath);
    }
  }

  // Hapus user dari database
  $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    $stmt->close();
    return 1; // sukses
  } else {
    $stmt->close();
    return 0; // gagal
  }
}
function createUser()
{
  global $conn;
  global $errors;


  $data = $_POST;
  $name = htmlspecialchars(trim($data['name']));
  $email = htmlspecialchars(trim($data['email']));
  $role = isset($data['role']) ? $data['role'] : '';
  $password = mysqli_real_escape_string($conn, $data['password']);
  $password2 = mysqli_real_escape_string($conn, $data['confirm_password']);

  // Validasi Nama
  if (empty($name)) {
    $errors['name'] = 'Nama wajib diisi.';
  }

  // Validasi Email
  if (empty($email)) {
    $errors['email'] = 'Email wajib diisi.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Format email tidak valid.';
  } elseif (mysqli_num_rows(mysqli_query($conn, "SELECT id FROM user WHERE email = '$email'")) > 0) {
    $errors['email'] = 'Email sudah terdaftar.';
  }

  // Validasi Role
  if (empty($role) || !in_array($role, ['admin', 'mahasiswa', 'dosen'])) {
    $errors['role'] = 'Role wajib dipilih (admin, mahasiswa, dosen).';
  }

  // Validasi Password
  if (empty($password)) {
    $errors['password'] = 'Password wajib diisi.';
  } elseif (strlen($password) < 8) {
    $errors['password'] = 'Password minimal 8 karakter.';
  }

  if (empty($password2)) {
    $errors['confirm_password'] = 'Konfirmasi password wajib diisi.';
  } elseif ($password !== $password2) {
    $errors['confirm_password'] = 'Konfirmasi password tidak sama.';
  }

  // Upload gambar
  $gambar = '';
  if ($_FILES['img']['error'] === 4) {
    $gambar = 'user.png'; // Gambar default
  } else {
    $upload = upload();
    if (isset($upload['error'])) {
      $errors['img'] = $upload['error'];
    } else {
      $gambar = $upload['filename'];
    }
  }

  // Jika tidak ada error
  if (!array_filter($errors)) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO user (name, email, password, role, image, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssss", $name, $email, $passwordHash, $role, $gambar);
    if ($stmt->execute()) {
      $stmt->close();
      return 1; // sukses
    } else {
      $stmt->close();
      return 0; // gagal
    }
  }

  return $errors;
}
function updateUser($id)
{
  global $conn;
  global $errors;

  $data = $_POST;
  $name = htmlspecialchars(trim($data['name']));
  $email = htmlspecialchars(trim($data['email']));
  $role = isset($data['role']) ? $data['role'] : '';
  $password = mysqli_real_escape_string($conn, $data['password']);
  $password2 = mysqli_real_escape_string($conn, $data['confirm_password']);
  $gambarLama = $data['gambarLama'];

  // Validasi Nama
  if (empty($name)) {
    $errors['name'] = 'Nama wajib diisi.';
  }

  // Ambil email lama dari database
  $userLama = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM user WHERE id = $id"));
  $emailLama = $userLama['email'];

  // Validasi Email
  if (empty($email)) {
    $errors['email'] = 'Email wajib diisi.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Format email tidak valid.';
  } elseif ($email !== $emailLama) {
    $cekEmail = mysqli_query($conn, "SELECT id FROM user WHERE email = '$email' AND id != $id");
    if (mysqli_num_rows($cekEmail) > 0) {
      $errors['email'] = 'Email sudah digunakan oleh user lain.';
    }
  }

  // Validasi Role
  if (empty($role) || !in_array($role, ['admin', 'mahasiswa', 'dosen'])) {
    $errors['role'] = 'Role wajib dipilih (admin, mahasiswa, dosen).';
  }

  // Validasi Password (jika diisi)
  $updatePassword = false;
  if (!empty($password) || !empty($password2)) {
    $updatePassword = true;
    if (empty($password)) {
      $errors['password'] = 'Password wajib diisi.';
    } elseif (strlen($password) < 8) {
      $errors['password'] = 'Password minimal 8 karakter.';
    }

    if (empty($password2)) {
      $errors['confirm_password'] = 'Konfirmasi password wajib diisi.';
    } elseif ($password !== $password2) {
      $errors['confirm_password'] = 'Konfirmasi password tidak sama.';
    }
  }

  // Upload Gambar
  $gambar = $gambarLama;
  if ($_FILES['img']['error'] !== 4) {
    $upload = upload();
    if (isset($upload['error'])) {
      $errors['img'] = $upload['error'];
    } else {
      // Hapus gambar lama jika bukan default
      if ($gambarLama !== 'user.png' && file_exists('../images/' . $gambarLama)) {
        unlink('../images/' . $gambarLama);
      }
      $gambar = $upload['filename'];
    }
  }

  // Jika tidak ada error
  if (!array_filter($errors)) {
    if ($updatePassword) {
      $passwordHash = password_hash($password, PASSWORD_DEFAULT);
      $query = "UPDATE user SET name=?, email=?, password=?, role=?, image=? WHERE id=?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("sssssi", $name, $email, $passwordHash, $role, $gambar, $id);
    } else {
      $query = "UPDATE user SET name=?, email=?, role=?, image=? WHERE id=?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ssssi", $name, $email, $role, $gambar, $id);
    }

    if ($stmt->execute()) {
      $stmt->close();
      return 1; // sukses
    } else {
      $stmt->close();
      return 0; // gagal
    }
  }

  return $errors;
}
