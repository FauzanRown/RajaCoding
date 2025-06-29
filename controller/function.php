<?php
$config = parse_ini_file(__DIR__."/../config.ini",true);
// var_dump($config["database"]["hostname"]);
$conn = mysqli_connect(
$config["database"]["hostname"],
$config["database"]["username"],
$config["database"]["password"],
$config["database"]["database"],
);
function query($query){
global $conn;
$result = mysqli_query($conn,$query);
$rows = [];
// Jika hasil query tidak mengembalikan baris, maka:
// mysqli_fetch_assoc($result) langsung mengembalikan false.

while($row = mysqli_fetch_assoc($result)){
$rows[] = $row;
}
return $rows;
}
// function getUser($idUser){
//   $userData=query("SELECT name,role,image,email FROM user WHERE id = $idUser");
//   return $userData;
// }
function getUser($idUser)
{
  global $conn;

  // Ambil data user
  $userData = query("SELECT name, role, image, email FROM user WHERE id = $idUser");

  if (!$userData) {
    return null;
  }

  // $userData = $userData[0]; // karena hasil query berupa array banyak, ambil satu

  // Jika user adalah mahasiswa, tambahkan data dosen pembimbing
  if ($userData[0]['role'] === 'mahasiswa') {
    $stmt = $conn->prepare("
      SELECT u.name AS dosen_name, u.email AS dosen_email 
      FROM pembimbing p 
      JOIN user u ON p.dosen_id = u.id 
      WHERE p.mahasiswa_id = ?
    ");
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();
    $dosen = $result->fetch_assoc();
    $stmt->close();

    // Tambahkan ke array user jika dosen ditemukan
    if ($dosen) {
      $userData[0]['dosen_name'] = $dosen['dosen_name'];
      $userData[0]['dosen_email'] = $dosen['dosen_email'];
    } else {
      $userData[0]['dosen_name'] = null;
      $userData[0]['dosen_email'] = null;
    }
  }


  return $userData;
}
