// ---------- INISIALISASI DATA TABLE ----------
new DataTable("#dosenTable");

// ---------- FUNGSI SET EDIT DOSEN ----------
function setEditDosen(nama, email, role = "dosen") {
  const inputNama = document.getElementById("editNamaDosen");
  const inputEmail = document.getElementById("editEmailDosen");
  const inputPassword = document.getElementById("editPasswordDosen");
  const selectRole = document.getElementById("editRoleDosen");

  inputNama.value = nama;
  inputEmail.value = email;
  inputPassword.value = "";
  selectRole.value = role.toLowerCase();
}
