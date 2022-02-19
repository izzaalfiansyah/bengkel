-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Feb 2022 pada 04.31
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bengkel`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_bengkel`
--

CREATE TABLE `data_bengkel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_buka` time NOT NULL,
  `jam_tutup` time NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_bengkel`
--

INSERT INTO `data_bengkel` (`id`, `nama`, `jam_buka`, `jam_tutup`, `alamat`, `lokasi`, `whatsapp`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Fopegram', '08:00:00', '15:00:00', 'Kencong - Jember', '-8.174110250403396,113.70265960693361', '082330538264', 'ee77756513fb5288286d.jpg', '2021-07-05 19:40:42', '2021-07-08 19:49:43'),
(2, 'Besi Tua', '08:00:00', '13:00:00', 'Jombang - Jember', '-8.164804156850824,113.45132093760186', '098192378765', '96e6407ddc1ed8271594.jpg', '2021-07-05 20:39:03', '2021-07-08 20:06:13');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `data_estimasi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `data_estimasi` (
`id` bigint(20) unsigned
,`kode` varchar(255)
,`keluhan` text
,`id_kendaraan_pelanggan` bigint(20) unsigned
,`id_transaksi` bigint(20) unsigned
,`id_user` bigint(20) unsigned
,`status` enum('0','1','2')
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `data_invoice`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `data_invoice` (
`id` bigint(20) unsigned
,`kode` varchar(255)
,`keluhan` text
,`id_kendaraan_pelanggan` bigint(20) unsigned
,`id_transaksi` bigint(20) unsigned
,`id_user` bigint(20) unsigned
,`status` enum('0','1','2')
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_jasa`
--

CREATE TABLE `data_jasa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_jasa`
--

INSERT INTO `data_jasa` (`id`, `nama`, `harga`, `created_at`, `updated_at`) VALUES
(1, 'Engine tune up', 200000, '2021-07-05 19:44:10', '2021-07-28 18:47:00'),
(2, 'Breaksystem', 100000, '2021-07-28 18:47:19', '2021-07-28 18:47:19'),
(3, 'Fuel injection system', 250000, '2021-07-28 18:48:01', '2021-07-28 18:48:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_kas`
--

CREATE TABLE `data_kas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tipe` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = masuk, 2 = keluar',
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_kas`
--

INSERT INTO `data_kas` (`id`, `deskripsi`, `jumlah`, `tipe`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'Beli gorengan', 5000, '0', 1, '2021-07-05 20:06:19', '2021-07-20 06:09:46'),
(10, 'Transaksi (TPO-20210729-0209)', 265000, '1', 1, '2021-07-28 19:09:30', '2021-07-29 20:17:12'),
(15, 'Transaksi (TPO-20210730-1449)', 305000, '1', 1, '2021-07-30 07:49:41', '2021-07-30 07:53:29'),
(16, 'Sumbangan dari PT Berkah Jaya', 200000, '1', 1, '2021-09-08 20:26:12', '2021-09-08 20:26:12'),
(17, 'Beli peralatan bengkel', 70000, '0', 1, '2021-09-08 20:26:52', '2021-09-08 20:26:52'),
(19, 'Transaksi (TPO-20211011-0708)', 326000, '1', 1, '2021-10-11 00:08:45', '2021-10-11 01:00:01'),
(20, 'Transaksi (TPO-20211011-0811)', 200000, '1', 1, '2021-10-11 01:11:03', '2021-10-14 04:36:48'),
(21, 'Transaksi (TPO-20211011-0813)', 111100, '1', 1, '2021-10-11 01:13:16', '2022-01-01 00:00:50'),
(23, 'Transaksi (TPO-20211014-1340)', 578600, '1', 1, '2021-10-14 06:40:02', '2021-10-14 06:40:02'),
(24, 'Transaksi (TPO-20220101-0651)', 121000, '1', 1, '2021-12-31 23:51:35', '2021-12-31 23:51:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pelanggan`
--

CREATE TABLE `data_pelanggan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `whatsapp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_pelanggan`
--

INSERT INTO `data_pelanggan` (`id`, `nama`, `alamat`, `tanggal_lahir`, `whatsapp`) VALUES
(1, 'Ricky', 'Jember', '1994-04-05', '082330538264'),
(2, 'Rafli', 'Jombang', '1988-05-17', '082330538264');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_produk`
--

CREATE TABLE `data_produk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_bengkel` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_produk`
--

INSERT INTO `data_produk` (`id`, `nama`, `deskripsi`, `stok`, `harga_beli`, `harga_jual`, `foto`, `id_bengkel`, `created_at`, `updated_at`) VALUES
(3, 'Busi', 'busi adalah sapi', 12, 4000, 5000, 'a:2:{i:0;s:24:\"814988da9df493b559cf.jpg\";i:1;s:24:\"02adc0c1d064e8b4c45c.jpg\";}', 2, '2021-07-12 20:01:55', '2022-01-01 00:00:50'),
(4, 'Ban', 'ban adalah benda putar untuk membantu gerak kendaraan', 93, 35000, 38000, 'a:2:{i:0;s:24:\"596aa63d9dd5611b29f2.jpg\";i:1;s:24:\"cab5c01e1436e601f129.jpg\";}', 2, '2021-07-12 20:06:19', '2022-01-01 00:00:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_service`
--

CREATE TABLE `data_service` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keluhan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `perintah_kerja` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = menunggu, 1 = sedang dikerjakan, 2 = selesai',
  `status_pengerjaan` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 = belum, 1 = proses, 2 = selesai',
  `total_harga` int(11) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `id_transaksi` bigint(20) UNSIGNED DEFAULT NULL,
  `id_kendaraan_pelanggan` bigint(20) UNSIGNED NOT NULL,
  `id_teknisi` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_service`
--

INSERT INTO `data_service` (`id`, `kode`, `keluhan`, `perintah_kerja`, `status`, `status_pengerjaan`, `total_harga`, `total_bayar`, `id_user`, `id_transaksi`, `id_kendaraan_pelanggan`, `id_teknisi`, `created_at`, `updated_at`) VALUES
(2, 'WO-20210729-0429', 'Akselerasi nyandet-nyandet', 'Kasih aja bang', '2', '1', 0, 0, 1, 12, 1, 1, '2021-07-28 21:29:49', '2021-10-11 01:08:18'),
(3, 'IN-20211011-0809', 'Tiba-tiba mati ketika distarter', NULL, '1', '0', 0, 0, 1, 13, 2, 1, '2021-10-11 01:09:19', '2021-10-11 01:11:46'),
(4, 'ES-20211011-0810', 'Knalpot kemlatak :v', NULL, '0', '0', 0, 0, 1, 14, 1, NULL, '2021-10-11 01:10:12', '2021-10-13 19:37:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_supplier`
--

CREATE TABLE `data_supplier` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_supplier`
--

INSERT INTO `data_supplier` (`id`, `nama`, `kontak`, `alamat`) VALUES
(1, 'Supplier 1', '08287676543', 'Jember');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_teknisi`
--

CREATE TABLE `data_teknisi` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `data_teknisi`
--

INSERT INTO `data_teknisi` (`id`, `nama`, `alamat`, `telepon`, `email`) VALUES
(1, 'Raul Gonzalez', 'Jember', '0812310108273', 'raulgnzlezz@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_transaksi`
--

CREATE TABLE `data_transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produk` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jasa` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` int(11) NOT NULL,
  `pajak_pph` int(11) DEFAULT 0,
  `pajak_ppn` int(11) DEFAULT 0,
  `grand_total` int(11) NOT NULL DEFAULT 0,
  `total_bayar` int(11) NOT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '1 = selesai, 0 = belum',
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_pelanggan` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_transaksi`
--

INSERT INTO `data_transaksi` (`id`, `kode`, `produk`, `jasa`, `total_harga`, `pajak_pph`, `pajak_ppn`, `grand_total`, `total_bayar`, `status`, `id_user`, `id_pelanggan`, `created_at`, `updated_at`) VALUES
(4, 'TPO-20210729-0209', 'a:1:{i:0;a:4:{s:2:\"id\";i:3;s:3:\"qty\";i:3;s:5:\"harga\";i:15000;s:6:\"produk\";a:10:{s:2:\"id\";i:3;s:4:\"nama\";s:4:\"Busi\";s:9:\"deskripsi\";s:16:\"busi adalah sapi\";s:4:\"stok\";i:19;s:10:\"harga_beli\";i:4000;s:10:\"harga_jual\";i:5000;s:4:\"foto\";s:78:\"a:2:{i:0;s:24:\"814988da9df493b559cf.jpg\";i:1;s:24:\"02adc0c1d064e8b4c45c.jpg\";}\";s:10:\"id_bengkel\";i:2;s:10:\"created_at\";s:27:\"2021-07-13T03:01:55.000000Z\";s:10:\"updated_at\";s:27:\"2021-07-30T03:16:48.000000Z\";}}}', 'a:1:{i:0;a:3:{s:2:\"id\";i:3;s:5:\"harga\";i:250000;s:4:\"jasa\";a:5:{s:2:\"id\";i:3;s:4:\"nama\";s:21:\"Fuel injection system\";s:5:\"harga\";i:250000;s:10:\"created_at\";s:27:\"2021-07-29T01:48:01.000000Z\";s:10:\"updated_at\";s:27:\"2021-07-29T01:48:07.000000Z\";}}}', 265000, 0, 0, 265000, 300000, '1', 1, NULL, '2021-07-28 19:09:30', '2021-07-29 20:17:12'),
(12, 'TPO-20211011-0708', 'a:1:{i:0;a:4:{s:2:\"id\";i:4;s:3:\"qty\";i:2;s:5:\"harga\";i:76000;s:6:\"produk\";a:10:{s:2:\"id\";i:4;s:4:\"nama\";s:3:\"Ban\";s:9:\"deskripsi\";s:53:\"ban adalah benda putar untuk membantu gerak kendaraan\";s:4:\"stok\";i:97;s:10:\"harga_beli\";i:35000;s:10:\"harga_jual\";i:38000;s:4:\"foto\";s:78:\"a:2:{i:0;s:24:\"596aa63d9dd5611b29f2.jpg\";i:1;s:24:\"cab5c01e1436e601f129.jpg\";}\";s:10:\"id_bengkel\";i:2;s:10:\"created_at\";s:27:\"2021-07-13T03:06:19.000000Z\";s:10:\"updated_at\";s:27:\"2021-10-11T07:08:45.000000Z\";}}}', 'a:1:{i:0;a:3:{s:2:\"id\";i:3;s:5:\"harga\";i:250000;s:4:\"jasa\";a:5:{s:2:\"id\";i:3;s:4:\"nama\";s:21:\"Fuel injection system\";s:5:\"harga\";i:250000;s:10:\"created_at\";s:27:\"2021-07-29T01:48:01.000000Z\";s:10:\"updated_at\";s:27:\"2021-07-29T01:48:07.000000Z\";}}}', 326000, 0, 0, 326000, 350000, '1', 1, 1, '2021-10-11 00:08:45', '2021-10-11 01:00:01'),
(13, 'TPO-20211011-0811', 'a:0:{}', 'a:1:{i:0;a:3:{s:2:\"id\";i:1;s:5:\"harga\";i:200000;s:4:\"jasa\";a:5:{s:2:\"id\";i:1;s:4:\"nama\";s:14:\"Engine tune up\";s:5:\"harga\";i:200000;s:10:\"created_at\";s:27:\"2021-07-06T02:44:10.000000Z\";s:10:\"updated_at\";s:27:\"2021-07-29T01:47:00.000000Z\";}}}', 200000, 0, 10000, 210000, 210000, '0', 1, 1, '2021-10-11 01:11:03', '2021-10-14 04:36:48'),
(14, 'TPO-20211011-0813', 'a:2:{i:0;a:4:{s:2:\"id\";i:4;s:3:\"qty\";i:2;s:5:\"harga\";i:76000;s:6:\"produk\";a:10:{s:2:\"id\";i:4;s:4:\"nama\";s:3:\"Ban\";s:9:\"deskripsi\";s:53:\"ban adalah benda putar untuk membantu gerak kendaraan\";s:4:\"stok\";i:93;s:10:\"harga_beli\";i:35000;s:10:\"harga_jual\";i:38000;s:4:\"foto\";s:78:\"a:2:{i:0;s:24:\"596aa63d9dd5611b29f2.jpg\";i:1;s:24:\"cab5c01e1436e601f129.jpg\";}\";s:10:\"id_bengkel\";i:2;s:10:\"created_at\";s:27:\"2021-07-13T03:06:19.000000Z\";s:10:\"updated_at\";s:27:\"2021-10-14T13:40:02.000000Z\";}}i:1;a:4:{s:2:\"id\";i:3;s:3:\"qty\";i:5;s:5:\"harga\";i:25000;s:6:\"produk\";a:10:{s:2:\"id\";i:3;s:4:\"nama\";s:4:\"Busi\";s:9:\"deskripsi\";s:16:\"busi adalah sapi\";s:4:\"stok\";i:12;s:10:\"harga_beli\";i:4000;s:10:\"harga_jual\";i:5000;s:4:\"foto\";s:78:\"a:2:{i:0;s:24:\"814988da9df493b559cf.jpg\";i:1;s:24:\"02adc0c1d064e8b4c45c.jpg\";}\";s:10:\"id_bengkel\";i:2;s:10:\"created_at\";s:27:\"2021-07-13T03:01:55.000000Z\";s:10:\"updated_at\";s:27:\"2022-01-01T06:51:35.000000Z\";}}}', 'a:0:{}', 101000, 0, 10100, 111100, 150000, '1', 1, 1, '2021-10-11 01:13:16', '2022-01-01 00:00:50'),
(16, 'TPO-20211014-1340', 'a:1:{i:0;a:3:{s:2:\"id\";i:4;s:3:\"qty\";i:2;s:5:\"harga\";i:76000;}}', 'a:2:{i:0;a:2:{s:2:\"id\";i:1;s:5:\"harga\";i:200000;}i:1;a:2:{s:2:\"id\";i:3;s:5:\"harga\";i:250000;}}', 526000, 0, 52600, 578600, 600000, '0', 1, NULL, '2021-10-14 06:40:02', '2021-10-14 06:40:02'),
(17, 'TPO-20220101-0651', 'a:1:{i:0;a:3:{s:2:\"id\";i:3;s:3:\"qty\";i:2;s:5:\"harga\";i:10000;}}', 'a:1:{i:0;a:2:{s:2:\"id\";i:2;s:5:\"harga\";i:100000;}}', 110000, 0, 11000, 121000, 200000, '0', 1, NULL, '2021-12-31 23:51:35', '2021-12-31 23:51:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_user`
--

CREATE TABLE `data_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_bengkel` bigint(20) UNSIGNED NOT NULL,
  `level` enum('1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1 = root, 2 = admin, 3 = pekerja, 4 = kasir',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_user`
--

INSERT INTO `data_user` (`id`, `username`, `password`, `nama`, `email`, `telepon`, `alamat`, `id_bengkel`, `level`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$10$.f7nR8X0AzPC9zMLWDMcHeiNnZA0.hK.1OPlS/VJ.f280xm4jkHDu', 'Muhammad Alfiansyah', 'iansyah@gmail.com', '082330538264', 'Karanganyar - Gumukmas - Jember', 1, '1', '2021-07-05 19:40:42', '2021-07-29 21:12:53');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `data_work_order`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `data_work_order` (
`id` bigint(20) unsigned
,`kode` varchar(255)
,`keluhan` text
,`perintah_kerja` text
,`total_harga` int(11)
,`total_bayar` int(11)
,`id_transaksi` bigint(20) unsigned
,`id_kendaraan_pelanggan` bigint(20) unsigned
,`id_teknisi` bigint(20) unsigned
,`id_user` bigint(20) unsigned
,`status_pengerjaan` enum('0','1','2')
,`status` enum('0','1','2')
,`created_at` timestamp
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan_pelanggan`
--

CREATE TABLE `kendaraan_pelanggan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merek` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year(4) NOT NULL,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_rangka` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_mesin` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_plat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_pelanggan` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kendaraan_pelanggan`
--

INSERT INTO `kendaraan_pelanggan` (`id`, `merek`, `brand`, `tahun`, `warna`, `nomor_rangka`, `nomor_mesin`, `nomor_plat`, `deskripsi`, `service`, `id_pelanggan`) VALUES
(1, 'Honda', 'Beat', 2010, 'Merah', '87654321', '12345678', 'P 38748 DO', '-', 'service 1', 1),
(2, 'Honda', 'Beat', 2014, 'Biru Putih', NULL, NULL, 'B 23746 NP', '-', 'service 1', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_07_05_021200_bengkel', 1),
(2, '2021_07_05_021215_user', 1),
(3, '2021_07_05_021253_produk', 1),
(4, '2021_07_05_021635_transaksi_produk', 1),
(5, '2021_07_05_021745_jasa', 1),
(6, '2021_07_05_021749_transaksi_jasa', 1),
(7, '2021_07_05_021832_kas', 1),
(8, '2021_07_05_021216_pelanggan', 2),
(9, '2021_07_26_002932_supplier', 2),
(11, '2021_07_27_004052_transaksi', 3),
(13, '2021_07_26_020226_kendaraan_pelanggan', 4),
(14, '2021_07_27_004145_service', 5);

-- --------------------------------------------------------

--
-- Struktur untuk view `data_estimasi`
--
DROP TABLE IF EXISTS `data_estimasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `data_estimasi`  AS SELECT `data_service`.`id` AS `id`, `data_service`.`kode` AS `kode`, `data_service`.`keluhan` AS `keluhan`, `data_service`.`id_kendaraan_pelanggan` AS `id_kendaraan_pelanggan`, `data_service`.`id_transaksi` AS `id_transaksi`, `data_service`.`id_user` AS `id_user`, `data_service`.`status` AS `status`, `data_service`.`created_at` AS `created_at`, `data_service`.`updated_at` AS `updated_at` FROM `data_service` WHERE `data_service`.`status` = '0' ;

-- --------------------------------------------------------

--
-- Struktur untuk view `data_invoice`
--
DROP TABLE IF EXISTS `data_invoice`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `data_invoice`  AS SELECT `data_service`.`id` AS `id`, `data_service`.`kode` AS `kode`, `data_service`.`keluhan` AS `keluhan`, `data_service`.`id_kendaraan_pelanggan` AS `id_kendaraan_pelanggan`, `data_service`.`id_transaksi` AS `id_transaksi`, `data_service`.`id_user` AS `id_user`, `data_service`.`status` AS `status`, `data_service`.`created_at` AS `created_at`, `data_service`.`updated_at` AS `updated_at` FROM `data_service` WHERE `data_service`.`status` = '2' OR `data_service`.`status` = '1' ;

-- --------------------------------------------------------

--
-- Struktur untuk view `data_work_order`
--
DROP TABLE IF EXISTS `data_work_order`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `data_work_order`  AS SELECT `data_service`.`id` AS `id`, `data_service`.`kode` AS `kode`, `data_service`.`keluhan` AS `keluhan`, `data_service`.`perintah_kerja` AS `perintah_kerja`, `data_service`.`total_harga` AS `total_harga`, `data_service`.`total_bayar` AS `total_bayar`, `data_service`.`id_transaksi` AS `id_transaksi`, `data_service`.`id_kendaraan_pelanggan` AS `id_kendaraan_pelanggan`, `data_service`.`id_teknisi` AS `id_teknisi`, `data_service`.`id_user` AS `id_user`, `data_service`.`status_pengerjaan` AS `status_pengerjaan`, `data_service`.`status` AS `status`, `data_service`.`created_at` AS `created_at`, `data_service`.`updated_at` AS `updated_at` FROM `data_service` WHERE `data_service`.`status` = '2' ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_bengkel`
--
ALTER TABLE `data_bengkel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_jasa`
--
ALTER TABLE `data_jasa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_kas`
--
ALTER TABLE `data_kas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_id_user` (`id_user`);

--
-- Indeks untuk tabel `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_produk`
--
ALTER TABLE `data_produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produk_id_bengkel` (`id_bengkel`);

--
-- Indeks untuk tabel `data_service`
--
ALTER TABLE `data_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id_user` (`id_user`),
  ADD KEY `service_id_kendaraan_pelanggan` (`id_kendaraan_pelanggan`),
  ADD KEY `service_id_transaksi` (`id_transaksi`);

--
-- Indeks untuk tabel `data_supplier`
--
ALTER TABLE `data_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_teknisi`
--
ALTER TABLE `data_teknisi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_transaksi`
--
ALTER TABLE `data_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id_user` (`id_user`),
  ADD KEY `transaksi_id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_bengkel` (`id_bengkel`);

--
-- Indeks untuk tabel `kendaraan_pelanggan`
--
ALTER TABLE `kendaraan_pelanggan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kendaraan_pelanggan_id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_bengkel`
--
ALTER TABLE `data_bengkel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `data_jasa`
--
ALTER TABLE `data_jasa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `data_kas`
--
ALTER TABLE `data_kas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `data_produk`
--
ALTER TABLE `data_produk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `data_service`
--
ALTER TABLE `data_service`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `data_supplier`
--
ALTER TABLE `data_supplier`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_teknisi`
--
ALTER TABLE `data_teknisi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_transaksi`
--
ALTER TABLE `data_transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kendaraan_pelanggan`
--
ALTER TABLE `kendaraan_pelanggan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_kas`
--
ALTER TABLE `data_kas`
  ADD CONSTRAINT `kas_id_user` FOREIGN KEY (`id_user`) REFERENCES `data_user` (`id`);

--
-- Ketidakleluasaan untuk tabel `data_produk`
--
ALTER TABLE `data_produk`
  ADD CONSTRAINT `produk_id_bengkel` FOREIGN KEY (`id_bengkel`) REFERENCES `data_bengkel` (`id`);

--
-- Ketidakleluasaan untuk tabel `data_service`
--
ALTER TABLE `data_service`
  ADD CONSTRAINT `service_id_kendaraan_pelanggan` FOREIGN KEY (`id_kendaraan_pelanggan`) REFERENCES `kendaraan_pelanggan` (`id`),
  ADD CONSTRAINT `service_id_user` FOREIGN KEY (`id_user`) REFERENCES `data_user` (`id`);

--
-- Ketidakleluasaan untuk tabel `data_transaksi`
--
ALTER TABLE `data_transaksi`
  ADD CONSTRAINT `transaksi_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id`),
  ADD CONSTRAINT `transaksi_id_user` FOREIGN KEY (`id_user`) REFERENCES `data_user` (`id`);

--
-- Ketidakleluasaan untuk tabel `data_user`
--
ALTER TABLE `data_user`
  ADD CONSTRAINT `user_id_bengkel` FOREIGN KEY (`id_bengkel`) REFERENCES `data_bengkel` (`id`);

--
-- Ketidakleluasaan untuk tabel `kendaraan_pelanggan`
--
ALTER TABLE `kendaraan_pelanggan`
  ADD CONSTRAINT `kendaraan_pelanggan_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `data_pelanggan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
