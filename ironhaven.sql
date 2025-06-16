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
-- Database: `ironhaven`
--

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `username`, `review`, `rating`, `created_at`) VALUES
(1, 0, 'teste', 'dd', 5, '2025-06-09 00:21:37'),
(2, 0, 'teste', 'adad', 5, '2025-06-09 00:21:45'),
(3, 0, 'teste', 'd', 5, '2025-06-09 00:23:02'),
(4, 0, 'teste', 'adad', 5, '2025-06-09 00:24:41'),
(5, 0, 'teste', 's', 5, '2025-06-09 00:24:43'),
(6, 0, 'teste', 's', 5, '2025-06-09 00:24:43'),
(7, 0, 'teste', 's', 5, '2025-06-09 00:24:44'),
(8, 0, 'teste', 's', 5, '2025-06-09 00:24:46'),
(9, 0, 'teste', 's', 5, '2025-06-09 00:24:47'),
(10, 0, 'teste', 's', 5, '2025-06-09 00:24:48'),
(11, 0, 'teste', 's', 5, '2025-06-09 00:24:48'),
(12, 0, 'teste', 's', 5, '2025-06-09 00:24:49'),
(13, 0, 'teste', 's', 5, '2025-06-09 00:24:49'),
(14, 0, 'teste', 's', 5, '2025-06-09 00:24:50'),
(15, 0, 'teste', 's', 5, '2025-06-09 00:24:50'),
(16, 0, 'teste', 's', 5, '2025-06-09 00:24:51'),
(17, 0, 'teste', 's', 5, '2025-06-09 00:24:52'),
(18, 0, 'teste', 's', 5, '2025-06-09 00:24:53'),
(19, 0, 'teste', 's', 5, '2025-06-09 00:24:54'),
(20, 0, 'teste', 's', 5, '2025-06-09 00:24:55'),
(21, 0, 'teste', 'd', 5, '2025-06-09 00:27:46'),
(22, 0, 'teste', 'd', 5, '2025-06-09 00:27:55'),
(23, 0, 'teste', 'd', 5, '2025-06-09 00:29:02'),
(24, 0, 'teste', 'd', 5, '2025-06-09 00:35:06'),
(25, 0, 'teste', 'dadad', 5, '2025-06-09 00:35:08'),
(26, 0, 'teste', 'ssdadad', 5, '2025-06-09 00:35:19'),
(27, 0, 'teste', 'dd', 5, '2025-06-09 00:35:37'),
(28, 0, 'alex', 'adadad', 5, '2025-06-09 21:32:24'),
(29, 0, 'alex', 'dadd', 5, '2025-06-10 15:52:00'),
(30, 0, 'Telemóvel', 'Hahah', 5, '2025-06-10 15:54:20'),
(31, 0, 'Telemóvel', 'Hdjdjdmsh', 5, '2025-06-10 15:58:41'),
(32, 0, 'Leonor', 'Muito bem amor, está a funcionar!', 5, '2025-06-10 16:01:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin', '', '$2y$10$48MfhOH173N4avoBFYFxVexqGAZCV161MIzVUTO7.meBByJp7KRIy'),
(2, 'alex777', 'o.tal.de.alex.futebolista@gmail.com', '$2y$10$8bShNlPgcht5d7cua1yc3OpsYlPwuV/G3rLlQZzvSfqFB1ZoHczA.'),
(3, 'alex', 'o.x.futebolista@gmail.com', '$2y$10$Ro3h97zGriCuD0utX9lkyu0tMr/VUC0lFsm/EsQsEImN9obOeTPv2'),
(4, 'alex1', '10cinfor.alexandre@gmail.com', '$2y$10$ydLJG.cmAlzeV7F8aZRj4.ED42eQL1/5j8kG1ViAYXe3NtZTlageC'),
(5, 'alex12', 'adad@gmail.com', '$2y$10$VoZkdFhF8iRxBpxmWzA0VORe7i3IetC/XyF/IvnWOI6nwLvT0MoHS'),
(6, 'alex7777', 'alex777@gmail.com', '$2y$10$qf0v/An3My6f9SVaUAdPOeqyV4.gcZEsz/O0kuFN.xwPck.jDnLs.'),
(7, 'alex8888', 'alex8888@gmail.com', '$2y$10$cAOWcvjroYCfIZGYrSxsGOE1LVQHGImX2zRrbyQ/YhgL9RwRBh1n6'),
(8, 'alex9999', 'alex9999@gmail.com', '$2y$10$iU3jffQd2sMGfmlGiJYlFOkADyHle65cWfo5PWizdw49n9Hq9bMRe'),
(9, 'alex2222', 'alex2222@gmail.com', '$2y$10$awuJxqs95C3SQ2evNux.f.09n8UZ.zvU9NGO7nfKkWo4fhsI1gmG.'),
(10, 'maria', 'maria@example.com', '$2y$10$rAi/IRhEm9.YEKaW5pY0nusEkXuAzxI8qVHSJTnMnrfml8HR9sJpu');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
