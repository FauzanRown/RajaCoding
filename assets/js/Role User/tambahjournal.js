// ! INI KODE UNTUK TOOLS BUAT EDIT TEKS NYA\
const button = document.querySelectorAll(".buttonActive");
button.forEach((btn) => {
  btn.addEventListener("click", () => {
    btn.classList.toggle("active");
  });
});

// ! KODE KETIKA SIDEBAR DI KLIK DAN MENJADI AKTIF
const sidebarActive = document.querySelectorAll(".btn-active");
sidebaActive.forEach((btn) => {
  btn.addEventListener("click", () => {
    btn.classList.toggle("active");
  });
});
