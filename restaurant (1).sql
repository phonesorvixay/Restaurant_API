-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 05, 2021 at 09:08 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(60) NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`c_id`, `c_name`) VALUES
(1, 'ເຄື່ອງດື່ມ'),
(3, 'ປະເພດທະເລ'),
(10, 'ປະເພດຊີ້ນ');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

DROP TABLE IF EXISTS `food`;
CREATE TABLE IF NOT EXISTS `food` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `f_name` varchar(60) NOT NULL,
  `price` double NOT NULL,
  `f_detail` text NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`f_id`, `c_id`, `f_name`, `price`, `f_detail`) VALUES
(3, 1, 'ໄກ່', 20000, 'no have'),
(4, 1, 'ອົບອ່ຽນ', 20000, 'no have'),
(5, 1, 'ອົບໝາ', 20000, 'no have'),
(6, 1, 'ປິ້ງແບ້', 20000, 'no have'),
(8, 3, 'ປາລາດພີກ', 50000, '');

-- --------------------------------------------------------

--
-- Table structure for table `list_order`
--

DROP TABLE IF EXISTS `list_order`;
CREATE TABLE IF NOT EXISTS `list_order` (
  `lo_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `lo_qty` int(11) NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`lo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `list_order`
--

INSERT INTO `list_order` (`lo_id`, `order_id`, `f_id`, `lo_qty`, `price`) VALUES
(3, 1, 3, 10, 2000000),
(4, 2, 3, 20, 59000000),
(5, 2, 3, 30, 4000000),
(6, 2, 3, 10, 2000000),
(7, 3, 3, 20, 59000000),
(8, 3, 3, 30, 4000000),
(9, 3, 3, 10, 2000000),
(10, 4, 3, 20, 59000000),
(11, 4, 3, 30, 4000000),
(12, 4, 3, 10, 2000000),
(13, 5, 3, 20, 59000000),
(14, 5, 3, 30, 4000000),
(15, 5, 3, 10225, 2000000),
(16, 9, 3, 20, 59000000),
(17, 1, 3, 20, 59000000),
(18, 1, 3, 20, 59000000),
(19, 6, 3, 20, 59000000),
(20, 6, 3, 30, 4000000),
(21, 6, 3, 10, 2000000),
(29, 8, 3, 1, 20000),
(36, 7, 3, 4, 20000),
(37, 9, 3, 1, 20000),
(38, 10, 3, 1, 20000),
(39, 11, 3, 1, 20000),
(40, 12, 4, 1, 20000),
(41, 13, 3, 1, 20000),
(42, 13, 5, 1, 20000),
(43, 14, 8, 4, 50000),
(44, 14, 5, 1, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `t_id`, `order_date`, `status`) VALUES
(1, 1, 2, '2021-05-11', 2),
(2, 1, 2, '2021-05-12', 0),
(3, 1, 2, '2021-05-13', 2),
(4, 1, 3, '2021-05-14', 2),
(5, 1, 3, '2021-05-15', 0),
(6, 1, 3, '2021-05-15', 0),
(7, 1, 4, '2021-05-15', 2),
(8, 4, 8, '2021-05-15', 2),
(9, 1, 8, '2021-05-16', 2),
(10, 1, 8, '2021-05-16', 2),
(11, 1, 8, '2021-05-16', 2),
(12, 6, 7, '2021-05-16', 0),
(13, 1, 6, '2021-05-16', 0),
(14, 4, 8, '2021-05-16', 2);

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

DROP TABLE IF EXISTS `table`;
CREATE TABLE IF NOT EXISTS `table` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` varchar(60) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`t_id`, `table_number`, `status`) VALUES
(2, 'ໂຕະ 7', 1),
(3, 'ໂຕະ 6', 0),
(4, 'ໂຕະ 5', 0),
(5, 'ໂຕະ 4', 0),
(6, 'ໂຕະ 3', 1),
(7, 'ໂຕະ 2', 1),
(8, 'ໂຕະ 1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL,
  `user_password` varchar(60) NOT NULL,
  `role` varchar(60) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `role`) VALUES
(1, 'admin', '123456', ''),
(6, 'thon', '1122', ''),
(8, 'brache', '123456789', ''),
(9, 'brachde', '123456789', ''),
(10, 'brdachde', '123456789', ''),
(11, 'brdac2hde', '123456789', ''),
(12, 'brd2ac2hde', '123456789', ''),
(13, 'brd22ac2hde', '123456789', ''),
(14, 'padmin', '1234567', ''),
(15, 'padmin2', '1234567', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
