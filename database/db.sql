CREATE DATABASE `log_book` /*!40100 user CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 user ENCRYPTION='N' */;
USE log_book;
-- log_book.`user` definition
CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('mahasiswa','dosen','admin') NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 user CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- log_book.category definition

CREATE TABLE `category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 user CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `pembimbing` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint unsigned NOT NULL,
  `dosen_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL user NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswa_unique` (`mahasiswa_id`),
  KEY `dosen_FK_1` (`dosen_id`),
  CONSTRAINT `dosen_FK_1` FOREIGN KEY (`dosen_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mahasiswa_FK` FOREIGN KEY (`mahasiswa_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 user CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- log_book.jurnal definition

CREATE TABLE `jurnal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pembimbing_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `note` text NOT NULL,
  `revision` text,
  `status` enum('valid','tidak valid','belum di review') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL user 'belum di review',
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jurnal_category_FK` (`category_id`),
  KEY `jurnal_pembimbing_FK` (`pembimbing_id`),
  CONSTRAINT `jurnal_category_FK` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `jurnal_pembimbing_FK` FOREIGN KEY (`pembimbing_id`) REFERENCES `pembimbing` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 user CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE VIEW view_jurnal_category AS SELECT jurnal.*, category.name AS category_name,  FROM jurnal JOIN category ON jurnal.category_id = category.id;

CREATE VIEW view_jurnal_category_desc AS SELECT jurnal.*, category.name AS category_name,  FROM jurnal JOIN category ON jurnal.category_id = category.id ORDER BY date DESC;

CREATE OR REPLACE VIEW view_jurnal_category_desc AS
SELECT 
    jurnal.*, 
    category.name AS category_name,
    user.name AS mahasiswa_name
FROM 
    jurnal
JOIN 
    category ON jurnal.category_id = category.id
JOIN 
    pembimbing ON jurnal.pembimbing_id = pembimbing.id
JOIN 
    user ON pembimbing.mahasiswa_id = user.id
ORDER BY 
    jurnal.date DESC;

INSERT INTO `user` (`name`, `email`, `password`, `role`, `image`, `created_at`) VALUES
-- Admin
('Admin 1', 'admin@example.com', 'password123', 'admin', 'user.png', NOW()),

-- Dosen (9 orang)
('Dosen 1', 'dosen1@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),
('Dosen 2', 'dosen2@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),
('Dosen 3', 'dosen3@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),
('Dosen 4', 'dosen4@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),
('Dosen 5', 'dosen5@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),
('Dosen 6', 'dosen6@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),
('Dosen 7', 'dosen7@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),
('Dosen 8', 'dosen8@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),
('Dosen 9', 'dosen9@tif.uad.ac.id', 'password123', 'dosen', 'user.png', NOW()),

-- Mahasiswa (20 orang)
('Mahasiswa 1', '2400018001@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 2', '2400018002@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 3', '2400018003@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 4', '2400018004@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 5', '2400018005@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 6', '2400018006@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 7', '2400018007@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 8', '2400018008@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 9', '2400018009@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 10', '2400018010@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 11', '2400018011@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 12', '2400018012@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 13', '2400018013@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 14', '2400018014@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 15', '2400018015@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 16', '2400018016@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 17', '2400018017@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 18', '2400018018@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 19', '2400018019@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW()),
('Mahasiswa 20', '2400018020@webmail.uad.ac.id', 'password123', 'mahasiswa', 'user.png', NOW());

INSERT INTO category (name, created_at) VALUES
('Skripsi', NOW()),
('Magang', NOW()),
('PKM', NOW()),
('Bimbingan Akademik', NOW()),
('KKN', NOW()),
('Penelitian', NOW()),
('Asistensi Mengajar', NOW()),
('Kegiatan Kampus Merdeka', NOW()),
('Tugas Besar', NOW()),
('Studi Literatur', NOW()),
('Proposal Skripsi', NOW()),
('Review Jurnal', NOW()),
('Seminar Hasil', NOW()),
('Sidang Akhir', NOW()),
('Diskusi Dosen', NOW()),
('Rapat Pembimbingan', NOW()),
('Survei Lapangan', NOW()),
('Pengumpulan Data', NOW()),
('Analisis Data', NOW()),
('Workshop PKM', NOW()),
('Koordinasi KKN', NOW()),
('Laporan Magang', NOW()),
('Konsultasi Dosen', NOW()),
('Evaluasi Mingguan', NOW()),
('Logbook Harian', NOW()),
('Observasi Lapangan', NOW()),
('Penyusunan Laporan', NOW()),
('Kegiatan Lab', NOW()),
('Progress Report', NOW()),
('Finalisasi Skripsi', NOW());
