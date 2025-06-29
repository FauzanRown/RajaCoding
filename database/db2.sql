-- Buat database tanpa fitur MySQL 8
CREATE DATABASE `log_book` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE log_book;

-- Table `user`
CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('mahasiswa','dosen','admin') NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table `category`
CREATE TABLE `category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table `pembimbing`
CREATE TABLE `pembimbing` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint unsigned NOT NULL,
  `dosen_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswa_unique` (`mahasiswa_id`),
  KEY `dosen_FK_1` (`dosen_id`),
  CONSTRAINT `dosen_FK_1` FOREIGN KEY (`dosen_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mahasiswa_FK` FOREIGN KEY (`mahasiswa_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table `jurnal`
CREATE TABLE `jurnal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pembimbing_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `revision` text,
  `status` enum('valid','tidak valid','belum di review') NOT NULL DEFAULT 'belum di review',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jurnal_category_FK` (`category_id`),
  KEY `jurnal_pembimbing_FK` (`pembimbing_id`),
  CONSTRAINT `jurnal_category_FK` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `jurnal_pembimbing_FK` FOREIGN KEY (`pembimbing_id`) REFERENCES `pembimbing` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- View: view_jurnal_category
CREATE OR REPLACE VIEW view_jurnal_category AS 
SELECT 
  jurnal.id,
  jurnal.pembimbing_id,
  jurnal.category_id,
  jurnal.name,
  jurnal.note,
  jurnal.revision,
  jurnal.status,
  jurnal.created_at,
  category.name AS category_name
FROM jurnal
JOIN category ON jurnal.category_id = category.id;

-- View: view_jurnal_category_desc
CREATE OR REPLACE VIEW view_jurnal_category_desc AS 
SELECT 
  jurnal.id,
  jurnal.pembimbing_id,
  jurnal.category_id,
  jurnal.name,
  jurnal.note,
  jurnal.revision,
  jurnal.status,
  jurnal.created_at,
  category.name AS category_name,
  user.name AS mahasiswa_name
FROM jurnal
JOIN category ON jurnal.category_id = category.id
JOIN pembimbing ON jurnal.pembimbing_id = pembimbing.id
JOIN user ON pembimbing.mahasiswa_id = user.id
ORDER BY jurnal.created_at DESC;
