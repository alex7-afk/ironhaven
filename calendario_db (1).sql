-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 10, 2025 at 04:50 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calendario_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `mensagem` text,
  `appointment_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `start`, `end`, `email`, `mensagem`, `appointment_type`) VALUES
(1, 'fff', '2025-05-03 08:30:00', '2025-05-03 09:00:00', 'alexcontagames@gmail.com', 'adadad', ''),
(2, 'asd', '2025-05-03 10:00:00', '2025-05-03 10:30:00', 'asdasda@gmail.com', 'asdadad', ''),
(3, 'alexandre', '2025-05-03 13:00:00', '2025-05-03 14:00:00', 'asdasda@gmail.com', 'asdadadasdasdasd', ''),
(4, 'alexandre', '2025-05-03 11:00:00', '2025-05-03 17:30:00', 'asdasda@gmail.com', 'asdadadasdasdasd', ''),
(5, 'asdad', '2025-05-03 09:00:00', '2025-05-03 09:30:00', 'o.tal.de.alex.futebolista@gmail.com', 'adadadad', ''),
(6, 'asdad', '2025-05-03 08:30:00', '2025-05-03 09:00:00', 'asdasda@gmail.com', 'aadaad', ''),
(7, 'asdad', '2025-05-03 09:00:00', '2025-05-03 10:00:00', 'asdasda@gmail.com', 'adad', ''),
(8, 'asdad', '2025-05-03 18:30:00', '2025-05-03 19:00:00', 'asdasda@gmail.com', 'adad', ''),
(9, 'asdad', '2025-05-03 08:00:00', '2025-05-03 09:30:00', 'ada@gmail.com', 'asd', ''),
(10, 'asdad', '2025-05-07 08:30:00', '2025-05-07 09:00:00', 'ada@gmail.com', 'asd', ''),
(11, 'arlete', '2025-05-09 10:00:00', '2025-05-09 11:00:00', 'ada@gmail.com', 'asd', ''),
(12, 'awdasd', '2025-05-07 12:00:00', '2025-05-07 13:00:00', 'dad@gmail.com', 'adadad', ''),
(13, 'awdasd', '2025-05-07 09:30:00', '2025-05-07 10:00:00', 'dad@gmail.com', 'adadad', ''),
(14, 'awdasd', '2025-05-09 12:00:00', '2025-05-09 13:00:00', 'dad@gmail.com', 'adadad', ''),
(15, 'adad', '2025-05-03 08:00:00', '2025-05-03 08:30:00', 'alexcontagames@gmail.com', 'adada', '');

-- --------------------------------------------------------

--
-- Table structure for table `marcacoes`
--

DROP TABLE IF EXISTS `marcacoes`;
CREATE TABLE IF NOT EXISTS `marcacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mensagem` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
