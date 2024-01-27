-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2024 at 04:05 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poli`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` int(11) NOT NULL,
  `id_pasien` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `keluhan` text NOT NULL,
  `no_antrian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`) VALUES
(1, 1, 3, 'Sakit Hati', 1),
(2, 3, 4, 'Sakit perut', 2),
(5, 9, 9, 'Bau Bawang', 3),
(6, 16, 9, 'Bau bawang akut', 4),
(7, 14, 3, 'flu', 5),
(8, 9, 7, 'Anak sakit', 6),
(9, 9, 9, 'Sakit Hati', 7),
(50, 19, 3, 'jchchc', 8),
(51, 20, 9, 'Ingin Pulang', 9),
(52, 9, 6, 'Sakit Ginjal', 10),
(53, 9, 6, 'Apalah', 11),
(81, 10, 3, 'Saya Sakit Pinggang', 12),
(82, 9, 3, 'Sakit Perut', 13),
(83, 26, 15, 'Tidak Napsu Makan', 14),
(84, 28, 16, 'Tergores Bagian Kaki', 15),
(86, 29, 16, 'Sakit Tangan', 16);

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` int(11) NOT NULL,
  `id_periksa` int(11) NOT NULL,
  `id_obat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
(1, 2, 1),
(3, 11, 2),
(8, 16, 2),
(9, 17, 4),
(11, 37, 2),
(12, 38, 2),
(13, 39, 4),
(14, 40, 2),
(15, 41, 4),
(17, 43, 1),
(23, 49, 7),
(24, 50, 7),
(25, 51, 9),
(29, 54, 2),
(30, 54, 4),
(31, 54, 7),
(32, 54, 9),
(33, 55, 2),
(34, 56, 1),
(35, 56, 2),
(36, 56, 7);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `id_poli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama`, `nip`, `password`, `alamat`, `no_hp`, `id_poli`) VALUES
(4, 'Pandji Alam', 'alama', '$2y$10$.plCZ.JOHXbJuchG1wf8TOFbCHCVz3uccfq9BdibYI2koAmhQ04kG', 'Desa Susukan RT RW 100', '089773', 6),
(5, 'Nazwan', 'nazwan', '$2y$10$1iZODJ9Ct1AA3gI25rAl5OgLpJ7QZd1IhSjtrOiwFiireUflbD8ye', 'Kos Bu bambang', '09786866', 7),
(56, 'Ilham', '123', '$2y$10$fHCGRl4E51yNDYW5vltDo.2XcL7wgamEoOMeGdnPD0gXay.Fs6aBS', 'Desa Konoha', '089777666', 10),
(59, 'Hilal', '55555', '$2y$10$H8WRuF5kdDveXvMG6oHe3uPr7nDpqYszhgYEI.ncGStccEHChy8La', 'Desa Susukan', '55555', 9),
(60, 'Nopal', '1234567890', '$2y$10$CJvaRxq0l1DVmXdtRqJCh.v3a7u0aJfM1UiB9p7.SUCoXuv5Q4.u2', 'Desa Susukan', '77778', 12),
(68, 'Kurniawan', '9090', '$2y$10$J4BmXCYfPR9w0zBVyLwSEOr/yrfBWyEbYwTIdX/H6bXH7MmIaCCKy', 'Desa Ke', '0897979', 9);

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` int(11) NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `aktif` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `aktif`) VALUES
(3, 4, 'Sabtu', '07:00:00', '10:00:00', 'N'),
(4, 5, 'Kamis', '15:00:00', '18:00:00', 'Y'),
(6, 59, 'Senin', '07:00:00', '10:00:00', 'Y'),
(7, 56, 'Selasa', '00:00:00', '22:00:00', 'Y'),
(9, 60, 'Rabu', '07:00:00', '18:00:00', 'Y'),
(10, 4, 'Rabu', '09:00:00', '12:00:00', 'N'),
(12, 60, 'Senin', '20:00:00', '22:00:00', 'Y'),
(14, 4, 'Senin', '08:00:00', '18:00:00', 'N'),
(15, 4, 'Selasa', '15:07:00', '18:07:00', 'N'),
(16, 4, 'Kamis', '15:24:00', '18:24:00', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(50) NOT NULL,
  `kemasan` varchar(35) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
(1, 'Paramex', 'Strip', 5000),
(2, 'Sanmol', 'Botol', 3000),
(4, 'Parameter1', 'Strip2', 10000),
(7, 'Antangin X', 'Sasetan', 7000),
(9, 'OBH', 'Strip', 35000);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_ktp` varchar(255) NOT NULL,
  `no_hp` varchar(50) NOT NULL,
  `no_rm` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
(1, 'REHAN', 'Desa Kam', '7889', '089777', '202312-001'),
(3, 'YANDA', 'Desa Susukan', '27777939', '089777777', '202312-002'),
(6, 'Mark Anjayani', 'Desa Seol', '12345', '0895555', '202312-003'),
(7, 'Loki', 'Desa Asgard', '54321', '08989', '202312-004'),
(8, 'Heimdal', 'Desa Asgard', '12354', '08977', '202312-005'),
(9, 'Gilgamesh', 'Desa Uruk', '99999', '999990', '202312-006'),
(10, 'Kiara', 'Desa Uruk', '99998', '09999', '202312-007'),
(12, 'Istar', 'Desa Uruk', '77866', '67788', '202312-008'),
(13, 'Enkidu', 'Desa Uruk', '99989', '99990', '202312-009'),
(14, 'Mashu', 'Desa Chaldea', '5555', '5555', '202312-010'),
(15, 'Alamak', 'Desa Seol', '56564', '8787', '202312-011'),
(16, 'Dimas', 'Desa Konoha', '7878787', '0897977', '202312-012'),
(17, 'Beko', 'Desa Konohamaru', '8787878675755', '979787868686', '202312-013'),
(18, 'Bika', 'Desa Susukan', '2324335553', '2324335553', '202312-014'),
(19, 'FUUUU', 'Desa Seol', '11222222', '11222222', '202312-015'),
(20, 'Sandro', 'Desa Ca', '675555523234343', '097848364836483643', '202401-016'),
(23, 'jojo', '144', '23243', '90796', '202401-017'),
(25, 'Kiki', 'Desa H', '123454345', '123454345', '202401-018'),
(26, 'SIska', 'Alga', '87678', '87678', '202401-019'),
(28, 'Alamsyah', 'Desa Jujur', '666667', '666667', '202401-020'),
(29, 'Mika', 'Desaaa', '1111111', '1111111', '202401-021');

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` int(11) NOT NULL,
  `id_daftar_poli` int(11) NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text NOT NULL,
  `biaya_periksa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
(2, 2, '2023-12-28 16:00:00', 'Jangan Makan gorengan', 155000),
(11, 1, '2023-12-30 16:57:00', 'Makan Tahu yang banyak', 153000),
(16, 5, '2023-12-31 15:54:00', 'Mandi', 153000),
(17, 6, '2023-12-27 15:55:42', 'Mandi 10 Kali perhari', 160000),
(37, 7, '2023-12-31 20:32:00', 'Sa', 153000),
(38, 9, '2024-01-04 13:43:00', 'Makan Hati', 153000),
(39, 51, '2024-01-04 13:50:00', 'Ngimpi dek', 160000),
(40, 52, '2024-01-12 09:35:00', 'Makan Ginjalnya', 153000),
(41, 53, '2024-01-04 09:40:00', 'Asljdkajvc', 160000),
(43, 50, '2024-01-05 18:32:00', 'Makan Ginjalnya', 155000),
(49, 81, '2024-01-05 19:51:00', 'Pijat', 157000),
(50, 82, '2024-01-06 13:47:00', 'Makan apel', 157000),
(51, 84, '2024-01-07 15:35:00', 'Dikasih Obat', 185000),
(54, 86, '2024-01-08 10:38:00', 'Pijat', 205000),
(55, 82, '2024-01-09 10:41:00', 'Makan Ginjalnya', 153000),
(56, 86, '2024-01-10 13:19:00', 'dsdgvrg', 165000);

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` varchar(25) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
(6, 'Poli Penyakit Luar', 'Untuk Luka Luar'),
(7, 'Poli Ibu', 'Untuk Ibu'),
(9, 'Poli Penyakit Dalam', 'Untuk Luka Dalam'),
(10, 'Poli Anak', 'Untuk Anak'),
(12, 'Poli Sepuh', 'Untuk Sesepuh');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`) VALUES
(3, 'Pandji Alam', 'pandji', '$2y$10$1iZODJ9Ct1AA3gI25rAl5OgLpJ7QZd1IhSjtrOiwFiireUflbD8ye'),
(4, 'Hilal', 'hilal', '$2y$10$LlSinySoYdFtZcwtrzvMGOFsOagICS0M3HH3dxsf9k7hx0U4Jkxby'),
(5, 'Nazwan', 'nazwan', '$2y$10$DeA6XDGBIRDZhK4WSnPBbuWYC/zjaL3tjFYMGSHb8RjP0dwnkNAk.'),
(6, '12345', '12345', '$2y$10$Z22A1aq35Oe.fWjec7c2OeWzQIUjlsil0pUW164nsuyu2pZMzLAlS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_daftar_poli_pasien` (`id_pasien`),
  ADD KEY `fk_daftar_poli_jadwal_periksa` (`id_jadwal`);

--
-- Indexes for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_periksa_obat` (`id_obat`),
  ADD KEY `fk_detail_periksa_periksa` (`id_periksa`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dokter_poli` (`id_poli`);

--
-- Indexes for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jadwal_periksa_dokter` (`id_dokter`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_periksa_daftar_poli` (`id_daftar_poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `fk_daftar_poli_jadwal_periksa` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`),
  ADD CONSTRAINT `fk_daftar_poli_pasien` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`);

--
-- Constraints for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `fk_detail_periksa_obat` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`),
  ADD CONSTRAINT `fk_detail_periksa_periksa` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`);

--
-- Constraints for table `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `fk_dokter_poli` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`);

--
-- Constraints for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `fk_jadwal_periksa_dokter` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

--
-- Constraints for table `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `fk_periksa_daftar_poli` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
