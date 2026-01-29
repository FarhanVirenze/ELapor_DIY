-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2026 at 02:56 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elaporr`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `model`, `model_id`, `description`, `ip_address`, `user_agent`, `payload`, `created_at`, `updated_at`) VALUES
(1, 1, 'UPDATE_STATUS', 'Report', 543, 'Superadmin mengubah status laporan #ADU-Y52T-91184 dari Diajukan menjadi Revisi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"new_status\": \"Revisi\", \"old_status\": \"Diajukan\"}', '2026-01-27 21:06:13', '2026-01-27 21:06:13'),
(2, 1, 'UPDATE_STATUS', 'Report', 631, 'Superadmin mengubah status laporan #SPEC-XKQ6-64912 dari Selesai menjadi Arsip', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"new_status\": \"Arsip\", \"old_status\": \"Selesai\"}', '2026-01-27 21:06:28', '2026-01-27 21:06:28'),
(3, 1, 'UPDATE_STATUS', 'Report', 628, 'Superadmin mengubah status laporan #SPEC-T01S-74437 dari Selesai menjadi Arsip', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"new_status\": \"Arsip\", \"old_status\": \"Selesai\"}', '2026-01-27 21:06:43', '2026-01-27 21:06:43'),
(4, 1, 'UPDATE_STATUS', 'Report', 627, 'Superadmin mengubah status laporan #SPEC-HZEO-58160 dari Selesai menjadi Arsip', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"new_status\": \"Arsip\", \"old_status\": \"Selesai\"}', '2026-01-27 21:07:11', '2026-01-27 21:07:11'),
(5, 1, 'UPDATE_STATUS', 'Report', 623, 'Superadmin mengubah status laporan #SPEC-9UKI-43383 dari Dibaca menjadi Revisi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"new_status\": \"Revisi\", \"old_status\": \"Dibaca\"}', '2026-01-27 21:07:25', '2026-01-27 21:07:25'),
(6, 1, 'UPDATE_STATUS', 'Report', 619, 'Superadmin mengubah status laporan #SPEC-0MRM-85843 dari Selesai menjadi Revisi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"new_status\": \"Revisi\", \"old_status\": \"Selesai\"}', '2026-01-27 21:07:38', '2026-01-27 21:07:38'),
(7, 1, 'UPDATE', 'Report', 619, 'Superadmin memperbarui laporan #SPEC-0MRM-85843', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": {\"new\": \"8\", \"old\": null}, \"updated_by\": {\"new\": 1, \"old\": null}, \"kategori_id\": {\"new\": \"1\", \"old\": 15}}', '2026-01-27 21:08:41', '2026-01-27 21:08:41'),
(8, 1, 'UPDATE_STATUS', 'Report', 629, 'Superadmin mengubah status laporan #SPEC-UVDC-41813 dari Dibaca menjadi Selesai', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"new_status\": \"Selesai\", \"old_status\": \"Dibaca\"}', '2026-01-27 21:11:54', '2026-01-27 21:11:54'),
(9, 1, 'UPDATE_STATUS', 'Report', 453, 'Superadmin mengubah status laporan #ADU-FOI3-76479 dari Diajukan menjadi Direspon', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"new_status\": \"Direspon\", \"old_status\": \"Diajukan\"}', '2026-01-27 21:12:10', '2026-01-27 21:12:10'),
(10, 1, 'DISPOSISI', 'Report', 618, 'Superadmin mendisposisikan laporan #SPEC-VY5L-13386 ke Admin: Dinas Pekerjaan Umum DIY, Kategori: Infrastruktur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"13\", \"kategori_id\": \"6\"}', '2026-01-27 21:13:25', '2026-01-27 21:13:25'),
(11, 1, 'DISPOSISI', 'Report', 499, 'Superadmin mendisposisikan laporan #ADU-FD2Y-21695 ke Admin: Dinas Pekerjaan Umum DIY, Kategori: Infrastruktur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"13\", \"kategori_id\": \"6\"}', '2026-01-27 21:13:41', '2026-01-27 21:13:41'),
(12, 1, 'DISPOSISI', 'Report', 475, 'Superadmin mendisposisikan laporan #ADU-F6KA-72095 ke Admin: Dinas Perhubungan DIY, Kategori: Transportasi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"12\", \"kategori_id\": \"5\"}', '2026-01-27 21:14:10', '2026-01-27 21:14:10'),
(13, 1, 'DISPOSISI', 'Report', 510, 'Superadmin mendisposisikan laporan #ADU-OIEH-81188 ke Admin: Dinas Pekerjaan Umum DIY, Kategori: Infrastruktur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"13\", \"kategori_id\": \"6\"}', '2026-01-27 21:14:32', '2026-01-27 21:14:32'),
(14, 1, 'DISPOSISI', 'Report', 577, 'Superadmin mendisposisikan laporan #ADU-OFHO-80230 ke Admin: Dinas Perhubungan DIY, Kategori: Transportasi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"12\", \"kategori_id\": \"5\"}', '2026-01-27 21:14:48', '2026-01-27 21:14:48'),
(15, 1, 'DISPOSISI', 'Report', 517, 'Superadmin mendisposisikan laporan #ADU-GY3D-88419 ke Admin: Dinas Lingkungan Hidup DIY, Kategori: Lingkungan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"14\", \"kategori_id\": \"7\"}', '2026-01-27 21:15:06', '2026-01-27 21:15:06'),
(16, 1, 'DISPOSISI', 'Report', 580, 'Superadmin mendisposisikan laporan #ADU-20HQ-19923 ke Admin: Dinas Kesehatan DIY, Kategori: Kesehatan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"9\", \"kategori_id\": \"2\"}', '2026-01-27 21:15:18', '2026-01-27 21:15:18'),
(17, 1, 'DISPOSISI', 'Report', 543, 'Superadmin mendisposisikan laporan #ADU-Y52T-91184 ke Admin: Dinas Kebudayaan DIY, Kategori: Kebudayaan', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"11\", \"kategori_id\": \"4\"}', '2026-01-27 21:15:37', '2026-01-27 21:15:37'),
(18, 1, 'DISPOSISI', 'Report', 607, 'Superadmin mendisposisikan laporan #ADU-AX3H-60814 ke Admin: Dinas Pekerjaan Umum DIY, Kategori: Infrastruktur', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"13\", \"kategori_id\": \"6\"}', '2026-01-27 21:15:49', '2026-01-27 21:15:49'),
(19, 1, 'DISPOSISI', 'Report', 563, 'Superadmin mendisposisikan laporan #ADU-IGOK-92774 ke Admin: Dinas Koperasi dan UKM DIY, Kategori: Koperasi & UKM', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"15\", \"kategori_id\": \"8\"}', '2026-01-27 21:16:00', '2026-01-27 21:16:00'),
(20, 1, 'DISPOSISI', 'Report', 555, 'Superadmin mendisposisikan laporan #ADU-IIAQ-57328 ke Admin: Dinas Koperasi dan UKM DIY, Kategori: Koperasi & UKM', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '{\"admin_id\": \"15\", \"kategori_id\": \"8\"}', '2026-01-27 21:16:13', '2026-01-27 21:16:13');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `followup_ratings`
--

CREATE TABLE `followup_ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `followup_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL,
  `komentar` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `follow_ups`
--

CREATE TABLE `follow_ups` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_umum`
--

CREATE TABLE `kategori_umum` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('wbs_admin','non_wbs_admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'non_wbs_admin',
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_umum`
--

INSERT INTO `kategori_umum` (`id`, `nama`, `tipe`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'Pendidikan', 'non_wbs_admin', 8, '2026-01-27 20:39:44', '2026-01-27 20:52:10'),
(2, 'Kesehatan', 'non_wbs_admin', 9, '2026-01-27 20:39:44', '2026-01-27 20:52:17'),
(3, 'Sosial', 'non_wbs_admin', 10, '2026-01-27 20:39:45', '2026-01-27 20:53:03'),
(4, 'Kebudayaan', 'non_wbs_admin', 11, '2026-01-27 20:39:45', '2026-01-27 20:52:33'),
(5, 'Transportasi', 'non_wbs_admin', 12, '2026-01-27 20:39:45', '2026-01-27 20:52:40'),
(6, 'Infrastruktur', 'non_wbs_admin', 13, '2026-01-27 20:39:46', '2026-01-27 20:52:54'),
(7, 'Lingkungan', 'non_wbs_admin', 14, '2026-01-27 20:39:46', '2026-01-27 20:53:11'),
(8, 'Koperasi & UKM', 'non_wbs_admin', 15, '2026-01-27 20:39:46', '2026-01-27 20:53:20'),
(9, 'Pertanian', 'non_wbs_admin', 16, '2026-01-27 20:39:47', '2026-01-27 20:53:31'),
(10, 'Pariwisata', 'non_wbs_admin', 17, '2026-01-27 20:39:47', '2026-01-27 20:53:42'),
(11, 'Informasi dan Teknologi', 'non_wbs_admin', 18, '2026-01-27 20:39:47', '2026-01-27 20:53:52'),
(12, 'Drainase / Saluran Air', 'non_wbs_admin', 13, '2026-01-27 20:50:36', '2026-01-27 20:52:54'),
(13, 'Penerangan Jalan', 'non_wbs_admin', 13, '2026-01-27 20:50:52', '2026-01-27 20:52:54'),
(14, 'Pembulian', 'non_wbs_admin', 10, '2026-01-27 20:50:59', '2026-01-27 20:53:03'),
(15, 'Penyimpangan dari Tugas dan Fungsi', 'wbs_admin', NULL, '2026-01-27 20:51:07', '2026-01-27 20:51:07'),
(16, 'Gratifikasi', 'wbs_admin', NULL, '2026-01-27 20:51:23', '2026-01-27 20:51:23'),
(17, 'Benturan Kepentingan', 'wbs_admin', NULL, '2026-01-27 20:51:33', '2026-01-27 20:51:33'),
(18, 'Melanggar Peraturan dan Perundangan yang Berlaku', 'wbs_admin', NULL, '2026-01-27 20:51:43', '2026-01-27 20:51:43'),
(19, 'Tindak Pidana Korupsi', 'wbs_admin', NULL, '2026-01-27 20:51:53', '2026-01-27 20:51:53');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_19_183719_create_wilayah_umum_table', 1),
(5, '2025_07_28_225626_create_kategori_umum_table', 1),
(6, '2025_07_28_225935_create_reports_table', 1),
(7, '2025_07_28_230055_create_follow_ups_table', 1),
(8, '2025_07_28_230127_create_comments_table', 1),
(9, '2025_07_28_230203_create_votes_table', 1),
(10, '2025_08_04_080621_add_foto_to_users_table', 1),
(11, '2025_08_17_200345_add_google_fields_to_users_table', 1),
(12, '2025_08_24_021836_add_updated_by_to_reports_table', 1),
(13, '2025_08_25_035717_create_followup_ratings_table', 1),
(14, '2025_08_27_214321_create_views_table', 1),
(15, '2025_08_28_110913_alter_users_add_wbs_admin_role', 1),
(16, '2025_08_29_002808_add_tipe_to_kategori_umum_table', 1),
(17, '2025_08_29_111840_create_wbs_reports_table', 1),
(18, '2025_08_29_224238_create_wbs_follow_ups_table', 1),
(19, '2025_08_29_224239_create_wbs_comments_table', 1),
(20, '2025_09_16_212901_add_is_arsip_to_reports_table', 1),
(21, '2025_09_16_214503_update_status_enum_in_reports_table', 1),
(22, '2025_11_11_114126_update_status_enum_in_reports_table', 1),
(23, '2025_11_11_115820_add_arsip_status_to_reports_table', 1),
(24, '2025_11_11_115946_update_status_enum_and_add_is_arsip_to_reports_table', 1),
(25, '2026_01_23_020122_add_komentar_revisi_to_reports_table', 1),
(26, '2026_01_23_022232_create_notifications_table', 1),
(27, '2026_01_23_051854_add_ai_fields_to_reports_table', 1),
(28, '2026_01_26_101419_create_activity_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0190c354-6dcc-4eba-940e-5a9a4b23266d', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 5, '{\"report_id\":619,\"tracking_id\":\"SPEC-0MRM-85843\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-0MRM-85843 telah berubah dari Selesai menjadi Revisi.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/daftar-aduan\\/619\\/detail\"}', NULL, '2026-01-27 21:07:38', '2026-01-27 21:07:38'),
('03d01580-1ee0-47df-b4cc-a14c83e90b51', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 1, '{\"report_id\":629,\"tracking_id\":\"SPEC-UVDC-41813\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-UVDC-41813 telah berubah dari Dibaca menjadi Selesai.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/superadmin\\/daftar-aduan\\/629\\/detail\"}', NULL, '2026-01-27 21:11:54', '2026-01-27 21:11:54'),
('0d52e711-ddd5-4dd3-ae36-08d5d7f8bb8d', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 17, '{\"report_id\":623,\"tracking_id\":\"SPEC-9UKI-43383\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-9UKI-43383 telah berubah dari Dibaca menjadi Revisi.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/daftar-aduan\\/623\\/detail\"}', NULL, '2026-01-27 21:07:25', '2026-01-27 21:07:25'),
('13d3a553-7fd3-4a9e-9559-46d713cdd0ae', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 1, '{\"report_id\":453,\"tracking_id\":\"ADU-FOI3-76479\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID ADU-FOI3-76479 telah berubah dari Diajukan menjadi Direspon.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/superadmin\\/daftar-aduan\\/453\\/detail\"}', NULL, '2026-01-27 21:12:10', '2026-01-27 21:12:10'),
('219f751e-6086-4c52-9fb6-2134d694f66b', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 7, '{\"report_id\":627,\"tracking_id\":\"SPEC-HZEO-58160\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-HZEO-58160 telah berubah dari Selesai menjadi Arsip.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/daftar-aduan\\/627\\/detail\"}', NULL, '2026-01-27 21:07:11', '2026-01-27 21:07:11'),
('251700b4-3728-43ca-9dec-f7ee490429e6', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 1, '{\"report_id\":619,\"tracking_id\":\"SPEC-0MRM-85843\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-0MRM-85843 telah berubah dari Selesai menjadi Revisi.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/superadmin\\/daftar-aduan\\/619\\/detail\"}', NULL, '2026-01-27 21:07:38', '2026-01-27 21:07:38'),
('4f25a082-34e1-46ad-a625-9321c9fdaefc', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 6, '{\"report_id\":628,\"tracking_id\":\"SPEC-T01S-74437\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-T01S-74437 telah berubah dari Selesai menjadi Arsip.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/daftar-aduan\\/628\\/detail\"}', NULL, '2026-01-27 21:06:43', '2026-01-27 21:06:43'),
('5a092485-05bb-4fd7-81df-abcefd7e0fba', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 1, '{\"report_id\":623,\"tracking_id\":\"SPEC-9UKI-43383\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-9UKI-43383 telah berubah dari Dibaca menjadi Revisi.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/superadmin\\/daftar-aduan\\/623\\/detail\"}', NULL, '2026-01-27 21:07:25', '2026-01-27 21:07:25'),
('6f2d246d-188a-4060-9d25-cd2ca3569ae2', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 6, '{\"report_id\":629,\"tracking_id\":\"SPEC-UVDC-41813\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-UVDC-41813 telah berubah dari Dibaca menjadi Selesai.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/daftar-aduan\\/629\\/detail\"}', NULL, '2026-01-27 21:11:54', '2026-01-27 21:11:54'),
('75352911-7ced-47b2-a1c6-4e9e65abb71c', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 2, '{\"report_id\":453,\"tracking_id\":\"ADU-FOI3-76479\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID ADU-FOI3-76479 telah berubah dari Diajukan menjadi Direspon.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/daftar-aduan\\/453\\/detail\"}', NULL, '2026-01-27 21:12:10', '2026-01-27 21:12:10'),
('9baf60f5-2219-40e4-88bc-6d3741852440', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 1, '{\"report_id\":627,\"tracking_id\":\"SPEC-HZEO-58160\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-HZEO-58160 telah berubah dari Selesai menjadi Arsip.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/superadmin\\/daftar-aduan\\/627\\/detail\"}', NULL, '2026-01-27 21:07:11', '2026-01-27 21:07:11'),
('a86e1c28-89bc-4d63-9fe8-a2727851e2d5', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 15, '{\"report_id\":627,\"tracking_id\":\"SPEC-HZEO-58160\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-HZEO-58160 telah berubah dari Selesai menjadi Arsip.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/daftar-aduan\\/627\\/detail\"}', NULL, '2026-01-27 21:07:11', '2026-01-27 21:07:11'),
('a8b724a5-2c8b-41f9-988a-c6da6dc14988', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 18, '{\"report_id\":453,\"tracking_id\":\"ADU-FOI3-76479\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID ADU-FOI3-76479 telah berubah dari Diajukan menjadi Direspon.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/daftar-aduan\\/453\\/detail\"}', NULL, '2026-01-27 21:12:10', '2026-01-27 21:12:10'),
('b840beb7-4e4c-4db7-b652-eea1cdd7c587', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 1, '{\"report_id\":631,\"tracking_id\":\"SPEC-XKQ6-64912\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-XKQ6-64912 telah berubah dari Selesai menjadi Arsip.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/superadmin\\/daftar-aduan\\/631\\/detail\"}', NULL, '2026-01-27 21:06:28', '2026-01-27 21:06:28'),
('cb3a0366-2755-419b-991c-27b931796d50', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 10, '{\"report_id\":631,\"tracking_id\":\"SPEC-XKQ6-64912\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-XKQ6-64912 telah berubah dari Selesai menjadi Arsip.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/admin\\/daftar-aduan\\/631\\/detail\"}', NULL, '2026-01-27 21:06:28', '2026-01-27 21:06:28'),
('dfa3d114-9ecc-4b9c-973f-fc8004d7f830', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 2, '{\"report_id\":631,\"tracking_id\":\"SPEC-XKQ6-64912\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-XKQ6-64912 telah berubah dari Selesai menjadi Arsip.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/daftar-aduan\\/631\\/detail\"}', NULL, '2026-01-27 21:06:28', '2026-01-27 21:06:28'),
('e06bb4eb-71cb-4eea-808d-34f61c0dd808', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 1, '{\"report_id\":543,\"tracking_id\":\"ADU-Y52T-91184\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID ADU-Y52T-91184 telah berubah dari Diajukan menjadi Revisi.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/superadmin\\/daftar-aduan\\/543\\/detail\"}', NULL, '2026-01-27 21:06:15', '2026-01-27 21:06:15'),
('e309e33b-0c9b-4923-905c-29e687e9344b', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 3, '{\"report_id\":543,\"tracking_id\":\"ADU-Y52T-91184\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID ADU-Y52T-91184 telah berubah dari Diajukan menjadi Revisi.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/daftar-aduan\\/543\\/detail\"}', NULL, '2026-01-27 21:06:15', '2026-01-27 21:06:15'),
('ef8bcc09-4cd9-45dc-94c6-d83538c3c225', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 1, '{\"report_id\":628,\"tracking_id\":\"SPEC-T01S-74437\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-T01S-74437 telah berubah dari Selesai menjadi Arsip.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/superadmin\\/daftar-aduan\\/628\\/detail\"}', NULL, '2026-01-27 21:06:43', '2026-01-27 21:06:43'),
('f4d4adc3-f666-41dd-81cf-13c53656c587', 'App\\Notifications\\ReportStatusChanged', 'App\\Models\\User', 5, '{\"report_id\":623,\"tracking_id\":\"SPEC-9UKI-43383\",\"title\":\"Status Aduan Berubah\",\"message\":\"Status aduan dengan ID SPEC-9UKI-43383 telah berubah dari Dibaca menjadi Revisi.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/daftar-aduan\\/623\\/detail\"}', NULL, '2026-01-27 21:07:25', '2026-01-27 21:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `tracking_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `admin_id` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `is_anonim` tinyint(1) NOT NULL DEFAULT '0',
  `nama_pengadu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_pengadu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon_pengadu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `wilayah_id` bigint UNSIGNED NOT NULL,
  `file` json NOT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `views` int UNSIGNED NOT NULL DEFAULT '0',
  `likes` int UNSIGNED NOT NULL DEFAULT '0',
  `dislikes` int UNSIGNED NOT NULL DEFAULT '0',
  `status` enum('Diajukan','Dibaca','Direspon','Selesai','Revisi','Arsip') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diajukan',
  `priority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Low, Medium, High, Emergency',
  `sentiment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Positive, Neutral, Negative',
  `ai_analysis` text COLLATE utf8mb4_unicode_ci,
  `suggested_kategori_id` bigint UNSIGNED DEFAULT NULL,
  `komentar_revisi` text COLLATE utf8mb4_unicode_ci,
  `is_arsip` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `tracking_id`, `user_id`, `admin_id`, `updated_by`, `is_anonim`, `nama_pengadu`, `email_pengadu`, `telepon_pengadu`, `nik`, `judul`, `isi`, `kategori_id`, `wilayah_id`, `file`, `lokasi`, `latitude`, `longitude`, `views`, `likes`, `dislikes`, `status`, `priority`, `sentiment`, `ai_analysis`, `suggested_kategori_id`, `komentar_revisi`, `is_arsip`, `created_at`, `updated_at`) VALUES
(451, 'ADU-SIV7-53737', 4, 8, NULL, 0, 'Warga Kaliurang', 'pelapor.kaliurang1@example.com', '08368874183', '341167624836802', 'Laporan Kendala Fasilitas Umum - Kaliurang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kaliurang, Sleman.', 1, 5, '[\"report_files/68c976ec4d533_1758033644.jpg\"]', 'Kaliurang, Sleman, DI Yogyakarta', '-7.7253610', '110.4191345', 203, 36, 9, 'Diajukan', 'Low', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-13 20:59:02', '2026-01-27 20:59:02'),
(452, 'ADU-L1VU-21028', 2, 10, NULL, 1, 'Warga Gamping', 'pelapor.gamping2@example.com', '08328336082', '344108694202729', 'Laporan Kendala Fasilitas Umum - Gamping', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Gamping, Sleman.', 3, 5, '[\"report_files/AX3r1KhDNHmCdW1jjyEh6EfI1FeuPJ4ievygohn3.jpg\"]', 'Gamping, Sleman, DI Yogyakarta', '-7.6894449', '110.4332990', 107, 17, 10, 'Direspon', 'Low', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-21 20:59:02', '2026-01-27 20:59:02'),
(453, 'ADU-FOI3-76479', 2, 18, NULL, 1, 'Warga Gamping', 'pelapor.gamping3@example.com', '08192961385', '341396696990804', 'Laporan Kendala Fasilitas Umum - Gamping', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Gamping, Sleman.', 11, 2, '[\"report_files/6915fa2596a34_1763047973.jpg\"]', 'Gamping, Sleman, DI Yogyakarta', '-7.6605798', '110.3075135', 84, 0, 2, 'Direspon', 'High', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-28 20:59:02', '2026-01-27 21:12:10'),
(454, 'ADU-CB3U-50070', 6, 11, NULL, 0, 'Warga Danurejan', 'pelapor.danurejan4@example.com', '08335871598', '341115476296044', 'Laporan Kendala Fasilitas Umum - Danurejan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Danurejan, Kota Yogyakarta.', 4, 5, '[\"report_files/6915ea78614eb_1763043960.jpg\"]', 'Danurejan, Kota Yogyakarta, DI Yogyakarta', '-7.7991710', '110.3856268', 234, 5, 7, 'Selesai', 'High', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-25 20:59:02', '2026-01-27 20:59:02'),
(455, 'ADU-VTWV-89651', 7, NULL, NULL, 0, 'Warga Temon', 'pelapor.temon5@example.com', '08211291900', '341309336336673', 'Laporan Kendala Fasilitas Umum - Temon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Temon, Kulon Progo.', 15, 5, '[\"report_files/69763c9f0f2e5_1769356447.jpg\"]', 'Temon, Kulon Progo, DI Yogyakarta', '-7.8750115', '110.0780245', 58, 45, 5, 'Selesai', 'High', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-05 20:59:02', '2026-01-27 20:59:02'),
(456, 'ADU-9ZWS-13134', 6, NULL, NULL, 1, 'Warga Piyungan', 'pelapor.piyungan6@example.com', '08980922140', '341496851131555', 'Laporan Kendala Fasilitas Umum - Piyungan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Piyungan, Bantul.', 15, 2, '[\"report_files/6972aec23fe91_1769123522.jpeg\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.8814114', '110.3706920', 269, 25, 10, 'Dibaca', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:02', '2026-01-27 20:59:02'),
(457, 'ADU-F9ZV-40970', 7, 13, NULL, 1, 'Warga Karangmojo', 'pelapor.karangmojo7@example.com', '08691910126', '342955957498902', 'Lampu PJU Mati Total - Karangmojo', 'Lampu jalan di sepanjang area ini mati total, jalanan menjadi gelap dan rawan tindak kejahatan. Lokasi detail di wilayah Karangmojo, Gunung Kidul.', 13, 2, '[\"report_files/6914d2fc43a9f_1762972412.jpg\"]', 'Karangmojo, Gunung Kidul, DI Yogyakarta', '-8.0251420', '110.6071000', 181, 2, 10, 'Direspon', 'High', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-12 20:59:02', '2026-01-27 20:59:02'),
(458, 'ADU-MGAE-70797', 5, NULL, NULL, 1, 'Warga Mangkubumi', 'pelapor.mangkubumi8@example.com', '08794190201', '342972863562313', 'Laporan Kendala Fasilitas Umum - Mangkubumi', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 19, 2, '[\"report_files/69145ffeec56c_1762942974.jpg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.7985390', '110.3870036', 69, 50, 7, 'Diajukan', 'Low', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-19 20:59:02', '2026-01-27 20:59:02'),
(459, 'ADU-SGQN-40608', 2, 11, NULL, 1, 'Warga Parangtritis', 'pelapor.parangtritis9@example.com', '08840746882', '342138007419280', 'Laporan Kendala Fasilitas Umum - Parangtritis', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Parangtritis, Bantul.', 4, 5, '[\"report_files/69728813365a0_1769113619.jpeg\"]', 'Parangtritis, Bantul, DI Yogyakarta', '-7.9740597', '110.3230760', 201, 43, 6, 'Diajukan', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-05 20:59:02', '2026-01-27 20:59:02'),
(460, 'ADU-LMCR-99398', 3, 17, NULL, 0, 'Warga Wonosari', 'pelapor.wonosari10@example.com', '08511522995', '344748344602768', 'Laporan Kendala Fasilitas Umum - Wonosari', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wonosari, Gunung Kidul.', 10, 5, '[\"report_files/6916cfad94565_1763102637.jpg\"]', 'Wonosari, Gunung Kidul, DI Yogyakarta', '-7.9614260', '110.6325700', 186, 27, 7, 'Dibaca', 'High', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-21 20:59:02', '2026-01-27 20:59:02'),
(461, 'ADU-VUTE-84343', 7, 9, NULL, 0, 'Warga Kaliurang', 'pelapor.kaliurang11@example.com', '08672206217', '344517411191257', 'Puskesmas Kurang Kebersihan - Kaliurang', 'Kondisi ruang tunggu kurang bersih dan fasilitas air sering mati. Mohon segera dicek. Lokasi detail di wilayah Kaliurang, Sleman.', 2, 1, '[\"report_files/IKA8kd99aXMKgJGXHVdqX6I2cDRCgTm7Z5KCsOun.jpg\"]', 'Kaliurang, Sleman, DI Yogyakarta', '-7.6957534', '110.3173310', 266, 46, 5, 'Direspon', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:02', '2026-01-27 20:59:02'),
(462, 'ADU-AI1B-52208', 3, 9, NULL, 0, 'Warga Wates', 'pelapor.wates12@example.com', '08701673511', '342677689794325', 'Puskesmas Kurang Kebersihan - Wates', 'Kondisi ruang tunggu kurang bersih dan fasilitas air sering mati. Mohon segera dicek. Lokasi detail di wilayah Wates, Kulon Progo.', 2, 3, '[\"report_files/cNlT3Kw6eBmGvxgSTfsz6X7jfbhP9YstsFlVyACs.jpg\"]', 'Wates, Kulon Progo, DI Yogyakarta', '-7.8384835', '110.0965660', 59, 13, 6, 'Diajukan', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-15 20:59:03', '2026-01-27 20:59:03'),
(463, 'ADU-UP3Z-48655', 7, NULL, NULL, 0, 'Warga Kalibawang', 'pelapor.kalibawang13@example.com', '08155037410', '341730993469095', 'Laporan Kendala Fasilitas Umum - Kalibawang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kalibawang, Kulon Progo.', 19, 2, '[\"report_files/69160b3575e1b_1763052341.jpg\"]', 'Kalibawang, Kulon Progo, DI Yogyakarta', '-7.8207685', '110.0850160', 188, 27, 6, 'Dibaca', 'Low', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-15 20:59:03', '2026-01-27 20:59:03'),
(464, 'ADU-BYPI-92622', 3, NULL, NULL, 0, 'Warga Karangmojo', 'pelapor.karangmojo14@example.com', '08584256198', '342720509143986', 'Laporan Kendala Fasilitas Umum - Karangmojo', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Karangmojo, Gunung Kidul.', 15, 3, '[\"report_files/693588a1b691e_1765116065.png\"]', 'Karangmojo, Gunung Kidul, DI Yogyakarta', '-8.0211660', '110.6885475', 148, 19, 4, 'Direspon', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-22 20:59:03', '2026-01-27 20:59:03'),
(465, 'ADU-TTK3-96426', 4, NULL, NULL, 1, 'Warga Gamping', 'pelapor.gamping15@example.com', '08197125073', '344731995981124', 'Laporan Kendala Fasilitas Umum - Gamping', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Gamping, Sleman.', 17, 3, '[\"report_files/6915517b1d827_1763004795.jpg\"]', 'Gamping, Sleman, DI Yogyakarta', '-7.6843893', '110.4369470', 174, 30, 4, 'Dibaca', 'High', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-15 20:59:03', '2026-01-27 20:59:03'),
(466, 'ADU-LTHB-96750', 7, 17, NULL, 0, 'Warga Banguntapan', 'pelapor.banguntapan16@example.com', '08580681113', '344735785907777', 'Laporan Kendala Fasilitas Umum - Banguntapan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Banguntapan, Bantul.', 10, 2, '[\"report_files/6914603cdbff1_1762943036.jpg\"]', 'Banguntapan, Bantul, DI Yogyakarta', '-7.8690830', '110.3876780', 34, 30, 6, 'Selesai', 'High', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-12 20:59:03', '2026-01-27 20:59:03'),
(467, 'ADU-NTA5-25014', 3, 10, NULL, 1, 'Warga Sentolo', 'pelapor.sentolo17@example.com', '08986937772', '342956340629282', 'Laporan Kendala Fasilitas Umum - Sentolo', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sentolo, Kulon Progo.', 3, 4, '[\"report_files/u3sHyiu1BQbGquslnBtVbO2EksMwRuO4MSL8Qlzf.jpg\"]', 'Sentolo, Kulon Progo, DI Yogyakarta', '-7.8080995', '110.1489175', 52, 12, 0, 'Direspon', 'High', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-15 20:59:03', '2026-01-27 20:59:03'),
(468, 'ADU-YYV2-78038', 2, 13, NULL, 1, 'Warga Temon', 'pelapor.temon18@example.com', '08350985980', '341283539028693', 'Lampu PJU Mati Total - Temon', 'Lampu jalan di sepanjang area ini mati total, jalanan menjadi gelap dan rawan tindak kejahatan. Lokasi detail di wilayah Temon, Kulon Progo.', 13, 5, '[\"report_files/6916061a32842_1763051034.jpg\"]', 'Temon, Kulon Progo, DI Yogyakarta', '-7.7650735', '110.0738815', 61, 11, 6, 'Selesai', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-23 20:59:03', '2026-01-27 20:59:03'),
(469, 'ADU-WKVD-25371', 4, 14, NULL, 0, 'Warga Sewon', 'pelapor.sewon19@example.com', '08469568272', '341393655156119', 'Pembuangan Sampah Liar - Sewon', 'Warga mengeluhkan tumpukan sampah di pinggir jalan yang menimbulkan bau tidak sedap. Lokasi detail di wilayah Sewon, Bantul.', 7, 2, '[\"report_files/69765097740bf_1769361559.png\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.9946246', '110.3491430', 20, 36, 9, 'Direspon', 'High', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-07 20:59:03', '2026-01-27 20:59:03'),
(470, 'ADU-IAVZ-25561', 6, 14, NULL, 0, 'Warga Sewon', 'pelapor.sewon20@example.com', '08989632402', '341794309905729', 'Pohon Tumbang Belum Dievakuasi - Sewon', 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani. Lokasi detail di wilayah Sewon, Bantul.', 7, 2, '[\"report_files/68c9765877daa_1758033496.jpg\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.9399322', '110.3261210', 29, 35, 7, 'Direspon', 'Low', 'Positive', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-08 20:59:03', '2026-01-27 20:59:03'),
(471, 'ADU-9AIO-99164', 3, 10, NULL, 0, 'Warga Piyungan', 'pelapor.piyungan21@example.com', '08979152970', '343509277809445', 'Laporan Kendala Fasilitas Umum - Piyungan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Piyungan, Bantul.', 14, 5, '[\"report_files/6916ecad5650d_1763110061.jpg\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.9323808', '110.3028850', 284, 40, 6, 'Selesai', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-21 20:59:03', '2026-01-27 20:59:03'),
(472, 'ADU-B0DZ-53446', 5, 10, NULL, 1, 'Warga Depok', 'pelapor.depok22@example.com', '08339732064', '343724118433668', 'Laporan Kendala Fasilitas Umum - Depok', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Depok, Sleman.', 14, 3, '[\"report_files/6915eac60f950_1763044038.jpg\"]', 'Depok, Sleman, DI Yogyakarta', '-7.7255293', '110.3970110', 193, 27, 6, 'Selesai', 'Medium', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-30 20:59:03', '2026-01-27 20:59:03'),
(473, 'ADU-YKMG-69017', 5, 17, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi23@example.com', '08285026856', '343678706926585', 'Laporan Kendala Fasilitas Umum - Mangkubumi', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 10, 1, '[\"report_files/6916157e54e26_1763054974.jpg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.7958760', '110.3723112', 90, 36, 8, 'Diajukan', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:03', '2026-01-27 20:59:03'),
(474, 'ADU-QFXW-11173', 3, 10, NULL, 0, 'Warga Mlati', 'pelapor.mlati24@example.com', '08216436743', '342656612658971', 'Laporan Kendala Fasilitas Umum - Mlati', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mlati, Sleman.', 14, 2, '[\"report_files/69786fc7509e6_1769500615.png\"]', 'Mlati, Sleman, DI Yogyakarta', '-7.7138451', '110.3511920', 51, 14, 1, 'Direspon', 'High', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-17 20:59:03', '2026-01-27 20:59:03'),
(475, 'ADU-F6KA-72095', 2, 12, NULL, 0, 'Warga Wates', 'pelapor.wates25@example.com', '08363414669', '342347444911902', 'Laporan Kendala Fasilitas Umum - Wates', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wates, Kulon Progo.', 5, 5, '[\"report_files/6916ed293ca65_1763110185.jpg\"]', 'Wates, Kulon Progo, DI Yogyakarta', '-7.8014740', '110.1545470', 149, 19, 4, 'Dibaca', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-26 20:59:03', '2026-01-27 21:14:10'),
(476, 'ADU-EKUQ-46093', 4, 8, NULL, 1, 'Warga Kasihan', 'pelapor.kasihan26@example.com', '08170134139', '341825006156348', 'Laporan Kendala Fasilitas Umum - Kasihan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kasihan, Bantul.', 1, 1, '[\"report_files/691552066f85e_1763004934.jpg\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.9725195', '110.3154270', 238, 42, 5, 'Diajukan', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-04 20:59:03', '2026-01-27 20:59:03'),
(477, 'ADU-MNVP-94796', 4, NULL, NULL, 0, 'Warga Kotagede', 'pelapor.kotagede27@example.com', '08943947498', '344734839891030', 'Laporan Kendala Fasilitas Umum - Kotagede', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 18, 5, '[\"report_files/qQgoOZpKECTYQl4XpPoO5iVCJ8HT9BtMlyWHLndZ.jpg\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.7766185', '110.3583204', 206, 4, 6, 'Diajukan', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-18 20:59:03', '2026-01-27 20:59:03'),
(478, 'ADU-1FH5-81132', 7, 10, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi28@example.com', '08897690229', '342862204741032', 'Laporan Kendala Fasilitas Umum - Mangkubumi', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 14, 1, '[\"report_files/iejeFaIcVgTy3DQxxsbXo9gc55ezjRax1HagU3A2.png\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.8005830', '110.3759508', 156, 34, 9, 'Dibaca', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:03', '2026-01-27 20:59:03'),
(479, 'ADU-4DQZ-32571', 7, NULL, NULL, 0, 'Warga Baron', 'pelapor.baron29@example.com', '08198903232', '344400001655682', 'Laporan Kendala Fasilitas Umum - Baron', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Baron, Gunung Kidul.', 15, 2, '[\"report_files/yTPCraOdTx79hjB2I1WZJa1nXN0ECkpakHPM5yGX.png\"]', 'Baron, Gunung Kidul, DI Yogyakarta', '-8.0850020', '110.5837975', 112, 5, 0, 'Dibaca', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:03', '2026-01-27 20:59:03'),
(480, 'ADU-HZE8-40075', 7, 13, NULL, 0, 'Warga Kalibawang', 'pelapor.kalibawang30@example.com', '08148827935', '344607926956359', 'Pagar Pembatas Jembatan Ambles - Kalibawang', 'Pagar pengaman di jembatan terlihat miring dan pondasinya ambles. Sangat berbahaya bagi warga sekitar. Lokasi detail di wilayah Kalibawang, Kulon Progo.', 6, 3, '[\"report_files/zH3LrZkUfTKQ7JkA17JthWF9EuunA5jWqGEdmohZ.png\"]', 'Kalibawang, Kulon Progo, DI Yogyakarta', '-7.8207295', '110.1830965', 203, 42, 1, 'Direspon', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-17 20:59:03', '2026-01-27 20:59:03'),
(481, 'ADU-OLM4-79607', 4, NULL, NULL, 0, 'Warga Sewon', 'pelapor.sewon31@example.com', '08198487689', '344284338825077', 'Laporan Kendala Fasilitas Umum - Sewon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sewon, Bantul.', 16, 5, '[\"report_files/6915541b5e662_1763005467.jpg\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.8396985', '110.3826260', 120, 28, 7, 'Dibaca', 'Medium', 'Positive', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-02 20:59:03', '2026-01-27 20:59:03'),
(482, 'ADU-AYVK-28723', 6, 10, NULL, 1, 'Warga Banguntapan', 'pelapor.banguntapan32@example.com', '08636052814', '341130842419630', 'Laporan Kendala Fasilitas Umum - Banguntapan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Banguntapan, Bantul.', 3, 3, '[\"report_files/6916df69cc54b_1763106665.jpg\"]', 'Banguntapan, Bantul, DI Yogyakarta', '-7.9234235', '110.3680150', 85, 20, 3, 'Selesai', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-06 20:59:03', '2026-01-27 20:59:03'),
(483, 'ADU-SHAU-99738', 7, 18, NULL, 1, 'Warga Sewon', 'pelapor.sewon33@example.com', '08680820474', '341662490929427', 'Laporan Kendala Fasilitas Umum - Sewon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sewon, Bantul.', 11, 4, '[\"report_files/6978664bac8c0_1769498187.png\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.9458108', '110.3064770', 62, 13, 5, 'Selesai', 'Medium', 'Positive', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-17 20:59:03', '2026-01-27 20:59:03'),
(484, 'ADU-AL7E-90948', 4, NULL, NULL, 1, 'Warga Depok', 'pelapor.depok34@example.com', '08746451058', '342104993143799', 'Laporan Kendala Fasilitas Umum - Depok', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Depok, Sleman.', 19, 1, '[\"report_files/6915ef403984b_1763045184.jpg\"]', 'Depok, Sleman, DI Yogyakarta', '-7.7360607', '110.3809010', 102, 27, 8, 'Selesai', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-09 20:59:03', '2026-01-27 20:59:03'),
(485, 'ADU-E87S-82151', 4, 8, NULL, 0, 'Warga Mlati', 'pelapor.mlati35@example.com', '08606190205', '341968343100553', 'Laporan Kendala Fasilitas Umum - Mlati', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mlati, Sleman.', 1, 5, '[\"report_files/6976706285184_1769369698.jpg\"]', 'Mlati, Sleman, DI Yogyakarta', '-7.7384290', '110.4039020', 215, 46, 4, 'Diajukan', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-26 20:59:03', '2026-01-27 20:59:03'),
(486, 'ADU-WOMZ-73420', 5, 18, NULL, 0, 'Warga Wonosari', 'pelapor.wonosari36@example.com', '08292797062', '341871940281766', 'Laporan Kendala Fasilitas Umum - Wonosari', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wonosari, Gunung Kidul.', 11, 3, '[\"report_files/BdA3Tskrit4DCarO0ljrF6clqyvsdD3UgV1Z0tyW.jpg\"]', 'Wonosari, Gunung Kidul, DI Yogyakarta', '-7.9694180', '110.5754075', 53, 20, 2, 'Dibaca', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:03', '2026-01-27 20:59:03'),
(487, 'ADU-H7WJ-82842', 3, 8, NULL, 0, 'Warga Baron', 'pelapor.baron37@example.com', '08388393784', '341996384337561', 'Laporan Kendala Fasilitas Umum - Baron', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Baron, Gunung Kidul.', 1, 1, '[\"report_files/4oNycensoG7InfiFLM1dkn88xiCvFaZh2lmm43Xh.jpg\"]', 'Baron, Gunung Kidul, DI Yogyakarta', '-8.0950840', '110.5803875', 167, 27, 5, 'Diajukan', 'High', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-29 20:59:03', '2026-01-27 20:59:03'),
(488, 'ADU-2PKY-57890', 5, 10, NULL, 1, 'Warga Wates', 'pelapor.wates38@example.com', '08754704984', '344443023434604', 'Laporan Kendala Fasilitas Umum - Wates', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wates, Kulon Progo.', 14, 5, '[\"report_files/MhZG32f5IiOn75LhLbjP9l1eLx7PCOsOxmgClaaY.jpg\"]', 'Wates, Kulon Progo, DI Yogyakarta', '-7.8899245', '110.1862810', 25, 12, 4, 'Selesai', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:03', '2026-01-27 20:59:03'),
(489, 'ADU-XKHT-29085', 2, 16, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi39@example.com', '08252735579', '341501404710490', 'Laporan Kendala Fasilitas Umum - Mangkubumi', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 9, 5, '[\"report_files/69480efde1501_1766330109.jpeg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.7896260', '110.3699644', 255, 16, 9, 'Selesai', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-22 20:59:03', '2026-01-27 20:59:03'),
(490, 'ADU-GGB3-86771', 7, 10, NULL, 0, 'Warga Kotagede', 'pelapor.kotagede40@example.com', '08363588532', '342719138270135', 'Laporan Kendala Fasilitas Umum - Kotagede', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 14, 2, '[\"report_files/69154d661f2e4_1763003750.jpg\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.7913830', '110.3645828', 184, 27, 8, 'Direspon', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-21 20:59:03', '2026-01-27 20:59:03'),
(491, 'ADU-LLSZ-78382', 2, 13, NULL, 1, 'Warga Kotagede', 'pelapor.kotagede41@example.com', '08262764538', '341870538486615', 'Laporan Kendala Fasilitas Umum - Kotagede', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 12, 1, '[\"report_files/b1X7cSayLvN98lgAOe6TyxmU2aWWFEFtPuXtzIRS.jpg\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.7791325', '110.3697972', 128, 9, 0, 'Diajukan', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-02 20:59:03', '2026-01-27 20:59:03'),
(492, 'ADU-XU5V-90943', 3, 18, NULL, 0, 'Warga Nanggulan', 'pelapor.nanggulan42@example.com', '08211857492', '344313579624240', 'Laporan Kendala Fasilitas Umum - Nanggulan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 11, 4, '[\"report_files/69763c9f0f2e5_1769356447.jpg\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.7974690', '110.0878705', 87, 9, 6, 'Dibaca', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-15 20:59:03', '2026-01-27 20:59:03'),
(493, 'ADU-BFCG-17995', 4, NULL, NULL, 0, 'Warga Sentolo', 'pelapor.sentolo43@example.com', '08580498306', '343497280075612', 'Laporan Kendala Fasilitas Umum - Sentolo', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sentolo, Kulon Progo.', 19, 4, '[\"report_files/2VGSqrYOgA4OjcTIewfyrmi01f2MIejKLyqiQXL6.jpg\"]', 'Sentolo, Kulon Progo, DI Yogyakarta', '-7.8060130', '110.1398365', 63, 0, 10, 'Diajukan', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-12 20:59:03', '2026-01-27 20:59:03'),
(494, 'ADU-WLKA-67590', 7, 18, NULL, 0, 'Warga Kasihan', 'pelapor.kasihan44@example.com', '08159618230', '341393965157962', 'Laporan Kendala Fasilitas Umum - Kasihan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kasihan, Bantul.', 11, 1, '[\"report_files/6972aef380054_1769123571.jpeg\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.8452167', '110.3003560', 213, 3, 1, 'Selesai', 'Low', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:03', '2026-01-27 20:59:03'),
(495, 'ADU-MBBY-32140', 2, 15, NULL, 0, 'Warga Nanggulan', 'pelapor.nanggulan45@example.com', '08689372191', '344915578050009', 'Laporan Kendala Fasilitas Umum - Nanggulan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 8, 1, '[\"report_files/69480efde1501_1766330109.jpeg\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.8041215', '110.1321940', 57, 4, 5, 'Direspon', 'Medium', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:03', '2026-01-27 20:59:03'),
(496, 'ADU-1DPV-57160', 3, 16, NULL, 0, 'Warga Kasihan', 'pelapor.kasihan46@example.com', '08487202461', '344814000093957', 'Laporan Kendala Fasilitas Umum - Kasihan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kasihan, Bantul.', 9, 5, '[\"report_files/b1X7cSayLvN98lgAOe6TyxmU2aWWFEFtPuXtzIRS.jpg\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.8808521', '110.3106120', 75, 30, 10, 'Dibaca', 'Medium', 'Positive', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:03', '2026-01-27 20:59:03'),
(497, 'ADU-NFHR-70909', 3, NULL, NULL, 0, 'Warga Nanggulan', 'pelapor.nanggulan47@example.com', '08195673298', '341486787134142', 'Laporan Kendala Fasilitas Umum - Nanggulan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 16, 1, '[\"report_files/691552066f85e_1763004934.jpg\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.7722435', '110.1877015', 63, 13, 10, 'Direspon', 'Low', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-28 20:59:03', '2026-01-27 20:59:03'),
(498, 'ADU-LOSY-87975', 2, 8, NULL, 1, 'Warga Kaliurang', 'pelapor.kaliurang48@example.com', '08262400396', '342122468570816', 'Laporan Kendala Fasilitas Umum - Kaliurang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kaliurang, Sleman.', 1, 5, '[\"report_files/6972aaeb42686_1769122539.jpeg\"]', 'Kaliurang, Sleman, DI Yogyakarta', '-7.7423252', '110.3590295', 194, 47, 9, 'Selesai', 'High', 'Negative', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-31 20:59:03', '2026-01-27 20:59:03'),
(499, 'ADU-FD2Y-21695', 3, 13, NULL, 0, 'Warga Sewon', 'pelapor.sewon49@example.com', '08127341923', '343620509618936', 'Laporan Kendala Fasilitas Umum - Sewon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sewon, Bantul.', 6, 3, '[\"report_files/rDWYffm8UBGTgymsl4YlRFbVj3Md5ad9aTu3mgCo.jpg\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.9651398', '110.3027660', 193, 26, 8, 'Dibaca', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-26 20:59:03', '2026-01-27 21:13:51'),
(500, 'ADU-OFXY-70397', 5, 14, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi50@example.com', '08833803631', '342147173708140', 'Pembuangan Sampah Liar - Mangkubumi', 'Warga mengeluhkan tumpukan sampah di pinggir jalan yang menimbulkan bau tidak sedap. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 7, 1, '[\"report_files/697289eb65590_1769114091.jpeg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.7731425', '110.3528308', 109, 6, 9, 'Diajukan', 'Medium', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-04 20:59:03', '2026-01-27 20:59:03'),
(501, 'ADU-XRNR-48419', 4, NULL, NULL, 0, 'Warga Kasihan', 'pelapor.kasihan51@example.com', '08453200347', '344769982009453', 'Laporan Kendala Fasilitas Umum - Kasihan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kasihan, Bantul.', 18, 3, '[\"report_files/PseeG04irhkC0JhSzP8P9qV18L8R5ux29YQV3JKr.jpg\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.9623926', '110.3623280', 163, 25, 6, 'Selesai', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-03 20:59:03', '2026-01-27 20:59:03'),
(502, 'ADU-P7GA-58080', 5, 17, NULL, 0, 'Warga Nanggulan', 'pelapor.nanggulan52@example.com', '08335164100', '344608935498757', 'Laporan Kendala Fasilitas Umum - Nanggulan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 10, 1, '[\"report_files/t7B4E0EUXp4omZv9hN042VNXTKeBlLe6zUZagbx6.jpg\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.7810455', '110.1153610', 125, 27, 2, 'Selesai', 'Low', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:03', '2026-01-27 20:59:03'),
(503, 'ADU-OLUA-62362', 2, NULL, NULL, 0, 'Warga Kotagede', 'pelapor.kotagede53@example.com', '08839250672', '343671215916298', 'Laporan Kendala Fasilitas Umum - Kotagede', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 16, 5, '[\"report_files/6915562439251_1763005988.jpg\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.8077455', '110.3657772', 16, 2, 1, 'Selesai', 'Low', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-06 20:59:03', '2026-01-27 20:59:03'),
(504, 'ADU-NFUD-80719', 3, NULL, NULL, 1, 'Warga Nanggulan', 'pelapor.nanggulan54@example.com', '08732290391', '343455773947598', 'Laporan Kendala Fasilitas Umum - Nanggulan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 16, 4, '[\"report_files/wjonZpcTIheCkHAX1k3ZHXkQ0YdbjhDGIJ05v3MB.png\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.8110035', '110.0542405', 119, 2, 2, 'Diajukan', 'Medium', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-28 20:59:03', '2026-01-27 20:59:03'),
(505, 'ADU-UGEG-59052', 3, 10, NULL, 0, 'Warga Temon', 'pelapor.temon55@example.com', '08713493950', '344875987490462', 'Laporan Kendala Fasilitas Umum - Temon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Temon, Kulon Progo.', 14, 2, '[\"report_files/6916ed7059e66_1763110256.jpg\"]', 'Temon, Kulon Progo, DI Yogyakarta', '-7.8519325', '110.1230815', 95, 48, 0, 'Direspon', 'Low', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-05 20:59:03', '2026-01-27 20:59:03'),
(506, 'ADU-QLXR-97638', 4, 10, NULL, 0, 'Warga Temon', 'pelapor.temon56@example.com', '08405015487', '341964722043489', 'Laporan Kendala Fasilitas Umum - Temon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Temon, Kulon Progo.', 3, 2, '[\"report_files/kVitnzAIm20N4sWgZVRxlfRn1OsIIX7ncPz8unBb.jpg\"]', 'Temon, Kulon Progo, DI Yogyakarta', '-7.8563260', '110.1120295', 198, 44, 4, 'Dibaca', 'High', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:03', '2026-01-27 20:59:03'),
(507, 'ADU-DZGQ-20637', 6, 10, NULL, 1, 'Warga Malioboro', 'pelapor.malioboro57@example.com', '08990300261', '343716075281266', 'Laporan Kendala Fasilitas Umum - Malioboro', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Malioboro, Kota Yogyakarta.', 3, 1, '[\"report_files/69160ab300630_1763052211.jpg\"]', 'Malioboro, Kota Yogyakarta, DI Yogyakarta', '-7.8160015', '110.3621844', 37, 44, 5, 'Dibaca', 'Low', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-31 20:59:03', '2026-01-27 20:59:03'),
(508, 'ADU-CEF3-81759', 2, NULL, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi58@example.com', '08507952253', '341397831434920', 'Laporan Kendala Fasilitas Umum - Mangkubumi', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 19, 1, '[\"report_files/TRBOUxXzyqRNxCL5QEBxlukEbKVbyx524Lel4jtv.jpg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.7791250', '110.3828116', 238, 49, 9, 'Direspon', 'High', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-30 20:59:03', '2026-01-27 20:59:03'),
(509, 'ADU-G5KS-23149', 6, 18, NULL, 1, 'Warga Kasihan', 'pelapor.kasihan59@example.com', '08659047110', '344564016570046', 'Laporan Kendala Fasilitas Umum - Kasihan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kasihan, Bantul.', 11, 2, '[\"report_files/6916016a0e975_1763049834.jpg\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.9612196', '110.3000300', 257, 44, 3, 'Dibaca', 'Medium', 'Positive', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-19 20:59:03', '2026-01-27 20:59:03'),
(510, 'ADU-OIEH-81188', 5, 13, NULL, 0, 'Warga Kalibawang', 'pelapor.kalibawang60@example.com', '08461069205', '344499747603287', 'Laporan Kendala Fasilitas Umum - Kalibawang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kalibawang, Kulon Progo.', 6, 2, '[\"report_files/UsPlzFnbPP5Ys2x5Gsagbu9Y20iEQU9NhYue5xTw.jpg\"]', 'Kalibawang, Kulon Progo, DI Yogyakarta', '-7.7561215', '110.0785270', 166, 46, 9, 'Direspon', 'Low', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:03', '2026-01-27 21:14:32'),
(511, 'ADU-KLUI-50852', 6, NULL, NULL, 0, 'Warga Temon', 'pelapor.temon61@example.com', '08254152976', '341932241658533', 'Laporan Kendala Fasilitas Umum - Temon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Temon, Kulon Progo.', 17, 5, '[\"report_files/YY8iV7Vn2ytHX7aO2iYh5DyOVg35b9PobqmLH8UT.jpg\"]', 'Temon, Kulon Progo, DI Yogyakarta', '-7.7833480', '110.0661220', 163, 32, 5, 'Dibaca', 'High', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-10 20:59:03', '2026-01-27 20:59:03'),
(512, 'ADU-SGUL-70593', 6, 10, NULL, 0, 'Warga Nanggulan', 'pelapor.nanggulan62@example.com', '08806120595', '343783318244077', 'Laporan Kendala Fasilitas Umum - Nanggulan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 3, 2, '[\"report_files/6935c33a1b41f_1765131066.png\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.8241765', '110.0988175', 238, 32, 0, 'Diajukan', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-13 20:59:03', '2026-01-27 20:59:03'),
(513, 'ADU-M4WD-24914', 3, 16, NULL, 0, 'Warga Wates', 'pelapor.wates63@example.com', '08162910938', '344258043403277', 'Laporan Kendala Fasilitas Umum - Wates', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wates, Kulon Progo.', 9, 1, '[\"report_files/6976706285184_1769369698.jpg\"]', 'Wates, Kulon Progo, DI Yogyakarta', '-7.8830620', '110.1635560', 273, 50, 9, 'Direspon', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-21 20:59:03', '2026-01-27 20:59:03'),
(514, 'ADU-SWU4-24385', 5, 13, NULL, 1, 'Warga Kasihan', 'pelapor.kasihan64@example.com', '08121134309', '343755595232784', 'Saluran Irigasi Tersumbat - Kasihan', 'Saluran irigasi di area persawahan tersumbat material sampah. Air meluap ke jalan desa. Lokasi detail di wilayah Kasihan, Bantul.', 6, 4, '[\"report_files/6919bc4cd2f91_1763294284.jpg\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.8734333', '110.3429630', 172, 8, 8, 'Dibaca', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-23 20:59:03', '2026-01-27 20:59:03'),
(515, 'ADU-8GMG-69542', 2, 13, NULL, 0, 'Warga Danurejan', 'pelapor.danurejan65@example.com', '08908064133', '344347301577495', 'Saluran Irigasi Tersumbat - Danurejan', 'Saluran irigasi di area persawahan tersumbat material sampah. Air meluap ke jalan desa. Lokasi detail di wilayah Danurejan, Kota Yogyakarta.', 6, 2, '[\"report_files/6976719dc591b_1769370013.jpg\"]', 'Danurejan, Kota Yogyakarta, DI Yogyakarta', '-7.8096140', '110.3845824', 54, 42, 7, 'Selesai', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-03 20:59:03', '2026-01-27 20:59:03'),
(516, 'ADU-U3FP-12683', 7, 13, NULL, 0, 'Warga Sentolo', 'pelapor.sentolo66@example.com', '08602958622', '344588873748050', 'Saluran Irigasi Tersumbat - Sentolo', 'Saluran irigasi di area persawahan tersumbat material sampah. Air meluap ke jalan desa. Lokasi detail di wilayah Sentolo, Kulon Progo.', 6, 1, '[\"report_files/4cAekkjca8woRWZNerz7vIc1nsjfZiiZGSE5AjCx.jpg\"]', 'Sentolo, Kulon Progo, DI Yogyakarta', '-7.8946555', '110.0581540', 37, 26, 4, 'Diajukan', 'High', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:03', '2026-01-27 20:59:03'),
(517, 'ADU-GY3D-88419', 6, 14, NULL, 0, 'Warga Baron', 'pelapor.baron67@example.com', '08493285732', '341831140133414', 'Laporan Kendala Fasilitas Umum - Baron', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Baron, Gunung Kidul.', 7, 3, '[\"report_files/iejeFaIcVgTy3DQxxsbXo9gc55ezjRax1HagU3A2.png\"]', 'Baron, Gunung Kidul, DI Yogyakarta', '-7.9572180', '110.6406325', 199, 17, 9, 'Dibaca', 'High', 'Negative', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:03', '2026-01-27 21:15:06'),
(518, 'ADU-W8B2-35329', 7, 16, NULL, 0, 'Warga Baron', 'pelapor.baron68@example.com', '08326680022', '341380942479040', 'Laporan Kendala Fasilitas Umum - Baron', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Baron, Gunung Kidul.', 9, 3, '[\"report_files/QyFizwUrVoMOoAcpmP1tWv1TE9246vTckxWNiQjF.jpg\"]', 'Baron, Gunung Kidul, DI Yogyakarta', '-7.9137460', '110.7242500', 50, 4, 5, 'Direspon', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-16 20:59:03', '2026-01-27 20:59:03'),
(519, 'ADU-EURV-44044', 6, NULL, NULL, 0, 'Warga Piyungan', 'pelapor.piyungan69@example.com', '08376499888', '343555834932002', 'Laporan Kendala Fasilitas Umum - Piyungan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Piyungan, Bantul.', 17, 5, '[\"report_files/rnNn4kKezBtJ05fGjvje6YoYco383oero9fArdgv.jpg\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.8316796', '110.3977140', 221, 31, 0, 'Dibaca', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-10 20:59:03', '2026-01-27 20:59:03'),
(520, 'ADU-SWFQ-79281', 4, 12, NULL, 0, 'Warga Parangtritis', 'pelapor.parangtritis70@example.com', '08111514233', '343566243527919', 'Parkir Liar di Bahu Jalan - Parangtritis', 'Banyak kendaraan parkir sembarangan yang menyebabkan kemacetan parah di jam pulang kerja. Lokasi detail di wilayah Parangtritis, Bantul.', 5, 2, '[\"report_files/697289eb65590_1769114091.jpeg\"]', 'Parangtritis, Bantul, DI Yogyakarta', '-7.9691552', '110.3989360', 270, 5, 8, 'Diajukan', 'Low', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:03', '2026-01-27 20:59:03'),
(521, 'ADU-0GZM-74944', 2, 13, NULL, 1, 'Warga Piyungan', 'pelapor.piyungan71@example.com', '08865666338', '342245862835482', 'Laporan Kendala Fasilitas Umum - Piyungan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Piyungan, Bantul.', 12, 5, '[\"report_files/69480efde1501_1766330109.jpeg\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.9133714', '110.3935480', 227, 15, 8, 'Diajukan', 'Low', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-19 20:59:03', '2026-01-27 20:59:03'),
(522, 'ADU-3XMB-95123', 5, 14, NULL, 0, 'Warga Mlati', 'pelapor.mlati72@example.com', '08696021283', '344572222656167', 'Pembuangan Sampah Liar - Mlati', 'Warga mengeluhkan tumpukan sampah di pinggir jalan yang menimbulkan bau tidak sedap. Lokasi detail di wilayah Mlati, Sleman.', 7, 3, '[\"report_files/CrgAf1PCxvGKmvZj2478VpkEBZK4tqMPC8jIFHIB.jpg\"]', 'Mlati, Sleman, DI Yogyakarta', '-7.7201811', '110.3140535', 192, 41, 6, 'Diajukan', 'Medium', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-21 20:59:03', '2026-01-27 20:59:03'),
(523, 'ADU-BYSH-99996', 5, 8, NULL, 0, 'Warga Ngaglik', 'pelapor.ngaglik73@example.com', '08269393786', '341994154957143', 'Laporan Kendala Fasilitas Umum - Ngaglik', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Ngaglik, Sleman.', 1, 1, '[\"report_files/6915eef4b95bf_1763045108.jpg\"]', 'Ngaglik, Sleman, DI Yogyakarta', '-7.6502838', '110.3737430', 295, 1, 0, 'Direspon', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:03', '2026-01-27 20:59:03'),
(524, 'ADU-38ZB-58329', 4, 13, NULL, 1, 'Warga Ngaglik', 'pelapor.ngaglik74@example.com', '08759938240', '342652609123361', 'Lampu PJU Mati Total - Ngaglik', 'Lampu jalan di sepanjang area ini mati total, jalanan menjadi gelap dan rawan tindak kejahatan. Lokasi detail di wilayah Ngaglik, Sleman.', 13, 1, '[\"report_files/69786fc7509e6_1769500615.png\"]', 'Ngaglik, Sleman, DI Yogyakarta', '-7.7327816', '110.3262020', 13, 2, 7, 'Direspon', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-31 20:59:03', '2026-01-27 20:59:03'),
(525, 'ADU-AHDH-30659', 5, 10, NULL, 1, 'Warga Kotagede', 'pelapor.kotagede75@example.com', '08854522303', '342889218832543', 'Laporan Kendala Fasilitas Umum - Kotagede', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 14, 5, '[\"report_files/kWG7v3Tr8SNU4cSyEsB3YNTGyqmBLs6qFyRoL7Pn.jpg\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.7841100', '110.3822712', 119, 7, 2, 'Dibaca', 'Low', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-10 20:59:03', '2026-01-27 20:59:03'),
(526, 'ADU-K7NQ-61655', 6, 13, NULL, 0, 'Warga Nanggulan', 'pelapor.nanggulan76@example.com', '08427087310', '342834478606913', 'Saluran Irigasi Tersumbat - Nanggulan', 'Saluran irigasi di area persawahan tersumbat material sampah. Air meluap ke jalan desa. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 6, 2, '[\"report_files/6914d2fc43a9f_1762972412.jpg\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.8556990', '110.1322180', 163, 7, 7, 'Diajukan', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-18 20:59:03', '2026-01-27 20:59:03');
INSERT INTO `reports` (`id`, `tracking_id`, `user_id`, `admin_id`, `updated_by`, `is_anonim`, `nama_pengadu`, `email_pengadu`, `telepon_pengadu`, `nik`, `judul`, `isi`, `kategori_id`, `wilayah_id`, `file`, `lokasi`, `latitude`, `longitude`, `views`, `likes`, `dislikes`, `status`, `priority`, `sentiment`, `ai_analysis`, `suggested_kategori_id`, `komentar_revisi`, `is_arsip`, `created_at`, `updated_at`) VALUES
(527, 'ADU-HQWU-73763', 2, 8, NULL, 0, 'Warga Semanu', 'pelapor.semanu77@example.com', '08603021804', '342492282944133', 'Laporan Kendala Fasilitas Umum - Semanu', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Semanu, Gunung Kidul.', 1, 5, '[\"report_files/69160ae0637a8_1763052256.jpg\"]', 'Semanu, Gunung Kidul, DI Yogyakarta', '-7.9663360', '110.6209275', 122, 45, 3, 'Direspon', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-14 20:59:03', '2026-01-27 20:59:03'),
(528, 'ADU-3CQO-59840', 4, 13, NULL, 0, 'Warga Malioboro', 'pelapor.malioboro78@example.com', '08150947297', '341702528408641', 'Laporan Kendala Fasilitas Umum - Malioboro', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Malioboro, Kota Yogyakarta.', 12, 5, '[\"report_files/69160561acf88_1763050849.jpg\"]', 'Malioboro, Kota Yogyakarta, DI Yogyakarta', '-7.7888975', '110.3690216', 208, 45, 8, 'Diajukan', 'Low', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-15 20:59:03', '2026-01-27 20:59:03'),
(529, 'ADU-P65I-91670', 2, 18, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi79@example.com', '08758094855', '342371156220760', 'Laporan Kendala Fasilitas Umum - Mangkubumi', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 11, 4, '[\"report_files/69155286b3f44_1763005062.jpg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.8091860', '110.3899484', 175, 32, 10, 'Dibaca', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-05 20:59:03', '2026-01-27 20:59:03'),
(530, 'ADU-R1SE-30626', 7, 13, NULL, 0, 'Warga Kotagede', 'pelapor.kotagede80@example.com', '08314449517', '344203737394274', 'Lampu PJU Mati Total - Kotagede', 'Lampu jalan di sepanjang area ini mati total, jalanan menjadi gelap dan rawan tindak kejahatan. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 13, 5, '[\"report_files/V1cirNmSVug4hb8VNFA2Vh1sB9AqilHUfxVecgk8.jpg\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.7791935', '110.3766968', 96, 23, 0, 'Direspon', 'Medium', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:03', '2026-01-27 20:59:03'),
(531, 'ADU-JT0L-42363', 2, 9, NULL, 0, 'Warga Karangmojo', 'pelapor.karangmojo81@example.com', '08427004729', '344222049809754', 'Keluhan Antrian BPJS Terlalu Lama - Karangmojo', 'Antrian pendaftaran sangat panjang dan tidak teratur. Mohon ditingkatkan sistem layanannya. Lokasi detail di wilayah Karangmojo, Gunung Kidul.', 2, 2, '[\"report_files/6916d2c4c2414_1763103428.jpg\"]', 'Karangmojo, Gunung Kidul, DI Yogyakarta', '-7.9021420', '110.6659700', 160, 49, 1, 'Dibaca', 'Low', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-10 20:59:03', '2026-01-27 20:59:03'),
(532, 'ADU-YNFD-51214', 5, 17, NULL, 0, 'Warga Kalibawang', 'pelapor.kalibawang82@example.com', '08782493189', '344568510213841', 'Laporan Kendala Fasilitas Umum - Kalibawang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kalibawang, Kulon Progo.', 10, 4, '[\"report_files/6915e70eb0bf1_1763043086.jpg\"]', 'Kalibawang, Kulon Progo, DI Yogyakarta', '-7.8933805', '110.1616090', 60, 40, 0, 'Diajukan', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-09 20:59:03', '2026-01-27 20:59:03'),
(533, 'ADU-FBRQ-97312', 7, NULL, NULL, 0, 'Warga Sewon', 'pelapor.sewon83@example.com', '08529778769', '342129126103987', 'Laporan Kendala Fasilitas Umum - Sewon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sewon, Bantul.', 16, 4, '[\"report_files/6916ebef25f2e_1763109871.jpg\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.9176078', '110.3297520', 116, 29, 3, 'Diajukan', 'Low', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-07 20:59:03', '2026-01-27 20:59:03'),
(534, 'ADU-JM4P-50678', 6, 11, NULL, 0, 'Warga Piyungan', 'pelapor.piyungan84@example.com', '08858217148', '344897174934689', 'Laporan Kendala Fasilitas Umum - Piyungan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Piyungan, Bantul.', 4, 1, '[\"report_files/MhZG32f5IiOn75LhLbjP9l1eLx7PCOsOxmgClaaY.jpg\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.9724005', '110.3308350', 156, 32, 1, 'Dibaca', 'Low', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-06 20:59:03', '2026-01-27 20:59:03'),
(535, 'ADU-GWJ2-38035', 7, 13, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi85@example.com', '08421771787', '342955790334004', 'Pagar Pembatas Jembatan Ambles - Mangkubumi', 'Pagar pengaman di jembatan terlihat miring dan pondasinya ambles. Sangat berbahaya bagi warga sekitar. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 6, 4, '[\"report_files/rMvHcS6uz1bUAdFXz2NxwyxbZ01d8m3Uxc9LI1RA.png\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.8000950', '110.3868008', 141, 2, 4, 'Selesai', 'Low', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-15 20:59:03', '2026-01-27 20:59:03'),
(536, 'ADU-DCUB-73513', 6, 14, NULL, 0, 'Warga Kasihan', 'pelapor.kasihan86@example.com', '08174095129', '342851637237747', 'Pohon Tumbang Belum Dievakuasi - Kasihan', 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani. Lokasi detail di wilayah Kasihan, Bantul.', 7, 1, '[\"report_files/FnGT9GRTiERJKdL1v7WYVPpsXeXucHwyrSb49eAI.jpg\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.8629494', '110.3378210', 248, 44, 9, 'Selesai', 'Low', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-18 20:59:03', '2026-01-27 20:59:03'),
(537, 'ADU-BXFN-75403', 6, NULL, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi87@example.com', '08973654373', '344251827479015', 'Laporan Kendala Fasilitas Umum - Mangkubumi', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 17, 2, '[\"report_files/rvbW346xIBJCjvF6eptMJTfw8UoVxtEjIFoV6sV1.jpg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.8141530', '110.3750904', 113, 16, 0, 'Selesai', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-30 20:59:03', '2026-01-27 20:59:03'),
(538, 'ADU-RIOM-81904', 7, 8, NULL, 1, 'Warga Ngaglik', 'pelapor.ngaglik88@example.com', '08647264520', '343210061333091', 'Laporan Kendala Fasilitas Umum - Ngaglik', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Ngaglik, Sleman.', 1, 1, '[\"report_files/69155755a7472_1763006293.jpg\"]', 'Ngaglik, Sleman, DI Yogyakarta', '-7.7457528', '110.3394320', 223, 46, 2, 'Selesai', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-03 20:59:03', '2026-01-27 20:59:03'),
(539, 'ADU-IMM4-20883', 5, 17, NULL, 1, 'Warga Kalibawang', 'pelapor.kalibawang89@example.com', '08949633571', '341391456504966', 'Laporan Kendala Fasilitas Umum - Kalibawang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kalibawang, Kulon Progo.', 10, 3, '[\"report_files/69786d3e32ba7_1769499966.png\"]', 'Kalibawang, Kulon Progo, DI Yogyakarta', '-7.8042325', '110.0944465', 226, 45, 1, 'Direspon', 'Low', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-26 20:59:03', '2026-01-27 20:59:03'),
(540, 'ADU-2TU8-49785', 2, 15, NULL, 0, 'Warga Malioboro', 'pelapor.malioboro90@example.com', '08700469721', '343927149923926', 'Laporan Kendala Fasilitas Umum - Malioboro', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Malioboro, Kota Yogyakarta.', 8, 1, '[\"report_files/69326191a0813_1764909457.png\"]', 'Malioboro, Kota Yogyakarta, DI Yogyakarta', '-7.8026265', '110.3547568', 69, 42, 5, 'Diajukan', 'Low', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-06 20:59:03', '2026-01-27 20:59:03'),
(541, 'ADU-3O4E-76898', 2, 10, NULL, 0, 'Warga Malioboro', 'pelapor.malioboro91@example.com', '08606073870', '344881065667014', 'Laporan Kendala Fasilitas Umum - Malioboro', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Malioboro, Kota Yogyakarta.', 14, 2, '[\"report_files/6915ef92de7f3_1763045266.jpg\"]', 'Malioboro, Kota Yogyakarta, DI Yogyakarta', '-7.7921870', '110.3799088', 239, 24, 3, 'Selesai', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:03', '2026-01-27 20:59:03'),
(542, 'ADU-L6JI-71111', 4, NULL, NULL, 0, 'Warga Danurejan', 'pelapor.danurejan92@example.com', '08528270970', '343476803300937', 'Laporan Kendala Fasilitas Umum - Danurejan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Danurejan, Kota Yogyakarta.', 18, 3, '[\"report_files/6916cfad94565_1763102637.jpg\"]', 'Danurejan, Kota Yogyakarta, DI Yogyakarta', '-7.7990135', '110.3545372', 20, 48, 6, 'Dibaca', 'Low', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-21 20:59:03', '2026-01-27 20:59:03'),
(543, 'ADU-Y52T-91184', 3, 11, NULL, 0, 'Warga Kalibawang', 'pelapor.kalibawang93@example.com', '08594307625', '344743472392366', 'Laporan Kendala Fasilitas Umum - Kalibawang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kalibawang, Kulon Progo.', 4, 3, '[\"report_files/69787c2f71672_1769503791.jpeg\"]', 'Kalibawang, Kulon Progo, DI Yogyakarta', '-7.8766135', '110.1768070', 170, 9, 6, 'Revisi', 'Low', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, 'lampiran salah', 0, '2026-01-23 20:59:03', '2026-01-27 21:15:37'),
(544, 'ADU-V0U3-11504', 7, NULL, NULL, 0, 'Warga Piyungan', 'pelapor.piyungan94@example.com', '08162995793', '344161353697450', 'Laporan Kendala Fasilitas Umum - Piyungan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Piyungan, Bantul.', 19, 3, '[\"report_files/69358c14ca691_1765116948.jpg\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.8822325', '110.3939480', 109, 48, 1, 'Selesai', 'High', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-30 20:59:03', '2026-01-27 20:59:03'),
(545, 'ADU-LL2J-89851', 7, NULL, NULL, 0, 'Warga Ngaglik', 'pelapor.ngaglik95@example.com', '08474216178', '341795200068785', 'Laporan Kendala Fasilitas Umum - Ngaglik', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Ngaglik, Sleman.', 19, 4, '[\"report_files/P2ciREB7WyxT5QSPC5MI5UWqrIx8dIBNxKvvsA3g.jpg\"]', 'Ngaglik, Sleman, DI Yogyakarta', '-7.7040738', '110.3197070', 260, 26, 6, 'Direspon', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-06 20:59:03', '2026-01-27 20:59:03'),
(546, 'ADU-VHI8-17667', 2, 13, NULL, 0, 'Warga Danurejan', 'pelapor.danurejan96@example.com', '08625699337', '343267204976944', 'Pagar Pembatas Jembatan Ambles - Danurejan', 'Pagar pengaman di jembatan terlihat miring dan pondasinya ambles. Sangat berbahaya bagi warga sekitar. Lokasi detail di wilayah Danurejan, Kota Yogyakarta.', 6, 4, '[\"report_files/69155755a7472_1763006293.jpg\"]', 'Danurejan, Kota Yogyakarta, DI Yogyakarta', '-7.8088970', '110.3717104', 230, 12, 0, 'Dibaca', 'High', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-04 20:59:03', '2026-01-27 20:59:03'),
(547, 'ADU-5HIK-20854', 4, 14, NULL, 0, 'Warga Playen', 'pelapor.playen97@example.com', '08812884800', '342173283077634', 'Pohon Tumbang Belum Dievakuasi - Playen', 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani. Lokasi detail di wilayah Playen, Gunung Kidul.', 7, 2, '[\"report_files/aL4KKvY9aPJtXJOPdcwoAzmDKBrqobjA20ILjPvp.png\"]', 'Playen, Gunung Kidul, DI Yogyakarta', '-7.9236720', '110.5924050', 185, 39, 9, 'Dibaca', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-25 20:59:03', '2026-01-27 20:59:03'),
(548, 'ADU-H0MN-88631', 4, 17, NULL, 0, 'Warga Gamping', 'pelapor.gamping98@example.com', '08767834534', '344426207445977', 'Laporan Kendala Fasilitas Umum - Gamping', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Gamping, Sleman.', 10, 1, '[\"report_files/sovuuqXL9Pv00OHoWNzf2NM6Mx7mZhQmJUoOtgBa.jpg\"]', 'Gamping, Sleman, DI Yogyakarta', '-7.7254204', '110.3312765', 131, 24, 4, 'Dibaca', 'Low', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-12 20:59:03', '2026-01-27 20:59:03'),
(549, 'ADU-NPMM-59988', 2, 13, NULL, 0, 'Warga Kotagede', 'pelapor.kotagede99@example.com', '08885070366', '344120924430662', 'Perbaikan Jalan Berlubang Parah - Kotagede', 'Mohon segera diperbaiki jalan yang berlubang di dekat jalan utama. Lubang cukup dalam dan sering membuat pengendara motor terjatuh. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 6, 1, '[\"report_files/nFLsQ21CN4VQsdHWEOgVSm2BxhwRobtSlsUoIT2U.jpg\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.8131455', '110.3880112', 159, 28, 9, 'Selesai', 'High', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-18 20:59:03', '2026-01-27 20:59:03'),
(550, 'ADU-F3OU-81723', 4, 13, NULL, 1, 'Warga Depok', 'pelapor.depok100@example.com', '08395821647', '343404932525143', 'Laporan Kendala Fasilitas Umum - Depok', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Depok, Sleman.', 12, 3, '[\"report_files/qswW16rJuG8tEv3nBAhi6frtGU2QLiWofIiP2rQQ.jpg\"]', 'Depok, Sleman, DI Yogyakarta', '-7.7326518', '110.4261110', 222, 31, 1, 'Diajukan', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-16 20:59:03', '2026-01-27 20:59:03'),
(551, 'ADU-7CDI-80404', 2, 15, NULL, 0, 'Warga Gamping', 'pelapor.gamping1@example.com', '08219126471', '344148077005884', 'Laporan Kendala Fasilitas Umum - Gamping', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Gamping, Sleman.', 8, 1, '[\"report_files/NwOHZ91PxjPaxvZE3W6LqXDAGPXV4kfzrtsUdahR.png\"]', 'Gamping, Sleman, DI Yogyakarta', '-7.7582862', '110.4156245', 20, 46, 7, 'Dibaca', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:39', '2026-01-27 20:59:39'),
(552, 'ADU-1XK4-75581', 6, 14, NULL, 1, 'Warga Banguntapan', 'pelapor.banguntapan2@example.com', '08469782160', '343498229499755', 'Pohon Tumbang Belum Dievakuasi - Banguntapan', 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani. Lokasi detail di wilayah Banguntapan, Bantul.', 7, 4, '[\"report_files/DhyFQ7EzugUEAR1wrdFGX7BhAShbiZ7zAR1QIqdi.jpg\"]', 'Banguntapan, Bantul, DI Yogyakarta', '-7.8512347', '110.3298390', 127, 44, 3, 'Dibaca', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-30 20:59:39', '2026-01-27 20:59:39'),
(553, 'ADU-J3M8-90773', 2, NULL, NULL, 0, 'Warga Karangmojo', 'pelapor.karangmojo3@example.com', '08412225229', '341104669483387', 'Laporan Kendala Fasilitas Umum - Karangmojo', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Karangmojo, Gunung Kidul.', 18, 1, '[\"report_files/6915ea78614eb_1763043960.jpg\"]', 'Karangmojo, Gunung Kidul, DI Yogyakarta', '-8.0692820', '110.7147125', 58, 40, 3, 'Selesai', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:39', '2026-01-27 20:59:39'),
(554, 'ADU-C0LZ-44693', 7, 11, NULL, 0, 'Warga Kotagede', 'pelapor.kotagede4@example.com', '08726714941', '341538645866696', 'Laporan Kendala Fasilitas Umum - Kotagede', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 4, 1, '[\"report_files/697870b6561c5_1769500854.png\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.7786135', '110.3723728', 206, 13, 8, 'Direspon', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-31 20:59:39', '2026-01-27 20:59:39'),
(555, 'ADU-IIAQ-57328', 3, 15, NULL, 0, 'Warga Parangtritis', 'pelapor.parangtritis5@example.com', '08184699671', '343529977386631', 'Laporan Kendala Fasilitas Umum - Parangtritis', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Parangtritis, Bantul.', 8, 3, '[\"report_files/6976719dc591b_1769370013.jpg\"]', 'Parangtritis, Bantul, DI Yogyakarta', '-7.8676635', '110.3076770', 72, 14, 3, 'Diajukan', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-22 20:59:39', '2026-01-27 21:16:13'),
(556, 'ADU-BE19-24232', 7, 8, NULL, 0, 'Warga Kasihan', 'pelapor.kasihan6@example.com', '08396306270', '342356279546315', 'Laporan Kendala Fasilitas Umum - Kasihan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kasihan, Bantul.', 1, 3, '[\"report_files/693588a1b691e_1765116065.png\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.9936709', '110.3847560', 221, 26, 2, 'Diajukan', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-17 20:59:39', '2026-01-27 20:59:39'),
(557, 'ADU-MKQ1-86060', 3, 14, NULL, 0, 'Warga Ngaglik', 'pelapor.ngaglik7@example.com', '08547331322', '341952432594298', 'Pohon Tumbang Belum Dievakuasi - Ngaglik', 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani. Lokasi detail di wilayah Ngaglik, Sleman.', 7, 2, '[\"report_files/6916d04352850_1763102787.jpg\"]', 'Ngaglik, Sleman, DI Yogyakarta', '-7.7273047', '110.3309525', 20, 20, 6, 'Selesai', 'High', 'Negative', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-05 20:59:39', '2026-01-27 20:59:39'),
(558, 'ADU-BLDJ-84809', 7, 12, NULL, 1, 'Warga Piyungan', 'pelapor.piyungan8@example.com', '08604273361', '344192747145409', 'Lampu APILL Error - Piyungan', 'Lampu lalu lintas di persimpangan ini hanya berkedip kuning, membuat lalu lintas semrawut. Lokasi detail di wilayah Piyungan, Bantul.', 5, 4, '[\"report_files/697662377ef6a_1769366071.png\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.8525760', '110.3872570', 46, 46, 4, 'Selesai', 'Low', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:39', '2026-01-27 20:59:39'),
(559, 'ADU-7UPS-34506', 5, 12, NULL, 0, 'Warga Sewon', 'pelapor.sewon9@example.com', '08947804404', '342225003531780', 'Lampu APILL Error - Sewon', 'Lampu lalu lintas di persimpangan ini hanya berkedip kuning, membuat lalu lintas semrawut. Lokasi detail di wilayah Sewon, Bantul.', 5, 2, '[\"report_files/6919bc4cd2f91_1763294284.jpg\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.8616149', '110.3921000', 198, 10, 2, 'Diajukan', 'Low', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-25 20:59:39', '2026-01-27 20:59:39'),
(560, 'ADU-ZKEB-61952', 6, NULL, NULL, 0, 'Warga Baron', 'pelapor.baron10@example.com', '08149762461', '343314724219261', 'Laporan Kendala Fasilitas Umum - Baron', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Baron, Gunung Kidul.', 18, 4, '[\"report_files/lrk2fus4QnScZcxdALUFJ9GmY76VtnvfzoQOyhkh.jpg\"]', 'Baron, Gunung Kidul, DI Yogyakarta', '-7.9779640', '110.6778475', 173, 30, 6, 'Dibaca', 'High', 'Negative', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-07 20:59:39', '2026-01-27 20:59:39'),
(561, 'ADU-XQXZ-61796', 4, NULL, NULL, 1, 'Warga Kaliurang', 'pelapor.kaliurang11@example.com', '08726064253', '341332810227801', 'Laporan Kendala Fasilitas Umum - Kaliurang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kaliurang, Sleman.', 15, 5, '[\"report_files/kVitnzAIm20N4sWgZVRxlfRn1OsIIX7ncPz8unBb.jpg\"]', 'Kaliurang, Sleman, DI Yogyakarta', '-7.7492266', '110.3433560', 156, 19, 1, 'Selesai', 'Low', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-31 20:59:39', '2026-01-27 20:59:39'),
(562, 'ADU-VULC-61628', 5, NULL, NULL, 1, 'Warga Ngaglik', 'pelapor.ngaglik12@example.com', '08236279661', '341664323548929', 'Laporan Kendala Fasilitas Umum - Ngaglik', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Ngaglik, Sleman.', 18, 2, '[\"report_files/lrk2fus4QnScZcxdALUFJ9GmY76VtnvfzoQOyhkh.jpg\"]', 'Ngaglik, Sleman, DI Yogyakarta', '-7.6662701', '110.3589860', 91, 46, 0, 'Diajukan', 'Low', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-29 20:59:39', '2026-01-27 20:59:39'),
(563, 'ADU-IGOK-92774', 5, 15, NULL, 0, 'Warga Playen', 'pelapor.playen13@example.com', '08882101826', '343427934045331', 'Laporan Kendala Fasilitas Umum - Playen', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Playen, Gunung Kidul.', 8, 5, '[\"report_files/69786d3e32ba7_1769499966.png\"]', 'Playen, Gunung Kidul, DI Yogyakarta', '-8.0088120', '110.5862400', 124, 39, 8, 'Dibaca', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-22 20:59:39', '2026-01-27 21:16:00'),
(564, 'ADU-NMUL-69250', 7, 10, NULL, 0, 'Warga Depok', 'pelapor.depok14@example.com', '08946939059', '343681353884799', 'Laporan Kendala Fasilitas Umum - Depok', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Depok, Sleman.', 14, 5, '[\"report_files/6976732b169eb_1769370411.jpg\"]', 'Depok, Sleman, DI Yogyakarta', '-7.6847556', '110.4368615', 237, 38, 10, 'Selesai', 'Medium', 'Negative', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-13 20:59:39', '2026-01-27 20:59:39'),
(565, 'ADU-EA7E-97304', 7, NULL, NULL, 0, 'Warga Wates', 'pelapor.wates15@example.com', '08133734260', '342297547769418', 'Laporan Kendala Fasilitas Umum - Wates', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wates, Kulon Progo.', 19, 2, '[\"report_files/aL4KKvY9aPJtXJOPdcwoAzmDKBrqobjA20ILjPvp.png\"]', 'Wates, Kulon Progo, DI Yogyakarta', '-7.8479215', '110.1432820', 155, 12, 6, 'Diajukan', 'Low', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-28 20:59:39', '2026-01-27 20:59:39'),
(566, 'ADU-CLRL-91267', 5, NULL, NULL, 0, 'Warga Wonosari', 'pelapor.wonosari16@example.com', '08494096037', '342374389888231', 'Laporan Kendala Fasilitas Umum - Wonosari', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wonosari, Gunung Kidul.', 16, 2, '[\"report_files/4cAekkjca8woRWZNerz7vIc1nsjfZiiZGSE5AjCx.jpg\"]', 'Wonosari, Gunung Kidul, DI Yogyakarta', '-8.0610740', '110.6681075', 258, 38, 5, 'Diajukan', 'High', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:39', '2026-01-27 20:59:39'),
(567, 'ADU-ZNYC-24239', 3, 10, NULL, 0, 'Warga Nanggulan', 'pelapor.nanggulan17@example.com', '08881073301', '342564342531767', 'Laporan Kendala Fasilitas Umum - Nanggulan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 14, 5, '[\"report_files/UsPlzFnbPP5Ys2x5Gsagbu9Y20iEQU9NhYue5xTw.jpg\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.8692065', '110.1933160', 131, 9, 5, 'Diajukan', 'High', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-09 20:59:39', '2026-01-27 20:59:39'),
(568, 'ADU-ROFI-51007', 3, NULL, NULL, 1, 'Warga Wonosari', 'pelapor.wonosari18@example.com', '08665551141', '344624724793030', 'Laporan Kendala Fasilitas Umum - Wonosari', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wonosari, Gunung Kidul.', 15, 3, '[\"report_files/6916157e54e26_1763054974.jpg\"]', 'Wonosari, Gunung Kidul, DI Yogyakarta', '-8.0519700', '110.6874725', 292, 7, 1, 'Direspon', 'Low', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-05 20:59:39', '2026-01-27 20:59:39'),
(569, 'ADU-HHRA-48441', 7, 18, NULL, 1, 'Warga Sentolo', 'pelapor.sentolo19@example.com', '08917971022', '342312758631058', 'Laporan Kendala Fasilitas Umum - Sentolo', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sentolo, Kulon Progo.', 11, 1, '[\"report_files/6916ddc896d34_1763106248.jpg\"]', 'Sentolo, Kulon Progo, DI Yogyakarta', '-7.8930805', '110.1688360', 42, 22, 7, 'Diajukan', 'High', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:39', '2026-01-27 20:59:39'),
(570, 'ADU-6X37-48895', 7, 11, NULL, 0, 'Warga Baron', 'pelapor.baron20@example.com', '08146463370', '342223503591723', 'Laporan Kendala Fasilitas Umum - Baron', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Baron, Gunung Kidul.', 4, 2, '[\"report_files/oHz1GApZ3aXuWJTiuembPUFBU7yrDW9z5c7cFDtd.jpg\"]', 'Baron, Gunung Kidul, DI Yogyakarta', '-8.0232320', '110.7385525', 285, 27, 6, 'Diajukan', 'Low', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-08 20:59:39', '2026-01-27 20:59:39'),
(571, 'ADU-IVL0-99497', 2, 13, NULL, 1, 'Warga Temon', 'pelapor.temon21@example.com', '08565480828', '341441436875180', 'Lampu PJU Mati Total - Temon', 'Lampu jalan di sepanjang area ini mati total, jalanan menjadi gelap dan rawan tindak kejahatan. Lokasi detail di wilayah Temon, Kulon Progo.', 13, 5, '[\"report_files/6916002d7b0b4_1763049517.jpg\"]', 'Temon, Kulon Progo, DI Yogyakarta', '-7.8181855', '110.1741565', 260, 42, 9, 'Direspon', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-01 20:59:39', '2026-01-27 20:59:39'),
(572, 'ADU-SXVU-98454', 7, 10, NULL, 0, 'Warga Sentolo', 'pelapor.sentolo22@example.com', '08468345692', '344747591015109', 'Laporan Kendala Fasilitas Umum - Sentolo', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sentolo, Kulon Progo.', 14, 1, '[\"report_files/XErZsNqypOTYbfQXD5yX7X9rB2RBIKgoc5d2bBs0.jpg\"]', 'Sentolo, Kulon Progo, DI Yogyakarta', '-7.7507320', '110.1946885', 85, 37, 6, 'Selesai', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-28 20:59:39', '2026-01-27 20:59:39'),
(573, 'ADU-G3EE-47090', 2, 13, NULL, 0, 'Warga Danurejan', 'pelapor.danurejan23@example.com', '08728255464', '341475830097634', 'Laporan Kendala Fasilitas Umum - Danurejan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Danurejan, Kota Yogyakarta.', 12, 3, '[\"report_files/wjonZpcTIheCkHAX1k3ZHXkQ0YdbjhDGIJ05v3MB.png\"]', 'Danurejan, Kota Yogyakarta, DI Yogyakarta', '-7.8053770', '110.3897860', 192, 46, 0, 'Diajukan', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-19 20:59:39', '2026-01-27 20:59:39'),
(574, 'ADU-PPXN-93426', 7, 9, NULL, 0, 'Warga Playen', 'pelapor.playen24@example.com', '08480346011', '343466308520275', 'Keluhan Antrian BPJS Terlalu Lama - Playen', 'Antrian pendaftaran sangat panjang dan tidak teratur. Mohon ditingkatkan sistem layanannya. Lokasi detail di wilayah Playen, Gunung Kidul.', 2, 3, '[\"report_files/6916ed293ca65_1763110185.jpg\"]', 'Playen, Gunung Kidul, DI Yogyakarta', '-8.0196760', '110.6477950', 129, 26, 5, 'Selesai', 'Medium', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:39', '2026-01-27 20:59:39'),
(575, 'ADU-WYLJ-86505', 3, 13, NULL, 0, 'Warga Karangmojo', 'pelapor.karangmojo25@example.com', '08658360600', '342100119397097', 'Saluran Irigasi Tersumbat - Karangmojo', 'Saluran irigasi di area persawahan tersumbat material sampah. Air meluap ke jalan desa. Lokasi detail di wilayah Karangmojo, Gunung Kidul.', 6, 3, '[\"report_files/69145e31ce692_1762942513.jpg\"]', 'Karangmojo, Gunung Kidul, DI Yogyakarta', '-7.9749360', '110.6827750', 128, 23, 3, 'Dibaca', 'High', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:39', '2026-01-27 20:59:39'),
(576, 'ADU-UACV-94528', 3, 16, NULL, 0, 'Warga Umbulharjo', 'pelapor.umbulharjo26@example.com', '08553203051', '342518397179706', 'Laporan Kendala Fasilitas Umum - Umbulharjo', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Umbulharjo, Kota Yogyakarta.', 9, 5, '[\"report_files/69358a3029e9e_1765116464.png\"]', 'Umbulharjo, Kota Yogyakarta, DI Yogyakarta', '-7.7960105', '110.3803768', 115, 18, 8, 'Selesai', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-13 20:59:39', '2026-01-27 20:59:39'),
(577, 'ADU-OFHO-80230', 2, 12, NULL, 0, 'Warga Kalibawang', 'pelapor.kalibawang27@example.com', '08831508760', '342749017030383', 'Laporan Kendala Fasilitas Umum - Kalibawang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kalibawang, Kulon Progo.', 5, 5, '[\"report_files/YwGaA7shZhpIRUuvy1H4A2vbkb0Czm3ODAl4PpfH.jpg\"]', 'Kalibawang, Kulon Progo, DI Yogyakarta', '-7.7921815', '110.1306955', 120, 31, 3, 'Direspon', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-25 20:59:39', '2026-01-27 21:14:48'),
(578, 'ADU-GOIN-67167', 7, 13, NULL, 1, 'Warga Wonosari', 'pelapor.wonosari28@example.com', '08919312411', '341316799782138', 'Laporan Kendala Fasilitas Umum - Wonosari', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wonosari, Gunung Kidul.', 12, 5, '[\"report_files/eXYEUTx66e8V5jV72OK3JiYLtWttQLGGEWKJrWbK.jpg\"]', 'Wonosari, Gunung Kidul, DI Yogyakarta', '-7.9683380', '110.6607550', 48, 23, 10, 'Dibaca', 'High', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:39', '2026-01-27 20:59:39'),
(579, 'ADU-AL41-47439', 4, NULL, NULL, 0, 'Warga Playen', 'pelapor.playen29@example.com', '08935624827', '344279283530415', 'Laporan Kendala Fasilitas Umum - Playen', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Playen, Gunung Kidul.', 19, 1, '[\"report_files/6918b424e2529_1763226660.jpg\"]', 'Playen, Gunung Kidul, DI Yogyakarta', '-8.0746920', '110.5851300', 188, 50, 3, 'Diajukan', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-28 20:59:39', '2026-01-27 20:59:39'),
(580, 'ADU-20HQ-19923', 5, 9, NULL, 0, 'Warga Sewon', 'pelapor.sewon30@example.com', '08845911969', '343466103003309', 'Laporan Kendala Fasilitas Umum - Sewon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sewon, Bantul.', 2, 4, '[\"report_files/kBXVgElCZk5AyosMsC2vC2jPyZD20jAr38toGMgd.jpg\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.8697596', '110.3849750', 164, 29, 9, 'Dibaca', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-23 20:59:40', '2026-01-27 21:15:18'),
(581, 'ADU-FANR-63279', 5, 15, NULL, 0, 'Warga Kotagede', 'pelapor.kotagede31@example.com', '08853867403', '344127260363564', 'Laporan Kendala Fasilitas Umum - Kotagede', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 8, 3, '[\"report_files/rMvHcS6uz1bUAdFXz2NxwyxbZ01d8m3Uxc9LI1RA.png\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.7944910', '110.3519756', 126, 43, 4, 'Selesai', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-15 20:59:40', '2026-01-27 20:59:40'),
(582, 'ADU-UXY1-28459', 3, 9, NULL, 0, 'Warga Umbulharjo', 'pelapor.umbulharjo32@example.com', '08601063674', '344903599317387', 'Keluhan Antrian BPJS Terlalu Lama - Umbulharjo', 'Antrian pendaftaran sangat panjang dan tidak teratur. Mohon ditingkatkan sistem layanannya. Lokasi detail di wilayah Umbulharjo, Kota Yogyakarta.', 2, 3, '[\"report_files/XbDX5VmufN3SOblJAprohgcmsgtn6E0q1eeli1nH.jpg\"]', 'Umbulharjo, Kota Yogyakarta, DI Yogyakarta', '-7.8043080', '110.3646512', 81, 40, 5, 'Direspon', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-19 20:59:40', '2026-01-27 20:59:40'),
(583, 'ADU-VQNK-80947', 4, 14, NULL, 1, 'Warga Karangmojo', 'pelapor.karangmojo33@example.com', '08214466027', '344417285786108', 'Pohon Tumbang Belum Dievakuasi - Karangmojo', 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani. Lokasi detail di wilayah Karangmojo, Gunung Kidul.', 7, 2, '[\"report_files/6935854e5abde_1765115214.png\"]', 'Karangmojo, Gunung Kidul, DI Yogyakarta', '-7.9581380', '110.6585400', 240, 0, 9, 'Selesai', 'High', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:40', '2026-01-27 20:59:40'),
(584, 'ADU-3CN0-76387', 2, 16, NULL, 1, 'Warga Baron', 'pelapor.baron34@example.com', '08555180079', '342804351919880', 'Laporan Kendala Fasilitas Umum - Baron', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Baron, Gunung Kidul.', 9, 4, '[\"report_files/HTZy0XvnMQcu4xnrI92SmJ0K0snTMuszEnptYQH9.jpg\"]', 'Baron, Gunung Kidul, DI Yogyakarta', '-8.0420360', '110.7415675', 99, 45, 8, 'Diajukan', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-09 20:59:40', '2026-01-27 20:59:40'),
(585, 'ADU-BFMV-78857', 4, 10, NULL, 0, 'Warga Piyungan', 'pelapor.piyungan35@example.com', '08336566278', '343171985622096', 'Laporan Kendala Fasilitas Umum - Piyungan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Piyungan, Bantul.', 3, 4, '[\"report_files/6915562439251_1763005988.jpg\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.9282702', '110.3497190', 296, 20, 1, 'Diajukan', 'Low', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-31 20:59:40', '2026-01-27 20:59:40'),
(586, 'ADU-C3EP-98951', 2, NULL, NULL, 1, 'Warga Temon', 'pelapor.temon36@example.com', '08702359652', '343659910318223', 'Laporan Kendala Fasilitas Umum - Temon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Temon, Kulon Progo.', 19, 3, '[\"report_files/6916ebef25f2e_1763109871.jpg\"]', 'Temon, Kulon Progo, DI Yogyakarta', '-7.8201025', '110.1227980', 263, 40, 0, 'Diajukan', 'High', 'Neutral', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:40', '2026-01-27 20:59:40'),
(587, 'ADU-DVU7-47555', 6, 10, NULL, 1, 'Warga Kotagede', 'pelapor.kotagede37@example.com', '08876232451', '344859887240076', 'Laporan Kendala Fasilitas Umum - Kotagede', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kotagede, Kota Yogyakarta.', 14, 2, '[\"report_files/697669eaa74ca_1769368042.png\"]', 'Kotagede, Kota Yogyakarta, DI Yogyakarta', '-7.8117075', '110.3724456', 135, 24, 4, 'Diajukan', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-08 20:59:40', '2026-01-27 20:59:40'),
(588, 'ADU-OXAI-84728', 4, 13, NULL, 0, 'Warga Ngaglik', 'pelapor.ngaglik38@example.com', '08508258681', '344260877579295', 'Perbaikan Jalan Berlubang Parah - Ngaglik', 'Mohon segera diperbaiki jalan yang berlubang di dekat jalan utama. Lubang cukup dalam dan sering membuat pengendara motor terjatuh. Lokasi detail di wilayah Ngaglik, Sleman.', 6, 3, '[\"report_files/6916d5c336f6d_1763104195.jpg\"]', 'Ngaglik, Sleman, DI Yogyakarta', '-7.6779444', '110.3486510', 274, 48, 9, 'Diajukan', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-04 20:59:40', '2026-01-27 20:59:40'),
(589, 'ADU-IXTQ-20980', 4, 13, NULL, 1, 'Warga Umbulharjo', 'pelapor.umbulharjo39@example.com', '08878748553', '344362709157276', 'Lampu PJU Mati Total - Umbulharjo', 'Lampu jalan di sepanjang area ini mati total, jalanan menjadi gelap dan rawan tindak kejahatan. Lokasi detail di wilayah Umbulharjo, Kota Yogyakarta.', 13, 3, '[\"report_files/6916db662a707_1763105638.jpg\"]', 'Umbulharjo, Kota Yogyakarta, DI Yogyakarta', '-7.7764915', '110.3546020', 197, 22, 8, 'Selesai', 'Low', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-26 20:59:40', '2026-01-27 20:59:40'),
(590, 'ADU-LYHY-53848', 4, NULL, NULL, 0, 'Warga Gamping', 'pelapor.gamping40@example.com', '08121167790', '342331001174865', 'Laporan Kendala Fasilitas Umum - Gamping', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Gamping, Sleman.', 17, 1, '[\"report_files/6916ebc67c70e_1763109830.jpg\"]', 'Gamping, Sleman, DI Yogyakarta', '-7.6982317', '110.3699225', 256, 0, 0, 'Selesai', 'Low', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-21 20:59:40', '2026-01-27 20:59:40'),
(591, 'ADU-SHDM-48519', 3, 9, NULL, 0, 'Warga Temon', 'pelapor.temon41@example.com', '08997177011', '341418913603290', 'Keluhan Antrian BPJS Terlalu Lama - Temon', 'Antrian pendaftaran sangat panjang dan tidak teratur. Mohon ditingkatkan sistem layanannya. Lokasi detail di wilayah Temon, Kulon Progo.', 2, 1, '[\"report_files/ZvLHFsVq0jMT9Ln1WeoTHHKdxhZJov4Vx4hXE0GY.png\"]', 'Temon, Kulon Progo, DI Yogyakarta', '-7.7593030', '110.1693295', 145, 47, 4, 'Dibaca', 'Medium', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-24 20:59:40', '2026-01-27 20:59:40'),
(592, 'ADU-DFBU-49293', 7, 13, NULL, 0, 'Warga Kasihan', 'pelapor.kasihan42@example.com', '08140838409', '343619360891908', 'Laporan Kendala Fasilitas Umum - Kasihan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kasihan, Bantul.', 12, 1, '[\"report_files/fWdZjAKOg3rVZyb7VOr9kocTAALxyLMEbWCMpaOS.jpg\"]', 'Kasihan, Bantul, DI Yogyakarta', '-7.8307208', '110.3206760', 39, 29, 9, 'Selesai', 'Medium', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-31 20:59:40', '2026-01-27 20:59:40'),
(593, 'ADU-MYO7-60322', 4, 13, NULL, 0, 'Warga Semanu', 'pelapor.semanu43@example.com', '08344789371', '341429147209878', 'Pagar Pembatas Jembatan Ambles - Semanu', 'Pagar pengaman di jembatan terlihat miring dan pondasinya ambles. Sangat berbahaya bagi warga sekitar. Lokasi detail di wilayah Semanu, Gunung Kidul.', 6, 2, '[\"report_files/KLA7cWmpl41mch2TlKrvfrtRQdkadwlnv8hOFPa8.jpg\"]', 'Semanu, Gunung Kidul, DI Yogyakarta', '-8.0599080', '110.5110050', 269, 40, 5, 'Selesai', 'Low', 'Neutral', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-31 20:59:40', '2026-01-27 20:59:40'),
(594, 'ADU-K8UD-65060', 4, NULL, NULL, 0, 'Warga Karangmojo', 'pelapor.karangmojo44@example.com', '08437790428', '343373470781669', 'Laporan Kendala Fasilitas Umum - Karangmojo', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Karangmojo, Gunung Kidul.', 15, 1, '[\"report_files/6914dc3f4400f_1762974783.jpg\"]', 'Karangmojo, Gunung Kidul, DI Yogyakarta', '-8.0381240', '110.7278475', 213, 42, 1, 'Direspon', 'Medium', 'Negative', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-14 20:59:40', '2026-01-27 20:59:40'),
(595, 'ADU-XGOC-61090', 3, 16, NULL, 0, 'Warga Kaliurang', 'pelapor.kaliurang45@example.com', '08673439140', '343191150170912', 'Laporan Kendala Fasilitas Umum - Kaliurang', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Kaliurang, Sleman.', 9, 4, '[\"report_files/6972854a459ee_1769112906.jpeg\"]', 'Kaliurang, Sleman, DI Yogyakarta', '-7.6877179', '110.3677940', 128, 11, 5, 'Direspon', 'Low', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-16 20:59:40', '2026-01-27 20:59:40'),
(596, 'ADU-6Q4D-38195', 5, 14, NULL, 1, 'Warga Mangkubumi', 'pelapor.mangkubumi46@example.com', '08425380208', '343792729616629', 'Pembuangan Sampah Liar - Mangkubumi', 'Warga mengeluhkan tumpukan sampah di pinggir jalan yang menimbulkan bau tidak sedap. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 7, 4, '[\"report_files/4oNycensoG7InfiFLM1dkn88xiCvFaZh2lmm43Xh.jpg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.8110495', '110.3886284', 213, 38, 8, 'Diajukan', 'High', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-05 20:59:40', '2026-01-27 20:59:40'),
(597, 'ADU-ZPPB-73314', 7, 13, NULL, 0, 'Warga Kalibawang', 'pelapor.kalibawang47@example.com', '08888800434', '341902541497994', 'Lampu PJU Mati Total - Kalibawang', 'Lampu jalan di sepanjang area ini mati total, jalanan menjadi gelap dan rawan tindak kejahatan. Lokasi detail di wilayah Kalibawang, Kulon Progo.', 13, 3, '[\"report_files/UsPlzFnbPP5Ys2x5Gsagbu9Y20iEQU9NhYue5xTw.jpg\"]', 'Kalibawang, Kulon Progo, DI Yogyakarta', '-7.7504935', '110.1833365', 285, 42, 8, 'Direspon', 'Low', 'Positive', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-03 20:59:40', '2026-01-27 20:59:40'),
(598, 'ADU-X9PR-82196', 2, 11, NULL, 0, 'Warga Mangkubumi', 'pelapor.mangkubumi48@example.com', '08662307836', '344110311565747', 'Laporan Kendala Fasilitas Umum - Mangkubumi', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mangkubumi, Kota Yogyakarta.', 4, 2, '[\"report_files/6916002d7b0b4_1763049517.jpg\"]', 'Mangkubumi, Kota Yogyakarta, DI Yogyakarta', '-7.7959255', '110.3789300', 235, 32, 10, 'Diajukan', 'Medium', 'Negative', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-25 20:59:40', '2026-01-27 20:59:40'),
(599, 'ADU-T5ND-20375', 6, 13, NULL, 0, 'Warga Semanu', 'pelapor.semanu49@example.com', '08772140865', '344645045349191', 'Saluran Irigasi Tersumbat - Semanu', 'Saluran irigasi di area persawahan tersumbat material sampah. Air meluap ke jalan desa. Lokasi detail di wilayah Semanu, Gunung Kidul.', 6, 3, '[\"report_files/6976732b169eb_1769370411.jpg\"]', 'Semanu, Gunung Kidul, DI Yogyakarta', '-7.9623640', '110.5721250', 256, 45, 1, 'Diajukan', 'High', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-05 20:59:40', '2026-01-27 20:59:40'),
(600, 'ADU-Z870-10076', 2, 10, NULL, 1, 'Warga Wates', 'pelapor.wates50@example.com', '08175613624', '341754361263923', 'Laporan Kendala Fasilitas Umum - Wates', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wates, Kulon Progo.', 3, 3, '[\"report_files/69765097740bf_1769361559.png\"]', 'Wates, Kulon Progo, DI Yogyakarta', '-7.8881425', '110.1077980', 282, 20, 9, 'Selesai', 'Low', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-13 20:59:40', '2026-01-27 20:59:40'),
(601, 'ADU-KWGM-58148', 3, 15, NULL, 1, 'Warga Playen', 'pelapor.playen51@example.com', '08725883193', '341729164044447', 'Laporan Kendala Fasilitas Umum - Playen', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Playen, Gunung Kidul.', 8, 3, '[\"report_files/6916dcb3df0dd_1763105971.jpg\"]', 'Playen, Gunung Kidul, DI Yogyakarta', '-8.0775920', '110.5603850', 263, 1, 9, 'Selesai', 'High', 'Negative', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2025-12-30 20:59:40', '2026-01-27 20:59:40');
INSERT INTO `reports` (`id`, `tracking_id`, `user_id`, `admin_id`, `updated_by`, `is_anonim`, `nama_pengadu`, `email_pengadu`, `telepon_pengadu`, `nik`, `judul`, `isi`, `kategori_id`, `wilayah_id`, `file`, `lokasi`, `latitude`, `longitude`, `views`, `likes`, `dislikes`, `status`, `priority`, `sentiment`, `ai_analysis`, `suggested_kategori_id`, `komentar_revisi`, `is_arsip`, `created_at`, `updated_at`) VALUES
(602, 'ADU-8YJN-61659', 2, 15, NULL, 0, 'Warga Depok', 'pelapor.depok52@example.com', '08135454377', '344367029579118', 'Laporan Kendala Fasilitas Umum - Depok', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Depok, Sleman.', 8, 1, '[\"report_files/wwF98nkITN3IBFJQJSzwGUeqyCgArmvuKxJb0Hdr.jpg\"]', 'Depok, Sleman, DI Yogyakarta', '-7.7108861', '110.4205715', 11, 17, 1, 'Direspon', 'Medium', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-20 20:59:40', '2026-01-27 20:59:40'),
(603, 'ADU-0IZU-35282', 7, 10, NULL, 1, 'Warga Sewon', 'pelapor.sewon53@example.com', '08690069213', '342537348223573', 'Laporan Kendala Fasilitas Umum - Sewon', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Sewon, Bantul.', 14, 4, '[\"report_files/6916ed7059e66_1763110256.jpg\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.9963212', '110.3116030', 88, 35, 4, 'Selesai', 'Low', 'Positive', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-11 20:59:40', '2026-01-27 20:59:40'),
(604, 'ADU-NBRH-59674', 3, 17, NULL, 0, 'Warga Gamping', 'pelapor.gamping54@example.com', '08415523445', '342483875855609', 'Laporan Kendala Fasilitas Umum - Gamping', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Gamping, Sleman.', 10, 4, '[\"report_files/691460ebc476e_1762943211.jpg\"]', 'Gamping, Sleman, DI Yogyakarta', '-7.7283002', '110.3092160', 173, 4, 2, 'Diajukan', 'Low', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-25 20:59:40', '2026-01-27 20:59:40'),
(605, 'ADU-YMPS-98680', 2, 13, NULL, 0, 'Warga Piyungan', 'pelapor.piyungan55@example.com', '08562392479', '344393209169702', 'Laporan Kendala Fasilitas Umum - Piyungan', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Piyungan, Bantul.', 12, 3, '[\"report_files/6916db662a707_1763105638.jpg\"]', 'Piyungan, Bantul, DI Yogyakarta', '-7.8627828', '110.3614460', 92, 23, 10, 'Diajukan', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-10 20:59:40', '2026-01-27 20:59:40'),
(606, 'ADU-GFQJ-11013', 7, 11, NULL, 0, 'Warga Wonosari', 'pelapor.wonosari56@example.com', '08338180317', '344190766464664', 'Laporan Kendala Fasilitas Umum - Wonosari', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Wonosari, Gunung Kidul.', 4, 4, '[\"report_files/6976719dc591b_1769370013.jpg\"]', 'Wonosari, Gunung Kidul, DI Yogyakarta', '-7.9862920', '110.5943125', 24, 18, 3, 'Direspon', 'Emergency', 'Negative', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-19 20:59:40', '2026-01-27 20:59:40'),
(607, 'ADU-AX3H-60814', 3, 13, NULL, 1, 'Warga Gamping', 'pelapor.gamping57@example.com', '08757008505', '344607612011353', 'Laporan Kendala Fasilitas Umum - Gamping', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Gamping, Sleman.', 6, 3, '[\"report_files/26VnQijdCxpSme2L0YRZ18TwLekdO1Wdmw7OmcdM.jpg\"]', 'Gamping, Sleman, DI Yogyakarta', '-7.7064476', '110.4335045', 229, 22, 0, 'Selesai', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-22 20:59:40', '2026-01-27 21:15:48'),
(608, 'ADU-RBLB-70219', 7, 14, NULL, 0, 'Warga Semanu', 'pelapor.semanu58@example.com', '08894691381', '342430472520618', 'Pohon Tumbang Belum Dievakuasi - Semanu', 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani. Lokasi detail di wilayah Semanu, Gunung Kidul.', 7, 4, '[\"report_files/69728813365a0_1769113619.jpeg\"]', 'Semanu, Gunung Kidul, DI Yogyakarta', '-7.9048160', '110.5604525', 33, 36, 0, 'Dibaca', 'Emergency', 'Positive', 'Laporan masuk dari wilayah Gunung Kidul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-12 20:59:40', '2026-01-27 20:59:40'),
(609, 'ADU-ZWEL-31372', 6, NULL, NULL, 0, 'Warga Parangtritis', 'pelapor.parangtritis59@example.com', '08202674754', '344511391210657', 'Laporan Kendala Fasilitas Umum - Parangtritis', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Parangtritis, Bantul.', 19, 4, '[\"report_files/69786fc7509e6_1769500615.png\"]', 'Parangtritis, Bantul, DI Yogyakarta', '-7.9522317', '110.3463240', 265, 41, 6, 'Selesai', 'Medium', 'Negative', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-12 20:59:40', '2026-01-27 20:59:40'),
(610, 'ADU-80MM-51422', 2, 10, NULL, 0, 'Warga Malioboro', 'pelapor.malioboro60@example.com', '08473090850', '343422268606959', 'Laporan Kendala Fasilitas Umum - Malioboro', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Malioboro, Kota Yogyakarta.', 3, 1, '[\"report_files/saSMGea3BS66rWTCaZn6jK6ny04vcnaF4NIm10zw.jpg\"]', 'Malioboro, Kota Yogyakarta, DI Yogyakarta', '-7.8041920', '110.3582096', 16, 15, 8, 'Diajukan', 'Medium', 'Positive', 'Laporan masuk dari wilayah Kota Yogyakarta. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-04 20:59:40', '2026-01-27 20:59:40'),
(611, 'ADU-YZFI-47885', 3, 14, NULL, 0, 'Warga Sewon', 'pelapor.sewon61@example.com', '08904184112', '344786114767320', 'Pohon Tumbang Belum Dievakuasi - Sewon', 'Ada pohon besar tumbang menghalangi sebagian badan jalan, mohon segera ditangani. Lokasi detail di wilayah Sewon, Bantul.', 7, 1, '[\"report_files/rMvHcS6uz1bUAdFXz2NxwyxbZ01d8m3Uxc9LI1RA.png\"]', 'Sewon, Bantul, DI Yogyakarta', '-7.9724294', '110.3652960', 23, 48, 7, 'Direspon', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Bantul. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-16 20:59:40', '2026-01-27 20:59:40'),
(612, 'ADU-IU0T-48076', 2, 8, NULL, 0, 'Warga Mlati', 'pelapor.mlati62@example.com', '08809592266', '341116624949439', 'Laporan Kendala Fasilitas Umum - Mlati', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mlati, Sleman.', 1, 5, '[\"report_files/6935854e5abde_1765115214.png\"]', 'Mlati, Sleman, DI Yogyakarta', '-7.7121555', '110.3713775', 109, 29, 9, 'Dibaca', 'Emergency', 'Neutral', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-18 20:59:40', '2026-01-27 20:59:40'),
(613, 'ADU-UXO3-87131', 6, NULL, NULL, 0, 'Warga Mlati', 'pelapor.mlati63@example.com', '08319496241', '344585743371164', 'Laporan Kendala Fasilitas Umum - Mlati', 'Terdapat kendala pada fasilitas publik di lokasi kami. Mohon segera ditindaklanjuti demi kenyamanan bersama. Lokasi detail di wilayah Mlati, Sleman.', 19, 4, '[\"report_files/6978664bac8c0_1769498187.png\"]', 'Mlati, Sleman, DI Yogyakarta', '-7.7175213', '110.4066410', 106, 36, 10, 'Direspon', 'Low', 'Positive', 'Laporan masuk dari wilayah Sleman. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-02 20:59:40', '2026-01-27 20:59:40'),
(614, 'ADU-UWJG-50203', 2, 9, NULL, 0, 'Warga Nanggulan', 'pelapor.nanggulan64@example.com', '08800754465', '342467654849029', 'Keluhan Antrian BPJS Terlalu Lama - Nanggulan', 'Antrian pendaftaran sangat panjang dan tidak teratur. Mohon ditingkatkan sistem layanannya. Lokasi detail di wilayah Nanggulan, Kulon Progo.', 2, 5, '[\"report_files/L4CVWVoNUNkRrnhkEyrEBeIegIYbUozr7eqpqmpr.jpg\"]', 'Nanggulan, Kulon Progo, DI Yogyakarta', '-7.8931360', '110.1946450', 134, 31, 3, 'Direspon', 'Low', 'Negative', 'Laporan masuk dari wilayah Kulon Progo. Analisis awal menunjukkan kebutuhan respon cepat.', NULL, NULL, 0, '2026-01-09 20:59:40', '2026-01-27 20:59:40'),
(615, 'SPEC-ZEGO-85716', 5, 14, NULL, 1, 'Warga Umbulharjo', 'user.umbulharjo193@example.com', '08207121389', '344529435976762', 'Tumpukan Sampah Liar (28 Jan 2026)', 'Warga mengeluhkan tumpukan sampah di pinggir jalan. Laporan ini dibuat pada 28 January 2026.', 7, 5, '[\"report_files/6915e6997f64b_1763042969.jpg\"]', 'Umbulharjo, Kota Yogyakarta, DIY', '-7.8018050', '110.3719436', 40, 0, 0, 'Dibaca', 'High', 'Positive', NULL, NULL, NULL, 0, '2026-01-28 05:34:00', '2026-01-28 05:55:33'),
(616, 'SPEC-KHBB-15297', 3, 17, NULL, 0, 'Warga Mlati', 'user.mlati621@example.com', '08331690050', '344828206080467', 'Laporan Fasilitas Umum (28 Jan 2026)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 28 January 2026.', 10, 2, '[\"report_files/6915eef4b95bf_1763045108.jpg\"]', 'Mlati, Sleman, DIY', '-7.6617194', '110.4499805', 69, 0, 0, 'Dibaca', 'Low', 'Positive', NULL, NULL, NULL, 0, '2026-01-28 01:05:00', '2026-01-28 01:05:00'),
(617, 'SPEC-MC3Z-50115', 2, 12, NULL, 0, 'Warga Kasihan', 'user.kasihan291@example.com', '08733090773', '341875605772154', 'Kemacetan Akibat Parkir Liar (28 Jan 2026)', 'Banyak kendaraan parkir sembarangan menyebabkan kemacetan. Laporan ini dibuat pada 28 January 2026.', 5, 3, '[\"report_files/69787125a9c89_1769500965.png\"]', 'Kasihan, Bantul, DIY', '-7.8498339', '110.3096200', 38, 0, 0, 'Dibaca', 'Low', 'Negative', NULL, NULL, NULL, 0, '2026-01-28 02:10:00', '2026-01-28 02:01:33'),
(618, 'SPEC-VY5L-13386', 4, 13, NULL, 1, 'Warga Kotagede', 'user.kotagede123@example.com', '08997185314', '343612414217661', 'Laporan Fasilitas Umum (28 Jan 2026)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 28 January 2026.', 6, 3, '[\"report_files/aZp4Gw6zKvNxESXgFZFbUIVrubGczRXWu1mkZYO0.png\"]', 'Kotagede, Kota Yogyakarta, DIY', '-7.7744520', '110.3705776', 61, 0, 0, 'Diajukan', 'Emergency', 'Negative', NULL, NULL, NULL, 0, '2026-01-28 07:16:00', '2026-01-27 21:13:25'),
(619, 'SPEC-0MRM-85843', 5, 8, 1, 0, 'Warga Kotagede', 'user.kotagede554@example.com', '08137793247', '342702455070725', 'Laporan Fasilitas Umum (28 Jan 2026)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 28 January 2026.', 1, 4, '[\"report_files/6916dc75e3219_1763105909.jpg\"]', 'Kotagede, Kota Yogyakarta, DIY', '-7.7936995', '110.3862736', 10, 0, 0, 'Revisi', 'High', 'Neutral', NULL, NULL, 'Perbaiki Foto Lampiran', 0, '2026-01-28 07:48:00', '2026-01-27 21:08:41'),
(620, 'SPEC-JGFJ-83232', 3, 12, NULL, 0, 'Warga Sewon', 'user.sewon294@example.com', '08710662886', '343666809812969', 'Kemacetan Akibat Parkir Liar (28 Jan 2026)', 'Banyak kendaraan parkir sembarangan menyebabkan kemacetan. Laporan ini dibuat pada 28 January 2026.', 5, 2, '[\"report_files/69155816b82ed_1763006486.jpg\"]', 'Sewon, Bantul, DIY', '-7.8998326', '110.3406410', 31, 0, 0, 'Diajukan', 'Emergency', 'Positive', NULL, NULL, NULL, 0, '2026-01-28 02:32:00', '2026-01-28 02:32:00'),
(621, 'SPEC-ARTV-65302', 4, 9, NULL, 0, 'Warga Gamping', 'user.gamping821@example.com', '08880563973', '343348446058334', 'Layanan Puskesmas Lambat (28 Jan 2026)', 'Antrian pendaftaran sangat panjang. Mohon ditingkatkan. Laporan ini dibuat pada 28 January 2026.', 2, 1, '[\"report_files/697662377ef6a_1769366071.png\"]', 'Gamping, Sleman, DIY', '-7.7271353', '110.4302120', 58, 0, 0, 'Selesai', 'High', 'Negative', NULL, NULL, NULL, 0, '2026-01-28 02:36:00', '2026-01-28 02:36:00'),
(622, 'SPEC-GIOU-30694', 7, 13, NULL, 0, 'Warga Depok', 'user.depok638@example.com', '08537636221', '343231058898411', 'Laporan Fasilitas Umum (28 Jan 2026)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 28 January 2026.', 12, 1, '[\"report_files/5eZpXlVTG81kEFkdag7dStTKHT0IZDet3F4pD8qP.jpg\"]', 'Depok, Sleman, DIY', '-7.7161232', '110.3243510', 94, 0, 0, 'Selesai', 'Low', 'Neutral', NULL, NULL, NULL, 0, '2026-01-28 03:14:00', '2026-01-28 03:14:00'),
(623, 'SPEC-9UKI-43383', 5, 17, NULL, 1, 'Warga Baron', 'user.baron371@example.com', '08390773631', '342701600842765', 'Laporan Fasilitas Umum (28 Jan 2026)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 28 January 2026.', 10, 3, '[\"report_files/6916ed293ca65_1763110185.jpg\"]', 'Baron, Gunung Kidul, DIY', '-8.0456800', '110.5203700', 84, 0, 0, 'Revisi', 'Emergency', 'Neutral', NULL, NULL, 'Perbaiki FOto', 0, '2026-01-28 08:01:00', '2026-01-27 21:13:13'),
(624, 'SPEC-BDHW-26321', 4, 18, NULL, 1, 'Warga Sentolo', 'user.sentolo141@example.com', '08229290675', '342692335495829', 'Laporan Fasilitas Umum (28 Jan 2026)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 28 January 2026.', 11, 1, '[\"report_files/6916dcb3df0dd_1763105971.jpg\"]', 'Sentolo, Kulon Progo, DIY', '-7.7655205', '110.0713135', 21, 0, 0, 'Direspon', 'High', 'Neutral', NULL, NULL, NULL, 0, '2026-01-28 03:51:00', '2026-01-28 03:51:00'),
(625, 'SPEC-NQHB-60963', 3, 12, NULL, 0, 'Warga Piyungan', 'user.piyungan962@example.com', '08982517025', '342845728656153', 'Kemacetan Akibat Parkir Liar (17 Dec 2025)', 'Banyak kendaraan parkir sembarangan menyebabkan kemacetan. Laporan ini dibuat pada 17 December 2025.', 5, 3, '[\"report_files/693589f7d025c_1765116407.png\"]', 'Piyungan, Bantul, DIY', '-7.9430024', '110.3351590', 12, 0, 0, 'Direspon', 'Emergency', 'Negative', NULL, NULL, NULL, 0, '2025-12-17 09:12:00', '2025-12-17 09:12:00'),
(626, 'SPEC-S7SF-40359', 5, 13, NULL, 0, 'Warga Kotagede', 'user.kotagede331@example.com', '08294066306', '342209310769255', 'Laporan Fasilitas Umum (14 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 14 December 2025.', 13, 3, '[\"report_files/zH3LrZkUfTKQ7JkA17JthWF9EuunA5jWqGEdmohZ.png\"]', 'Kotagede, Kota Yogyakarta, DIY', '-7.7862860', '110.3591788', 100, 0, 0, 'Direspon', 'Emergency', 'Negative', NULL, NULL, NULL, 0, '2025-12-14 02:43:00', '2025-12-14 02:43:00'),
(627, 'SPEC-HZEO-58160', 7, 15, NULL, 0, 'Warga Kasihan', 'user.kasihan223@example.com', '08245954425', '342806619948500', 'Laporan Fasilitas Umum (24 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 24 December 2025.', 8, 4, '[\"report_files/6972aef380054_1769123571.jpeg\"]', 'Kasihan, Bantul, DIY', '-7.8740402', '110.3892890', 19, 0, 0, 'Arsip', 'High', 'Neutral', NULL, NULL, NULL, 0, '2025-12-24 09:28:00', '2026-01-27 21:07:11'),
(628, 'SPEC-T01S-74437', 6, NULL, NULL, 1, 'Warga Umbulharjo', 'user.umbulharjo430@example.com', '08343641456', '341480012474658', 'Laporan Fasilitas Umum (16 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 16 December 2025.', 15, 3, '[\"report_files/lAFkO0eJcrXNPr4g6EM0toRV1MmbbRTV9A6DhSiQ.jpg\"]', 'Umbulharjo, Kota Yogyakarta, DIY', '-7.7985190', '110.3710768', 21, 0, 0, 'Arsip', 'Emergency', 'Neutral', NULL, NULL, NULL, 0, '2025-12-16 01:34:00', '2026-01-27 21:06:43'),
(629, 'SPEC-UVDC-41813', 6, NULL, NULL, 0, 'Warga Kasihan', 'user.kasihan384@example.com', '08229913398', '341679845418472', 'Laporan Fasilitas Umum (26 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 26 December 2025.', 15, 4, '[\"report_files/XbDX5VmufN3SOblJAprohgcmsgtn6E0q1eeli1nH.jpg\"]', 'Kasihan, Bantul, DIY', '-7.9814054', '110.3574640', 71, 0, 0, 'Selesai', 'Medium', 'Negative', NULL, NULL, NULL, 0, '2025-12-26 01:24:00', '2026-01-27 21:11:54'),
(630, 'SPEC-IVMQ-72376', 4, 13, NULL, 1, 'Warga Temon', 'user.temon689@example.com', '08269792210', '341973003567811', 'Laporan Fasilitas Umum (30 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 30 December 2025.', 13, 1, '[\"report_files/6918a9e9e3bd2_1763224041.jpg\"]', 'Temon, Kulon Progo, DIY', '-7.8377110', '110.1677410', 87, 0, 0, 'Direspon', 'Medium', 'Negative', NULL, NULL, NULL, 0, '2025-12-30 02:06:00', '2025-12-30 02:06:00'),
(631, 'SPEC-XKQ6-64912', 2, 10, NULL, 0, 'Warga Wates', 'user.wates581@example.com', '08486214428', '341653886423039', 'Laporan Fasilitas Umum (04 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 04 December 2025.', 3, 2, '[\"report_files/693589f7d025c_1765116407.png\"]', 'Wates, Kulon Progo, DIY', '-7.8517015', '110.1296710', 10, 0, 0, 'Arsip', 'Low', 'Negative', NULL, NULL, NULL, 0, '2025-12-04 04:11:00', '2026-01-27 21:06:28'),
(632, 'SPEC-WNSM-24809', 6, 13, NULL, 0, 'Warga Kasihan', 'user.kasihan827@example.com', '08572377160', '341543812249263', 'Laporan Fasilitas Umum (11 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 11 December 2025.', 12, 3, '[\"report_files/693588a1b691e_1765116065.png\"]', 'Kasihan, Bantul, DIY', '-7.9082799', '110.3371260', 6, 0, 0, 'Direspon', 'Medium', 'Negative', NULL, NULL, NULL, 0, '2025-12-11 07:44:00', '2025-12-11 07:44:00'),
(633, 'SPEC-O4FW-35366', 4, 11, NULL, 0, 'Warga Wates', 'user.wates997@example.com', '08796525932', '343950975962811', 'Laporan Fasilitas Umum (31 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 31 December 2025.', 4, 1, '[\"report_files/rnNn4kKezBtJ05fGjvje6YoYco383oero9fArdgv.jpg\"]', 'Wates, Kulon Progo, DIY', '-7.8337000', '110.1559795', 38, 0, 0, 'Diajukan', 'Medium', 'Neutral', NULL, NULL, NULL, 0, '2025-12-31 06:40:00', '2025-12-31 06:40:00'),
(634, 'SPEC-NMMR-45934', 4, 10, NULL, 0, 'Warga Danurejan', 'user.danurejan311@example.com', '08623214975', '343350001394063', 'Laporan Fasilitas Umum (17 Dec 2025)', 'Terdapat kendala pada fasilitas publik. Mohon tindak lanjutnya. Laporan ini dibuat pada 17 December 2025.', 14, 3, '[\"report_files/691553c92ab44_1763005385.jpg\"]', 'Danurejan, Kota Yogyakarta, DIY', '-7.8053570', '110.3800700', 68, 0, 0, 'Selesai', 'Emergency', 'Neutral', NULL, NULL, NULL, 0, '2025-12-17 05:32:00', '2025-12-17 05:32:00');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NeFemX9GP7nbRdxifLk4JD1AZvm5dK7IIypUigLE', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibmRuMTJ0SEFuQTFQOVFHam1rRmQ2NE9NTnpBd2JJbVlucDBSWkVGeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmZvL3VzZS1jYXNlL3VzZXIiO3M6NToicm91dGUiO3M6MTM6InVzZS1jYXNlLnVzZXIiO31zOjE3OiJyZXBvcnRfdmlld2VkXzYxNSI7YjoxO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9fQ==', 1769598508);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('user','admin','superadmin','wbs_admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `email_verified_at`, `password`, `foto`, `nik`, `nomor_telepon`, `role`, `remember_token`, `created_at`, `updated_at`, `google_id`, `avatar`) VALUES
(1, 'Superadmin', 'superadmin@gmail.com', '2026-01-27 20:39:42', '$2y$12$IulTdlduXjheu3VMKsWb3.hB4YBYyqIrASRMV2qVr3ndF6adOfqli', NULL, '20220140130', '087817182358', 'superadmin', 'ajvjtmBOhCb62yFP3K76INHuVEIIKCuyFjcsTdWXwIAea96PcZTMPHXIG5Rl', '2026-01-27 20:39:42', '2026-01-27 20:39:42', NULL, NULL),
(2, 'Farhan', 'farhanvirenze18@gmail.com', '2026-01-27 20:39:42', '$2y$12$F3xeDAxsa/oITpVuWqbdVOL6kb1qzfJforBdv0wJt1e36tYmRmn2e', NULL, '20220140139', '087817184079', 'user', 'l4elkzI3ixUWLyd3pHoFXKFXQpNBwfPMh5mJwpGO4y1BLXNMEaaCRuquG4Nh', '2026-01-27 20:39:43', '2026-01-27 21:17:02', '108812523506611172388', 'https://lh3.googleusercontent.com/a/ACg8ocLoT1kmb36t32a5nqcXsTveZEZ5RwK-uSOAbGUAtYh-yIZO8Sc6=s96-c'),
(3, 'Kevin', 'kevin@gmail.com', '2026-01-27 20:39:43', '$2y$12$wCWXbiV9sASnGJUG7/GFIeJmLArx5A9xvWtZ5.ZadkEpXStPBNIAe', NULL, '20220140140', '081234567891', 'user', '1k60PWLF6N', '2026-01-27 20:39:43', '2026-01-27 20:39:43', NULL, NULL),
(4, 'Bagas Saputra', 'bagas.saputra@gmail.com', '2026-01-27 20:39:43', '$2y$12$lb60h5/Abwks54JSmb6tbeNofH/zzqC.GeXmmrqiwsWyngpQapG.W', NULL, '20220140141', '082223334455', 'user', 'qPYIEpXtUT', '2026-01-27 20:39:43', '2026-01-27 20:39:43', NULL, NULL),
(5, 'Citra Amelia', 'citra.amelia@gmail.com', '2026-01-27 20:39:43', '$2y$12$Rzyo8tQjjjj/uaiIyxX45uyVXmxOQjTjMgnWQFUJ2PPz/i7Nk4ayi', NULL, '20220140142', '083312345678', 'user', 'CVEoOhSrcK', '2026-01-27 20:39:43', '2026-01-27 20:39:43', NULL, NULL),
(6, 'Dedi Pratama', 'dedi.pratama@gmail.com', '2026-01-27 20:39:43', '$2y$12$99XZpqxKjV4I9urlWkNpOe7mXgOdNIFxGAQc47L.FeJLQnZkvzUuS', NULL, '20220140143', '085678901234', 'user', '9VOEarpG53', '2026-01-27 20:39:44', '2026-01-27 20:39:44', NULL, NULL),
(7, 'Eka Lestari', 'eka.lestari@gmail.com', '2026-01-27 20:39:44', '$2y$12$EGSjiGbcfMOaXJPSB5JlhuYN6UrK3YoS/jvIQ2.jOoIeJJUw5ssY6', NULL, '20220140144', '087701234567', 'user', 'vZQ23W68lm', '2026-01-27 20:39:44', '2026-01-27 20:39:44', NULL, NULL),
(8, 'Dinas Pendidikan DIY', 'dinas_pendidikan_diy@gmail.com', '2026-01-27 20:39:44', '$2y$12$s7l/jRpNcd/RW/qg3SpLsO.TzcuIlkr5uh6mx1f7JjNGB7floiytC', NULL, '352800000001', '086803208940', 'admin', 'MVU0UToBQ3', '2026-01-27 20:39:44', '2026-01-27 20:39:44', NULL, NULL),
(9, 'Dinas Kesehatan DIY', 'dinas_kesehatan_diy@gmail.com', '2026-01-27 20:39:44', '$2y$12$EeYDZXE7R0TbGj9dU9FIPuupHcpxKVaj.nPxc5gdvn0mG4HMLYgmq', NULL, '352800000002', '088488008744', 'admin', 'wpxe8semts', '2026-01-27 20:39:44', '2026-01-27 20:39:44', NULL, NULL),
(10, 'Dinas Sosial DIY', 'dinas_sosial_diy@gmail.com', '2026-01-27 20:39:44', '$2y$12$MczoiBTjQchRtf2sjxoQ2ecpFBjdopbUMLVOcHXoZsPb0PC0Dvjje', NULL, '352800000003', '081117565990', 'admin', 'eiY1daHKEA', '2026-01-27 20:39:45', '2026-01-27 20:39:45', NULL, NULL),
(11, 'Dinas Kebudayaan DIY', 'dinas_kebudayaan_diy@gmail.com', '2026-01-27 20:39:45', '$2y$12$cs4ZGbHFjSReLOYrYe691.UqAgLAlaOrQ6ee2vTu4hYe7sfLn4eum', NULL, '352800000004', '086317448835', 'admin', 'Ldwj7hw5DF', '2026-01-27 20:39:45', '2026-01-27 20:39:45', NULL, NULL),
(12, 'Dinas Perhubungan DIY', 'dinas_perhubungan_diy@gmail.com', '2026-01-27 20:39:45', '$2y$12$66oTWlWHGA7Pu9Ky5iQTD.Gx6QaX.yx5ZiA3/ndKojOwGXw0jwfuq', NULL, '352800000005', '086632516214', 'admin', 'fgfcKJeI1o', '2026-01-27 20:39:45', '2026-01-27 20:39:45', NULL, NULL),
(13, 'Dinas Pekerjaan Umum DIY', 'dinas_pekerjaan_umum_diy@gmail.com', '2026-01-27 20:39:45', '$2y$12$3z838cs5frzIa/SE5kOhtOhl8xLyQfkJCGl3CQgXkZhw0CijsVO92', NULL, '352800000006', '088594512916', 'admin', 'I0Sauk2O8Q', '2026-01-27 20:39:46', '2026-01-27 20:39:46', NULL, NULL),
(14, 'Dinas Lingkungan Hidup DIY', 'dinas_lingkungan_hidup_diy@gmail.com', '2026-01-27 20:39:46', '$2y$12$pGacyWrep0R1gxQjdUWix.EZrhHvFmLGhXSEGQJhhDEcANyK6YQKO', NULL, '352800000007', '087334045301', 'admin', 'nTiTyzW980', '2026-01-27 20:39:46', '2026-01-27 20:39:46', NULL, NULL),
(15, 'Dinas Koperasi dan UKM DIY', 'dinas_koperasi_dan_ukm_diy@gmail.com', '2026-01-27 20:39:46', '$2y$12$Sxj.TTN3xnDRamKR2Bjh8OiaIDvBi8qj75oyKRE6m6AdHIVyn18E6', NULL, '352800000008', '083519387853', 'admin', 'EmRWRprJgu', '2026-01-27 20:39:46', '2026-01-27 20:39:46', NULL, NULL),
(16, 'Dinas Pertanian DIY', 'dinas_pertanian_diy@gmail.com', '2026-01-27 20:39:46', '$2y$12$/qOMeIAcrf0tAkl1Czxv6uTeJiclwXbz/wrBR3dfMNZgSIWRaEyFK', NULL, '352800000009', '089352853742', 'admin', 'saItC8gJHC', '2026-01-27 20:39:47', '2026-01-27 20:39:47', NULL, NULL),
(17, 'Dinas Pariwisata DIY', 'dinas_pariwisata_diy@gmail.com', '2026-01-27 20:39:47', '$2y$12$F3v6AV80426yNSkBbxdqju2y0NTyEFpWATNZMMmSN6tvRx9quka8q', NULL, '352800000010', '086408386101', 'admin', '7uRBhKlb5q', '2026-01-27 20:39:47', '2026-01-27 20:39:47', NULL, NULL),
(18, 'Dinas Kominfo DIY', 'dinas_kominfo_diy@gmail.com', '2026-01-27 20:39:47', '$2y$12$wnaOIl3/4gUQV/7PEsv7Cef4TMNLP9sUSeBa5El.H8mFVqBBJ2Dha', NULL, '352800000011', '089243033774', 'admin', '8bN02s7yfW', '2026-01-27 20:39:47', '2026-01-27 20:39:47', NULL, NULL),
(19, 'Nia Ramadhani 1', 'nia-ramadhani1@example.com', '2026-01-27 21:10:21', '$2y$12$cnUv/EuytJ3CpZcphuAt.OgKdxdqdQDWcU2Vkjb8tRWxemWryIjWm', NULL, '3460463872972012', '08668514534', 'user', NULL, '2026-01-27 21:10:21', '2026-01-27 21:10:21', NULL, NULL),
(20, 'Arif Rahman 2', 'arif-rahman2@example.com', '2026-01-27 21:10:21', '$2y$12$S8TTvPtBCZ7fiX2olrTuYO6.MfFjDDOAu/YWurW/3T3GsJX9sG76S', NULL, '3494137300091153', '08630949999', 'user', NULL, '2026-01-27 21:10:21', '2026-01-27 21:10:21', NULL, NULL),
(21, 'Adi Nugroho 3', 'adi-nugroho3@example.com', '2026-01-27 21:10:22', '$2y$12$Bu8O1W4.q6IkBW.Y.6lCAuS.3mDbYwW5/kxQB5IUsx9rE.ZxaNXeO', NULL, '3495788568088112', '08825190501', 'user', NULL, '2026-01-27 21:10:22', '2026-01-27 21:10:22', NULL, NULL),
(22, 'Dewi Lestari 4', 'dewi-lestari4@example.com', '2026-01-27 21:10:22', '$2y$12$hqopCld9cS3x.46g.DogueEqcz63y8kNuGVlkr1xsDSnMNxUQJaX2', NULL, '3442468721531741', '08610898581', 'user', NULL, '2026-01-27 21:10:22', '2026-01-27 21:10:22', NULL, NULL),
(23, 'Andi Wijaya 5', 'andi-wijaya5@example.com', '2026-01-27 21:10:22', '$2y$12$E.kOWz71XQrM7hM.Uydic.oAGqpSEAj0qEMS9m29LSNvBTMfyBuBm', NULL, '3465178608697990', '08999189157', 'user', NULL, '2026-01-27 21:10:22', '2026-01-27 21:10:22', NULL, NULL),
(24, 'Budi Santoso 6', 'budi-santoso6@example.com', '2026-01-27 21:10:22', '$2y$12$SVnFD14maOiouqCa1ySmUetsHwMFFAFCmkg0bwL9DIPoNnfrig0Ty', NULL, '3459825804484058', '08548678509', 'user', NULL, '2026-01-27 21:10:22', '2026-01-27 21:10:22', NULL, NULL),
(25, 'Dian Saputri 7', 'dian-saputri7@example.com', '2026-01-27 21:10:23', '$2y$12$1ZY5SCSROOSiIRuOi46viOq6QBCJUQI.TEfLmUBfu5dTMpsMoMvOC', NULL, '3420674939506479', '08576070522', 'user', NULL, '2026-01-27 21:10:23', '2026-01-27 21:10:23', NULL, NULL),
(26, 'Anita Wijayanti 8', 'anita-wijayanti8@example.com', '2026-01-27 21:10:23', '$2y$12$x5bXS63NbVQb0TEQyxCtF.71j0U6E5/USMxv/TshYVCsLf05ge5l6', NULL, '3477337403014288', '08476101595', 'user', NULL, '2026-01-27 21:10:23', '2026-01-27 21:10:23', NULL, NULL),
(27, 'Indah Permata 9', 'indah-permata9@example.com', '2026-01-27 21:10:24', '$2y$12$RLw/XQWZScCeyOhQpbIc6ekVQ15kL4u7Ssm75IApkTnoo7QNI8HuC', NULL, '3415583440082596', '08866034981', 'user', NULL, '2026-01-27 21:10:24', '2026-01-27 21:10:24', NULL, NULL),
(28, 'Rizky Pratama 10', 'rizky-pratama10@example.com', '2026-01-27 21:10:24', '$2y$12$wnlrdk1pMbzjx3bAnaX6HO0sigjnXIPX3CQv6yR.G0RqXkIcQk09e', NULL, '3455588233738831', '08886169222', 'user', NULL, '2026-01-27 21:10:24', '2026-01-27 21:10:24', NULL, NULL),
(29, 'Mega Utami 11', 'mega-utami11@example.com', '2026-01-27 21:10:25', '$2y$12$s9li.0ZqPaAuZV0c6LF0ZOlrSLMeWAsWLbr0gltmABW0tsqgRgckm', NULL, '3438709719010158', '08356893330', 'user', NULL, '2026-01-27 21:10:25', '2026-01-27 21:10:25', NULL, NULL),
(30, 'Rahmat Hidayat 12', 'rahmat-hidayat12@example.com', '2026-01-27 21:10:25', '$2y$12$baPavshMOASo7DaKIlVEUurh0wKce2CozWQz3N9e1neR/v3fuL5MC', NULL, '3429432603540914', '08506712545', 'user', NULL, '2026-01-27 21:10:25', '2026-01-27 21:10:25', NULL, NULL),
(31, 'Linda Kusuma 13', 'linda-kusuma13@example.com', '2026-01-27 21:10:25', '$2y$12$W88LeUOXKHl3U5cDGzaJCuLXOT7g3N2E2KzY7WUbiq3OQ0Y9coKwi', NULL, '3485557532482864', '08534142020', 'user', NULL, '2026-01-27 21:10:25', '2026-01-27 21:10:25', NULL, NULL),
(32, 'Dedi Kurniawan 14', 'dedi-kurniawan14@example.com', '2026-01-27 21:10:26', '$2y$12$wz8wFMrJqeclxYuDk/S5AO0XroIcJcjnb2C3JaHlBcf7SgKIxE88m', NULL, '3437405117110307', '08827009410', 'user', NULL, '2026-01-27 21:10:26', '2026-01-27 21:10:26', NULL, NULL),
(33, 'Hendra Kusuma 15', 'hendra-kusuma15@example.com', '2026-01-27 21:10:26', '$2y$12$39CiL9xUK.SvSfekES/cke5kxCtu/2r4PMtKXFvHvkZpi7sr8Ec96', NULL, '3485071572133316', '08508148799', 'user', NULL, '2026-01-27 21:10:26', '2026-01-27 21:10:26', NULL, NULL),
(34, 'Adi Nugroho 16', 'adi-nugroho16@example.com', '2026-01-27 21:10:26', '$2y$12$SDEH261mkbRG8/eJzo.7k.AdbN6K80lau01Tusqf6wlOSwIvrmb.q', NULL, '3479961385132794', '08113160345', 'user', NULL, '2026-01-27 21:10:26', '2026-01-27 21:10:26', NULL, NULL),
(35, 'Taufik Hidayat 17', 'taufik-hidayat17@example.com', '2026-01-27 21:10:27', '$2y$12$zOnaMco8vpIsO99wi8jU1uQBmmzKCRk0OCXQYOmVyXg5nAb.HM.Wi', NULL, '3477269738392431', '08464543910', 'user', NULL, '2026-01-27 21:10:27', '2026-01-27 21:10:27', NULL, NULL),
(36, 'Fajar Ramadhan 18', 'fajar-ramadhan18@example.com', '2026-01-27 21:10:27', '$2y$12$QT6paM6gcou4DoTGY0IJ6elAhRlE9Pef/ZJx2DMYjUCt1BakXZKyG', NULL, '3443145781080968', '08939086815', 'user', NULL, '2026-01-27 21:10:27', '2026-01-27 21:10:27', NULL, NULL),
(37, 'Maya Sari 19', 'maya-sari19@example.com', '2026-01-27 21:10:27', '$2y$12$ZsF22Kkn4gCSjkCDfvnVce.vnODasYvUpQ02c4LSEIxsFmi5f8bZS', NULL, '3481877629591528', '08953612678', 'user', NULL, '2026-01-27 21:10:27', '2026-01-27 21:10:27', NULL, NULL),
(38, 'Dedi Kurniawan 20', 'dedi-kurniawan20@example.com', '2026-01-27 21:10:27', '$2y$12$DTLlWPywKP9tY.yOtUWGNeJ0xM7i0uQ9QLYqj6MfY9L2zkS4cIoO2', NULL, '3478118461156233', '08186598547', 'user', NULL, '2026-01-27 21:10:27', '2026-01-27 21:10:27', NULL, NULL),
(39, 'Taufik Hidayat 21', 'taufik-hidayat21@example.com', '2026-01-27 21:10:28', '$2y$12$hPfSXQp3TGlyhxRCSRMwW.v3pFqo2l02O/dZXgi78O7eOrmFl1/ku', NULL, '3457616737859346', '08481070052', 'user', NULL, '2026-01-27 21:10:28', '2026-01-27 21:10:28', NULL, NULL),
(40, 'Rizky Pratama 22', 'rizky-pratama22@example.com', '2026-01-27 21:10:28', '$2y$12$iubN01EJIHskY8uV0ttDDe36YAN/PA/jPIHj8Gl1WBpgXspiuJQbi', NULL, '3426359239148226', '08999992547', 'user', NULL, '2026-01-27 21:10:28', '2026-01-27 21:10:28', NULL, NULL),
(41, 'Adi Nugroho 23', 'adi-nugroho23@example.com', '2026-01-27 21:10:29', '$2y$12$pDdigAYw5Iwftg1w9RjT/OjKRYwKurnqC7m.6KRC6ktkAH5wEglLe', NULL, '3474244365385293', '08790086863', 'user', NULL, '2026-01-27 21:10:29', '2026-01-27 21:10:29', NULL, NULL),
(42, 'Dedi Kurniawan 24', 'dedi-kurniawan24@example.com', '2026-01-27 21:10:29', '$2y$12$Xj0gAHfj.n2biBQ9W3.WNeDu1ske.SYOA6MEM0UAZcOXJgbK8nBkm', NULL, '3464847165354553', '08875775887', 'user', NULL, '2026-01-27 21:10:29', '2026-01-27 21:10:29', NULL, NULL),
(43, 'Rizky Pratama 25', 'rizky-pratama25@example.com', '2026-01-27 21:10:29', '$2y$12$DV0otnm24rZIChY7zF.yt.Ab9DGTNy8WHWAlSUYTDwYMEEG8LxS.K', NULL, '3450446724269798', '08961957198', 'user', NULL, '2026-01-27 21:10:29', '2026-01-27 21:10:29', NULL, NULL),
(44, 'Taufik Hidayat 26', 'taufik-hidayat26@example.com', '2026-01-27 21:10:30', '$2y$12$1bhVILsrrYFxupUMM3aT0OngXynkAXTO/b46TlHm9jVmPF.lcElGm', NULL, '3467924939134860', '08488504446', 'user', NULL, '2026-01-27 21:10:30', '2026-01-27 21:10:30', NULL, NULL),
(45, 'Indah Permata 27', 'indah-permata27@example.com', '2026-01-27 21:10:30', '$2y$12$xPK6TJc2glMuHG.maF7Gge/T2SpA3gFC1pOCT22kOodmjJLWDwKb.', NULL, '3463434756676438', '08797214006', 'user', NULL, '2026-01-27 21:10:30', '2026-01-27 21:10:30', NULL, NULL),
(46, 'Dedi Kurniawan 28', 'dedi-kurniawan28@example.com', '2026-01-27 21:10:30', '$2y$12$eEACoYFIdSUfqjgcGdOZfeu.n3lMvbD0A3xN0Z4xTyIafyLY7nUxG', NULL, '3447610169018883', '08522371068', 'user', NULL, '2026-01-27 21:10:30', '2026-01-27 21:10:30', NULL, NULL),
(47, 'Rizky Pratama 29', 'rizky-pratama29@example.com', '2026-01-27 21:10:30', '$2y$12$ZwYZ8PtF9nXtXVy6Ipt9Ru7dXoZVPqxKhat.fLlAkKZMhqxIosOw2', NULL, '3436242455204685', '08800838872', 'user', NULL, '2026-01-27 21:10:30', '2026-01-27 21:10:30', NULL, NULL),
(48, 'Taufik Hidayat 30', 'taufik-hidayat30@example.com', '2026-01-27 21:10:31', '$2y$12$/71ap7Zp262UDhTch3YCbO21cRWcVqXAbdTdUHjam7gE.uz2c00Xq', NULL, '3491985278195614', '08708246675', 'user', NULL, '2026-01-27 21:10:31', '2026-01-27 21:10:31', NULL, NULL),
(49, 'Taufik Hidayat 31', 'taufik-hidayat31@example.com', '2026-01-27 21:10:31', '$2y$12$6z.z5QySVtFmGKd.uWRLCuINJaAmTZczOWW.WLUn2NAR7Up8NGCsy', NULL, '3461481154443607', '08836592511', 'user', NULL, '2026-01-27 21:10:31', '2026-01-27 21:10:31', NULL, NULL),
(50, 'Larasati Putri 32', 'larasati-putri32@example.com', '2026-01-27 21:10:31', '$2y$12$pZeh32Runfn66Jsa99QE2OhVpI5fsFpQbsQRCEY8NOrQcyeLMEGDC', NULL, '3438805595800587', '08307927269', 'user', NULL, '2026-01-27 21:10:31', '2026-01-27 21:10:31', NULL, NULL),
(51, 'Rahmat Hidayat 33', 'rahmat-hidayat33@example.com', '2026-01-27 21:10:32', '$2y$12$XsN2scTvG.aCafKS8f14auT5bkzz3zM0EliQlZUmldMfajT/pO.qy', NULL, '3418005750787260', '08144554789', 'user', NULL, '2026-01-27 21:10:32', '2026-01-27 21:10:32', NULL, NULL),
(52, 'Larasati Putri 34', 'larasati-putri34@example.com', '2026-01-27 21:10:32', '$2y$12$kdCpYRgLdMf/u6vdbwyzv.CQ73vhi.QKT7t59lJO1t/d3pkLoOSv6', NULL, '3452138800659997', '08578272719', 'user', NULL, '2026-01-27 21:10:32', '2026-01-27 21:10:32', NULL, NULL),
(53, 'Yuni Kartika 35', 'yuni-kartika35@example.com', '2026-01-27 21:10:32', '$2y$12$JqVAV0jAfuL1LHjBN0WAL.7n9.tHdt24069F.hbcnjHNUqHUL8gfq', NULL, '3471850050598200', '08981049856', 'user', NULL, '2026-01-27 21:10:32', '2026-01-27 21:10:32', NULL, NULL),
(54, 'Taufik Hidayat 36', 'taufik-hidayat36@example.com', '2026-01-27 21:10:33', '$2y$12$8jDbo/1cMfbaa.8PewFhPuPHid0l17DJ7ZqiGWeVtArhJcqADTERS', NULL, '3449512909109322', '08766732306', 'user', NULL, '2026-01-27 21:10:33', '2026-01-27 21:10:33', NULL, NULL),
(55, 'Larasati Putri 37', 'larasati-putri37@example.com', '2026-01-27 21:10:33', '$2y$12$q4BFqPlsACnR.rt1OEWzGOPyJxLd/E688VF/b147uNSCMrMq1uRO6', NULL, '3439396913160338', '08455567591', 'user', NULL, '2026-01-27 21:10:33', '2026-01-27 21:10:33', NULL, NULL),
(56, 'Dian Saputri 38', 'dian-saputri38@example.com', '2026-01-27 21:10:33', '$2y$12$RK1oc8um3wpsiO3dUUyfRuDFhvJiFhfRwYSbMbwtY/w9/CxtET37W', NULL, '3487510437711525', '08600455705', 'user', NULL, '2026-01-27 21:10:33', '2026-01-27 21:10:33', NULL, NULL),
(57, 'Dedi Kurniawan 39', 'dedi-kurniawan39@example.com', '2026-01-27 21:10:34', '$2y$12$dd3wHXJxZ6FiE3S7FzL63uTMV8AIp3p6CDNE5rIX11obwZNERY9dC', NULL, '3435172303173566', '08520374713', 'user', NULL, '2026-01-27 21:10:34', '2026-01-27 21:10:34', NULL, NULL),
(58, 'Arif Rahman 40', 'arif-rahman40@example.com', '2026-01-27 21:10:34', '$2y$12$g2026qoRpX0ocDQDSEFvgeuGJ1Sa8v9EkXuqzUbObp8y6ijbH1fbq', NULL, '3431550204273721', '08817455028', 'user', NULL, '2026-01-27 21:10:34', '2026-01-27 21:10:34', NULL, NULL),
(59, 'Rahmat Hidayat 41', 'rahmat-hidayat41@example.com', '2026-01-27 21:10:34', '$2y$12$Gy4ttg0xXAO6GDkHhOBBB.h2.7Sa3Ld2e/TcOeqvFLzIxAaGs4mWa', NULL, '3456585820662295', '08379727713', 'user', NULL, '2026-01-27 21:10:34', '2026-01-27 21:10:34', NULL, NULL),
(60, 'Arif Rahman 42', 'arif-rahman42@example.com', '2026-01-27 21:10:35', '$2y$12$GvSvXs7dSKdjluhMAP.9reCgINKCW5z.c6SKbHAYKbbDf7SBMnF56', NULL, '3411544979064544', '08903849075', 'user', NULL, '2026-01-27 21:10:35', '2026-01-27 21:10:35', NULL, NULL),
(61, 'Rahmat Hidayat 43', 'rahmat-hidayat43@example.com', '2026-01-27 21:10:35', '$2y$12$YUysJJhdQFZ8kyLgIKo7ye5uT3tJ/dbo.B6Iu18VqjxzyPGt28IcS', NULL, '3473589778251997', '08564801956', 'user', NULL, '2026-01-27 21:10:35', '2026-01-27 21:10:35', NULL, NULL),
(62, 'Dedi Kurniawan 44', 'dedi-kurniawan44@example.com', '2026-01-27 21:10:35', '$2y$12$UOjQvqcaZ0Oi49Z0Uh1Rx.WxdUwPYdjBAJ1SBmsowowHZyWRPRpOi', NULL, '3444565254913412', '08161232256', 'user', NULL, '2026-01-27 21:10:35', '2026-01-27 21:10:35', NULL, NULL),
(63, 'Mega Utami 45', 'mega-utami45@example.com', '2026-01-27 21:10:36', '$2y$12$plShzQc4j0KjR1mWuKBbU.8WS4mKfZRwM4G/ICX4B5NPlQNQGDTee', NULL, '3482917055308413', '08186061705', 'user', NULL, '2026-01-27 21:10:36', '2026-01-27 21:10:36', NULL, NULL),
(64, 'Dian Saputri 46', 'dian-saputri46@example.com', '2026-01-27 21:10:36', '$2y$12$e5pfAkfnwRvx6lbsZ2zCmOxH/5FEOhIOnkjS4o9ZglMCKbSaOumjy', NULL, '3420628252846554', '08958477655', 'user', NULL, '2026-01-27 21:10:36', '2026-01-27 21:10:36', NULL, NULL),
(65, 'Rosa Melinda 47', 'rosa-melinda47@example.com', '2026-01-27 21:10:36', '$2y$12$lNm7lCMXW7tuutncxv4aDOMLaF1D3JwE1u.LOjv2uph/H0xA6rKWa', NULL, '3452564684566525', '08570476573', 'user', NULL, '2026-01-27 21:10:36', '2026-01-27 21:10:36', NULL, NULL),
(66, 'Dian Saputri 48', 'dian-saputri48@example.com', '2026-01-27 21:10:36', '$2y$12$DUcDkkIFcIQM2VsJ47LreenouSVo3f.1oW7njyiHsojj9Dv5TkAMK', NULL, '3454933241189279', '08511979724', 'user', NULL, '2026-01-27 21:10:36', '2026-01-27 21:10:36', NULL, NULL),
(67, 'Doni Setiawan 49', 'doni-setiawan49@example.com', '2026-01-27 21:10:37', '$2y$12$cES.UCjBL.INdBbRRVebFusTkVteliS04FHVOm8nfzvYLOBQ87Ioe', NULL, '3425252886784066', '08818821890', 'user', NULL, '2026-01-27 21:10:37', '2026-01-27 21:10:37', NULL, NULL),
(68, 'Adi Nugroho 50', 'adi-nugroho50@example.com', '2026-01-27 21:10:37', '$2y$12$igkiLmhVVOWcIywy7/cRzu3MdrnXrGt8x1Vq6rZq6jQo.LgCC1Kui', NULL, '3419786713524676', '08518169223', 'user', NULL, '2026-01-27 21:10:37', '2026-01-27 21:10:37', NULL, NULL),
(69, 'Hendra Kusuma 51', 'hendra-kusuma51@example.com', '2026-01-27 21:10:38', '$2y$12$GPyLTtUZCKaaHqJWpMdKSufOxuy7dSY8rN.qL.UyrL1EY6UyFnBbS', NULL, '3425469022923310', '08781574555', 'user', NULL, '2026-01-27 21:10:38', '2026-01-27 21:10:38', NULL, NULL),
(70, 'Fajar Ramadhan 52', 'fajar-ramadhan52@example.com', '2026-01-27 21:10:38', '$2y$12$86eJtcIwEE2s8z1xCYoY.eJQFkM486FGO8u8n5OgvOGdfAN9UFhi2', NULL, '3475323592465882', '08394555618', 'user', NULL, '2026-01-27 21:10:38', '2026-01-27 21:10:38', NULL, NULL),
(71, 'Vina Panduwinata 53', 'vina-panduwinata53@example.com', '2026-01-27 21:10:38', '$2y$12$2RkR0Asdx2dXHSLoY7IC4ORStyEJjAuyiTGitKA82lNdHYTfXvwh6', NULL, '3449523545073263', '08943319194', 'user', NULL, '2026-01-27 21:10:38', '2026-01-27 21:10:38', NULL, NULL),
(72, 'Indah Permata 54', 'indah-permata54@example.com', '2026-01-27 21:10:38', '$2y$12$biH0VgeFSX/tU01dEENTju/o4X94qRjO1I2qsOdw2GtvosuJZbMCW', NULL, '3479679760152688', '08366816733', 'user', NULL, '2026-01-27 21:10:38', '2026-01-27 21:10:38', NULL, NULL),
(73, 'Eko Saputra 55', 'eko-saputra55@example.com', '2026-01-27 21:10:39', '$2y$12$JSoaNZr26k39.JfHDx4KXOIq/sknyg4L0MWi9kg4IXr5lbCIx6A1m', NULL, '3483722741632324', '08739521930', 'user', NULL, '2026-01-27 21:10:39', '2026-01-27 21:10:39', NULL, NULL),
(74, 'Siska Amelia 56', 'siska-amelia56@example.com', '2026-01-27 21:10:39', '$2y$12$xkZYEXeaFCClyLdOKVKg5.OvOqxdNOaLX.OU2zD.j.lkYxLfAe5xK', NULL, '3416135518027390', '08506254927', 'user', NULL, '2026-01-27 21:10:39', '2026-01-27 21:10:39', NULL, NULL),
(75, 'Larasati Putri 57', 'larasati-putri57@example.com', '2026-01-27 21:10:39', '$2y$12$p.KXflEHJ7ii3zrRoiCsEe5bEl35Fww5vW6rqncxA0hNJnHeJs7zi', NULL, '3418714250203437', '08375568598', 'user', NULL, '2026-01-27 21:10:39', '2026-01-27 21:10:39', NULL, NULL),
(76, 'Arif Rahman 58', 'arif-rahman58@example.com', '2026-01-27 21:10:39', '$2y$12$NzCOErb1ykjjYyBrTjStbOHE/czhZRdOxC1JzpRqg8mCIdGRAtIMO', NULL, '3478500213606361', '08727323192', 'user', NULL, '2026-01-27 21:10:39', '2026-01-27 21:10:39', NULL, NULL),
(77, 'Rosa Melinda 59', 'rosa-melinda59@example.com', '2026-01-27 21:10:40', '$2y$12$o5Ru0fBqPdJdtv6yoaJFeup0LHZX6c4tIkeiqvpLna3el2plAbLNO', NULL, '3427465222050271', '08598626816', 'user', NULL, '2026-01-27 21:10:40', '2026-01-27 21:10:40', NULL, NULL),
(78, 'Doni Setiawan 60', 'doni-setiawan60@example.com', '2026-01-27 21:10:40', '$2y$12$xirrelWFFY4SMwHs3rVofuqSNEYoAvFITA030Y5ZnVv4/Ghawk16q', NULL, '3460184285494967', '08416224071', 'user', NULL, '2026-01-27 21:10:40', '2026-01-27 21:10:40', NULL, NULL),
(79, 'Rizky Pratama 61', 'rizky-pratama61@example.com', '2026-01-27 21:10:40', '$2y$12$NCmGqte4D/8tIPXsr26vdOhIDhqKyBczgrUuLRPMWWqxxtI87efW6', NULL, '3456206340397551', '08326053960', 'user', NULL, '2026-01-27 21:10:40', '2026-01-27 21:10:40', NULL, NULL),
(80, 'Indah Permata 62', 'indah-permata62@example.com', '2026-01-27 21:10:41', '$2y$12$i4P7EKOHi91uEPXxvjUzf.9LFxnTZHFTRWE3a4qNo17IVB22yW6Cm', NULL, '3473468362755243', '08995997652', 'user', NULL, '2026-01-27 21:10:41', '2026-01-27 21:10:41', NULL, NULL),
(81, 'Andi Wijaya 63', 'andi-wijaya63@example.com', '2026-01-27 21:10:41', '$2y$12$qCzR/pf2ZYGDfXnSfMqSBeam4ekCmIsQeo2HIiOi4kF8JLUV22tbm', NULL, '3452794093622301', '08631873335', 'user', NULL, '2026-01-27 21:10:41', '2026-01-27 21:10:41', NULL, NULL),
(82, 'Dewi Lestari 64', 'dewi-lestari64@example.com', '2026-01-27 21:10:41', '$2y$12$H4a4PMZggvVfYVdwAD/8m.dX1XpomP.YJ0DizHNHu8IOkvvKMJdO2', NULL, '3449627377432656', '08243999060', 'user', NULL, '2026-01-27 21:10:41', '2026-01-27 21:10:41', NULL, NULL),
(83, 'Taufik Hidayat 65', 'taufik-hidayat65@example.com', '2026-01-27 21:10:42', '$2y$12$y7m0RSSEpFiVc5kQ0PzOW.NpRwqMfRIelGrDdylxswE0NIr2uJ2.K', NULL, '3426735103821411', '08749345895', 'user', NULL, '2026-01-27 21:10:42', '2026-01-27 21:10:42', NULL, NULL),
(84, 'Linda Kusuma 66', 'linda-kusuma66@example.com', '2026-01-27 21:10:42', '$2y$12$1wVacOgtJkdv00BRC7OTyeJIgYdsJv1C67xGjUdJi.Dy27pE0BbE6', NULL, '3468397562927718', '08850730751', 'user', NULL, '2026-01-27 21:10:42', '2026-01-27 21:10:42', NULL, NULL),
(85, 'Mega Utami 67', 'mega-utami67@example.com', '2026-01-27 21:10:42', '$2y$12$D2AW1vJfHfuTlGqM7wxJ0euPOvWOq4TR927gKZQ0iVjbdkdFKw7AS', NULL, '3467513502930578', '08479923607', 'user', NULL, '2026-01-27 21:10:42', '2026-01-27 21:10:42', NULL, NULL),
(86, 'Agus Prayitno 68', 'agus-prayitno68@example.com', '2026-01-27 21:10:43', '$2y$12$Z0fMIBqbSJxJF/EgEyW.QeqCheHKvlAFWhbVbVTo2xK/ZScTi0sJS', NULL, '3424728865278483', '08767619417', 'user', NULL, '2026-01-27 21:10:43', '2026-01-27 21:10:43', NULL, NULL),
(87, 'Linda Kusuma 69', 'linda-kusuma69@example.com', '2026-01-27 21:10:43', '$2y$12$OJrR9ee66zxm4JzFI9AQ2eRr7PsZFc4WXjEZj2ajBrJXhja3WUMPO', NULL, '3430855548319711', '08667390572', 'user', NULL, '2026-01-27 21:10:43', '2026-01-27 21:10:43', NULL, NULL),
(88, 'Nia Ramadhani 70', 'nia-ramadhani70@example.com', '2026-01-27 21:10:43', '$2y$12$tqc9py7K184dpRFGp0K3c.mmZSC/29Xe/TNoRUSR1HA1irRb8VmFe', NULL, '3427255891668095', '08766399523', 'user', NULL, '2026-01-27 21:10:43', '2026-01-27 21:10:43', NULL, NULL),
(89, 'Adi Nugroho 71', 'adi-nugroho71@example.com', '2026-01-27 21:10:44', '$2y$12$3F5NOsjShIPw5Oo6q.1FF.j6gaZoSC73Oh4fSq8ahHxzBvvrkFQ/q', NULL, '3460533159372909', '08215746435', 'user', NULL, '2026-01-27 21:10:44', '2026-01-27 21:10:44', NULL, NULL),
(90, 'Yuni Kartika 72', 'yuni-kartika72@example.com', '2026-01-27 21:10:44', '$2y$12$Qok8kcrec3emc0UpKclwyudIOsvSEKFFX/bSkwuomE4jyf4mBug7O', NULL, '3472955578797521', '08115814664', 'user', NULL, '2026-01-27 21:10:44', '2026-01-27 21:10:44', NULL, NULL),
(91, 'Maya Sari 73', 'maya-sari73@example.com', '2026-01-27 21:10:44', '$2y$12$iEt7fnHANB997EIbxTanDu3ZMD1aAclfVlEyeJ0YH4VQw/nLWqshO', NULL, '3484361415626968', '08211021906', 'user', NULL, '2026-01-27 21:10:44', '2026-01-27 21:10:44', NULL, NULL),
(92, 'Linda Kusuma 74', 'linda-kusuma74@example.com', '2026-01-27 21:10:44', '$2y$12$Wi8OC88Q5cyRV5UOckMFZ.dJQYG1eFgGgaualq5srwP7JOsdm/jMO', NULL, '3479937975439066', '08936974464', 'user', NULL, '2026-01-27 21:10:44', '2026-01-27 21:10:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` bigint UNSIGNED NOT NULL,
  `viewable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `viewable_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visitor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `collection` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `viewable_type`, `viewable_id`, `visitor`, `ip_address`, `user_agent`, `collection`, `viewed_at`) VALUES
(1, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-27 20:39:51'),
(2, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 20:39:58'),
(3, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-27 20:43:08'),
(4, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 20:43:11'),
(5, 'page', 'e0feb2af7286350', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-kategori', '2026-01-27 20:43:16'),
(6, 'page', 'e0feb2af7286350', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-kategori', '2026-01-27 20:44:44'),
(7, 'page', '4236a440a662cc8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'logout', '2026-01-27 20:44:47'),
(8, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 20:44:48'),
(9, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 20:46:18'),
(10, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 20:47:36'),
(11, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-27 20:47:58'),
(12, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-27 20:50:07'),
(13, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 20:50:11'),
(14, 'page', 'e0feb2af7286350', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-kategori', '2026-01-27 20:50:15'),
(15, 'page', '8be199487e5634a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-kategori/12', '2026-01-27 20:50:45'),
(16, 'page', 'e0feb2af7286350', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-kategori', '2026-01-27 20:51:23'),
(17, 'page', '75ba134f503b903', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin', '2026-01-27 20:52:03'),
(18, 'page', '00297afa7842bf7', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/8', '2026-01-27 20:52:10'),
(19, 'page', '3e9d40e1fcdc725', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/9', '2026-01-27 20:52:17'),
(20, 'page', '5af79c82fb9c6e1', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/10', '2026-01-27 20:52:25'),
(21, 'page', '4059574dc65f9c9', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/11', '2026-01-27 20:52:33'),
(22, 'page', 'b9ca4b81c727685', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/12', '2026-01-27 20:52:40'),
(23, 'page', 'ab88457bf251e23', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/13', '2026-01-27 20:52:54'),
(24, 'page', '75ba134f503b903', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin', '2026-01-27 20:53:05'),
(25, 'page', '21eec41820e901a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/14', '2026-01-27 20:53:11'),
(26, 'page', 'fe818d63ae6d77b', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/15', '2026-01-27 20:53:20'),
(27, 'page', '50aa2a9c2e84526', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/16', '2026-01-27 20:53:31'),
(28, 'page', '6e4b85cf47f0ed4', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/17', '2026-01-27 20:53:42'),
(29, 'page', 'cd86fa0ed6dccc6', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kategori-admin/18', '2026-01-27 20:53:52'),
(30, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 20:53:54'),
(31, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 20:54:17'),
(32, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 20:56:40'),
(33, 'page', 'f37bd2f66651e7d', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'notifications', '2026-01-27 20:58:01'),
(34, 'page', 'dc2c34fb3b41715', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/activity-logs', '2026-01-27 20:58:05'),
(35, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 20:59:10'),
(36, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:00:05'),
(37, 'page', 'fd557b1d648a4f5', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/daftar-aduan/607/detail', '2026-01-27 21:00:21'),
(38, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 21:00:43'),
(39, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:01:08'),
(40, 'page', '89801d788929f64', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-user', '2026-01-27 21:01:13'),
(41, 'page', '449b75a0f70fb40', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/laporan-aduan', '2026-01-27 21:01:15'),
(42, 'page', '4236a440a662cc8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'logout', '2026-01-27 21:01:19'),
(43, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 21:01:20'),
(44, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-27 21:01:34'),
(45, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-27 21:04:31'),
(46, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 21:04:46'),
(47, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-27 21:05:25'),
(48, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 21:05:32'),
(49, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:05:37'),
(50, 'page', 'd021838162f16ed', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/daftar-aduan/543/detail', '2026-01-27 21:06:01'),
(51, 'page', 'f7b00625ed68cce', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/543', '2026-01-27 21:06:13'),
(52, 'page', 'bdf7d9d84d25725', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/631', '2026-01-27 21:06:28'),
(53, 'page', '431698611c358a4', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/628', '2026-01-27 21:06:43'),
(54, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:06:44'),
(55, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 21:06:46'),
(56, 'page', 'dc2c34fb3b41715', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/activity-logs', '2026-01-27 21:06:49'),
(57, 'page', 'f2db27e193ebd16', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/627', '2026-01-27 21:07:11'),
(58, 'page', '9caeedf5cfbc2d0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/623', '2026-01-27 21:07:25'),
(59, 'page', 'ea2a777f0840bb0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/619', '2026-01-27 21:07:38'),
(60, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:08:17'),
(61, 'page', '0036b05989fc350', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/daftar-aduan/619/detail', '2026-01-27 21:08:31'),
(62, 'page', 'adfc848731ae3f1', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/daftar-aduan/619', '2026-01-27 21:08:41'),
(63, 'page', 'dc2c34fb3b41715', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/activity-logs', '2026-01-27 21:08:57'),
(64, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 21:09:02'),
(65, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 21:10:23'),
(66, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:11:26'),
(67, 'page', 'a14c71f5beeabea', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/629', '2026-01-27 21:11:54'),
(68, 'page', '9ab663dbaecb383', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/453', '2026-01-27 21:12:10'),
(69, 'page', '449b75a0f70fb40', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/laporan-aduan', '2026-01-27 21:12:25'),
(70, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 21:12:28'),
(71, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:13:11'),
(72, 'page', 'f0eff565ad86bfc', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/daftar-aduan/623/detail', '2026-01-27 21:13:13'),
(73, 'page', '232c26fbbc4e362', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/618', '2026-01-27 21:13:25'),
(74, 'page', '0a2845a8392ad06', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/499', '2026-01-27 21:13:41'),
(75, 'page', '409f58617a5c5d4', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/daftar-aduan/499/detail', '2026-01-27 21:13:51'),
(76, 'page', '087be1ec2769bda', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/475', '2026-01-27 21:14:10'),
(77, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:14:13'),
(78, 'page', '884b9866c2d3f5a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/510', '2026-01-27 21:14:32'),
(79, 'page', '386965f33d68f6e', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/577', '2026-01-27 21:14:48'),
(80, 'page', 'db802d7e1b213a5', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/517', '2026-01-27 21:15:06'),
(81, 'page', 'f71be1420de81c2', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/580', '2026-01-27 21:15:18'),
(82, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:15:19'),
(83, 'page', 'f7b00625ed68cce', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/543', '2026-01-27 21:15:37'),
(84, 'page', 'b5b767bf7bd7827', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/607', '2026-01-27 21:15:48'),
(85, 'page', '2406812797affaa', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/563', '2026-01-27 21:16:00'),
(86, 'page', '7264fecf840131b', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan/555', '2026-01-27 21:16:13'),
(87, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-27 21:16:22'),
(88, 'page', '449b75a0f70fb40', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/laporan-aduan', '2026-01-27 21:16:48'),
(89, 'page', '4236a440a662cc8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'logout', '2026-01-27 21:16:52'),
(90, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 21:16:53'),
(91, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-27 21:16:56'),
(92, 'page', 'ffb3ae258341949', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'auth/google', '2026-01-27 21:16:59'),
(93, 'page', '93b221b333045fc', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'auth/google/callback', '2026-01-27 21:17:00'),
(94, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-27 21:17:02'),
(95, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-27 21:17:05'),
(96, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-27 21:19:38'),
(97, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 21:19:51'),
(98, 'page', 'fdc459004d7ab11', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'daftar-aduan', '2026-01-27 21:20:07'),
(99, 'page', '9284b8108363196', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/profile', '2026-01-27 21:20:38'),
(100, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 21:43:34'),
(101, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 21:50:57'),
(102, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 21:57:21'),
(103, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-27 21:57:25'),
(104, 'page', '4236a440a662cc8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'logout', '2026-01-27 22:13:00'),
(105, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-27 22:13:01'),
(106, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-27 22:13:05'),
(107, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-27 22:13:09'),
(108, 'page', 'dc2c34fb3b41715', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/activity-logs', '2026-01-27 22:13:12'),
(109, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 01:20:30'),
(110, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-28 01:20:46'),
(111, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-28 01:34:35'),
(112, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 01:34:41'),
(113, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-28 01:34:46'),
(114, 'page', 'ffb3ae258341949', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'auth/google', '2026-01-28 01:34:48'),
(115, 'page', '93b221b333045fc', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'auth/google/callback', '2026-01-28 01:34:50'),
(116, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 01:34:52'),
(117, 'page', '9284b8108363196', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/profile', '2026-01-28 01:40:49'),
(118, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 01:43:07'),
(119, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 01:49:22'),
(120, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 01:51:44'),
(121, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 01:52:55'),
(122, 'page', '9284b8108363196', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/profile', '2026-01-28 01:53:02'),
(123, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 01:53:21'),
(124, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 01:55:07'),
(125, 'page', '9284b8108363196', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/profile', '2026-01-28 01:55:16'),
(126, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 01:55:19'),
(127, 'page', '4236a440a662cc8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'logout', '2026-01-28 01:55:27'),
(128, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-28 01:55:31'),
(129, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-28 01:55:35'),
(130, 'page', '1cc8f961afc4bf0', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/kelola-aduan', '2026-01-28 01:56:33'),
(131, 'page', '024ac55e3a35f17', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'superadmin/dashboard', '2026-01-28 01:56:37'),
(132, 'page', '4236a440a662cc8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'logout', '2026-01-28 01:57:10'),
(133, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 01:57:11'),
(134, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-28 01:57:15'),
(135, 'page', 'ffb3ae258341949', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'auth/google', '2026-01-28 01:57:17'),
(136, 'page', '93b221b333045fc', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'auth/google/callback', '2026-01-28 01:57:18'),
(137, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 01:57:20'),
(138, 'page', '9284b8108363196', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/profile', '2026-01-28 01:57:30'),
(139, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 01:58:51'),
(140, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 02:00:24'),
(141, 'page', '0fb26c0fa11c0ad', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'daftar-aduan/615/detail', '2026-01-28 02:00:32'),
(142, 'page', '9284b8108363196', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/profile', '2026-01-28 02:01:16'),
(143, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 02:01:18'),
(144, 'page', '473126c1d9a6a9c', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'daftar-aduan/617/detail', '2026-01-28 02:01:33'),
(145, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 02:03:55'),
(146, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 02:22:30'),
(147, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 02:23:33'),
(148, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 02:25:53'),
(149, 'page', 'd73d2b5aaaac6d8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'statistik', '2026-01-28 02:25:58'),
(150, 'page', '9284b8108363196', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/profile', '2026-01-28 02:26:03'),
(151, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 02:26:16'),
(152, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 02:27:11'),
(153, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 04:15:24'),
(154, 'page', 'c7494c144c06114', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'api/chatbot', '2026-01-28 04:15:31'),
(155, 'page', '9284b8108363196', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/profile', '2026-01-28 04:15:53'),
(156, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 04:15:56'),
(157, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 05:53:13'),
(158, 'page', '4236a440a662cc8', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'logout', '2026-01-28 05:53:23'),
(159, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 05:55:28'),
(160, 'page', '0fb26c0fa11c0ad', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'daftar-aduan/615/detail', '2026-01-28 05:55:33'),
(161, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 07:39:21'),
(162, 'page', 'd56b699830e77ba', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'login', '2026-01-28 07:39:26'),
(163, 'page', 'ffb3ae258341949', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'auth/google', '2026-01-28 07:39:35'),
(164, 'page', '93b221b333045fc', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'auth/google/callback', '2026-01-28 07:39:40'),
(165, 'page', '8b91be7f4a05b9a', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'user/riwayat-aduan', '2026-01-28 07:40:16'),
(166, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 07:40:22'),
(167, 'page', 'c7494c144c06114', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'api/chatbot', '2026-01-28 07:42:12'),
(168, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 09:20:26'),
(169, 'page', '6666cd76f969564', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '/', '2026-01-28 10:57:59'),
(170, 'page', '9d9d8aaa790905c', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case', '2026-01-28 11:01:18'),
(171, 'page', '241f4b49076036c', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/user', '2026-01-28 11:01:21'),
(172, 'page', 'cae553be29ddd59', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/wbs-admin', '2026-01-28 11:01:40'),
(173, 'page', '9d9d8aaa790905c', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case', '2026-01-28 11:02:50'),
(174, 'page', '241f4b49076036c', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/user', '2026-01-28 11:02:52'),
(175, 'page', '5c36b0765529d76', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/admin', '2026-01-28 11:03:31'),
(176, 'page', 'fd365c182e25476', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/superadmin', '2026-01-28 11:03:38'),
(177, 'page', 'cae553be29ddd59', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/wbs-admin', '2026-01-28 11:03:45'),
(178, 'page', '241f4b49076036c', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/user', '2026-01-28 11:05:36'),
(179, 'page', '241f4b49076036c', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/user', '2026-01-28 11:06:52'),
(180, 'page', '241f4b49076036c', '3d2ce998493d887b601aa14d76ff84f2eec9f451', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'info/use-case/user', '2026-01-28 11:07:58');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `vote_type` enum('like','dislike') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wbs_comments`
--

CREATE TABLE `wbs_comments` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pesan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wbs_follow_ups`
--

CREATE TABLE `wbs_follow_ups` (
  `id` bigint UNSIGNED NOT NULL,
  `report_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wbs_reports`
--

CREATE TABLE `wbs_reports` (
  `id` bigint UNSIGNED NOT NULL,
  `tracking_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `is_anonim` tinyint(1) NOT NULL DEFAULT '0',
  `nama_pengadu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_pengadu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon_pengadu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_terlapor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wilayah_id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `waktu_kejadian` timestamp NOT NULL,
  `lokasi_kejadian` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lampiran` json DEFAULT NULL,
  `status` enum('Diajukan','Dibaca','Direspon','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diajukan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah_umum`
--

CREATE TABLE `wilayah_umum` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wilayah_umum`
--

INSERT INTO `wilayah_umum` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Kota Yogyakarta', '2026-01-27 20:39:42', '2026-01-27 20:39:42'),
(2, 'Kabupaten Sleman', '2026-01-27 20:39:42', '2026-01-27 20:39:42'),
(3, 'Kabupaten Bantul', '2026-01-27 20:39:42', '2026-01-27 20:39:42'),
(4, 'Kabupaten Kulon Progo', '2026-01-27 20:39:42', '2026-01-27 20:39:42'),
(5, 'Kabupaten Gunungkidul', '2026-01-27 20:39:42', '2026-01-27 20:39:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

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
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_report_id_foreign` (`report_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `followup_ratings`
--
ALTER TABLE `followup_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `followup_ratings_followup_id_user_id_unique` (`followup_id`,`user_id`),
  ADD KEY `followup_ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `follow_ups`
--
ALTER TABLE `follow_ups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follow_ups_report_id_foreign` (`report_id`),
  ADD KEY `follow_ups_user_id_foreign` (`user_id`);

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
-- Indexes for table `kategori_umum`
--
ALTER TABLE `kategori_umum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_umum_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reports_tracking_id_unique` (`tracking_id`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_admin_id_foreign` (`admin_id`),
  ADD KEY `reports_kategori_id_foreign` (`kategori_id`),
  ADD KEY `reports_wilayah_id_foreign` (`wilayah_id`),
  ADD KEY `reports_updated_by_foreign` (`updated_by`);

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
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nik_unique` (`nik`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD KEY `users_nomor_telepon_index` (`nomor_telepon`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `views_viewable_id_visitor_index` (`viewable_id`,`visitor`),
  ADD KEY `views_viewed_at_index` (`viewed_at`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `votes_user_id_report_id_unique` (`user_id`,`report_id`),
  ADD KEY `votes_report_id_foreign` (`report_id`);

--
-- Indexes for table `wbs_comments`
--
ALTER TABLE `wbs_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wbs_comments_report_id_foreign` (`report_id`),
  ADD KEY `wbs_comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `wbs_follow_ups`
--
ALTER TABLE `wbs_follow_ups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wbs_follow_ups_report_id_foreign` (`report_id`),
  ADD KEY `wbs_follow_ups_user_id_foreign` (`user_id`);

--
-- Indexes for table `wbs_reports`
--
ALTER TABLE `wbs_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wbs_reports_tracking_id_unique` (`tracking_id`),
  ADD KEY `wbs_reports_user_id_foreign` (`user_id`),
  ADD KEY `wbs_reports_wilayah_id_foreign` (`wilayah_id`),
  ADD KEY `wbs_reports_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `wilayah_umum`
--
ALTER TABLE `wilayah_umum`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followup_ratings`
--
ALTER TABLE `followup_ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follow_ups`
--
ALTER TABLE `follow_ups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_umum`
--
ALTER TABLE `kategori_umum`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=635;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wbs_comments`
--
ALTER TABLE `wbs_comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wbs_follow_ups`
--
ALTER TABLE `wbs_follow_ups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wbs_reports`
--
ALTER TABLE `wbs_reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wilayah_umum`
--
ALTER TABLE `wilayah_umum`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `followup_ratings`
--
ALTER TABLE `followup_ratings`
  ADD CONSTRAINT `followup_ratings_followup_id_foreign` FOREIGN KEY (`followup_id`) REFERENCES `follow_ups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followup_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `follow_ups`
--
ALTER TABLE `follow_ups`
  ADD CONSTRAINT `follow_ups_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follow_ups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `kategori_umum`
--
ALTER TABLE `kategori_umum`
  ADD CONSTRAINT `kategori_umum_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_umum` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `reports_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah_umum` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `wbs_comments`
--
ALTER TABLE `wbs_comments`
  ADD CONSTRAINT `wbs_comments_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `wbs_reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wbs_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `wbs_follow_ups`
--
ALTER TABLE `wbs_follow_ups`
  ADD CONSTRAINT `wbs_follow_ups_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `wbs_reports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wbs_follow_ups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `wbs_reports`
--
ALTER TABLE `wbs_reports`
  ADD CONSTRAINT `wbs_reports_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_umum` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wbs_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL,
  ADD CONSTRAINT `wbs_reports_wilayah_id_foreign` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah_umum` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
