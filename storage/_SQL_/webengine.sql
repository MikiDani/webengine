-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2023 at 09:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webengine`
--

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
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menujson` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`menujson`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menujson`, `created_at`, `updated_at`) VALUES
(1, '\"[{\\\"id\\\":\\\"1\\\",\\\"sequence\\\":2,\\\"menuname_hu\\\":\\\"ELS\\\\u0150 01\\\",\\\"menuname_en\\\":\\\"FIRST 01\\\",\\\"child\\\":[{\\\"id\\\":\\\"4\\\",\\\"sequence\\\":4,\\\"menuname_hu\\\":\\\"M\\\\u00c1SODIK 02\\\",\\\"menuname_en\\\":\\\"M\\\\u00c1SODIK 02\\\"}]},{\\\"id\\\":\\\"2\\\",\\\"sequence\\\":5,\\\"menuname_hu\\\":\\\"\\\\u00daj men\\\\u00fcsor-2\\\",\\\"menuname_en\\\":\\\"New element-2\\\",\\\"child\\\":[{\\\"id\\\":\\\"5\\\",\\\"sequence\\\":7,\\\"menuname_hu\\\":\\\"\\\\u00daj men\\\\u00fcsor-5\\\",\\\"menuname_en\\\":\\\"New element-5\\\"}]},{\\\"id\\\":\\\"3\\\",\\\"sequence\\\":8,\\\"menuname_hu\\\":\\\"\\\\u00daj men\\\\u00fcsor-3\\\",\\\"menuname_en\\\":\\\"New element-3\\\"}]\"', '2023-11-18 19:54:39', '2023-11-18 19:54:39');

-- --------------------------------------------------------

--
-- Table structure for table `menulist`
--

CREATE TABLE `menulist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menuname_hu` varchar(255) NOT NULL,
  `menuname_en` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menulist`
--

INSERT INTO `menulist` (`id`, `menuname_hu`, `menuname_en`, `created_at`, `updated_at`) VALUES
(1, 'ELSŐ 01', 'FIRST 01', '2023-11-18 19:42:54', '2023-11-18 19:54:39'),
(2, 'Új menüsor-2', 'New element-2', '2023-11-18 19:42:54', '2023-11-18 19:42:54'),
(3, 'Új menüsor-3', 'New element-3', '2023-11-18 19:42:54', '2023-11-18 19:42:54'),
(4, 'MÁSODIK 02', 'MÁSODIK 02', '2023-11-18 19:42:54', '2023-11-18 19:54:39'),
(5, 'Új menüsor-5', 'New element-5', '2023-11-18 19:42:54', '2023-11-18 19:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `menumodulelist`
--

CREATE TABLE `menumodulelist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sequence` varchar(4) NOT NULL,
  `modulename_hu` varchar(100) NOT NULL,
  `modulename_en` varchar(100) NOT NULL,
  `id_menulist` bigint(20) UNSIGNED NOT NULL,
  `id_moduletype` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menumodulelist`
--

INSERT INTO `menumodulelist` (`id`, `sequence`, `modulename_hu`, `modulename_en`, `id_menulist`, `id_moduletype`, `created_at`, `updated_at`) VALUES
(1, '01', 'Első hírek 01', 'First news 02', 1, 1, '2023-11-18 19:58:11', '2023-11-18 19:58:11'),
(2, '02', 'Első email küldés 02', 'Second email send 02', 1, 2, '2023-11-18 19:58:11', '2023-11-18 19:58:11'),
(3, '01', 'Második News 03', 'Second News 03', 4, 1, '2023-11-18 20:00:51', '2023-11-18 20:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `menumoduletype`
--

CREATE TABLE `menumoduletype` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menumoduletype`
--

INSERT INTO `menumoduletype` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'news', '2023-11-18 19:56:58', '2023-11-18 19:56:58'),
(2, 'sendemail', '2023-11-18 19:56:58', '2023-11-18 19:56:58');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2023_10_27_000000_create_menu_table', 1),
(11, '2023_11_03_201456_menulist', 1),
(12, '2023_11_03_204040_menumoduletype', 1),
(13, '2023_11_03_204050_menumodulelist', 1),
(14, '2023_11_04_110000_module_news', 1),
(15, '2023_11_04_120000_module_sendemail', 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_news`
--

CREATE TABLE `module_news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menumodulelist` bigint(20) UNSIGNED NOT NULL,
  `news_datetime` datetime NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_message` longtext NOT NULL,
  `news_image` varchar(255) NOT NULL,
  `news_link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `module_sendemail`
--

CREATE TABLE `module_sendemail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menumodulelist` bigint(20) UNSIGNED NOT NULL,
  `sendemail_email` varchar(50) NOT NULL,
  `sendemail_label` varchar(255) NOT NULL,
  `sendemail_message` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('4caaa24341dcab16705a8aaadac3e3d70ba3fc9cd546150bd6c889776ef8cf77dbc7133c091ae1b3', 1, 1, 'auth_token', '[]', 0, '2023-11-18 19:41:38', '2023-11-18 19:41:38', '2024-11-18 20:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'WebEngine Personal Access Client', 'OpSZBF0MhN7mPGTE5eYHPlQPjYX5LPq06lOA7EPu', NULL, 'http://localhost', 1, 0, 0, '2023-11-18 19:40:26', '2023-11-18 19:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-11-18 19:40:26', '2023-11-18 19:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
  `identifier` varchar(32) NOT NULL,
  `rank` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `identifier`, `rank`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'MikiDani', 'miklosdani@protonmail.com', '2023-11-18 19:42:12', '$2y$10$QN0YCTXWf6AK6bs9qmFHeedLRXIRhYnVMmbT6nKotZ0Jgszq/j6.W', '44383616d6e174786ad43e646057e9ef', 1, 'TqmOooI9eubLeFPufyQe3byGJ9QqyFWZL9419iI3GZBHrquuNKje43eqQr5D', '2023-11-18 19:41:38', '2023-11-18 19:42:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menulist`
--
ALTER TABLE `menulist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menumodulelist`
--
ALTER TABLE `menumodulelist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menumodulelist_id_menulist_foreign` (`id_menulist`),
  ADD KEY `menumodulelist_id_moduletype_foreign` (`id_moduletype`);

--
-- Indexes for table `menumoduletype`
--
ALTER TABLE `menumoduletype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_news`
--
ALTER TABLE `module_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_news_id_menumodulelist_foreign` (`id_menumodulelist`);

--
-- Indexes for table `module_sendemail`
--
ALTER TABLE `module_sendemail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `module_sendemail_id_menumodulelist_foreign` (`id_menumodulelist`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

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
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menumodulelist`
--
ALTER TABLE `menumodulelist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menumoduletype`
--
ALTER TABLE `menumoduletype`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `module_news`
--
ALTER TABLE `module_news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `module_sendemail`
--
ALTER TABLE `module_sendemail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menumodulelist`
--
ALTER TABLE `menumodulelist`
  ADD CONSTRAINT `menumodulelist_id_menulist_foreign` FOREIGN KEY (`id_menulist`) REFERENCES `menulist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menumodulelist_id_moduletype_foreign` FOREIGN KEY (`id_moduletype`) REFERENCES `menumoduletype` (`id`);

--
-- Constraints for table `module_news`
--
ALTER TABLE `module_news`
  ADD CONSTRAINT `module_news_id_menumodulelist_foreign` FOREIGN KEY (`id_menumodulelist`) REFERENCES `menumodulelist` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `module_sendemail`
--
ALTER TABLE `module_sendemail`
  ADD CONSTRAINT `module_sendemail_id_menumodulelist_foreign` FOREIGN KEY (`id_menumodulelist`) REFERENCES `menumodulelist` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
