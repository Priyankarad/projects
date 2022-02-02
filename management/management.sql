-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2019 at 06:11 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` tinyint(2) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `duration`, `price`) VALUES
(1, 'Maths', 2, 5000),
(2, 'English', 2, 6000),
(3, 'Science', 4, 10000),
(4, 'Hindi', 1, 2000),
(11, 'Sanskrit', 3, 334);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` int(11) UNSIGNED NOT NULL,
  `registration_id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `students` int(11) NOT NULL,
  `contact_no` bigint(11) NOT NULL,
  `logo` text DEFAULT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `registration_id`, `name`, `email`, `students`, `contact_no`, `logo`, `address`) VALUES
(17, 'SCH-47802', 'Test & Test', 'test@test.org', 200, 9754828201, 'default_logo.png', 'Teli Bakhal'),
(18, 'SCH-98721', 'Ryan', 'ryan@gmail.com', 120, 9876543212, '1575738349_6584341504_67166.jpg', 'indore'),
(19, 'SCH-74230', 'Mount', 'mount@gmail.com', 234, 9123456789, 'default_logo.png', 'Teli Bakhal'),
(20, 'SCH-43795', 'Paul', 'paul@gmail.com', 100, 8989898989, 'default_logo.png', 'Shakkar Bazar');

-- --------------------------------------------------------

--
-- Table structure for table `school_course`
--

CREATE TABLE `school_course` (
  `id` int(11) NOT NULL,
  `school_id` int(11) UNSIGNED NOT NULL,
  `course_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_course`
--

INSERT INTO `school_course` (`id`, `school_id`, `course_id`) VALUES
(67, 17, 1),
(68, 17, 2),
(69, 17, 3),
(70, 17, 4),
(71, 17, 11),
(72, 18, 1),
(73, 18, 4),
(74, 19, 3),
(75, 20, 1),
(76, 20, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_course`
--
ALTER TABLE `school_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `school_fk` (`school_id`),
  ADD KEY `course_fk` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `school_course`
--
ALTER TABLE `school_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `school_course`
--
ALTER TABLE `school_course`
  ADD CONSTRAINT `course_fk` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `school_fk` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
