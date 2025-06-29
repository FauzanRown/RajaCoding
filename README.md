# Aplikasi Web Jurnal Kegiatan Mahasiswa (StudentLogBook)

## Deskripsi

Aplikasi ini memungkinkan mahasiswa mencatat dan melaporkan aktivtas harian mereka seperti magang, KKN, atau tugas akhir.

## Kelompok

| Nama Anggota          | NIM        | Peran                    |
| --------------------- | ---------- | ------------------------ |
| Muhammad Fauzan Anwar | 2400018012 | Frontend Developer       |
| Ahmad Fadhil Fanani   | 2400018026 | Backend Developer        |
| Lutfan Alaudin Naja   | 2400018032 | Database Manager         |
| Shandy Dwika Alfarezki| 2400018033 | GitHub Manager           |
| Farhan                | 2400018009 | Project Manager / Tester |

## Teknologi yang Digunakan

- HTML, CSS, JavaScript
- PHP
- MySQL (via XAMPP)
- Git dan GitHub

## Cara Menjalankan Proyek
# RajaCoding - Student Logbook Journal App 📝

Aplikasi logbook jurnal mahasiswa berbasis web yang dibangun dengan PHP dan MySQL. Aplikasi ini memungkinkan mahasiswa mencatat jurnal harian, dikelola oleh dosen pembimbing.

## 🚀 Fitur Utama

- Login & Role-based Access (Mahasiswa, Dosen, Admin)
- Kelola jurnal harian (Create, Read, Update, Delete)
- Filter jurnal berdasarkan tanggal
- Validasi jurnal oleh pembimbing
- Export PDF
- Summernote editor
- Toastr notifications
- AJAX-powered DataTables

---

## 🛠️ Requirements

- PHP >= 8.0
- MySQL / MariaDB
- Apache / Nginx
- Composer
- Web Browser (Chrome, Firefox, etc)

---

## ⚙️ Instalasi

1. **Clone Repository**
    
    ```bash
    git clone <https://github.com/FauzanRown/RajaCoding.git>
    cd RajaCoding
    
    ```
    

---

1. **Import Database**
    - Buka **phpMyAdmin** atau gunakan terminal:
        
        ```bash
        mysql -u root -p
        
        ```
        
    - Jalankan SQL dari file db`.sql`
        - Untuk MySQL gunakan db.sql
        - Untuk MariaDB gunakan db2.sql
        
        ```sql
        SOURCE /path/to/db.sql;
        
        ```
        
    - Atau buat database manual dan gunakan struktur dari file `sql_schema.sql` jika kamu punya.
2. **Konfigurasi Database**
    
    Ubah file `config.ini.example` menjadi `config.ini`
    Edit file `config.ini` atau lokasi konfigurasi database Anda:
    
    ```php
    $config = [
      "database" => [
        "hostname" => "localhost",
        "username" => "root",
        "password" => "",
        "database" => "log_book"
      ]
    ];
    
    ```
    

---

## 📦 Fitur Ekstra

- **DataTables AJAX**: Halaman jurnal dinamis dengan filter tanggal
- **Toastr.js**: Notifikasi sukses/gagal
- **Summernote**: Editor WYSIWYG
- **Select2**: Pencarian kategori jurnal

---

## 📢 Catatan

- Beberapa fitur seperti export PDF, validasi dosen, dan tampilan responsif masih dapat dikembangkan lebih lanjut.
- Perbedaan versi MySQL dan MariaDB dapat menyebabkan masalah dengan kolasi
    - Untuk MySQL gunakan db.sql
    - Untuk MariaDB gunakan db2.sql
- Bagi Mahasiswa dan Dosen wajib menggunakan email UAD

---

## 🤝 Kontribusi

Pull request dan saran sangat diterima! Jangan lupa untuk star ⭐ jika kamu merasa proyek ini bermanfaat.