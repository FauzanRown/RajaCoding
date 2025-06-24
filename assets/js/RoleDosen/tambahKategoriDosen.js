  const modalKategori = document.getElementById("modalTambahKategori");
  const btnOpen = document.querySelector(".btn-tambah-kategori");
  const btnClose = document.getElementById("closeTambahKategori");
  const btnCloseFooter = document.getElementById("closeModalBtn");

  // Buka modal saat tombol diklik
  btnOpen.addEventListener("click", () => {
    modalKategori.style.display = "block";
  });

  // Tutup modal saat klik (x) atau tombol close
  btnClose.addEventListener("click", () => {
    modalKategori.style.display = "none";
  });
  btnCloseFooter.addEventListener("click", () => {
    modalKategori.style.display = "none";
  });

  // Tutup saat klik luar modal
  window.addEventListener("click", (e) => {
    if (e.target === modalKategori) {
      modalKategori.style.display = "none";
    }
  });