-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2022 at 06:38 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `id` int(11) NOT NULL,
  `first_name` text COLLATE utf8_bin NOT NULL,
  `last_name` text COLLATE utf8_bin NOT NULL,
  `category_id` int(11) NOT NULL,
  `voting_id` int(11) NOT NULL,
  `votes` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `first_name`, `last_name`, `category_id`, `voting_id`, `votes`) VALUES
(25, 'Bert', 'Dela Cruz', 65, 63, 0),
(24, 'John Arthur', 'Makalang', 62, 63, 0),
(26, 'John', 'Dela Cruz', 62, 63, 0),
(27, 'Anthony', 'Malaya', 63, 63, 0),
(28, 'Carl', 'Dela Cruz', 64, 63, 0),
(29, 'Kurt', 'Dela Cruz', 63, 63, 0),
(30, 'Anton', 'Cruz', 65, 63, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category` varchar(225) COLLATE utf8_bin NOT NULL,
  `voting_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`, `voting_id`) VALUES
(65, 'Treasurer', 63),
(64, 'Secretary', 63),
(63, 'Vice President', 63),
(62, 'President', 63);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(225) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(225) COLLATE utf8_bin NOT NULL,
  `LRN` varchar(225) COLLATE utf8_bin NOT NULL,
  `access` text COLLATE utf8_bin NOT NULL,
  `pass` varchar(225) COLLATE utf8_bin NOT NULL,
  `vote_63` int(11) DEFAULT NULL,
  `President_63` int(11) DEFAULT NULL,
  `Vice_President_63` int(11) DEFAULT NULL,
  `Secretary_63` int(11) DEFAULT NULL,
  `Treasurer_63` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `LRN`, `access`, `pass`, `vote_63`, `President_63`, `Vice_President_63`, `Secretary_63`, `Treasurer_63`) VALUES
(1, 'admin', 'admini', 'admin', 'admin', 'admin', NULL, NULL, NULL, NULL, NULL),
(40, 'John Benedict', 'Macario', '123456789012', 'user', 'none', NULL, NULL, NULL, NULL, NULL),
(39, 'John Carlos', 'Trinidad', '123456789122', 'user', 'none', NULL, NULL, NULL, NULL, NULL),
(38, 'Juan', 'Dela Cruz', '123456789123', 'user', 'none', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `voting_list`
--

CREATE TABLE `voting_list` (
  `id` int(11) NOT NULL,
  `voting_title` varchar(225) COLLATE utf8_bin NOT NULL,
  `voting_description` varchar(225) COLLATE utf8_bin NOT NULL,
  `display` int(11) NOT NULL,
  `date` varchar(225) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `voting_list`
--

INSERT INTO `voting_list` (`id`, `voting_title`, `voting_description`, `display`, `date`) VALUES
(63, 'SSG', '2021', 1, 'September 30, 2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voting_list`
--
ALTER TABLE `voting_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `voting_list`
--
ALTER TABLE `voting_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
