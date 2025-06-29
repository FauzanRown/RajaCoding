<?php
require 'function.php';

session_start();
if (!isset($_SESSION["id"])) {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit;
}
// require 'function.php';
// get user pembimbing
// DB table to use
$table = 'user';
// Table's primary key
$primaryKey = 'id';
$idUser = $_SESSION["id"];
$currentUser = getUser($idUser)[0];
if (!($currentUser["role"] == "dosen")) {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit;
}
$where = "id IN (
    SELECT mahasiswa_id 
    FROM pembimbing 
    WHERE dosen_id = 5
);";

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
  array('db' => 'id', 'dt' => 0,    'formatter' => function ($d, $row) {
    return null;
  }),
  array('db' => 'name', 'dt' => 1),
  array('db' => 'email', 'dt' => 2),
  // array( 'db' => 'office', 'dt' => 3 ),
  array('db' => 'id', 'dt' => 3,    'formatter' => function ($d, $row) {
    return
      '<div class="btn-group">    
      <a href="journalAnda.php?id=' . $d . '">
        <button type="button" class="btn btn-info">
        <i class="fas fa-eye text-white"></i>
        </button>
      </a>   
      <form method="post" action="">
            <input type="hidden" name="hapus_id" value="' . $d . '">
          <button type="submit" name="delete" class="btn btn-danger text-white">
          <i class="fas fa-trash "></i>
          </button>
        </form>
    </div>';
  }),


);

// SQL server connection information
$sql_details = array(
  'user' => $config["database"]["username"],
  'pass' => $config["database"]["password"],
  'db' => $config["database"]["database"],
  'host' => $config["database"]["hostname"]
  // ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* If you just want to use the basic configuration for DataTables with PHP
* server-side, there is no need to edit below this line.
*/

require('ssp.class.php');

// echo json_encode(
//   // SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns )
//   SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,null,$where)

// );
// Cek apakah user memiliki pembimbing
// if ($idPembimbing && isset($idPembimbing["id"])) {
  // $where = "pembimbing_id = " . intval($idPembimbing["id"]);

  echo json_encode(
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $where)
  );
// } else {
//   // User tidak punya pembimbing atau jurnal, kirimkan data kosong
//   echo json_encode([
//     "draw" => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
//     "recordsTotal" => 0,
//     "recordsFiltered" => 0,
//     "data" => []
//   ]);
// }
