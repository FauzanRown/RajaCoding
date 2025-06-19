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
function getUser($idUser){
  $userData=query("SELECT name,role,image,email FROM user WHERE id = $idUser");
  return $userData;
}