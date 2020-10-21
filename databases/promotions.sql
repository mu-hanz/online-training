-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2020 at 03:02 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlinetraining1`
--

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `promotions_id` int(5) NOT NULL,
  `type` varchar(20) NOT NULL,
  `type_voucher` varchar(20) NOT NULL,
  `promotions_name` varchar(25) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `promotions_content` text NOT NULL,
  `promotions_image` varchar(100) NOT NULL,
  `promotions_code` varchar(10) NOT NULL,
  `area_display_voucher` varchar(20) NOT NULL,
  `collected_voucher_date` datetime NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `valid_on` varchar(15) NOT NULL,
  `limit_promotion` int(5) NOT NULL,
  `limit_user` int(5) NOT NULL,
  `limit_user_referral` int(5) DEFAULT 0,
  `amount_discount_referral` int(20) DEFAULT 0,
  `type_discount_referral` varchar(15) DEFAULT NULL,
  `status` varchar(15) NOT NULL,
  `status_delete` int(2) NOT NULL,
  `edited_by` int(3) NOT NULL,
  `edited_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promotions_id`, `type`, `type_voucher`, `promotions_name`, `slug`, `promotions_content`, `promotions_image`, `promotions_code`, `area_display_voucher`, `collected_voucher_date`, `start_date`, `end_date`, `valid_on`, `limit_promotion`, `limit_user`, `limit_user_referral`, `amount_discount_referral`, `type_discount_referral`, `status`, `status_delete`, `edited_by`, `edited_date`) VALUES
(69, 'voucher', 'Collectible', 'Voucher 1x', '', '', '', '', '', '2020-08-23 00:00:00', '2020-05-01 12:00:00', '2020-09-30 12:00:00', 'Training', 10, 10, 0, 0, '', 'On Progress', 0, 1, '2020-08-23 19:19:57'),
(70, 'flexi_combo', '', 'Flexi Combo 1x', '', '', '', '', '', '0000-00-00 00:00:00', '2020-05-21 12:00:00', '2020-10-31 12:00:00', 'All Training', 10, 10, 2, 0, 'Custom', 'On Progress', 1, 1, '2020-08-08 18:56:34'),
(72, 'campaign', '', 'Campaign A', 'campaign-a', 'Promo Flexi Combo beli banyak makin banyak potongan harganya.', '', '', '', '0000-00-00 00:00:00', '2020-10-01 12:00:00', '2020-10-31 12:00:00', 'Training', 0, 0, 0, 0, '', 'On Progress', 0, 1, '2020-10-20 20:14:04'),
(79, 'campaign', '', 'Campaign C', 'campaign-c', 'Promo Flexi Combo beli banyak makin banyak potongan harganya.', '', '', '', '0000-00-00 00:00:00', '2020-08-06 12:00:00', '2020-08-27 12:00:00', 'Training', 0, 0, 0, 0, '', 'On Progress', 0, 1, '2020-08-20 07:23:17'),
(80, 'voucher', 'Code Voucher', 'Kode 1', '', '', '', '1234566', '', '0000-00-00 00:00:00', '2020-10-05 12:00:00', '2020-10-31 12:00:00', 'All Training', 100, 1, 0, 0, '', 'On Progress', 0, 2, '2020-10-06 03:00:33'),
(81, 'voucher', 'Code Voucher', 'Coba Voucher', '', '', '', '123456', '', '0000-00-00 00:00:00', '2020-10-01 00:00:00', '2020-10-31 12:00:00', 'All Training', 100, 1, 0, 0, '', 'On Progress', 0, 21, '2020-10-12 13:52:15'),
(82, 'voucher', 'Code Voucher', 'Coba Voucher Persen', '', '', '', 'PERSEN', '', '0000-00-00 00:00:00', '2020-10-01 12:00:00', '2020-10-31 12:00:00', 'All Training', 10, 1, 0, 0, '', 'On Progress', 0, 1, '2020-10-12 16:14:14'),
(83, 'flexi_combo', '', 'Coba Flexi', '', '', '', '', '', '0000-00-00 00:00:00', '2020-10-01 12:00:00', '2020-10-31 12:00:00', 'All Training', 10, 1, NULL, 0, NULL, 'On Progress', 0, 1, '2020-10-13 15:58:02'),
(84, 'flexi_combo', '', 'Coba Flexi 2', '', '', '', '', '', '0000-00-00 00:00:00', '2020-10-13 12:00:00', '2020-10-31 12:00:00', 'Training', 5, 5, NULL, 0, NULL, 'On Progress', 1, 1, '2020-10-13 15:15:45'),
(85, 'flexi_combo', '', 'asd', '', '', '', '', '', '0000-00-00 00:00:00', '2020-10-13 12:00:00', '2020-10-31 12:00:00', 'Training', 5, 5, NULL, 0, NULL, 'On Progress', 1, 1, '2020-10-13 15:20:27'),
(86, 'flexi_combo', '', 'ce', '', '', '', '', '', '0000-00-00 00:00:00', '2020-10-13 12:00:00', '2020-10-31 12:00:00', 'Training', 5, 5, NULL, 0, NULL, 'On Progress', 1, 1, '2020-10-13 15:24:08'),
(87, 'flexi_combo', '', 'tr', '', '', '', '', '', '0000-00-00 00:00:00', '2020-10-13 12:00:00', '2020-10-31 12:00:00', 'Training', 2, 2, NULL, 0, NULL, 'On Progress', 1, 1, '2020-10-13 15:25:41'),
(88, 'flexi_combo', '', 'Coba Flexi 3', '', '', '', '', '', '0000-00-00 00:00:00', '2020-10-13 12:00:00', '2020-10-31 12:00:00', 'Training', 5, 5, NULL, 0, NULL, 'On Progress', 0, 1, '2020-10-13 15:58:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`promotions_id`),
  ADD KEY `promotions_code` (`promotions_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `promotions_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
