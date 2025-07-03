CREATE DATABASE IF NOT EXISTS log_book DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE log_book;

-- Tabel user
CREATE TABLE `user` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `role` ENUM('mahasiswa','dosen','admin') NOT NULL,
  `image` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel category
CREATE TABLE `category` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel pembimbing
CREATE TABLE `pembimbing` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` BIGINT UNSIGNED NOT NULL,
  `dosen_id` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswa_unique` (`mahasiswa_id`),
  KEY `dosen_FK_1` (`dosen_id`),
  CONSTRAINT `dosen_FK_1` FOREIGN KEY (`dosen_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mahasiswa_FK` FOREIGN KEY (`mahasiswa_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel jurnal
CREATE TABLE `jurnal` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pembimbing_id` BIGINT UNSIGNED NOT NULL,
  `category_id` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `note` TEXT NOT NULL,
  `revision` TEXT,
  `status` ENUM('valid','tidak valid','belum di review') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'belum di review',
  `date` DATE NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jurnal_category_FK` (`category_id`),
  KEY `jurnal_pembimbing_FK` (`pembimbing_id`),
  CONSTRAINT `jurnal_category_FK` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `jurnal_pembimbing_FK` FOREIGN KEY (`pembimbing_id`) REFERENCES `pembimbing` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- View view_jurnal_category
CREATE OR REPLACE VIEW view_jurnal_category AS
SELECT jurnal.*, category.name AS category_name
FROM jurnal
JOIN category ON jurnal.category_id = category.id;

-- View view_jurnal_category_desc
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
