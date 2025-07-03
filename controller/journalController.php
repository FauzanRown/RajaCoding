<?php

require 'function.php';
$errors = ['title' => '', 'date' => '', 'category' => '', 'description' => ''];

function create()
{
  global $conn;
  global $errors;
  // $stmt = $conn->prepare("INSERT INTO users (nama, email) VALUES (?, ?)");
  // $stmt->bind_param("ss", $nama, $email);
  $data = $_POST;
  // var_dump($_POST);
  $title = htmlspecialchars($data["title"]);
  $date = htmlspecialchars($data["date"]);
  $category = htmlspecialchars($data["category"] ?? "") ;
  $description =  $data["description"];
  empty($title) ? $errors["title"] = "Judul Jurnal Wajib di isi" : "";
  empty($date) ? $errors["date"] = "Tanggal Jurnal Wajib di isi" : "";
  empty($category) ? $errors["category"] = "Kategori Jurnal Wajib di isi" : "";
  empty($description) ? $errors["description"] = "Deskripsi Jurnal Wajib di isi" : "";
  if (!array_filter($errors)) {
    $idUser = $_SESSION['id'];
    $idPembimbing = query("SELECT id FROM pembimbing where mahasiswa_id = $idUser")[0]["id"];
    $stmt = $conn->prepare("INSERT INTO jurnal (id,pembimbing_id, category_id, title, note, revision, status, date, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $revision = "";
    $status = 'belum di review';
    $id = null;
    $createdAt = date('Y-m-d H:i:s');
    $stmt->bind_param("iiissssss", $id, $idPembimbing, $category, $title, $description, $revision, $status, $date, $createdAt);
    if ($stmt->execute()) {
      $stmt->close();
      return true;
      // redirect atau aksi lanjutan
    } else {
      $stmt->close();
      return false;
    }
  }
}
function update($id){
  global $conn;
  global $errors;
  $data = $_POST;
  $title = htmlspecialchars($data["title"]);
  $date = htmlspecialchars($data["date"]);
  $category = htmlspecialchars($data["category"]);
  $description =  $data["description"];
  empty($title) ? $errors["title"] = "Judul Jurnal Wajib di isi" : "";
  empty($date) ? $errors["date"] = "Tanggal Jurnal Wajib di isi" : "";
  empty($category) ? $errors["category"] = "Kategori Jurnal Wajib di isi" : "";
  empty($description) ? $errors["description"] = "Deskripsi Jurnal Wajib di isi" : "";
  if (!array_filter($errors)) {
    $query = "UPDATE jurnal SET 
    title = '$title',
    date = '$date',
    category_id = '$category',
    note = '$description' where id = $id;
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
  }
  $errors = ['title' => '', 'date' => '', 'category' => '', 'description' => ''];
}
function update_dosen($id){
  global $conn;
  global $errors;
  $data = $_POST;
  $revision = htmlspecialchars($data["revisi"]);
  $status = htmlspecialchars($data["status"]);
  empty($status) ? $status["status"] = "Status Jurnal Wajib di isi" : "";
  if (!array_filter($errors)) {
    $query = "UPDATE jurnal SET 
    revision = '$revision',
    status = '$status'
     where id = $id;
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
  }
}
function getCategories($search)
{
  global $conn;

  $query = $conn->prepare("SELECT id, name FROM category WHERE name LIKE CONCAT('%', ?, '%') LIMIT 20");
  $query->bind_param("s", $search);
  $query->execute();
  $result = $query->get_result();

  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[] = [
      "id" => $row['id'],
      "text" => $row['name']
    ];
  }
  $query->close();

  return $data;
}
function hapus($id)
{
  global $conn;
  mysqli_query($conn, "DELETE FROM jurnal WHERE id = $id");
  return mysqli_affected_rows($conn);
}
// Routing berdasarkan parameter "action"
$action = $_GET['action'] ?? '';

if ($action === 'getCategories') {
  $search = $_GET['search'] ?? '';
  echo json_encode(getCategories($search));
}

function formatTanggalIndonesia($tanggal)
{
  $bulan = [
    1 => 'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  ];

  $pecah = explode('-', $tanggal);

  return (int)$pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
}
function view($id)
{
  global $conn;

  // Ambil data jurnal
  $journal = query("SELECT * FROM jurnal WHERE id = $id");
  if (empty($journal)) {
    return null;
  }

  $journal = $journal[0]; // karena query() mengembalikan array of array

  // Ambil nama kategori
  $category_id = $journal['category_id'];
  $category = query("SELECT name FROM category WHERE id = $category_id");

  // Ambil data pembimbing, termasuk nama mahasiswa dan dosen
  $stmt = $conn->prepare("
    SELECT 
      mahasiswa.name AS mahasiswa_name,
      dosen.name AS dosen_name
    FROM pembimbing
    JOIN user AS mahasiswa ON pembimbing.mahasiswa_id = mahasiswa.id
    JOIN user AS dosen ON pembimbing.dosen_id = dosen.id
    WHERE pembimbing.id = ?
  ");
  $stmt->bind_param("i", $journal['pembimbing_id']);
  $stmt->execute();
  $result = $stmt->get_result();
  $pembimbing = $result->fetch_assoc();
  $stmt->close();

  // Format data
  $journal['date_format'] = formatTanggalIndonesia($journal['date']);
  $journal['status'] = ucwords($journal['status']);
  $journal['category'] = $category[0]["name"] ?? '-';
  $journal['mahasiswa_name'] = $pembimbing['mahasiswa_name'] ?? '-';
  $journal['dosen_name'] = $pembimbing['dosen_name'] ?? '-';

  return $journal;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status_update'])) {

  updateStatus();
}

function updateStatus(){
  global $conn;

  $id = $_POST['id'];
  $status = $_POST['status_update'];

  // Validasi sederhana
  if (!in_array($status, ['valid', 'belum di review', 'tidak valid'])) {
    http_response_code(400);
    echo 'Status tidak valid';
    exit;
  }

  $stmt = $conn->prepare("UPDATE jurnal SET status = ? WHERE id = ?");
  $stmt->bind_param("si", $status, $id);
  if ($stmt->execute()) {
    echo "success";
  } else {
    http_response_code(500);
    echo "Gagal update status";
  }
  $stmt->close();
  $conn->close();
}