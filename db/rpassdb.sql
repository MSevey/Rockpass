-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 28, 2017 at 07:48 PM
-- Server version: 5.7.20
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rpassdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `gyms`
--

CREATE TABLE `gyms` (
  `ID` int(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `gymName` varchar(25) NOT NULL,
  `shortName` varchar(25) NOT NULL,
  `state` varchar(25) NOT NULL,
  `stAddress` varchar(50) NOT NULL,
  `zipCode` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gyms`
--

INSERT INTO `gyms` (`ID`, `email`, `gymName`, `shortName`, `state`, `stAddress`, `zipCode`, `phone`) VALUES
(1, 'rockspot@rockspot.com', 'RockSpot', 'RSpot', 'MA', 'South Boston', '2127', '1234567890'),
(2, 'metro@metrorock.com', 'MetroRock', 'Metro', 'MA', 'Evertt', '12345', '1234567890'),
(3, 'crg@crg.com', 'Central Rock Gym', 'CRG', 'MA', 'Watertown', '02472', '3214560987'),
(4, 'bkb@bkb.com', 'Brooklyn Boulders', 'BKBSomm', 'MA', 'Sommerville', '01289', '4561237890');

-- --------------------------------------------------------

--
-- Table structure for table `hobbies`
--

CREATE TABLE `hobbies` (
  `userID` int(25) NOT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rockClimbing` int(5) DEFAULT NULL,
  `iceClimbing` int(5) DEFAULT NULL,
  `hiking` int(5) DEFAULT NULL,
  `camping` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hobbies`
--

INSERT INTO `hobbies` (`userID`, `lastUpdate`, `rockClimbing`, `iceClimbing`, `hiking`, `camping`) VALUES
(1, '2017-12-27 22:26:43', 1, 1, 1, 1),
(2, '2017-12-28 19:12:35', 1, 0, 1, 0),
(3, '2017-12-28 19:23:50', 1, 1, 1, 1),
(4, '2017-12-28 19:46:04', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `ID` int(25) NOT NULL,
  `matchedUserID` int(11) NOT NULL,
  `primaryUserID` int(11) NOT NULL,
  `hobbieMatch` int(5) DEFAULT NULL,
  `styleMatch` int(5) DEFAULT NULL,
  `boulderMatch` int(5) DEFAULT NULL,
  `TRMatch` int(5) DEFAULT NULL,
  `leadMatch` int(5) DEFAULT NULL,
  `gymMatch` int(5) DEFAULT NULL,
  `rating` int(5) DEFAULT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `passes`
--

CREATE TABLE `passes` (
  `ID` int(25) NOT NULL,
  `userID` int(25) NOT NULL,
  `datePurchased` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateUsed` timestamp NULL DEFAULT NULL,
  `emailSent` varchar(25) DEFAULT NULL,
  `rockGym` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passes`
--

INSERT INTO `passes` (`ID`, `userID`, `datePurchased`, `dateUsed`, `emailSent`, `rockGym`) VALUES
(1, 1, '2017-12-27 22:50:40', '2017-12-27 23:03:14', 'Yes', 'RSpot'),
(2, 1, '2017-12-27 22:50:40', '2017-12-28 19:11:31', 'Yes', 'Metro'),
(3, 1, '2017-12-27 22:50:40', NULL, NULL, NULL),
(4, 1, '2017-12-27 22:50:40', NULL, NULL, NULL),
(5, 1, '2017-12-27 22:50:40', NULL, NULL, NULL),
(6, 1, '2017-12-27 22:50:40', NULL, NULL, NULL),
(7, 1, '2017-12-27 22:50:40', NULL, NULL, NULL),
(8, 1, '2017-12-27 22:50:40', NULL, NULL, NULL),
(9, 1, '2017-12-27 22:50:40', NULL, NULL, NULL),
(10, 1, '2017-12-27 22:50:40', NULL, NULL, NULL),
(11, 2, '2017-12-27 22:50:40', '2017-12-28 19:15:16', 'Yes', 'Metro'),
(12, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(13, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(14, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(15, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(16, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(17, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(18, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(19, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(20, 2, '2017-12-27 22:50:40', NULL, NULL, NULL),
(21, 3, '2017-12-27 22:50:40', '2017-12-28 19:44:13', 'Yes', 'CRG'),
(22, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(23, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(24, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(25, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(26, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(27, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(28, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(29, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(30, 3, '2017-12-27 22:50:40', NULL, NULL, NULL),
(31, 4, '2017-12-27 22:50:40', '2017-12-28 19:46:20', 'Yes', 'BKBSomm'),
(32, 4, '2017-12-27 22:50:40', NULL, NULL, NULL),
(33, 4, '2017-12-27 22:50:40', NULL, NULL, NULL),
(34, 4, '2017-12-27 22:50:40', NULL, NULL, NULL),
(35, 4, '2017-12-27 22:50:40', NULL, NULL, NULL),
(36, 4, '2017-12-27 22:50:40', NULL, NULL, NULL),
(37, 4, '2017-12-27 22:50:40', NULL, NULL, NULL),
(38, 4, '2017-12-27 22:50:40', NULL, NULL, NULL),
(39, 4, '2017-12-27 22:50:40', NULL, NULL, NULL),
(40, 4, '2017-12-27 22:50:40', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `userID` int(25) NOT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `preferedStyle` varchar(25) DEFAULT NULL,
  `boulderinglvl` int(5) DEFAULT NULL,
  `topRopinglvl` int(5) DEFAULT NULL,
  `leadinglvl` int(5) DEFAULT NULL,
  `yearsClimbing` int(5) DEFAULT NULL,
  `percVisit` double DEFAULT NULL,
  `mostVisitGym` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`userID`, `lastUpdate`, `preferedStyle`, `boulderinglvl`, `topRopinglvl`, `leadinglvl`, `yearsClimbing`, `percVisit`, `mostVisitGym`) VALUES
(3, '2017-12-28 19:30:51', 'Lead Climbing', 5, 17, 11, 5, NULL, NULL),
(1, '2017-12-28 19:32:35', 'Lead Climbing', 5, 18, 13, 12, NULL, NULL),
(2, '2017-12-28 19:35:54', 'Lead Climbing', 4, 17, 12, 4, NULL, NULL),
(4, '2017-12-28 19:46:04', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `fName` varchar(25) DEFAULT NULL,
  `lName` varchar(25) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `state` varchar(25) NOT NULL,
  `job` varchar(25) DEFAULT NULL,
  `referralCode` varchar(10) NOT NULL,
  `profilePic` varchar(25) DEFAULT './img/Empty_Profile.png',
  `admin` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `fName`, `lName`, `username`, `email`, `password`, `state`, `job`, `referralCode`, `profilePic`, `admin`) VALUES
(1, 'Matthew', 'Sevey', 'MJSevey', 'mjsevey@gmail.com', 'c06db68e819be6ec3d26c6038d8e8d1f', 'MA', 'Engineer', 'ricn6h', NULL, 'Yes'),
(2, 'test', 'user 1', 'test@test.com', 'test@test.com', 'c06db68e819be6ec3d26c6038d8e8d1f', 'MA', 'Student', 'uavgpw', './img/Empty_Profile.png', NULL),
(3, 'test 2', 'user 2', 'test1', 'test1@test.com', 'c06db68e819be6ec3d26c6038d8e8d1f', 'MA', 'Engineer', 'frqh2c', './img/Empty_Profile.png', NULL),
(4, 'test', 'user3', 'test2', 'test2@test.com', 'c06db68e819be6ec3d26c6038d8e8d1f', 'MA', 'Student', 'flssou', './img/Empty_Profile.png', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gyms`
--
ALTER TABLE `gyms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `passes`
--
ALTER TABLE `passes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gyms`
--
ALTER TABLE `gyms`
  MODIFY `ID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `passes`
--
ALTER TABLE `passes`
  MODIFY `ID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
