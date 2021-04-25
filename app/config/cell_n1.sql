-- phpMyAdmin SQL Dump
-- version 5.1.0-rc2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 25, 2021 at 02:17 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cell_n1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cells`
--

CREATE TABLE `cells` (
  `id` bigint(60) NOT NULL,
  `type` varchar(255) NOT NULL,
  `owner_id` bigint(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cells`
--

INSERT INTO `cells` (`id`, `type`, `owner_id`) VALUES
(1, 'forest', 6),
(100, 'cave', 6),
(101, 'base', 6),
(102, 'lab', 6),
(201, 'army', 6),
(209, 'forest', 2),
(308, 'cave', 2),
(309, 'base', 2),
(310, 'lab', 2),
(409, 'army', 2);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(60) NOT NULL,
  `owner_id` bigint(60) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `owner_id`, `name`) VALUES
(7, 2, 'Rased Empire'),
(8, 6, 'Fairy Tail');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` bigint(60) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(60) DEFAULT NULL,
  `money` bigint(60) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `username`, `email`, `password`, `token`, `money`) VALUES
(1, 'eyyo', 'myboi@gmail.com', '$2y$10$4lCXVC6y1vjYXOIQGmzdcOHaoiR02CdJbOIKRfck5xIwLqgli.Bsi', NULL, 0),
(2, 'askerased', 'askedwhoami@gmail.com', '$2y$10$TTtZSCU.28JZj6eUdkJeaepGSEQQZQpRwZS3dASn0V4qhSmOIcAWq', '41cd8fa84837ba5e79d4b981714d2899', 0),
(3, 'testuser', 'myemail@femma.com', '$2y$10$u9OwqYZm1bT103Bh4mwmHutPddWl7OqAJRTo8h5ehIG/C3jzRWeui', 'a9444185cd0dfc49a90bc0088bc418c0', 0),
(4, 'mytester', 'mytester@gmail.com', '$2y$10$WN0WzcKx4wT39pZH2rwzt.Kt5K7mtJRn6kBDrcT59PGzThaIzWy0e', '05202bd3ddae1379de4e8f707f6f0487', 0),
(5, 'testmyname', 'itis@an.email', '$2y$10$Kh7NDOPdvH5P39AEMDwdoePy5.6JG91FAH8MGDUbDuwyaxrz0jEge', NULL, 0),
(6, 'spriggan27', 'avatar.1942@mail.ru', '$2y$10$jmtNPwgRje8WmKTeCLmaDu936G83SpWaW.u5n7xLLLrZA/zYj1fJ.', '6a1f2d8ff81b6ed95c19ae3bbeea5d4e', 622);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cells`
--
ALTER TABLE `cells`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cells`
--
ALTER TABLE `cells`
  MODIFY `id` bigint(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10096;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` bigint(60) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cells`
--
ALTER TABLE `cells`
  ADD CONSTRAINT `cells_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `players` (`id`);

--
-- Constraints for table `countries`
--
ALTER TABLE `countries`
  ADD CONSTRAINT `countries_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `players` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
