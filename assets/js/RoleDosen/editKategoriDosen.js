const modalEdit = document.getElementById("modalEditKategori");
const btnCloseEdit = document.getElementById("closeEditKategori");
const btnCloseFooterEdit = document.getElementById("closeModalEditBtn");
const inputEditNama = document.getElementById("editNamaKategori");

const editButtons = document.querySelectorAll(".btn.edit");

editButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    modalEdit.style.display = "block";

    const row = btn.closest("tr");
    const namaKategori = row.children[1].textContent;
    inputEditNama.value = namaKategori;
  });
});

btnCloseEdit.addEventListener("click", () => {
  modalEdit.style.display = "none";
});

btnCloseFooterEdit.addEventListener("click", () => {
  modalEdit.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === modalEdit) {
    modalEdit.style.display = "none";
  }
});
