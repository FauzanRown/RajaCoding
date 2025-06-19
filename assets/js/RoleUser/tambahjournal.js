// ! INI KODE UNTUK TOOLS BUAT EDIT TEKS NYA\
$("#summernote").summernote({
  placeholder: "Tulis Journal Anda Di Sini...",
  tabsize: 2,
  height: 120,
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "underline", "clear"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["table", ["table"]],
    ["insert", []],
    ["view", ["fullscreen","help"]],
  ],
});

// ! KODE KETIKA SIDEBAR DI KLIK DAN MENJADI AKTIF
const sidebarActive = document.querySelectorAll(".btn-active");
sidebaActive.forEach((btn) => {
  btn.addEventListener("click", () => {
    btn.classList.toggle("active");
  });
});
