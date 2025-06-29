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
$table = 'view_jurnal_category_desc';
// Table's primary key
$primaryKey = 'id';
$idUser = $_SESSION["id"];
$currentUser = getUser($idUser)[0];
// echo $_GET["id"];
if ($currentUser["role"] == "dosen" && !empty($_GET['id'])) {
  $query = $conn->prepare("SELECT id FROM pembimbing WHERE dosen_id = ? AND mahasiswa_id = ?");
  $query->bind_param("ii", $idUser, $_GET['id']);
  $query->execute();
  $result = $query->get_result();
  $idPembimbing = $result->fetch_assoc();
  $query->close();
} else if ($currentUser["role"] == "dosen") {
  $query = $conn->prepare("SELECT id FROM pembimbing WHERE dosen_id = ? ");
  $query->bind_param("i", $idUser);
  $query->execute();
  $result = $query->get_result();
  $idPembimbing = $result->fetch_assoc();
  $query->close();
} else {
  http_response_code(403);
  echo json_encode(["error" => "Unauthorized"]);
  exit;
}


if ($idPembimbing) {
  $where = "pembimbing_id = " . intval($idPembimbing["id"]);
}
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
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
$columns = array(
  array('db' => 'id', 'dt' => 0,    'formatter' => function ($d, $row) {
    return null;
  }),
  array('db' => 'mahasiswa_name', 'dt' => 1),
  array('db' => 'title', 'dt' => 2),
  array('db' => 'category_name', 'dt' => 3),
  array(
    'db' => 'date',
    'dt' => 4,
    'formatter' => function ($d, $row) {
      return formatTanggalIndonesia($d);
    }
  ),
  array('db' => 'status', 'dt' => 5, 'formatter' => function ($d, $row) {
    $style = "success";
    if ($d == "valid") {
      # code...
      $style = "success";
    } else if ($d == "tidak valid") {
      $style = "danger";
    } else {
      $style = "secondary";
    }
    return '<div class="btn-group">
    <button type="button" class="btn btn-' . $style . ' dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      ' . $d . '
    </button>
    <ul class="dropdown-menu">
      <li><button class="dropdown-item update-status" data-document-id="' . $row[0] . '" value="valid">valid</button></li>
      <li><button class="dropdown-item update-status" data-document-id="' . $row[0] . '" value="belum di review">belum di review</button></li>
      <li><button class="dropdown-item update-status" data-document-id="' . $row[0] . '" value="tidak valid">tidak valid</button></li>
    </ul>
  </div>';
  }),
  // array( 'db' => 'office', 'dt' => 3 ),
  array('db' => 'revision', 'dt' => 6,    'formatter' => function ($d, $row) {
    return
      '<div class="btn-group">    
      <a href="viewJournal.php?id=' . $row[0] . '">
        <button type="button" class="btn btn-info">
        <i class="fas fa-eye text-white"></i>
        </button>
      </a> 
        <a href="../../controller/downloadJurnal.php?id=' . $row[0] . '" target="_blank" >
                <button type="button" class="btn btn-danger">
        <i class="fas fa-file-pdf text-white"></i>
        </button>
      </a>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal' . $row[0]  . '">
        <i class="fas fa-edit text-white"></i>
        </button>   
    </div>
    <div class="modal fade" id="exampleModal' . $row[0] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" action=" ">
        <div class="modal-body">
          <div class="mb-3">
            <input type="hidden" class="form-control" name="update_id" value="' . $row[0]  . '">
            <label for="revisi' . $row[0] . '" class="form-label">Revisi</label>
              <textarea class="form-control" id="revisi' . $row[0] . '" rows="3"  name="revisi">' . $d . '</textarea>
          </div>
          <label for="status' . $row[0] . '" class="form-label">Revisi</label>
          <select class="form-select" name="status" aria-label="Default select example" id="status' . $row[0] . '">
            <option value="tidak valid" ' . ($row[4] == 'tidak valid' ? 'selected' : '') . '>Tidak Valid</option>
            <option value="valid" ' . ($row[4] == 'valid' ? 'selected' : '') . '>Valid</option>
            <option value="belum di review" ' . ($row[4] == 'belum di review' ? 'selected' : '') . '>Belum di review</option>
          </select>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
      </div>
    </div>
    ';
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
if ($idPembimbing && isset($idPembimbing["id"])) {
  $where = "pembimbing_id = " . intval($idPembimbing["id"]);
  if (!empty($_GET['date'])) {
    $tanggal = $_GET['date']; // format: YYYY-MM-DD
    $tanggal = mysqli_real_escape_string($conn, $tanggal); // sanitasi
    // Gabungkan pencarian berdasarkan tanggal dan id pembimbing
    $where .= " AND DATE(date) = '$tanggal'";
  }
  echo json_encode(
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, null, $where)
  );
} else {
  // User tidak punya pembimbing atau jurnal, kirimkan data kosong
  echo json_encode([
    "draw" => isset($_GET['draw']) ? intval($_GET['draw']) : 0,
    "recordsTotal" => 0,
    "recordsFiltered" => 0,
    "data" => []
  ]);
}
