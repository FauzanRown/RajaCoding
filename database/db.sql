CREATE DATABASE `log_book` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
-- log_book.`user` definition
USE log_book_test;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
-- log_book.pembimbing definition

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- log_book.jurnal definition

CREATE TABLE `jurnal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_pembimbing` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `revision` text,
  `status` enum('valid','tidak valid','belum di review') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'belum di review',
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jurnal_pembimbing_FK` (`id_pembimbing`),
  CONSTRAINT `jurnal_pembimbing_FK` FOREIGN KEY (`id_pembimbing`) REFERENCES `pembimbing` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;