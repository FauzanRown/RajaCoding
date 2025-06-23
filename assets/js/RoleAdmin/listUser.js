// ---------- INISIALISASI DATA TABLE ----------
new DataTable("#userTable");

// ---------- FUNGSI EDIT USER ----------
function setEditUser(nama, email, role) {
  const inputNama = document.getElementById("editNama");
  const inputEmail = document.getElementById("editEmail");
  const inputPassword = document.getElementById("editPassword");
  const selectRole = document.getElementById("editRole");

  inputNama.value = nama;
  inputEmail.value = email;
  inputPassword.value = "";
  selectRole.value = role.toLowerCase();
}
