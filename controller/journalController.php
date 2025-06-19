<?php   

require 'function.php';
$errors = ['title' => '', 'date' => '', 'category' => '', 'description' => ''];

function create(){
  global $conn;
  global $errors;
  // $stmt = $conn->prepare("INSERT INTO users (nama, email) VALUES (?, ?)");
  // $stmt->bind_param("ss", $nama, $email);
  $data = $_POST;
// var_dump($_POST);
  $title = htmlspecialchars($data["title"]);
  $date = htmlspecialchars($data["date"]);
  $category = htmlspecialchars($data["category"]);
  $description =  $data["description"];
  empty($title) ? $errors["title"] = "Judul Jurnal Wajib di isi" : "";
  empty($date) ? $errors["date"] = "Tanggal Jurnal Wajib di isi" : "";
  empty($category) ? $errors["category"] = "Kategori Jurnal Wajib di isi" : "";
  empty($description) ? $errors["description"] = "Deskripsi Jurnal Wajib di isi" : "";
  if (!array_filter($errors)) {
    $idUser = $_SESSION['id']; 
    $idPembimbing = query( "SELECT id FROM pembimbing where mahasiswa_id = $idUser")[0]["id"];
    var_dump($idPembimbing);
    $stmt = $conn->prepare("INSERT INTO jurnal (id,pembimbing_id, category_id, title, note, revision, status, date, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $revision = "";
    $status = 'belum di review';
    $id = null;
    $createdAt = date('Y-m-d H:i:s');
    $stmt->bind_param("iiissssss",$id ,$idPembimbing, $category, $title, $description, $revision, $status, $date, $createdAt);


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