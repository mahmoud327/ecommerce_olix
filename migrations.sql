-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2021 at 02:44 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suiiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2009_05_16_123105_create_governorates_table', 1),
(2, '2009_05_16_123105_create_properties_table', 1),
(3, '2009_05_16_123105_create_sub_properties_table', 1),
(4, '2009_05_16_123106_create_product_sub_properties_table', 1),
(5, '2009_06_16_123105_create_cities_table', 1),
(6, '2009_06_16_123106_create_category_types_table', 1),
(7, '2009_06_16_123106_create_filter_types_table', 1),
(8, '2009_06_16_123106_create_organization_types_table', 1),
(9, '2010_03_22_144155_create_notifications_table', 1),
(10, '2014_10_12_000000_create_settings_table', 1),
(11, '2014_10_12_000000_create_users_table', 1),
(12, '2014_10_12_100000_create_password_resets_table', 1),
(13, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(14, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(15, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(16, '2016_06_01_000004_create_oauth_clients_table', 1),
(17, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(18, '2018_08_08_100000_create_telescope_entries_table', 1),
(19, '2018_09_21_134643_create_products_table', 1),
(20, '2019_08_19_000000_create_failed_jobs_table', 1),
(21, '2020_06_20_132228_create_upgrade_requests_table', 1),
(22, '2020_07_05_111112_create_search_user_table', 1),
(23, '2020_07_05_111113_create_feature_product_table', 1),
(24, '2021_06_14_150230_create_medias_table', 1),
(25, '2021_06_16_103741_create_organizations_table', 1),
(26, '2021_06_16_123106_create_accounts_table', 1),
(27, '2021_06_16_123106_create_categories_recurring_table', 1),
(28, '2021_06_16_123106_create_categories_table', 1),
(29, '2021_06_16_123106_create_category_sub_accounts_table', 1),
(30, '2021_06_16_123106_create_filter_sub_accounts_table', 1),
(31, '2021_06_16_123106_create_filters_recurring_table', 1),
(32, '2021_06_16_123106_create_sub_accounts_table', 1),
(33, '2021_06_16_123106_create_views_table', 1),
(34, '2021_06_17_152953_create_features_table', 1),
(35, '2021_06_17_152954_create_feature_sub_account_table', 1),
(36, '2021_06_19_064905_create_sessions_table', 1),
(37, '2021_06_20_132228_create_filter_recurring_sub_accounts_table', 1),
(38, '2021_06_21_132548_table_product_favourite_user_table', 1),
(39, '2021_06_24_163645_create_categories_recurring_sub_accounts_table', 1),
(40, '2021_06_24_200000_create_sub_account_user_table', 1),
(41, '2021_06_25_153129999_create_foreign_keys', 1),
(42, '2021_09_04_154727_create_jobs_table', 1),
(43, '2021_11_20_121257_create_complainments_table', 1),
(44, '2021_11_20_121529_create_contacts_table', 1),
(45, '2021_11_20_122847_create_marketer_codes_table', 1),
(46, '2021_11_20_125727_create_product_reports_table', 1),
(47, '2021_11_20_130345_create_permission_tables', 1),
(48, '2021_11_20_134708_create_admins_table', 1),
(49, '2021_11_20_135702_create_advertisments_table', 1),
(50, '2021_11_20_141124_create_category_filter_recurring_table', 1),
(51, '2021_11_20_141413_create_category_organization_service_table', 1),
(52, '2021_11_20_141750_create_organization_services', 1),
(53, '2021_11_20_142633_create_organization_service_service_table', 1),
(54, '2021_11_20_143426_create_comments_table', 1),
(55, '2021_11_20_144153_create_posts_table', 1),
(56, '2021_11_20_144349_create_replies_table', 1),
(57, '2021_11_20_154012_create_product_sub_filter_recurring_table', 1),
(58, '2021_11_20_154356_create_likes_table', 1),
(59, '2021_11_20_165129_create_service_requests_table', 1),
(60, '2021_11_20_165746_create_services_table', 1),
(61, '2021_11_20_173905_create_sub_filters_recurring_table', 1),
(62, '2021_11_21_112217_change_category_id_to_foreign_key', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
