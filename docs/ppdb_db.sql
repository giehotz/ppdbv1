-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 16, 2026 at 12:22 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppdb_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alur_pendaftaran`
--

CREATE TABLE `alur_pendaftaran` (
  `id` int UNSIGNED NOT NULL,
  `judul` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'fas fa-check',
  `urutan` int NOT NULL DEFAULT '1',
  `status` enum('aktif','tidak_aktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alur_pendaftaran`
--

INSERT INTO `alur_pendaftaran` (`id`, `judul`, `deskripsi`, `icon`, `urutan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Buat Akun', 'buat akun untuk mendaftar', 'fas fa-user-circle', 1, 'aktif', '2026-02-14 13:36:35', '2026-02-14 13:43:39'),
(2, 'isi data diri', 'isi data diri sesuai dengan kartu keluarga', 'fas fa-trophy', 2, 'aktif', '2026-02-14 13:58:07', '2026-02-14 13:58:07');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int UNSIGNED NOT NULL,
  `pertanyaan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jawaban` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jalur_pendaftaran`
--

CREATE TABLE `jalur_pendaftaran` (
  `id` int UNSIGNED NOT NULL,
  `nama_jalur` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'fas fa-graduation-cap',
  `icon_color` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'primary',
  `deskripsi` text COLLATE utf8mb4_general_ci NOT NULL,
  `persyaratan` text COLLATE utf8mb4_general_ci NOT NULL COMMENT 'JSON array of requirements',
  `urutan` int NOT NULL DEFAULT '0',
  `status` enum('aktif','tidak_aktif') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2025-12-28-000001', 'App\\Database\\Migrations\\CreateAlurPendaftaran', 'default', 'App', 1766921517, 1),
(2, '2025-12-28-000002', 'App\\Database\\Migrations\\CreateFaqs', 'default', 'App', 1766921517, 1),
(3, '2025-12-28-000003', 'App\\Database\\Migrations\\CreateJalurPendaftaran', 'default', 'App', 1766921518, 1),
(4, '2025-12-28-000004', 'App\\Database\\Migrations\\CreateTblBerkas', 'default', 'App', 1766921518, 1),
(5, '2025-12-28-000005', 'App\\Database\\Migrations\\CreateTblKomp', 'default', 'App', 1766921518, 1),
(6, '2025-12-28-000006', 'App\\Database\\Migrations\\CreateTblLandingContent', 'default', 'App', 1766921518, 1),
(7, '2025-12-28-000007', 'App\\Database\\Migrations\\CreateTblPdd', 'default', 'App', 1766921518, 1),
(8, '2025-12-28-000008', 'App\\Database\\Migrations\\CreateTblPekerjaan', 'default', 'App', 1766921518, 1),
(9, '2025-12-28-000009', 'App\\Database\\Migrations\\CreateTblPenghasilan', 'default', 'App', 1766921518, 1),
(10, '2025-12-28-000010', 'App\\Database\\Migrations\\CreateTblPengumuman', 'default', 'App', 1766921519, 1),
(11, '2025-12-28-000011', 'App\\Database\\Migrations\\CreateTblSiswa', 'default', 'App', 1766921519, 1),
(12, '2025-12-28-000012', 'App\\Database\\Migrations\\CreateTblUser', 'default', 'App', 1766921519, 1),
(13, '2025-12-28-000013', 'App\\Database\\Migrations\\CreateTblVerifikasi', 'default', 'App', 1766921519, 1),
(14, '2025-12-28-000014', 'App\\Database\\Migrations\\CreateTblWeb', 'default', 'App', 1766921519, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_berkas`
--

CREATE TABLE `tbl_berkas` (
  `id_berkas` int UNSIGNED NOT NULL,
  `id_siswa` int UNSIGNED NOT NULL,
  `jenis_berkas` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `status_verifikasi` enum('pending','valid','invalid') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_berkas`
--

INSERT INTO `tbl_berkas` (`id_berkas`, `id_siswa`, `jenis_berkas`, `nama_file`, `deskripsi`, `keterangan`, `status_verifikasi`, `created_at`, `updated_at`) VALUES
(5, 1, 'Kartu Keluarga', '3190042995/kartu_keluarga_1768650631_1768650631_a223fa1ec23ba89f1d44.jpeg', '', NULL, 'pending', '2026-01-17 11:50:31', '2026-01-17 11:50:31'),
(6, 1, 'Akte Kelahiran', '3190042995/akte_kelahiran_1768650675_1768650675_64f9a8b73702e0064040.jpeg', '', NULL, 'pending', '2026-01-17 11:51:15', '2026-01-17 11:51:15'),
(7, 1, 'Pas Foto', '3190042995/pas_foto_1768652497_1768652497_1840dcf933a049ed2271.png', '', NULL, 'pending', '2026-01-17 12:21:37', '2026-01-17 12:21:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_komp`
--

CREATE TABLE `tbl_komp` (
  `id_komp` int NOT NULL,
  `kompetensi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_komp`
--

INSERT INTO `tbl_komp` (`id_komp`, `kompetensi`) VALUES
(1, 'Rekayasa Perangkat Lunak'),
(2, 'Teknik Komputer dan Jaringan'),
(3, 'Multimedia'),
(4, 'Akuntansi'),
(5, 'Perkantoran');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_landing_content`
--

CREATE TABLE `tbl_landing_content` (
  `id` int UNSIGNED NOT NULL,
  `section` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `content_key` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `content_value` text COLLATE utf8mb4_general_ci,
  `media_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order_index` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_landing_content`
--

INSERT INTO `tbl_landing_content` (`id`, `section`, `content_key`, `content_value`, `media_path`, `order_index`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'hero', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:27'),
(2, 'hero', 'title', 'Selamat Datang di PPDB Online', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:27'),
(3, 'hero', 'subtitle', '<p>Wujudkan generasi cerdas, berakhlakul karimah, dan unggul bersama Madrasah Ibtidaiyah Negeri 2 Tanggamus.</p>', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:27'),
(4, 'hero', 'cta_text', 'Daftar Sekarang', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:27'),
(5, 'hero', 'cta_link', '/auth/register', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:27'),
(6, 'info_cards', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:27'),
(7, 'info_cards', 'card_1_title', 'Siswa Terdaftar', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:27'),
(8, 'info_cards', 'card_1_value', '380+', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:28'),
(9, 'info_cards', 'card_2_title', 'Guru Profesional', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:28'),
(10, 'info_cards', 'card_2_value', '30+', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:29'),
(11, 'keunggulan', 'is_active', '0', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:29'),
(12, 'keunggulan', 'card_1_title', 'fasilitas lengkap', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:29'),
(13, 'keunggulan', 'card_1_icon', 'fas fa-check', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:29'),
(14, 'keunggulan', 'card_1_desc', '', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(15, 'keunggulan', 'card_2_title', 'guru berkompeten sesuai bidangnya', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(16, 'keunggulan', 'card_2_icon', 'fas fa-check', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(17, 'keunggulan', 'card_2_desc', '', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(18, 'keunggulan', 'card_3_title', '', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(19, 'keunggulan', 'card_3_icon', ' fa-user-circle', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(20, 'keunggulan', 'card_3_desc', '', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(21, 'keunggulan', 'card_4_title', '', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(22, 'keunggulan', 'card_4_icon', 'fas fa-check', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(23, 'keunggulan', 'card_4_desc', '', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(24, 'jalur_section', 'is_active', '0', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(25, 'alur_section', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(26, 'countdown', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(27, 'countdown', 'title', 'Pendaftaran Ditutup Dalam:', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(28, 'countdown', 'target_time', '2026-06-28T11:35', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(29, 'cta_besar', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:30'),
(30, 'cta_besar', 'title', 'Siap Mendaftar?', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:31'),
(31, 'cta_besar', 'description', 'Bergabunglah bersama kami dan raih masa depan gemilang.', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:31'),
(32, 'cta_besar', 'btn1_text', 'Buat Akun', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:31'),
(33, 'cta_besar', 'btn1_link', 'auth/register', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:31'),
(34, 'cta_besar', 'btn2_text', 'Pelajari Alur', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:31'),
(35, 'cta_besar', 'btn2_link', 'alur', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:31'),
(36, 'gallery', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:31'),
(37, 'video_profile', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:19', '2026-02-15 12:48:31'),
(38, 'video_profile', 'youtube_url', 'https://www.youtube.com/embed/1xdNisAhsxc', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(39, 'video_profile', 'title', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(40, 'faq_section', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(41, 'contact', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(42, 'contact', 'phone', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(43, 'contact', 'whatsapp', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(44, 'contact', 'email', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(45, 'contact', 'address', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(46, 'seo', 'meta_title', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(47, 'seo', 'meta_description', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(48, 'seo', 'meta_keywords', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:31'),
(49, 'style', 'primary_color', '#71ee44', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(50, 'style', 'font_family', '\'Poppins\', sans-serif', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(51, 'footer', 'is_active', '1', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(52, 'footer', 'description', 'Sistem Penerimaan Peserta Didik Baru MIN 2 Tanggamus ', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(53, 'footer', 'facebook_url', '#', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(54, 'footer', 'instagram_url', '#', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(55, 'footer', 'youtube_url', '#', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(56, 'footer', 'whatsapp_help', '628123456789', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(57, 'footer', 'download_1_text', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(58, 'footer', 'download_1_url', '#', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(59, 'footer', 'download_2_text', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(60, 'footer', 'download_2_url', '#', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(61, 'footer', 'download_3_text', '', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(62, 'footer', 'download_3_url', '#', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(63, 'footer', 'copyright', 'PPDB Online. All rights reserved.', NULL, 0, 1, '2025-12-28 11:35:20', '2026-02-15 12:48:32'),
(64, 'hero', 'background_image', 'uploads/landing/1768653653_1849f107220be804fb0d.jpg', 'uploads/landing/1768653653_1849f107220be804fb0d.jpg', 0, 1, '2026-01-17 12:40:53', '2026-01-17 12:40:53'),
(65, 'video_profile', 'poster', '', 'uploads/landing/1770897326_031ba47a07b89fda5555.png', 0, 1, '2026-02-12 11:55:26', '2026-02-12 11:57:09'),
(66, 'gallery', 'img_1', 'uploads/landing/gallery/1770897691_4fc759edb01e9c467ceb.png', 'uploads/landing/gallery/1770897691_4fc759edb01e9c467ceb.png', 0, 1, '2026-02-12 12:01:31', '2026-02-12 12:01:31'),
(67, 'gallery', 'img_2', 'uploads/landing/gallery/1770897691_3dc137ea128084ce7879.jpeg', 'uploads/landing/gallery/1770897691_3dc137ea128084ce7879.jpeg', 0, 1, '2026-02-12 12:01:31', '2026-02-12 12:01:31'),
(68, 'gallery', 'img_3', 'uploads/landing/gallery/1770897691_c0fe4f20cd6a6acee523.jpeg', 'uploads/landing/gallery/1770897691_c0fe4f20cd6a6acee523.jpeg', 0, 1, '2026-02-12 12:01:31', '2026-02-12 12:01:31'),
(69, 'settings', 'mode', 'default', NULL, 0, 1, '2026-02-14 13:28:28', '2026-02-15 12:48:27'),
(70, 'cta_besar', 'background_image', 'uploads/landing/1771076008_be06f94d22478273bdcb.jpeg', 'uploads/landing/1771076008_be06f94d22478273bdcb.jpeg', 0, 1, '2026-02-14 13:33:28', '2026-02-14 13:33:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pdd`
--

CREATE TABLE `tbl_pdd` (
  `id_pdd` int NOT NULL,
  `pendidikan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pdd`
--

INSERT INTO `tbl_pdd` (`id_pdd`, `pendidikan`, `urutan`) VALUES
(1, 'Tidak Sekolah', 1),
(2, 'SD / Sederajat', 2),
(3, 'SMP / Sederajat', 3),
(4, 'SMA / SMK / Sederajat', 4),
(5, 'D1', 5),
(6, 'D2', 6),
(7, 'D3', 7),
(8, 'D4 / S1', 8),
(9, 'S2', 9),
(10, 'S3', 10),
(11, 'TK/RA/PAUD', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pekerjaan`
--

CREATE TABLE `tbl_pekerjaan` (
  `id_pekerjaan` int NOT NULL,
  `nama_pekerjaan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kategori_peruntukan` enum('ayah','ibu','wali','umum') COLLATE utf8mb4_general_ci DEFAULT 'umum',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pekerjaan`
--

INSERT INTO `tbl_pekerjaan` (`id_pekerjaan`, `nama_pekerjaan`, `kategori_peruntukan`, `created_at`, `updated_at`) VALUES
(1, 'Tidak Bekerja', 'umum', NULL, NULL),
(2, 'PNS / ASN', 'umum', NULL, NULL),
(3, 'TNI / Polri', 'umum', NULL, NULL),
(4, 'Karyawan Swasta', 'umum', NULL, NULL),
(5, 'Wiraswasta', 'umum', NULL, NULL),
(6, 'Petani / Peternak', 'umum', NULL, NULL),
(7, 'Nelayan', 'umum', NULL, NULL),
(8, 'Buruh', 'umum', NULL, NULL),
(9, 'Pedagang', 'umum', NULL, NULL),
(10, 'Ibu Rumah Tangga', 'ibu', NULL, NULL),
(11, 'Pensiunan', 'umum', NULL, NULL),
(12, 'Lainnya', 'umum', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penghasilan`
--

CREATE TABLE `tbl_penghasilan` (
  `id_penghasilan` int NOT NULL,
  `nama_penghasilan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `urutan` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_penghasilan`
--

INSERT INTO `tbl_penghasilan` (`id_penghasilan`, `nama_penghasilan`, `urutan`) VALUES
(4, 'Rp. 2.000.000 - Rp. 5.000.000', 4),
(6, 'Kurang dari Rp. 500.000', 1),
(7, 'Rp. 500.000 - Rp. 1.000.000', 2),
(8, 'Rp. 1.000.000 - Rp. 2.000.000', 3),
(10, 'Lebih dari Rp. 5.000.000', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengumuman`
--

CREATE TABLE `tbl_pengumuman` (
  `id_pengumuman` int UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isi_pengumuman` text COLLATE utf8mb4_general_ci NOT NULL,
  `tipe` enum('general','ujian','kelulusan') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'general',
  `target_audience` enum('all','verified','lulus','rejected') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'all',
  `lampiran` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `publish_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id_siswa` int NOT NULL,
  `no_pendaftaran` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci,
  `nis` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nisn` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik` text COLLATE utf8mb4_general_ci,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jk` varchar(12) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir` text COLLATE utf8mb4_general_ci,
  `tgl_lahir` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `agama` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_keluarga` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anak_ke` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jml_saudara` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hobi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cita` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `paud` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tk` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_siswa` text COLLATE utf8mb4_general_ci,
  `jenis_tinggal` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `desa` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kec` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kab` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prov` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_pos` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jarak` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trans` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_hp_siswa` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_kk` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kepala_keluarga` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_ayah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik_ayah` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir_ayah` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_lahir_ayah` date DEFAULT NULL,
  `status_ayah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `th_lahir_ayah` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pdd_ayah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pekerjaan_ayah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penghasilan_ayah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_ibu` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik_ibu` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir_ibu` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_lahir_ibu` date DEFAULT NULL,
  `status_ibu` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `th_lahir_ibu` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pdd_ibu` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pekerjaan_ibu` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penghasilan_ibu` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_wali` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nik_wali` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `th_lahir_wali` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pdd_wali` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pekerjaan_wali` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penghasilan_wali` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_hp_ortu` varchar(14) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `npsn_sekolah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_sekolah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_sekolah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenjang_sekolah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `lokasi_sekolah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_kks` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_kks` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_pkh` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_pkh` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_kip` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_kip` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `komp_ahli` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jalur_pendaftaran` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_siswa` datetime DEFAULT NULL,
  `status_verifikasi` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_pendaftaran` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_verifikasi` datetime DEFAULT NULL,
  `verified_by` int DEFAULT NULL,
  `catatan_verifikasi` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id_siswa`, `no_pendaftaran`, `password`, `nis`, `nisn`, `nik`, `nama_lengkap`, `email`, `jk`, `tempat_lahir`, `tgl_lahir`, `agama`, `status_keluarga`, `anak_ke`, `jml_saudara`, `hobi`, `cita`, `paud`, `tk`, `alamat_siswa`, `jenis_tinggal`, `desa`, `kec`, `kab`, `prov`, `kode_pos`, `jarak`, `trans`, `no_hp_siswa`, `no_kk`, `kepala_keluarga`, `nama_ayah`, `nik_ayah`, `tempat_lahir_ayah`, `tgl_lahir_ayah`, `status_ayah`, `th_lahir_ayah`, `pdd_ayah`, `pekerjaan_ayah`, `penghasilan_ayah`, `nama_ibu`, `nik_ibu`, `tempat_lahir_ibu`, `tgl_lahir_ibu`, `status_ibu`, `th_lahir_ibu`, `pdd_ibu`, `pekerjaan_ibu`, `penghasilan_ibu`, `nama_wali`, `nik_wali`, `th_lahir_wali`, `pdd_wali`, `pekerjaan_wali`, `penghasilan_wali`, `no_hp_ortu`, `npsn_sekolah`, `nama_sekolah`, `status_sekolah`, `jenjang_sekolah`, `lokasi_sekolah`, `no_kks`, `file_kks`, `no_pkh`, `file_pkh`, `no_kip`, `file_kip`, `komp_ahli`, `jalur_pendaftaran`, `tgl_siswa`, `status_verifikasi`, `status_pendaftaran`, `tgl_verifikasi`, `verified_by`, `catatan_verifikasi`) VALUES
(1, 'PPDB-2026-0001', '$2y$10$4MKt38gPljQ/BFNJ/It8L.nDOb1sG24V1UW1udwX1/Nwsge1xWJjC', NULL, '3190042995', '1806012705700006', 'MUHAMMAD SOFYAN HARIS', '', 'L', 'TANGGAMUS', '2019-02-09', 'Islam', NULL, '1', '2', 'main', 'doker', NULL, NULL, 'DUSUN GUNUNG SARI, RT/RW 003/002, WAY PRING, PUGUNG, TANGGAMUS, LAMPUNG, 35375', 'Bersama Orang Tua', 'PURWODADI', 'GISTING', 'KABUPATEN TANGGAMUS', 'LAMPUNG', '35378', '1', 'Jalan Kaki', '082269226552', '1806201011206666', NULL, 'MU\'MIN', '1806112002190010', 'PANDEGLANG', '1991-06-12', 'Hidup', '1991', 'SD / Sederajat', 'Petani / Peternak', 'Rp. 500.000 - Rp. 1.000.000', 'SUPIAH', '1806116505980002', 'GEDONG TATAAN', '1998-05-25', 'Hidup', '1998', 'SMP / Sederajat', 'Ibu Rumah Tangga', 'Rp. 500.000 - Rp. 1.000.000', 'MU\'MIN', '1806112002190010', '1991', 'SD / Sederajat', 'Petani / Peternak', 'Rp. 500.000 - Rp. 1.000.000', '082269226558', '160606222', 'RA PPI', 'Swasta', 'TK/RA/PAUD', 'Tanggamus', '', '', '', '', '', '', NULL, NULL, '2026-01-17 10:22:15', '1', 'Lulus', '2026-01-30 12:16:40', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_static_page`
--

CREATE TABLE `tbl_static_page` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_general_ci,
  `is_active` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_static_page`
--

INSERT INTO `tbl_static_page` (`id`, `title`, `content`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, '<p>&lt;!DOCTYPE html&gt;</p><p>&lt;html lang=\"id\"&gt;</p><p>&lt;head&gt;</p><p>&nbsp; &nbsp; &lt;meta charset=\"UTF-8\"&gt;</p><p>&nbsp; &nbsp; &lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"&gt;</p><p>&nbsp; &nbsp; &lt;title&gt;PPDB Online - MIN 2 Tanggamus&lt;/title&gt;</p><p>&nbsp; &nbsp; &lt;script src=\"https://cdn.tailwindcss.com\"&gt;&lt;/script&gt;</p><p>&nbsp; &nbsp; &lt;!-- Font Google --&gt;</p><p>&nbsp; &nbsp; &lt;link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&amp;display=swap\" rel=\"stylesheet\"&gt;</p><p>&nbsp; &nbsp; &lt;style&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; body { font-family: \'Inter\', sans-serif; }</p><p>&nbsp; &nbsp; &nbsp; &nbsp; .bg-madrasah { background-color: #064e3b; } /* Hijau Tua Khas Madrasah */</p><p>&nbsp; &nbsp; &nbsp; &nbsp; .text-madrasah { color: #064e3b; }</p><p>&nbsp; &nbsp; &lt;/style&gt;</p><p>&lt;/head&gt;</p><p>&lt;body class=\"bg-gray-50 text-gray-800\"&gt;</p><p><br></p><p>&nbsp; &nbsp; &lt;!-- BAGIAN 1: NAVBAR (NAVIGASI) --&gt;</p><p>&nbsp; &nbsp; &lt;nav class=\"bg-white shadow-md sticky top-0 z-50\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"container mx-auto px-4 py-3 flex justify-between items-center\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"flex items-center space-x-2\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;!-- Placeholder Logo --&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"w-10 h-10 bg-madrasah rounded-full flex items-center justify-center text-white font-bold text-xl\"&gt;M&lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;span class=\"font-bold text-lg md:text-xl tracking-tight\"&gt;MIN 2 Tanggamus&lt;/span&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"hidden md:flex space-x-6 font-medium\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;a href=\"#beranda\" class=\"hover:text-green-600 transition\"&gt;Beranda&lt;/a&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;a href=\"#jadwal\" class=\"hover:text-green-600 transition\"&gt;Jadwal&lt;/a&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;a href=\"#syarat\" class=\"hover:text-green-600 transition\"&gt;Syarat&lt;/a&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;a href=\"#kontak\" class=\"hover:text-green-600 transition\"&gt;Kontak&lt;/a&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;button class=\"md:hidden text-gray-600\" id=\"menu-btn\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-6 w-6\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 6h16M4 12h16m-7 6h7\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/svg&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/button&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &lt;/nav&gt;</p><p><br></p><p>&nbsp; &nbsp; &lt;!-- BAGIAN 2: HERO SECTION --&gt;</p><p>&nbsp; &nbsp; &lt;header id=\"beranda\" class=\"relative bg-madrasah py-16 md:py-24 text-white overflow-hidden\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"container mx-auto px-4 relative z-10 text-center\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h1 class=\"text-3xl md:text-5xl font-extrabold mb-4 leading-tight\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Penerimaan Peserta Didik Baru (PPDB) &lt;br&gt; Tahun Pelajaran 2024/2025</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/h1&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"text-lg md:text-xl text-green-100 mb-8 max-w-2xl mx-auto\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wujudkan generasi cerdas, berakhlakul karimah, dan unggul bersama Madrasah Ibtidaiyah Negeri 2 Tanggamus.</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"flex flex-col md:flex-row justify-center gap-4\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;a href=\"#daftar\" class=\"bg-yellow-500 hover:bg-yellow-400 text-green-900 font-bold py-3 px-8 rounded-full transition shadow-lg text-lg text-center\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Daftar Sekarang</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/a&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;a href=\"#syarat\" class=\"border-2 border-white hover:bg-white hover:text-green-900 font-bold py-3 px-8 rounded-full transition text-lg text-center\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Cek Persyaratan</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/a&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;!-- Dekorasi Latar Belakang --&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-green-700 rounded-full opacity-20\"&gt;&lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-green-700 rounded-full opacity-20\"&gt;&lt;/div&gt;</p><p>&nbsp; &nbsp; &lt;/header&gt;</p><p><br></p><p>&nbsp; &nbsp; &lt;!-- BAGIAN 3: JADWAL &amp; ALUR --&gt;</p><p>&nbsp; &nbsp; &lt;section id=\"jadwal\" class=\"py-16 bg-white\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"container mx-auto px-4\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h2 class=\"text-3xl font-bold text-center mb-12 text-madrasah\"&gt;Jadwal Pelaksanaan&lt;/h2&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"grid grid-cols-1 md:grid-cols-3 gap-8\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;!-- Tahap 1 --&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"bg-gray-50 p-6 rounded-2xl border-t-4 border-green-500 shadow-sm\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"text-green-600 font-bold text-sm mb-2\"&gt;TAHAP 1&lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h3 class=\"text-xl font-bold mb-4\"&gt;Pendaftaran Online&lt;/h3&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"text-gray-600\"&gt;01 Mei - 15 Mei 2024&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"mt-2 text-sm italic\"&gt;Melalui website resmi PPDB&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;!-- Tahap 2 --&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"bg-gray-50 p-6 rounded-2xl border-t-4 border-yellow-500 shadow-sm\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"text-yellow-600 font-bold text-sm mb-2\"&gt;TAHAP 2&lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h3 class=\"text-xl font-bold mb-4\"&gt;Verifikasi Berkas&lt;/h3&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"text-gray-600\"&gt;17 Mei - 20 Mei 2024&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"mt-2 text-sm italic\"&gt;Datang langsung ke Madrasah&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;!-- Tahap 3 --&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"bg-gray-50 p-6 rounded-2xl border-t-4 border-blue-500 shadow-sm\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"text-blue-600 font-bold text-sm mb-2\"&gt;TAHAP 3&lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h3 class=\"text-xl font-bold mb-4\"&gt;Pengumuman Hasil&lt;/h3&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"text-gray-600\"&gt;25 Mei 2024&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"mt-2 text-sm italic\"&gt;Dilihat di papan informasi &amp; website&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &lt;/section&gt;</p><p><br></p><p>&nbsp; &nbsp; &lt;!-- BAGIAN 4: PERSYARATAN --&gt;</p><p>&nbsp; &nbsp; &lt;section id=\"syarat\" class=\"py-16 bg-green-50\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"container mx-auto px-4\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"max-w-4xl mx-auto\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h2 class=\"text-3xl font-bold text-center mb-12 text-madrasah\"&gt;Persyaratan Pendaftaran&lt;/h2&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"bg-white p-8 rounded-3xl shadow-xl\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;ul class=\"space-y-4\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;li class=\"flex items-start\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;svg class=\"h-6 w-6 text-green-500 mr-3 flex-shrink-0\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/svg&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;span&gt;Berusia minimal 6 tahun pada bulan Juli 2024.&lt;/span&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/li&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;li class=\"flex items-start\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;svg class=\"h-6 w-6 text-green-500 mr-3 flex-shrink-0\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/svg&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;span&gt;Fotocopy Akta Kelahiran (2 lembar).&lt;/span&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/li&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;li class=\"flex items-start\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;svg class=\"h-6 w-6 text-green-500 mr-3 flex-shrink-0\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/svg&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;span&gt;Fotocopy Kartu Keluarga (KK) (2 lembar).&lt;/span&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/li&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;li class=\"flex items-start\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;svg class=\"h-6 w-6 text-green-500 mr-3 flex-shrink-0\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/svg&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;span&gt;Fotocopy Ijazah TK/RA (jika ada).&lt;/span&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/li&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;li class=\"flex items-start\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;svg class=\"h-6 w-6 text-green-500 mr-3 flex-shrink-0\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/svg&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;span&gt;Pas Foto ukuran 3x4 latar belakang merah (4 lembar).&lt;/span&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/li&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/ul&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &lt;/section&gt;</p><p><br></p><p>&nbsp; &nbsp; &lt;!-- BAGIAN 5: KONTAK &amp; LOKASI --&gt;</p><p>&nbsp; &nbsp; &lt;section id=\"kontak\" class=\"py-16 bg-white\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"container mx-auto px-4\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h2 class=\"text-3xl font-bold text-center mb-12 text-madrasah\"&gt;Hubungi Kami&lt;/h2&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"flex flex-col md:flex-row gap-12 items-center justify-center\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;!-- Alamat --&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"w-full md:w-1/2 space-y-6\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"flex items-center space-x-4\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"bg-green-100 p-3 rounded-full text-green-600\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-6 w-6\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 11a3 3 0 11-6 0 3 3 0 016 0z\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/svg&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h4 class=\"font-bold\"&gt;Alamat Madrasah&lt;/h4&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"text-gray-600\"&gt;Jl. Raya No. 123, Kabupaten Tanggamus, Lampung&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"flex items-center space-x-4\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"bg-green-100 p-3 rounded-full text-green-600\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-6 w-6\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z\" /&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/svg&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;h4 class=\"font-bold\"&gt;WhatsApp Panitia&lt;/h4&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"text-gray-600\"&gt;+62 812-3456-7890 (Bpk. Ahmad)&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;!-- Tombol CTA WhatsApp --&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"w-full md:w-auto\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;a href=\"https://wa.me/6281234567890\" target=\"_blank\" class=\"inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-10 rounded-2xl transition shadow-xl space-x-2\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;span&gt;Chat Panitia Sekarang&lt;/span&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/a&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &lt;/section&gt;</p><p><br></p><p>&nbsp; &nbsp; &lt;!-- FOOTER --&gt;</p><p>&nbsp; &nbsp; &lt;footer class=\"bg-madrasah text-white py-8\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"container mx-auto px-4 text-center\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"mb-2 font-bold\"&gt;MIN 2 Tanggamus&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;p class=\"text-sm text-green-200\"&gt;&amp;copy; 2024 Official Website PPDB MIN 2 Tanggamus. All rights reserved.&lt;/p&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &lt;/div&gt;</p><p>&nbsp; &nbsp; &lt;/footer&gt;</p><p><br></p><p>&nbsp; &nbsp; &lt;!-- Script Sederhana untuk Mobile Menu --&gt;</p><p>&nbsp; &nbsp; &lt;script&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; const btn = document.getElementById(\'menu-btn\');</p><p>&nbsp; &nbsp; &nbsp; &nbsp; // Fitur menu mobile bisa ditambahkan di sini jika ingin interaktif penuh</p><p>&nbsp; &nbsp; &nbsp; &nbsp; btn.addEventListener(\'click\', () =&gt; {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; alert(\'Menu navigasi akan muncul di sini (Fitur Demo)\');</p><p>&nbsp; &nbsp; &nbsp; &nbsp; });</p><p>&nbsp; &nbsp; &lt;/script&gt;</p><p>&lt;/body&gt;</p><p>&lt;/html&gt;</p>', 0, '2026-02-14 13:28:28', '2026-02-15 12:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id_user` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` text COLLATE utf8mb4_general_ci,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `website` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telp` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kab_sekolah` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ketua_panitia` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nip_ketua` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `th_pelajaran` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_surat` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kepsek` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nip_kepsek` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `level` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_daftar` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id_user`, `username`, `password`, `nama_lengkap`, `alamat`, `email`, `website`, `telp`, `kab_sekolah`, `ketua_panitia`, `nip_ketua`, `th_pelajaran`, `no_surat`, `kepsek`, `nip_kepsek`, `level`, `tgl_daftar`) VALUES
(1, 'admin', '$2y$10$tj0C1gvqIbccPcg49QT4pulJfPucrUbDKnFszwvkVU0vz1ATcCCba', 'Administrator PPDB', 'Jl. Pendidikan No. 1', 'admin@sekolah.sch.id', 'https://sekolah.sch.id', '081234567890', 'Kabupaten Contoh', NULL, NULL, '2025/2026', NULL, NULL, NULL, 'admin', '2025-12-28 11:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verifikasi`
--

CREATE TABLE `tbl_verifikasi` (
  `id_verifikasi` int NOT NULL,
  `isi` text COLLATE utf8mb4_general_ci,
  `ket` text COLLATE utf8mb4_general_ci,
  `tgl_verifikasi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_web`
--

CREATE TABLE `tbl_web` (
  `id_web` int NOT NULL,
  `status_ppdb` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ujian_aktif` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `tgl_ujian` datetime DEFAULT NULL,
  `pengumuman_aktif` enum('0','1') COLLATE utf8mb4_general_ci DEFAULT '0',
  `tgl_pengumuman` datetime DEFAULT NULL,
  `tgl_diubah` datetime DEFAULT NULL,
  `nama_sekolah` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat_sekolah` text COLLATE utf8mb4_general_ci,
  `logo_sekolah` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pesan_tutup` text COLLATE utf8mb4_general_ci,
  `limit_kuota` int DEFAULT '0',
  `nsm` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `npsn` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kecamatan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kabupaten` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `provinsi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_kepala` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nip_kepala` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `website` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_web`
--

INSERT INTO `tbl_web` (`id_web`, `status_ppdb`, `ujian_aktif`, `tgl_ujian`, `pengumuman_aktif`, `tgl_pengumuman`, `tgl_diubah`, `nama_sekolah`, `alamat_sekolah`, `logo_sekolah`, `pesan_tutup`, `limit_kuota`, `nsm`, `npsn`, `kecamatan`, `kabupaten`, `provinsi`, `nama_kepala`, `nip_kepala`, `telepon`, `email`, `website`) VALUES
(1, 'buka', '0', NULL, '1', '2026-04-15 19:50:00', '2026-01-30 11:52:19', 'MIN 2 Tanggamus', NULL, 'logo_sekolah.png', '', 0, '111118060002', '60705691', 'GISTING', 'TANGGAMUS', 'LAMPUNG', '', '', '(021) 12345678', 'minduatanggamus@gmail.com', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alur_pendaftaran`
--
ALTER TABLE `alur_pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jalur_pendaftaran`
--
ALTER TABLE `jalur_pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_berkas`
--
ALTER TABLE `tbl_berkas`
  ADD PRIMARY KEY (`id_berkas`);

--
-- Indexes for table `tbl_komp`
--
ALTER TABLE `tbl_komp`
  ADD PRIMARY KEY (`id_komp`);

--
-- Indexes for table `tbl_landing_content`
--
ALTER TABLE `tbl_landing_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pdd`
--
ALTER TABLE `tbl_pdd`
  ADD PRIMARY KEY (`id_pdd`);

--
-- Indexes for table `tbl_pekerjaan`
--
ALTER TABLE `tbl_pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `tbl_penghasilan`
--
ALTER TABLE `tbl_penghasilan`
  ADD PRIMARY KEY (`id_penghasilan`);

--
-- Indexes for table `tbl_pengumuman`
--
ALTER TABLE `tbl_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `tbl_static_page`
--
ALTER TABLE `tbl_static_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `tbl_verifikasi`
--
ALTER TABLE `tbl_verifikasi`
  ADD PRIMARY KEY (`id_verifikasi`);

--
-- Indexes for table `tbl_web`
--
ALTER TABLE `tbl_web`
  ADD PRIMARY KEY (`id_web`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alur_pendaftaran`
--
ALTER TABLE `alur_pendaftaran`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jalur_pendaftaran`
--
ALTER TABLE `jalur_pendaftaran`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_berkas`
--
ALTER TABLE `tbl_berkas`
  MODIFY `id_berkas` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_komp`
--
ALTER TABLE `tbl_komp`
  MODIFY `id_komp` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_landing_content`
--
ALTER TABLE `tbl_landing_content`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tbl_pdd`
--
ALTER TABLE `tbl_pdd`
  MODIFY `id_pdd` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_pekerjaan`
--
ALTER TABLE `tbl_pekerjaan`
  MODIFY `id_pekerjaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_penghasilan`
--
ALTER TABLE `tbl_penghasilan`
  MODIFY `id_penghasilan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_pengumuman`
--
ALTER TABLE `tbl_pengumuman`
  MODIFY `id_pengumuman` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_static_page`
--
ALTER TABLE `tbl_static_page`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_verifikasi`
--
ALTER TABLE `tbl_verifikasi`
  MODIFY `id_verifikasi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_web`
--
ALTER TABLE `tbl_web`
  MODIFY `id_web` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
