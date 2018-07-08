-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jul 2018 pada 17.47
-- Versi server: 10.1.33-MariaDB
-- Versi PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sakip`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `address` text,
  `phone` varchar(300) DEFAULT NULL,
  `photo` varchar(300) DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `email` varchar(50) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `login_status` int(11) DEFAULT '0',
  `firebase_token` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `nip`, `name`, `password`, `address`, `phone`, `photo`, `active`, `email`, `role_id`, `login_status`, `firebase_token`) VALUES
(32, '1422500233', 'Administrator', '$2y$10$hITRJwtoajGMfwfJwzuSS.4f/9zlEMf8ucEh1vwJly7MZstQafwp6', 'Pangkalpinang', '082377228970', '121.jpg', 1, 'Pangkalpinang@gmail.com', 1, 1, 'eTDR_W5fWJo:APA91bEeYXQxCAJfMzLYzHpKJz6T-auYOwD9Io0rlrs0FJxDAKoEEpTUQ3xC1f2iK3cQHgo_iS00-LYOYJAxDgrHJQahzLWjy3sjiVCMZAzeMVIvH8D9QdxMI0cSopncdLr1VufNFKAP'),
(33, '1422500232', 'user', '$2y$10$24GreE9HFsX9IKPCn6LO3.MG2MTXBccsGSTsU5w0AeZ0cZHWghdsu', '', '', 'c31.png', 1, 'user@gmail.com', 1, 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_role`
--

CREATE TABLE `users_role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_description` text,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users_role`
--

INSERT INTO `users_role` (`role_id`, `role_name`, `role_description`, `role`) VALUES
(1, 'Administrator', 'Grup ini Super Administrator (tidak bisa diubah) semua akses terbuka.', '{\"surat_perizinan\":[\"on\",\"block\"],\"surat_non_perizinan\":[\"on\",\"block\"],\"analytics\":[\"on\",\"block\"],\"penduduk\":[\"on\",\"create\",\"read\",\"update\",\"delete\",\"block\"],\"desa\":[\"on\",\"create\",\"read\",\"update\",\"delete\",\"block\"],\"manejemen_surat\":[\"on\",\"update\",\"block\"],\"pegawai\":[\"on\",\"create\",\"read\",\"update\",\"delete\",\"block\"],\"statistik_penduduk\":[\"on\",\"block\"],\"statistik_surat_non_perizinan\":[\"on\",\"block\"],\"statistik_surat_perizinan\":[\"on\",\"block\"],\"statistik_pelayanan\":[\"on\",\"block\"],\"pengaturan\":[\"on\",\"block\"]}'),
(2, 'Petugas Verifikasi', 'Bertugas memverifikasi surat-surat yang diajukan petugas pelayanan', '{\"surat_perizinan\":[\"block\"],\"surat_non_perizinan\":[\"block\"],\"analytics\":[\"on\",\"block\"],\"penduduk\":[\"block\"],\"desa\":[\"read\",\"block\"],\"manejemen_surat\":[\"block\"],\"pegawai\":[\"block\"],\"statistik_penduduk\":[\"block\"],\"statistik_surat_non_perizinan\":[\"block\"],\"statistik_surat_perizinan\":[\"block\"],\"statistik_pelayanan\":[\"block\"],\"pengaturan\":[\"block\"]}'),
(3, 'Staff Pelayanan', 'Grup Akses Module untuk staff bagian pelayanan', '{\"surat_perizinan\":[\"on\",\"block\"],\"surat_non_perizinan\":[\"on\",\"block\"],\"analytics\":[\"block\"],\"penduduk\":[\"on\",\"create\",\"read\",\"update\",\"delete\",\"block\"],\"desa\":[\"block\"],\"manejemen_surat\":[\"block\"],\"pegawai\":[\"block\"],\"statistik_penduduk\":[\"block\"],\"statistik_surat_non_perizinan\":[\"block\"],\"statistik_surat_perizinan\":[\"block\"],\"statistik_pelayanan\":[\"block\"],\"pengaturan\":[\"block\"]}');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indeks untuk tabel `users_role`
--
ALTER TABLE `users_role`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `users_role`
--
ALTER TABLE `users_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
