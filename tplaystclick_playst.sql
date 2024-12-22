-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 17, 2024 lúc 05:04 AM
-- Phiên bản máy phục vụ: 10.5.26-MariaDB
-- Phiên bản PHP: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tplaystclick_playst`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `authme`
--

CREATE TABLE `authme` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `realname` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `ip` varchar(40) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `lastlogin` bigint(20) DEFAULT NULL,
  `x` double NOT NULL DEFAULT 0,
  `y` double NOT NULL DEFAULT 0,
  `z` double NOT NULL DEFAULT 0,
  `world` varchar(255) NOT NULL DEFAULT 'world',
  `regdate` bigint(20) NOT NULL DEFAULT 0,
  `regip` varchar(40) CHARACTER SET ascii COLLATE ascii_bin DEFAULT NULL,
  `yaw` float DEFAULT NULL,
  `pitch` float DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `isLogged` smallint(6) NOT NULL DEFAULT 0,
  `hasSession` smallint(6) NOT NULL DEFAULT 0,
  `totp` varchar(32) DEFAULT NULL,
  `uuid` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dotman_config`
--

CREATE TABLE `dotman_config` (
  `key` varchar(64) NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dotman_napthe_log`
--

CREATE TABLE `dotman_napthe_log` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `uuid` char(36) NOT NULL,
  `seri` varchar(20) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `success` tinyint(4) NOT NULL DEFAULT 0,
  `waiting` tinyint(4) NOT NULL DEFAULT 0,
  `server` varchar(32) NOT NULL DEFAULT 'web',
  `pointsnhan` int(11) NOT NULL DEFAULT 0,
  `thucnhan` int(11) NOT NULL DEFAULT 0,
  `transaction_id` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dotman_player_data`
--

CREATE TABLE `dotman_player_data` (
  `uuid` char(36) NOT NULL,
  `name` varchar(32) NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` int(11) NOT NULL DEFAULT 0,
  `last_updated` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dotman_player_info`
--

CREATE TABLE `dotman_player_info` (
  `uuid` char(36) NOT NULL,
  `name` varchar(32) NOT NULL,
  `last_updated` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dotman_point_log`
--

CREATE TABLE `dotman_point_log` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `uuid` char(36) NOT NULL,
  `amount` int(11) NOT NULL,
  `point_from` int(11) NOT NULL,
  `point_to` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `server` varchar(32) NOT NULL DEFAULT 'web',
  `content` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `freegems_info`
--

CREATE TABLE `freegems_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `turns` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `link_logs`
--

CREATE TABLE `link_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `used` tinyint(1) DEFAULT 0,
  `create_time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` text NOT NULL,
  `nation` text NOT NULL,
  `source` text NOT NULL,
  `create_time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `recharge_logs`
--

CREATE TABLE `recharge_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trans_id` text NOT NULL,
  `amount` text DEFAULT NULL,
  `amount2` text DEFAULT NULL,
  `gems` text NOT NULL,
  `method` text NOT NULL,
  `status` text NOT NULL,
  `create_time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` mediumint(8) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'host_rcon', 'host_rcon'),
(2, 'port_rcon', 'port_rcon'),
(3, 'pass_rcon', 'pass_rcon'),
(4, 'timeout_rcon', '3'),
(5, 'card_partner_id', 'card_partner_id'),
(6, 'card_partner_key', 'card_partner_key'),
(7, 'discord_webhook_recharge_bank', 'discord_webhook_recharge_bank'),
(8, 'api_link', 'api_link'),
(9, 'api_sepay', 'api_sepay');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tong_nap`
--

CREATE TABLE `tong_nap` (
  `user_id` int(11) NOT NULL,
  `tongnap` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vong_quay`
--

CREATE TABLE `vong_quay` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `percent` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `authme`
--
ALTER TABLE `authme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `dotman_config`
--
ALTER TABLE `dotman_config`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `dotman_napthe_log`
--
ALTER TABLE `dotman_napthe_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dotman_napthe_log_uuid_index` (`uuid`);

--
-- Chỉ mục cho bảng `dotman_player_data`
--
ALTER TABLE `dotman_player_data`
  ADD UNIQUE KEY `DOTMAN_PLAYER_DATA_PK` (`uuid`,`key`);

--
-- Chỉ mục cho bảng `dotman_player_info`
--
ALTER TABLE `dotman_player_info`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `dotman_player_info_name_index` (`name`);

--
-- Chỉ mục cho bảng `dotman_point_log`
--
ALTER TABLE `dotman_point_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dotman_point_log_uuid_index` (`uuid`);

--
-- Chỉ mục cho bảng `freegems_info`
--
ALTER TABLE `freegems_info`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `link_logs`
--
ALTER TABLE `link_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `recharge_logs`
--
ALTER TABLE `recharge_logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tong_nap`
--
ALTER TABLE `tong_nap`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `vong_quay`
--
ALTER TABLE `vong_quay`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `authme`
--
ALTER TABLE `authme`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dotman_napthe_log`
--
ALTER TABLE `dotman_napthe_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dotman_point_log`
--
ALTER TABLE `dotman_point_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `freegems_info`
--
ALTER TABLE `freegems_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `link_logs`
--
ALTER TABLE `link_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `recharge_logs`
--
ALTER TABLE `recharge_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
