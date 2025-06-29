<?php
require_once 'function.php';

// function getCategory($search)
// {
//   global $conn;

//   $query = $conn->prepare("SELECT id, name FROM category WHERE name LIKE CONCAT('%', ?, '%') LIMIT 20");
//   $query->bind_param("s", $search);
//   $query->execute();
//   $result = $query->get_result();

//   $data = [];
//   while ($row = $result->fetch_assoc()) {
//     $data[] = [
//       "id" => $row['name'],
//       "text" => $row['name'] ,
//     ];
//   }
//   $query->close();

//   return $data;
// }
// $action = $_GET['action'] ?? '';

// if ($action === 'getCategory') {
//   $search = $_GET['search'] ?? '';
//   echo json_encode(getCategory($search));
// }
function tambahCategory()
{
  global $conn;

  // Ambil nama kategori dari form
  $category_name = strtolower( $_POST["kategori"]);

  // Cek apakah kategori sudah ada
  $cek = $conn->prepare("SELECT id FROM category WHERE LOWER(name) = LOWER(?)");
  $cek->bind_param("s", $category_name);
  $cek->execute();
  $cek->store_result();

  if ($cek->num_rows > 0) {
    $cek->close();
    return 0;
  }

  $cek->close();

  // Tambahkan kategori baru
  $stmt = $conn->prepare("INSERT INTO category (name, created_at) VALUES (?, NOW())");
  $stmt->bind_param("s", $category_name);

  if ($stmt->execute()) {
    $stmt->close();
    return 1; // berhasil
  } else {
    $stmt->close();
    return 0; // gagal
  }
}

function hapusCategory()
{
  global $conn;

  $category_id = $_POST["hapus_id"];

  // Cek apakah kategori sedang digunakan di tabel jurnal
  $cek = $conn->prepare("SELECT id FROM jurnal WHERE category_id = ?");
  $cek->bind_param("i", $category_id);
  $cek->execute();
  $cek->store_result();

  if ($cek->num_rows > 0) {
    $cek->close();
    return "Kategori tidak dapat dihapus karena sedang digunakan.";
  }

  $cek->close();

  // Hapus kategori dari tabel
  $stmt = $conn->prepare("DELETE FROM category WHERE id = ?");
  $stmt->bind_param("i", $category_id);

  if ($stmt->execute()) {
    $stmt->close();
    return "Kategori berhasil dihapus.";
  } else {
    $stmt->close();
    return "Gagal menghapus kategori.";
  }
}
function editCategory()
{
  global $conn;

  // Ambil data dari form
  $category_id = $_POST['edit_id'];
  $new_category_name = strtolower(trim($_POST['kategori']));

  // Validasi: nama kategori tidak boleh kosong
  if (empty($new_category_name)) {
    return "Nama kategori tidak boleh kosong.";
  }

  // Cek apakah nama kategori yang sama sudah ada (kecuali dirinya sendiri)
  $cek = $conn->prepare("SELECT id FROM category WHERE LOWER(name) = LOWER(?) AND id != ?");
  $cek->bind_param("si", $new_category_name, $category_id);
  $cek->execute();
  $cek->store_result();

  if ($cek->num_rows > 0) {
    $cek->close();
    return "Kategori dengan nama ini sudah ada.";
  }

  $cek->close();
  $new_category_name = ucfirst($new_category_name);
  // Update nama kategori
  $stmt = $conn->prepare("UPDATE category SET name = ? WHERE id = ?");
  $stmt->bind_param("si", $new_category_name, $category_id);

  if ($stmt->execute()) {
    $stmt->close();
    return 1; // berhasil
  } else {
    $stmt->close();
    return "Gagal mengubah kategori.";
  }
}
