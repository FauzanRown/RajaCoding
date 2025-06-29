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
$table = 'category';
// Table's primary key
$primaryKey = 'id';
$idUser = $_SESSION["id"];
$currentUser = getUser($idUser)[0];
if (!($currentUser["role"] == "dosen")) {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit;
}
$where = null;

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
  array('db' => 'id', 'dt' => 0,    'formatter' => function ($d, $row) {
    return null;
  }),
  array('db' => 'name', 'dt' => 1),
  // array( 'db' => 'office', 'dt' => 3 ),
  array('db' => 'id', 'dt' => 2,    'formatter' => function ($d, $row) {
    ob_start();
    include('../public/component/dosen/modalUpdateCategory.php');
    $modal = ob_get_clean();
    return
      '<div class="btn-group">    
      <a href="journalAnda.php?kateogri=' . $d . '">
        <button type="button" class="btn btn-info">
        <i class="fas fa-eye text-white"></i>
        </button>
      </a>   
      <button data-bs-toggle="modal"
          data-bs-target="#modalUpdateKateogri' . $row[0] . '" type="button" class="btn btn-warning">
        <i class="fas fa-edit text-white"></i>
        </button>
      <form method="post" action="">
            <input type="hidden" name="hapus_id" value="' . $d . '">
          <button type="submit" name="delete" class="btn btn-danger text-white">
          <i class="fas fa-trash "></i>
          </button>
        </form>
    </div>'.$modal;
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
