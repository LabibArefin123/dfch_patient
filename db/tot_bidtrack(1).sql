-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2025 at 05:54 AM
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
-- Database: `tot_bidtrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_chat_message`
--

CREATE TABLE `ai_chat_message` (
  `id` bigint UNSIGNED NOT NULL,
  `chat_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `awarded_tenders`
--

CREATE TABLE `awarded_tenders` (
  `id` bigint UNSIGNED NOT NULL,
  `participated_tender_id` bigint UNSIGNED NOT NULL,
  `tender_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `awarded_date` date NOT NULL,
  `delivery_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('goods','works','software') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `awarded_tender_deliveries`
--

CREATE TABLE `awarded_tender_deliveries` (
  `id` bigint UNSIGNED NOT NULL,
  `awarded_tender_id` bigint UNSIGNED NOT NULL,
  `pg_amount` decimal(12,2) NOT NULL,
  `pg_expiry_date` date NOT NULL,
  `warranty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `big_guarantees`
--

CREATE TABLE `big_guarantees` (
  `id` bigint UNSIGNED NOT NULL,
  `bg_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_in_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_in_branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `tender_id` bigint UNSIGNED NOT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchaser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `big_guarantees`
--

INSERT INTO `big_guarantees` (`id`, `bg_no`, `issue_in_bank`, `issue_in_branch`, `issue_date`, `expiry_date`, `tender_id`, `item`, `purchaser`, `amount`, `attachment`, `created_at`, `updated_at`) VALUES
(1, '1000', 'BRAC Bank', 'Dhaka', '2025-06-25', '2025-06-30', 1, '2', 'Navy', '5000.00', 'bg_attachments/AOXe7L6qOStSWHDlcro4wkYS20M201IHUkfv9EE1.pdf', '2025-06-29 13:06:54', '2025-06-29 13:06:54');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('admin@gmail.com|127.0.0.1', 'i:1;', 1751261457),
('admin@gmail.com|127.0.0.1:timer', 'i:1751261457;', 1751261457),
('spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:61:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:7:\"profile\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"profile.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:14:\"profile.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"profile.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"tenders.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:14:\"tenders.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:13:\"tenders.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:14:\"tenders.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"tenders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"tenders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:20:\"tenders.downloadSpec\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:22:\"tenders.downloadNotice\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:20:\"tenders.updateStatus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:15:\"tenders.archive\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:20:\"tenders.archive.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:22:\"tenders.archive.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:23:\"tenders.archive.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:26:\"participated_tenders.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:27:\"participated_tenders.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:26:\"participated_tenders.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:25:\"participated_tenders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:27:\"participated_tenders.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:28:\"participated_tenders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"tender.mytender\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:27:\"participated_tenders.reject\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:22:\"rejected_tenders.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:21:\"awarded_tenders.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:22:\"awarded_tenders.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:21:\"awarded_tenders.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:20:\"awarded_tenders.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:22:\"awarded_tenders.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:23:\"awarded_tenders.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:17:\"user_activity_log\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:18:\"profile.management\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:17:\"user_profile_edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:19:\"user_profile_update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:20:\"profile_picture_edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:22:\"profile_picture_update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:20:\"user_password_update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:18:\"user_password_edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:19:\"user_password_reset\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"permissions.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:18:\"permissions.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:17:\"permissions.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:16:\"permissions.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:18:\"permissions.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:19:\"permissions.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:11:\"roles.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:12:\"roles.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:11:\"roles.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:10:\"roles.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:12:\"roles.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:13:\"roles.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:18:\"system_users.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:19:\"system_users.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:18:\"system_users.store\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:17:\"system_users.show\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:17:\"system_users.edit\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:19:\"system_users.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:20:\"system_users.destroy\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:23:\"completed_tenders.index\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:2;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:7:\"Manager\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"Admin\";s:1:\"c\";s:3:\"web\";}}}', 1751281635);

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
-- Table structure for table `chat_ai_data`
--

CREATE TABLE `chat_ai_data` (
  `id` bigint UNSIGNED NOT NULL,
  `chat_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `chat_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` bigint UNSIGNED NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2025_02_17_133801_create_users_table', 1),
(2, '2025_02_19_005824_create_user_activity_logs_table', 1),
(3, '2025_02_27_120603_create_chat_ai_data_table', 1),
(4, '2025_02_27_175437_create_chat_ai_message_table', 1),
(5, '2025_03_03_012504_create_sessions_table', 1),
(6, '2025_03_03_012712_create_cache_table', 1),
(7, '2025_03_03_012816_create_permission_tables', 1),
(8, '2025_04_26_135053_create_tenders_table', 1),
(9, '2025_04_26_175854_add_archived_to_tenders_table', 1),
(10, '2025_04_26_183215_create_bidders_table', 1),
(11, '2025_04_26_184108_add_bidding_price_to_bidders_table', 1),
(12, '2025_04_27_113645_create_participated_bidders_table', 1),
(13, '2025_04_27_113715_create_rejected_bidders_table', 1),
(14, '2025_04_28_103604_create_ionwave_bids_table', 1),
(15, '2025_04_28_111004_create_beyond_bids_table', 1),
(16, '2025_04_28_120810_create_beyond_suppliers_table', 1),
(17, '2025_04_28_124234_add_columns_to_beyond_suppliers_table', 1),
(18, '2025_04_28_131734_create_bidhives_table', 1),
(19, '2025_04_28_145329_add_dates_to_tenders_table', 1),
(20, '2025_04_28_152129_create_participated_tenders_table', 1),
(21, '2025_04_29_111803_add_more_fields_to_tenders_table', 1),
(22, '2025_04_29_115235_add_offer_validity_and_expiry_date_to_participated_tenders_table', 1),
(23, '2025_04_29_122436_remove_position_from_participated_tenders_table', 1),
(24, '2025_04_29_133626_add_security_price_to_participated_tenders_table', 1),
(25, '2025_04_29_231038_create_denos_table', 1),
(26, '2025_04_29_232149_change_quantity_to_string_in_tenders_table', 1),
(27, '2025_04_30_171940_create_demos_table', 1),
(28, '2025_04_30_182755_blood_group', 1),
(29, '2025_04_30_182938_department', 1),
(30, '2025_04_30_235652_create_my_tenders_table', 1),
(31, '2025_05_01_101744_add_batch_id_to_participated_tenders_and_my_tenders', 1),
(32, '2025_05_07_133023_create_awarded_tenders_table', 1),
(33, '2025_05_07_133140_create_awarded_tenders_deliveries', 1),
(34, '2025_05_07_153545_create_partial_deliveries_table', 1),
(35, '2025_05_07_164626_add_financial_year_to_tenders_table', 1),
(36, '2025_05_07_184313_add_status_to_participated_tenders_table', 1),
(37, '2025_05_08_111331_add_submission_time_to_tenders_table', 1),
(38, '2025_05_08_151044_add_status_to_participated_tenders_table', 1),
(39, '2025_05_08_180130_add_company_name_to_users_table', 1),
(40, '2025_06_29_170227_create_view_permissions_table', 2),
(41, '2025_06_29_182430_create_bg_tables_data', 3),
(42, '2025_06_29_182606_create_pg_tables_data', 4),
(43, '2025_06_29_185056_create_big_guarantees_table', 5),
(44, '2025_06_29_185533_create_performance_guarantees_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 29);

-- --------------------------------------------------------

--
-- Table structure for table `my_tenders`
--

CREATE TABLE `my_tenders` (
  `id` bigint UNSIGNED NOT NULL,
  `tender_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int DEFAULT NULL,
  `offered_price` decimal(15,2) NOT NULL,
  `offer_validity` date NOT NULL,
  `security_price` decimal(15,2) NOT NULL,
  `expiry_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `partial_deliveries`
--

CREATE TABLE `partial_deliveries` (
  `id` bigint UNSIGNED NOT NULL,
  `awarded_tender_id` bigint UNSIGNED NOT NULL,
  `delivery_item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_date` date NOT NULL,
  `warranty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participated_bidders`
--

CREATE TABLE `participated_bidders` (
  `id` bigint UNSIGNED NOT NULL,
  `tender_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_members` int NOT NULL DEFAULT '1',
  `start_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participated_tenders`
--

CREATE TABLE `participated_tenders` (
  `id` bigint UNSIGNED NOT NULL,
  `tender_id` bigint UNSIGNED NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `offered_price` decimal(15,2) NOT NULL,
  `security_price` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `offer_validity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'accepted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `participated_tenders`
--

INSERT INTO `participated_tenders` (`id`, `tender_id`, `batch_id`, `company_name`, `deno`, `qty`, `offered_price`, `security_price`, `created_at`, `updated_at`, `offer_validity`, `expiry_date`, `status`) VALUES
(1, 1, NULL, 'TOTALOFFTEC', 'Meter', 15, '50000.00', '50000.00', '2025-06-29 17:34:04', '2025-06-29 17:34:27', '2025-06-25', '2025-06-25', 'rejected'),
(2, 1, NULL, 'TOTALOFFTEC', 'Meter', 15, '50000.00', '50000.00', '2025-06-29 17:39:43', '2025-06-29 17:39:43', '2025-06-15', '2025-06-20', 'accepted'),
(3, 1, NULL, 'XCorpTech', 'Meter', 15, '45000.00', '45000.00', '2025-06-29 17:39:43', '2025-06-29 17:39:43', '2025-06-15', '2025-06-20', 'accepted'),
(4, 1, NULL, 'NanoCorp', 'Meter', 15, '20000.00', '20000.00', '2025-06-29 17:39:43', '2025-06-29 17:39:43', '2025-06-15', '2025-06-20', 'accepted'),
(5, 1, NULL, 'AB Company', 'Meter', 15, '55000.00', '55000.00', '2025-06-29 17:39:43', '2025-06-29 17:39:43', '2025-06-15', '2025-06-06', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `performance_guarantees`
--

CREATE TABLE `performance_guarantees` (
  `id` bigint UNSIGNED NOT NULL,
  `pg_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_in_bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_in_branch` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `tender_id` bigint UNSIGNED NOT NULL,
  `item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purchaser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'profile', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(2, 'profile.edit', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(3, 'profile.update', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(4, 'profile.destroy', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(5, 'tenders.index', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(6, 'tenders.create', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(7, 'tenders.store', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(8, 'tenders.update', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(9, 'tenders.edit', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(10, 'tenders.destroy', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(11, 'tenders.downloadSpec', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(12, 'tenders.downloadNotice', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(13, 'tenders.updateStatus', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(14, 'tenders.archive', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(15, 'tenders.archive.edit', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(16, 'tenders.archive.update', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(17, 'tenders.archive.destroy', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(18, 'participated_tenders.index', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(19, 'participated_tenders.create', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(20, 'participated_tenders.store', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(21, 'participated_tenders.edit', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(22, 'participated_tenders.update', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(23, 'participated_tenders.destroy', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(24, 'tender.mytender', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(25, 'participated_tenders.reject', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(26, 'rejected_tenders.index', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(27, 'awarded_tenders.index', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(28, 'awarded_tenders.create', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(29, 'awarded_tenders.store', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(30, 'awarded_tenders.edit', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(31, 'awarded_tenders.update', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(32, 'awarded_tenders.destroy', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(33, 'user_activity_log', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(34, 'profile.management', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(35, 'user_profile_edit', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(36, 'user_profile_update', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(37, 'profile_picture_edit', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(38, 'profile_picture_update', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(39, 'user_password_update', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(40, 'user_password_edit', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(41, 'user_password_reset', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(42, 'permissions.index', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(43, 'permissions.create', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(44, 'permissions.store', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(45, 'permissions.edit', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(46, 'permissions.update', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(47, 'permissions.destroy', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(48, 'roles.index', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(49, 'roles.create', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(50, 'roles.store', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(51, 'roles.edit', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(52, 'roles.update', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(53, 'roles.destroy', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(54, 'system_users.index', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(55, 'system_users.create', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(56, 'system_users.store', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(57, 'system_users.show', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(58, 'system_users.edit', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(59, 'system_users.update', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(60, 'system_users.destroy', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14'),
(61, 'completed_tenders.index', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14');

-- --------------------------------------------------------

--
-- Table structure for table `rejected_bidders`
--

CREATE TABLE `rejected_bidders` (
  `id` bigint UNSIGNED NOT NULL,
  `participated_bidder_id` bigint UNSIGNED NOT NULL,
  `tender_id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_members` int NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Manager', 'web', '2025-06-29 10:44:55', '2025-06-29 10:44:55'),
(2, 'Admin', 'web', '2025-06-29 11:07:14', '2025-06-29 11:07:14');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2);

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
('5L6oD6TdD9p6gHWpD21uc05JeimykXV90hreEJDh', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMldWakxzUWdZOVQzeW9TajMwbnhSOEJ6TWRaclI3VDFGMUo5V3pRdSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZ19iZ19tYW5hZ2VtZW50Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6ImF1dGgiO2E6MTp7czoyMToicGFzc3dvcmRfY29uZmlybWVkX2F0IjtpOjE3NTEyMjIwMjM7fX0=', 1751223056),
('kVEAnWX4WspsnUdNkHzUMzVP6JXJVbfiqUlfC6Qz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMUczWHlvTjJZS0FqNGlOOUtLMENaTmJvejkwR0VkMTZUQnBQNFBOZCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvdGVuZGVycy9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1MTI2MTQxMjt9fQ==', 1751261860);

-- --------------------------------------------------------

--
-- Table structure for table `tenders`
--

CREATE TABLE `tenders` (
  `id` bigint UNSIGNED NOT NULL,
  `tender_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spec_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notice_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `submission_date` date DEFAULT NULL,
  `submission_time` time DEFAULT NULL,
  `procuring_authority` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deno` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `financial_year` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('P','NP') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tenders`
--

INSERT INTO `tenders` (`id`, `tender_no`, `title`, `spec_file`, `notice_file`, `archived`, `created_at`, `updated_at`, `publication_date`, `submission_date`, `submission_time`, `procuring_authority`, `end_user`, `deno`, `financial_year`, `status`, `quantity`) VALUES
(1, 'Demo', 'demo', 'specs/1751213176_spec_NID.jpg', 'notice_files/4t777IyvrVQT8fzN1MFO1Y9SCOUCw3xCe1VSOwCF.pdf', 0, '2025-06-29 13:04:57', '2025-06-29 17:16:46', '2025-06-14', '2025-06-20', '12:00:00', 'NSSD', 'Navy', 'Meter', '2023-2024', 'P', '15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `user_type` tinyint DEFAULT NULL COMMENT '1=System User, 2=Employee',
  `employeeID` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_2` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `employeeID`, `name`, `company_name`, `phone`, `phone_2`, `username`, `role_id`, `email`, `password`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Admin', 'TOTALOFFTEC', '01700000000', '01700000000', 'admin', 2, 'admin@gmail.com', '$2y$12$o1Y9ky2K6EWRyIaRFMge7e4pY3r4cbvv5.7TCJCZxjORMn0mp.VVq', 'images/profile_pictures/1751221428_686184b450b77.jpeg', '2025-06-24 05:33:35', '2025-06-29 18:28:27'),
(29, 1, NULL, 'Mahfuz', NULL, NULL, '01700000003', 'mahfuz', NULL, 'mahfuz@gmail.com', '$2y$12$/2kWVezs57nEHx08s/iDoO1v16b9L8JCcWU/enmMRkogIO8Hd58SG', NULL, '2025-06-29 11:06:06', '2025-06-29 11:06:06');

-- --------------------------------------------------------

--
-- Table structure for table `view_permissions`
--

CREATE TABLE `view_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `view_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_chat_message`
--
ALTER TABLE `ai_chat_message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `awarded_tenders`
--
ALTER TABLE `awarded_tenders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `awarded_tenders_participated_tender_id_foreign` (`participated_tender_id`);

--
-- Indexes for table `awarded_tender_deliveries`
--
ALTER TABLE `awarded_tender_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `awarded_tender_deliveries_awarded_tender_id_foreign` (`awarded_tender_id`);

--
-- Indexes for table `big_guarantees`
--
ALTER TABLE `big_guarantees`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `chat_ai_data`
--
ALTER TABLE `chat_ai_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_department_name_unique` (`department_name`);

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
-- Indexes for table `my_tenders`
--
ALTER TABLE `my_tenders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `my_tenders_tender_id_foreign` (`tender_id`);

--
-- Indexes for table `partial_deliveries`
--
ALTER TABLE `partial_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partial_deliveries_awarded_tender_id_foreign` (`awarded_tender_id`);

--
-- Indexes for table `participated_bidders`
--
ALTER TABLE `participated_bidders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participated_bidders_tender_id_foreign` (`tender_id`);

--
-- Indexes for table `participated_tenders`
--
ALTER TABLE `participated_tenders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participated_tenders_tender_id_foreign` (`tender_id`);

--
-- Indexes for table `performance_guarantees`
--
ALTER TABLE `performance_guarantees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `rejected_bidders`
--
ALTER TABLE `rejected_bidders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rejected_bidders_participated_bidder_id_foreign` (`participated_bidder_id`),
  ADD KEY `rejected_bidders_tender_id_foreign` (`tender_id`);

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
-- Indexes for table `tenders`
--
ALTER TABLE `tenders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tenders_tender_no_unique` (`tender_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `view_permissions`
--
ALTER TABLE `view_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `view_permissions_role_id_index` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_chat_message`
--
ALTER TABLE `ai_chat_message`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `awarded_tenders`
--
ALTER TABLE `awarded_tenders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `awarded_tender_deliveries`
--
ALTER TABLE `awarded_tender_deliveries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `big_guarantees`
--
ALTER TABLE `big_guarantees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat_ai_data`
--
ALTER TABLE `chat_ai_data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `my_tenders`
--
ALTER TABLE `my_tenders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `partial_deliveries`
--
ALTER TABLE `partial_deliveries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `participated_bidders`
--
ALTER TABLE `participated_bidders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `participated_tenders`
--
ALTER TABLE `participated_tenders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `performance_guarantees`
--
ALTER TABLE `performance_guarantees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `rejected_bidders`
--
ALTER TABLE `rejected_bidders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenders`
--
ALTER TABLE `tenders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `view_permissions`
--
ALTER TABLE `view_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `awarded_tenders`
--
ALTER TABLE `awarded_tenders`
  ADD CONSTRAINT `awarded_tenders_participated_tender_id_foreign` FOREIGN KEY (`participated_tender_id`) REFERENCES `participated_tenders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `awarded_tender_deliveries`
--
ALTER TABLE `awarded_tender_deliveries`
  ADD CONSTRAINT `awarded_tender_deliveries_awarded_tender_id_foreign` FOREIGN KEY (`awarded_tender_id`) REFERENCES `awarded_tenders` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `my_tenders`
--
ALTER TABLE `my_tenders`
  ADD CONSTRAINT `my_tenders_tender_id_foreign` FOREIGN KEY (`tender_id`) REFERENCES `tenders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `partial_deliveries`
--
ALTER TABLE `partial_deliveries`
  ADD CONSTRAINT `partial_deliveries_awarded_tender_id_foreign` FOREIGN KEY (`awarded_tender_id`) REFERENCES `awarded_tenders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `participated_bidders`
--
ALTER TABLE `participated_bidders`
  ADD CONSTRAINT `participated_bidders_tender_id_foreign` FOREIGN KEY (`tender_id`) REFERENCES `tenders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `participated_tenders`
--
ALTER TABLE `participated_tenders`
  ADD CONSTRAINT `participated_tenders_tender_id_foreign` FOREIGN KEY (`tender_id`) REFERENCES `tenders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rejected_bidders`
--
ALTER TABLE `rejected_bidders`
  ADD CONSTRAINT `rejected_bidders_participated_bidder_id_foreign` FOREIGN KEY (`participated_bidder_id`) REFERENCES `participated_bidders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rejected_bidders_tender_id_foreign` FOREIGN KEY (`tender_id`) REFERENCES `tenders` (`id`) ON DELETE CASCADE;

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
