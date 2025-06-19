$(document).ready(function () {
  $("#example").DataTable({
    ajax: "../../controller/datatableController.php",
    processing: true,
    serverSide: true,
  });
});
