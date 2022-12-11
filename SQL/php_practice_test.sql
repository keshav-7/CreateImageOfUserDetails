-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2022 at 05:53 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_practice_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_pool`
--

CREATE TABLE `email_pool` (
  `id` int(11) NOT NULL,
  `user_name` varchar(20) DEFAULT NULL,
  `attachement` varchar(45) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `sent_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_pool`
--

INSERT INTO `email_pool` (`id`, `user_name`, `attachement`, `status`, `sent_time`) VALUES
(1, 'keshav', 'keshav63958bfb716b8.png', 1, '2022-12-10 23:51:25'),
(2, 'keshav', 'keshav63958c642002e.png', 1, '2022-12-10 23:53:10'),
(3, 'keshav', 'keshav63958ea073112.png', 1, '2022-12-11 00:02:42'),
(4, 'aman', 'aman63960f4c3b424.png', 1, '2022-12-11 22:41:42'),
(5, 'virat', 'virat63960f63764c9.png', 1, '2022-12-11 22:42:05'),
(6, 'anuj', 'anuj639613a885555.png', 1, '2022-12-11 23:00:16'),
(7, 'Neha', 'Neha639615c2cf505.png', 1, '2022-12-11 23:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `telephone` varchar(12) DEFAULT NULL,
  `picture` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `fname`, `lname`, `email`, `password`, `gender`, `telephone`, `picture`) VALUES
(16, 'keshav', 'kumar', 'keshav@gmail.com', 'dsfrtr5y54', 'm', '5646675567', '1615795942812.jpg'),
(17, 'aman', 'gupta', 'aman@gupta.im', 'rgtry65645', 'm', '5676768678', 'meitsaman1.jpg'),
(18, 'virat', 'sharma', 'virat@in', '34546gfgtyy', 'm', '6575675675', 'download.jpg'),
(19, 'anuj', 'verma', 'anuj@gmail.com', '3453rtfert4353', 'm', '5667867878', 'Screenshot (1).png'),
(20, 'Neha', 'Biswas', 'neha@biswas.in', '343453454', 'm', '5645665656', '1666939316102.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_pool`
--
ALTER TABLE `email_pool`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_pool`
--
ALTER TABLE `email_pool`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
