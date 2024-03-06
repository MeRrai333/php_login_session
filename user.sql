-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2024 at 11:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbhw8`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_password` char(32) NOT NULL,
  `user_fname` text NOT NULL,
  `user_lname` text NOT NULL,
  `user_gender` int(11) NOT NULL DEFAULT 0,
  `user_age` int(11) NOT NULL DEFAULT 1,
  `user_province` int(11) NOT NULL DEFAULT 0,
  `user_email` varchar(200) NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_fname`, `user_lname`, `user_gender`, `user_age`, `user_province`, `user_email`, `user_role`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'adminFname', 'adminLname', 1, 20, 77, 'admin@mail.com', 99),
(2, 'user1', '2ac9cb7dc02b3c0083eb70898e549b63', 'fuser1', 'luser1', 2, 27, 77, 'user1@mail.com', 1),
(3, 'user2', '2ac9cb7dc02b3c0083eb70898e549b63', 'fuser2test', 'luser2', 2, 17, 77, 'user2@mail.com', 1),
(4, 'user3', '2ac9cb7dc02b3c0083eb70898e549b63', 'fuser3', 'luser3', 1, 18, 77, 'user3@mail.com', 1),
(15, 'user4', '2ac9cb7dc02b3c0083eb70898e549b63', 'fuser4', 'luser4', 1, 41, 20, 'user4@mail.com', 1),
(18, 'user5', '2ac9cb7dc02b3c0083eb70898e549b63', 'fuser4', 'luser5', 1, 20, 77, 'user5@mail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_username` (`user_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
