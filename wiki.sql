-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 14, 2024 at 09:40 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wiki`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int NOT NULL,
  `category_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `category_name`) VALUES
(2, 'front-end'),
(3, 'back-end'),
(4, 'test'),
(26, 'sport');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int NOT NULL,
  `tag_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `tag_name`) VALUES
(2, 'test'),
(3, 'check '),
(4, 'te'),
(5, 're'),
(6, 'he');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` enum('admin','auteur') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'test', 'test@gmail.com', '$2y$10$BC2ubiJOlb17.yETbxMFnOYLZTRCBRWEfCF.jIa.G2FrXM/5poCpG', 'auteur'),
(2, 'test', 'test@gmail.com', '$2y$10$BITOapSRx70iXffN8pMh/OM8lhcxWgpM64kH1b9O4yPQNDAV5YDLy', 'auteur'),
(3, 'check', 'check@gmail.com', '$2y$10$Zg6RoAMzayOkJBqGB97eUebBV3kvNoDd.y3o2fwNK2g5kdr3WrcCi', 'auteur'),
(4, 'nada', 'nadaelmahfoudi@gmail.com', '$2y$10$LN8.PAlrTopB4gv82BIxcOfAmHs39H1LPJhChXD/PrBarSPb.Vkn6', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wiki`
--

CREATE TABLE `wiki` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `datecreate` timestamp NOT NULL,
  `status` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `user_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wiki`
--

INSERT INTO `wiki` (`id`, `title`, `content`, `datecreate`, `status`, `description`, `user_id`, `category_id`) VALUES
(1, 'test', ' test', '2024-01-11 15:57:14', 1, 'test', NULL, NULL),
(9, 'title', 'test', '2024-01-12 07:23:57', 0, 'test', 1, 2),
(10, 'test', 'test', '2024-01-13 09:43:15', 1, 'test', 1, 3),
(18, 'nada', 'vsvzjn,mq', '2024-01-13 10:11:37', 0, 'test', 2, 26),
(19, 'nada', 'vdhj', '2024-01-13 16:11:01', 1, 'test', 2, 3),
(20, 'test', 'gsb', '2024-01-13 17:40:46', 1, 'test', 1, 26),
(21, 'test', 'test', '2024-01-13 17:42:42', 0, 'test', 1, 26),
(22, 'test', 'test', '2024-01-13 17:47:09', 0, 'test', 1, 26);

-- --------------------------------------------------------

--
-- Table structure for table `wiki_tags`
--

CREATE TABLE `wiki_tags` (
  `wiki_id` int NOT NULL,
  `tag_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wiki_tags`
--

INSERT INTO `wiki_tags` (`wiki_id`, `tag_id`) VALUES
(22, 4),
(22, 5),
(22, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wiki`
--
ALTER TABLE `wiki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_category_id` (`category_id`);

--
-- Indexes for table `wiki_tags`
--
ALTER TABLE `wiki_tags`
  ADD PRIMARY KEY (`wiki_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wiki`
--
ALTER TABLE `wiki`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wiki`
--
ALTER TABLE `wiki`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categorie` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wiki_tags`
--
ALTER TABLE `wiki_tags`
  ADD CONSTRAINT `wiki_tags_ibfk_1` FOREIGN KEY (`wiki_id`) REFERENCES `wiki` (`id`),
  ADD CONSTRAINT `wiki_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
 