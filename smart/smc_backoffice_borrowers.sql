-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: db798353820.hosting-data.io
-- Generation Time: Nov 15, 2019 at 06:39 AM
-- Server version: 5.5.60-0+deb7u1-log
-- PHP Version: 7.0.33-0+deb9u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db798353820`
--

-- --------------------------------------------------------

--
-- Table structure for table `smc_backoffice_borrowers`
--

CREATE TABLE `smc_backoffice_borrowers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `second_surname` varchar(255) NOT NULL,
  `dninie` varchar(20) DEFAULT NULL,
  `idnumber` varchar(255) DEFAULT NULL,
  `homelanguage` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `maritalstatus` int(11) NOT NULL,
  `noofdependants` int(11) NOT NULL,
  `employmenttype` int(11) NOT NULL,
  `employercompanyname` varchar(255) DEFAULT NULL,
  `grossmonthlyincome` int(11) NOT NULL,
  `netmonthlyincome` int(11) NOT NULL,
  `servicetype` int(11) NOT NULL,
  `timewithemployer` int(11) NOT NULL,
  `workphonenumber` varchar(255) DEFAULT NULL,
  `cellphonenumber` bigint(20) NOT NULL,
  `alternatenumber` bigint(20) NOT NULL,
  `emailaddress` varchar(255) DEFAULT NULL,
  `housenumber` varchar(255) DEFAULT NULL,
  `streetname` text,
  `suburb` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `postcode` int(11) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `secretquestion` int(11) NOT NULL,
  `secretanswer` varchar(255) DEFAULT NULL,
  `bankname` varchar(255) DEFAULT NULL,
  `street_bank_branch` varchar(500) DEFAULT NULL,
  `bank_branch` varchar(500) DEFAULT NULL,
  `accountnumber` varchar(255) DEFAULT NULL,
  `nameofaccountholder` varchar(255) DEFAULT NULL,
  `ibannumber` varchar(255) NOT NULL,
  `nameoncard` varchar(255) DEFAULT NULL,
  `cardnumber` bigint(20) NOT NULL,
  `expirymonth` int(11) NOT NULL,
  `expiryyear` int(11) NOT NULL,
  `cvvnumber` int(11) NOT NULL,
  `createdate` varchar(255) DEFAULT NULL,
  `mobile_verified` enum('0','1') NOT NULL DEFAULT '0',
  `email_verified` enum('0','1') NOT NULL DEFAULT '0',
  `hasmerchantid` varchar(255) DEFAULT NULL,
  `merchantidnumber` varchar(255) DEFAULT NULL,
  `loanpurpose` text,
  `merchantnamecontactorwebsite` text,
  `dob` varchar(255) DEFAULT NULL,
  `note` text,
  `unique_identifier` varchar(255) DEFAULT NULL,
  `block` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `smc_backoffice_borrowers`
--
ALTER TABLE `smc_backoffice_borrowers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `smc_backoffice_borrowers`
--
ALTER TABLE `smc_backoffice_borrowers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
