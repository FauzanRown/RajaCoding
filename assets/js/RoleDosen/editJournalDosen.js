// ------ POP-UP EDIT JOURNAL ROLE DOSEN ------
const modal = document.getElementById("editModal");
const closeBtn = document.querySelector(".close");
const closeModalBtn = document.getElementById("closeModalBtn");
const judulModal = document.getElementById("judulModal");

// Tangkap semua tombol edit
const editButtons = document.querySelectorAll(".btn.edit");

editButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    const tableRow = btn.closest("tr");
    const judul = tableRow.children[1].textContent;
    judulModal.textContent = judul;
    modal.style.display = "block";
  });
});

// Tutup modal
closeBtn.onclick = closeModalBtn.onclick = function () {
  modal.style.display = "none";
};

// Klik luar modal = tutup
window.onclick = function (event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
};
