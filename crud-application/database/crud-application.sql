-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2021 at 01:51 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud-application`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `crs_id` bigint(20) UNSIGNED NOT NULL,
  `crs_name` varchar(200) DEFAULT NULL,
  `crs_code` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`crs_id`, `crs_name`, `crs_code`) VALUES
(1, 'Bachelor of Legislative Law', 'LLB'),
(2, 'Bachelor In Computer Science', 'BSCS'),
(3, 'Bachelor of Business Administration', 'BBA'),
(4, 'Bachelor of Medicine and Bachelor of Surgery', 'MBBS');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `stu_id` bigint(20) UNSIGNED NOT NULL,
  `stu_name` varchar(100) DEFAULT NULL,
  `stu_phone` varchar(11) DEFAULT NULL,
  `stu_address` varchar(255) DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`stu_id`, `stu_name`, `stu_phone`, `stu_address`, `course_id`) VALUES
(1, 'Muhammad Abubakar', '03214698761', 'Saddar Bazar Lahore Cantt', 2),
(2, 'Samar Almas', '03214698762', 'Cheema Bazar Rawalpindi', 2),
(3, 'Harris Umer', '03214698763', 'RA Bazar Lahore Cantt', 1),
(4, 'Waleed Ashraf', '03214698764', 'Taj Pora Lahore Cantt', 1),
(5, 'Muaviya Imran', '03214698765', 'Shalamar Road Lahore Cantt', 1),
(6, 'Abuzar Yaseen', '03214698766', 'Wagha Border Lahore Cantt', 3),
(7, 'Fatima Hussain', '03214698767', 'Jameel Park Lahore Cantt', 4),
(8, 'Ayesha Akhtar', '03214698768', 'Ghazi Road Lahore Cantt', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`crs_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`stu_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `crs_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `stu_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`crs_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
