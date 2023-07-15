-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 26 Des 2022 pada 03.55
-- Versi server: 10.5.16-MariaDB
-- Versi PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id17931840_stockbarang`
--
CREATE DATABASE IF NOT EXISTS `id17931840_stockbarang` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `id17931840_stockbarang`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluar`
--

CREATE TABLE `keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lokasipart` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `serialnumber` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `serialnumberbaru` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `masuk`
--

CREATE TABLE `masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `lokasipart` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `serialnumber` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `serialnumberbaru` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `idpeminjaman` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggalpinjam` timestamp NOT NULL DEFAULT current_timestamp(),
  `qty` int(11) NOT NULL,
  `peminjam` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lokasipart` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `serialnumber` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `serialnumberbaru` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Overhaul'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengerjaan`
--

CREATE TABLE `pengerjaan` (
  `idbarang` int(11) NOT NULL,
  `tanggalpengerjaan` timestamp NOT NULL DEFAULT current_timestamp(),
  `namapekerja` varchar(99) NOT NULL,
  `namabarang` varchar(90) NOT NULL,
  `lokasipart` varchar(99) NOT NULL,
  `serialnumber` varchar(90) NOT NULL,
  `serialnumberbaru` varchar(90) NOT NULL,
  `deskripsi` text NOT NULL,
  `stock` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `image` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengerjaan`
--

INSERT INTO `pengerjaan` (`idbarang`, `tanggalpengerjaan`, `namapekerja`, `namabarang`, `lokasipart`, `serialnumber`, `serialnumberbaru`, `deskripsi`, `stock`, `status`, `image`) VALUES
(29, '2022-08-23 02:22:48', 'LRV 2', 'Coupler ', 'Mc', 'ID380 2.6KA - 001 - 2017 10', '0', 'Underframe Equipment MC A', 1, 'OVERHAUL', 'cc9a51c752071230c8ba5232fed7373b.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock`
--

CREATE TABLE `stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(50) NOT NULL,
  `lokasipart` varchar(99) NOT NULL,
  `serialnumber` varchar(50) NOT NULL,
  `serialnumberbaru` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `stock`
--

INSERT INTO `stock` (`idbarang`, `namabarang`, `lokasipart`, `serialnumber`, `serialnumberbaru`, `deskripsi`, `stock`, `image`) VALUES
(76, 'Kuas 1\" 25.4mm 8x', 'Gudang', '', '', 'Kuas 1\" 25.4mm 8x', 8, '1bcde4893299c2a5c3b09183f968fa8d.jpeg'),
(77, 'Kuas 1.5\" 38.1mm', 'Gudang', '', '', 'Kuas 1.5\" 38.1mm', 1, '31ef50e1547c3e2fda6a2a453d0a99e2.jpeg'),
(78, 'Seal Tape', 'Gudang', '', '', 'Seal Tape', 8, '5d2b7b7fefe50fb306a60ffb52e0eb3a.jpeg'),
(79, 'Rexcon 50', 'Gudang', '', '', 'Rexcon 50', 4, '252eb763c18841c67fb1e6af03f990bd.jpeg'),
(80, 'Rexcon 18', 'Gudang', '', '', 'Rexcon 18', 0, 'b2ee33b5a46fd16547054478dad2823c.jpg'),
(81, 'WD 40', 'Gudang', '', '', 'WD 40', 10, 'a0f416103a9390e529f3572b445764f4.jpg'),
(82, 'Masker (Box)', 'Gudang', '', '', 'Masker (Box)', 1, '274f70675ba054aa277ecc3ca15b53d1.jpg'),
(83, 'Plastic Wrap', 'Gudang', '', '', 'Plastic Wrap', 1, '2e59be0eba15cc8a2d974ee9b9365b95.jpg'),
(84, 'Sarung Tangan Putih', 'Gudang', '', '', 'Sarung Tangan Putih', 7, 'ec79758826ed94e0e20e5017530be4f0.jpg'),
(85, 'Sarung Tangan Hitam', 'Gudang', '', '', 'Sarung Tangan Hitam', 6, 'ce6cc8a01bbd90c5bfc5aadb99713439.jpg'),
(86, 'Eonwash 500', 'Gudang', '', '', 'Eonwash 500', 6, 'fab971067297e45fd3f344a233a18bb6.jpg'),
(87, 'Eonwash 600', 'Gudang', '', '', 'Eon 600', 0, 'd7179eaf2e63e8bf71d6ed119e2d1825.jpg'),
(88, 'Spidol Putih', 'Gudang', '', '', 'Spidol Putih', 2, 'c8dc38cc8688a27d4ad4f55800de78f2.jpg'),
(89, 'Spidol Merah', 'Gudang', '', '', 'Spidol Merah', 0, '328903dcc1eb093e81dbe2174f30da14.jpg'),
(90, 'Kapur', 'Gudang', '', '', 'Kapur', 12, '00ab89c5ba7efe745e1e153d0e47b813.jpg'),
(91, 'Synthetic Gear Lubricant / SGL', 'Gudang', '', '', 'Synthetic Gear Lubricant / SGL', 0, '4e5ff986bc31c77ab9ab333d0c04483c.jpg'),
(92, 'Synthetic Gear Oil / SGO', 'Gudang', '', '', 'Synthetic Gear Oil', 0, 'd15d32ddc7a814e95d49f027fa94d69a.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`iduser`, `email`, `password`) VALUES
(1, 'lrtinventory10@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(2, 'inventory10@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indeks untuk tabel `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`idpeminjaman`);

--
-- Indeks untuk tabel `pengerjaan`
--
ALTER TABLE `pengerjaan`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indeks untuk tabel `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `keluar`
--
ALTER TABLE `keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `masuk`
--
ALTER TABLE `masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `idpeminjaman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengerjaan`
--
ALTER TABLE `pengerjaan`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `stock`
--
ALTER TABLE `stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
