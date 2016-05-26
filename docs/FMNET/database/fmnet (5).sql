-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 12, 2016 at 10:17 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fmnet`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`email`, `password`) VALUES
('fmnettester2016@gmail.com', '$2y$10$HLOJTNwXH8k3EWI3QSQ6mO0y0dTbj/39zOBdBMWR6/ehB6QCtO7ja');

-- --------------------------------------------------------

--
-- Table structure for table `bgm`
--

CREATE TABLE `bgm` (
  `shop_id` varchar(14) NOT NULL,
  `bgm_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `list_name` varchar(255) NOT NULL,
  `bgm_name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `content_length` int(11) NOT NULL,
  `del_flg` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bgm`
--

INSERT INTO `bgm` (`shop_id`, `bgm_id`, `playlist_id`, `list_name`, `bgm_name`, `filename`, `content_length`, `del_flg`) VALUES
('myshop', 1, 2035, 'aaa', 'test bgm', 'bgm.mp3', 12000, 0),
('myshop', 2, 2035, 'aaa', 'test bgm', 'bgm.mp3', 24000, 0),
('0', 3, 2088, 'aaaxxxx', 'test bgm 88', 'bgm991.mp3', 0, 0),
('myshop', 4, 2035, 'aaa', 'test bgm', 'bgm.mp3', 12000, 0),
('0', 9, 2088, 'zzzz', 'test bgm 999', 'bgm999.mp3', 0, 0),
('shop999', 10, 2099, 'zzzz777', 'test bgm 777', 'bgm777.mp3', 1200, 0),
('shop999', 11, 2099, 'aaaxxxx999', 'test bgm 99', 'bgm999.mp3', 600, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bgm_schedule`
--

CREATE TABLE `bgm_schedule` (
  `shop_id` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bgm_schedule_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `del_flg` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bgm_schedule`
--

INSERT INTO `bgm_schedule` (`shop_id`, `bgm_schedule_id`, `schedule_id`, `playlist_id`, `del_flg`) VALUES
('0', 1, 2020, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `daiban_voice`
--

CREATE TABLE `daiban_voice` (
  `shop_id` varchar(14) NOT NULL,
  `daiban_voice_id` int(11) NOT NULL,
  `file_url1` varchar(1000) NOT NULL,
  `file_url2` varchar(1000) NOT NULL,
  `filename1` varchar(255) NOT NULL COMMENT 'Nếu NULL thì là chưa ghi âm',
  `filename2` varchar(255) NOT NULL COMMENT 'Nếu NULL thì là chưa ghi âm',
  `del_flg` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `default_schedule`
--

CREATE TABLE `default_schedule` (
  `shop_id` varchar(14) NOT NULL,
  `default_schedule_id` int(11) NOT NULL,
  `day` int(2) NOT NULL COMMENT '0:日(Chủ nhật),1:月(T2),2:火(T3),3:水,4:木,5:金,6:土',
  `schedule_id` int(11) NOT NULL,
  `del_flg` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `normal_voice`
--

CREATE TABLE `normal_voice` (
  `shop_id` varchar(14) NOT NULL,
  `normal_voice_id` int(11) NOT NULL,
  `file_url` varchar(1000) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `del_flg` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `original_voice`
--

CREATE TABLE `original_voice` (
  `shop_id` varchar(14) NOT NULL,
  `daibango` int(11) NOT NULL,
  `file_url` varchar(1000) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `ketsuban_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:欠番(missing number)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `playlist`
--

CREATE TABLE `playlist` (
  `shop_id` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `playlist_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `playlist_total_time` int(11) NOT NULL,
  `del_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:normal; 1:deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlist`
--

INSERT INTO `playlist` (`shop_id`, `playlist_id`, `playlist_name`, `playlist_total_time`, `del_flg`) VALUES
('0', 2022, 'ececec', 36000, 0),
('myshop', 2021, 'ececec', 36000, 0),
('myshop', 2028, 'ececec', 36000, 0),
('myshop', 2030, 'ececec', 36000, 0),
('myshop', 2035, 'ececec', 36000, 0),
('shop999', 2088, 'test_playlist', 18000, 0),
('shop999', 2099, 'test_playlist777', 15000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `shop_id` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `del_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:normal; 1:deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`shop_id`, `schedule_id`, `display_name`, `open_time`, `close_time`, `del_flg`) VALUES
('myshop', 2020, 'test schedule', '10:00:00', '23:30:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `shop_id` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trial_period` datetime DEFAULT NULL,
  `premium_period` datetime DEFAULT NULL,
  `premium_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not yet member、1:premium member',
  `account_status` int(11) NOT NULL COMMENT '1:trial,2:expired,3:payment finished,4:during take-over,5:take-over finihsed',
  `register_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:normal; 1:deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`shop_id`, `shop_password`, `access_token`, `user_id`, `shop_name`, `trial_period`, `premium_period`, `premium_flag`, `account_status`, `register_date`, `del_flg`) VALUES
('000001', '25d55ad283aa400af464c76d713c07ad', NULL, 7, 'abc1', '2016-05-28 04:41:54', NULL, 0, 1, '2016-03-29 04:41:54', 0),
('123456', '25f9e794323b453885f5181f1b624d0b', '$2y$10$9H3s8bmlSptN1hkLHKwrCuNRKEzfA27FeDHLLDfMEnl3gNBnJ6b3q', 13, 'dfsdfsd', '2016-06-07 10:48:23', NULL, 0, 1, '2016-04-08 10:48:23', 0),
('12345699', '25d55ad283aa400af464c76d713c07ad', NULL, 15, 'fsdfdf', '2016-06-24 07:54:47', NULL, 0, 1, '2016-04-25 07:54:47', 0),
('ececeecece123', '25d55ad283aa400af464c76d713c07ad', NULL, 11, 'dfdsf fdsfds fdsf ', NULL, NULL, 0, 1, '2016-04-07 03:10:06', 0),
('eecceced', '25d55ad283aa400af464c76d713c07ad', NULL, 16, 'test shop', '2016-06-25 04:19:46', NULL, 0, 1, '2016-04-26 04:19:46', 0),
('eeeefcdcdcd', '25d55ad283aa400af464c76d713c07ad', NULL, 12, 'teset ', NULL, '2016-05-30 10:52:34', 1, 3, '2016-04-15 04:40:33', 0),
('fsdfstest', '25d55ad283aa400af464c76d713c07ad', NULL, 14, 'qfsdfsf', '2016-06-13 03:43:28', NULL, 0, 1, '2016-04-14 03:43:28', 0),
('myshop', '25d55ad283aa400af464c76d713c07ad', '$2y$10$Tn0Gpw5QhrOfMCrhPIPBm.v1PU1OjSmZ08r.ZjnXqb6MLlZ6JbwmW', 8, 'terst', '2016-05-30 11:00:39', NULL, 0, 1, '2016-03-31 11:00:39', 0),
('shop12345', '25d55ad283aa400af464c76d713c07ad', '$2y$10$WjoFmat.b4hVYai6zT0dUe9q4TZwqb1iZqWYfhF4fvOPcoUxTdhVW', 6, '654654654', '2016-05-24 11:02:23', NULL, 0, 1, '2016-03-25 11:02:23', 0),
('shop666', '25d55ad283aa400af464c76d713c07ad', NULL, 4, 'Family mart Dien Bien Phu BT', NULL, NULL, 0, 1, '2016-04-11 06:38:40', 0),
('shop777', 'd41d8cd98f00b204e9800998ecf8427e', '$2y$10$puyx5vyzsOMkDTOt7faDOOv064uxE5hQsmgjN5VxsU7brHcbtaVy.', 4, 'Farmily mart Dinh Tien Hoang', '2016-04-01 00:00:00', NULL, 0, 1, '0000-00-00 00:00:00', 0),
('shop888', '25d55ad283aa400af464c76d713c07ad', NULL, 4, 'Famiy mart Cách Mạng Tháng 8,quận 3', NULL, NULL, 0, 1, '2016-04-07 03:51:24', 0),
('shop999', '25d55ad283aa400af464c76d713c07ad', '$2y$10$12.qjk8LDpqhhcZQmFaR8u9MK71dN7/g6cisVGLHjvJBIkKoJHA9a', 4, 'Family mart To Hien Thanh', '2016-06-04 03:43:28', NULL, 0, 1, '2016-04-05 03:43:28', 0),
('testmyshop', 'cbdbee44359f265477c55b2e213dce18', NULL, 12, 'fdsfsdf', '2016-06-07 04:53:42', '2016-06-29 10:52:34', 1, 3, '2016-04-08 04:53:42', 0),
('testmyshop9999', '25d55ad283aa400af464c76d713c07ad', NULL, 11, 'fdsf', '2016-06-05 06:52:44', NULL, 0, 1, '2016-04-06 06:52:44', 0),
('testshop', '25d55ad283aa400af464c76d713c07ad', NULL, 10, 'dsfsdfdsf', '2016-06-05 03:18:17', NULL, 0, 1, '2016-04-06 03:18:17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `temp_registration`
--

CREATE TABLE `temp_registration` (
  `temp_registration_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_at` datetime NOT NULL,
  `used_flg` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未使用(not use)、1:本登録済(finished main register)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temp_registration`
--

INSERT INTO `temp_registration` (`temp_registration_id`, `email`, `uuid`, `expired_at`, `used_flg`) VALUES
(1, '', '', '0000-00-00 00:00:00', 0),
(2, '', '', '0000-00-00 00:00:00', 0),
(3, 'vuminhtri08@gmail.com', 'b984eaf1-b7fb-4436-b2aa-ef34dd16a5d0', '2016-03-18 09:52:07', 0),
(4, 'vuminhtri08@gmail.com', '5717614f-64ee-4f6e-afbe-063d46295700', '2016-03-18 09:52:23', 0),
(5, 'vuminhtri08@gmail.com', '9d7362df-2f1f-47c0-88ff-8ffd87d448e7', '2016-03-18 09:56:22', 0),
(6, '', 'b8c4bb30-f75f-491f-8d7c-c7a743e7003b', '2016-03-18 10:01:04', 0),
(7, 'vuminhtri08@gmail.com', '', '0000-00-00 00:00:00', 0),
(8, 'vuminhtri08@gmail.com', '95ca7f55-7f1f-45b9-a36f-ff6e5799b8a0', '2016-03-18 10:07:02', 0),
(9, 'vuminhtri08@gmail.com', '45e37696-0971-4846-be3a-b454aff56d95', '2016-03-18 10:28:14', 0),
(10, 'vuminhtri08@gmail.com', 'bd783cc2-467a-4abb-9a24-75895f39dbef', '2016-03-18 11:14:32', 0),
(11, 'aaa@ggg.cc', 'ad24ec1d-7541-4bf7-8099-8a2cf0203694', '2016-03-19 10:58:20', 0),
(12, 'aaa@ggg.cc', '3ac2f00d-53da-4919-80e0-2d159efff382', '2016-03-19 10:58:26', 0),
(13, 'aaa@ggg.cc', 'f4ca86b9-1d9f-46d1-834a-88c0c9423dce', '2016-03-19 10:58:29', 0),
(14, 'aaa@ggg.COM', '880f788f-05df-481f-a226-0dc41e5398f6', '2016-03-22 01:58:28', 0),
(15, 'vuminhtri@gmail.com', '0e28970b-2271-4df5-ad61-ec7b647cbc9c', '2016-03-22 02:06:25', 0),
(16, 'testtests@gmail.com', 'a2cc3527-6a9d-4e8f-9d24-c7a9ac505362', '2016-03-22 02:26:09', 0),
(17, 'testtests@gmail.com', 'cdbd7e29-3062-454a-9bb0-7f2ecc988429', '2016-03-22 02:31:55', 0),
(18, 'vuminhtri08@gmail.com', '73bb9aec-24e5-4d1d-92a3-f5d831447c46', '2016-03-22 06:17:19', 0),
(19, 'vuminhtri08@gmail.com', 'a8c9505f-a06c-4fc2-9e87-55f1d8734b00', '2016-03-22 06:19:28', 0),
(20, 'vuminhtri08@gmail.com', '7a03b742-145f-4abe-a170-4b1fcb3c193e', '2016-03-22 06:24:27', 0),
(21, 'test999test@gmail.com', '153d163e-20b0-4fe3-8570-7641da073c2a', '2016-03-24 03:35:35', 0),
(22, 'ththanh17@gmail.com', 'e2db33ac-1f11-47c5-a7e5-1f6ed7920cf7', '2016-03-24 03:40:09', 0),
(23, 'thuanngo1990@gmail.com', '16e2bc33-28fd-40ce-a2cf-0daba646e5e8', '2016-03-24 10:34:30', 0),
(24, 'vuminhtri08+1@gmail.com', 'fe4fec64-8bef-435b-829f-f323ad41b40f', '2016-03-25 10:41:27', 0),
(25, 'ththanh17@gmail.com', '3f58e31a-6fd5-4209-8608-567f1fb3e303', '2016-03-26 02:12:23', 0),
(26, 'vuminhtri08+08@gmail.com', '310af9ce-35d0-4b10-9d40-67a8147807e2', '2016-03-26 08:41:01', 0),
(27, 'vuminhtri08+33@gmail.com', '13cc190a-cf4b-4ce0-a5cc-9326d2473a1a', '2016-03-26 10:17:44', 0),
(28, 'vuminhtri08+33@gmail.com', '92c82072-7219-4def-b824-0abf0e6c27eb', '2016-03-26 10:17:46', 1),
(29, 'vuminhtri08+335@gmail.com', '4a5f341e-003d-4189-8ef6-01c4eb0d6701', '2016-03-26 10:21:36', 1),
(30, 'ththanh17@gmail.com', '4643579e-f9a4-4b89-a2e9-0e86aa16e825', '2016-03-26 10:28:21', 1),
(31, 'vuminhtri08+33532@gmail.com', '99b6fdb8-e231-411c-9b29-442a7ece4b6e', '2016-03-26 10:54:31', 1),
(32, 'ththanh17+1@gmail.com', 'e3a76e45-9bd0-44d1-b704-34b4461cdb08', '2016-03-26 11:00:27', 1),
(33, 'nhhatphuong171288@gmail.com', '1cc4b661-e722-43bd-af81-64e641c52bcd', '2016-03-30 04:21:11', 0),
(34, 'nhatphuong171288@gmail.com', 'b2a453a7-cf7a-4dae-9f54-1581df47d4e6', '2016-03-30 04:23:36', 1),
(35, 'nhatphuong171288@gmail.com', 'cff2d7b1-eefe-4da4-a4e9-f172da830833', '2016-03-30 04:24:35', 0),
(36, 'nhatphuong171288@gmail.com', 'f2c5daeb-dca1-4323-af4e-7d1367c037ae', '2016-03-30 04:26:36', 0),
(37, 'vuminhtri08+1234@gmail.com', 'b827ddfb-4785-4ceb-8337-eba8df01d6b6', '2016-03-30 07:29:32', 0),
(38, 'vuminhtri08+279@gmail.com', '228bb4aa-1398-4df2-a809-c13762851302', '2016-03-30 07:35:04', 0),
(39, 'vuminhtri08+11234@gmail.com', 'a11115e1-8ad3-4f09-a742-6668352281f5', '2016-04-01 10:56:26', 1),
(40, 'ththanh17+2@gmail.com', 'd9f9e212-0ef3-4064-b390-3335fc249a0d', '2016-04-06 03:28:11', 1),
(41, 'vuminhtri08@gmail.com', '560e9ecd-c9c9-4d88-b3db-1bfb60c8cc39', '2016-04-07 03:13:20', 0),
(42, 'vuminhtri08@gmail.com', 'e3d6e320-8f66-4b72-a586-eca2acca864f', '2016-04-07 03:13:22', 1),
(43, 'vuminhtri08+111@gmail.com', 'ba9436c3-0bda-4a16-be47-f621d862af75', '2016-04-07 06:52:09', 1),
(44, 'vuminhtri08@gmail.com', 'ef53fe38-a5b0-44dd-840c-6abb4b0a56ec', '2016-04-09 04:47:15', 1),
(45, 'vuminhtri08+279@gmail.com', 'f7a2f5eb-ba9c-49dd-b5ee-f74f665812ef', '2016-04-09 10:47:52', 1),
(46, 'vuminhtri08+2709@gmail.com', 'df0e021d-2277-477c-9a09-859d3d33f357', '2016-04-15 03:42:44', 1),
(47, 'vuminhtri09@gmail.com', 'd37c7f19-7ab7-4e3b-85e6-4fbb1ad6cc0f', '2016-04-23 06:30:03', 0),
(48, 'vuminhtri09@gmail.com', '5bfb4025-f725-4b2a-9179-6219c10bb554', '2016-04-23 07:38:55', 0),
(49, 'vuminhtri08+777@gmail.com', 'e075f72d-7696-47b1-b17f-938efa29a032', '2016-04-26 07:53:38', 1),
(50, 'vuminhtri08+3351@gmail.com', '61f1778d-b8f6-47c5-89c9-e501b841915f', '2016-04-26 08:01:02', 0),
(51, 'vuminhtri08+33335@gmail.com', '023d45a8-6a1f-4e48-a742-185a47074f97', '2016-04-26 08:04:10', 0),
(52, 'vuminhtri08+8888@gmail.com', 'bc502cef-dc34-4f14-9610-fd0837066405', '2016-04-27 04:18:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `timed_schedule`
--

CREATE TABLE `timed_schedule` (
  `shop_id` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timed_schedule_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `normal_voice_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `stop_time` time NOT NULL,
  `del_flg` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timed_schedule`
--

INSERT INTO `timed_schedule` (`shop_id`, `timed_schedule_id`, `schedule_id`, `playlist_id`, `normal_voice_id`, `start_time`, `stop_time`, `del_flg`) VALUES
('0', 1, 2020, 2, 1, '10:00:00', '23:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payer_kana` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_pay_date` datetime DEFAULT NULL,
  `last_pay_date` datetime DEFAULT NULL,
  `next_pay_amount` int(11) DEFAULT NULL,
  `basic_plan_id` int(11) NOT NULL DEFAULT '1' COMMENT ' 1:１ヶ月, 2:１年',
  `payment_method` int(11) NOT NULL DEFAULT '1' COMMENT '1: 振り込み(chuyển khoản), 2:クレジットカード(credit card)',
  `register_date` datetime NOT NULL,
  `temp_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temp_email_expired_at` datetime DEFAULT NULL,
  `credit_card_customer_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT ' この情報をもとにクレジットカード決済を行う',
  `credit_card_rec_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `memo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `del_flg` tinyint(1) NOT NULL COMMENT '0:normal; 1:deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `company_name`, `user_name`, `tel`, `payer`, `payer_kana`, `next_pay_date`, `last_pay_date`, `next_pay_amount`, `basic_plan_id`, `payment_method`, `register_date`, `temp_email`, `temp_email_expired_at`, `credit_card_customer_id`, `credit_card_rec_id`, `memo`, `del_flg`) VALUES
(4, 'ththanh17333@gmail.com', '$2y$10$Bg7/ryX3SsbVDHa6PhF/mue/0jT/wj1WrfbrXk30Ey2U4PMTSCELK', '担当者名', 'Huy Thanh', '0833334444', '', '', '2016-05-25 00:00:00', NULL, NULL, 1, 0, '2016-03-25 10:38:43', '', '0000-00-00 00:00:00', '', '', '', 0),
(6, 'ththanh17+1@gmail.com', '$2y$10$JNlErAF8mQZnmCH3tnCYcOMmuSlVnr5XgcalL1o/9MhCeWe251.mi', 'name 111111', '', NULL, NULL, NULL, '2016-05-18 00:00:00', NULL, NULL, 2, 0, '2016-03-25 11:02:23', '', '0000-00-00 00:00:00', '', '', '', 0),
(7, 'nhatphuong171288@gmail.com', '$2y$10$W9w0bn/7CeQU5uFhHNTZoOzfKGXcDRfUZCGItdafRcSOAaiCu07Qi', 'abc""","",', 'dfdsfdsf', '', '', '', '0000-00-00 00:00:00', NULL, 0, 1, 0, '2016-03-29 04:41:54', '', '0000-00-00 00:00:00', '', '', '', 0),
(9, 'ththanh17+2@gmail.com', '$2y$10$doMl0Dnz3pRedbd3usLFAu3sCh6v0mX6nc42cVmsnuod8ikypf2Zu', 'BSV', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2016-04-05 03:43:28', '', '0000-00-00 00:00:00', '', '', '', 0),
(12, 'vuminhtri08@gmail.com', '$2y$10$nJsvP7Go18pe8q1WG7NdBON12.1m5lN2D5YMbJp8zkZ2y70eM7Z7C', '会社名', '担当者名', '2323233', '振込者名義', '振込者名義カナ', '2016-05-17 00:00:00', '2016-04-30 10:52:34', 2324, 2, 2, '2016-04-08 04:53:42', NULL, NULL, 'cus_21h1YY1Vdb328aU', 'rec_2lV4SpfTYdwmexf', '', 0),
(13, 'vuminhtri08+279@gmail.com', '$2y$10$kdodHFXDhFMyyKyxt5DA4uVS7RM33gZVc.LM60GcF3h7fahNzSL3K', 'dfsdf', 'dfsfsdf', NULL, NULL, NULL, '2016-05-18 00:00:00', NULL, NULL, 1, 1, '2016-04-08 10:48:23', NULL, NULL, '', '', '', 0),
(14, 'vuminhtri08+2709@gmail.com', '$2y$10$R6Lh/pSXc7dfDm.1VSvLR.e.ZmPnuAQv0.DFmMTQhGu.ylBFzh4dW', 'fsdfsdf', 'fdsfsa', '', '', '', '0000-00-00 00:00:00', NULL, NULL, 1, 1, '2016-04-14 03:43:28', NULL, NULL, '', '', 'fdsfdsf\r\nfd\r\nfd\r\nfd\r\n', 0),
(15, 'vuminhtri08+777@gmail.com', '$2y$10$UUdHS2YsyCM0pJpwYRpG.eVWS7t5e5IpwHE1cj4fQU52jZ8d0j.qe', '', 'fdsf', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2016-04-25 07:54:47', NULL, NULL, '', '', '', 0),
(16, 'vuminhtri08+8888@gmail.com', '$2y$10$eC7S04T4J7sZ77ZuaP9t5ushQ/AemRSMKHoXCKTP4z5dzO0pXq5T.', '', 'fdf', '', '', '', '2016-05-18 00:00:00', NULL, NULL, 1, 1, '2016-04-26 04:19:46', NULL, NULL, '', '', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bgm`
--
ALTER TABLE `bgm`
  ADD PRIMARY KEY (`bgm_id`,`shop_id`);

--
-- Indexes for table `bgm_schedule`
--
ALTER TABLE `bgm_schedule`
  ADD PRIMARY KEY (`shop_id`,`bgm_schedule_id`);

--
-- Indexes for table `daiban_voice`
--
ALTER TABLE `daiban_voice`
  ADD PRIMARY KEY (`daiban_voice_id`,`shop_id`);

--
-- Indexes for table `default_schedule`
--
ALTER TABLE `default_schedule`
  ADD PRIMARY KEY (`default_schedule_id`,`shop_id`);

--
-- Indexes for table `normal_voice`
--
ALTER TABLE `normal_voice`
  ADD PRIMARY KEY (`normal_voice_id`,`shop_id`);

--
-- Indexes for table `original_voice`
--
ALTER TABLE `original_voice`
  ADD PRIMARY KEY (`daibango`,`shop_id`);

--
-- Indexes for table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`shop_id`,`playlist_id`),
  ADD UNIQUE KEY `shop_id` (`shop_id`,`playlist_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`,`shop_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`shop_id`),
  ADD UNIQUE KEY `shop_id` (`shop_id`);

--
-- Indexes for table `temp_registration`
--
ALTER TABLE `temp_registration`
  ADD PRIMARY KEY (`temp_registration_id`);

--
-- Indexes for table `timed_schedule`
--
ALTER TABLE `timed_schedule`
  ADD PRIMARY KEY (`timed_schedule_id`,`shop_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `temp_registration`
--
ALTER TABLE `temp_registration`
  MODIFY `temp_registration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
