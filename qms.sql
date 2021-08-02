-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jul 15, 2021 at 04:17 AM
-- Server version: 8.0.25
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qms`
--

-- --------------------------------------------------------

--
-- Table structure for table `authorization_codes`
--

CREATE TABLE `authorization_codes` (
  `authorization_code` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `redirect_uri` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `expires` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scope` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_token` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
('20210610022517'),
('20210610041044'),
('20210610042044'),
('20210610042047'),
('20210610042048'),
('20210610042050'),
('20210610042053'),
('20210610044940'),
('20210610045001'),
('20210611023533'),
('20210611024244'),
('20210611024405'),
('20210617033806'),
('20210621031311');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `expires` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scope` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`access_token`, `client_id`, `user_id`, `expires`, `scope`) VALUES
('08692b00a9b071ec1452fc8ee56dcd3eac10f943', 'qms-web', 'xtendlobby', '2021-06-11 16:20:32', NULL),
('73e5c2f5969b27d1c6c0d2d58cfa71d5b1a29b1b', 'qms-web', 'xtendlobby', '2022-06-11 15:27:27', NULL),
('82d3d6ae43f78de3741698a35749ffef892de456', 'qms-web', 'xtendlobby', '2021-06-11 16:21:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_secret` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `grant_types` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `scopes` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scopes`, `user_id`) VALUES
('qms-web', '$2y$12$pmKBYqH85tk2OGa3rH6psexBZP2/W9OQeet8YqjXRSJGc218DZXlO', '/oauth/receivecode', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_jwt`
--

CREATE TABLE `oauth_jwt` (
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_key` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `expires` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scope` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_refresh_tokens`
--

INSERT INTO `oauth_refresh_tokens` (`refresh_token`, `client_id`, `user_id`, `expires`, `scope`) VALUES
('08d00a3eaa94c53de8442231ab8b53bec49981ee', 'qms-web', 'xtendlobby', '2021-06-24 14:47:09', NULL),
('1124ba01fcc5558c48884067392058a593ec21a5', 'qms-web', 'xtendlobby', '2021-06-25 15:17:44', NULL),
('5bf6d92a22c308f5f59207a3e75d4dd115233441', 'qms-web', 'xtendlobby', '2021-06-25 15:27:27', NULL),
('8803db57d7ec4206c94a136b3b7af606e15debd6', 'qms-web', 'xtendlobby', '2021-06-25 15:21:17', NULL),
('99c8652c9100e2bea8c9b28aaad83f4ce3540f41', 'qms-web', 'xtendlobby', '2021-06-24 14:26:11', NULL),
('db97862f7dfbd85f30d8a14a1e228c06ea299780', 'qms-web', 'xtendlobby', '2021-06-25 15:20:32', NULL),
('ea08951d22747a801dccb1d778a3045a6c5cb33a', 'qms-web', 'xtendlobby', '2021-06-24 14:24:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_scopes`
--

CREATE TABLE `oauth_scopes` (
  `id` int NOT NULL,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'supported',
  `scope` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `client_id` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_default` smallint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_users`
--

CREATE TABLE `oauth_users` (
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(2000) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth_users`
--

INSERT INTO `oauth_users` (`username`, `password`, `first_name`, `last_name`) VALUES
('xtendlobby', '$2y$10$Zr1SB2.EfDxVjk9z9u/3fOM1GrTUp7RrmFE0kNL60kCpvv6pTdTSq', 'Xtend', 'Lobby');

-- --------------------------------------------------------

--
-- Table structure for table `queue_devices`
--

CREATE TABLE `queue_devices` (
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `site_uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `queue_devices`
--

INSERT INTO `queue_devices` (`uuid`, `site_uuid`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
('809b1897-41f1-441d-8c81-c3fe6dfbb7de', '4132b069-c116-4ecb-9468-a71e4364f7f6', 'XTend Lobby', NULL, '2021-06-11 05:10:01', '2021-06-11 05:10:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queue_logs`
--

CREATE TABLE `queue_logs` (
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `device_uuid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `counter_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `reserved_time` datetime NOT NULL,
  `called_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `processing_time` double DEFAULT NULL,
  `waiting_time` double DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `queue_logs`
--

INSERT INTO `queue_logs` (`uuid`, `device_uuid`, `number`, `counter_number`, `reserved_time`, `called_time`, `end_time`, `processing_time`, `waiting_time`, `created_at`, `updated_at`, `deleted_at`) VALUES
('ccd8fac8-d890-11eb-952f-0242ac130002', '809b1897-41f1-441d-8c81-c3fe6dfbb7de', '1001', '10', '2021-06-29 08:02:00', '2021-06-29 08:03:00', '2021-06-29 08:03:00', 0, 1, '2021-06-29 11:16:38', '2021-06-29 11:16:43', NULL),
('cf70ac85-d890-11eb-952f-0242ac130002', '809b1897-41f1-441d-8c81-c3fe6dfbb7de', '1002', '10', '2021-06-29 08:02:00', '2021-06-29 08:03:00', '2021-06-29 08:03:00', 0, 1, '2021-06-29 11:16:43', '2021-06-29 11:16:46', NULL),
('d1258cc4-d890-11eb-952f-0242ac130002', '809b1897-41f1-441d-8c81-c3fe6dfbb7de', '1003', '10', '2021-06-29 08:02:00', '2021-06-29 08:03:00', '2021-06-29 08:03:00', 0, 1, '2021-06-29 11:16:46', '2021-06-29 11:16:50', NULL),
('d3aa2e09-d890-11eb-952f-0242ac130002', '809b1897-41f1-441d-8c81-c3fe6dfbb7de', '1004', '10', '2021-06-29 08:02:00', '2021-06-29 08:03:00', NULL, NULL, 1, '2021-06-29 11:16:50', '2021-06-29 11:16:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queue_log_daily_summaries`
--

CREATE TABLE `queue_log_daily_summaries` (
  `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `device_uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `counter_number` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `total_queue` int NOT NULL DEFAULT '0',
  `avg_processing_time` double NOT NULL DEFAULT '0',
  `avg_waiting_time` double NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `queue_log_daily_summaries`
--

INSERT INTO `queue_log_daily_summaries` (`uuid`, `device_uuid`, `counter_number`, `date`, `total_queue`, `avg_processing_time`, `avg_waiting_time`, `created_at`, `updated_at`, `deleted_at`) VALUES
('2e374dfa-d897-11eb-952f-0242ac130002', '809b1897-41f1-441d-8c81-c3fe6dfbb7de', '10', '2021-06-29', 3, 0, 1, '2021-06-29 12:02:19', '2021-06-29 12:02:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queue_sites`
--

CREATE TABLE `queue_sites` (
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `queue_sites`
--

INSERT INTO `queue_sites` (`uuid`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
('4132b069-c116-4ecb-9468-a71e4364f7f6', 'XTend Indonesia', NULL, '2021-06-11 05:09:23', '2021-06-11 05:09:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_accounts`
--

CREATE TABLE `user_accounts` (
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_reset_passwords`
--

CREATE TABLE `user_reset_passwords` (
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `expiration` datetime NOT NULL,
  `reseted` datetime DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authorization_codes`
--
ALTER TABLE `authorization_codes`
  ADD PRIMARY KEY (`authorization_code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`access_token`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_jwt`
--
ALTER TABLE `oauth_jwt`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`refresh_token`);

--
-- Indexes for table `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_users`
--
ALTER TABLE `oauth_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `queue_devices`
--
ALTER TABLE `queue_devices`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `queue_device_site_idx` (`site_uuid`);

--
-- Indexes for table `queue_logs`
--
ALTER TABLE `queue_logs`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `queue_log_device_idx` (`device_uuid`),
  ADD KEY `queue_log_number_idx` (`number`),
  ADD KEY `queue_log_counter_number_idx` (`counter_number`),
  ADD KEY `queue_log_reserved_time_idx` (`reserved_time`);

--
-- Indexes for table `queue_log_daily_summaries`
--
ALTER TABLE `queue_log_daily_summaries`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `daily_summary_device_idx` (`device_uuid`),
  ADD KEY `daily_summary_counter_idx` (`counter_number`),
  ADD KEY `daily_summary_date_idx` (`date`);

--
-- Indexes for table `queue_sites`
--
ALTER TABLE `queue_sites`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `user_username_idx` (`username`),
  ADD KEY `user_email_idx` (`email`),
  ADD KEY `user_phone_idx` (`phone`),
  ADD KEY `user_name_idx` (`name`);

--
-- Indexes for table `user_reset_passwords`
--
ALTER TABLE `user_reset_passwords`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `user_email_idx` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oauth_scopes`
--
ALTER TABLE `oauth_scopes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `queue_devices`
--
ALTER TABLE `queue_devices`
  ADD CONSTRAINT `queue_device_sites_fk` FOREIGN KEY (`site_uuid`) REFERENCES `queue_sites` (`uuid`) ON UPDATE CASCADE;

--
-- Constraints for table `queue_logs`
--
ALTER TABLE `queue_logs`
  ADD CONSTRAINT `queue_log_device_fk` FOREIGN KEY (`device_uuid`) REFERENCES `queue_devices` (`uuid`) ON UPDATE CASCADE;

--
-- Constraints for table `queue_log_daily_summaries`
--
ALTER TABLE `queue_log_daily_summaries`
  ADD CONSTRAINT `daily_summary_device_fk` FOREIGN KEY (`device_uuid`) REFERENCES `queue_devices` (`uuid`) ON UPDATE CASCADE;

--
-- Constraints for table `user_accounts`
--
ALTER TABLE `user_accounts`
  ADD CONSTRAINT `user_oauth_users_fk` FOREIGN KEY (`username`) REFERENCES `oauth_users` (`username`) ON UPDATE CASCADE;

--
-- Constraints for table `user_reset_passwords`
--
ALTER TABLE `user_reset_passwords`
  ADD CONSTRAINT `user_reset_oauth_users_fk` FOREIGN KEY (`email`) REFERENCES `oauth_users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
