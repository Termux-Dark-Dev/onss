-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2024 at 05:40 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onssdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblnotes`
--

CREATE TABLE `tblnotes` (
  `ID` int(5) NOT NULL,
  `UserID` int(5) DEFAULT NULL,
  `Subject` varchar(250) DEFAULT NULL,
  `NotesTitle` varchar(250) DEFAULT NULL,
  `NotesDecription` longtext DEFAULT NULL,
  `File` varchar(250) DEFAULT NULL,
  `isNotePaid` tinyint(1) DEFAULT 0,
  `notePrice` int(100) NOT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblnotes`
--

INSERT INTO `tblnotes` (`ID`, `UserID`, `Subject`, `NotesTitle`, `NotesDecription`, `File`, `isNotePaid`, `notePrice`, `CreationDate`, `UpdationDate`) VALUES
(10, 5, 'Test', 'Test Note', 'Test', 'd41d8cd98f00b204e9800998ecf8427e1707748487.pdf', 1, 30, '2024-02-12 14:34:47', '2024-02-16 03:25:17'),
(11, 5, 'Test 1', 'Test Note 1', 'Test desc about ', '717fcbf819bb99c162eb9c33765b70671707791717.pdf', 0, 0, '2024-02-13 02:35:17', '2024-02-16 14:05:00'),
(12, 5, 'Test 2', 'Test Note 2', 'Test desc 2', '717fcbf819bb99c162eb9c33765b70671707791747.pdf', 1, 20, '2024-02-13 02:35:47', '2024-02-16 14:04:50'),
(13, 5, 'Test', 'Test Note 10', 'hh', '717fcbf819bb99c162eb9c33765b70671707793225.pdf', 1, 30, '2024-02-13 03:00:25', '2024-02-16 14:04:54'),
(14, 5, 'Test 1', 'Test Note 1', 'ssss', '7724c836f8650de17664fd4b1656ebea1707794402.pdf', 0, 0, '2024-02-13 03:20:02', NULL),
(15, 5, 'Test 0', 'Test Note 2', 'test', '5b612ab00003e04a3c9642fb1b5d2d711707794444.pdf', 1, 50, '2024-02-13 03:20:44', NULL),
(16, 5, 'Test 0', 'Test Note', 'jjj', '5b612ab00003e04a3c9642fb1b5d2d711707794500.pdf', 1, 20, '2024-02-13 03:21:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbltransaction`
--

CREATE TABLE `tbltransaction` (
  `tscid` varchar(100) NOT NULL,
  `noteId` int(100) NOT NULL,
  `usrId` int(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `date_of_payment` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbltransaction`
--

INSERT INTO `tbltransaction` (`tscid`, `noteId`, `usrId`, `payment_status`, `date_of_payment`) VALUES
('pay_NcFfH2VdgLHc7m', 10, 5, 'paid', '2024-02-18 06:58:12'),
('pay_NcFguLZAQQbIiM', 12, 5, 'paid', '2024-02-18 06:59:44'),
('pay_NcFipjuRa0J4tW', 12, 5, 'paid', '2024-02-18 07:01:39'),
('pay_NcFWmTlmvY3eV1', 10, 5, 'paid', '2024-02-18 06:57:33'),
('pay_NcG12riJYHw8ZN', 16, 5, 'paid', '2024-02-18 07:18:48'),
('pay_NcG52BnYC9YH4d', 12, 5, 'paid', '2024-02-18 07:22:36'),
('pay_NcGBdoDJLWNKAP', 10, 5, 'paid', '2024-02-18 07:28:50'),
('pay_NcGGhC2oPJCmav', 15, 5, 'paid', '2024-02-18 07:33:37'),
('pay_NcGI3u62v11b8a', 16, 5, 'paid', '2024-02-18 07:34:54'),
('pay_NcGKqsz4AArw6H', 16, 5, 'paid', '2024-02-18 07:37:33'),
('pay_NcGOjG0up1ouWU', 16, 5, 'paid', '2024-02-18 07:41:13'),
('pay_NcGR6BO5f6eBQf', 16, 5, 'paid', '2024-02-18 07:43:28'),
('pay_NcGTb3S3pzXjTK', 16, 5, 'paid', '2024-02-18 07:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(5) NOT NULL,
  `FullName` varchar(250) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FullName`, `MobileNumber`, `Email`, `Password`, `RegDate`) VALUES
(1, 'Abir Singh', 9798789789, 'abir@gmail.com', '202cb962ac59075b964b07152d234b70', '2022-06-06 13:36:36'),
(2, 'Anuj Kumar', 1425362514, 'ak@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2022-06-11 11:48:57'),
(3, 'Raghav', 7897979878, 'rahgav@gmail.com', '202cb962ac59075b964b07152d234b70', '2023-12-14 05:26:12'),
(4, 'John Doe', 1122112211, 'john12@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2023-12-15 17:46:20'),
(5, 'test user', 8944844949, 'test@gmail.com', '098f6bcd4621d373cade4e832627b4f6', '2024-01-03 14:18:58'),
(6, 'test1', 7595757585, 'xyz@gmail.com', '098f6bcd4621d373cade4e832627b4f6', '2024-02-16 02:38:44'),
(7, 'test2', 575755955, 'uuu@gmail.com', '098f6bcd4621d373cade4e832627b4f6', '2024-02-16 02:39:35'),
(8, 'hms', 6484846474, 'testss@gmail.com', '098f6bcd4621d373cade4e832627b4f6', '2024-02-16 02:40:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblnotes`
--
ALTER TABLE `tblnotes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbltransaction`
--
ALTER TABLE `tbltransaction`
  ADD PRIMARY KEY (`tscid`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblnotes`
--
ALTER TABLE `tblnotes`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
