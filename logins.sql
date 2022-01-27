-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 15, 2021 at 10:03 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `logins`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `itemName` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `itemPrice` float NOT NULL,
  `itemLink` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes` int(100) NOT NULL,
  PRIMARY KEY (`itemName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemName`, `itemPrice`, `itemLink`, `likes`) VALUES
('Watch A', 3.2, '//www.lelong.com.my/-220474871-2023-03-Sale-P.htm', 2),
('Watch B', 3.2, '//www.lelong.com.my/-220474872-2023-03-Sale-P.htm', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pwd` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `pwd`) VALUES
('goldstair', '1234'),
('niccarson', '1234'),
('ethan', '1234'),
('jolyyap', 'twice'),
('nicholas', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `user_item_likes`
--

DROP TABLE IF EXISTS `user_item_likes`;
CREATE TABLE IF NOT EXISTS `user_item_likes` (
  `user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_item` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_item`),
  KEY `user` (`user`),
  KEY `item` (`item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_item_likes`
--

INSERT INTO `user_item_likes` (`user`, `item`, `user_item`) VALUES
('niccarson', 'Watch B', '9e865fc3a188aff13cff85fd50637d6b49cc3761'),
('ethan', 'Watch A', 'f8c94796d335bf0482df0a05e357bc632c104564'),
('niccarson', 'Watch A', '305b72bc0d352529120f11e9e7287692907c3636');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
