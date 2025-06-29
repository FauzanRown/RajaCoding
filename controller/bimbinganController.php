<?php
require_once 'function.php';

function getMhs($search)
{
  global $conn;

  $query = $conn->prepare("SELECT id, name,email FROM user WHERE name LIKE CONCAT('%', ?, '%') LIMIT 20");
  $query->bind_param("s", $search);
  $query->execute();
  $result = $query->get_result();

  $data = [];
  while ($row = $result->fetch_assoc()) {
    $data[] = [
      "id" => $row['id'],
      "text" => $row['name'] . ' - ' . $row['email'],
    ];
  }
  $query->close();

  return $data;
}
$action = $_GET['action'] ?? '';

if ($action === 'getMhs') {
  $search = $_GET['search'] ?? '';
  echo json_encode(getMhs($search));
}
function tambahMhsBimbingan()
{
  global $conn;
  $dosen_id = $_SESSION["id"]; // id dosen yang login
  $mahasiswa_id = $_POST["mahasiswa"];
  // Cek apakah mahasiswa sudah memiliki pembimbing
  $cek = $conn->prepare("SELECT id FROM pembimbing WHERE mahasiswa_id = ?");
  $cek->bind_param("i", $mahasiswa_id);
  $cek->execute();
  $cek->store_result();

  if ($cek->num_rows > 0) {
    return "Mahasiswa sudah memiliki pembimbing.";
  }

  $cek->close();

  // Tambahkan ke tabel pembimbing
  $stmt = $conn->prepare("INSERT INTO pembimbing (mahasiswa_id, dosen_id, created_at) VALUES (?, ?, NOW())");
  $stmt->bind_param("ii", $mahasiswa_id, $dosen_id);

  if ($stmt->execute()) {
    $stmt->close();
    return 1;
  } else {
    $stmt->close();
    return 0;
  }
  
}
function hapusMhsBimbingan()
{
  global $conn;
  $dosen_id = $_SESSION["id"]; // id dosen yang login
  $mahasiswa_id = $_POST["hapus_id"];
  // Hapus relasi mahasiswa dan dosen dari tabel pembimbing
  $stmt = $conn->prepare("DELETE FROM pembimbing WHERE dosen_id = ? AND mahasiswa_id = ?");
  $stmt->bind_param("ii", $dosen_id, $mahasiswa_id);

  if ($stmt->execute()) {
    $stmt->close();
    return 1;
  } else {
    $stmt->close();
    return 0;
  }
}
?>
