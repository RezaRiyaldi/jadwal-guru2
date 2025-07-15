-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 15, 2025 at 06:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jadwal-guru`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `gurus`
--

CREATE TABLE `gurus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `status` enum('aktif','tidak_aktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gurus`
--

INSERT INTO `gurus` (`id`, `user_id`, `nip`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, '15512312322', 'Cantika', 'P', 'Sukabumi', '2025-07-05', NULL, NULL, 'tidak_aktif', '2025-07-10 03:58:55', '2025-07-15 15:57:22'),
(2, 14, '31210284', 'Reza Riyaldi', 'L', 'Bandung', '2002-06-15', 'Perum Kertamukti\nJl. Pisang Batu', '085695186848', 'aktif', '2025-07-15 04:36:03', '2025-07-15 04:36:03'),
(3, 15, '881238828', 'Ariel', 'L', 'Bulak', '1995-06-01', 'Bulak', NULL, 'aktif', '2025-07-15 14:54:15', '2025-07-15 14:56:51'),
(4, 18, '123', 'Aldi', 'L', 'bekasi', '2025-07-11', NULL, NULL, 'aktif', '2025-07-15 15:38:09', '2025-07-15 15:38:09'),
(5, 19, NULL, 'Aut Numquam Officia ', 'L', 'Officiis nihil aliqu', '2025-07-13', 'Dolore voluptate dol', NULL, 'aktif', '2025-07-15 16:11:22', '2025-07-15 16:11:22');

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `mata_pelajaran_id` bigint(20) UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwals`
--

INSERT INTO `jadwals` (`id`, `kelas_id`, `guru_id`, `mata_pelajaran_id`, `hari`, `jam_mulai`, `jam_selesai`, `ruangan`, `keterangan`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 12, 'Senin', '07:30:00', '09:30:00', NULL, NULL, '2025-07-15 04:52:21', '2025-07-15 04:52:21'),
(5, 2, 2, 12, 'Senin', '07:30:00', '09:30:00', NULL, NULL, '2025-07-15 05:04:50', '2025-07-15 05:04:50'),
(6, 3, 2, 14, 'Senin', '10:00:00', '12:00:00', NULL, NULL, '2025-07-15 07:20:20', '2025-07-15 07:20:20'),
(7, 4, 3, 10, 'Senin', '07:30:00', '08:30:00', NULL, NULL, '2025-07-15 15:14:46', '2025-07-15 15:14:46'),
(8, 4, 3, 13, 'Senin', '09:00:00', '09:30:00', NULL, NULL, '2025-07-15 15:18:21', '2025-07-15 15:18:21'),
(9, 4, 4, 12, 'Selasa', '12:30:00', '13:30:00', NULL, NULL, '2025-07-15 15:39:15', '2025-07-15 15:39:15'),
(10, 4, 5, 11, 'Kamis', '15:00:00', '16:00:00', NULL, NULL, '2025-07-15 16:16:01', '2025-07-15 16:16:01'),
(11, 4, 4, 16, 'Kamis', '16:00:00', '17:00:00', NULL, NULL, '2025-07-15 16:26:20', '2025-07-15 16:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tingkat` tinyint(3) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `wali_kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `tingkat`, `nama_kelas`, `wali_kelas_id`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, '1A', 1, NULL, NULL, '2025-07-10 23:38:00'),
(2, 1, '1B', 1, NULL, '2025-07-10 23:41:02', '2025-07-11 08:54:49'),
(3, 2, '2A', 2, NULL, '2025-07-15 05:15:04', '2025-07-15 05:15:04'),
(4, 3, '3A', 4, NULL, '2025-07-15 14:59:01', '2025-07-15 15:39:42');

-- --------------------------------------------------------

--
-- Table structure for table `mata_pelajarans`
--

CREATE TABLE `mata_pelajarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tingkat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tingkat`)),
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mata_pelajarans`
--

INSERT INTO `mata_pelajarans` (`id`, `kode`, `nama`, `tingkat`, `deskripsi`, `created_at`, `updated_at`) VALUES
(9, 'MATE1234560001', 'Matematika', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:42:12', '2025-07-15 04:42:12'),
(10, 'BAHA1234560002', 'Bahasa Indonesia', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:42:20', '2025-07-15 04:42:20'),
(11, 'SENI1234560003', 'Seni Budaya dan Keterampilan', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:42:27', '2025-07-15 04:42:27'),
(12, 'AGAM1234560004', 'Agama Islam', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:42:32', '2025-07-15 04:42:32'),
(13, 'BAHA1234560005', 'Bahasa Inggris', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:42:38', '2025-07-15 04:42:38'),
(14, 'ILMU1234560006', 'Ilmu Pengetahuan Alam', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:43:03', '2025-07-15 04:43:03'),
(15, 'ILMU1234560007', 'Ilmu Pengetahuan Sosial', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:43:12', '2025-07-15 04:43:12'),
(16, 'SEJA1234560008', 'Sejarah', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:43:19', '2025-07-15 04:43:19'),
(17, 'PEND1234560009', 'Pendidikan Lingkungan Hidup', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:43:30', '2025-07-15 04:43:30'),
(18, 'PEND1234560010', 'Pendidikan Jasmani Olahraga dan Kesehatan', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', NULL, '2025-07-15 04:44:14', '2025-07-15 04:44:14'),
(19, 'TEKN0004560011', 'Teknik Informasi dan Komunikasi', '[\"4\",\"5\",\"6\"]', NULL, '2025-07-15 16:04:09', '2025-07-15 16:04:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_10_085344_create_gurus_table', 2),
(5, '2025_07_10_085344_create_kelas_table', 2),
(6, '2025_07_10_085344_create_murids_table', 2),
(7, '2025_07_10_085345_create_mata_pelajarans_table', 2),
(8, '2025_07_10_085346_create_jadwals_table', 3),
(9, '2025_07_10_090640_add_column_role_at_users', 4),
(10, '2025_07_11_164221_create_permission_tables', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `murids`
--

CREATE TABLE `murids` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nis` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `status` enum('aktif','lulus','keluar','pindah','meninggal') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `murids`
--

INSERT INTO `murids` (`id`, `user_id`, `kelas_id`, `nis`, `nama_lengkap`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `no_hp`, `status`, `created_at`, `updated_at`) VALUES
(1, 8, 1, '25710001', 'Aperiam recusandae', 'L', 'Alias debitis', '2025-07-10', 'Aliqua Ipsam dicta', NULL, 'pindah', '2025-07-10 02:46:35', '2025-07-15 15:43:59'),
(2, 12, 2, '18720001', 'John', 'P', 'Bekasi', '2018-07-01', 'Rem eligendi nostrud', NULL, 'aktif', '2025-07-11 00:32:00', '2025-07-11 00:32:00'),
(3, 16, 4, '250720003', 'Tatum', 'P', 'Cibit', '2018-04-01', 'Anim officia molliti', NULL, 'aktif', '2025-07-15 15:07:51', '2025-07-15 15:07:51'),
(4, 17, 4, '250710004', 'Nigga', 'L', 'Banten', '2019-07-06', 'Cupiditate nesciunt', NULL, 'aktif', '2025-07-15 15:09:59', '2025-07-15 15:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','tu','guru','murid') NOT NULL DEFAULT 'murid',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'admin@super.com', NULL, '$2y$12$kMoPpOKKUoJzDfgdRSH3P.Wvq6MUkjvZvCsyu4ySxaIEt4I.mjV3i', 'superadmin', 'klDArcNdbcTziKLRGQDB6tLs8r2yPHsWANehzPNMsl3fm1qVpwB86DOoPIVc', '2025-07-09 23:54:48', '2025-07-09 23:54:48'),
(8, 'aperiam_recusandae', 'sixesobequ@mailinator.com', NULL, '$2y$12$zQpRDwB/TQ.rNds0rNV2Lu85pUni8jZ24oWWCXiqo34CX31wJCW56', 'murid', NULL, '2025-07-10 02:46:35', '2025-07-12 17:49:52'),
(11, 'Cantika', 'can@tik.com', NULL, '$2y$12$7OFXfTksqZ7iT2LIDsAU9uSG/wzdP/fFezstwkCI2wmDRo2Z4Nr.m', 'guru', NULL, '2025-07-10 03:58:55', '2025-07-10 03:58:55'),
(12, 'john', 'kydodagasu@mailinator.com', NULL, '$2y$12$zsbq6RbkH30A/pCvIsIkYuQuSbvgQjlm6wEEcEbkvIkryf2wyyOcO', 'murid', NULL, '2025-07-11 00:32:00', '2025-07-11 00:32:00'),
(13, 'stafftu', 'stafftu@super.com', NULL, '$2y$12$2AsxxU52GZTD7VwzvR7pJuvYPKi54CsLA206iUWW8p0xMMULb8sSq', 'tu', NULL, '2025-07-12 17:54:17', '2025-07-12 17:54:17'),
(14, 'reza_riyaldi', 'reza@ret.co.id', NULL, '$2y$12$bJv8I4aIDDAt1Bnkt1umeOMeqa5bn4Cc84nHAN1L7.BZqMvRmNrY2', 'guru', NULL, '2025-07-15 04:36:03', '2025-07-15 04:36:03'),
(15, 'eaque_obcaecati_mole', 'hubifu@mailinator.com', NULL, '$2y$12$C8.miYHbngBu.lkRc.KGueAOIQx1UZb9V/F188NujgrgbJ5vJeSj6', 'guru', NULL, '2025-07-15 14:54:15', '2025-07-15 14:54:15'),
(16, 'tatum', 'geqigi@mailinator.com', NULL, '$2y$12$NWj2XgZPkqXXXS7L1EaidO.bhjxaN2qnggzICHKAibRELP1NCXwTG', 'murid', NULL, '2025-07-15 15:07:51', '2025-07-15 15:07:51'),
(17, 'nigga', 'gyqabe@mailinator.com', NULL, '$2y$12$nQTueoEww3L9UZ2UpW02COKuSI5Avw7.WFujlsXqZsqwJpF9JwmSK', 'murid', NULL, '2025-07-15 15:09:59', '2025-07-15 15:09:59'),
(18, 'aldi', 'aldi@gmail.com', NULL, '$2y$12$pWwLCCRlvwDd32M2lH1lr.oCcD9xrYC9v86S.KiAin3CkFmWzoDa.', 'guru', NULL, '2025-07-15 15:38:09', '2025-07-15 15:38:09'),
(19, 'aut_numquam_officia_', 'guma@mailinator.com', NULL, '$2y$12$tOR7Rkf09tmmAc4.CeyG6.M.jCYCAMa7cQcPhm4s6nbRhR5ym04a.', 'guru', NULL, '2025-07-15 16:11:22', '2025-07-15 16:11:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gurus`
--
ALTER TABLE `gurus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gurus_user_id_foreign` (`user_id`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwals_kelas_id_foreign` (`kelas_id`),
  ADD KEY `jadwals_guru_id_foreign` (`guru_id`),
  ADD KEY `jadwals_mata_pelajaran_id_foreign` (`mata_pelajaran_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_wali_kelas_id_foreign` (`wali_kelas_id`);

--
-- Indexes for table `mata_pelajarans`
--
ALTER TABLE `mata_pelajarans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mata_pelajarans_kode_unique` (`kode`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `murids`
--
ALTER TABLE `murids`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `murids_nis_unique` (`nis`),
  ADD KEY `murids_user_id_foreign` (`user_id`),
  ADD KEY `murids_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gurus`
--
ALTER TABLE `gurus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwals`
--
ALTER TABLE `jadwals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mata_pelajarans`
--
ALTER TABLE `mata_pelajarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `murids`
--
ALTER TABLE `murids`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gurus`
--
ALTER TABLE `gurus`
  ADD CONSTRAINT `gurus_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD CONSTRAINT `jadwals_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `gurus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwals_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwals_mata_pelajaran_id_foreign` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajarans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `gurus` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `murids`
--
ALTER TABLE `murids`
  ADD CONSTRAINT `murids_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `murids_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
