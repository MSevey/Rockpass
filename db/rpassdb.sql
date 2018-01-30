-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2015 at 01:51 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rpassdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
`ID` int(11) NOT NULL,
  `fromName` varchar(50) NOT NULL,
  `fromEmail` varchar(50) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(500) NOT NULL,
  `toEmail` varchar(50) NOT NULL,
  `sent` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gyms`
--

CREATE TABLE IF NOT EXISTS `gyms` (
`ID` int(11) NOT NULL,
  `gymName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL DEFAULT 'password' COMMENT 'Set to password, then gyms can change it',
  `state` varchar(50) NOT NULL,
  `shortName` varchar(50) NOT NULL COMMENT 'This is the abbreviated name',
  `stAddress` varchar(100) NOT NULL,
  `zipCode` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gyms`
--

INSERT INTO `gyms` (`ID`, `gymName`, `password`, `state`, `shortName`, `stAddress`, `zipCode`, `email`, `phone`) VALUES
(1, 'Metro Rock', 'password', 'MA', 'MetroEverett', 'something', 12345, 'something', 123),
(2, 'Rock Spot', 'password', 'MA', 'RSpotSB', 'something', 12345, 'something', 123),
(3, 'Brooklyn Boulders', 'password', 'MA', 'BKBSomm', 'something', 12345, 'something', 123),
(4, 'Central Rock', 'password', 'MA', 'CentralRockBoston', 'something', 12345, 'something', 123);

-- --------------------------------------------------------

--
-- Table structure for table `passes`
--

CREATE TABLE IF NOT EXISTS `passes` (
`ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `rockGym` varchar(50) NOT NULL,
  `dateDay` date NOT NULL,
  `dateTime` datetime NOT NULL,
  `passesUsed` int(25) NOT NULL COMMENT 'This is the number of day passes used',
  `passesAvail` int(25) NOT NULL COMMENT 'This is the number of day passes available',
  `packsPurchased` int(25) NOT NULL COMMENT 'This is the number of Rock Passes Purchased',
  `emailSent` varchar(5) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `passes`
--

INSERT INTO `passes` (`ID`, `username`, `rockGym`, `dateDay`, `dateTime`, `passesUsed`, `passesAvail`, `packsPurchased`, `emailSent`) VALUES
(66, 'MSevey', '', '0000-00-00', '0000-00-00 00:00:00', 0, 10, 1, ''),
(67, 'MSevey', 'RSpotSB', '2015-10-04', '2015-10-04 10:18:15', 10, 10, 2, 'Yes'),
(68, 'MSevey', 'CentralRockBoston', '2015-10-05', '2015-10-05 12:49:10', 11, 9, 0, 'Yes'),
(69, 'MSevey', 'BKBSomm', '2015-10-08', '2015-10-08 01:21:51', 13, 10, 2, 'Yes'),
(70, 'MSevey', 'MetroEverett', '2015-10-16', '2015-10-16 07:36:37', 14, 9, 0, 'Yes'),
(71, 'OSevey', '', '0000-00-00', '0000-00-00 00:00:00', 0, 10, 1, ''),
(72, 'OSevey', 'RSpotSB', '2015-10-16', '2015-10-16 07:39:34', 0, 10, 0, 'No'),
(73, 'MSevey', 'BKBSomm', '2015-10-17', '2015-10-17 09:05:56', 16, 7, 0, 'Yes'),
(75, 'MSevey', 'Brooklyn Boulders in Sommerville', '2015-10-18', '2015-10-18 08:36:44', 17, 10, 1, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `state` varchar(10) NOT NULL,
`ID` int(11) NOT NULL,
  `signDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` varchar(5) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`fName`, `lName`, `username`, `email`, `password`, `state`, `ID`, `signDate`, `admin`) VALUES
('Matthew', 'Sevey', 'MSevey', 'mjsevey@gmail.com', 'aebc7dfafde486758efb13d78f7219fd', 'MA', 15, '2015-09-26 18:36:35', 'Yes'),
('Olivia', 'Sevey', 'OSevey', 'oliviasevey@gmail.com', 'edac7e113177922b08c9e611e8219c93', 'MA', 17, '2015-09-26 19:36:38', 'No'),
('test', 'test', 'test', 'test', '4f0b36a34946153c358f8b243428a1eb', 'AL', 23, '2015-10-07 12:34:02', 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email`
--
ALTER TABLE `email`
 ADD PRIMARY KEY (`ID`);

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
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gyms`
--
ALTER TABLE `gyms`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `passes`
--
ALTER TABLE `passes`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
