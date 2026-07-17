-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jul 2026 pada 09.02
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baginda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_02_045550_create_tb_hakakses_table', 2),
(5, '2026_06_02_050150_rename_users_to_tb_user', 3),
(6, '2026_06_03_010327_create_tb_kaleng_table', 4),
(7, '2026_06_03_010328_create_tb_pemilikkaleng_table', 4),
(8, '2026_06_03_010329_create_tb_transaksi_kaleng_table', 4),
(9, '2026_06_03_000001_create_tb_penerimaan_kaleng_table', 5),
(10, '2026_06_03_000002_remove_tb_kaleng_id_from_tb_penerimaan_kaleng', 5),
(11, '2026_06_03_200000_create_tb_kas_table', 6),
(12, '2026_06_03_210000_add_operator_koin_hakakses', 7),
(13, '2026_06_03_210100_update_operator_koin_hakakses', 7),
(14, '2026_06_04_052043_create_tb_guru_table', 7),
(15, '2026_06_04_052044_create_tb_kelas_table', 7),
(16, '2026_06_04_052044_create_tb_santri_table', 7),
(17, '2026_06_04_052045_create_tb_absensi_santri_table', 7),
(18, '2026_06_04_062509_add_akses_modul_to_tb_user_table', 8),
(19, '2026_06_04_065000_create_tpq_keuangan_tables', 9),
(20, '2026_06_04_070000_create_tb_setting_table', 10),
(21, '2026_06_04_072209_add_no_wa_to_tb_pemilikkaleng_table', 11),
(22, '2026_06_04_080000_create_operasional_tables', 12),
(23, '2026_06_22_084454_add_foto_masjid_to_tb_setting_table', 13),
(24, '2026_06_22_090154_add_logo_to_tb_setting_table', 14),
(25, '2026_06_22_092453_create_tb_pengumuman_table', 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kSBURSBFAx51dP1n5BhAl9bkM15rN9bzvtSVHpdz', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieWdFakZ5bHppcllJRnVmQnJSaEZXbHBlMk1nY3FBQ0VXY3JodE9lNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9kZW1vLmxvdHVzY29tcHV0YW1hLmNvbS9iYWdpbmRhL3B1YmxpYy9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1782312501),
('WH3RI8afUsI9c1ACIGSFc3hiBFy7LnscHDTFGAno', 4, '::1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYm1kUUFkTE5xajAxYTJCcXk3bkRLMXQ3dVRHNWtoVFZQQWEyZ05tYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9kZW1vLmxvdHVzY29tcHV0YW1hLmNvbS9iYWdpbmRhL3B1YmxpYy9rb2luLWJhZ2luZGEiO3M6NToicm91dGUiO3M6MTA6ImtvaW4uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1782309627);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_absensi_santri`
--

CREATE TABLE `tb_absensi_santri` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_santri_id` bigint(20) UNSIGNED NOT NULL,
  `tb_kelas_id` bigint(20) UNSIGNED NOT NULL,
  `tb_guru_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` varchar(1) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_absensi_santri`
--

INSERT INTO `tb_absensi_santri` (`id`, `tb_santri_id`, `tb_kelas_id`, `tb_guru_id`, `tanggal`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, '2026-06-04', 'H', NULL, '2026-06-03 22:34:33', '2026-06-03 22:34:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_jenis_barang_id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL DEFAULT 'Unit',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_guru`
--

INSERT INTO `tb_guru` (`id`, `tb_user_id`, `nip`, `nama_guru`, `no_hp`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 6, '001', 'Ahmad Khoirudin', '088239382024', 'Jeruk Sawit, Jeruk Sawit, Gondangrejo, Karanganyar', '2026-06-03 22:30:14', '2026-06-04 00:47:16'),
(2, 8, '002', 'Alifah', NULL, 'Asrama ISI Surakarta Mojosongo', '2026-06-03 22:31:16', '2026-06-04 00:50:20'),
(3, 7, '003', 'Amel', NULL, 'Asrama ISI Surakarta Mojosongo', '2026-06-03 22:31:40', '2026-06-04 00:50:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_hakakses`
--

CREATE TABLE `tb_hakakses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_hakakses` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_hakakses`
--

INSERT INTO `tb_hakakses` (`id`, `nama_hakakses`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'administrator', 'Admin dengan akses penuh ke sistem', '2026-06-01 21:56:21', '2026-06-01 21:56:21'),
(2, 'operator', 'Operator pengelola data operasional', '2026-06-01 21:56:21', '2026-06-01 21:56:21'),
(3, 'bendahara', 'Bendahara pengelola keuangan', '2026-06-01 21:56:21', '2026-06-01 21:56:21'),
(4, 'tpq', 'Pengelola TPQ', '2026-06-01 21:56:21', '2026-06-01 21:56:21'),
(5, 'operator koin', 'Operator Koin Baginda', '2026-06-03 07:08:57', '2026-06-03 07:08:57'),
(6, 'guru tpq', 'Guru TPQ', '2026-06-03 22:21:15', '2026-06-03 22:21:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_inventaris`
--

CREATE TABLE `tb_inventaris` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_barang_id` bigint(20) UNSIGNED NOT NULL,
  `kode_inventaris` varchar(255) NOT NULL,
  `tanggal_perolehan` date NOT NULL,
  `asal_usul` varchar(255) NOT NULL DEFAULT 'Pembelian Kas',
  `kondisi` enum('baik','rusak_ringan','rusak_berat') NOT NULL DEFAULT 'baik',
  `lokasi` varchar(255) NOT NULL,
  `harga_perolehan` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis_barang`
--

CREATE TABLE `tb_jenis_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_jenis` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kaleng`
--

CREATE TABLE `tb_kaleng` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_kaleng` varchar(255) NOT NULL,
  `nama_kaleng` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_kaleng`
--

INSERT INTO `tb_kaleng` (`id`, `kode_kaleng`, `nama_kaleng`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'BGD00001', 'BGD00001', NULL, '2026-06-02 18:09:57', '2026-06-02 18:09:57'),
(2, 'BGD00002', 'BGD00002', NULL, '2026-06-02 22:18:17', '2026-06-02 22:18:17'),
(3, 'BGD00003', 'BGD00003', NULL, '2026-06-03 00:35:32', '2026-06-03 00:35:32'),
(4, 'BGD00004', 'BGD00004', NULL, '2026-06-03 00:35:39', '2026-06-03 00:35:39'),
(5, 'BGD00005', 'BGD00005', NULL, '2026-06-03 00:35:43', '2026-06-03 00:35:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kas`
--

CREATE TABLE `tb_kas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_kas` date NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tb_user_id` bigint(20) UNSIGNED NOT NULL,
  `tb_penerimaan_kaleng_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_kas`
--

INSERT INTO `tb_kas` (`id`, `tanggal_kas`, `tipe`, `jumlah`, `keterangan`, `tb_user_id`, `tb_penerimaan_kaleng_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '2026-06-03', 'masuk', 20000, 'infaq', 1, NULL, 'confirmed', '2026-06-02 21:39:06', '2026-06-02 23:56:04'),
(2, '2026-06-03', 'masuk', 10000, 'Penerimaan koin Baginda bulan Juni', 1, 1, 'confirmed', '2026-06-02 21:40:08', '2026-06-02 23:56:06'),
(3, '2026-06-03', 'keluar', 20000, 'beli atk', 1, NULL, 'confirmed', '2026-06-02 21:58:08', '2026-06-02 21:58:08'),
(4, '2026-06-03', 'masuk', 10000, 'infaq', 3, NULL, 'confirmed', '2026-06-02 23:59:05', '2026-06-02 23:59:05'),
(5, '2026-06-03', 'masuk', 1000, 'infaq', 1, NULL, 'pending', '2026-06-03 00:00:02', '2026-06-03 00:00:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `tb_guru_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_kelas`
--

INSERT INTO `tb_kelas` (`id`, `nama_kelas`, `tb_guru_id`, `created_at`, `updated_at`) VALUES
(1, 'Kelas 3', 1, '2026-06-03 22:30:26', '2026-06-03 22:30:26'),
(2, 'Kelas 2', 3, '2026-06-03 22:31:50', '2026-06-03 22:31:50'),
(3, 'Kelas 1', 2, '2026-06-03 22:31:57', '2026-06-03 22:31:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pemilikkaleng`
--

CREATE TABLE `tb_pemilikkaleng` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_kaleng_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `no_wa` varchar(255) DEFAULT NULL,
  `tanggal_diserahkan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_pemilikkaleng`
--

INSERT INTO `tb_pemilikkaleng` (`id`, `tb_kaleng_id`, `nama`, `alamat`, `no_wa`, `tanggal_diserahkan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lilik Rochmawan', 'Taman Harmoni Blok R28', '082327588785', '2026-06-03', '2026-06-02 18:11:32', '2026-06-04 00:24:56'),
(2, 2, 'Linggar Meyta Sari', 'R28', NULL, '2026-06-03', '2026-06-02 22:18:43', '2026-06-02 22:18:43'),
(3, 2, 'dimas kusuma aji', 'M21', NULL, '2026-06-03', '2026-06-03 00:18:30', '2026-06-03 00:35:07'),
(4, 3, 'Harun Rosyid', 'D2', '058989232354', '2026-06-23', '2026-06-24 06:32:52', '2026-06-24 06:32:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penerimaan_kaleng`
--

CREATE TABLE `tb_penerimaan_kaleng` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_penerimaan` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tb_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_penerimaan_kaleng`
--

INSERT INTO `tb_penerimaan_kaleng` (`id`, `tanggal_penerimaan`, `jumlah`, `keterangan`, `tb_user_id`, `created_at`, `updated_at`) VALUES
(1, '2026-06-03', 10000, 'bulan mei', 1, '2026-06-02 19:57:11', '2026-06-02 19:57:11'),
(2, '2026-06-24', 1000000, 'penerimaan bulan juli', 1, '2026-06-24 06:48:05', '2026-06-24 06:48:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengumuman`
--

CREATE TABLE `tb_pengumuman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rencana_kerja`
--

CREATE TABLE `tb_rencana_kerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_takmir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_program` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `anggaran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `target_selesai` date NOT NULL,
  `status` enum('belum_mulai','sedang_berjalan','selesai','dibatalkan') NOT NULL DEFAULT 'belum_mulai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_santri`
--

CREATE TABLE `tb_santri` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nis` varchar(255) DEFAULT NULL,
  `nama_santri` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `nama_orang_tua` varchar(255) DEFAULT NULL,
  `no_hp_orang_tua` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_santri`
--

INSERT INTO `tb_santri` (`id`, `tb_kelas_id`, `nis`, `nama_santri`, `jenis_kelamin`, `tanggal_lahir`, `nama_orang_tua`, `no_hp_orang_tua`, `created_at`, `updated_at`) VALUES
(1, 3, '0001', 'Muhammad Husain Rochmawan', 'L', '2022-05-24', 'Lilik Rochmawan', '082327588785', '2026-06-03 22:33:18', '2026-06-03 22:33:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_setting`
--

CREATE TABLE `tb_setting` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fonnte_token` text DEFAULT NULL,
  `midtrans_client_id` varchar(255) DEFAULT NULL,
  `midtrans_server_key` varchar(255) DEFAULT NULL,
  `midtrans_environment` varchar(255) NOT NULL DEFAULT 'sandbox',
  `foto_masjid` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_setting`
--

INSERT INTO `tb_setting` (`id`, `fonnte_token`, `midtrans_client_id`, `midtrans_server_key`, `midtrans_environment`, `foto_masjid`, `logo`, `created_at`, `updated_at`) VALUES
(1, '7pukdbKa9hcQMHyxqy8r', 'lilik@baginda.local', NULL, 'sandbox', 'settings/RwdJteaBN1022wCIY8PhO2HRyupuq8kD979sUxbB.png', 'settings/3xrUO6S8FDcuBgdr5RaOu0vakFTdoWe7SseihZtP.jpg', '2026-06-04 00:04:35', '2026-06-22 02:16:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_spp_pembayaran`
--

CREATE TABLE `tb_spp_pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_santri_id` bigint(20) UNSIGNED NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `tb_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_spp_pembayaran`
--

INSERT INTO `tb_spp_pembayaran` (`id`, `tb_santri_id`, `bulan`, `tahun`, `jumlah`, `tanggal_bayar`, `tb_user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2026, 20000, '2026-06-04', 1, '2026-06-03 23:58:40', '2026-06-03 23:58:40'),
(2, 1, 2, 2026, 20000, '2026-06-04', 1, '2026-06-04 00:14:09', '2026-06-04 00:14:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_surat`
--

CREATE TABLE `tb_surat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe` enum('masuk','keluar','proposal') NOT NULL,
  `nomor_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `tanggal_diterima` date DEFAULT NULL,
  `pengirim` varchar(255) DEFAULT NULL,
  `penerima` varchar(255) DEFAULT NULL,
  `perihal` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `status_proposal` enum('pending','disetujui','ditolak') DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_takmir`
--

CREATE TABLE `tb_takmir` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `status` enum('aktif','non_aktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tpq_kas`
--

CREATE TABLE `tb_tpq_kas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tb_spp_pembayaran_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tb_user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_tpq_kas`
--

INSERT INTO `tb_tpq_kas` (`id`, `tanggal`, `tipe`, `jumlah`, `keterangan`, `tb_spp_pembayaran_id`, `tb_user_id`, `created_at`, `updated_at`) VALUES
(1, '2026-06-04', 'masuk', 20000, 'Pembayaran SPP Ananda Muhammad Husain Rochmawan untuk bulan Januari 2026', 1, 1, '2026-06-03 23:58:40', '2026-06-03 23:58:40'),
(2, '2026-06-04', 'masuk', 20000, 'Pembayaran SPP Ananda Muhammad Husain Rochmawan untuk bulan Februari 2026', 2, 1, '2026-06-04 00:14:09', '2026-06-04 00:14:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi_kaleng`
--

CREATE TABLE `tb_transaksi_kaleng` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_kaleng_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_ambil` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_transaksi_kaleng`
--

INSERT INTO `tb_transaksi_kaleng` (`id`, `tb_kaleng_id`, `tanggal_ambil`, `keterangan`, `created_at`, `updated_at`) VALUES
(4, 2, '2026-06-04', 'Pengambilan isi kaleng bulanan', '2026-06-04 00:28:52', '2026-06-04 00:28:52'),
(5, 1, '2026-06-04', 'Pengambilan isi kaleng bulanan', '2026-06-04 00:30:23', '2026-06-04 00:30:23'),
(6, 3, '2026-06-24', 'Pengambilan isi kaleng bulanan', '2026-06-24 06:45:47', '2026-06-24 06:45:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tb_hakakses_id` bigint(20) UNSIGNED NOT NULL DEFAULT 2,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `akses_modul` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id`, `tb_hakakses_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `akses_modul`) VALUES
(1, 1, 'Lilik', 'lilik@baginda.local', '2026-06-01 22:02:23', '$2y$12$A4c2I8Hqbyx7ha9TpynxMee5JnTaWTK70EHMUkrhgMUJ1.hsFcaQy', NULL, '2026-06-01 22:02:24', '2026-06-03 22:12:59', NULL),
(2, 5, 'Daryanto', 'daryanto@baginda.local', NULL, '$2y$12$3pX8AMb2ler13Nk2xd3.hu4k6frS56.1K7TqBB2b9okgkmN/BbMJe', NULL, '2026-06-02 22:27:05', '2026-06-03 23:37:18', '[\"koin\",\"koin.inventory\",\"koin.pemilik\",\"koin.scan\",\"koin.penerimaan\",\"koin.laporan\"]'),
(3, 3, 'Agung Susilo', 'agungsusilo@baginda.local', NULL, '$2y$12$EiWqMkWTXGTfIJBp0z0LV.F1to6jVoZ0TAWv8FTjwJ96TY1cXBEPm', NULL, '2026-06-02 22:29:40', '2026-06-03 23:37:35', '[\"koin\",\"koin.inventory\",\"koin.pemilik\",\"koin.scan\",\"koin.penerimaan\",\"koin.laporan\",\"keuangan\",\"keuangan.transaksi\",\"keuangan.laporan\"]'),
(4, 1, 'Dimas Kusuma Aji', 'dimaskusuma@baginda.local', NULL, '$2y$12$.VJcjsZ/XudcEW0mj1.86eotRrSUiteB.C2pk77t.g4M8h.pWt5k.', NULL, '2026-06-03 05:48:51', '2026-06-03 05:48:51', NULL),
(5, 4, 'Linggar Meyta Sari', 'linggar@baginda.local', NULL, '$2y$12$clkbBgivvadoRI9l3NrJF.iZrpFWOs44ub8HNcXJJ9K96hugAmY7G', NULL, '2026-06-03 23:30:43', '2026-06-03 23:34:57', '[\"tpq\",\"tpq.guru\",\"tpq.kelas\",\"tpq.santri\",\"tpq.absensi\",\"tpq.laporan\"]'),
(6, 6, 'Ahmad Khoirudin', 'ahmadkhoirudin@baginda.local', NULL, '$2y$12$c37HJbMfxd3ICP/SyC6g2ev8DEnwGMcb8Er6/pvX2iAO4qSPDq4vu', NULL, '2026-06-03 23:38:48', '2026-06-03 23:38:48', '[\"tpq\",\"tpq.santri\",\"tpq.absensi\"]'),
(7, 6, 'Amel', 'amel@baginda.local', NULL, '$2y$12$GryVy46H7sPdtvmVE9OhB.OpBzEENpznYeARZ9RFFAx1o/biM2XTC', NULL, '2026-06-04 00:49:31', '2026-06-04 00:49:31', '[\"tpq\",\"tpq.santri\",\"tpq.absensi\"]'),
(8, 6, 'Alifah', 'alifah@baginda.local', NULL, '$2y$12$pJjzO/BxgSOs0YLPOSVqKuoZ/ajQd.jXsMjNoVWOzS8QtPYGZ7TI.', NULL, '2026-06-04 00:49:56', '2026-06-04 00:49:56', '[\"tpq\",\"tpq.santri\",\"tpq.absensi\"]');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_wa_template`
--

CREATE TABLE `tb_wa_template` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `template` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_wa_template`
--

INSERT INTO `tb_wa_template` (`id`, `key`, `template`, `created_at`, `updated_at`) VALUES
(1, 'spp_kuitansi', '*_Assalamu\'alaikum wr. wb._*\r\n\r\nYth Wali Santri *{nama_santri}*\r\n\r\nTerima kasih, pembayaran SPP Ananda *{nama_santri}* untuk bulan *{bulan} {tahun}* sebesar *Rp {jumlah}* telah kami terima pada tanggal *{tanggal_bayar}*.\r\n\r\nSyukron jazakumullah khairan.', '2026-06-03 23:50:16', '2026-06-04 00:15:27'),
(2, 'koin_scan', '*_Assalamu\'alaikum wr. wb._*\n\nYth. Bapak/Ibu *{nama_pemilik}*,\n\nKaleng dengan kode *{kode_kaleng}* ({nama_kaleng}) telah berhasil discan / diambil oleh petugas pada tanggal *{tanggal_ambil}*.\n\nTerima kasih atas infak dan partisipasi Anda dalam program Koin Baginda. Semoga menjadi amal jariyah dan membawa berkah bagi keluarga.\n\n*_Wassalamu\'alaikum wr. wb._*', '2026-06-04 00:30:23', '2026-06-04 00:30:23');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tb_absensi_santri`
--
ALTER TABLE `tb_absensi_santri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_absensi_santri_tb_santri_id_tanggal_unique` (`tb_santri_id`,`tanggal`),
  ADD KEY `tb_absensi_santri_tb_kelas_id_foreign` (`tb_kelas_id`),
  ADD KEY `tb_absensi_santri_tb_guru_id_foreign` (`tb_guru_id`);

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_barang_tb_jenis_barang_id_foreign` (`tb_jenis_barang_id`);

--
-- Indeks untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_guru_tb_user_id_unique` (`tb_user_id`),
  ADD UNIQUE KEY `tb_guru_nip_unique` (`nip`);

--
-- Indeks untuk tabel `tb_hakakses`
--
ALTER TABLE `tb_hakakses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_hakakses_nama_hakakses_unique` (`nama_hakakses`);

--
-- Indeks untuk tabel `tb_inventaris`
--
ALTER TABLE `tb_inventaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_inventaris_kode_inventaris_unique` (`kode_inventaris`),
  ADD KEY `tb_inventaris_tb_barang_id_foreign` (`tb_barang_id`);

--
-- Indeks untuk tabel `tb_jenis_barang`
--
ALTER TABLE `tb_jenis_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_kaleng`
--
ALTER TABLE `tb_kaleng`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_kaleng_kode_kaleng_unique` (`kode_kaleng`);

--
-- Indeks untuk tabel `tb_kas`
--
ALTER TABLE `tb_kas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_kas_tb_user_id_foreign` (`tb_user_id`),
  ADD KEY `tb_kas_tb_penerimaan_kaleng_id_foreign` (`tb_penerimaan_kaleng_id`);

--
-- Indeks untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_kelas_tb_guru_id_foreign` (`tb_guru_id`);

--
-- Indeks untuk tabel `tb_pemilikkaleng`
--
ALTER TABLE `tb_pemilikkaleng`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_pemilikkaleng_tb_kaleng_id_foreign` (`tb_kaleng_id`);

--
-- Indeks untuk tabel `tb_penerimaan_kaleng`
--
ALTER TABLE `tb_penerimaan_kaleng`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_penerimaan_kaleng_tb_user_id_foreign` (`tb_user_id`);

--
-- Indeks untuk tabel `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_rencana_kerja`
--
ALTER TABLE `tb_rencana_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_rencana_kerja_tb_takmir_id_foreign` (`tb_takmir_id`);

--
-- Indeks untuk tabel `tb_santri`
--
ALTER TABLE `tb_santri`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_santri_nis_unique` (`nis`),
  ADD KEY `tb_santri_tb_kelas_id_foreign` (`tb_kelas_id`);

--
-- Indeks untuk tabel `tb_setting`
--
ALTER TABLE `tb_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_spp_pembayaran`
--
ALTER TABLE `tb_spp_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_spp_pembayaran_tb_santri_id_bulan_tahun_unique` (`tb_santri_id`,`bulan`,`tahun`),
  ADD KEY `tb_spp_pembayaran_tb_user_id_foreign` (`tb_user_id`);

--
-- Indeks untuk tabel `tb_surat`
--
ALTER TABLE `tb_surat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_takmir`
--
ALTER TABLE `tb_takmir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_takmir_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `tb_tpq_kas`
--
ALTER TABLE `tb_tpq_kas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_tpq_kas_tb_spp_pembayaran_id_foreign` (`tb_spp_pembayaran_id`),
  ADD KEY `tb_tpq_kas_tb_user_id_foreign` (`tb_user_id`);

--
-- Indeks untuk tabel `tb_transaksi_kaleng`
--
ALTER TABLE `tb_transaksi_kaleng`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_transaksi_kaleng_tb_kaleng_id_foreign` (`tb_kaleng_id`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `tb_user_tb_hakakses_id_foreign` (`tb_hakakses_id`);

--
-- Indeks untuk tabel `tb_wa_template`
--
ALTER TABLE `tb_wa_template`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tb_wa_template_key_unique` (`key`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tb_absensi_santri`
--
ALTER TABLE `tb_absensi_santri`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_hakakses`
--
ALTER TABLE `tb_hakakses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_inventaris`
--
ALTER TABLE `tb_inventaris`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_jenis_barang`
--
ALTER TABLE `tb_jenis_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_kaleng`
--
ALTER TABLE `tb_kaleng`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_kas`
--
ALTER TABLE `tb_kas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_pemilikkaleng`
--
ALTER TABLE `tb_pemilikkaleng`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_penerimaan_kaleng`
--
ALTER TABLE `tb_penerimaan_kaleng`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_rencana_kerja`
--
ALTER TABLE `tb_rencana_kerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_santri`
--
ALTER TABLE `tb_santri`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_setting`
--
ALTER TABLE `tb_setting`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_spp_pembayaran`
--
ALTER TABLE `tb_spp_pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_surat`
--
ALTER TABLE `tb_surat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_takmir`
--
ALTER TABLE `tb_takmir`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_tpq_kas`
--
ALTER TABLE `tb_tpq_kas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_transaksi_kaleng`
--
ALTER TABLE `tb_transaksi_kaleng`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_wa_template`
--
ALTER TABLE `tb_wa_template`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_absensi_santri`
--
ALTER TABLE `tb_absensi_santri`
  ADD CONSTRAINT `tb_absensi_santri_tb_guru_id_foreign` FOREIGN KEY (`tb_guru_id`) REFERENCES `tb_guru` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tb_absensi_santri_tb_kelas_id_foreign` FOREIGN KEY (`tb_kelas_id`) REFERENCES `tb_kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_absensi_santri_tb_santri_id_foreign` FOREIGN KEY (`tb_santri_id`) REFERENCES `tb_santri` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD CONSTRAINT `tb_barang_tb_jenis_barang_id_foreign` FOREIGN KEY (`tb_jenis_barang_id`) REFERENCES `tb_jenis_barang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD CONSTRAINT `tb_guru_tb_user_id_foreign` FOREIGN KEY (`tb_user_id`) REFERENCES `tb_user` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tb_inventaris`
--
ALTER TABLE `tb_inventaris`
  ADD CONSTRAINT `tb_inventaris_tb_barang_id_foreign` FOREIGN KEY (`tb_barang_id`) REFERENCES `tb_barang` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_kas`
--
ALTER TABLE `tb_kas`
  ADD CONSTRAINT `tb_kas_tb_penerimaan_kaleng_id_foreign` FOREIGN KEY (`tb_penerimaan_kaleng_id`) REFERENCES `tb_penerimaan_kaleng` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `tb_kas_tb_user_id_foreign` FOREIGN KEY (`tb_user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `tb_kelas_tb_guru_id_foreign` FOREIGN KEY (`tb_guru_id`) REFERENCES `tb_guru` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tb_pemilikkaleng`
--
ALTER TABLE `tb_pemilikkaleng`
  ADD CONSTRAINT `tb_pemilikkaleng_tb_kaleng_id_foreign` FOREIGN KEY (`tb_kaleng_id`) REFERENCES `tb_kaleng` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_penerimaan_kaleng`
--
ALTER TABLE `tb_penerimaan_kaleng`
  ADD CONSTRAINT `tb_penerimaan_kaleng_tb_user_id_foreign` FOREIGN KEY (`tb_user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_rencana_kerja`
--
ALTER TABLE `tb_rencana_kerja`
  ADD CONSTRAINT `tb_rencana_kerja_tb_takmir_id_foreign` FOREIGN KEY (`tb_takmir_id`) REFERENCES `tb_takmir` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tb_santri`
--
ALTER TABLE `tb_santri`
  ADD CONSTRAINT `tb_santri_tb_kelas_id_foreign` FOREIGN KEY (`tb_kelas_id`) REFERENCES `tb_kelas` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tb_spp_pembayaran`
--
ALTER TABLE `tb_spp_pembayaran`
  ADD CONSTRAINT `tb_spp_pembayaran_tb_santri_id_foreign` FOREIGN KEY (`tb_santri_id`) REFERENCES `tb_santri` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_spp_pembayaran_tb_user_id_foreign` FOREIGN KEY (`tb_user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_takmir`
--
ALTER TABLE `tb_takmir`
  ADD CONSTRAINT `tb_takmir_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `tb_takmir` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tb_tpq_kas`
--
ALTER TABLE `tb_tpq_kas`
  ADD CONSTRAINT `tb_tpq_kas_tb_spp_pembayaran_id_foreign` FOREIGN KEY (`tb_spp_pembayaran_id`) REFERENCES `tb_spp_pembayaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_tpq_kas_tb_user_id_foreign` FOREIGN KEY (`tb_user_id`) REFERENCES `tb_user` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_transaksi_kaleng`
--
ALTER TABLE `tb_transaksi_kaleng`
  ADD CONSTRAINT `tb_transaksi_kaleng_tb_kaleng_id_foreign` FOREIGN KEY (`tb_kaleng_id`) REFERENCES `tb_kaleng` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_tb_hakakses_id_foreign` FOREIGN KEY (`tb_hakakses_id`) REFERENCES `tb_hakakses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
