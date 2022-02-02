-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db703344863.db.1and1.com
-- Generation Time: Jul 09, 2018 at 04:24 PM
-- Server version: 5.5.60-0+deb7u1-log
-- PHP Version: 5.4.45-0+deb7u14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db703344863`
--

-- --------------------------------------------------------

--
-- Table structure for table `smc_admin`
--

CREATE TABLE IF NOT EXISTS `smc_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `user_group` varchar(256) NOT NULL,
  `status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `smc_admin`
--

INSERT INTO `smc_admin` (`id`, `username`, `password`, `name`, `email`, `user_group`, `status`) VALUES
(1, 'admin', '123456', 'Super Admin', 'admin@admin.com', 'Admin', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `smc_backoffice_admin`
--

CREATE TABLE IF NOT EXISTS `smc_backoffice_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `user_group` varchar(256) NOT NULL,
  `status` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `smc_backoffice_admin`
--

INSERT INTO `smc_backoffice_admin` (`id`, `username`, `password`, `name`, `email`, `user_group`, `status`) VALUES
(1, 'admin', 'de5a174ab77cbc25bc2dd55be61edcfc', 'Super Admin', 'admin@admin.com', 'Admin', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `smc_backoffice_borrowers`
--

CREATE TABLE IF NOT EXISTS `smc_backoffice_borrowers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
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
  `accountnumber` varchar(255) DEFAULT NULL,
  `nameofaccountholder` varchar(255) DEFAULT NULL,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `smc_backoffice_borrowers`
--

INSERT INTO `smc_backoffice_borrowers` (`id`, `username`, `firstname`, `middlename`, `surname`, `idnumber`, `homelanguage`, `status`, `maritalstatus`, `noofdependants`, `employmenttype`, `employercompanyname`, `grossmonthlyincome`, `netmonthlyincome`, `servicetype`, `timewithemployer`, `workphonenumber`, `cellphonenumber`, `alternatenumber`, `emailaddress`, `housenumber`, `streetname`, `suburb`, `city`, `province`, `postcode`, `password`, `secretquestion`, `secretanswer`, `bankname`, `accountnumber`, `nameofaccountholder`, `nameoncard`, `cardnumber`, `expirymonth`, `expiryyear`, `cvvnumber`, `createdate`, `mobile_verified`, `email_verified`, `hasmerchantid`, `merchantidnumber`, `loanpurpose`, `merchantnamecontactorwebsite`, `dob`, `note`, `unique_identifier`) VALUES
(2, 'subhasis001', 'Subhasis', '', 'Laha', '5656565656565', '', 12, 21, 2, 1, 'Test Company', 2222, 3333, 27, 2, '4444444444', 9836215056, 7595906192, 'subh.laha@gmail.com', '10/17/4', 'Nandalal Mukherjee Lane', '', 'Howrah', 'West Bengal', 77777, 'af15d5fdacd5fdfea300e88a8e253e82', 60, 'papu', 'State Bank of India', 'AA1111111111111111111111', 'Subhasis Laha', 'Subhasis Laha', 676766767676, 2, 2024, 444, '1523696752', '1', '0', 'no', '', 'Refrigerator Buy', 'Reliance Digital', '15/11/1986', NULL, '004eaa6463bf8fdfaddfdd3de244ddc8'),
(4, 'Ariadna', 'Ariadna', '', 'Villalba', '47881151G', '', 11, 21, 0, 1, 'Hennes and Mauritz', 200, 1400, 55, 10, '677067136', 677067136, 934305195, 'ari.villalba.rodriguez@gmail.com', '2', 'Berlin', '', 'Barcelona', 'Barcelona', 8014, '96113b131c5b7c69a5aefa1758a9c686', 68, 'Barcelona', 'Caixabank', 'ES9721000878280100661190', 'Ariadna Villalba Rodriguez', 'Ariadna Villalba Rodriguez', 4966264437397025, 5, 2022, 393, '1525253796', '1', '0', 'no', '', 'Compra Thermomix', 'Vorwerk', '15/12/1988', NULL, NULL),
(5, 'silvia@smartcredit.es', 'SILVIA', NULL, 'INSA', '46145437P', NULL, 15, 20, 1, 2, 'pp', 2000, 2000, 29, 3, '934455667', 689565555, 123456711, 'silvia@smartcredit.es', 'CONSTITUCIÃ“N', 'CONSTITUCIÃ“N', '', 'SANT JUST DESVERN', 'BARCELONA', 8960, '43632cc3763f39e84fe4ea85ff881fc8', 60, 'Zaira', 'bbva', 'ES2022222222222222222222', 'SILVIA CALLS INSA', 'silvia calls', 4507970187661636, 4, 2020, 123, '1528275241', '1', '0', 'no', 'B67188899', 'ODONTOTOLOGIA', 'Dorsia', '02/06/1980', NULL, NULL),
(6, 'premhamad', 'prem', NULL, 'Hamad', '12345678t', NULL, 12, 21, 2, 1, 'Pixlr it solution', 1900, 8000, 30, 2, '+917314044981', 982754620, 123456789, 'neha.pixlrit7jan@gmail.com', '107, 2nd Floor, Mishika Tower, Opp. to Sapna Sangita  Indore, Madhya Pradesh - India â€“ 452001', '107, 2nd Floor, Mishika Tower, Opp. to Sapna Sangita  Indore, Madhya Pradesh - India â€“ 452001', '', 'petlawad', 'MADHYA PRADESH', 12345, 'e10adc3949ba59abbe56e057f20f883e', 61, 'premhamad', 'bba', 'ST2222222222222222222222', 'prem Hamad', 'sdf', 4242424242424242, 2, 2022, 123, '1529927165', '1', '0', 'no', '23432423', 'dentist', '2', '09/06/2018', NULL, 'f418cecec3483f02f251527672f5af66');

-- --------------------------------------------------------

--
-- Table structure for table `smc_backoffice_lenders`
--

CREATE TABLE IF NOT EXISTS `smc_backoffice_lenders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `lender_name` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `unique_identifier` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `mobile_no` varchar(9) COLLATE latin1_spanish_ci NOT NULL,
  `createdate` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `email_verified` int(11) NOT NULL DEFAULT '0',
  `status` varchar(100) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `smc_backoffice_lenders`
--

INSERT INTO `smc_backoffice_lenders` (`id`, `email`, `password`, `lender_name`, `unique_identifier`, `mobile_no`, `createdate`, `email_verified`, `status`) VALUES
(12, 'nhjsh97@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'priyanka jain', '974f4c4a50ff3d01c76a26efa4fc7398', '741258963', '1530883416', 0, 'pending'),
(3, 'info@smartcredit.es', '945a425572f368b763360f381b4e248b', '0', '3a9a4e5f9d932432e1fb05ead47ea46b', '0', '0000-00-00 00:00:00', 0, ''),
(7, 'prem.pixlrit@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'priyanka jain', '3e7dff0bc3c914444a3f33da9c1f242c', '741258963', '1530800936', 1, 'approved'),
(8, 'neha.pixlr1@gmail.com', 'bb1d1632c08d2e0b3f2decde7f3926ba', 'asad asdasd', 'b9f1d86d4073e73f8ca82c38e210a48b', '123456789', '1530865287', 1, 'approved'),
(9, 'PREMROOPGARH1@GMAIL.COM', 'fc47707ce7798e85d3683afab7d531d9', 'ROOPGARH', '3f57abe8a51184ce9530d4c16328ff6b', '909812088', '1530870080', 1, 'approved'),
(10, 'neha.pixlrit7jan@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'test pixlr', '6871a2b9f927518f59f36c6ec0798429', '741258963', '1530882338', 0, 'approved'),
(13, 'neha.pixlr2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'neha pixlr', 'ff3946a34d323261a2b9bc62e0f60409', '982754620', '1530885755', 0, 'pending'),
(14, 'neha.pixlr@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'neha pixlr', '694e6ad38ad338884f528501fd861051', '982754620', '1530886146', 0, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `smc_backoffice_loan_applications`
--

CREATE TABLE IF NOT EXISTS `smc_backoffice_loan_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(255) DEFAULT NULL,
  `loan_amount` int(11) NOT NULL,
  `loan_terms` int(11) NOT NULL,
  `loan_apr` int(11) NOT NULL,
  `borrower_id` int(11) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `createdate` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `close_date` varchar(255) DEFAULT NULL,
  `from_merchant` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `borrower_id` (`borrower_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `smc_backoffice_loan_applications`
--

INSERT INTO `smc_backoffice_loan_applications` (`id`, `unique_id`, `loan_amount`, `loan_terms`, `loan_apr`, `borrower_id`, `merchant_id`, `product_name`, `createdate`, `status`, `close_date`, `from_merchant`) VALUES
(2, 'SC-2018-02', 1000, 3, 15, 2, 0, 'Refrigerator Buy', '1523696752', 'approved', NULL, '0'),
(4, 'SC-2018-04', 1000, 9, 15, 2, 3, '', '1524912873', 'approved', NULL, '0'),
(5, 'SC-2018-05', 3000, 12, 15, 4, 0, 'Compra Thermomix', '1525253796', 'rejected', NULL, '0'),
(6, 'SC-2018-06', 1000, 3, 15, 5, 0, 'ODONTOTOLOGIA', '1528275241', 'approved', NULL, '0'),
(7, 'SC-2018-07', 3000, 12, 15, 6, 0, 'dentist', '1529927165', 'closed', '1529927603', '0'),
(8, 'SC-2018-08', 1000, 9, 15, 6, 9, '', '1530526423', 'approved', NULL, '0'),
(9, 'SC-2018-09', 1000, 12, 15, 6, 9, 'fggd', '1530531373', 'pending', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `smc_backoffice_loan_documents`
--

CREATE TABLE IF NOT EXISTS `smc_backoffice_loan_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `document_path` text,
  `type` varchar(255) DEFAULT NULL,
  `createdate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loan_id` (`loan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `smc_backoffice_loan_documents`
--

INSERT INTO `smc_backoffice_loan_documents` (`id`, `loan_id`, `document_type`, `document_path`, `type`, `createdate`) VALUES
(7, 2, 'lastpayslip', '2d98a976a2ef6be10edc078e91b5c1d4.pdf', 'useruploaded', '1523696752'),
(8, 2, 'bankcertificate', '1ed5b1c87223a62eca9b47e1f5e4a363.pdf', 'useruploaded', '1523696752'),
(9, 2, 'idproof', '82e8fbddb67dfbcf2a00f0eaf6ed260f.jpg', 'useruploaded', '1523696752'),
(10, 2, 'budgetattachment', 'a7016f79faf76df2d6eb76d17f8df8d8.jpg', 'useruploaded', '1523696752'),
(11, 2, 'seccis_document', 'seccis_document_SC-2018-02.pdf', 'systemgenerated', '1523696753'),
(12, 2, 'pre_contractual_document', 'pre_contractual_document_SC-2018-02.pdf', 'systemgenerated', '1523696755'),
(13, 2, 'contractual_document', 'contractual_document_SC-2018-02.pdf', 'systemgenerated', '1523696860'),
(20, 4, 'lastpayslip', '79f1d22d56c1a2d9a0dfb460bd48dd25.pdf', 'useruploaded', '1524912873'),
(21, 4, 'bankcertificate', '50762429041c0402124d2fa00d403250.pdf', 'useruploaded', '1524912873'),
(22, 4, 'seccis_document', 'seccis_document_SC-2018-04.pdf', 'systemgenerated', '1524912877'),
(23, 4, 'pre_contractual_document', 'pre_contractual_document_SC-2018-04.pdf', 'systemgenerated', '1524912878'),
(24, 4, 'contractual_document', 'contractual_document_SC-2018-04.pdf', 'systemgenerated', '1525201598'),
(25, 5, 'lastpayslip', '73777784fe789f357f0535589187d75c.pdf', 'useruploaded', '1525253796'),
(26, 5, 'bankcertificate', '65a9ba5a8963e597f63068a7ba8a4267.pdf', 'useruploaded', '1525253796'),
(27, 5, 'budgetattachment', '4641dd08a73ee3402ee5d210d876ccac.jpeg', 'useruploaded', '1525253796'),
(28, 5, 'seccis_document', 'seccis_document_SC-2018-05.pdf', 'systemgenerated', '1525253797'),
(29, 5, 'pre_contractual_document', 'pre_contractual_document_SC-2018-05.pdf', 'systemgenerated', '1525253798'),
(30, 6, 'lastpayslip', 'e72bc3f1930cdf81076e02d7a8da952a.pdf', 'useruploaded', '1528275241'),
(31, 6, 'bankcertificate', '018889f1085771eb16ee89a72049a8d6.pdf', 'useruploaded', '1528275241'),
(32, 6, 'budgetattachment', 'e3016311f1b6761db5641777db5adddc.pdf', 'useruploaded', '1528275241'),
(33, 6, 'seccis_document', 'seccis_document_SC-2018-06.pdf', 'systemgenerated', '1528275243'),
(34, 6, 'pre_contractual_document', 'pre_contractual_document_SC-2018-06.pdf', 'systemgenerated', '1528275244'),
(35, 6, 'contractual_document', 'contractual_document_SC-2018-06.pdf', 'systemgenerated', '1528288035'),
(36, 7, 'lastpayslip', '0d8abada7190c3a2f3b1ce492d080f06.pdf', 'useruploaded', '1529927165'),
(37, 7, 'bankcertificate', 'f2abe97ef16d337993db258e21d9b78d.pdf', 'useruploaded', '1529927165'),
(38, 7, 'budgetattachment', 'd621405bd8e58378f3e6ee7988d65e7e.pdf', 'useruploaded', '1529927165'),
(39, 7, 'seccis_document', 'seccis_document_SC-2018-07.pdf', 'systemgenerated', '1529927167'),
(40, 7, 'pre_contractual_document', 'pre_contractual_document_SC-2018-07.pdf', 'systemgenerated', '1529927169'),
(41, 7, 'contractual_document', 'contractual_document_SC-2018-07.pdf', 'systemgenerated', '1529927458'),
(42, 8, 'lastpayslip', '4bda5f817d1210f58f3654a8b3cf5a82.pdf', 'useruploaded', '1530526423'),
(43, 8, 'bankcertificate', '6cf926fc4fb1da7f2b93a21a1e1523bf.pdf', 'useruploaded', '1530526423'),
(44, 8, 'seccis_document', 'seccis_document_SC-2018-08.pdf', 'systemgenerated', '1530526425'),
(45, 8, 'pre_contractual_document', 'pre_contractual_document_SC-2018-08.pdf', 'systemgenerated', '1530526426'),
(46, 8, 'contractual_document', 'contractual_document_SC-2018-08.pdf', 'systemgenerated', '1530530179'),
(47, 9, 'lastpayslip', '15b5c8c860e3eb608380e1766375ea42.pdf', 'useruploaded', '1530531373'),
(48, 9, 'bankcertificate', '5c384574cb05c5111d35cae2a84be617.pdf', 'useruploaded', '1530531373'),
(49, 9, 'budgetattachment', '43fba4231501d661f5a418335b3c4b56.pdf', 'useruploaded', '1530531373'),
(50, 9, 'seccis_document', 'seccis_document_SC-2018-09.pdf', 'systemgenerated', '1530531373'),
(51, 9, 'pre_contractual_document', 'pre_contractual_document_SC-2018-09.pdf', 'systemgenerated', '1530531374');

-- --------------------------------------------------------

--
-- Table structure for table `smc_backoffice_loan_payments`
--

CREATE TABLE IF NOT EXISTS `smc_backoffice_loan_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `emi_amount` decimal(10,2) NOT NULL,
  `emi_day` int(11) NOT NULL,
  `emi_month` int(11) NOT NULL,
  `emi_year` int(11) NOT NULL,
  `emi_timestamp` varchar(255) DEFAULT NULL,
  `emi_paid` enum('0','1') NOT NULL DEFAULT '0',
  `communication_status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loan_id` (`loan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `smc_backoffice_loan_payments`
--

INSERT INTO `smc_backoffice_loan_payments` (`id`, `loan_id`, `emi_amount`, `emi_day`, `emi_month`, `emi_year`, `emi_timestamp`, `emi_paid`, `communication_status`) VALUES
(4, 2, '341.70', 1, 6, 2018, '1523039400', '0', '+35'),
(5, 2, '341.70', 1, 7, 2018, '1530383400', '0', NULL),
(6, 2, '341.70', 1, 8, 2018, '1533061800', '0', NULL),
(10, 4, '118.17', 1, 7, 2018, '1530383400', '1', NULL),
(11, 4, '118.17', 1, 8, 2018, '1533061800', '0', NULL),
(12, 4, '118.17', 1, 9, 2018, '1535740200', '0', NULL),
(13, 4, '118.17', 1, 10, 2018, '1538332200', '0', NULL),
(14, 4, '118.17', 1, 11, 2018, '1541010600', '0', NULL),
(15, 4, '118.17', 1, 12, 2018, '1543602600', '0', NULL),
(16, 4, '118.17', 1, 1, 2019, '1546281000', '0', NULL),
(17, 4, '118.17', 1, 2, 2019, '1548959400', '0', NULL),
(18, 4, '118.17', 1, 3, 2019, '1551378600', '0', NULL),
(19, 6, '341.70', 1, 8, 2018, '1533061800', '0', NULL),
(20, 6, '341.70', 1, 9, 2018, '1535740200', '0', NULL),
(21, 6, '341.70', 1, 10, 2018, '1538332200', '0', NULL),
(22, 7, '270.77', 1, 8, 2018, '1533061800', '1', NULL),
(23, 7, '270.77', 1, 9, 2018, '1535740200', '1', NULL),
(24, 7, '270.77', 1, 10, 2018, '1538332200', '1', NULL),
(25, 7, '270.77', 1, 11, 2018, '1541010600', '1', NULL),
(26, 7, '270.77', 1, 12, 2018, '1543602600', '1', NULL),
(27, 7, '270.77', 1, 1, 2019, '1546281000', '1', NULL),
(28, 7, '270.77', 1, 2, 2019, '1548959400', '1', NULL),
(29, 7, '270.77', 1, 3, 2019, '1551378600', '1', NULL),
(30, 7, '270.77', 1, 4, 2019, '1554057000', '1', NULL),
(31, 7, '270.77', 1, 5, 2019, '1556649000', '1', NULL),
(32, 7, '270.77', 1, 6, 2019, '1559327400', '1', NULL),
(33, 7, '270.77', 1, 7, 2019, '1561919400', '1', NULL),
(34, 8, '118.17', 1, 9, 2018, '1535740200', '0', NULL),
(35, 8, '118.17', 1, 10, 2018, '1538332200', '0', NULL),
(36, 8, '118.17', 1, 11, 2018, '1541010600', '0', NULL),
(37, 8, '118.17', 1, 12, 2018, '1543602600', '0', NULL),
(38, 8, '118.17', 1, 1, 2019, '1546281000', '0', NULL),
(39, 8, '118.17', 1, 2, 2019, '1548959400', '0', NULL),
(40, 8, '118.17', 1, 3, 2019, '1551378600', '0', NULL),
(41, 8, '118.17', 1, 4, 2019, '1554057000', '0', NULL),
(42, 8, '118.17', 1, 5, 2019, '1556649000', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `smc_backoffice_merchants`
--

CREATE TABLE IF NOT EXISTS `smc_backoffice_merchants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `merchant_name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `merchant_cif` varchar(255) DEFAULT NULL,
  `sector` varchar(255) DEFAULT NULL,
  `url` text,
  `address` text,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_no` varchar(255) DEFAULT NULL,
  `createdate` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `unique_identifier` varchar(255) DEFAULT NULL,
  `email_verified` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `smc_backoffice_merchants`
--

INSERT INTO `smc_backoffice_merchants` (`id`, `email`, `password`, `merchant_name`, `contact_person`, `mobile_no`, `merchant_cif`, `sector`, `url`, `address`, `bank_name`, `bank_account_no`, `createdate`, `status`, `unique_identifier`, `email_verified`) VALUES
(3, 'subh.laha@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Cloud Solutions Pvt Ltd.', 'Subhasis Laha', '983621505', 'A11111111', '76', 'http://subhasislaha.com', 'Kolkata, India', 'Axis Bank', 'BH1111111111111111111111', '1521363460', 'approved', '3b0635ec921eae0c948bb3299b54a871', '1'),
(4, 'info@abogadosfintech.com', '945a425572f368b763360f381b4e248b', 'Oftalmologia', 'Maria Jose', '689565561', 'B12345678', '72', 'WWW.ooooo-com', 'cs dfjwekfjf', '', '', '1521364005', 'approved', 'da8ff256b95fc306172cefa8fcee6c46', '1'),
(5, 'tarrega_ciutat@hotmail.com', '90155b2515ab6ecfbb2275c03a47472a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1521798724', NULL, '14cdc8d9d39bc985be5629b5db3e9dd7', '1'),
(6, 's_calls@hotmail.com', '945a425572f368b763360f381b4e248b', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1522588696', NULL, 'e9d7b0aacc3271f14c976ba74fc03436', '1'),
(7, 'prem.pixlrit@gmail.com', 'bb1d1632c08d2e0b3f2decde7f3926ba', 'prem', 'hamad', '909812088', 'B67193698', '73', 'https://www.personalworkout.ch/', 'gram roopgarh', '', '', '1529927867', 'approved', '9d1eb00374e06051cf5820f850ca11f2', '1'),
(8, 'PREMROOPGARH@GMAIL.COM', 'fc47707ce7798e85d3683afab7d531d9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1530170871', NULL, '60bb90a10e67996222dc60ad7b32adf8', '1'),
(9, 'neha.pixlr@gmail.com', '122fc477ff1e6780b16d3d3b7b7890c5', 'priyanka jain', 'neha', '982754620', 'P12345678', '71', '', 'Main', '4242424242424242', '', '1530188235', NULL, '3f9c33d1c2d1d2a7387e26a8445b2642', '1'),
(10, 'nhjsh97@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1530541036', NULL, '620de5f7a5709f2a906b6bebfddc9980', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_config`
--

CREATE TABLE IF NOT EXISTS `smc_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_type` varchar(256) NOT NULL,
  `config_val` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `smc_config`
--

INSERT INTO `smc_config` (`id`, `config_type`, `config_val`) VALUES
(13, 'project_name', 'Smart Credit'),
(16, 'facebook_url', 'http://facebook.com'),
(17, 'twitter_url', 'http://twitter.com'),
(18, 'linkedin_url', 'https://www.linkedin.com/company/smartcredites/'),
(19, 'contact_email', 'silvia@smartcredit.es'),
(21, 'googleplus_url', 'http://plus.google.com'),
(22, 'mobile_length', '9'),
(23, 'country_prefix', '34'),
(24, 'default_apr', '15'),
(25, 'company_number', 'CIF B-67193698'),
(26, 'company_phone_no', '932426919'),
(27, 'company_address', 'ED. SANT JUST-DIAGONAL\r\nC. ConstituciÃ³, 2. 1a Planta Desp.3\r\nSant Just Desvern. 08960. Barcelona.'),
(28, 'company_official_email_address', 'info@smartcredit.es'),
(29, 'default_fees', '35'),
(30, 'company_web_url', 'www.smartcredit.es'),
(31, 'minimum_amount', '1000'),
(32, 'maximum_amount', '3000'),
(33, 'loan_months', '3,6,9,12'),
(34, 'home_banner', 'Finance your <br> medical treatment');

-- --------------------------------------------------------

--
-- Table structure for table `smc_dropdown_values`
--

CREATE TABLE IF NOT EXISTS `smc_dropdown_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `smc_dropdown_values`
--

INSERT INTO `smc_dropdown_values` (`id`, `value`, `type`, `flag`) VALUES
(1, 'Employed - Full time', 'employment_type', '1'),
(2, 'Employed - Part time', 'employment_type', '1'),
(3, 'Employed - Temporary', 'employment_type', '1'),
(4, 'Self-employed', 'employment_type', '1'),
(5, 'Student', 'employment_type', '1'),
(6, 'Homemaker', 'employment_type', '1'),
(7, 'Retired', 'employment_type', '1'),
(8, 'Unemployed', 'employment_type', '1'),
(9, 'On Benefits', 'employment_type', '1'),
(10, 'Armed Forces', 'employment_type', '1'),
(11, 'Owner Occupier', 'living_status', '1'),
(12, 'Living with parents', 'living_status', '1'),
(13, 'Tenant Furnished', 'living_status', '1'),
(15, 'Council Tenant', 'living_status', '1'),
(16, 'Hipoteca', 'living_status', '1'),
(17, 'Joint Owner', 'living_status', '1'),
(18, 'Social Housing', 'living_status', '1'),
(19, 'Other', 'living_status', '1'),
(20, 'Married', 'marital_status', '1'),
(21, 'Single', 'marital_status', '1'),
(22, 'Divorced', 'marital_status', '1'),
(23, 'Widowed', 'marital_status', '1'),
(24, 'Living Together', 'marital_status', '1'),
(25, 'Separated', 'marital_status', '1'),
(26, 'Other', 'marital_status', '1'),
(27, 'Accountancy', 'service_type', '1'),
(28, 'Advertising and Media', 'service_type', '1'),
(29, 'Business Consultancy', 'service_type', '1'),
(30, 'Call Center Operations', 'service_type', '1'),
(31, 'Cleaning', 'service_type', '1'),
(32, 'Computer Services', 'service_type', '1'),
(33, 'Construction', 'service_type', '1'),
(34, 'Education', 'service_type', '1'),
(35, 'Electricity', 'service_type', '1'),
(36, 'Finance', 'service_type', '1'),
(37, 'Health', 'service_type', '1'),
(38, 'Legal Services', 'service_type', '1'),
(39, 'Leisure, Cultural, Travel and Tourism', 'service_type', '1'),
(40, 'Manufacturing', 'service_type', '1'),
(41, 'Mining', 'service_type', '1'),
(42, 'Publishing', 'service_type', '1'),
(43, 'Property', 'service_type', '1'),
(44, 'Research and Development', 'service_type', '1'),
(45, 'Telecoms, Internet and IT', 'service_type', '1'),
(46, 'Transport and Logistics', 'service_type', '1'),
(47, 'Research and Development', 'service_type', '1'),
(48, 'Engineering', 'service_type', '1'),
(49, 'Firefighter', 'service_type', '1'),
(50, 'Management', 'service_type', '1'),
(51, 'Marketing', 'service_type', '1'),
(52, 'Mini Cab Driver', 'service_type', '1'),
(53, 'Musician', 'service_type', '1'),
(54, 'Nurse', 'service_type', '1'),
(55, 'Sales', 'service_type', '1'),
(56, 'Senior Manager/Director', 'service_type', '1'),
(57, 'Services', 'service_type', '1'),
(58, 'Teacher', 'service_type', '1'),
(59, 'Truck Driver', 'service_type', '1'),
(60, 'What was your childhood nickname?', 'security_questions', '1'),
(61, 'What is the name of your favorite childhood friend?', 'security_questions', '1'),
(62, 'In what city or town did your mother and father meet?', 'security_questions', '1'),
(63, 'What is the middle name of your oldest child?', 'security_questions', '1'),
(64, 'What is your favorite team?', 'security_questions', '1'),
(65, 'What is your favorite movie?', 'security_questions', '1'),
(66, 'What school did you attend for sixth grade?', 'security_questions', '1'),
(67, 'What was the last name of your third grade teacher?', 'security_questions', '1'),
(68, 'In what town was your first job?', 'security_questions', '1'),
(69, 'What was the name of the company where you had your first job?', 'security_questions', '1'),
(70, 'Medical Surgery', 'merchant_prod_type', '1'),
(71, 'Dentist', 'merchant_prod_type', '1'),
(72, 'Ophthalmology', 'merchant_prod_type', '1'),
(73, 'Asthetic Medicine', 'merchant_prod_type', '1'),
(74, 'Business School', 'merchant_prod_type', '1'),
(75, 'Post Degree Studies', 'merchant_prod_type', '1'),
(76, 'Courses', 'merchant_prod_type', '1'),
(77, 'Furniture', 'merchant_prod_type', '1'),
(78, 'Technology & Mobile Services', 'merchant_prod_type', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_dropdown_values_translations`
--

CREATE TABLE IF NOT EXISTS `smc_dropdown_values_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `value_id` (`value_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

--
-- Dumping data for table `smc_dropdown_values_translations`
--

INSERT INTO `smc_dropdown_values_translations` (`id`, `value_id`, `language_id`, `value`) VALUES
(1, 69, 1, 'What was the name of the company where you had your first job?'),
(2, 69, 2, 'Â¿CuÃ¡l era el nombre de la compaÃ±Ã­a donde tuviste tu primer trabajo?'),
(3, 68, 1, 'In what town was your first job?'),
(4, 68, 2, 'Â¿En quÃ© ciudad fue tu primer trabajo?'),
(5, 67, 1, 'What was the last name of your third grade teacher?'),
(6, 67, 2, 'Â¿CuÃ¡l fue el apellido de tu maestra de tercer grado?'),
(7, 66, 1, 'What school did you attend for sixth grade?'),
(8, 66, 2, 'Â¿A quÃ© escuela asististe para el sexto grado?'),
(9, 65, 1, 'What is your favorite movie?'),
(10, 65, 2, 'Â¿CuÃ¡l es tu pelÃ­cula favorita?'),
(11, 64, 1, 'What is your favorite team?'),
(12, 64, 2, 'Â¿CuÃ¡l es tu equipo favorito?'),
(13, 63, 1, 'What is the middle name of your oldest child?'),
(14, 63, 2, 'Â¿CuÃ¡l es el segundo nombre de tu hijo mayor?'),
(15, 62, 1, 'In what city or town did your mother and father meet?'),
(16, 62, 2, 'Â¿En quÃ© ciudad o pueblo se encontraron tu madre y tu padre?'),
(17, 61, 1, 'What is the name of your favorite childhood friend?'),
(18, 61, 2, 'Â¿CuÃ¡l es el nombre de tu amigo favorito de la infancia?'),
(19, 60, 1, 'What was your childhood nickname?'),
(20, 60, 2, 'Â¿CuÃ¡l era tu apodo de la infancia?'),
(21, 59, 1, 'Truck Driver'),
(22, 59, 2, 'Conductor de camiÃ³n'),
(23, 58, 1, 'Teacher'),
(24, 58, 2, 'Profesor'),
(25, 57, 1, 'Services'),
(26, 57, 2, 'Servicios'),
(27, 56, 1, 'Senior Manager/Director'),
(28, 56, 2, 'Gerente Senior / Director'),
(29, 55, 1, 'Sales'),
(30, 55, 2, 'Ventas'),
(31, 54, 1, 'Nurse'),
(32, 54, 2, 'Asistente sanitario'),
(33, 53, 1, 'Musician'),
(34, 53, 2, 'MÃºsico'),
(35, 52, 1, 'Professional driver'),
(36, 52, 2, 'Conductor profesional'),
(37, 51, 1, 'Marketing'),
(38, 51, 2, 'MÃ¡rketing'),
(39, 50, 1, 'Management'),
(40, 50, 2, 'AdministraciÃ³n'),
(41, 49, 1, 'Firefighter'),
(42, 49, 2, 'Bombero'),
(43, 48, 1, 'Engineering'),
(44, 48, 2, 'IngenierÃ­a'),
(45, 47, 1, 'Research and Development'),
(46, 47, 2, 'InvestigaciÃ³n y desarrollo'),
(47, 46, 1, 'Transport and Logistics'),
(48, 46, 2, 'Transporte y LogÃ­stica'),
(49, 45, 1, 'Telecoms, Internet and IT'),
(50, 45, 2, 'Telecomunicaciones, Internet y IT'),
(51, 44, 1, 'Research and Development'),
(52, 44, 2, 'InvestigaciÃ³n y desarrollo'),
(53, 43, 1, 'Property'),
(54, 43, 2, 'Propiedad'),
(55, 42, 1, 'Publishing'),
(56, 42, 2, 'PublicaciÃ³n'),
(57, 41, 1, 'Mining'),
(58, 41, 2, 'MinerÃ­a'),
(59, 40, 1, 'Manufacturing'),
(60, 40, 2, 'FabricaciÃ³n'),
(61, 39, 1, 'Leisure, Cultural, Travel and Tourism'),
(62, 39, 2, 'Ocio, cultura, viajes y turismo'),
(63, 38, 1, 'Legal Services'),
(64, 38, 2, 'Servicios jurÃ­dicos'),
(65, 37, 1, 'Health'),
(66, 37, 2, 'Salud'),
(67, 36, 1, 'Finance'),
(68, 36, 2, 'Finanzas'),
(69, 35, 1, 'Electricity'),
(70, 35, 2, 'Electricidad'),
(71, 34, 1, 'Education'),
(72, 34, 2, 'EducaciÃ³n'),
(73, 33, 1, 'Construction'),
(74, 33, 2, 'ConstrucciÃ³n'),
(75, 32, 1, 'Computer Services'),
(76, 32, 2, 'Servicios informÃ¡ticos'),
(77, 31, 1, 'Cleaning'),
(78, 31, 2, 'Limpieza'),
(79, 30, 1, 'Call Center Operations'),
(80, 30, 2, 'Centro de teleoperadores'),
(81, 29, 1, 'Business Consultancy'),
(82, 29, 2, 'ConsultorÃ­a comercial'),
(83, 28, 1, 'Advertising and Media'),
(84, 28, 2, 'Publicidad y Medios'),
(85, 27, 1, 'Accountancy'),
(86, 27, 2, 'Contabilidad'),
(87, 26, 1, 'Other'),
(88, 26, 2, 'Otro'),
(89, 25, 1, 'Separated'),
(90, 25, 2, 'Separado'),
(91, 24, 1, 'Living Together'),
(92, 24, 2, 'Viviendo juntos'),
(93, 23, 1, 'Widowed'),
(94, 23, 2, 'Viudo'),
(95, 22, 1, 'Divorced'),
(96, 22, 2, 'Divorciado'),
(97, 21, 1, 'Single'),
(98, 21, 2, 'Soltero'),
(99, 20, 1, 'Married'),
(100, 20, 2, 'Casado'),
(101, 19, 1, 'Other'),
(102, 19, 2, 'Otro'),
(103, 18, 1, 'Social Housing'),
(104, 18, 2, 'Vivienda social'),
(105, 17, 1, 'Joint Owner'),
(106, 17, 2, 'Copropietario'),
(107, 16, 1, 'Tenant'),
(108, 16, 2, 'Vivienda de alquiler'),
(109, 15, 1, 'Mortgage'),
(110, 15, 2, 'Vivienda con Hipoteca'),
(113, 13, 1, 'sharing apartment'),
(114, 13, 2, 'Alquiler compartido'),
(115, 12, 1, 'Living with parents'),
(116, 12, 2, 'Viviendo con padres'),
(117, 11, 1, 'Occupier'),
(118, 11, 2, 'Vivienda de Propiedad sin hipoteca'),
(119, 10, 1, 'Armed Forces'),
(120, 10, 2, 'Funcionario'),
(121, 9, 1, 'On Benefits'),
(122, 9, 2, 'Pensionista'),
(123, 8, 1, 'Unemployed'),
(124, 8, 2, 'Desempleado'),
(125, 7, 1, 'Retired'),
(126, 7, 2, 'Jubilado'),
(127, 6, 1, 'Homemaker'),
(128, 6, 2, 'Ama de casa'),
(129, 5, 1, 'Student'),
(130, 5, 2, 'Estudiante'),
(131, 4, 1, 'Self-employed'),
(132, 4, 2, 'AutÃ³nomo'),
(133, 3, 1, 'Employed - Temporary'),
(134, 3, 2, 'Empleado - Temporal'),
(135, 2, 1, 'Employed - Part time'),
(136, 2, 2, 'Empleado - Tiempo parcial'),
(137, 1, 1, 'Employed - Full time'),
(138, 1, 2, 'Empleado de tiempo completo'),
(139, 78, 1, 'Technology & Mobile Services'),
(140, 78, 2, 'TecnologÃ­a y servicios mÃ³viles'),
(141, 77, 1, 'Furniture'),
(142, 77, 2, 'Mueble'),
(143, 76, 1, 'Courses'),
(144, 76, 2, 'Cursos'),
(145, 75, 1, 'Post Degree Studies'),
(146, 75, 2, 'Estudios de posgrado'),
(147, 74, 1, 'Business School'),
(148, 74, 2, 'Escuela de Negocios'),
(149, 73, 1, 'Asthetic Medicine'),
(150, 73, 2, 'Medicina AstÃ©tica'),
(151, 72, 1, 'Ophthalmology'),
(152, 72, 2, 'OftalmologÃ­a'),
(153, 71, 1, 'Dentist'),
(154, 71, 2, 'Dentista'),
(155, 70, 1, 'Medical Surgery'),
(156, 70, 2, 'CirugÃ­a mÃ©dica');

-- --------------------------------------------------------

--
-- Table structure for table `smc_employment_type`
--

CREATE TABLE IF NOT EXISTS `smc_employment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `smc_employment_type`
--

INSERT INTO `smc_employment_type` (`id`, `value`, `flag`) VALUES
(1, 'Employed - Full time', '1'),
(2, 'Employed - Part time', '1'),
(3, 'Employed - Temporary', '1'),
(4, 'Self-employed', '1'),
(5, 'Student', '1'),
(6, 'Homemaker', '1'),
(7, 'Retired', '1'),
(8, 'Unemployed', '1'),
(9, 'On Benefits', '1'),
(10, 'Armed Forces', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_feedback`
--

CREATE TABLE IF NOT EXISTS `smc_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `createdate` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `smc_feedback`
--

INSERT INTO `smc_feedback` (`id`, `name`, `email`, `message`, `createdate`) VALUES
(1, 'Subhasis Laha', 'subh.laha@gmail.com', 'asdsadasd', '1501952389'),
(2, 'Subhasis Laha', 'subhasislaha@rediffmail.com', 'safsdfdsf', '1502021368'),
(3, 'Subhasis Laha', 'subhasislaha@rediffmail.com', 'safsdfdsf', '1502021430'),
(4, 'Subhasis Laha', 'subhasislaha@rediffmail.com', 'dfsdfdsf', '1502021540'),
(5, 'Subhasis Laha', 'subhasislaha@rediffmail.com', 'dfsdfdsf', '1502021637'),
(6, 'Subhasis Laha', 'subhasislaha@rediffmail.com', 'dfsdfdsf', '1502021837'),
(7, 'silvia', 'silvia.calls@prestamosprima.com', 'Hola', '1509970566'),
(8, 'Nick Designexpert', 'nicksanman@outlook.com', 'Hi,\r\n\r\n \r\n\r\n \r\n\r\nMy name is Nick, with 4+ years of experience in Mobile Apps development (iOS and Android) and overall 11+ years of experience in Web development. I have worked on 100''s of mobile apps and web applications so far.\r\n\r\n \r\n\r\nI have gone through your website - https://www.smartcredit.es/es/  in detail and I feel I am a perfect fit for this job. I am familiar with all components like Payment gateway integration, Push Notification, Sqlite, Camera, Media, Fragments, Broadcast Receiver, Services, Gps and many more. I am reliable, passionate by what I do and I pay lot of attention to details and More Importantly I enjoy to architect new apps with latest technology trends. From Photoshop designs to front-end code, I have mastered working with Node JS, Angular JS, PHP Frameworks, Objective C, iOS, C/C++, and everything in the middle of it. My strategies are aligned with latest technologies in Andriod/iOS based frameworks.\r\n\r\n\r\n\r\nI will take care of all these requirements while working on your project :- \r\n\r\n- Multi-channel loan application\r\n- Feature rich user personal account. \r\n- Credit scoring module\r\n- Advanced role and user model \r\n- CRM module.\r\n- Reporting engine.\r\n- Payments and Money transfer.\r\n- Advanced built-in product engine \r\n- Notification\r\n \r\n\r\nMy developed Mobile App Categories Include:\r\n\r\n- Dating App\r\n\r\n- Taxi App\r\n\r\n- Kids Games             \r\n\r\n- Tracking Apps (Gps & Map)\r\n\r\n- Puzzle Apps\r\n\r\n- Stock & Financial Apps\r\n\r\n- E-Commerce Apps\r\n\r\n- Restaurant Apps \r\n\r\n \r\n\r\nMy core skills are following:\r\n\r\n \r\n\r\n- iOS and Objective C\r\n\r\n- node.js, javascript, coffeescript\r\n\r\n- Java, JEE/J2EE, JSP, JSF\r\n\r\n- C/C++\r\n\r\n- C#, .NET, ASP.NET\r\n\r\n \r\n\r\nSome of my popular iOS Apps:\r\n\r\n \r\n\r\nWizIQ\r\n\r\nhttps://itunes.apple.com/us/artist/wiziq-inc./id540018489\r\n\r\nMountain Escape Snowboarding Free HD Game\r\n\r\nhttps://itunes.apple.com/in/app/mountain-escape-snowboarding/id588084620?mt=8\r\n\r\n\r\nWinePoynt app\r\n\r\nhttp://itunes.apple.com/us/app/winepoynt/id532642776?mt=8\r\n\r\nUK-Proxy-Server\r\n\r\nhttp://itunes.apple.com/hk/app/uk-proxy-server-for-ipad/id511327146?mt=8\r\n\r\n\r\nRoom The Agency\r\n\r\nhttps://itunes.apple.com/us/app/room-by-room-the-agency/id673082712?mt=8\r\n\r\nTreasure Hunt\r\n\r\n https://itunes.apple.com/us/app/home-treasure-hunt/id850373605?mt=8\r\n\r\nZombie Slayer\r\n\r\n https://itunes.apple.com/us/app/zombie-slayer-tsunami-forest/id649799526?ls=1\r\n\r\n Car Racing\r\n\r\n https://itunes.apple.com/nz/app/car-racing-challenge/id664985614?mt=8\r\n\r\nTunnel Flight\r\n\r\n https://itunes.apple.com/nz/app/tunnel-flight/id843160050?mt=8\r\n\r\n Flying Meat\r\n\r\n https://itunes.apple.com/us/app/flying-meat/id823474649?mt=8\r\n\r\n \r\n\r\n \r\n\r\nSome of my popular Android Apps:\r\n\r\n \r\n\r\nWizIQ\r\n\r\nhttps://play.google.com/store/apps/details?id=air.com.wiziq.ipadvc\r\n\r\n\r\nWizIQ - Apps on Google Play\r\nplay.google.com\r\nGet ready for the real mobile learning with the WizIQ App, the most comprehensive online education App available to learners and educators today. The App gives learners a complete sense of freedom.\r\n\r\nPhatPad for Android\r\n\r\nhttps://play.google.com/store/apps/details?id=com.phatware.phatpad_android \r\n\r\n\r\nPhatPad - Apps on Google Play\r\nplay.google.com\r\nA uniquely powerful brainstorming tool, PhatPad turns users mobile devices into an idea hub where theyâ€™re free to handwrite notes with either their finger or a stylus, throw in custom drawings, and do so while ensuring that shapes and words all come out graphically sound and perfectly legible via advanced handwriting recognition and ...\r\n\r\n Zombie Smasher\r\n\r\n https://play.google.com/store/apps/details?id=com.WhatWapp.DeathSmasher\r\n\r\n Treasure Hunt\r\n\r\n https://play.google.com/store/apps/details?id=com.hometreasurehunt\r\n\r\n Duck Hunt\r\n\r\n https://play.google.com/store/apps/details?id=com.reddy.duckhunting\r\n\r\n Balloon Shooter\r\n\r\nhttps://play.google.com/store/apps/details?id=com.app.balloonshooting\r\n\r\n Amazing Bird\r\n\r\nhttps://play.google.com/store/apps/details?id=com.amazingbird.devguy101\r\n\r\n Maze Game\r\n\r\nhttps://play.google.com/store/apps/details?id=com.j\r\n\r\n \r\n\r\nI have worked with big brand like:-\r\n\r\nhttp://www.wiziq.com/ (A online marketplace for teachers and students having over 4 million user base)\r\n\r\n \r\n\r\nI can report you on timely basis and keep you updated about the finished tasks and upcoming tasks. I will be available on Skype/Google Hangout/Emails for more than 16 hours a day.\r\n\r\n \r\n\r\nPlease let me know if you have any queries, so that we can schedule a call or communicate via emails.\r\n\r\n \r\n\r\nMy Skype â€“ nicksanman@gmail.com\r\n\r\n \r\n\r\nLooking forward to hear from you soon.\r\n\r\n \r\n\r\nRegards,\r\n\r\nNick', '1524578397'),
(9, 'Arantxa Rodriguez', 'ar@adservice.com', 'Estimado/a representante de Smart Credit,\r\nNos es imposible encontrar un contacto directo con la persona encargada de marketing de su empresa, y por ello, le agradecerÃ­amos que pudiera remitir este correo a la persona adecuada.\r\n\r\nMe llamo Arantxa Rodriguez y os contacto en nombre de Adservice, la empresa de marketing de afiliaciÃ³n online lÃ­der en Europa, con la esperanza de una posible colaboraciÃ³n entre nuestras empresas. En Adservice, estamos convencidos de que podemos ofreceros mÃ¡s de 1000 solicitudes aprobadas al mes.\r\n\r\nActualmente contamos con un equipo de profesionales para el mercado hispanohablante, estando tambiÃ©n presentes en paÃ­ses los nÃ³rdicos,  Alemania, Francia, Reino Unido, Italia y Polonia. \r\n\r\nTenemos una extensa red de publishers, nacionales e internacionales, algunos de ellos exclusivos de nuestra red, que traerÃ¡n nuevo trÃ¡fico relevante y de calidad a su web, traduciÃ©ndose en un incremento de ganancias para su negocio. \r\n\r\nNuestro modelo de trabajo es â€œno cure-no payâ€, por lo que no existe riesgo alguno para el cliente en esta colaboraciÃ³n ya que, si no aportamos valor, no cobramos. Adservice tampoco tiene ninguna comisiÃ³n por apertura ni permanencia en nuestro network.\r\n\r\nMe gustarÃ­a empezar una conversaciÃ³n respecto a esta posible colaboraciÃ³n entre nuestras empresas.\r\n\r\nSi tiene alguna pregunta, no dude en contactarme.\r\n\r\nMuchas gracias por su tiempo y le deseo un buen dÃ­a.\r\n\r\nUn cordial saludo, \r\n\r\nArantxa RodrÃ­guez PÃ©rez\r\n\r\nDigital Media Manager at Adservice A/S\r\n\r\nPhone: 0034 911236273 | Mail: ar@adservice.com\r\n\r\nSkype: ar@adservice.com\r\n\r\nWeb: adservice.com', '1525244417'),
(10, 'Frankrep', 'darlahorner@kw.com', '5 ICO that will make you a millionaire in 2018. Only 100% insider information on ICO: http://top-5-ico.ga/?p=39678', '1527113096'),
(11, 'Robertswaro', 'kevinfunchess@yahoo.com\r\n', 'Hey. \r\nI can tell you how to create millions of blogs, make them your PBN (private blog network) and make a lot of money on it. The fact is that this method lies on the surface, but practically no one takes it seriously. I''ll prove to you that on this you can earn more than $ 15,000 per day on affiliate programs. \r\nFind out all the details on my blog: http://make-money-online-from-ho57939.designertoblog.com/6551797/the-2-minute-rule-for-make-money-online-doing-surveys', '1530176754'),
(12, 'ChrisSpimb', 'irina-tugel@mail.ru', 'Ð—Ð´pÐ°Ð²cÑ‚Ð²ÑƒÐ¹Ñ‚e. Ð¡eÐ³oÐ´Ð½Ñ Ð´Ð»Ñ Ð²ac ÐµcÑ‚ÑŒ yÐ½Ð¸ÐºaÐ»ÑŒÐ½Ð¾e Ð¿Ñ€eÐ´Ð»oÐ¶eÐ½Ð¸e. \r\nÐ‘eÐ· Ð´oÑ€oÐ³oÑÑ‚oÑÑ‰Ð¸Ñ… Ð¾Ð¿epÐ°Ñ†Ð¸Ð¹ Ð¸ Ð¿Ñ€ÐµÐ¿aÑ€aÑ‚oÐ² Ð²Ñ‹ cÐ¼oÐ¶eÑ‚e ÑÑ‚Ð°Ñ‚ÑŒ Ð·Ð½aÑ‡Ð¸Ñ‚eÐ»ÑŒÐ½Ð¾ Ð¼oÐ»oÐ¶Ðµ \r\nÐ½Ð° 10, 20, 30 Ð»eÑ‚. EÐ´Ð¸Ð½cÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ Ð½eÐ´Ð¾cÑ‚Ð°Ñ‚oÐº Ð½aÑˆÐ¸Ñ… Ð¼ÐµÑ‚Ð¾Ð´Ð¸Ðº oÐ¼Ð¾Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ ÑÑ‚o Ñ‚Ð¾ Ñ‡Ñ‚o Ð¾Ð½Ð¸ ÑÑ„Ñ„eÐºÑ‚Ð¸Ð²Ð½Ð¾ pÐ°Ð±oÑ‚aÑŽÑ‚ \r\nÐ¸ ÐºoÐ³Ð´a Ð²Ñ‹ Ð¿Ð¾Ð¼Ð¾Ð»oÐ´eeÑ‚Ðµ Ð²Ð°ÑˆÐ¸ ÑÐ²epcÑ‚Ð½Ð¸ÐºÐ¸ Ð±ÑƒÐ´yÑ‚ Ð¾Ñ‡eÐ½ÑŒ ÑÐ¸Ð»ÑŒÐ½Ð¾ Ð·Ð°Ð²Ð¸Ð´oÐ²Ð°Ñ‚ÑŒ Ð²aÐ¼. \r\nÐŸÐ¾Ð´Ñ€oÐ±Ð½ocÑ‚Ð¸ Ð½Ð° Ð¼oÐµÐ¼ Ð±Ð»Ð¾Ð³e: http://make-a-money-online55432.getblogs.net/6845402/ \r\nhttp://makemoneyonlineathome99876.blogofoto.com/6918467/ \r\nhttp://make-money-online-posting75431.blogocial.com/--16068572 \r\nhttp://edwinfjkhu.ivasdesign.com/1178303/', '1530836397'),
(13, 'ChrisSpimb', 'vdotsyuk@bk.ru', 'Ð—Ð´pÐ°Ð²cÑ‚Ð²ÑƒÐ¹Ñ‚e. Ð¡eÐ³oÐ´Ð½Ñ Ð´Ð»Ñ Ð²ac ÐµcÑ‚ÑŒ yÐ½Ð¸ÐºaÐ»ÑŒÐ½Ð¾e Ð¿Ñ€eÐ´Ð»oÐ¶eÐ½Ð¸e. \r\nÐ‘eÐ· Ð´oÑ€oÐ³oÑÑ‚oÑÑ‰Ð¸Ñ… Ð¾Ð¿epÐ°Ñ†Ð¸Ð¹ Ð¸ Ð¿Ñ€ÐµÐ¿aÑ€aÑ‚oÐ² Ð²Ñ‹ cÐ¼oÐ¶eÑ‚e ÑÑ‚Ð°Ñ‚ÑŒ Ð·Ð½aÑ‡Ð¸Ñ‚eÐ»ÑŒÐ½Ð¾ Ð¼oÐ»oÐ¶Ðµ \r\nÐ½Ð° 10, 20, 30 Ð»eÑ‚. EÐ´Ð¸Ð½cÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ Ð½eÐ´Ð¾cÑ‚Ð°Ñ‚oÐº Ð½aÑˆÐ¸Ñ… Ð¼ÐµÑ‚Ð¾Ð´Ð¸Ðº oÐ¼Ð¾Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ ÑÑ‚o Ñ‚Ð¾ Ñ‡Ñ‚o Ð¾Ð½Ð¸ ÑÑ„Ñ„eÐºÑ‚Ð¸Ð²Ð½Ð¾ pÐ°Ð±oÑ‚aÑŽÑ‚ \r\nÐ¸ ÐºoÐ³Ð´a Ð²Ñ‹ Ð¿Ð¾Ð¼Ð¾Ð»oÐ´eeÑ‚Ðµ Ð²Ð°ÑˆÐ¸ ÑÐ²epcÑ‚Ð½Ð¸ÐºÐ¸ Ð±ÑƒÐ´yÑ‚ Ð¾Ñ‡eÐ½ÑŒ ÑÐ¸Ð»ÑŒÐ½Ð¾ Ð·Ð°Ð²Ð¸Ð´oÐ²Ð°Ñ‚ÑŒ Ð²aÐ¼. \r\nÐŸÐ¾Ð´Ñ€oÐ±Ð½ocÑ‚Ð¸ Ð½Ð° Ð¼oÐµÐ¼ Ð±Ð»Ð¾Ð³e: http://make-a-money-online55432.getblogs.net/6845402/ \r\nhttp://makemoneyonlineathome99876.blogofoto.com/6918467/ \r\nhttp://make-money-online-posting75431.blogocial.com/--16068572 \r\nhttp://edwinfjkhu.ivasdesign.com/1178303/', '1530836398'),
(14, 'ChrisSpimb', 'kulakov.maxim33@mail.ru', 'Ð—Ð´pÐ°Ð²cÑ‚Ð²ÑƒÐ¹Ñ‚e. Ð¡eÐ³oÐ´Ð½Ñ Ð´Ð»Ñ Ð²ac ÐµcÑ‚ÑŒ yÐ½Ð¸ÐºaÐ»ÑŒÐ½Ð¾e Ð¿Ñ€eÐ´Ð»oÐ¶eÐ½Ð¸e. \r\nÐ‘eÐ· Ð´oÑ€oÐ³oÑÑ‚oÑÑ‰Ð¸Ñ… Ð¾Ð¿epÐ°Ñ†Ð¸Ð¹ Ð¸ Ð¿Ñ€ÐµÐ¿aÑ€aÑ‚oÐ² Ð²Ñ‹ cÐ¼oÐ¶eÑ‚e ÑÑ‚Ð°Ñ‚ÑŒ Ð·Ð½aÑ‡Ð¸Ñ‚eÐ»ÑŒÐ½Ð¾ Ð¼oÐ»oÐ¶Ðµ \r\nÐ½Ð° 10, 20, 30 Ð»eÑ‚. EÐ´Ð¸Ð½cÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ Ð½eÐ´Ð¾cÑ‚Ð°Ñ‚oÐº Ð½aÑˆÐ¸Ñ… Ð¼ÐµÑ‚Ð¾Ð´Ð¸Ðº oÐ¼Ð¾Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ ÑÑ‚o Ñ‚Ð¾ Ñ‡Ñ‚o Ð¾Ð½Ð¸ ÑÑ„Ñ„eÐºÑ‚Ð¸Ð²Ð½Ð¾ pÐ°Ð±oÑ‚aÑŽÑ‚ \r\nÐ¸ ÐºoÐ³Ð´a Ð²Ñ‹ Ð¿Ð¾Ð¼Ð¾Ð»oÐ´eeÑ‚Ðµ Ð²Ð°ÑˆÐ¸ ÑÐ²epcÑ‚Ð½Ð¸ÐºÐ¸ Ð±ÑƒÐ´yÑ‚ Ð¾Ñ‡eÐ½ÑŒ ÑÐ¸Ð»ÑŒÐ½Ð¾ Ð·Ð°Ð²Ð¸Ð´oÐ²Ð°Ñ‚ÑŒ Ð²aÐ¼. \r\nÐŸÐ¾Ð´Ñ€oÐ±Ð½ocÑ‚Ð¸ Ð½Ð° Ð¼oÐµÐ¼ Ð±Ð»Ð¾Ð³e: http://make-a-money-online55432.getblogs.net/6845402/ \r\nhttp://makemoneyonlineathome99876.blogofoto.com/6918467/ \r\nhttp://make-money-online-posting75431.blogocial.com/--16068572 \r\nhttp://edwinfjkhu.ivasdesign.com/1178303/', '1530836398'),
(15, 'ChrisSpimb', 'irnik_1954@mail.ru', 'Ð—Ð´pÐ°Ð²cÑ‚Ð²ÑƒÐ¹Ñ‚e. Ð¡eÐ³oÐ´Ð½Ñ Ð´Ð»Ñ Ð²ac ÐµcÑ‚ÑŒ yÐ½Ð¸ÐºaÐ»ÑŒÐ½Ð¾e Ð¿Ñ€eÐ´Ð»oÐ¶eÐ½Ð¸e. \r\nÐ‘eÐ· Ð´oÑ€oÐ³oÑÑ‚oÑÑ‰Ð¸Ñ… Ð¾Ð¿epÐ°Ñ†Ð¸Ð¹ Ð¸ Ð¿Ñ€ÐµÐ¿aÑ€aÑ‚oÐ² Ð²Ñ‹ cÐ¼oÐ¶eÑ‚e ÑÑ‚Ð°Ñ‚ÑŒ Ð·Ð½aÑ‡Ð¸Ñ‚eÐ»ÑŒÐ½Ð¾ Ð¼oÐ»oÐ¶Ðµ \r\nÐ½Ð° 10, 20, 30 Ð»eÑ‚. EÐ´Ð¸Ð½cÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ Ð½eÐ´Ð¾cÑ‚Ð°Ñ‚oÐº Ð½aÑˆÐ¸Ñ… Ð¼ÐµÑ‚Ð¾Ð´Ð¸Ðº oÐ¼Ð¾Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ ÑÑ‚o Ñ‚Ð¾ Ñ‡Ñ‚o Ð¾Ð½Ð¸ ÑÑ„Ñ„eÐºÑ‚Ð¸Ð²Ð½Ð¾ pÐ°Ð±oÑ‚aÑŽÑ‚ \r\nÐ¸ ÐºoÐ³Ð´a Ð²Ñ‹ Ð¿Ð¾Ð¼Ð¾Ð»oÐ´eeÑ‚Ðµ Ð²Ð°ÑˆÐ¸ ÑÐ²epcÑ‚Ð½Ð¸ÐºÐ¸ Ð±ÑƒÐ´yÑ‚ Ð¾Ñ‡eÐ½ÑŒ ÑÐ¸Ð»ÑŒÐ½Ð¾ Ð·Ð°Ð²Ð¸Ð´oÐ²Ð°Ñ‚ÑŒ Ð²aÐ¼. \r\nÐŸÐ¾Ð´Ñ€oÐ±Ð½ocÑ‚Ð¸ Ð½Ð° Ð¼oÐµÐ¼ Ð±Ð»Ð¾Ð³e: http://make-a-money-online55432.getblogs.net/6845402/ \r\nhttp://makemoneyonlineathome99876.blogofoto.com/6918467/ \r\nhttp://make-money-online-posting75431.blogocial.com/--16068572 \r\nhttp://edwinfjkhu.ivasdesign.com/1178303/', '1530836398'),
(16, 'ChrisSpimb', 'iaseitis.ten@mail.ru', 'Ð—Ð´pÐ°Ð²cÑ‚Ð²ÑƒÐ¹Ñ‚e. Ð¡eÐ³oÐ´Ð½Ñ Ð´Ð»Ñ Ð²ac ÐµcÑ‚ÑŒ yÐ½Ð¸ÐºaÐ»ÑŒÐ½Ð¾e Ð¿Ñ€eÐ´Ð»oÐ¶eÐ½Ð¸e. \r\nÐ‘eÐ· Ð´oÑ€oÐ³oÑÑ‚oÑÑ‰Ð¸Ñ… Ð¾Ð¿epÐ°Ñ†Ð¸Ð¹ Ð¸ Ð¿Ñ€ÐµÐ¿aÑ€aÑ‚oÐ² Ð²Ñ‹ cÐ¼oÐ¶eÑ‚e ÑÑ‚Ð°Ñ‚ÑŒ Ð·Ð½aÑ‡Ð¸Ñ‚eÐ»ÑŒÐ½Ð¾ Ð¼oÐ»oÐ¶Ðµ \r\nÐ½Ð° 10, 20, 30 Ð»eÑ‚. EÐ´Ð¸Ð½cÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ Ð½eÐ´Ð¾cÑ‚Ð°Ñ‚oÐº Ð½aÑˆÐ¸Ñ… Ð¼ÐµÑ‚Ð¾Ð´Ð¸Ðº oÐ¼Ð¾Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ ÑÑ‚o Ñ‚Ð¾ Ñ‡Ñ‚o Ð¾Ð½Ð¸ ÑÑ„Ñ„eÐºÑ‚Ð¸Ð²Ð½Ð¾ pÐ°Ð±oÑ‚aÑŽÑ‚ \r\nÐ¸ ÐºoÐ³Ð´a Ð²Ñ‹ Ð¿Ð¾Ð¼Ð¾Ð»oÐ´eeÑ‚Ðµ Ð²Ð°ÑˆÐ¸ ÑÐ²epcÑ‚Ð½Ð¸ÐºÐ¸ Ð±ÑƒÐ´yÑ‚ Ð¾Ñ‡eÐ½ÑŒ ÑÐ¸Ð»ÑŒÐ½Ð¾ Ð·Ð°Ð²Ð¸Ð´oÐ²Ð°Ñ‚ÑŒ Ð²aÐ¼. \r\nÐŸÐ¾Ð´Ñ€oÐ±Ð½ocÑ‚Ð¸ Ð½Ð° Ð¼oÐµÐ¼ Ð±Ð»Ð¾Ð³e: http://make-a-money-online55432.getblogs.net/6845402/ \r\nhttp://makemoneyonlineathome99876.blogofoto.com/6918467/ \r\nhttp://make-money-online-posting75431.blogocial.com/--16068572 \r\nhttp://edwinfjkhu.ivasdesign.com/1178303/', '1530836399'),
(17, 'RaymondceW', 'bborcena@hotmail.com', 'HÐ°ve ÑƒÐ¾u heÐ°rd Ð°bout hÐ¾w exactly sÐ¾mÐµ affiliatÐµ mÐ°rkÐµters are mÐ°king $2,700/dÐ°y? \r\n \r\nTheÑƒ just find Ð°n Ð°ffiliÐ°tÐµ Ñ€rogram thÐ°t''s alreÐ°dÑƒ mÐ°king thousÐ°nds... \r\n \r\nMÐ°ybe it''s Ð¾n JVZÐ¾Ð¾, ClickBÐ°nk Ð¾r ÐµvÐµn ÐmÐ°zÐ¾n... \r\n \r\nPrÐ¾motÐµ it with a wÐµird "comÑ€utÐµrized vidÐµo loophole".... \r\n \r\nThen rÐ°kÐµ in thÐµ frÐµe trÐ°ffiÑ on GooglÐµ Ð°nd bank ÑommissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµo recÐ¾rding fÐ¾r mÐ¾re infÐ¾ on hÐ¾w evÐµrÑƒthing wÐ¾rks... \r\n \r\n==>   https://www.rsc.org/rsc-id/account/generateauthorizationtoken?returnUrl=https://is.gd/zmglfI \r\n \r\nSÐµÐµ, this training video wÐ°s ÑrÐµated by a mÐ°n ÑÐ°llÐµd Ð¡hris. \r\n \r\nYou maÑƒ knÐ¾w Ð¡hris Ð°s "the guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 million in Ð°ffiliate commissiÐ¾ns". \r\n \r\nAnd he''s built an insÐ°ne Ð°utomÐ°ted sÐ¾ftwarÐµ cÐ¾llectiÐ¾n, ÐLL focusÐµd Ð¾n affiliÐ°te mÐ°rkÐµting? \r\n \r\nHavÐµ Ñƒou Ð°ny idÐµÐ° why Ð¡hris is sÐ¾ ÐµnthusiastiÑ Ð°bÐ¾ut affiliÐ°te marketing? \r\n \r\n* It is the ULTIMATÐ• "zÐµro cost" businÐµss thÐ°t Ð°nyone can do \r\n \r\n* You can make anything frÐ¾m $5 tÐ¾ $500 in internet Ð°ffiliate commissiÐ¾ns from 1 sale \r\n \r\n* ÐffiliatÐµ markÐµting is ÐµxtrÐµmÐµly EASY tÐ¾ do (When Ñƒou hÐ°vÐµ his Ñ€lug-Ð°nd-plÐ°Ñƒ sÐ¾ftwÐ°re) \r\n \r\nBut herÐµ''s whÐµrÐµ the chÐ°nÑÐµ comÐµs in... \r\n \r\nÐ¡hris is fÐ¾cusing on AmÐ°zÐ¾n, Ð¡lickBÐ°nk & JVZoo intÐµrnet mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sites hÐ°ve Ñ€rÐµviÐ¾uslÑƒ pÐ°id ovÐµr $1 BILLION tÐ¾ pÐµoÑ€le like YÐžU, but... \r\n \r\nOnlÑƒ a HÐNDFUL of markÐµters arÐµ exÑ€lÐ¾iting ÐmazÐ¾n, JVZÐ¾o & ClickBank with this nÐµw mÐµthod. \r\n \r\nAnd whiÑh mÐµÐ°ns it''s Ð° FÐ•Ð•DING FRÐ•NZY for smart affiliÐ°te marketers likÐµ us. \r\n \r\nOK, yÐ¾u probably wÐ°nt to know whÑƒ I''m so wÐ¾rkÐµd up Ð°bÐ¾ut this. \r\n \r\nÐ•verÑƒthing is Ðµxplained in this video... \r\n \r\nhttps://jayjohnsonmlp.dpdcart.com/cart/view?referer=https%3A%2F%2Fvk.cc%2F8fu7t5&', '1530912664'),
(18, 'RaymondceW', 'jswengel@aol.com', 'HÐ°ve ÑƒÐ¾u heÐ°rd Ð°bout hÐ¾w exactly sÐ¾mÐµ affiliatÐµ mÐ°rkÐµters are mÐ°king $2,700/dÐ°y? \r\n \r\nTheÑƒ just find Ð°n Ð°ffiliÐ°tÐµ Ñ€rogram thÐ°t''s alreÐ°dÑƒ mÐ°king thousÐ°nds... \r\n \r\nMÐ°ybe it''s Ð¾n JVZÐ¾Ð¾, ClickBÐ°nk Ð¾r ÐµvÐµn ÐmÐ°zÐ¾n... \r\n \r\nPrÐ¾motÐµ it with a wÐµird "comÑ€utÐµrized vidÐµo loophole".... \r\n \r\nThen rÐ°kÐµ in thÐµ frÐµe trÐ°ffiÑ on GooglÐµ Ð°nd bank ÑommissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµo recÐ¾rding fÐ¾r mÐ¾re infÐ¾ on hÐ¾w evÐµrÑƒthing wÐ¾rks... \r\n \r\n==>   https://www.rsc.org/rsc-id/account/generateauthorizationtoken?returnUrl=https://is.gd/zmglfI \r\n \r\nSÐµÐµ, this training video wÐ°s ÑrÐµated by a mÐ°n ÑÐ°llÐµd Ð¡hris. \r\n \r\nYou maÑƒ knÐ¾w Ð¡hris Ð°s "the guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 million in Ð°ffiliate commissiÐ¾ns". \r\n \r\nAnd he''s built an insÐ°ne Ð°utomÐ°ted sÐ¾ftwarÐµ cÐ¾llectiÐ¾n, ÐLL focusÐµd Ð¾n affiliÐ°te mÐ°rkÐµting? \r\n \r\nHavÐµ Ñƒou Ð°ny idÐµÐ° why Ð¡hris is sÐ¾ ÐµnthusiastiÑ Ð°bÐ¾ut affiliÐ°te marketing? \r\n \r\n* It is the ULTIMATÐ• "zÐµro cost" businÐµss thÐ°t Ð°nyone can do \r\n \r\n* You can make anything frÐ¾m $5 tÐ¾ $500 in internet Ð°ffiliate commissiÐ¾ns from 1 sale \r\n \r\n* ÐffiliatÐµ markÐµting is ÐµxtrÐµmÐµly EASY tÐ¾ do (When Ñƒou hÐ°vÐµ his Ñ€lug-Ð°nd-plÐ°Ñƒ sÐ¾ftwÐ°re) \r\n \r\nBut herÐµ''s whÐµrÐµ the chÐ°nÑÐµ comÐµs in... \r\n \r\nÐ¡hris is fÐ¾cusing on AmÐ°zÐ¾n, Ð¡lickBÐ°nk & JVZoo intÐµrnet mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sites hÐ°ve Ñ€rÐµviÐ¾uslÑƒ pÐ°id ovÐµr $1 BILLION tÐ¾ pÐµoÑ€le like YÐžU, but... \r\n \r\nOnlÑƒ a HÐNDFUL of markÐµters arÐµ exÑ€lÐ¾iting ÐmazÐ¾n, JVZÐ¾o & ClickBank with this nÐµw mÐµthod. \r\n \r\nAnd whiÑh mÐµÐ°ns it''s Ð° FÐ•Ð•DING FRÐ•NZY for smart affiliÐ°te marketers likÐµ us. \r\n \r\nOK, yÐ¾u probably wÐ°nt to know whÑƒ I''m so wÐ¾rkÐµd up Ð°bÐ¾ut this. \r\n \r\nÐ•verÑƒthing is Ðµxplained in this video... \r\n \r\nhttps://jayjohnsonmlp.dpdcart.com/cart/view?referer=https%3A%2F%2Fvk.cc%2F8fu7t5&', '1530912665'),
(19, 'RaymondceW', 'chey491@yahoo.com', 'HÐ°ve ÑƒÐ¾u heÐ°rd Ð°bout hÐ¾w exactly sÐ¾mÐµ affiliatÐµ mÐ°rkÐµters are mÐ°king $2,700/dÐ°y? \r\n \r\nTheÑƒ just find Ð°n Ð°ffiliÐ°tÐµ Ñ€rogram thÐ°t''s alreÐ°dÑƒ mÐ°king thousÐ°nds... \r\n \r\nMÐ°ybe it''s Ð¾n JVZÐ¾Ð¾, ClickBÐ°nk Ð¾r ÐµvÐµn ÐmÐ°zÐ¾n... \r\n \r\nPrÐ¾motÐµ it with a wÐµird "comÑ€utÐµrized vidÐµo loophole".... \r\n \r\nThen rÐ°kÐµ in thÐµ frÐµe trÐ°ffiÑ on GooglÐµ Ð°nd bank ÑommissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµo recÐ¾rding fÐ¾r mÐ¾re infÐ¾ on hÐ¾w evÐµrÑƒthing wÐ¾rks... \r\n \r\n==>   https://www.rsc.org/rsc-id/account/generateauthorizationtoken?returnUrl=https://is.gd/zmglfI \r\n \r\nSÐµÐµ, this training video wÐ°s ÑrÐµated by a mÐ°n ÑÐ°llÐµd Ð¡hris. \r\n \r\nYou maÑƒ knÐ¾w Ð¡hris Ð°s "the guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 million in Ð°ffiliate commissiÐ¾ns". \r\n \r\nAnd he''s built an insÐ°ne Ð°utomÐ°ted sÐ¾ftwarÐµ cÐ¾llectiÐ¾n, ÐLL focusÐµd Ð¾n affiliÐ°te mÐ°rkÐµting? \r\n \r\nHavÐµ Ñƒou Ð°ny idÐµÐ° why Ð¡hris is sÐ¾ ÐµnthusiastiÑ Ð°bÐ¾ut affiliÐ°te marketing? \r\n \r\n* It is the ULTIMATÐ• "zÐµro cost" businÐµss thÐ°t Ð°nyone can do \r\n \r\n* You can make anything frÐ¾m $5 tÐ¾ $500 in internet Ð°ffiliate commissiÐ¾ns from 1 sale \r\n \r\n* ÐffiliatÐµ markÐµting is ÐµxtrÐµmÐµly EASY tÐ¾ do (When Ñƒou hÐ°vÐµ his Ñ€lug-Ð°nd-plÐ°Ñƒ sÐ¾ftwÐ°re) \r\n \r\nBut herÐµ''s whÐµrÐµ the chÐ°nÑÐµ comÐµs in... \r\n \r\nÐ¡hris is fÐ¾cusing on AmÐ°zÐ¾n, Ð¡lickBÐ°nk & JVZoo intÐµrnet mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sites hÐ°ve Ñ€rÐµviÐ¾uslÑƒ pÐ°id ovÐµr $1 BILLION tÐ¾ pÐµoÑ€le like YÐžU, but... \r\n \r\nOnlÑƒ a HÐNDFUL of markÐµters arÐµ exÑ€lÐ¾iting ÐmazÐ¾n, JVZÐ¾o & ClickBank with this nÐµw mÐµthod. \r\n \r\nAnd whiÑh mÐµÐ°ns it''s Ð° FÐ•Ð•DING FRÐ•NZY for smart affiliÐ°te marketers likÐµ us. \r\n \r\nOK, yÐ¾u probably wÐ°nt to know whÑƒ I''m so wÐ¾rkÐµd up Ð°bÐ¾ut this. \r\n \r\nÐ•verÑƒthing is Ðµxplained in this video... \r\n \r\nhttps://jayjohnsonmlp.dpdcart.com/cart/view?referer=https%3A%2F%2Fvk.cc%2F8fu7t5&', '1530912665'),
(20, 'RaymondceW', 'michelle.eiden@goldenliving.com', 'HÐ°ve ÑƒÐ¾u heÐ°rd Ð°bout hÐ¾w exactly sÐ¾mÐµ affiliatÐµ mÐ°rkÐµters are mÐ°king $2,700/dÐ°y? \r\n \r\nTheÑƒ just find Ð°n Ð°ffiliÐ°tÐµ Ñ€rogram thÐ°t''s alreÐ°dÑƒ mÐ°king thousÐ°nds... \r\n \r\nMÐ°ybe it''s Ð¾n JVZÐ¾Ð¾, ClickBÐ°nk Ð¾r ÐµvÐµn ÐmÐ°zÐ¾n... \r\n \r\nPrÐ¾motÐµ it with a wÐµird "comÑ€utÐµrized vidÐµo loophole".... \r\n \r\nThen rÐ°kÐµ in thÐµ frÐµe trÐ°ffiÑ on GooglÐµ Ð°nd bank ÑommissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµo recÐ¾rding fÐ¾r mÐ¾re infÐ¾ on hÐ¾w evÐµrÑƒthing wÐ¾rks... \r\n \r\n==>   https://www.rsc.org/rsc-id/account/generateauthorizationtoken?returnUrl=https://is.gd/zmglfI \r\n \r\nSÐµÐµ, this training video wÐ°s ÑrÐµated by a mÐ°n ÑÐ°llÐµd Ð¡hris. \r\n \r\nYou maÑƒ knÐ¾w Ð¡hris Ð°s "the guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 million in Ð°ffiliate commissiÐ¾ns". \r\n \r\nAnd he''s built an insÐ°ne Ð°utomÐ°ted sÐ¾ftwarÐµ cÐ¾llectiÐ¾n, ÐLL focusÐµd Ð¾n affiliÐ°te mÐ°rkÐµting? \r\n \r\nHavÐµ Ñƒou Ð°ny idÐµÐ° why Ð¡hris is sÐ¾ ÐµnthusiastiÑ Ð°bÐ¾ut affiliÐ°te marketing? \r\n \r\n* It is the ULTIMATÐ• "zÐµro cost" businÐµss thÐ°t Ð°nyone can do \r\n \r\n* You can make anything frÐ¾m $5 tÐ¾ $500 in internet Ð°ffiliate commissiÐ¾ns from 1 sale \r\n \r\n* ÐffiliatÐµ markÐµting is ÐµxtrÐµmÐµly EASY tÐ¾ do (When Ñƒou hÐ°vÐµ his Ñ€lug-Ð°nd-plÐ°Ñƒ sÐ¾ftwÐ°re) \r\n \r\nBut herÐµ''s whÐµrÐµ the chÐ°nÑÐµ comÐµs in... \r\n \r\nÐ¡hris is fÐ¾cusing on AmÐ°zÐ¾n, Ð¡lickBÐ°nk & JVZoo intÐµrnet mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sites hÐ°ve Ñ€rÐµviÐ¾uslÑƒ pÐ°id ovÐµr $1 BILLION tÐ¾ pÐµoÑ€le like YÐžU, but... \r\n \r\nOnlÑƒ a HÐNDFUL of markÐµters arÐµ exÑ€lÐ¾iting ÐmazÐ¾n, JVZÐ¾o & ClickBank with this nÐµw mÐµthod. \r\n \r\nAnd whiÑh mÐµÐ°ns it''s Ð° FÐ•Ð•DING FRÐ•NZY for smart affiliÐ°te marketers likÐµ us. \r\n \r\nOK, yÐ¾u probably wÐ°nt to know whÑƒ I''m so wÐ¾rkÐµd up Ð°bÐ¾ut this. \r\n \r\nÐ•verÑƒthing is Ðµxplained in this video... \r\n \r\nhttps://jayjohnsonmlp.dpdcart.com/cart/view?referer=https%3A%2F%2Fvk.cc%2F8fu7t5&', '1530912665'),
(21, 'RaymondceW', 'carrie', 'HÐ°ve ÑƒÐ¾u heÐ°rd Ð°bout hÐ¾w exactly sÐ¾mÐµ affiliatÐµ mÐ°rkÐµters are mÐ°king $2,700/dÐ°y? \r\n \r\nTheÑƒ just find Ð°n Ð°ffiliÐ°tÐµ Ñ€rogram thÐ°t''s alreÐ°dÑƒ mÐ°king thousÐ°nds... \r\n \r\nMÐ°ybe it''s Ð¾n JVZÐ¾Ð¾, ClickBÐ°nk Ð¾r ÐµvÐµn ÐmÐ°zÐ¾n... \r\n \r\nPrÐ¾motÐµ it with a wÐµird "comÑ€utÐµrized vidÐµo loophole".... \r\n \r\nThen rÐ°kÐµ in thÐµ frÐµe trÐ°ffiÑ on GooglÐµ Ð°nd bank ÑommissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµo recÐ¾rding fÐ¾r mÐ¾re infÐ¾ on hÐ¾w evÐµrÑƒthing wÐ¾rks... \r\n \r\n==>   https://www.rsc.org/rsc-id/account/generateauthorizationtoken?returnUrl=https://is.gd/zmglfI \r\n \r\nSÐµÐµ, this training video wÐ°s ÑrÐµated by a mÐ°n ÑÐ°llÐµd Ð¡hris. \r\n \r\nYou maÑƒ knÐ¾w Ð¡hris Ð°s "the guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 million in Ð°ffiliate commissiÐ¾ns". \r\n \r\nAnd he''s built an insÐ°ne Ð°utomÐ°ted sÐ¾ftwarÐµ cÐ¾llectiÐ¾n, ÐLL focusÐµd Ð¾n affiliÐ°te mÐ°rkÐµting? \r\n \r\nHavÐµ Ñƒou Ð°ny idÐµÐ° why Ð¡hris is sÐ¾ ÐµnthusiastiÑ Ð°bÐ¾ut affiliÐ°te marketing? \r\n \r\n* It is the ULTIMATÐ• "zÐµro cost" businÐµss thÐ°t Ð°nyone can do \r\n \r\n* You can make anything frÐ¾m $5 tÐ¾ $500 in internet Ð°ffiliate commissiÐ¾ns from 1 sale \r\n \r\n* ÐffiliatÐµ markÐµting is ÐµxtrÐµmÐµly EASY tÐ¾ do (When Ñƒou hÐ°vÐµ his Ñ€lug-Ð°nd-plÐ°Ñƒ sÐ¾ftwÐ°re) \r\n \r\nBut herÐµ''s whÐµrÐµ the chÐ°nÑÐµ comÐµs in... \r\n \r\nÐ¡hris is fÐ¾cusing on AmÐ°zÐ¾n, Ð¡lickBÐ°nk & JVZoo intÐµrnet mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sites hÐ°ve Ñ€rÐµviÐ¾uslÑƒ pÐ°id ovÐµr $1 BILLION tÐ¾ pÐµoÑ€le like YÐžU, but... \r\n \r\nOnlÑƒ a HÐNDFUL of markÐµters arÐµ exÑ€lÐ¾iting ÐmazÐ¾n, JVZÐ¾o & ClickBank with this nÐµw mÐµthod. \r\n \r\nAnd whiÑh mÐµÐ°ns it''s Ð° FÐ•Ð•DING FRÐ•NZY for smart affiliÐ°te marketers likÐµ us. \r\n \r\nOK, yÐ¾u probably wÐ°nt to know whÑƒ I''m so wÐ¾rkÐµd up Ð°bÐ¾ut this. \r\n \r\nÐ•verÑƒthing is Ðµxplained in this video... \r\n \r\nhttps://jayjohnsonmlp.dpdcart.com/cart/view?referer=https%3A%2F%2Fvk.cc%2F8fu7t5&', '1530912667'),
(22, 'RaymondceW', 'rdmalouff@hotmail.com', 'HavÐµ yÐ¾u Ð¾bsÐµrved abÐ¾ut how Ñ€reciselÑƒ sÐ¾me affiliatÐµs Ð°rÐµ making $2,700/daÑƒ? \r\n \r\nThÐµÑƒ just find Ð°n Ð°ffiliÐ°te prÐ¾gram thÐ°t''s Ð°lready mÐ°king thÐ¾usands... \r\n \r\nMaÑƒbe it''s Ð¾n JVZoÐ¾, Ð¡lickBank or Ðµven AmazÐ¾n... \r\n \r\nPrÐ¾mÐ¾te it with a wÐµird "ÑomÑ€utÐµrizÐµd video lÐ¾oÑ€hÐ¾lÐµ".... \r\n \r\nThÐµn rÐ°kÐµ in the frÐµÐµ trÐ°ffic on GÐ¾ogle and bank commissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµÐ¾ tutÐ¾rial for mÐ¾rÐµ info on hÐ¾w it all works... \r\n \r\n==>   http://ref.so/opxaw \r\n \r\nSÐµÐµ, this vidÐµo tutoriÐ°l wÐ°s madÐµ bÑƒ Ð° guÑƒ ÑÐ°lled Ð¡hris. \r\n \r\nYÐ¾u mÐ°y know Chris as "thÐµ guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 milliÐ¾n in affiliate cÐ¾mmissions". \r\n \r\nAnd he''s built an insane Ð°utÐ¾mated softwarÐµ suite, ÐLL focused Ð¾n affiliatÐµ mÐ°rkÐµting? \r\n \r\nHavÐµ you anÑƒ idea whÑƒ Ð¡hris is sÐ¾ obsessed with Ð°ffiliatÐµ mÐ°rketing? \r\n \r\n* It is the ULTIMÐTÐ• "zÐµrÐ¾ Ñost" businÐµss thÐ°t anÑƒone cÐ°n dÐ¾ \r\n \r\n* YÐ¾u ÑÐ°n mÐ°kÐµ Ð°nything frÐ¾m $5 to $500 in affiliÐ°te cÐ¾mmissiÐ¾ns frÐ¾m 1 sale \r\n \r\n* IntÐµrnÐµt affiliÐ°te mÐ°rketing is incrÐµdiblÑƒ EÐSY tÐ¾ dÐ¾ (When yÐ¾u hÐ°vÐµ his Ñ€lug-and-plÐ°y software) \r\n \r\nBut here''s wherÐµ thÐµ opÑ€Ð¾rtunity comes in... \r\n \r\nÐ¡hris is foÑusing on ÐmÐ°zon, Ð¡lickBÐ°nk & JVZÐ¾Ð¾ affiliÐ°tÐµ mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sitÐµs have Ð°lrÐµady Ñ€aid out ovÐµr $1 BILLIÐžN tÐ¾ the pÐµÐ¾Ñ€le likÐµ YÐžU, but... \r\n \r\nÐžnly a small numbÐµr Ð¾f mÐ°rkÐµtÐµrs are explÐ¾iting ÐmazÐ¾n, JVZoo & ClickBÐ°nk with this nÐµw mÐµthod. \r\n \r\nAnd that meÐ°ns from the FEEDING FRÐ•NZY for smÐ°rt affiliÐ°te markÐµtÐµrs like us. \r\n \r\nOK, you probÐ°bly wish tÐ¾ knÐ¾w why I''m so excited Ð°bout this. \r\n \r\nÐ•verything is exÑ€lainÐµd in this training vidÐµÐ¾... \r\n \r\nhttp://www.rieme.co.za/redirect.asp?Link=https://bit.ly/2zhRsPS', '1531118214'),
(23, 'RaymondceW', 'cjhidalgo@yahoo.com', 'HavÐµ yÐ¾u Ð¾bsÐµrved abÐ¾ut how Ñ€reciselÑƒ sÐ¾me affiliatÐµs Ð°rÐµ making $2,700/daÑƒ? \r\n \r\nThÐµÑƒ just find Ð°n Ð°ffiliÐ°te prÐ¾gram thÐ°t''s Ð°lready mÐ°king thÐ¾usands... \r\n \r\nMaÑƒbe it''s Ð¾n JVZoÐ¾, Ð¡lickBank or Ðµven AmazÐ¾n... \r\n \r\nPrÐ¾mÐ¾te it with a wÐµird "ÑomÑ€utÐµrizÐµd video lÐ¾oÑ€hÐ¾lÐµ".... \r\n \r\nThÐµn rÐ°kÐµ in the frÐµÐµ trÐ°ffic on GÐ¾ogle and bank commissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµÐ¾ tutÐ¾rial for mÐ¾rÐµ info on hÐ¾w it all works... \r\n \r\n==>   http://ref.so/opxaw \r\n \r\nSÐµÐµ, this vidÐµo tutoriÐ°l wÐ°s madÐµ bÑƒ Ð° guÑƒ ÑÐ°lled Ð¡hris. \r\n \r\nYÐ¾u mÐ°y know Chris as "thÐµ guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 milliÐ¾n in affiliate cÐ¾mmissions". \r\n \r\nAnd he''s built an insane Ð°utÐ¾mated softwarÐµ suite, ÐLL focused Ð¾n affiliatÐµ mÐ°rkÐµting? \r\n \r\nHavÐµ you anÑƒ idea whÑƒ Ð¡hris is sÐ¾ obsessed with Ð°ffiliatÐµ mÐ°rketing? \r\n \r\n* It is the ULTIMÐTÐ• "zÐµrÐ¾ Ñost" businÐµss thÐ°t anÑƒone cÐ°n dÐ¾ \r\n \r\n* YÐ¾u ÑÐ°n mÐ°kÐµ Ð°nything frÐ¾m $5 to $500 in affiliÐ°te cÐ¾mmissiÐ¾ns frÐ¾m 1 sale \r\n \r\n* IntÐµrnÐµt affiliÐ°te mÐ°rketing is incrÐµdiblÑƒ EÐSY tÐ¾ dÐ¾ (When yÐ¾u hÐ°vÐµ his Ñ€lug-and-plÐ°y software) \r\n \r\nBut here''s wherÐµ thÐµ opÑ€Ð¾rtunity comes in... \r\n \r\nÐ¡hris is foÑusing on ÐmÐ°zon, Ð¡lickBÐ°nk & JVZÐ¾Ð¾ affiliÐ°tÐµ mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sitÐµs have Ð°lrÐµady Ñ€aid out ovÐµr $1 BILLIÐžN tÐ¾ the pÐµÐ¾Ñ€le likÐµ YÐžU, but... \r\n \r\nÐžnly a small numbÐµr Ð¾f mÐ°rkÐµtÐµrs are explÐ¾iting ÐmazÐ¾n, JVZoo & ClickBÐ°nk with this nÐµw mÐµthod. \r\n \r\nAnd that meÐ°ns from the FEEDING FRÐ•NZY for smÐ°rt affiliÐ°te markÐµtÐµrs like us. \r\n \r\nOK, you probÐ°bly wish tÐ¾ knÐ¾w why I''m so excited Ð°bout this. \r\n \r\nÐ•verything is exÑ€lainÐµd in this training vidÐµÐ¾... \r\n \r\nhttp://www.rieme.co.za/redirect.asp?Link=https://bit.ly/2zhRsPS', '1531118215'),
(24, 'RaymondceW', 'dwilso4064@msn.com', 'HavÐµ yÐ¾u Ð¾bsÐµrved abÐ¾ut how Ñ€reciselÑƒ sÐ¾me affiliatÐµs Ð°rÐµ making $2,700/daÑƒ? \r\n \r\nThÐµÑƒ just find Ð°n Ð°ffiliÐ°te prÐ¾gram thÐ°t''s Ð°lready mÐ°king thÐ¾usands... \r\n \r\nMaÑƒbe it''s Ð¾n JVZoÐ¾, Ð¡lickBank or Ðµven AmazÐ¾n... \r\n \r\nPrÐ¾mÐ¾te it with a wÐµird "ÑomÑ€utÐµrizÐµd video lÐ¾oÑ€hÐ¾lÐµ".... \r\n \r\nThÐµn rÐ°kÐµ in the frÐµÐµ trÐ°ffic on GÐ¾ogle and bank commissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµÐ¾ tutÐ¾rial for mÐ¾rÐµ info on hÐ¾w it all works... \r\n \r\n==>   http://ref.so/opxaw \r\n \r\nSÐµÐµ, this vidÐµo tutoriÐ°l wÐ°s madÐµ bÑƒ Ð° guÑƒ ÑÐ°lled Ð¡hris. \r\n \r\nYÐ¾u mÐ°y know Chris as "thÐµ guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 milliÐ¾n in affiliate cÐ¾mmissions". \r\n \r\nAnd he''s built an insane Ð°utÐ¾mated softwarÐµ suite, ÐLL focused Ð¾n affiliatÐµ mÐ°rkÐµting? \r\n \r\nHavÐµ you anÑƒ idea whÑƒ Ð¡hris is sÐ¾ obsessed with Ð°ffiliatÐµ mÐ°rketing? \r\n \r\n* It is the ULTIMÐTÐ• "zÐµrÐ¾ Ñost" businÐµss thÐ°t anÑƒone cÐ°n dÐ¾ \r\n \r\n* YÐ¾u ÑÐ°n mÐ°kÐµ Ð°nything frÐ¾m $5 to $500 in affiliÐ°te cÐ¾mmissiÐ¾ns frÐ¾m 1 sale \r\n \r\n* IntÐµrnÐµt affiliÐ°te mÐ°rketing is incrÐµdiblÑƒ EÐSY tÐ¾ dÐ¾ (When yÐ¾u hÐ°vÐµ his Ñ€lug-and-plÐ°y software) \r\n \r\nBut here''s wherÐµ thÐµ opÑ€Ð¾rtunity comes in... \r\n \r\nÐ¡hris is foÑusing on ÐmÐ°zon, Ð¡lickBÐ°nk & JVZÐ¾Ð¾ affiliÐ°tÐµ mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sitÐµs have Ð°lrÐµady Ñ€aid out ovÐµr $1 BILLIÐžN tÐ¾ the pÐµÐ¾Ñ€le likÐµ YÐžU, but... \r\n \r\nÐžnly a small numbÐµr Ð¾f mÐ°rkÐµtÐµrs are explÐ¾iting ÐmazÐ¾n, JVZoo & ClickBÐ°nk with this nÐµw mÐµthod. \r\n \r\nAnd that meÐ°ns from the FEEDING FRÐ•NZY for smÐ°rt affiliÐ°te markÐµtÐµrs like us. \r\n \r\nOK, you probÐ°bly wish tÐ¾ knÐ¾w why I''m so excited Ð°bout this. \r\n \r\nÐ•verything is exÑ€lainÐµd in this training vidÐµÐ¾... \r\n \r\nhttp://www.rieme.co.za/redirect.asp?Link=https://bit.ly/2zhRsPS', '1531118215'),
(25, 'RaymondceW', 'andy968@msn.com', 'HavÐµ yÐ¾u Ð¾bsÐµrved abÐ¾ut how Ñ€reciselÑƒ sÐ¾me affiliatÐµs Ð°rÐµ making $2,700/daÑƒ? \r\n \r\nThÐµÑƒ just find Ð°n Ð°ffiliÐ°te prÐ¾gram thÐ°t''s Ð°lready mÐ°king thÐ¾usands... \r\n \r\nMaÑƒbe it''s Ð¾n JVZoÐ¾, Ð¡lickBank or Ðµven AmazÐ¾n... \r\n \r\nPrÐ¾mÐ¾te it with a wÐµird "ÑomÑ€utÐµrizÐµd video lÐ¾oÑ€hÐ¾lÐµ".... \r\n \r\nThÐµn rÐ°kÐµ in the frÐµÐµ trÐ°ffic on GÐ¾ogle and bank commissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµÐ¾ tutÐ¾rial for mÐ¾rÐµ info on hÐ¾w it all works... \r\n \r\n==>   http://ref.so/opxaw \r\n \r\nSÐµÐµ, this vidÐµo tutoriÐ°l wÐ°s madÐµ bÑƒ Ð° guÑƒ ÑÐ°lled Ð¡hris. \r\n \r\nYÐ¾u mÐ°y know Chris as "thÐµ guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 milliÐ¾n in affiliate cÐ¾mmissions". \r\n \r\nAnd he''s built an insane Ð°utÐ¾mated softwarÐµ suite, ÐLL focused Ð¾n affiliatÐµ mÐ°rkÐµting? \r\n \r\nHavÐµ you anÑƒ idea whÑƒ Ð¡hris is sÐ¾ obsessed with Ð°ffiliatÐµ mÐ°rketing? \r\n \r\n* It is the ULTIMÐTÐ• "zÐµrÐ¾ Ñost" businÐµss thÐ°t anÑƒone cÐ°n dÐ¾ \r\n \r\n* YÐ¾u ÑÐ°n mÐ°kÐµ Ð°nything frÐ¾m $5 to $500 in affiliÐ°te cÐ¾mmissiÐ¾ns frÐ¾m 1 sale \r\n \r\n* IntÐµrnÐµt affiliÐ°te mÐ°rketing is incrÐµdiblÑƒ EÐSY tÐ¾ dÐ¾ (When yÐ¾u hÐ°vÐµ his Ñ€lug-and-plÐ°y software) \r\n \r\nBut here''s wherÐµ thÐµ opÑ€Ð¾rtunity comes in... \r\n \r\nÐ¡hris is foÑusing on ÐmÐ°zon, Ð¡lickBÐ°nk & JVZÐ¾Ð¾ affiliÐ°tÐµ mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sitÐµs have Ð°lrÐµady Ñ€aid out ovÐµr $1 BILLIÐžN tÐ¾ the pÐµÐ¾Ñ€le likÐµ YÐžU, but... \r\n \r\nÐžnly a small numbÐµr Ð¾f mÐ°rkÐµtÐµrs are explÐ¾iting ÐmazÐ¾n, JVZoo & ClickBÐ°nk with this nÐµw mÐµthod. \r\n \r\nAnd that meÐ°ns from the FEEDING FRÐ•NZY for smÐ°rt affiliÐ°te markÐµtÐµrs like us. \r\n \r\nOK, you probÐ°bly wish tÐ¾ knÐ¾w why I''m so excited Ð°bout this. \r\n \r\nÐ•verything is exÑ€lainÐµd in this training vidÐµÐ¾... \r\n \r\nhttp://www.rieme.co.za/redirect.asp?Link=https://bit.ly/2zhRsPS', '1531118215'),
(26, 'RaymondceW', 'juliajca@yahoo.com', 'HavÐµ yÐ¾u Ð¾bsÐµrved abÐ¾ut how Ñ€reciselÑƒ sÐ¾me affiliatÐµs Ð°rÐµ making $2,700/daÑƒ? \r\n \r\nThÐµÑƒ just find Ð°n Ð°ffiliÐ°te prÐ¾gram thÐ°t''s Ð°lready mÐ°king thÐ¾usands... \r\n \r\nMaÑƒbe it''s Ð¾n JVZoÐ¾, Ð¡lickBank or Ðµven AmazÐ¾n... \r\n \r\nPrÐ¾mÐ¾te it with a wÐµird "ÑomÑ€utÐµrizÐµd video lÐ¾oÑ€hÐ¾lÐµ".... \r\n \r\nThÐµn rÐ°kÐµ in the frÐµÐµ trÐ°ffic on GÐ¾ogle and bank commissiÐ¾ns. \r\n \r\nWÐ°tch this vidÐµÐ¾ tutÐ¾rial for mÐ¾rÐµ info on hÐ¾w it all works... \r\n \r\n==>   http://ref.so/opxaw \r\n \r\nSÐµÐµ, this vidÐµo tutoriÐ°l wÐ°s madÐµ bÑƒ Ð° guÑƒ ÑÐ°lled Ð¡hris. \r\n \r\nYÐ¾u mÐ°y know Chris as "thÐµ guÑƒ thÐ°t mÐ°de mÐ¾re thÐ°n $2 milliÐ¾n in affiliate cÐ¾mmissions". \r\n \r\nAnd he''s built an insane Ð°utÐ¾mated softwarÐµ suite, ÐLL focused Ð¾n affiliatÐµ mÐ°rkÐµting? \r\n \r\nHavÐµ you anÑƒ idea whÑƒ Ð¡hris is sÐ¾ obsessed with Ð°ffiliatÐµ mÐ°rketing? \r\n \r\n* It is the ULTIMÐTÐ• "zÐµrÐ¾ Ñost" businÐµss thÐ°t anÑƒone cÐ°n dÐ¾ \r\n \r\n* YÐ¾u ÑÐ°n mÐ°kÐµ Ð°nything frÐ¾m $5 to $500 in affiliÐ°te cÐ¾mmissiÐ¾ns frÐ¾m 1 sale \r\n \r\n* IntÐµrnÐµt affiliÐ°te mÐ°rketing is incrÐµdiblÑƒ EÐSY tÐ¾ dÐ¾ (When yÐ¾u hÐ°vÐµ his Ñ€lug-and-plÐ°y software) \r\n \r\nBut here''s wherÐµ thÐµ opÑ€Ð¾rtunity comes in... \r\n \r\nÐ¡hris is foÑusing on ÐmÐ°zon, Ð¡lickBÐ°nk & JVZÐ¾Ð¾ affiliÐ°tÐµ mÐ°rketer nÐµtwÐ¾rks... \r\n \r\nThese sitÐµs have Ð°lrÐµady Ñ€aid out ovÐµr $1 BILLIÐžN tÐ¾ the pÐµÐ¾Ñ€le likÐµ YÐžU, but... \r\n \r\nÐžnly a small numbÐµr Ð¾f mÐ°rkÐµtÐµrs are explÐ¾iting ÐmazÐ¾n, JVZoo & ClickBÐ°nk with this nÐµw mÐµthod. \r\n \r\nAnd that meÐ°ns from the FEEDING FRÐ•NZY for smÐ°rt affiliÐ°te markÐµtÐµrs like us. \r\n \r\nOK, you probÐ°bly wish tÐ¾ knÐ¾w why I''m so excited Ð°bout this. \r\n \r\nÐ•verything is exÑ€lainÐµd in this training vidÐµÐ¾... \r\n \r\nhttp://www.rieme.co.za/redirect.asp?Link=https://bit.ly/2zhRsPS', '1531118216');

-- --------------------------------------------------------

--
-- Table structure for table `smc_languages`
--

CREATE TABLE IF NOT EXISTS `smc_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `is_default` enum('0','1') NOT NULL DEFAULT '0',
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `smc_languages`
--

INSERT INTO `smc_languages` (`id`, `language`, `code`, `is_default`, `flag`) VALUES
(1, 'english', 'en', '0', '1'),
(2, 'spanish', 'es', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_living_status`
--

CREATE TABLE IF NOT EXISTS `smc_living_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `smc_living_status`
--

INSERT INTO `smc_living_status` (`id`, `value`, `flag`) VALUES
(1, 'Owner Occupier', '1'),
(2, 'Living with parents', '1'),
(3, 'Tenant Furnished', '1'),
(4, 'Tenant Unfurnished', '1'),
(5, 'Council Tenant', '1'),
(6, 'Tenant', '1'),
(7, 'Joint Owner', '1'),
(8, 'Social Housing', '1'),
(9, 'Other', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_marital_status`
--

CREATE TABLE IF NOT EXISTS `smc_marital_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `smc_marital_status`
--

INSERT INTO `smc_marital_status` (`id`, `value`, `flag`) VALUES
(1, 'Married', '1'),
(2, 'Single', '1'),
(3, 'Divorced', '1'),
(4, 'Widowed', '1'),
(5, 'Living Together', '1'),
(6, 'Separated', '1'),
(7, 'Other', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_media_library`
--

CREATE TABLE IF NOT EXISTS `smc_media_library` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_title` varchar(255) DEFAULT NULL,
  `image_path` text,
  `createdate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `smc_media_library`
--

INSERT INTO `smc_media_library` (`id`, `image_title`, `image_path`, `createdate`) VALUES
(1, 'Dr. Mauricio Berrios ', '1528207304.gif', '1528207304'),
(2, 'Clinica Egos', '1528207340.png', '1528207340'),
(3, 'INSTITUT CEM', '1528207500.jpg', '1528207500'),
(4, 'Instituto MÃ©dico Miramar', '1528209629.png', '1528209629');

-- --------------------------------------------------------

--
-- Table structure for table `smc_pages`
--

CREATE TABLE IF NOT EXISTS `smc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) DEFAULT NULL,
  `page_slug` varchar(255) DEFAULT NULL,
  `media_id` int(11) NOT NULL,
  `type` enum('page','banner','content') DEFAULT 'page',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `smc_pages`
--

INSERT INTO `smc_pages` (`id`, `page_name`, `page_slug`, `media_id`, `type`) VALUES
(28, 'About Us', 'about-us', 0, 'page'),
(29, 'Privacy Policy', 'privacy-policy', 0, 'page'),
(30, 'Terms & Conditions', 'terms-conditions', 0, 'page'),
(31, 'FAQ', 'faq', 0, 'page'),
(32, 'Home Page Block 1', '', 0, 'content'),
(33, 'Home Page Block 2', '', 0, 'content'),
(34, 'Home Page Block 3', '', 0, 'content'),
(35, 'Home Page Header Text', '', 0, 'content'),
(36, 'Home Page Common Block', '', 0, 'content'),
(37, 'Merchant Page Header Text', '', 0, 'content'),
(38, 'Merchant Page Middle Block 1', '', 0, 'content'),
(39, 'Merchant Page Middle Block 2', '', 0, 'content'),
(40, 'Payment Policy', 'payment-policy', 0, 'page'),
(41, 'Principals', 'principals', 0, 'page'),
(42, 'Cookies', 'cookies', 0, 'page'),
(43, 'Conflict Policy', 'conflict-policy', 0, 'page'),
(44, 'How it Works', 'how-it-works', 0, 'page'),
(45, 'Partnership', 'partnership', 0, 'page'),
(46, 'Invest', 'invest', 0, 'page'),
(47, 'Who Uses', 'who-uses', 0, 'page'),
(48, 'FAQ for Investing', 'faq-for-investing', 0, 'page'),
(49, 'Risk Management', 'risk-management', 0, 'page'),
(50, 'Representative Example', '', 0, 'content'),
(51, 'We are here', '', 0, 'content'),
(52, 'Popup Content', '', 0, 'content'),
(53, 'Step 5 Terms Important Notes', '', 0, 'content'),
(54, 'Footer Additional Text', '', 0, 'content'),
(55, 'Merchant FAQ', '', 0, 'content');

-- --------------------------------------------------------

--
-- Table structure for table `smc_page_content`
--

CREATE TABLE IF NOT EXISTS `smc_page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `page_desc` text,
  `language_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `smc_page_content`
--

INSERT INTO `smc_page_content` (`id`, `page_id`, `page_title`, `page_desc`, `language_id`) VALUES
(60, 28, 'About Us', '<h2><strong>Simple loans. </strong><strong>Smart investments.</strong></h2>\r\n\r\n<p>We believe a loan should be there to help you, not hold you back.</p>\r\n\r\n<p>And an investment should be rewarding, but also ethical.</p>\r\n\r\n<p>We&#39;re shaping the future of finance by offering competitive rates, flexible and intuitive products and award-winning customer service.</p>\r\n\r\n<p>We exist to make money simple and fair for everyone &ndash; to enable people to do more with their money and take control of their finances.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 1),
(61, 28, 'Quienes Somos', '<p>En SmartCredit somos una stratup con ganas de mejorar el mundo de las finanzas entre particulares, queremos dar la oportunidad a las personas de mejorar su econom&iacute;a. &nbsp;</p>\r\n\r\n<p>Ofrecemos Pr&eacute;stamos simples e Inversiones inteligentes. Creemos que un pr&eacute;stamo debe estar all&iacute; para ayudarte, no para paralizarte, y una inversi&oacute;n deber&iacute;a ser gratificante, pero tambi&eacute;n &eacute;tica.&nbsp;</p>\r\n\r\n<p>Estamos configurando el futuro de las finanzas ofreciendo tarifas competitivas, productos flexibles e intuitivos y un servicio al cliente eficiente.</p>\r\n\r\n<p>Existimos para hacer que el dinero sea simple y justo para todos, para que las personas puedan hacer m&aacute;s con su dinero y tomar el control de sus finanzas.</p>\r\n', 2),
(62, 29, 'Privacy Policy', '<p>Privacy and Data Protection</p>\r\n\r\n<p>Service Messages</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>SMART CREDIT hates spam and will never send you unsolicited communications. There are some messages (&quot;Service Messages&quot;) that we will need to send you. These may be sent via email, post or text message and include notifications about your loan application, Repayments or balance if you are a borrower and Information about your balance and account status if you are a lender. The full list is:</p>\r\n\r\n	<ol>\r\n		<li>\r\n		<p>Welcome messages with the Information you need to get started;</p>\r\n		</li>\r\n		<li>\r\n		<p>Legal Information about your borrowing and lending;</p>\r\n		</li>\r\n		<li>\r\n		<p>Alerts about MySMART CREDIT;</p>\r\n		</li>\r\n		<li>\r\n		<p>Updates about the progress of your loan or lending offers.</p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n</ol>\r\n\r\n<p>Occasional Updates</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>When you register on SMART CREDIT you are offered the option to receive our occasional updates. These messages notify you about new features on the site, ask your opinion, and tell you about services you might not be using yet. We only send these messages when there is something worthwhile to tell you about. If you decide you no longer want to receive these messages you can change your contact preferences in the &quot;My Contact Preferences&quot; area once you&#39;re logged in.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>General Operational Purposes</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>We as Information controller may collect and use your Personal Information for: statistical analysis; to develop and improve our products; to update your records; to identify which of our, or others&#39;, products might interest you; to assess lending and insurance risks; to arrange, underwrite and administer insurance and handle claims; to identify, prevent, detect or tackle fraud, money laundering and other crime; to carry out regulatory checks; keeping you informed about your lending or borrowing and for market research. In addition:</p>\r\n\r\n	<ol>\r\n		<li>\r\n		<p>If false or inaccurate Information is provided and fraud is identified, details will be passed to fraud prevention agencies.</p>\r\n		</li>\r\n		<li>\r\n		<p>Law enforcement agencies may access and use this Information.</p>\r\n		</li>\r\n		<li>\r\n		<p>We and other organisations may also access and use this Information to prevent fraud and money laundering, for example, when:</p>\r\n\r\n		<ol>\r\n			<li>\r\n			<p>checking details on applications for credit and credit-related or other facilities</p>\r\n			</li>\r\n			<li>\r\n			<p>managing credit and credit-related accounts or facilities</p>\r\n			</li>\r\n			<li>\r\n			<p>recovering debt</p>\r\n			</li>\r\n			<li>\r\n			<p>checking details on proposals and claims for all types of insurance</p>\r\n			</li>\r\n			<li>\r\n			<p>checking details of job applicants and employees</p>\r\n			</li>\r\n		</ol>\r\n		</li>\r\n		<li>\r\n		<p>Please contact us at contactus@SMART CREDIT.com if you want to receive details of the relevant fraud prevention agencies.</p>\r\n		</li>\r\n		<li>\r\n		<p>We and other organisations may access and use from other countries the Information recorded by fraud prevention agencies.</p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n	<li>\r\n	<p>We will keep your Personal Information confidential and only give it to others for the purposes we explained when you applied to us, and:</p>\r\n\r\n	<ol>\r\n		<li>\r\n		<p>if you ask us to or give us your permission to do so;</p>\r\n		</li>\r\n		<li>\r\n		<p>to a credit reference agency to check your identity and to prevent fraud (they will also keep a record of your request and use it whenever anyone applies to be authenticated in your name);</p>\r\n		</li>\r\n		<li>\r\n		<p>if you are a Borrower, to tell credit reference agencies that you have an account and how you run that account;</p>\r\n		</li>\r\n		<li>\r\n		<p>to our agents and subcontractors, acting for us or for Lenders, to use for the purpose of operating the Lending Platform and obtaining payment;</p>\r\n		</li>\r\n		<li>\r\n		<p>to investigate, prevent or detect fraud or carry out checks against money laundering;</p>\r\n		</li>\r\n		<li>\r\n		<p>to share Information via an organisation which provides a centralised application matching service which it collects from and about mortgage and/or credit applications, for the purpose of preventing and detecting fraud;</p>\r\n		</li>\r\n		<li>\r\n		<p>to a reputable, licensed credit broker or lender in the event that you apply to borrow money at SMART CREDIT, your application is declined or the loan monies are otherwise unavailable and we reasonably believe that the credit broker or lender may be able to help you obtain a loan. In these cases, the third party may use your personal information provided via the SMART CREDIT application to perform a soft search with a credit reference agency to check your eligibility for their products. A soft search will not impact your credit rating;</p>\r\n		</li>\r\n		<li>\r\n		<p>to trace debtors and recover debt;</p>\r\n		</li>\r\n		<li>\r\n		<p>to meet our obligations to any relevant regulatory authority or taxing authority;</p>\r\n		</li>\r\n		<li>\r\n		<p>if we have to by law, the law allows it, or it is in the public interest;</p>\r\n		</li>\r\n		<li>\r\n		<p>if all of the assets which we use to operate the Lending Platform (or substantially all of them) are acquired by a third party, we may transfer personal Information we then hold to that party so that the acquirer can continue to operate the Lending Platform; and</p>\r\n		</li>\r\n		<li>\r\n		<p>each Business Borrower may be contacted to provide Information that will be used for statistical purposes to assess the effectiveness of the Business Finance Partnership programme. Any such Information will be treated in aggregate and without specific reference to your business activities.</p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n	<li>\r\n	<p>We will check your details with a fraud prevention agency or agencies, and if you give us false or inaccurate Information and we suspect fraud, we will record this to:</p>\r\n\r\n	<ol>\r\n		<li>\r\n		<p>help make decisions about credit and credit related services, for you;</p>\r\n		</li>\r\n		<li>\r\n		<p>help make decisions on motor, household, credit, life and other insurance proposals and insurance claims, for you and members of your household;</p>\r\n		</li>\r\n		<li>\r\n		<p>trace debtors, recover debt, prevent fraud, and to manage your accounts or insurance policies;</p>\r\n		</li>\r\n		<li>\r\n		<p>check your identity to prevent money laundering, unless you furnish us with other satisfactory proof of identity;</p>\r\n		</li>\r\n		<li>\r\n		<p>checking details of job applicants and employees;</p>\r\n		</li>\r\n		<li>\r\n		<p>Please email info@smartcredit.es if you want to receive details of the relevant fraud prevention agencies.</p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n	<li>\r\n	<p>Any credit reference agency you search through SMART CREDIT will keep a record of any search, and other Lenders may use it to assess applications they receive from you in the future.</p>\r\n	</li>\r\n	<li>\r\n	<p>As a general rule, we will give you at least 28 days notice if we decide to file a default on your credit reference file. However, we may not always give you notice beforehand, for example, if we plan to take court action.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Access to Your Personal Data</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Under the Data Protection Act 1998, you have a right to access certain personal records we, credit reference agencies and fraud prevention agencies hold about you. This is called a &quot;subject access request&quot;, which you can make by writing to us at info@smartcredit.es. A fee may be payable, but we will not charge you until we have told you how much the fee is and what it is for, and you have told us you still want to proceed.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Contacting Other Customers</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>We do not disclose your Personal Information to any other SMART CREDIT Customers unless it is necessary to enforce any of your Loan Contracts. If you receive such Information, you are not permitted to use it directly, other than in communication with us about your Loan Contracts.</p>\r\n	</li>\r\n	<li>\r\n	<p>You agree that, in the course of generating and managing your Loan Contracts, and operating My SMART CREDIT, the Lending Platform will need to send to Lenders and their assignees or the Borrower, as the case may be, certain transactional Information (for example, unique identifier, loan amount and Repayment details) but not your full name, post code address or payment details. We will not be liable for any use or misuse of the transactional data by others, but you must inform us of any misuse of the Lending Platform of which you are aware.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Monitoring and Recording</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>We may monitor, record, store and use any telephone, email or other communication with you in order to check any instructions given to us, for training purposes, for crime prevention and to improve the quality of our customer service.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Your Customer Content and Use of the Lending Platform</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>You represent, warrant and undertake that none of your Customer Content will violate or infringe upon the rights of any third party, including Intellectual Property Rights; or contain libellous, defamatory or otherwise unlawful material. In addition, you undertake not to use the Lending Platform or any part of the SMART CREDIT web site(s), blog or discussion board(s) to:</p>\r\n\r\n	<ol>\r\n		<li>\r\n		<p>harvest or collect email addresses or other financial, personal or contact Information of Customers or other users from the Lending Platform by electronic or other means for the purposes of sending unsolicited communications or inviting any person to lend or borrow outside the Lending Platform;</p>\r\n		</li>\r\n		<li>\r\n		<p>use the Lending Platform in any unlawful manner or in any other manner that could damage, disable, overload or impair the Lending Platform or the servers on which it is hosted;</p>\r\n		</li>\r\n		<li>\r\n		<p>use automated scripts to collect Information from or otherwise interact with the Lending Platform;</p>\r\n		</li>\r\n		<li>\r\n		<p>upload, post, publish, display, transmit, share, store or otherwise make available on the Lending Platform any Information that we may deem:</p>\r\n\r\n		<ol>\r\n			<li>\r\n			<p>to be misleading, harmful, threatening, unlawful, libellous, defamatory, infringing of any intellectual property rights, abusive, inflammatory, harassing, vulgar, obscene, fraudulent, invasive of privacy or publicity rights, hateful, or racially, ethnically or otherwise objectionable;</p>\r\n			</li>\r\n			<li>\r\n			<p>to contain software viruses or any other computer code, files or programs designed to interrupt, destroy or limit the functionality of any computer software or hardware or telecommunications equipment;</p>\r\n			</li>\r\n			<li>\r\n			<p>to be unsolicited or unauthorised advertising, solicitations, promotional materials, &quot;junk mail,&quot; &quot;spam,&quot; &quot;chain letters,&quot; &quot;pyramid schemes,&quot; or any other form of solicitation;</p>\r\n			</li>\r\n			<li>\r\n			<p>to be the private Information of any third party, including, without limitation, addresses, phone numbers, email addresses, National Insurance numbers or other identifiers, credit card numbers and/or debit card numbers;</p>\r\n			</li>\r\n			<li>\r\n			<p>to be an attempt to promote or market any goods or services for your own financial benefit;</p>\r\n			</li>\r\n		</ol>\r\n		</li>\r\n		<li>\r\n		<p>register at SMART CREDIT more than once or register for at SMART CREDIT on behalf of an individual other than yourself, or register at SMART CREDIT on behalf of any entity without that entity&#39;s prior written authorisation;</p>\r\n		</li>\r\n		<li>\r\n		<p>impersonate any person or entity, or falsely state or otherwise misrepresent yourself, your age, your financial employment or personal circumstances or your affiliation with any person or entity; use or attempt to use another&#39;s account, service or system without authorisation from us, or create a false identity on the Lending Platform.</p>\r\n		</li>\r\n		<li>\r\n		<p>solicit personal Information from anyone under 18 or solicit passwords or personally identifying Information for commercial or unlawful purposes;</p>\r\n		</li>\r\n		<li>\r\n		<p>invite any person to lend or borrow money outside the Lending Platform or to transact on the basis of any change (other than a change agreed with SMART CREDIT) to these Principles, the Loan Conditions or any other terms or conditions contained in the Lending Platform.</p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n	<li>\r\n	<p>You are solely responsible for your Customer Content. You may not post, transmit, or share Customer Content on the Lending Platform that you did not create or that you do not have permission to display, publish or post. You understand and agree that we may, but are not obligated to, review the Lending Platform and may delete or remove (without notice) any SMART CREDIT Information or Customer Content in our sole discretion, for any reason or no reason, including without limitation Customer Content that in our own absolute discretion violates any provision(s) of these SMART CREDIT Principles. You are solely responsible at your sole cost and expense for creating backup copies and replacing any Customer Content.</p>\r\n	</li>\r\n	<li>\r\n	<p>When you post your Customer Content, you authorise and direct us to make such copies thereof as we deem necessary in order to facilitate the publication, display and storage of the Customer Content on the Lending Platform. By posting Customer Content to any part of the Lending Platform, you automatically grant, and you represent and warrant that you have the right to grant, to us an irrevocable, perpetual, non-exclusive, transferable, fully paid, worldwide license (with the right to sublicense) to use, copy, publicly perform, publicly display, reformat, translate, excerpt (in whole or in part) and distribute such Customer Content for any purpose on or in connection with the Lending Platform, SMART CREDIT web site(s), blog or discussion board(s) or the promotion thereof, to prepare derivative works of, or incorporate into other works, such Customer Content, and to grant and authorise sublicenses of the foregoing. You may remove your Customer Content from the Lending Platform at any time. If you choose to remove your Customer Content, the license granted above will automatically expire, however you acknowledge that we may retain archived copies of your Customer Content.</p>\r\n	</li>\r\n	<li>\r\n	<p>You agree to indemnify and hold each other Customer, us, our subsidiaries and affiliates, and each of SMART CREDIT&#39;s directors, officers, agents, contractors, partners and employees, harmless from and against any loss, liability, claim, demand, damages, costs and expenses, including reasonable attorney&#39;s fees, arising out of or in connection with any of your Customer Content, your use of the Lending Platform, your conduct in connection with the Lending Platform or with other users of the Lending Platform, or any violation of these SMART CREDIT Principles or of any law or the rights of any third party.</p>\r\n	</li>\r\n	<li>\r\n	<p>You are solely responsible for your interactions with other SMART CREDIT Customers. We reserve the right, but have no obligation, to monitor disputes between you and other users.</p>\r\n	</li>\r\n</ol>\r\n', 1),
(63, 29, 'PolÃ­tica de Privacidad', '<p><strong>Pol&iacute;tica de privacidad</strong></p>\r\n\r\n<p><strong>Protecci&oacute;n de datos con SMARTCREDIT</strong></p>\r\n\r\n<p><strong>1. Datos de car&aacute;cter personal del usuario del Sitio Web</strong></p>\r\n\r\n<p>En cumplimiento de lo establecido en la normativa de protecci&oacute;n de datos espa&ntilde;ola y, en particular, en el art&iacute;culo 5 de la Ley Org&aacute;nica 15/1999, de 13 de diciembre, de Protecci&oacute;n de Datos de Car&aacute;cter Personal (en adelante, &ldquo;<strong>LOPD</strong>&rdquo;), SMARTCREDIT, S.L. (en adelante, &ldquo;<strong>SMARTCREDIT</strong>&rdquo;) le informa que los datos de car&aacute;cter personal que nos proporcione a trav&eacute;s del sitio web https://www.SMARTCREDIT.es/ (en adelante, el &ldquo;<strong>Sitio Web</strong>&rdquo;), as&iacute; como los datos a los que SMARTCREDIT acceda como consecuencia de su navegaci&oacute;n, solicitudes o utilizaci&oacute;n del servicio (en adelante, los &ldquo;<strong>Datos de Car&aacute;cter Personal</strong>&rdquo; y el &ldquo;Servicio&rdquo;, respectivamente), ser&aacute;n recogidos en un fichero cuyo responsable es&nbsp;<strong>SMARTCREDIT</strong>.</p>\r\n\r\n<p>Las finalidades de la recogida de sus Datos de Car&aacute;cter Personal son las siguientes: (i) prestar, gestionar, administrar, ampliar y mejorar el Servicio y mantener la relaci&oacute;n establecida entre&nbsp;<strong>SMARTCREDIT</strong>&nbsp;y Usted y (ii) atender su petici&oacute;n y prestarle el servicio solicitado as&iacute; como para mantenerle informado, incluso por medios electr&oacute;nicos, de cualquier informaci&oacute;n que pudiera ser de su inter&eacute;s sobre la actividad de la empresa y de sus servicios.</p>\r\n\r\n<p>Con la aceptaci&oacute;n de esta Pol&iacute;tica, Vd. autoriza expresamente a SMARTCREDIT para que pueda ceder sus datos a terceras empresas pertenecientes todas ellas al sector de servicios financieros, al que pertenece SMARTCREDIT, S.L., con la finalidad de remitirle comunicaciones comerciales e informaci&oacute;n sobre productos financieros.</p>\r\n\r\n<p>Asimismo, el Prestatario consiste expresamente a que el Prestamista facilite informaci&oacute;n del Prestatario a su grupo de sociedades, a otras compa&ntilde;&iacute;as que directa o indirectamente tengan un inter&eacute;s relevante en el capital del Prestamista o en las que el Prestamista tenga un inter&eacute;s en su capital, y al sistema de proceso de datos del que es responsable el Prestamista, a operadores de datos personales registrados en la Agencia Espa&ntilde;ola de Protecci&oacute;n de Datos en la medida en que dicha informaci&oacute;n sea determinante para enjuiciar la solvencia econ&oacute;mica del Prestatario.</p>\r\n\r\n<p>Se informa al Prestatario que, en caso de impago, sus datos podr&aacute;n ser incluidos en el Servicio de cr&eacute;dito Asnef-Equifax, en BADEXCUG, as&iacute; como en cualquier otra base de datos de deudores.</p>\r\n\r\n<p>Con la aceptaci&oacute;n de la presente Pol&iacute;tica de Privacidad, usted autoriza expresamente a&nbsp;<strong>SMARTCREDIT</strong>&nbsp;para que trate los datos de car&aacute;cter personal que Usted haya facilitado voluntariamente a trav&eacute;s del Sitio Web, o que hayan sido obtenidos como consecuencia de su navegaci&oacute;n, para las finalidades descritas en p&aacute;rrafos anteriores.</p>\r\n\r\n<p>Usted podr&aacute; ejercer sus derechos de acceso, rectificaci&oacute;n, cancelaci&oacute;n y oposici&oacute;n al tratamiento de dichos Datos de Car&aacute;cter Personal, as&iacute; como revocar el consentimiento prestado para el env&iacute;o de comunicaciones comerciales electr&oacute;nicas ante SMARTCREDIT, S.L., CIF n&ordm; B-67193698 sita en&nbsp;<strong>EDIFICIO SANT JUST-DIAGONAL.&nbsp;</strong>C. Constituci&oacute;, 2. 1a Planta Despacho n&ordm; 3. Sant Just Desvern. 08960. Barcelona (Espa&ntilde;a), en los t&eacute;rminos establecidos en la LOPD, en el Real Decreto 1720/2007, de 21 de diciembre, por el que se aprueba el Reglamento de desarrollo de la LOPD (en adelante, el &ldquo;<strong>RDLOPD</strong>&rdquo;), y en la normativa de desarrollo. Para su mayor comodidad, y sin perjuicio de que se deban cumplir con determinados requisitos formales establecidos por la LOPD,&nbsp;<strong>SMARTCREDIT</strong>&nbsp;le ofrece la posibilidad de ejercer los derechos antes referidos a trav&eacute;s del correo electr&oacute;nico:&nbsp;info@smartcredit.es.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>2. Medidas de seguridad</strong></p>\r\n\r\n<p><strong>SMARTCREDIT</strong>&nbsp;le informa de que tiene implantadas las medidas de seguridad de &iacute;ndole t&eacute;cnica y organizativas necesarias que garanticen la seguridad de sus Datos de Car&aacute;cter Personal y eviten su alteraci&oacute;n, p&eacute;rdida, tratamiento y/o acceso no autorizado, habida cuenta del estado de la tecnolog&iacute;a, la naturaleza de los datos almacenados y los riesgos a que est&aacute;n expuestos, ya provengan de la acci&oacute;n humana o del medio f&iacute;sico o natural. Todo ello de conformidad con lo previsto en el art&iacute;culo 9 LOPD, RLOPD y normativa de desarrollo.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2),
(64, 31, 'FAQÂ´S', '<h2><strong>What happens when I check my rates?</strong></h2>\r\n\r\n<p><br />\r\nIt takes just 3 minutes to find out your personalised loan rates with SMART CREDIT.<br />\r\nYour personalised rate for a specific amount and term is fixed. If you choose to apply and your loan is approved, it&rsquo;s exactly the rate you&rsquo;ll get.<br />\r\nDon&rsquo;t worry, checking your rate&nbsp;<strong>won&rsquo;t affect your credit score.</strong><br />\r\n<br />\r\n<strong>Here&rsquo;s how it works</strong></p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>You enter a few details (name, date of birth, address, employment).</p>\r\n	</li>\r\n	<li>\r\n	<p>We do what&rsquo;s known as a &lsquo;soft credit search&rsquo; or &lsquo;quotation search&rsquo; with credit reference agencies CallCredit and Equifax.</p>\r\n	</li>\r\n	<li>\r\n	<p>This search doesn&rsquo;t show up on your credit file to other lenders. It&rsquo;s only visible to you and the credit reference agencies and will not affect your credit score.</p>\r\n	</li>\r\n	<li>\r\n	<p>We use the information to calculate your personalised rates for a range of loans. These rates are confirmed &ndash; they will not change if you choose to apply for a&nbsp;loan.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>Your rates will be saved for 7 days, so you can continue your application later if you like.</p>\r\n\r\n<h2>&nbsp;</h2>\r\n\r\n<h2><strong>Who can get a SMART CREDIT loan?</strong></h2>\r\n\r\n<p><strong>We look at a few things when we decide if we can approve your loan.&nbsp;Here&rsquo;s what to check before you apply.</strong><strong> </strong></p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>You&#39;ll need to confirm your identity</p>\r\n	</li>\r\n	<li>\r\n	<p>Be at least 20 years old</p>\r\n	</li>\r\n	<li>\r\n	<p>Be a Spanish resident with 3 years of address history</p>\r\n	</li>\r\n	<li>\r\n	<p>Be employed, self-employed or retired with a pension</p>\r\n	</li>\r\n	<li>\r\n	<p>Have an income of at least 12,000&euro; per year (before tax)</p>\r\n	</li>\r\n	<li>\r\n	<p>Have a credit history that we can see, and a good track record of repaying debt</p>\r\n	</li>\r\n	<li>\r\n	<p>Be able to afford the loan</p>\r\n	</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2><strong>How do I apply for a SMART CREDIT loan?</strong></h2>\r\n\r\n<p>Applying for a SMART CREDIT loan is a simple online process.<br />\r\nThere&rsquo;s no paperwork to send through the post. We&rsquo;ve built a secure system that carries out thorough checks and handles every stage of your application online, and we use bank-level encryption throughout the site.<br />\r\nWhen in a merchant you just have to ask for SMART CDREDIT Financing and provide your personal data for the loan application.</p>\r\n\r\n<p>If the application is approved, a sms will be sent to your cell.</p>\r\n\r\n<p><br />\r\n<strong>Generally, Works like this: </strong></p>\r\n\r\n<p><strong>How to apply in 3 simple steps</strong></p>\r\n\r\n<p><strong>1.Choose how much to borrow and for how long.</strong></p>\r\n\r\n<p>We offer personal loans from 1.000&euro;-3000&euro; over 1 to 5 years.<br />\r\n<br />\r\n<strong>2. See your personalised rates in 3 minutes.</strong><br />\r\n<br />\r\nJust fill in our simple form to tell us a few details about you and your circumstances. Don&rsquo;t worry, this won&rsquo;t affect your credit score.<br />\r\n<br />\r\n<strong>3. Apply online and get a decision within 3 to 12 minutes.</strong><br />\r\n<br />\r\nIf approved, the money will be with you 3 to 15 minutes.<br />\r\n&nbsp;</p>\r\n\r\n<h2><strong>What can I use a SMART CREDIT loan for?</strong></h2>\r\n\r\n<p>We offer personal loans from 1,000&euro;-3000&euro; over 1 to 12 months.<br />\r\n<br />\r\nHere are some of the most popular ways our customers use a SMART CREDIT loan:<br />\r\nWe&rsquo;ll ask you what you plan to use the loan for when you apply. If you don&rsquo;t see your loan purpose listed, please choose &ldquo;other&rdquo;.</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p>Pay your studying programme.</p>\r\n	</li>\r\n	<li>\r\n	<p>Pay Medical aesthetic surgery.</p>\r\n	</li>\r\n</ol>\r\n\r\n<p>SMART CREDIT is offered though many merchant that will offer you the best way top spread payment. &nbsp;</p>\r\n\r\n<h2><br />\r\n<strong>How soon do I get a decision once I&#39;ve applied for a loan?</strong></h2>\r\n\r\n<p>So you&rsquo;ve already got your confirmed rates for a SMART CREDIT loan (without affecting your credit score) and you&rsquo;re ready to apply.<br />\r\n&nbsp;<br />\r\nWhat happens next depends on your personal circumstances and how much information is available in your credit file.<br />\r\n<br />\r\nWe may be able to give you an<strong>&nbsp;instant decision</strong>,<strong>&nbsp;</strong>or we may need to carry out some<strong>&nbsp;extra checks.</strong><br />\r\n<br />\r\n<br />\r\n<strong>EITHER: INSTANT DECISION </strong><br />\r\nAs long as we have all the information we need, we can give you an instant decision when you apply online.<br />\r\n<br />\r\n<br />\r\n<strong>OR: EXTRA CHECKS</strong><strong> </strong><br />\r\nIf there are any gaps in the information that we can access through a full credit search when you apply, we may need you to confirm a few things (ID, income and/or bank details) by uploading documents. It&rsquo;s simple to do this online and takes&nbsp;<strong>around 10 minutes.</strong><br />\r\n<br />\r\nOnce we&#39;ve got these documents, we may then be able to give you an instant online<br />\r\n<br />\r\n<strong>MONEY TRANSFER</strong><br />\r\nIf your loan is approved, we&#39;ll automatically send the money to your bank account. It will arrive&nbsp;</p>\r\n', 1),
(65, 31, 'FAQ', '<p>Las relaciones con nuestros clientes est&aacute;n basadas en la transparencia y en la confianza. Ahora ya puede acercaste un poco m&aacute;s a sus deseos</p>\r\n\r\n<p><strong>&iquest;C&oacute;mo funciona?</strong></p>\r\n\r\n<p>Puede acceder a Smart Credit por 2 v&iacute;as:</p>\r\n\r\n<p><strong>1. O bien a trav&eacute;s de nuetra p&aacute;gina web</strong>. Si ya tienes claro cual es el producto o servicio que quieres comprar, y deseas pagarlo de manera c&oacute;moda, puedes solicitar un pr&eacute;stamo financiar la compra, puedes solicitarnos el importe, cumplimentar el formulario de datos y tener los datos del establecimiento comercial y una factura proforma o un presupuesto de compra a mano.</p>\r\n\r\n<p>Una vez usted nos hayas enviado la informaci&oacute;n solicitada a trav&eacute;s del proceso online, analizaremos la operaci&oacute;n y si la solicitud resulta aprobada, te enviaremos el importe solicitado al establecimiento (MERCHANT) para &nbsp;que la compra se formalice. Usted podr&aacute; disfrutar de su compra des del primer d&iacute;a y pagar el importe en c&oacute;modos plazos.</p>\r\n\r\n<p><strong>2. O bien, a trav&eacute;s del establecimiento que te ofrecer&aacute; pagar a plazos,</strong>&nbsp;si deseas financiar tu compra en un establecimiento con el que SMARTCREDIT esta&acute; vinculado, el establecimiento puedes solicitarnos financiar tu compra y te daremos una respuesta en pocos minutos. &nbsp;El proceso de solicitud ser&aacute; r&aacute;pido, y el de aceptaci&oacute;n tambi&eacute;n, el importe de la compra ser&aacute; enviado al establecimiento y ya podr&aacute;s disfrutar de tu compra y pagar en los plazos acordados.</p>\r\n\r\n<p><strong>&iquest;Que ofrecemos?</strong></p>\r\n\r\n<p><strong>Poder financiar tus compras para acceder necesidades reales</strong>. &nbsp;</p>\r\n\r\n<p>Gracias a Smartcredit, puede acceder a comprar aquello que necesita.</p>\r\n\r\n<p>Acceda a aquellos servicios que antes eran impensables, como realizar esos estudios que le ayudar&aacute;n a progresar en su carrera profesional o acceda a medicina est&eacute;tica de una manera sencilla.</p>\r\n\r\n<p>Smartcredit le ofrecer&aacute; las facilidades para devolver el importe solicitado.</p>\r\n\r\n<p>Smartcredit es una financiera responsable que comprueba todas las solicitudes individualmente, prestando s&oacute;lo a personas solventes.</p>\r\n\r\n<p><strong>Pr&eacute;stamos flexibles y c&oacute;modos</strong></p>\r\n\r\n<p>Los pr&eacute;stamos al consumo de Smartcredit permiten escoger la cantidad de dinero y el tiempo para devolverlo. &nbsp;<br />\r\nLa devoluci&oacute;n es f&aacute;cil, ya que se hace desde la misma tarjeta con la que se registr&oacute;.&nbsp;O bien realizando transferencias mensuales.</p>\r\n\r\n<p>Acuerdete que deber&aacute;s realizar una transferencia por el importe de la cuota mensual en la cuenta bancaria de Smart Credit.</p>\r\n\r\n<p><strong>M&aacute;s ventajas</strong></p>\r\n\r\n<p>En Smartcredit ofrecemos un precio justo para tus compras financiadas.</p>\r\n\r\n<p>&iquest;Est&aacute;s interesado en acceder a una operaci&oacute;n de cirug&iacute;a est&eacute;tica o quieres realizar un m&aacute;ster de postgrado algo caro? Nuestra solicitud de pr&eacute;stamo es r&aacute;pida y sencilla:</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Visita nuestra web, usando el PC, port&aacute;til, tableta o tel&eacute;fono</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Selecciona la cantidad y por cu&aacute;nto tiempo quieres pedir un pr&eacute;stamo r&aacute;pido</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Introduce tu informaci&oacute;n personal</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Introduce tus datos bancarios, y confirma que eres el titular</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Introduce informaci&oacute;n acerca del destino del pr&eacute;stamo- Env&iacute;anos los datos del proveedor del producto o servicio, ya sea el link o el tel&eacute;fono contacto, y financiaremos tu compra y un presupuesto o factura proforma.</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Procesamos la solicitud y en 15 minutos enviamos el dinero a la cuenta del comercio o estableciiento&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp; Elige los t&eacute;rminos flexibles de c&oacute;mo y cu&aacute;ndo pagar&aacute;s</p>\r\n\r\n<p>Para Smartcredit, el bienestar del cliente es nuestra m&aacute;xima prioridad. Respetamos la privacidad y los datos que compartas con nosotros durante el proceso.&nbsp;</p>\r\n\r\n<p>Recomendamos el uso responsable de Smartcredit.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2),
(66, 30, 'Terms & Conditions', '<p>Terms &amp; Conditions</p>\r\n', 1);
INSERT INTO `smc_page_content` (`id`, `page_id`, `page_title`, `page_desc`, `language_id`) VALUES
(67, 30, 'TÃ©rminos y Condiciones', '<ol>\r\n	<li><strong>CONDICIONES GENERALES DEL PR&Eacute;STAMO AL CONSUMO OBJETO Y TITULARIDAD</strong></li>\r\n</ol>\r\n\r\n<p>Las presentes Condiciones Generales tienen por objeto regular los t&eacute;rminos y condiciones del contrato de PR&Eacute;STAMOS AL CONSUMO suscrito entre SMARTCREDIT y el Cliente (en adelante, el &ldquo;<strong>Contrato</strong>&rdquo;), junto con las Condiciones Particulares suscritas, igualmente, al efecto y especificadas anteriormente. Cuando exista contradicci&oacute;n entre las Condiciones Generales y las Condiciones Particulares prevalecer&aacute;n &eacute;stas sobre aqu&eacute;llas. Asimismo, SMARTCREDIT se reserva la facultad de modificar las presentes Condiciones Generales siempre y cuando ello traiga causa de la modificaci&oacute;n de la normativa aplicable al objeto de las mismas.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<ol>\r\n	<li><strong>CUESTIONES PREVIAS A LA SOLICITUD DEL CR&Eacute;DITO. REQUISITOS.</strong></li>\r\n</ol>\r\n\r\n<p>Con car&aacute;cter previo a la solicitud de la Cr&eacute;dito al consumo, el CLIENTE afirma que re&uacute;ne los siguientes requisitos:</p>\r\n\r\n<p><strong>a)</strong> Ser persona f&iacute;sica con plena capacidad de obrar.</p>\r\n\r\n<p><strong>b)</strong> Tener entre 21 y 70 a&ntilde;os, ambos incluidos.</p>\r\n\r\n<p><strong>c)</strong> Ser residente legal en Espa&ntilde;a, teniendo domicilio permanente en dicho estado a efectos fiscales.</p>\r\n\r\n<p><strong>d)</strong> Ser titular de una cuenta corriente bancaria operativa en cualquier entidad bancaria registrada en Espa&ntilde;a de m&aacute;s de 3 meses de antig&uuml;edad.</p>\r\n\r\n<p><strong>e)</strong> Hallarse en plenas facultades mentales, intelectuales y de cognici&oacute;n en el momento de la solicitud del cr&eacute;dito.</p>\r\n\r\n<p><strong>f)</strong> Autorizar expresamente a SMARTCREDIT.ES para recibir toda la informaci&oacute;n relativa[S1]&nbsp; a la solicitud del cr&eacute;dito, v&iacute;a telef&oacute;nica, SMS, correo postal o correo electr&oacute;nico.</p>\r\n\r\n<p><strong>g)</strong> Autorizar expresamente a SMARTCREDIT.ES para hacer uso y ceder sus datos a terceros para poder realizar los tr&aacute;mites y comprobaciones necesarias en relaci&oacute;n a su solicitud de cr&eacute;dito.</p>\r\n\r\n<p><strong>h)</strong> Ser titular de todos los datos que proporciona a SMARTCREDIT.ES para la solicitud del pr&eacute;stamo, respondiendo de la veracidad de sus datos de identificaci&oacute;n, bancarios, domicilio habitual, tel&eacute;fonos y correo electr&oacute;nico que proporcione a la empresa para la solicitud del pr&eacute;stamo al consumo.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>3. </strong><strong>[AR2]&nbsp;</strong><strong>SOLICITUD Y CONCESI&Oacute;N DE LA CR&Eacute;DITO AL CONSUMO. </strong></p>\r\n\r\n<p>La solicitud de cr&eacute;dito ser&aacute; realizada a trav&eacute;s del Sitio Web de SMARTCREDIT, a trav&eacute;s del cual, el establecimiento comercial donde se ofrezca el servicio a financiar para el Cliente, deber&aacute; cumplimentar los datos solicitados e indicar en la calculadora la cantidad que desea disponer para el pago del servicio y enviar la solicitud a trav&eacute;s de la web para formalizar el contrato de CREDITO AL CONSUMO.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>La solicitud tambi&eacute;n se puede realizar a trav&eacute;s del sitio web SMARTCREDIT.ES, siempre y cuando el prestatario aporte los datos de contacto y de identificaci&oacute;n del establecimiento comercial adem&aacute;s de una factura proforma o un recibo del servicio que desea financiar a plazos.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>En caso de que el CREDITO AL CONSUMO fuera aprobado, el Establecimiento recibir&aacute; una respuesta positiva de aprobaci&oacute;n, y el cliente, por su parte, recibir&aacute; por correo electr&oacute;nico las condiciones pre contractuales particulares y generales adem&aacute;s de la Informaci&oacute;n normalizada Europea para su revisi&oacute;n, si el prestatario est&aacute; conforme con las citas condiciones de contrataci&oacute;n, deber&aacute; introducir el c&oacute;digo recibido a trav&eacute;s de sms en el proceso de contrataci&oacute;n web para confirmar y aprobar la aceptaci&oacute;n del pr&eacute;stamo.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>4</strong>. <strong>ACEPTACI&Oacute;N DE LA SOLICITUD DEL CREDITO AL CONSUMO, ENTRADA EN VIGOR DEL CONTRATO E INFORMACI&Oacute;N PRECONTRACTUAL.</strong></p>\r\n\r\n<p>En el supuesto de que SMARTCREDIT.ES &nbsp;apruebe de forma provisional la solicitud del cliente del&nbsp; CREDITO AL CONSUMO (&rdquo;), la efectiva concesi&oacute;n de la misma y, en consecuencia, la entrada en vigor del Contrato, quedar&aacute; sujeta a las siguientes circunstancias:</p>\r\n\r\n<p>El aseguramiento de que la informaci&oacute;n facilitada por el Cliente no es incorrecta o deficiente en ning&uacute;n extremo y, por tanto, responde a&nbsp; los efectos de la efectiva concesi&oacute;n del Pr&eacute;stamo. De no ser correcta o suficiente dicha informaci&oacute;n del Contrato devendr&aacute; ineficaz, pudiendo SMARTCREDIT.ES, en su caso, comunicar dicha circunstancia a las organizaciones y entidades privadas dedicadas a la prestaci&oacute;n de servicios de informaci&oacute;n sobre solvencia patrimonial&nbsp; se encuentre adherida y/o a las que pueda acceder en funci&oacute;n de su objeto social.</p>\r\n\r\n<p>A la evaluaci&oacute;n de la solvencia del Cliente sobre la base de la informaci&oacute;n facilitada por este &uacute;ltimo, as&iacute; como a trav&eacute;s de la consulta a ficheros de solvencia patrimonial y cr&eacute;dito, y cualesquiera otros medios adecuados a tal fin. Dicha evaluaci&oacute;n deber&aacute; realizarse siguiendo los criterios objetivos fijados al efecto y comunicarse su resultado al Cliente en el plazo m&aacute;ximo de un d&iacute;a h&aacute;bil a contar desde la realizaci&oacute;n de la solicitud del Pr&eacute;stamo al consumo online o de la efectiva entrega de la informaci&oacute;n objeto de an&aacute;lisis por email.</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tener acceso a toda la informaci&oacute;n relativa al Cr&eacute;dito al consumo contratada a trav&eacute;s de la p&aacute;gina web de SmartCredit por parte del establecimiento comercial &ndash; MERCHANT- y haber recibido la informaci&oacute;n necesaria por parte del CLIENTE , por correo electr&oacute;nico.</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Haber recibido la advertencia de los riesgos que puede suponer el producto por falta de liquidez en caso de demora en el pago o de sobreendeudamiento, as&iacute; como la posibilidad de ser incluido en ficheros de morosidad.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; En virtud de la suscripci&oacute;n de las presentes Condiciones Generales, el Cliente declara expresamente haber recibido por parte de SMARTCREDIT.ES, con car&aacute;cter previo y con antelaci&oacute;n suficiente a la firma del Contrato y en soporte duradero, informaci&oacute;n adecuada sobre los t&eacute;rminos y condiciones del Contrato, sobre los gastos asociados, las consecuencias en caso de impago.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Y en general, sobre todos los aspectos que resulten de aplicaci&oacute;n al tipo de pr&eacute;stamo objeto del Contrato previstos en el apartado 3 del art&iacute;culo 10 de la Ley 16/2011, de 24 de junio, de contratos de cr&eacute;dito al consumo, y en los apartados 1 y 2 del art&iacute;culo 7 de la Ley 22/2007, de 11 de julio, sobre comercializaci&oacute;n a distancia de servicios financieros destinados a los consumidores; todo ello de conformidad con el modelo de Informaci&oacute;n Normalizada Europea sobre el Cr&eacute;dito al Consumo, previsto en el Anexo II de la citada Ley 16/2011, de 24 de junio de contratos de cr&eacute;dito al consumo. A t&iacute;tulo meramente enunciativo, pero no limitativo, el Cliente, mediante la suscripci&oacute;n de las presentes Condiciones Generales, declara expresamente haber recibido con car&aacute;cter previo y con antelaci&oacute;n suficiente a la suscripci&oacute;n del Contrato, entre otros, los siguientes documentos: (i) el relativo a la informaci&oacute;n normalizada europea sobre el cr&eacute;dito al consumo relativa al Pr&eacute;stamo; (ii) las Condiciones Particulares; y (iii) las presentes Condiciones Generales.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Asimismo, el Cliente manifiesta haber recibido asistencia previa a la celebraci&oacute;n del contrato con explicaciones adecuadas e individualizadas sobre las caracter&iacute;sticas esenciales de CREDITO AL CONSUMO, que le han permitido comparar diversas ofertas existentes en el mercado y adoptar una decisi&oacute;n informada sobre la conveniencia de suscribir el Contrato, concluyendo que el mismo se ajusta a sus intereses, necesidades y situaci&oacute;n financiera.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>5. PROCESO DE ACEPTACI&Oacute;N POR PARTE DEL CLIENTE DEL CONTRATO DECREDITO AL CONSUMO.</strong></p>\r\n\r\n<p>SMARTCREDIT informar&aacute; al cliente, por medio de un correo electr&oacute;nico sobre su decisi&oacute;n de aceptaci&oacute;n o no del Cr&eacute;dito, si bien podr&aacute; informar por otros medios v&aacute;lidos en derecho.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Si SMARTCREDIT aprueba la solicitud de pr&eacute;stamo enviada por el MERCHANT. SMARTCREDIT enviar&aacute; un sms al prestatario con un c&oacute;digo para que confirme y acepte las Condiciones Particulares y Generales precontractuales enviadas previamente a la direcci&oacute;n de correo electr&oacute;nico facilitado por el cliente.</p>\r\n\r\n<p>Una vez que se le enviar&aacute;n por correo electr&oacute;nico.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Esta confirmaci&oacute;n por parte del cliente significa que: i) el Cliente ha aceptado y est&aacute; de acuerdo con las condiciones del Contrato de cr&eacute;dito al consumo (ii) presta su consentimiento para el tratamiento de sus datos personales (ver cl&aacute;usula de protecci&oacute;n de datos personales) (iii) manifiesta su conformidad de transferir el cr&eacute;dito solicitado al establecimiento comercial para la realizaci&oacute;n de la compra tan pronto como sea posible. En el caso de que haya aceptado la solicitud de cr&eacute;dito con la cantidad solicitada inicialmente por el cliente, y se formalice el contrato de cr&eacute;dito se enviar&aacute; al cliente una copia del contrato por correo electr&oacute;nico a la direcci&oacute;n de correo electr&oacute;nico que se haya proporcionado a SMARTCREDIT. As&iacute; mismo se crear&aacute; una cuenta de usuario autom&aacute;ticamente para el cliente.</p>\r\n\r\n<p>Al mismo tiempo, el establecimiento comercial recibir&aacute; un sms confirmando el env&iacute;o de la transferencia a su cuenta para que pueda realizarse la venta.</p>\r\n\r\n<p><strong>6. DERECHO DE DESISTIMIENTO.</strong></p>\r\n\r\n<p>El CLIENTE podr&aacute; dejar sin efecto el contrato suscrito, ejercitando el derecho de desistimiento dentro del plazo de 14 d&iacute;as naturales desde la fecha de formalizaci&oacute;n del Contrato de Cr&eacute;dito. Para ejercitar el derecho de desistimiento el CLIENTE deber&aacute; enviar un correo electr&oacute;nico a la direcci&oacute;n info@smartcredit.es, identificando en el asunto del correo la palabra &ldquo;DESISTIMIENTO LINEA DE CREDITO&rdquo;, especificando en el cuerpo del correo electr&oacute;nico: a) nombre y apellidos, NIF (Documento Nacional de Identidad DNI o N&uacute;mero de Identificaci&oacute;n de Extranjero NIE), y Documento adjunto escaneado con la notificaci&oacute;n del desistimiento del contrato de cr&eacute;dito, identificando el n&uacute;mero de contrato, lugar y fecha de la solicitud de desistimiento y la firma del CLIENTE. El desistimiento no tiene ning&uacute;n tipo de coste para el CLIENTE, de conformidad con la Ley de Consumidores y Usuarios. El CLIENTE &uacute;nicamente deber&aacute; reintegrar a SMARTCREDIT, la parte del cr&eacute;dito dispuesto, m&aacute;s el inter&eacute;s diario y las comisiones y gastos devengados desde la fecha de disposici&oacute;n del cr&eacute;dito y la fecha de comunicaci&oacute;n de la solicitud de desistimiento, siempre y cuando la solicitud re&uacute;na los requisitos exigidos.</p>\r\n\r\n<p><strong>7. DURACI&Oacute;N Y TERMINACI&Oacute;N DE LA CREDITO AL CONSUMO. RESOLUCI&Oacute;N ANTICIPADA DEL CONTRATO.</strong></p>\r\n\r\n<p>El presente contrato de cr&eacute;dito tendr&aacute; una duraci&oacute;n especificada en el apartado h) de las condiciones particulares del presente contrato.</p>\r\n\r\n<p>Cualquiera de las Partes podr&aacute; resolver el Contrato de Cr&eacute;dito en cualquier momento de la vigencia del mismo, de conformidad con las siguientes disposiciones:</p>\r\n\r\n<p>Previamente a la solicitud de la cancelaci&oacute;n anticipada, el CLIENTE deber&aacute; reembolsar el importe total dispuesto pendiente que adeude a SMARTCREDIT.</p>\r\n\r\n<p>Para ejercer el reembolso anticipado, el CLIENTE deber&aacute; enviar un mensaje de correo electr&oacute;nico a la direcci&oacute;n info@smartcredit.es, identificando en el asunto del correo la palabra &ldquo;RESOLUCI&Oacute;N PR&Eacute;STAMO&rdquo;, especificando en el cuerpo del correo electr&oacute;nico: a) nombre y apellidos, NIF (Documento Nacional de Identidad DNI o N&uacute;mero de Identificaci&oacute;n de Extranjero NIE), y Documento adjunto escaneado manifestando su voluntad de resolver el contrato de CREDITO AL CONSUMO&nbsp; identificando el n&uacute;mero de contrato, lugar y fecha de la solicitud de resoluci&oacute;n y la firma del CLIENTE.</p>\r\n\r\n<p><strong>8. &nbsp;DISPOSICI&Oacute;N DEL CR&Eacute;DITO.</strong></p>\r\n\r\n<p>Tras la firma del Contrato, se conceder&aacute; al CLIENTE el Cr&eacute;dito por el importe pactado en las Condiciones Particulares del Contrato. Dicho importe se enviar&aacute; a la cuenta del MERCHANT- Establecimiento donde se haya realizado la compra, para que el cliente pueda disponer del bien o servicio.</p>\r\n\r\n<p>Antes de cada solicitud de disposici&oacute;n, el MERCHANT- Establecimiento comercial- deber&aacute; utilizar la Calculadora disponible en el Sitio Web de SMARTCREDIT.ES para determinar las comisiones e intereses a aplicar sobre tal la cantidad del cr&eacute;dito solicitada, para informar al prestatario y de manera comunicar las condiciones particulares del cr&eacute;dito y importe del nuevo Pago Mensual M&iacute;nimo que le ser&aacute; aplicable seg&uacute;n el plazo de devoluci&oacute;n pactado y los precios aplicables. Paralelamente, toda la informaci&oacute;n ser&aacute; enviada a trav&eacute;s de los medios facilitados por SMARTCREDIT: tel&eacute;fono, mail y chat online al CLIENTE.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>El CLIENTE podr&aacute; disponer del servicio o producto ofrecido por el MERCHANT- Establecimiento comercial- .</p>\r\n\r\n<p>En caso de que SMARTCREDIT.ES acepte la solicitud de cr&eacute;dito, el CLIENTE deber&aacute; confirmarla &nbsp;expresamente, manifestando que est&aacute; informado y por tanto est&aacute; conforme con las condiciones de cr&eacute;dito y del Pago Mensual aplicable.</p>\r\n\r\n<p>En &nbsp;ese momento recibir&aacute; el importe del cr&eacute;dito a trav&eacute;s de transferencia a la Cuenta Bancaria del Cliente, indicada por &eacute;l mismo a tales efectos. Habida cuenta de que la transferencia a la Cuenta Bancaria al establecimiento Comercial depende de Terceros, Smart Credit no se hace responsable del retraso en la entrega del importe del cr&eacute;dito por parte de dichos terceros, siempre y cuando SMARTCREDIT.ES haya ordenado la transferencia a la mayor brevedad desde la aceptaci&oacute;n de la solicitud de disposici&oacute;n.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>9. COSTE DEL LA CREDITO AL CONSUMO.</strong></p>\r\n\r\n<p>El tipo de inter&eacute;s de la CREDITO AL CONSUMO estar&aacute; indicado en las condiciones Particulares del contrato y depender&aacute; del importe de cr&eacute;dito dispuesto y del plazo de amortizaci&oacute;n escogido por el CLIENTE. El c&aacute;lculo de la TAE corresponde al saldo te&oacute;rico sin reutilizaci&oacute;n del disponible, sin promociones de pago especiales y no incluye penalizaciones por mora. (periodos de carencia, cuotas reducidas. Tasa Anual Equivalente) (T.A.E.) ser&aacute; calculada de acuerdo con la ley de cr&eacute;dito al consumo.&nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>10.&nbsp; CANCELACI&Oacute;N ANTICIPADA DEL CR&Eacute;DITO</strong></p>\r\n\r\n<p>&nbsp;Existan sospechas de que pueda existir un uso fraudulento, o &nbsp;ileg&iacute;timo del &Aacute;rea de Usuario o de la Cuenta de la CREDITO AL CONSUMO&nbsp; del CLIENTE por parte de un Tercero o del propio CLIENTE. los datos de contacto del cliente dejen de ser v&aacute;lidos de modo que SMARTCREDIT.ES no pueda contactar con el cliente con fines de ejecuci&oacute;n del contrato. Si EL CLIENTE se encuentra ilocalizable pasadas 48h desde que se hubieran realizado los &uacute;ltimos intentos de contacto por email, sms, tel&eacute;fono y &eacute;ste no se mostrara localizable, se informar&aacute; debidamente al CLIENTE del bloqueo para disponer del cr&eacute;dito concedido y de los motivos de dicho bloqueo y se reanudar&aacute; la aceptaci&oacute;n de las solicitudes de disposici&oacute;n una vez se hayan subsanado los motivos que hayan dado lugar a dicha suspensi&oacute;n o bloqueo<strong>. </strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>11. DEVOLUCI&Oacute;N DEL CR&Eacute;DITO. PAGO.</strong></p>\r\n\r\n<p>El CLIENTE deber&aacute; reembolsar a SMARTCREDIT.ES el importe total del Cr&eacute;dito dispuesto, m&aacute;s los Intereses y comisiones que en su caso sean aplicables a la fecha de vencimiento de acuerdo con las Condiciones Particulares de este contrato.</p>\r\n\r\n<p>El CLIENTE podr&aacute; efectuar el abono de los importes adeudados a trav&eacute;s de los siguientes sistemas de pago:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <ins>&nbsp;a) </ins>&nbsp;a trav&eacute;s de adeudo(s) en la tarjeta de d&eacute;bito, de conformidad con lo se&ntilde;alado anteriormente<ins>, </ins></p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <ins>b) en caso que el cliente haya&nbsp; facilitado el n&uacute;mero de cuenta bancaria en el proceso de solicitud de pr&eacute;stamo, el pago se realizar</ins><ins>&aacute; mediante transferencia</ins><ins> bancaria&nbsp; a las cuentas facilitadas</ins><ins>, </ins><ins>o&nbsp; mediante el&nbsp; pago por cualquier medio admisible en derecho (por ejemplo,</ins><ins> tanto</ins><ins> transferencia bancaria o ingreso de efectivo en cuenta corriente</ins>)</p>\r\n\r\n<p><ins>En el caso que el cliente&nbsp; no proceda al pago del pr&eacute;stamo el d&iacute;a de vencimiento, </ins>Smart Credit<ins> se reserva el derecho a externalizar la gesti&oacute;n de cobro de deuda a trav&eacute;s de agencias de recobro autorizadas y habilitadas a tal fin.&nbsp; </ins></p>\r\n\r\n<p><ins>De acuerdo con la obligaci</ins><ins>&oacute;n y el deber de actualizaci&oacute;n y exactitud de los datos establecido en el Art. 4.3 de la ley org&aacute;nica 15/1999, seg&uacute;n la cual</ins>, Smartcredit se reserva el derecho a actualizar los datos personales de acuerdo con los principios de exactitud y veracidad exigidos por la ley. &nbsp;<ins>&ldquo;los datos de car&aacute;cter personal ser&aacute;n exactos y puestos al d&iacute;a de forma que respondan con veracidad a la situaci&oacute;n actual del afectado.</ins><ins>&rdquo;, la entidad se reserva el derecho a adoptar las medidas necesarias para su adecuada actualizaci</ins><ins>&oacute;n, cuando tenga conocimiento que los datos de tratamiento son inexactos&rdquo;</ins></p>\r\n\r\n<p>En caso de realizar el pago mediante ingreso o transferencia, el CLIENTE deber&aacute; indicar en el concepto de la transferencia el DNI o NIE del CLIENTE. Si el CLIENTE no sigue estos pasos y SMARTCREDIT.ES no puede identificar el pago, el pago podr&aacute; considerarse como no recibido y el CLIENTE incurrir&aacute; en mora, a menos que pueda aportar prueba o evidencia de que el pago se realiz&oacute; debidamente en la fecha de vencimiento.</p>\r\n\r\n<p>Mediante tarjeta de d&eacute;bito de cualquier entidad bancaria espa&ntilde;ola, llamando al n&uacute;mero de tel&eacute;fono de SMARTCREDIT.ES, siempre que la tarjeta de cr&eacute;dito disponga de c&oacute;digo CES (Comercio Electr&oacute;nico Seguro). A trav&eacute;s de la plataforma de pago PAYTPV. En este caso las tarjetas deber&aacute;n disponer del c&oacute;digo CES (Comercio Electr&oacute;nico Seguro).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>La devoluci&oacute;n del Pr&eacute;stamo as&iacute; como del Importe Total Adeudado a la Fecha de Vencimiento sin demora es esencial. En caso de retraso en el pago del Importe Total Adeudado por cualquier concepto a la Fecha de Vencimiento, el Cliente estar&aacute; obligado a satisfacer intereses de demora respecto de dicho importe sobre la base del tipo de inter&eacute;s de demora determinado en las Condiciones Particulares, que se devengar&aacute; diariamente desde la fecha en que debi&oacute; realizarse el pago, liquid&aacute;ndose cada treinta (30) d&iacute;as&nbsp; y hasta un m&aacute;ximo de treinta (30) d&iacute;as (o en la fecha en que se produzca el cobro efectivo por Smartcredit de la Cantidad Total Adeudada si &eacute;ste tiene lugar con anterioridad).</p>\r\n\r\n<p>Smart Credit tendr&aacute; derecho a repercutir al Cliente cualesquiera gastos y costes razonables en los que Smart Credit haya podido incurrir como consecuencia del impago por parte del Cliente, incluyendo, entre otros, aquellos derivados de la gesti&oacute;n de cobro, la contrataci&oacute;n de servicios de recobro y el ejercicio de reclamaciones y acciones extrajudiciales y judiciales.</p>\r\n\r\n<p>SMARTCREDIT podr&aacute; aplicar los Intereses de Demora determinados en las Condiciones Particulares hasta la fecha de pago de los importes adeudados.</p>\r\n\r\n<p>En caso de que el CLENTE realice pagos insuficientes para cubrir los importes devengados, las cuant&iacute;as abonadas se imputar&aacute;n en el orden siguiente:</p>\r\n\r\n<p>Intereses de Demora.</p>\r\n\r\n<p>Comisiones Aplicables.</p>\r\n\r\n<p>Intereses.</p>\r\n\r\n<p>Principal del Cr&eacute;dito. Coste de recobro (si lo hubiera).</p>\r\n\r\n<p>&nbsp;<strong>12. INFORMACI&Oacute;N COMERCIAL Y OFERTAS PROMOCIONALES.</strong></p>\r\n\r\n<p>&nbsp;De forma ocasional, SMARTCREDIT.ES podr&aacute; ofrecer ofertas especiales o promociones al Cliente, las cuales quedar&aacute;n sujetas a los t&eacute;rminos y condiciones que en cada caso se publiquen en cumplimiento de lo dispuesto en la Ley 22/2007, de 11 de julio, sobre comercializaci&oacute;n a distancia de servicios financieros destinados a los consumidores, en la Ley 16/2011, de 24 de junio, de contratos de cr&eacute;dito al consumo, y dem&aacute;s legislaci&oacute;n aplicable, en particular, en materia de consumidores.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Si el cliente marca la casilla de consentimiento y no se opone por cualquier otro medio significar&aacute; que SMARTCREDIT.ES tendr&aacute; derecho a tratar los datos para la realizaci&oacute;n de actividades y comunicaciones comerciales, publicitarias y promocionales mediante cualquier medio, ya sea tradicional, ya sea mediante el env&iacute;o de correos electr&oacute;nicos y de mensajes a trav&eacute;s de cualquier sistema incluyendo SMS, etc., por parte de SMARTCREDIT.ES que incorporen informaci&oacute;n sobre productos y servicios comercializados por SMARTCREDIT. El cliente es informado que tiene derecho a oponerse al tratamiento de sus datos con finalidades comerciales, en el momento de la introducci&oacute;n de sus datos en la p&aacute;gina web.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>En caso de querer ejercer el derecho a no recibir dichas comunicaciones, el cliente podr&aacute; oponerse en todo momento al env&iacute;o de estas comunicaciones comerciales enviando un correo electr&oacute;nico a info@smartcredit.es [AR7]&nbsp;e indic&aacute;ndolo expresamente de acuerdo con lo dispuesto en la Directiva 2000/31/CE, del Parlamento Europeo y del Consejo, de 8 de junio, relativa a determinados aspectos de los servicios de la sociedad de la informaci&oacute;n</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>13. CONFIDENCIALIDAD Y CONSENTIMIENTO PARA EL TRATAMIENTO DE DATOS DE CAR&Aacute;CTER PERSONAL.</strong></p>\r\n\r\n<p>&nbsp; SMARTCREDIT informa al CLIENTE y &eacute;ste da su consentimiento para que los datos que le facilite en el formulario de solicitud de Cr&eacute;dito al consumo del Sitio Web sean incorporados en un fichero de su titularidad, que se encuentra dado de alta en el Registro de la Agencia Espa&ntilde;ola de Protecci&oacute;n de Datos, cuya finalidad es el control, gesti&oacute;n, mantenimiento y ejecuci&oacute;n del contrato, as&iacute; como el env&iacute;o de informaci&oacute;n acerca de productos y servicios relativos a la solicitud del CLIENTE tanto por medios postales como electr&oacute;nicos.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>El cliente consiente a que SMARTCREDIT.ES pueda ceder sus datos personales a terceros con el fin de realizar averiguaciones patrimoniales y para &nbsp;los procesos de recuperaci&oacute;n de deuda si fuera necesario.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>El CLIENTE consiente expresamente que SMARTCREDIT.ES pueda recabar datos relativos a sus antecedentes crediticios e informaci&oacute;n relacionada con el enjuiciamiento de su solvencia econ&oacute;mica.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>14. &nbsp;</strong><strong>PREVENCI&Oacute;N DEL BLANQUEO DE CAPITALES.</strong></p>\r\n\r\n<p>SMARTCREDIT comunicar&aacute; al Servicio Ejecutivo de Prevenci&oacute;n del Blanqueo de Capitales (SEPBLAC) cualquier hecho u operaci&oacute;n, incluso la mera tentativa, respecto de los cu&aacute;les exista indicio o certeza de que est&aacute; relacionado con el blanqueo de capitales o la financiaci&oacute;n del terrorismo, debiendo abstenerse de ejecutar cualquier operaci&oacute;n, si se ponen de manifiesto tales circunstancias, SMARTCREDIT.ES no ser&aacute; responsable ante el Cliente de los da&ntilde;os y perjuicios que este pueda sufrir como consecuencia del cumplimiento de dichas obligaciones.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>15. PROPIEDAD INDUSTRIAL E INTELECTUAL.</strong></p>\r\n\r\n<p>Los derechos de propiedad intelectual e industrial sobre las creaciones, marcas, logos, y cualquier otro susceptible de protecci&oacute;n, contenidos en la p&aacute;gina web de SMARTCREDIT.ES corresponden en exclusiva al SMARTCREDIT.ES o a terceros que han autorizado su inclusi&oacute;n en la p&aacute;gina web. La reproducci&oacute;n, distribuci&oacute;n, comercializaci&oacute;n o transformaci&oacute;n no autorizadas de tales creaciones, marcas, logos, etc. constituye una infracci&oacute;n de los derechos de propiedad intelectual e industrial de SMARTCREDIT.ES o del titular de los mismos, y podr&aacute; dar lugar al ejercicio de cuantas acciones judiciales o extrajudiciales les pudieran corresponder en el ejercicio de sus derechos.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Asimismo, la informaci&oacute;n a la cual el CLIENTE puede acceder a trav&eacute;s de la web puede estar protegida por derechos de propiedad industrial, intelectual o de otra &iacute;ndole. SMARTCREDIT.ES no ser&aacute; responsable en ning&uacute;n caso y bajo ning&uacute;n concepto de las infracciones de tales derechos que pueda cometer como usuario el CLIENTE.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>16. CESI&Oacute;N.</strong></p>\r\n\r\n<p>SMARTCREDIT tendr&aacute; el derecho de ceder sus derechos y obligaciones en relaci&oacute;n con el Contrato de Cr&eacute;dito a un tercero sin requerir el consentimiento del CLIENTE y el CLIENTE tendr&aacute; los mismos derechos frente al cesionario que contra SMARTCREDIT. El CLIENTE ser&aacute; debidamente notificado de dicha cesi&oacute;n. El CLIENTE no podr&aacute; ceder ninguno de sus derechos u obligaciones en t&eacute;rminos de este contrato de cr&eacute;dito sin el consentimiento expreso y por escrito de SMARTCREDIT.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>SMARTCRDIT podr&aacute; ceder a un Tercero el derecho a ejercitar cualquier reclamaci&oacute;n contra el CLIENTE sin necesidad de recabar el consentimiento del mismo. Mediante la firma de este Contrato, el CLIENTE otorga a SMARTCREDIT.ES y a ese Tercero, su consentimiento irrevocable para procesar sus datos personales en la medida necesaria para satisfacer dicha reclamaci&oacute;n de SMARTCREDIT.ES o el Tercero.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>17. IDIOMA Y NOTIFICACIONES.</strong></p>\r\n\r\n<p>Todas las notificaciones relacionadas con el Contrato de Cr&eacute;dito intercambiadas entre las Partes se efectuar&aacute;n en castellano, as&iacute; como en catal&aacute;n en los contratos perfeccionados en Catalunya.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>El CLIENTE podr&aacute; utilizar cualquiera de los medios puestos a disposici&oacute;n de SMARTCREDIT.ES para intercambiar comunicaciones: correo postal a C. Clos n 8 &ordm;&nbsp; 08960, Sant Just Desvern. BARCELONA, info@smartcredit.es</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>SMARTCREDIT por su parte podr&aacute; comunicarse con el CLIENTE a trav&eacute;s del domicilio, correo electr&oacute;nico y tel&eacute;fono/os facilitados por el propio CLIENTE mediante el formulario de solicitud del cr&eacute;dito, incluyendo la posibilidad de env&iacute;o de mensajes de texto (SMS) al tel&eacute;fono m&oacute;vil del CLIENTE, salvo que en este contrato se prevea un procedimiento de notificaci&oacute;n espec&iacute;fico.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>El CLIENTE se compromete a notificar a SMARTCREDIT, enviando dicha notificaci&oacute;n al email info@smartcredit.es y aportando justificante que acredite el cambio solicitado.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>A los efectos del presente Contrato, para ambas Partes se entiende que una notificaci&oacute;n ha sido debidamente recibida en los siguientes supuestos: tras la recepci&oacute;n del acuse de recibo si lo hubiere; cinco (5) d&iacute;as naturales despu&eacute;s de enviarla, si se remite por correo postal ordinario; o despu&eacute;s de un (1) d&iacute;a natural, si se env&iacute;a en formato electr&oacute;nico por SMS o correo electr&oacute;nico.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>18. JURISDICCI&Oacute;N Y LEY APLICABLE.</strong></p>\r\n\r\n<p>El Contrato de Cr&eacute;dito y la relaci&oacute;n comercial entre el CLIENTE y SMARTCREDIT.ES se regir&aacute;n por la ley espa&ntilde;ola. &nbsp;En particular, este Contrato estar&aacute; regido por las presentes Condiciones Generales, las Condiciones Particulares, la Ley 16/2011, de 24 de junio, de Contratos de Cr&eacute;dito al Consumo, la Ley 22/2007, de 11 de julio, sobre Comercializaci&oacute;n a Distancia de Servicios Financieros Destinados a los Consumidores, el Real Decreto Legislativo 1/2007, de 16 de noviembre, para la Defensa de los Consumidores y Usuarios y la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Informaci&oacute;n y de Comercio Electr&oacute;nico, as&iacute; como el resto de la legislaci&oacute;n que pueda resultarle aplicable.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Cualquier conflicto que pudiere generarse entre las partes, ser&aacute; resuelto de forma amistosa. En el supuesto en el que las partes no pudiesen resolver la controversia a trav&eacute;s de la negociaci&oacute;n y la buena fe, las partes se someten de manera expresa, para conocer del asunto a los Juzgados y Tribunales del domicilio de CLIENTE.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2),
(68, 32, 'Spread your purchases', '<p>Postpone your purchases. You can fund your purchase up to 12 monthly installments. It&#39;s up to you.</p>\r\n', 1),
(69, 32, 'Aplaza tus compras', '<p>Permite financiar compras hasta en 12 cuotas mensuales. Flexible.</p>\r\n', 2),
(70, 33, 'Fixed fees', '<p>Fixed Instalment quotes. Once you choose the quotes, the amount will never change.</p>\r\n', 1),
(71, 33, 'Cuotas fijas', '<p>Una vez se eligen las cuotas, la cantidad no variar&aacute; nunca.</p>\r\n', 2),
(72, 34, 'Quick answer and paperless', '<p>Fast and paperless You will know immediately if your financing has been authorized, without paperwork</p>\r\n', 1),
(73, 34, 'RÃ¡pido y sin papeleo', '<p>Los clientes sabr&aacute;n de inmediato si su financiaci&oacute;n ha sido autorizada, sin papeleos.</p>\r\n', 2),
(74, 35, 'Comprar es ahora mÃ¡s fÃ¡cil que nunca', '<p>We all win with SMART CREDIT</p>\r\n', 1),
(75, 35, 'AcÃ©rcate  a tus sueÃ±os con Smart Credit', '<p>Compra ahora y paga m&aacute;s adelante</p>\r\n', 2),
(76, 36, 'Easy and quick win', '<p>Look at the smart part of life</p>\r\n', 1),
(77, 36, 'Ventajas de obtener financiaciÃ³n online', '<p>Financiaci&oacute;n sencilla, inversiones rentables&nbsp;</p>\r\n', 2),
(78, 37, 'Merchant', '<p>Offering a loan to your customer has never been so easy. Just sign in to your account and get started.</p>\r\n', 1),
(79, 37, 'Comerciante', '<p>Ofrecer un pr&eacute;stamo a su cliente nunca ha sido tan f&aacute;cil. Simplemente inicie sesi&oacute;n en su cuenta y comience.</p>\r\n', 2),
(80, 38, 'What will Smartcredit.es offer to your business?', '<p>What will Smartcredit.es offer to your business?</p>\r\n', 1),
(81, 38, 'Â¿QuÃ© ofrecerÃ¡ Smartcredit.es a su negocio?', '<p>&nbsp;Smartcredit.es ofrece ventajas para que tus clientes compren en tu establecimiento de forma f&aacute;cil.</p>\r\n\r\n<p>Aumenta tus ventas y fideliza a tus clientes! &nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2),
(82, 39, 'Advantages for your business', '<p>Use smartcredit.es and offer your customers the chance of spreding their payments and pay in flexible instalments.</p>\r\n\r\n<p><strong>Improve customer engagement</strong></p>\r\n\r\n<p><strong>Improve the midium tiket</strong></p>\r\n\r\n<p><strong>You will receive the amount in less tan 24horas</strong></p>\r\n', 1),
(83, 39, 'Ventajas de utilizar SmartCredit.es como forma de pago para tus clientes', '<p>&nbsp;La plataforma de financiaci&oacute;n smartcredit.es ofrece a tus clientes la oportunidad de aplazar sus pagos y pagar en cuotas flexibles.</p>\r\n\r\n<p><strong>Mejora el compromiso del cliente</strong></p>\r\n\r\n<p><strong><strong>Incrementa el tiquet medio de las ventas&nbsp;</strong></strong></p>\r\n\r\n<p><strong><strong>Como comerciante recibir&aacute;s la cantidad de la venta en menos de 24horas en su cuenta</strong>&nbsp;</strong></p>\r\n', 2),
(84, 40, 'Payment Policy', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 1),
(85, 40, 'PolÃ­tica de pago', '<p>SmartCredit podr&aacute; cobrar para compensar los gastos de reclamaci&oacute;n extrajudicial derivados del impago de la mensualidad, una comisi&oacute;n de 30&euro; euros, cada vez que quede una posici&oacute;n deudora vencida.</p>\r\n\r\n<p>&nbsp;\r\n<p><strong>La falta de pago total o parcial de al menos 2 mensualidades durante la vida del cr&eacute;dito, sean o no consecutivas o de la ultima mensualidad del contrato, facultar&aacute; a SmartCredit para considerar vencido anticipadamente el contrato de pr&eacute;stamo y exigir de inmediato de </strong></p>\r\n</p>\r\n\r\n<p><strong>la devoluci&oacute;n del capital que quede por amortizar, incrementado por los intereses vencidos y no pagados y las comisiones y gastos ocasionados, as&iacute; como una penalizaci&oacute;n por da&ntilde;os y perjuicios del capital del 8% del capital pendiente de amortizaci&oacute;n. &nbsp;</strong></p>\r\n\r\n<p>En caso de no atender a los pagos, los datos podr&aacute;n ser comunicados por SMART CREDIT a ficheros de solvencia patrimonial y de cr&eacute;dito.</p>\r\n\r\n<p>El detalle y la aplicaci&oacute;n de las consecuencias derivadas del impago se recogen en las siguientes cl&aacute;usulas del presente contrato de condiciones generales.</p>\r\n', 2),
(86, 41, 'Principals', '<p>Principals</p>\r\n', 1),
(87, 41, 'Principios y Condiciones de Uso', '<p><strong>1. CONDICIONES DE USO DEL PORTAL</strong></p>\r\n\r\n<p><strong>1.1. General</strong></p>\r\n\r\n<p>Los Usuarios del Portal se obligan a hacer un uso correcto del Portal de conformidad con la Ley y las presentes Condiciones de Uso. El Usuario que incumpla la Ley o las presentes Condiciones de Uso responder&aacute; frente a SMARTCREDIT o frente a terceros de cualesquiera da&ntilde;os y perjuicios que pudieran causarse como consecuencia del incumplimiento de dicha obligaci&oacute;n.</p>\r\n\r\n<p>Queda expresamente prohibido el uso del Portal con fines lesivos de bienes o intereses de SMARTCREDIT o que de cualquier otra forma sobrecarguen, da&ntilde;en o inutilicen las redes, servidores y dem&aacute;s equipos inform&aacute;ticos (hardware) o productos y aplicaciones inform&aacute;ticas (software) de SMARTCREDIT o de terceros.</p>\r\n\r\n<p><strong>1.2. Introducci&oacute;n de enlaces al Portal</strong></p>\r\n\r\n<p>Los Usuarios de Internet o prestadores de Servicios de la Sociedad de la Informaci&oacute;n que quieran introducir enlaces desde sus propias p&aacute;ginas web al Portal deber&aacute;n cumplir con las condiciones que se detallan a continuaci&oacute;n:</p>\r\n\r\n<ul>\r\n	<li>No se realizar&aacute;n desde la p&aacute;gina que introduce el enlace ning&uacute;n tipo de manifestaci&oacute;n falsa, inexacta o incorrecta sobre SMARTCREDIT, sus socios, empleados, miembros o sobre la calidad de los servicios que ofrece a los usuarios.</li>\r\n	<li>En ning&uacute;n caso, se expresar&aacute; en la p&aacute;gina donde se ubique el enlace que SMARTCREDIT ha prestado su consentimiento para la inserci&oacute;n del enlace o que de otra forma patrocina, colabora, verifica o supervisa los servicios del remitente.</li>\r\n	<li>Est&aacute; prohibida la utilizaci&oacute;n de cualquier marca denominativa, gr&aacute;fica o mixta o cualquier otro signo distintivo de SMARTCREDIT salvo en los casos permitidos por la ley o expresamente autorizados por SMARTCREDIT y siempre que se permita, en estos casos, un enlace directo con el Portal en la forma establecida en esta cl&aacute;usula.</li>\r\n</ul>\r\n\r\n<p><strong>1.3. Propiedad intelectual e industrial</strong></p>\r\n\r\n<p>El Portal, as&iacute; como todos los contenidos del Portal, entendiendo por estos, a t&iacute;tulo meramente enunciativo, los textos, fotograf&iacute;as, gr&aacute;ficos, im&aacute;genes, iconos, tecnolog&iacute;a, software, links y dem&aacute;s contenidos, as&iacute; como su dise&ntilde;o gr&aacute;fico y c&oacute;digos fuente (en adelante, los &ldquo;Contenidos&rdquo;), son propiedad intelectual de SMARTCREDIT o de sus leg&iacute;timos titulares, sin que puedan entenderse cedidos a los Usuarios ninguno de los derechos de explotaci&oacute;n reconocidos por la normativa vigente en materia de propiedad intelectual. No obstante lo anterior, durante el tiempo que los Usuarios permanezcan conectados al Portal podr&aacute;n hacer uso del Portal y de dichos Contenidos en la medida que resulte necesario para la navegaci&oacute;n y s&oacute;lo en cuanto dichos Contenidos se encuentren accesibles de acuerdo con las normas previstas en &eacute;stas Condiciones de Uso. En particular, los Usuarios deber&aacute;n de abstenerse de reproducir, copiar, distribuir, poner a disposici&oacute;n, comunicar p&uacute;blicamente, transformar o modificar los Contenidos salvo en la medida que sea estrictamente necesario para su descarga en aquellos casos &eacute;sta se ofrezca a trav&eacute;s del Portal o en aquellos casos autorizados en la ley u otros expresamente consentidos por SMARTCREDIT.</p>\r\n\r\n<p>Las marcas, nombres comerciales o signos distintivos son titularidad de SMARTCREDIT sin que pueda entenderse que el acceso al Portal atribuya a los Usuarios ning&uacute;n derecho sobre las citadas marcas, nombres comerciales y/o signos distintivos.</p>\r\n\r\n<p><strong>2. EXCLUSI&Oacute;N DE RESPONSABILIDAD</strong></p>\r\n\r\n<p><strong>2.1. De la calidad del servicio</strong></p>\r\n\r\n<p>La conexi&oacute;n al Portal se realiza a trav&eacute;s de redes abiertas de manera que SMARTCREDIT no controla la seguridad de la comunicaci&oacute;n de datos ni de los equipos conectados a Internet. Corresponde al Usuario, disponer de herramientas adecuadas para la prevenci&oacute;n, detecci&oacute;n y desinfecci&oacute;n de programas inform&aacute;ticos da&ntilde;inos o software malicioso. Puede obtener informaci&oacute;n sobre herramientas gratuitas de detecci&oacute;n de software malicioso, tales como virus, troyanos, etc. en la p&aacute;gina de INTECO: http://cert.inteco.es/software/Proteccion/utiles_gratuitos/. SMARTCREDIT no se responsabiliza de los da&ntilde;os producidos en los equipos inform&aacute;ticos de los Usuarios o de terceros por actos de terceros durante la conexi&oacute;n al Portal.</p>\r\n\r\n<p><strong>2.2. De la disponibilidad del Servicio</strong></p>\r\n\r\n<p>El acceso al Portal requiere de servicios y suministros de terceros, incluidos el transporte a trav&eacute;s de redes de telecomunicaciones cuya fiabilidad, calidad, seguridad, continuidad y funcionamiento no corresponde a SMARTCREDIT ni se encuentra bajo su control. SMARTCREDIT no se responsabilizar&aacute;n de los da&ntilde;os o perjuicios de cualquier tipo producidos en el Usuario que traigan causa de fallos o desconexiones en las redes de telecomunicaciones que produzcan la suspensi&oacute;n, cancelaci&oacute;n o interrupci&oacute;n del Portal durante la prestaci&oacute;n del mismo o con car&aacute;cter previo.</p>\r\n\r\n<p><strong>2.3. De los contenidos y servicios enlazados a trav&eacute;s del Portal</strong></p>\r\n\r\n<p>El Portal puede incluir enlaces o links que permiten al Usuario acceder a otras p&aacute;ginas y portales de Internet (en adelante, &ldquo;Sitios Enlazados&rdquo;). En estos casos, SMARTCREDIT act&uacute;a como prestador de servicios de intermediaci&oacute;n de conformidad con el art&iacute;culo 17 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Informaci&oacute;n y el Comercio Electr&oacute;nico (&ldquo;LSSI&rdquo;) y s&oacute;lo ser&aacute; responsable de los contenidos y servicios suministrados en los Sitios Enlazados en la medida en que tenga conocimiento efectivo de la ilicitud y no haya desactivado el enlace con la diligencia debida.</p>\r\n\r\n<p>En ning&uacute;n caso, la existencia de Sitios Enlazados debe presuponer la existencia de acuerdos con los responsables o titulares de los mismos, ni la recomendaci&oacute;n, promoci&oacute;n o identificaci&oacute;n de SMARTCREDIT con las manifestaciones, contenidos o servicios provistos.</p>\r\n\r\n<p>SMARTCREDIT no conoce los contenidos y servicios de los Sitios Enlazados y por tanto no se hace responsable por los da&ntilde;os producidos por la ilicitud, calidad, desactualizaci&oacute;n, indisponibilidad, error e inutilidad de los contenidos y/o servicios de los Sitios Enlazados ni por cualquier otro da&ntilde;o que no sea directamente imputable a SMARTCREDIT por sus propios servicios.</p>\r\n\r\n<p><strong>2.4. De los contenidos de terceros alojados por SMARTCREDIT</strong></p>\r\n\r\n<p>El Portal incluye o puede incluir la posibilidad de que los Usuarios, registrados o no, incluyan comentarios o, de cualquier otra forma, participen emitiendo opiniones personales o determinada informaci&oacute;n. Asimismo, algunos productos, servicios o programas de SMARTCREDIT pueden incluir contenidos de terceros. En estos casos, SMARTCREDIT act&uacute;a como prestador de servicios de intermediaci&oacute;n de alojamiento de conformidad con el art&iacute;culo 16 de la Ley 34/2002, de 12 de julio, de Servicios de la Sociedad de la Informaci&oacute;n y el Comercio Electr&oacute;nico (&ldquo;LSSI&rdquo;) y s&oacute;lo ser&aacute; responsable de los contenidos subidos por otros Usuarios en la medida en que tenga conocimiento efectivo de la ilicitud y no haya retirado el contenido il&iacute;cito con la diligencia debida.</p>\r\n\r\n<p>En ning&uacute;n caso, la existencia de comentarios o contenidos de terceros debe presuponer la existencia de acuerdos con los autores de los mismos, ni la recomendaci&oacute;n, promoci&oacute;n o identificaci&oacute;n de SMARTCREDIT con las manifestaciones o informaci&oacute;n facilitada.</p>\r\n\r\n<p><strong>2.5. De la confidencialidad de la informaci&oacute;n transmitida a trav&eacute;s del Portal</strong></p>\r\n\r\n<p>SMARTCREDIT tiene adoptadas las medidas de seguridad exigidas legalmente para garantizar la confidencialidad y secreto de los datos de car&aacute;cter personal que los Usuarios facilitan en nuestro Portal. No obstante lo anterior, la transmisi&oacute;n de dichos datos a SMARTCREDIT circula por redes de telecomunicaciones de terceros no controladas por SMARTCREDIT.&nbsp;</p>\r\n', 2),
(88, 42, 'Cookies', '<p>Cookies</p>\r\n', 1),
(89, 42, 'Cookies', '<p>Page under construction</p>\r\n', 2),
(90, 43, 'Conflict Policy', '<p>Conflict Policy</p>\r\n', 1),
(91, 43, 'Servicio de MediaciÃ³n', '<p>Smartcredit.es est&aacute; adherida al centre de &quot;Mediaci&oacute; i Abitratge de Catalunya&quot;, ello implica que ante cualquier conflicto que pudiera sugir, se recurrir&aacute; en primera instancia a la via de la mediaci&oacute;n legal, ofreciendo as&iacute; la posibilidad al cliente de solicitar un servicio de mediaci&oacute;n p&uacute;blico.</p>\r\n\r\n<p>En cuanto a las normas de buen gobierno, Smartcredit.es cumple con las pol&iacute;ticas de compliance, y as&iacute; mismo con la regulaci&oacute;ny normativa vigente de derecho de cr&eacute;dito al consumo, contrataci&oacute;n electr&oacute;nica, LSSICE, AML y de Protecci&oacute;n de datos- RGPD.</p>\r\n\r\n<p>Smart Credit contiene y cumple con politicas y procedimientos de acuerdo con las directrices governance en regulaci&oacute;n Europea. &nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2);
INSERT INTO `smc_page_content` (`id`, `page_id`, `page_title`, `page_desc`, `language_id`) VALUES
(92, 44, 'How it Works', '<h2><strong>How SMART CREDIT works</strong></h2>\r\n\r\n<p>We&#39;re proud to do things differently.</p>\r\n\r\n<p>The SMART CREDIT model was the first of its kind in the world: we directly match people looking for a low rate loan with investors looking for a higher rate of return.</p>\r\n\r\n<p>It&#39;s efficient and online. It lowers our overheads and allows us to pass on the rewards to our customers, so everyone is better off.</p>\r\n\r\n<p>We&#39;ve earned our reputation as an innovator by obsessing about tech, data, and delivering an exceptional customer experience.</p>\r\n\r\n<p>A number of financial institutions also invest through our platform.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2><strong>How do we make money?</strong></h2>\r\n\r\n<p>We believe in transparency, so our fees are displayed clearly to our customers when they take out a loan or invest their money.</p>\r\n\r\n<p>We charge&nbsp;3 types of fee&nbsp;at SMART CREDIT. They enable us to provide the service our customers know and love.</p>\r\n\r\n<p><strong><em>Loan customers</em></strong></p>\r\n\r\n<p>We charge an&nbsp;origination fee&nbsp;to help cover the cost of setting up the loan. We also apply a&nbsp;loan servicing fee&nbsp;to each loan contract, which is deducted directly from each borrower repayment before the principal and interest is passed on to investors. Both fees are included in the loan&#39;s APR.</p>\r\n\r\n<p><strong><em>Investors</em></strong></p>\r\n\r\n<p>We charge a&nbsp;<strong>1% fee</strong>&nbsp;if an investor wants to sell their loans to access their money quickly. It&#39;s free to withdraw money in other ways.</p>\r\n\r\n<h2><strong>Our investment products</strong></h2>\r\n\r\n<p>You can sign up to SMART CREDIT with as little as 1.000&euro;. Please note that we charge a 1% fee with our products if you choose to sell your loans early.</p>\r\n\r\n<p>Plus investors, returns are likely to be more volatile than for Core investors.</p>\r\n\r\n<p><strong><em>1.000&euro; minimum</em></strong></p>\r\n\r\n<p>There is a minimum initial investment amount of 1.000&euro;. This is to ensure your investments are sufficiently diversified. Your money is lent out in chunks starting at 10&euro;, meaning no one person would have more than 1% of your overall investment.</p>\r\n\r\n<p><strong><em>Access your money</em></strong></p>\r\n\r\n<p>You can withdraw your monthly repayments as they are paid back by borrowers for free, by letting repayments go into your holding account. If you would like to access a lump sum, you can sell your outstanding loans to other investors for a 1% fee.</p>\r\n\r\n<p><strong><em>Defaults at SMART CREDIT</em></strong></p>\r\n\r\n<p>If a borrower misses 4 months&rsquo; worth of repayments, their loan is defaulted and your capital may be claimed by court. After a default, we still make every effort to recover your capital, and return those funds to you. Your projected return factors in expected defaults.&nbsp;</p>\r\n', 1),
(93, 44, 'Â¿CÃ³mo funciona SMART CREDIT?', '<p><strong>Pr&eacute;stamos simples para financiar tus proyectos.</strong></p>\r\n\r\n<p>&nbsp;Creemos que un pr&eacute;stamo debe estar all&iacute; para ayudarte, no para pon&eacute;rtelo dif&iacute;cil.</p>\r\n\r\n<p>Estamos configurando el futuro de las finanzas ofreciendo tarifas competitivas, productos flexibles e intuitivos y un buen servicio al cliente. Existimos para hacer que el dinero sea simple y justo para todos, para que las personas puedan hacer m&aacute;s con su dinero y tomar el control de sus finanzas.</p>\r\n\r\n<p><strong>&iquest;C&oacute;mo funciona SMART CREDIT?</strong></p>\r\n\r\n<p>El modelo SMART CREDIT quiere ser pionero en las finanzas colaborativas: emparejamos directamente a las personas que buscan un pr&eacute;stamo accesible para financiar sus compras con una plataforma de inversi&oacute;n en la cual estamos trabajando&hellip;En un futuro cercano, queremos ofrecer una plataforma de inversi&oacute;n para los inversores que buscan un mayor rendimiento.</p>\r\n\r\n<p>El proceso es eficiente y online.</p>\r\n\r\n<p>La plataforma de inversi&oacute;n disminuye nuestros gastos generales y nos permite transferir las recompensas a nuestros clientes, para que todos est&eacute;n satisfechos.</p>\r\n\r\n<p>Nos hemos ganado nuestra reputaci&oacute;n como innovadores al obsesionarnos con la tecnolog&iacute;a, los datos y ofrecer una experiencia de cliente excepcional.&nbsp;</p>\r\n', 2),
(94, 45, 'Partnership', '<p><img alt="Clinica Egos Barcelona" src="https://www.smartcredit.es/smccontrolpanel/userfiles/1528207340.png" style="height:77px; width:133px" />You are interested in being part of this project that will grow internationally, Partnership-</p>\r\n\r\n<p>email</p>\r\n\r\n<p>info@smartcredit.es</p>\r\n', 1),
(95, 45, 'Partnership', '<p><br />\r\n<img alt="INSTITUT CEM" src="https://www.smartcredit.es/smccontrolpanel/userfiles/1528207500.jpg" style="float:right; height:96px; width:96px" /><img alt="" src="https://www.smartcredit.es/smccontrolpanel/userfiles/1528207304.gif" />Dr. Mauricio Berrios</p>\r\n\r\n<p>Env&iacute;arnos un email a info@smartcredit.es</p>\r\n', 2),
(96, 46, 'Invest', '<p>&nbsp;</p>\r\n\r\n<p>Invest in SMARTCREDIT. &nbsp;If you have a part of your savings that you want to get a return on, SMARTCREDIT gives you the tools to make it profitable. you have an amount from &euro; 100 onwards you can get a high profitability. To invest with SMARTCREDIT is to make an intelligent use of your money, investing in solvent people, with very low costs and obtaining a high profitability.</p>\r\n', 1),
(97, 46, 'Invierte y obtÃ©n una alta rentabilidad', '<p>&nbsp;Invierte en &nbsp;SMARTCREDIT.</p>\r\n\r\n<p>&nbsp;Si dispones de una parte de tus ahorros de los que quieres sacar un rendimiento, SMARTCREDIT te da las herramientas para rentabilizarlo.</p>\r\n\r\n<p>tienes una cantidad desde 100&euro; en adelante podr&aacute;s obtener una alta rentabilidad.</p>\r\n\r\n<p>Invertir con SMARTCREDIT es &nbsp;hacer un uso inteligente de tu dinero, invirtiendo en personas solventes, con costes muy bajos y obteniendo una alta rentabilidad.</p>\r\n', 2),
(98, 47, 'How SMART CREDIT works', '<p><strong>How SMART CREDIT works</strong></p>\r\n\r\n<p>We&#39;re proud to do things differently.</p>\r\n\r\n<p>The SMART CREDIT model was the first of its kind in the world: we directly match people looking for a low rate loan with investors looking for a higher rate of return.</p>\r\n\r\n<p>It&#39;s efficient and online. It lowers our overheads and allows us to pass on the rewards to our customers, so everyone is better off.We&#39;ve earned our reputation as an innovator by obsessing about tech, data, and delivering an exceptional customer experience.</p>\r\n\r\n<p>A number of financial institutions also invest through our platform.</p>\r\n\r\n<p><strong>How do we make money?</strong></p>\r\n\r\n<p>We believe in transparency, so our fees are displayed clearly to our customers when they take out a loan or invest their money.</p>\r\n\r\n<p>We charge 3 types of fee at SMART CREDIT. They enable us to provide the service our customers know and love.</p>\r\n\r\n<p><strong>Loan customers</strong></p>\r\n\r\n<p>We charge an origination fee to help cover the cost of setting up the loan. We also apply a loan servicing fee to each loan contract, which is deducted directly from each borrower repayment before the principal and interest is passed on to investors. Both fees are included in the loan&#39;s APR.</p>\r\n\r\n<p><strong>Investors</strong></p>\r\n\r\n<p>We charge a 1% fee if an investor wants to sell their loans to access their money quickly. It&#39;s free to withdraw money in other ways.</p>\r\n\r\n<p>Our investment products</p>\r\n\r\n<p>You can sign up to SMART CREDIT with as little as 100&euro;. Please note that we charge a 1% fee with our products if you choose to sell your loans early.</p>\r\n\r\n<p>Plus investors, returns are likely to be more volatile than for Core investors.</p>\r\n\r\n<p>100&euro; minimum</p>\r\n\r\n<p>There is a minimum initial investment amount of 100&euro;. This is to ensure your investments are sufficiently diversified. Your money is lent out in chunks starting at 10&euro;, meaning no one person would have more than 1% of your overall investment.</p>\r\n\r\n<p><strong>Access your money</strong></p>\r\n\r\n<p>You can withdraw your monthly repayments as they are paid back by borrowers for free, by letting repayments go into your holding account. If you would like to access a lump sum, you can sell your outstanding loans to other investors for a 1% fee.</p>\r\n\r\n<p><strong>Defaults at SMART CREDIT</strong></p>\r\n\r\n<p>If a borrower misses 4 months&rsquo; worth of repayments, their loan is defaulted and your capital may be claimed by court. After a default, we still make every effort to recover your capital, and return those funds to you. Your projected return factors in expected defaults.</p>\r\n', 1),
(99, 47, 'CÃ³mo funciona Smartcredit como plataforma de inversiÃ³n', '<p><strong>C&oacute;mo funciona SMART CREDIT</strong></p>\r\n\r\n<p>Estamos orgullosos de hacer las cosas de manera diferente.</p>\r\n\r\n<p>El modelo SMART CREDIT relacionamos directamente a las personas que buscan un pr&eacute;stamo con los inversores que buscan una mayor tasa de rendimiento.</p>\r\n\r\n<p>Es eficiente y online. Esto disminuye nuestros gastos generales y nos permite transferir las recompensas a nuestros clientes, para que todos est&eacute;n mejor.</p>\r\n\r\n<p>Nos hemos ganado nuestra reputaci&oacute;n como innovadores al obsesionarnos con la tecnolog&iacute;a, los datos y ofrecer una experiencia de cliente excepcional.</p>\r\n\r\n<p>Varias instituciones financieras tambi&eacute;n invierten a trav&eacute;s de nuestra plataforma.</p>\r\n\r\n<p><strong>&iquest;C&oacute;mo hacemos dinero?</strong></p>\r\n\r\n<p>Creemos en la transparencia, por lo que nuestros honorarios se muestran claramente a nuestros clientes cuando solicitan un pr&eacute;stamo o invierten su dinero.</p>\r\n\r\n<p>Cobramos 3 tipos de tarifa en SMART CREDIT. Nos permiten brindar el servicio que nuestros clientes conocen y aman.</p>\r\n\r\n<p><strong>Clientes de pr&eacute;stamos</strong></p>\r\n\r\n<p>Cobramos una tarifa de originaci&oacute;n para ayudar a cubrir el costo de establecer el pr&eacute;stamo. Tambi&eacute;n aplicamos una comisi&oacute;n de servicio del pr&eacute;stamo a cada contrato de pr&eacute;stamo, que se deduce directamente de cada reembolso al prestatario antes de que el principal y los intereses se pasen a los inversores. Ambas tarifas est&aacute;n incluidas en la tasa de porcentaje anual del pr&eacute;stamo.</p>\r\n\r\n<p><strong>Inversores</strong></p>\r\n\r\n<p>Cobramos una tarifa del 1% si un inversor quiere vender sus pr&eacute;stamos para acceder a su dinero r&aacute;pidamente. Es gratis retirar dinero de otras maneras.</p>\r\n\r\n<p><strong>Nuestros productos de inversi&oacute;n</strong></p>\r\n\r\n<p>Puede suscribirse a SMART CREDIT con tan solo 100 &euro;. Tenga en cuenta que cobramos una tarifa del 1% con nuestros productos si elige vender sus pr&eacute;stamos anticipadamente.</p>\r\n\r\n<p>100 &euro; m&iacute;nimo</p>\r\n\r\n<p>Hay un importe m&iacute;nimo de inversi&oacute;n inicial de 100 &euro;. Esto es para asegurar que sus inversiones est&eacute;n lo suficientemente diversificadas. Su dinero se presta en trozos a partir de 10 &euro;, lo que significa que ninguna persona tendr&aacute; m&aacute;s del 1% de su inversi&oacute;n total.</p>\r\n\r\n<p><strong>Acceda a su dinero</strong></p>\r\n\r\n<p>Puede retirar sus reembolsos mensuales, ya que los prestatarios los reembolsan de forma gratuita, permitiendo que los reembolsos ingresen en su cuenta de haberes. Si desea acceder a una suma global, puede vender sus pr&eacute;stamos pendientes a otros inversores por una tarifa del 1%.</p>\r\n\r\n<p>Valores predeterminados en SMART CREDIT</p>\r\n\r\n<p>Si un prestatario pierde el valor de los reembolsos de 4 meses, su pr&eacute;stamo est&aacute; impago y su capital puede ser reclamada por la via judicial. Despu&eacute;s de un incumplimiento, a&uacute;n hacemos todos los esfuerzos posibles por recuperar su capital y le devolvemos esos fondos. Sus factores de retorno proyectados en los valores predeterminados esperados</p>\r\n', 2),
(100, 48, 'FAQ for Investing', '<p>FAQ&nbsp;</p>\r\n\r\n<p><strong>Smart investments.</strong></p>\r\n\r\n<p>We believe a INVESTMENT should be afordable for everyone, not for a few. Investment should be rewarding, but also ethical.</p>\r\n\r\n<p>We&#39;re shaping the future of finance by offering competitive rates, flexible and intuitive products and award-winning customer service.</p>\r\n\r\n<p>We exist to make money simple and fair for everyone &ndash; to enable people to do more with their money and take control of their finances.</p>\r\n\r\n<p><strong>Please note the Trust is not a guarantee and your investment is not covered by the Financial Services Compensation Scheme.</strong></p>\r\n\r\n<p>If you need access to the money you have lent out before your borrowers are due to pay it back, you can use the Rapid Return Facility to sell your Loan Contracts to another investor. You can access your money any time so long as there is another investor to sell your Loan Contract to. This may occur within a few business days, but there is a chance that you may not be able to access your money when you want it. For investments in SMARTCREDIT Classic and SMARTCREDIT Plus, SMARTCREDIT will charge you a small fee (1% of the full amount owing by the Borrower under the loan) for arranging and facilitating the sale of your loan, and if your Loan Contract is for a lower interest rate than the incoming investor&rsquo;s offer, you will have to pay that investor the shortfall.</p>\r\n\r\n<p>Your money is held by us in trust on your behalf in a segregated bank account so that it does not form part of our assets and would not be available to our creditors in the event of our insolvency. We administer Loan Contracts in a way that ensures that the fees payable in relation to those Loan Contracts will be sufficient to cover the costs of administering them during any winding down process if we were to cease trading for any reason. SMARTCREDIT customers do not have recourse to the Financial Services Compensation Scheme.</p>\r\n', 1),
(101, 48, 'InformaciÃ³n de interÃ©s para inversores', '<p><strong>Informaci&oacute;n b&aacute;sica que debes conocer antes de invertir en SMARTCREDIT</strong></p>\r\n\r\n<p>Al aceptar nuestras condiciones y/o usar nuestros servicios, confirmas que entiendes y aceptas los riesgos asociados a conceder pr&eacute;stamos a trav&eacute;s de SMARTCREDIT, incluyendo, entre otros, los siguientes:</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Como inversor, debes saber que existe el riesgo de p&eacute;rdida total o parcial del capital invertido. Igualmente tienes el riesgo de no obtener el rendimiento dinerario esperado y/o de la falta de liquidez de la inversi&oacute;n.</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SMARTCREDIT no ostenta la condici&oacute;n de empresa de servicios de inversi&oacute;n, ni de entidad de cr&eacute;dito y no est&aacute; adherida a ning&uacute;n fondo de garant&iacute;a de inversiones o fondo de garant&iacute;a de dep&oacute;sitos. Por tanto, el capital invertido en los prestamos no est&aacute; garantizado por el fondo de garant&iacute;a de inversiones ni por el fondo de garant&iacute;a de dep&oacute;sitos.</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Los pr&eacute;stamos que publicamos en SMARTCREDIT no son objeto de autorizaci&oacute;n ni de supervisi&oacute;n por la Comisi&oacute;n Nacional del Mercado de Valores ni por el Banco de Espa&ntilde;a y la informaci&oacute;n facilitada por el promotor (prestatario) no ha sido revisada por ellos.</p>\r\n', 2),
(102, 49, 'Risk Management', '<p><strong>Please note the Trust is not a guarantee and your investment is not covered by the Financial Services Compensation Scheme.</strong></p>\r\n\r\n<p>If you need access to the money you have lent out before your borrowers are due to pay it back, you can use the Rapid Return Facility to sell your Loan Contracts to another investor. You can access your money any time so long as there is another investor to sell your Loan Contract to. This may occur within a few business days, but there is a chance that you may not be able to access your money when you want it. For investments in SMARTCREDIT Classic and SMARTCREDIT Plus, SMARTCREDIT will charge you a small fee (1% of the full amount owing by the Borrower under the loan) for arranging and facilitating the sale of your loan, and if your Loan Contract is for a lower interest rate than the incoming investor&rsquo;s offer, you will have to pay that investor the shortfall.</p>\r\n\r\n<p>Your money is held by us in trust on your behalf in a segregated bank account so that it does not form part of our assets and would not be available to our creditors in the event of our insolvency. We administer Loan Contracts in a way that ensures that the fees payable in relation to those Loan Contracts will be sufficient to cover the costs of administering them during any winding down process if we were to cease trading for any reason. SMARTCREDIT customers do not have recourse to the Financial Services Compensation Scheme.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 1),
(103, 49, 'InformaciÃ³n de interÃ©s para inversores', '<p>SMART CREDIT utiliza la tecnolog&iacute;a m&aacute;s avanzada para analizar los datos de nuestros clientes, pretstarios, y as&iacute; poder ser una finaciera sostenible donde el an&aacute;lisis del riesgo crediticio sea uno de los KIP&acute;S, indicadores de &eacute;xito de la plataforma de crowdlending.</p>\r\n\r\n<p>Eso significa que solo concedemos pr&eacute;stamos a un porcentaje reducido de todas las aplicaciones que recibimos y que solo concedemos a aquellas personas que nos ofrecen confianza y garant&iacute;as de devoluci&oacute;n por su historial crediticio. Concedemos pr&eacute;stamos a gente responsable que sabemos que solicita financiar una compra con un valor aspiracional.</p>\r\n\r\n<p>Aun as&iacute;, en pocas ocasiones, pero puede ocuurir, los prestatarios pueden retrasarse en sus pagos.&nbsp;</p>\r\n\r\n<p><strong>informaci&oacute;n b&aacute;sica que debes conocer antes de invertir en SMARTCREDIT</strong></p>\r\n\r\n<p>Al aceptar nuestras condiciones y/o usar nuestros servicios, confirmas que entiendes y aceptas los riesgos asociados a conceder pr&eacute;stamos a trav&eacute;s de SMARTCREDIT, incluyendo, entre otros, los siguientes:</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Como inversor, debes saber que existe el riesgo de p&eacute;rdida total o parcial del capital invertido. Igualmente tienes el riesgo de no obtener el rendimiento dinerario esperado y/o de la falta de liquidez de la inversi&oacute;n.</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SMARTCREDIT no ostenta la condici&oacute;n de empresa de servicios de inversi&oacute;n, ni de entidad de cr&eacute;dito y no est&aacute; adherida a ning&uacute;n fondo de garant&iacute;a de inversiones o fondo de garant&iacute;a de dep&oacute;sitos. Por tanto, el capital invertido en los prestamos no est&aacute; garantizado por el fondo de garant&iacute;a de inversiones ni por el fondo de garant&iacute;a de dep&oacute;sitos.</p>\r\n\r\n<p>&middot;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Los pr&eacute;stamos que publicamos en SMARTCREDIT no son objeto de autorizaci&oacute;n ni de supervisi&oacute;n por la Comisi&oacute;n Nacional del Mercado de Valores ni por el Banco de Espa&ntilde;a y la informaci&oacute;n facilitada por el promotor (prestatario) no ha sido revisada por ellos.</p>\r\n', 2),
(104, 50, 'Representative Example', '<p>Loan amount &euro; 3,000 at 1 year annual interest rate 15%, opening fee &euro; 35, 12 installments, and amount of each installment &euro; 270,77, APR: 18,68%.</p>\r\n', 1),
(105, 50, 'Ejemplo representativo', '<p>Importe del pr&eacute;stamo 3.000&euro; a un 1a&ntilde;o el tipo de inter&eacute;s anual 15%, la comisi&oacute;n de apertura 35&euro;, 12 cuotas, e importe de cada cuota 270,77&euro; mes,&nbsp;<strong>TAE:</strong> 18,68 %.</p>\r\n', 2),
(106, 51, 'We''re here!!', '<p>Opening hours: From Monday to Thursday (<strong>9am to 5pm</strong>), and Friday (<strong>9am to 4pm</strong>).</p>\r\n', 1),
(107, 51, 'Â¡Â¡Estamos aquÃ­!!', '<p>Horario de atenci&oacute;n: de lunes a jueves (de 9 a.m. a 5 p.m.) y viernes (de 9 a.m. a 4 p.m.).</p>\r\n', 2),
(108, 52, 'FINANCE YOUR AESTHETIC SURGERY', '<p>SMARTCREDIT wants to help you finance those services or products to make your life easier, such as A MEDICAL TREATMENT OR AESTHETIC SURGERY.</p>\r\n\r\n<p>So if you are a person with concerns to improve in any area, and want to do a master to take a professional leap, or a treatment of medicine or cosmetic surgery and need an economic boost, from SMARTCREDIT we want to finance your project.</p>\r\n\r\n<p>How does it work?</p>\r\n\r\n<p>1. Either the establishment itself will offer you the possibility of accessing the payment of the service through our financing platform. In case the establishment you have chosen does not offer financing, tell it about SMARTCREDIT or, send us the establishment&#39;s information so that contact and can sell your products or services financed with SMARTCREDIT.</p>\r\n\r\n<p>2. Or if you land on SMARTCREDIT from the internet, and you are looking for funding to perform a medicine or cosmetic surgery treatment, or a push to decide to take that master&#39;s degree or course that will make you progress professionally, here we can help you by offering you online funding, simple way, and without paperwork, you only need to have on hand the budget of the commercial establishment at the time of contracting the financing online.</p>\r\n\r\n<p>The process is easy and simple, SMARTCREDIT wants to help you get closer to your dreams by facilitating financing online.</p>\r\n', 1),
(109, 52, 'FINANCIA TU OPERACIÃ“N DE CIRUGÃA ESTÃ‰TICA, OFTALMOLOGÃA U ODONTOLOGÃA', '<p>En SMARTCREDIT queremos ayudarte a que puedas realizar aquellos tratamiento m&eacute;dicos que deseas, tales como un tratamiento de ODONTOLOG&Iacute;A, OFTALMOLOG&Iacute;A o de MEDICINA O CIRUG&Iacute;A EST&Eacute;TICA ofreci&eacute;ndote financiaci&oacute;n de forma sencilla des del mismo centro m&eacute;dico y con una respuesta inmediata.</p>\r\n\r\n<p>Si eres una persona con inquietudes por mejorar en cualquier &aacute;mbito personal y de salud, y quieres realizar un tratamiento m&eacute;dico, oftalmol&oacute;g&iacute;co, o de medicina o cirug&iacute;a est&eacute;tica, y necesitas un empuj&oacute;n econ&oacute;mico, des de SMARTCREDIT queremos ayudarte.</p>\r\n\r\n<p>&iquest;C&oacute;mo funciona?</p>\r\n\r\n<p>1. Puedes acceder a la financiaci&oacute;n de la compra a trav&eacute;s de la propia cl&iacute;nica, la cual te ofrecer&aacute; en el momento del pago la posibilidad de acceder a nuestra financaici&oacute;n utilizando nuestra APP.</p>\r\n\r\n<p>2. O bien si aterrizas en SMARTCREDIT desde internet, y est&aacute;s buscando financiaci&oacute;n para realizarte un tratamiento de medicina o cirug&iacute;a est&eacute;tica, puedes solicitarla online, de forma sencilla y sin papeleos, solo necesitas tener a mano el presupuesto del establecimiento m&eacute;dico en el momento de la contratar online.</p>\r\n\r\n<p>El proceso es f&aacute;cil y sencillo, SMARTCREDIT quiere ayudarte a que puedas acercarte a tus sue&ntilde;os facilit&aacute;ndote la financiaci&oacute;n de manera online. Hasta 3.000&euro;.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2),
(110, 53, 'Important Notes', '<ul>\r\n	<li>Smart Credit will send an SMS with a code so you can confirm your acceptance and digitally sign the contract.</li>\r\n	<li>Once you have entered the code in the web process received by SMS, the loan will be approved and you will receive the binding contract in your email.</li>\r\n	<li>The amount of the purchase will be sent to the Merchant.</li>\r\n	<li>Remember that it is very important to pay monthly payments, according to the payment policy.</li>\r\n</ul>\r\n', 1),
(111, 53, 'Notas importantes:', '<ul>\r\n	<li>Smart Credit enviar&aacute; un sms con un c&oacute;digo para que puedas confirmar tu aceptaci&oacute;n y firmar de forma digital el contrato.</li>\r\n	<li>Una vez introducido el c&oacute;digo en el proceso web recibido por sms, el pr&eacute;stamo quedar&aacute; aprobado y recibir&aacute; el contrato vinculante en su correo electr&oacute;nico.</li>\r\n	<li>El importe de la compra ser&aacute; enviado al establecimiento comercial.</li>\r\n	<li>Recuerda que es muy importante atender los pagos mensuales, de acuerdo con la pol&iacute;tica de pagos.</li>\r\n</ul>\r\n', 2),
(112, 54, 'Footer Additional Text', '<p>The SMARTCREDIT Society, S.L. Company of Spanish nationality, with address at Calle Constituci&oacute;n n&ordm; 2, 1st office 3. 08960. Sant Just Desvern, Barcelona. And CIF number B-67193698, Registered in the Mercantile Registry of Barcelona.<br />\r\nTelephone number 932426919<br />\r\nContact E-Mail; info@smartcredit.es</p>\r\n\r\n<p>the detailed information in articles 7 and 8 of Law 22/2007, of July 11, on Distance Marketing of Financial Services Destined to Consumers, as well as the one foreseen in articles 10 and 12 of Law 16/2011, of June 24, Consumer Credit Contracts, will be made available to the Borrower in sufficient time in accordance with current regulations.</p>\r\n', 1),
(113, 54, 'Texto adicional del pie de pÃ¡gina', '<p>La Sociedad SMARTCREDIT, S.L. Sociedad de nacionalidad espa&ntilde;ola, con domicilio en Calle Constituci&oacute;n n&ordm; 2, 1&ordf; &nbsp;despacho 3. 08960. Sant Just Desvern, Barcelona. Y n&uacute;mero de CIF B-67193698, Inscrita en el Registro Mercantil de Barcelona.</p>\r\n\r\n<p>Numero de tel&eacute;fono 932426919</p>\r\n\r\n<p>Correo electr&oacute;nico de contacto; info@smartcredit.es</p>\r\n\r\n<p>&nbsp;</p>\r\n', 2),
(114, 55, 'ADVANTAGES FOR YOUR BUSINESS', '<p><strong>1. Increase your sales.</strong></p>\r\n\r\n<p>Go further by offering the financing option to your customers. With SmartCredit, you will have many more customers and you will be able to close many more sales. &nbsp;</p>\r\n\r\n<p><strong>2. Do your customers think twice before buying your products?</strong> &nbsp;</p>\r\n\r\n<p>With Smart Credit you will see that your customers easily access more expensive products, where you can get more margin. Get more benefits by selling more products, with Smart Credit you can reach more customers and get many more benefits.&nbsp;</p>\r\n\r\n<p><strong>3. Do you charge for your sales in less than 24 hours.</strong></p>\r\n\r\n<p>Your customers receive financing, and you charge for each sale at the moment (as fast as our transfer arrives).</p>\r\n', 1),
(115, 55, 'VENTAJAS PARA TU NEGOCIO', '<p><strong>1. Aumenta tus ventas.</strong></p>\r\n\r\n<p>Llega m&aacute;s lejos ofreciendo la opci&oacute;n de financiaci&oacute;n a tus clientes. Con SmartCredit, tendr&aacute;s muchos m&aacute;s clientes y podr&aacute;s cerrar muchas m&aacute;s ventas.</p>\r\n\r\n<p><strong>2. &iquest;Tus clientes se lo piensan 2 veces antes de comprar tus productos?</strong></p>\r\n\r\n<p>Con Smart Credit ver&aacute;s que tus clientes acceden a productos m&aacute;s caros, donde podr&aacute;s obtener un margen de contribuci&oacute;n mayor. Podr&aacute;s aumentar tus ventas y obtener muchos m&aacute;s beneficios. &nbsp;</p>\r\n\r\n<p><strong>3. Cobra por tus ventas en menos de 24 horas.</strong></p>\r\n\r\n<p>Tus clientes reciben la financiaci&oacute;n de la compra, y tu cobras por cada venta al momento (tan r&aacute;pido como llegue nuestra transferencia).</p>\r\n\r\n<p><strong>Disfruta de las ventajas des del primer momento &ndash; Omnicanal-</strong></p>\r\n', 2);

-- --------------------------------------------------------

--
-- Table structure for table `smc_security_questions`
--

CREATE TABLE IF NOT EXISTS `smc_security_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `smc_security_questions`
--

INSERT INTO `smc_security_questions` (`id`, `value`, `flag`) VALUES
(1, 'What was your childhood nickname?', '1'),
(2, 'What is the name of your favorite childhood friend?', '1'),
(3, 'In what city or town did your mother and father meet?', '1'),
(4, 'What is the middle name of your oldest child?', '1'),
(5, 'What is your favorite team?', '1'),
(6, 'What is your favorite movie?', '1'),
(7, 'What school did you attend for sixth grade?', '1'),
(8, 'What was the last name of your third grade teacher?', '1'),
(9, 'In what town was your first job?', '1'),
(10, 'What was the name of the company where you had your first job?', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_service_type`
--

CREATE TABLE IF NOT EXISTS `smc_service_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `smc_service_type`
--

INSERT INTO `smc_service_type` (`id`, `value`, `flag`) VALUES
(1, 'Accountancy', '1'),
(2, 'Advertising and Media', '1'),
(3, 'Business Consultancy', '1'),
(4, 'Call Center Operations', '1'),
(5, 'Cleaning', '1'),
(6, 'Computer Services', '1'),
(7, 'Construction', '1'),
(8, 'Education', '1'),
(9, 'Electricity', '1'),
(10, 'Finance', '1'),
(11, 'Health', '1'),
(12, 'Legal Services', '1'),
(13, 'Leisure, Cultural, Travel and Tourism', '1'),
(14, 'Manufacturing', '1'),
(15, 'Mining', '1'),
(16, 'Publishing', '1'),
(17, 'Property', '1'),
(18, 'Research and Development', '1'),
(19, 'Telecoms, Internet and IT', '1'),
(20, 'Transport and Logistics', '1'),
(21, 'Research and Development', '1'),
(22, 'Engineering', '1'),
(23, 'Firefighter', '1'),
(24, 'Management', '1'),
(25, 'Marketing', '1'),
(26, 'Mini Cab Driver', '1'),
(27, 'Musician', '1'),
(28, 'Nurse', '1'),
(29, 'Sales', '1'),
(30, 'Senior Manager/Director', '1'),
(31, 'Services', '1'),
(32, 'Teacher', '1'),
(33, 'Truck Driver', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_terms`
--

CREATE TABLE IF NOT EXISTS `smc_terms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term` varchar(255) DEFAULT NULL,
  `flag` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=287 ;

--
-- Dumping data for table `smc_terms`
--

INSERT INTO `smc_terms` (`id`, `term`, `flag`) VALUES
(54, 'Get Loan', '1'),
(55, 'Invest', '1'),
(56, 'I am a Merchant', '1'),
(57, 'Copyright', '1'),
(58, 'All rights reserved', '1'),
(59, 'Home', '1'),
(60, 'About Us', '1'),
(63, 'FAQ', '1'),
(64, 'Contact Us', '1'),
(65, 'Sign In', '1'),
(66, 'Get a loan/Purchase your wish', '1'),
(67, 'Your personalised loan rates in 3 minutes. This won''t affect your credit score.', '1'),
(68, 'I want to get a loan for', '1'),
(69, 'Term', '1'),
(70, 'Monthly Cost', '1'),
(71, 'months', '1'),
(72, 'Get Personalized Rates', '1'),
(73, 'You have chosen a loan amount of', '1'),
(74, 'for the period of', '1'),
(75, 'Provide your personal details below', '1'),
(76, 'Personal Details', '1'),
(77, 'Your Name', '1'),
(78, 'First Name', '1'),
(79, 'Middle Name', '1'),
(80, 'Surname', '1'),
(81, 'ID Number', '1'),
(82, 'Home Language', '1'),
(83, 'Status', '1'),
(84, 'Marital Status', '1'),
(85, 'Number of Dependants', '1'),
(86, 'Employment Details', '1'),
(87, 'Employment Type', '1'),
(88, 'Employer Company Name', '1'),
(89, 'Gross Monthly Income', '1'),
(90, 'Net Monthly Income', '1'),
(91, 'Service Type', '1'),
(92, 'Time With Employer in Years', '1'),
(93, 'University', '1'),
(94, 'Time at University', '1'),
(95, 'Division', '1'),
(96, 'Time in Service', '1'),
(97, 'Work Phone Number', '1'),
(98, 'Frequency of Income', '1'),
(99, 'Next Pay Date', '1'),
(100, 'Cell Phone Number', '1'),
(101, 'Alternate Number', '1'),
(102, 'Email Address', '1'),
(103, 'Confirm Email Address', '1'),
(104, 'Address Details', '1'),
(105, 'House Number', '1'),
(106, 'Street Name', '1'),
(107, 'Suburb', '1'),
(108, 'City', '1'),
(109, 'Province', '1'),
(110, 'Postcode', '1'),
(111, 'Continue', '1'),
(112, 'Provide Your Account Information', '1'),
(113, 'Account Setup', '1'),
(114, 'User Name', '1'),
(115, 'Choose Password', '1'),
(116, 'Confirm Password', '1'),
(117, 'Secret Question', '1'),
(118, 'Secret Answer', '1'),
(119, 'Provide Your Bank Details', '1'),
(120, 'Bank Details', '1'),
(121, 'Bank Name', '1'),
(122, 'Account Number', '1'),
(123, 'Name of Account Holder', '1'),
(124, 'Time with Bank', '1'),
(125, 'Credit Card Details', '1'),
(126, 'Name on Card', '1'),
(127, 'Card Number', '1'),
(128, 'Expiry Month', '1'),
(129, 'Expiry Year', '1'),
(130, 'Please Wait', '1'),
(131, 'Your risk scoring is being done', '1'),
(132, 'Congratulations', '1'),
(133, 'Your loan has been accepted', '1'),
(134, 'Pre contactual information has been sent to your email address. If you agree, please click in the link to confirm you sign the Contractual Terms and Conditions', '1'),
(135, 'By clicking I do agree with the', '1'),
(136, 'Privacy Policy', '1'),
(137, 'of the website', '1'),
(138, 'Legal Information', '1'),
(139, 'Important Notes', '1'),
(140, 'Once approved the amount will be sent to your account within 15 minutes', '1'),
(141, 'Depending on the bank you work with, the transfer may take a bit longer', '1'),
(142, 'Remember to payback on the agreed date', '1'),
(143, 'See', '1'),
(144, 'Thank You', '1'),
(145, 'A smart investment', '1'),
(146, 'Demand from investors for our peer-to-peer platform is exceptionally high. If you would like to start investing with us, sign up to our waiting list and when we''re next open to new investors we''ll be in touch', '1'),
(147, 'Investor Registration', '1'),
(148, 'Email', '1'),
(149, 'Password', '1'),
(150, 'Confirm Password', '1'),
(151, 'Full Name', '1'),
(152, 'Mobile Phone', '1'),
(153, 'Register', '1'),
(154, 'OR', '1'),
(155, 'If you are already registered', '1'),
(156, 'Click here', '1'),
(157, 'to signin', '1'),
(158, 'Message Sent Successfully', '1'),
(159, 'Invalid Captcha Entered', '1'),
(160, 'Enquiry Form', '1'),
(161, 'Do you have an enquiry? Please fill up the details below and send me your message', '1'),
(162, 'Name', '1'),
(163, 'Message', '1'),
(164, 'Enter Result', '1'),
(165, 'Send Message', '1'),
(166, 'I Agree', '1'),
(167, 'Merchant Name', '1'),
(168, 'Product Name', '1'),
(169, 'Amount Lended', '1'),
(170, 'Good deal', '1'),
(171, 'makes your sales increase', '1'),
(172, 'An sms has been sent to the customer for accepting the loan terms and conditions. Amount will be transfered to borrower as soon as the acceptance is done', '1'),
(173, 'Okay', '1'),
(174, 'Welcome back', '1'),
(175, 'To sign in, please enter your details. Not got an account?', '1'),
(176, 'to signup', '1'),
(177, 'Investor Signin', '1'),
(178, 'Remember Me', '1'),
(179, 'Sign in Securely', '1'),
(180, 'My Investments', '1'),
(181, 'Choose Risk Level', '1'),
(182, 'Loan', '1'),
(183, 'Borrower Name', '1'),
(184, 'Terms', '1'),
(185, 'Amount to Fund', '1'),
(186, 'Funded', '1'),
(187, 'Score', '1'),
(188, 'Risk Level', '1'),
(189, 'My Bid', '1'),
(190, 'Bid', '1'),
(191, 'Logout', '1'),
(192, 'Account Created', '1'),
(193, 'Account created with', '1'),
(194, 'An email with verification link has been sent to your email address. Please click on that link to verify your account', '1'),
(195, 'Click here to Sign In', '1'),
(196, 'Get a Loan', '1'),
(197, 'Payment Policy', '1'),
(198, 'Your personalised loan rates in 3 minutes. This won\\''t affect your credit score. We check your details with a soft credit search', '1'),
(199, 'Investment Opportunities', '1'),
(200, 'Investor Login', '1'),
(201, 'You are almost there', '1'),
(202, 'For your loan approval you need to accept our privacy policy and terms and conditions. Please tick the checkboxes below if you agree.', '1'),
(203, 'Success', '1'),
(204, 'Your loan application has been submitted', '1'),
(205, 'Contractual information will be sent to your email address once your loan application is approved. It will take short time to review your details. Please be patient.', '1'),
(206, 'Submit Application', '1'),
(207, 'Attach your last payslip', '1'),
(208, 'Attach your bank certificate', '1'),
(209, 'Mobile Verification', '1'),
(210, 'Submit', '1'),
(211, 'A 6 digit verification code has been sent to your mobile number. Please enter it in the below textbox to verify your cell number.', '1'),
(212, 'Enter Verification Code', '1'),
(213, 'Sign In', '1'),
(214, 'Merchant', '1'),
(215, 'Create an Account', '1'),
(216, 'Merchant Signup', '1'),
(217, 'Please fill up the below form and submit to create your free account. Once your account is created and approved you can send loan application on behalf of your customer.', '1'),
(218, 'Merchant Signin', '1'),
(219, 'Contact Person', '1'),
(220, 'Bank Account No', '1'),
(221, 'Bank Name', '1'),
(222, 'Sector', '1'),
(223, 'Merchant Name', '1'),
(224, 'Your merchant account has been successfully created. Please be patient while the admin approves your account. You will be able to login to your account once approved and then you can apply for loans for your customers.', '1'),
(225, 'Invalid username or password', '1'),
(226, 'Customer Loans', '1'),
(227, 'My Account', '1'),
(228, 'Applied On', '1'),
(229, 'Get Started', '1'),
(230, 'How it Works', '1'),
(231, 'Blog', '1'),
(232, 'Partnership', '1'),
(233, 'Contact', '1'),
(234, 'Principals', '1'),
(235, 'Cookies', '1'),
(236, 'Conflict Policy', '1'),
(237, 'Invest', '1'),
(238, 'Risk Management', '1'),
(239, 'Who Uses', '1'),
(240, 'FAQ for investing', '1'),
(241, 'Annual Interest', '1'),
(242, 'We can''t take applications over the phone. Spanish residents only. Calls may be monitored or recorded.', '1'),
(243, 'for loans', '1'),
(244, 'for investments', '1'),
(245, 'Yes', '1'),
(246, 'No', '1'),
(247, 'Date of Birth', '1'),
(248, 'Merchant Details', '1'),
(249, 'Do you have a merchant id?', '1'),
(250, 'Merchant ID Number', '1'),
(251, 'Purpose of the Loan', '1'),
(252, 'Merchant Name and Contact Number or Merchant Website', '1'),
(253, 'Budget Attachment', '1'),
(254, 'ID proof Attachment (Optional)', '1'),
(255, 'Your account has been successfully created. Please be patient while the admin approves your account. You will be able to login to your account once approved.', '1'),
(256, 'Once the loan is approved, the amount will be sent to the account of the establishment with which you have contracted.', '1'),
(257, 'Depending on the bank with which the establishment works, the transfer may take more or less time to become effective.', '1'),
(258, 'Remember to pay every day 1 of each month.', '1'),
(259, 'Enter your credentials', '1'),
(260, 'My Loans', '1'),
(261, 'Verify your email', '1'),
(262, 'Provide some more account related information to successfully register your account', '1'),
(263, 'Email address verified!', '1'),
(264, 'URL', '1'),
(265, 'Address', '1'),
(266, 'Account Details', '1'),
(267, 'Update', '1'),
(268, 'Information updated successfully', '1'),
(269, 'Web', '1'),
(270, 'Telephone', '1'),
(271, '100% Flexible', '1'),
(272, 'Forgot Password', '1'),
(273, 'Don''t worry we''ll help you to retrive your password. Enter your registered email address below:', '1'),
(274, 'Reset Password', '1'),
(275, 'Please set your new password below', '1'),
(276, 'New Password', '1'),
(277, 'Don''t worry we''ll help you to retrive your password. Enter your registered email address below:', '1'),
(278, 'An email has been sent to your email address with the instructions to reset your password.', '1'),
(279, 'Your password has been successfully reset. Please', '1'),
(280, 'My Payments', '1'),
(281, 'EMI Amount', '1'),
(282, 'EMI Date', '1'),
(283, 'Borrower Signin', '1'),
(284, 'Borrower', '1'),
(285, 'Trader', '1'),
(286, 'Lender', '1');

-- --------------------------------------------------------

--
-- Table structure for table `smc_term_language`
--

CREATE TABLE IF NOT EXISTS `smc_term_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `term_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `language_term` text,
  PRIMARY KEY (`id`),
  KEY `term_id` (`term_id`),
  KEY `language_id` (`language_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=573 ;

--
-- Dumping data for table `smc_term_language`
--

INSERT INTO `smc_term_language` (`id`, `term_id`, `language_id`, `language_term`) VALUES
(111, 65, 1, 'Sign In'),
(112, 65, 2, 'Registrate'),
(113, 64, 1, 'Contact Us'),
(114, 64, 2, 'ContÃ¡ctanos'),
(115, 63, 1, 'FAQ'),
(116, 63, 2, 'FAQS'),
(117, 60, 1, 'About Us'),
(118, 60, 2, 'Sobre nosotros'),
(119, 59, 1, 'Home'),
(120, 59, 2, 'Home'),
(121, 58, 1, 'All rights reserved'),
(122, 58, 2, 'Todos los derechos reservados'),
(123, 57, 1, 'Copyright'),
(124, 57, 2, 'Derechos de autor'),
(125, 56, 1, 'IÂ´m a Merchant'),
(126, 56, 2, 'Soy comerciantes'),
(127, 55, 1, 'Invest'),
(128, 55, 2, 'Invertir'),
(129, 54, 1, 'Get a Loan'),
(130, 54, 2, 'Financiar una compra'),
(131, 72, 1, 'Get Personalized Rates'),
(132, 72, 2, 'EvaluaciÃ³n de riesgo'),
(133, 71, 1, 'Months'),
(134, 71, 2, 'Meses'),
(135, 70, 1, 'Monthly Cost'),
(136, 70, 2, 'Cuota mensual'),
(137, 69, 1, 'Term'),
(138, 69, 2, 'Plazo'),
(139, 68, 1, 'I want to get a loan for'),
(140, 68, 2, 'Deseo comprar a plazos'),
(141, 67, 1, 'Your personalised loan rates in 3 minutes. This won''t affect your credit score.'),
(142, 67, 2, 'Te daremos una respuesta a tu solicitud en pocos minutos.'),
(143, 66, 1, 'Get a loan/Purchase your wish'),
(144, 66, 2, 'Financia tus compras'),
(145, 195, 1, 'Click here to Sign In'),
(146, 195, 2, 'Clic aquÃ­ para iniciar sesiÃ³n'),
(147, 194, 1, 'An email with verification link has been sent to your email address. Please click on that link to verify your account'),
(148, 194, 2, 'Se ha enviado un correo electrÃ³nico con un enlace de verificaciÃ³n a tu direcciÃ³n de correo electrÃ³nico. Haz clic en ese enlace para verificar tu cuenta.'),
(149, 193, 1, 'Account created with'),
(150, 193, 2, 'Cuenta creada con'),
(151, 192, 1, 'Account Created'),
(152, 192, 2, 'Cuenta creada'),
(153, 191, 1, 'Logout'),
(154, 191, 2, 'Cerrar sesiÃ³n'),
(155, 190, 1, 'Bid'),
(156, 190, 2, 'Oferta'),
(157, 189, 1, 'My Bid'),
(158, 189, 2, 'Mi oferta'),
(159, 188, 1, 'Risk Level'),
(160, 188, 2, 'Nivel de riesgo'),
(161, 187, 1, 'Score'),
(162, 187, 2, 'Scoring'),
(163, 186, 1, 'Funded'),
(164, 186, 2, 'Fundado'),
(165, 185, 1, 'Amount to Fund'),
(166, 185, 2, 'Importe a invertir'),
(167, 184, 1, 'Terms'),
(168, 184, 2, 'Condiciones'),
(169, 183, 1, 'Borrower Name'),
(170, 183, 2, 'Nombre del prestatario'),
(171, 182, 1, 'Loan'),
(172, 182, 2, 'PrÃ©stamo'),
(173, 181, 1, 'Choose Risk Level'),
(174, 181, 2, 'Elije el nivel de riesgo'),
(175, 180, 1, 'My Investments'),
(176, 180, 2, 'Mis inversiones'),
(177, 179, 1, 'Sign in Securely'),
(178, 179, 2, 'Iniciar sesiÃ³n de forma segura'),
(179, 178, 1, 'Remember Me'),
(180, 178, 2, 'RecuÃ©rdame'),
(181, 177, 1, 'Investor Signin'),
(182, 177, 2, 'Inversor Signin'),
(183, 176, 1, 'to signup'),
(184, 176, 2, 'inscribirse'),
(185, 175, 1, 'To sign in, please enter your details. Not got an account?'),
(186, 175, 2, 'Para iniciar sesiÃ³n, ingresa tus datos. Â¿No tienes cuenta con nosotros?'),
(187, 174, 1, 'Welcome back'),
(188, 174, 2, 'Bienvenido de nuevo!'),
(189, 173, 1, 'Okay'),
(190, 173, 2, 'Correcto'),
(191, 172, 1, 'An SMS has been sent to the customer for accepting the loan terms and conditions. Amount will be transfered to borrower as soon as the acceptance is done'),
(192, 172, 2, 'Se ha enviado un SMS al cliente para que acepte los tÃ©rminos y condiciones del prÃ©stamo. El importe se transferirÃ¡ al establecimiento comercial tan pronto como se realice la aceptaciÃ³n'),
(193, 171, 1, 'makes your sales increase'),
(194, 171, 2, 'Haz que tus ventas aumenten'),
(195, 170, 1, 'Good deal'),
(196, 170, 2, 'Buen negocio'),
(197, 169, 1, 'Amount Lended'),
(198, 169, 2, 'Cantidad cedida'),
(199, 168, 1, 'Product Name'),
(200, 168, 2, 'Nombre del producto'),
(201, 167, 1, 'Merchant Name'),
(202, 167, 2, 'Nombre del comerciante'),
(203, 166, 1, 'I Agree'),
(204, 166, 2, 'Estoy de acuerdo'),
(205, 165, 1, 'Send Message'),
(206, 165, 2, 'Enviar mensaje'),
(207, 164, 1, 'Enter Result'),
(208, 164, 2, 'Introduzca el resultado'),
(209, 163, 1, 'Message'),
(210, 163, 2, 'Mensaje'),
(211, 162, 1, 'Name'),
(212, 162, 2, 'Nombre'),
(213, 161, 1, 'Do you have an enquiry? Please fill up the details below and send me your message'),
(214, 161, 2, 'Â¿Tienes alguna pregunta? Por favor, completa los detalles a continuaciÃ³n y envÃ­anos tu mensaje.'),
(215, 160, 1, 'Enquiry Form'),
(216, 160, 2, 'Formulario de Consulta'),
(217, 159, 1, 'Invalid Captcha Entered'),
(218, 159, 2, 'Captcha invÃ¡lido ingresado'),
(219, 158, 1, 'Message Sent Successfully'),
(220, 158, 2, 'Mensaje enviado con Ã©xito'),
(221, 157, 1, 'to signin'),
(222, 157, 2, 'para iniciar sesiÃ³n'),
(223, 156, 1, 'Click here'),
(224, 156, 2, 'Haz clic aquÃ­'),
(225, 155, 1, 'If you are already registered'),
(226, 155, 2, 'Si ya estÃ¡s registrado'),
(227, 154, 1, 'OR'),
(228, 154, 2, 'O'),
(229, 153, 1, 'Register'),
(230, 153, 2, 'Registro'),
(231, 152, 1, 'Mobile Phone'),
(232, 152, 2, 'TelÃ©fono mÃ³vil'),
(233, 151, 1, 'Full Name'),
(234, 151, 2, 'Nombre completo'),
(235, 150, 1, 'Confirm Password'),
(236, 150, 2, 'Confirmar contraseÃ±a'),
(237, 149, 1, 'Password'),
(238, 149, 2, 'ContraseÃ±a'),
(239, 148, 1, 'Email'),
(240, 148, 2, 'Email'),
(241, 147, 1, 'Investor Registration'),
(242, 147, 2, 'Registro de inversores'),
(243, 146, 1, 'Demand from investors for our peer-to-peer platform is exceptionally high. If you would like to start investing with us, sign up to our waiting list and when we''re next open to new investors we''ll be in touch'),
(244, 146, 2, 'La demanda de los inversores para nuestra plataforma peer-to-peer es excepcionalmente alta. Si deseas comenzar a invertir con nosotros, regÃ­strate en nuestra lista de espera y, cuando estemos nuevamente abiertos a nuevos inversores, nos comunicaremos con usted.'),
(245, 145, 1, 'A smart investment'),
(246, 145, 2, 'Una inversiÃ³n inteligente'),
(247, 144, 1, 'Thank You'),
(248, 144, 2, 'Gracias'),
(249, 143, 1, 'See'),
(250, 143, 2, 'Ver'),
(251, 142, 1, 'Remember to payback on the agreed date'),
(252, 142, 2, 'Recuerda pagar en la fecha acordada'),
(253, 141, 1, 'Depending on the bank you work with, the transfer may take a bit longer'),
(254, 141, 2, 'Dependiendo del banco con el que trabajes, la transferencia puede tardar un poco mÃ¡s'),
(255, 140, 1, 'Once approved the amount will be sent to your account within 15 minutes'),
(256, 140, 2, 'Una vez aprobado, el importe se enviarÃ¡ a su cuenta en 15 minutos.'),
(257, 139, 1, 'Important Notes'),
(258, 139, 2, 'Notas importantes'),
(259, 138, 1, 'Legal Information'),
(260, 138, 2, 'InformaciÃ³n legal'),
(261, 137, 1, 'of the website'),
(262, 137, 2, 'del sitio web'),
(263, 136, 1, 'Privacy Policy'),
(264, 136, 2, 'PolÃ­tica de privacidad'),
(265, 135, 1, 'By clicking I do agree with the'),
(266, 135, 2, 'Al hacer clic en Estoy de acuerdo con el'),
(267, 134, 1, 'Pre contactual information has been sent to your email address. If you agree, please click in the link to confirm you sign the Contractual Terms and Conditions'),
(268, 134, 2, 'Se ha enviado informaciÃ³n precontextual a tu direcciÃ³n de correo electrÃ³nico. Si aceptas, haz clic en el enlace para confirmar que firmas los TÃ©rminos y condiciones contractuales'),
(269, 133, 1, 'Your loan has been accepted'),
(270, 133, 2, 'Tu prÃ©stamo ha sido aceptado'),
(271, 132, 1, 'Congratulations'),
(272, 132, 2, 'Felicidades'),
(273, 131, 1, 'Your risk scoring is being done'),
(274, 131, 2, 'Se estÃ¡ realizando la evaluaciÃ³n de riesgo crediticio de tu prÃ©stamo'),
(275, 130, 1, 'Please Wait'),
(276, 130, 2, 'Por favor, espera'),
(277, 129, 1, 'Expiry Year'),
(278, 129, 2, 'AÃ±o de vencimiento'),
(279, 128, 1, 'Expiry Month'),
(280, 128, 2, 'Meses de vencimiento'),
(281, 127, 1, 'Card Number'),
(282, 127, 2, 'NÃºmero de tarjeta'),
(283, 126, 1, 'Name on Card'),
(284, 126, 2, 'Nombre en la tarjeta'),
(285, 125, 1, 'Credit Card Details'),
(286, 125, 2, 'Datos de la tarjeta de crÃ©dito'),
(287, 124, 1, 'Time with Bank'),
(288, 124, 2, 'AntigÃ¼edad en el Banco'),
(289, 123, 1, 'Name of Account Holder'),
(290, 123, 2, 'Nombre del titular de la cuenta'),
(291, 122, 1, 'Account Number'),
(292, 122, 2, 'NÃºmero de cuenta'),
(293, 121, 1, 'Bank Name'),
(294, 121, 2, 'Nombre del banco'),
(295, 120, 1, 'Bank Details'),
(296, 120, 2, 'Detalles del banco'),
(297, 119, 1, 'Provide Your Bank Details'),
(298, 119, 2, 'Proporciona los datos de tu banco'),
(299, 118, 1, 'Secret Answer'),
(300, 118, 2, 'Respuesta secreta'),
(301, 117, 1, 'Secret Question'),
(302, 117, 2, 'Pregunta secreta'),
(303, 116, 1, 'Confirm Password'),
(304, 116, 2, 'Confirmar contraseÃ±a'),
(305, 115, 1, 'Choose Password'),
(306, 115, 2, 'Elegir una contraseÃ±a'),
(307, 114, 1, 'User Name'),
(308, 114, 2, 'Nombre de usuario'),
(309, 113, 1, 'Account Setup'),
(310, 113, 2, 'Configuracion de cuenta'),
(311, 112, 1, 'Provide Your Account Information'),
(312, 112, 2, 'Proporciona la informaciÃ³n de tu cuenta'),
(313, 111, 1, 'Continue'),
(314, 111, 2, 'Continuar'),
(315, 110, 1, 'Postcode'),
(316, 110, 2, 'CÃ³digo postal'),
(317, 109, 1, 'Province'),
(318, 109, 2, 'Provincia'),
(319, 108, 1, 'City'),
(320, 108, 2, 'Ciudad'),
(321, 107, 1, 'Suburb'),
(322, 107, 2, 'PoblaciÃ³n'),
(323, 106, 1, 'Street Name'),
(324, 106, 2, 'Nombre de la calle'),
(325, 105, 1, 'Street Number'),
(326, 105, 2, 'NÃºmero'),
(327, 104, 1, 'Address Details'),
(328, 104, 2, 'DirecciÃ³n'),
(329, 103, 1, 'Confirm Email Address'),
(330, 103, 2, 'Confirmar el correo'),
(331, 102, 1, 'Email Address'),
(332, 102, 2, 'DirecciÃ³n de correo electrÃ³nico'),
(333, 101, 1, 'Alternate Number'),
(334, 101, 2, 'NÃºmero Alternativo'),
(335, 100, 1, 'Cell Phone Number'),
(336, 100, 2, 'NÃºmero MÃ³vil'),
(337, 99, 1, 'Next Pay Date'),
(338, 99, 2, 'Siguiente fecha de pago'),
(339, 98, 1, 'Frequency of Income'),
(340, 98, 2, 'Frecuencia de ingresos'),
(341, 97, 1, 'Work Phone Number'),
(342, 97, 2, 'NÃºmero de telÃ©fono del trabajo'),
(343, 96, 1, 'Time in Service'),
(344, 96, 2, 'AntigÃ¼edad en la empresa'),
(345, 95, 1, 'Division'),
(346, 95, 2, 'DivisiÃ³n'),
(347, 94, 1, 'Time at University'),
(348, 94, 2, 'AÃ±os en que cursaste los estudios universitarios'),
(349, 93, 1, 'University'),
(350, 93, 2, 'Universidad'),
(351, 92, 1, 'Time With Employer in Years'),
(352, 92, 2, 'AntigÃ¼edad en aÃ±os'),
(353, 91, 1, 'Service Type'),
(354, 91, 2, 'Tipo de servicio'),
(355, 90, 1, 'Net Monthly Income'),
(356, 90, 2, 'Ingreso mensual neto'),
(357, 89, 1, 'Monthly expenses amount'),
(358, 89, 2, 'Gastos mensuales fijos'),
(359, 88, 1, 'Employer Company Name'),
(360, 88, 2, 'Nombre de la empresa donde trabajas'),
(361, 87, 1, 'Employment Type'),
(362, 87, 2, 'Tipo de empleo'),
(363, 86, 1, 'Employment Details'),
(364, 86, 2, 'Detalles de Empleo'),
(365, 85, 1, 'Number of Dependants'),
(366, 85, 2, 'NÃºmero de hijos/personas a su cargo'),
(367, 84, 1, 'Marital Status'),
(368, 84, 2, 'Estado civil'),
(369, 83, 1, 'Status'),
(370, 83, 2, 'Estado'),
(371, 82, 1, 'Home Language'),
(372, 82, 2, 'Idioma del hogar'),
(373, 81, 1, 'ID Number'),
(374, 81, 2, 'DNI/NIE'),
(375, 80, 1, 'Surname'),
(376, 80, 2, 'Apellido'),
(377, 79, 1, 'Middle Name'),
(378, 79, 2, 'Segundo nombre'),
(379, 78, 1, 'First Name'),
(380, 78, 2, 'Nombre'),
(381, 77, 1, 'Your Name'),
(382, 77, 2, 'Tu nombre'),
(383, 76, 1, 'Personal Details'),
(384, 76, 2, 'Detalles personales'),
(385, 75, 1, 'Provide your personal details below'),
(386, 75, 2, 'Proporciona tus datos personales a continuaciÃ³n'),
(387, 74, 1, 'for the period of'),
(388, 74, 2, 'para el perÃ­odo de'),
(389, 73, 1, 'You have chosen a loan amount of'),
(390, 73, 2, 'Has elegido un importe de prÃ©stamo de'),
(391, 196, 1, 'Get a Loan'),
(392, 196, 2, 'Financia tu compra'),
(393, 197, 1, 'Payment Policy'),
(394, 197, 2, 'PolÃ­tica de pagos'),
(395, 198, 1, 'Your personalised loan rates in 3 minutes. This won''t affect your credit score. We check your details with a soft credit search'),
(396, 198, 2, 'Tu evaluaciÃ³n de riesgo crediticio se realizarÃ¡ en pocos minutos. Verificamos tus datos para otorgarte un prÃ©stamo de manera responsable.'),
(397, 199, 1, 'Investment Opportunities'),
(398, 199, 2, 'Oportunidades de inversion'),
(399, 200, 1, 'Investor Login'),
(400, 200, 2, 'Alta como  inversor'),
(401, 202, 1, 'For your loan approval you need to accept our privacy policy and terms and conditions. Please tick the checkboxes below if you agree.'),
(402, 202, 2, 'Para la aprobaciÃ³n de tu prÃ©stamo, debes aceptar nuestra polÃ­tica de privacidad y los tÃ©rminos y condiciones. Marca las casillas de verificaciÃ³n a continuaciÃ³n si estÃ¡s de acuerdo.'),
(403, 201, 1, 'You are almost there'),
(404, 201, 2, 'Ya casi has estÃ¡s'),
(405, 205, 1, 'Contractual information will be sent to your email address once your loan application is approved. It will take short time to review your details. Please be patient.'),
(406, 205, 2, 'La informaciÃ³n que la informaciÃ³n contractual se enviarÃ¡ a tu direcciÃ³n de correo electrÃ³nico, una vez confirmes tu consentimiento introduciendo el cÃ³digo enviado a travÃ©s de SMS,  se te darÃ¡ una respuesta. Puede llevar algo de tiempo revisar todos los datos.'),
(407, 204, 1, 'Your loan application has been submitted'),
(408, 204, 2, 'Tu solicitud de prÃ©stamo ha sido enviada'),
(409, 203, 1, 'Success'),
(410, 203, 2, 'Objetivo logrado'),
(411, 206, 1, 'Submit Application'),
(412, 206, 2, 'Presentar la solicitud'),
(413, 207, 1, 'Attach your last payslip'),
(414, 207, 2, 'Adjunta tu Ãºltima nÃ³mina'),
(415, 208, 1, 'Attach your bank certificate'),
(416, 208, 2, 'Adjunta tu certificado de titularidad bancaria, o recibo bancario'),
(417, 209, 1, 'Mobile Verification'),
(418, 209, 2, 'VerificaciÃ³n mÃ³vil'),
(419, 210, 1, 'Submit'),
(420, 210, 2, 'Enviar'),
(421, 211, 1, 'A 6 digit verification code has been sent to your mobile number. Please enter it in the below textbox to verify your cell number.'),
(422, 211, 2, 'Se ha enviado un cÃ³digo de verificaciÃ³n de 6 dÃ­gitos a tu nÃºmero de telÃ©fono mÃ³vil. Por favor ingrÃ©salo en el cuadro de texto a continuaciÃ³n para verificar tu nÃºmero de telÃ©fono mÃ³vil.'),
(423, 212, 1, 'Enter Verification Code'),
(424, 212, 2, 'Insertar el cÃ³digo de verificaciÃ³n'),
(425, 213, 1, 'Log In'),
(426, 213, 2, 'Log In'),
(427, 214, 1, 'Merchant'),
(428, 214, 2, 'Comerciante'),
(429, 215, 1, 'Create an Account'),
(430, 215, 2, 'Crea una cuenta'),
(431, 216, 1, 'Merchant Signup'),
(432, 216, 2, 'Registro de comerciante'),
(433, 217, 1, 'Please fill up the below form and submit to create your free account. Once your account is created and approved you can send loan application on behalf of your customer'),
(434, 217, 2, 'Completa el siguiente formulario y envÃ­alo para crear tu cuenta gratuita. Una vez que se haya creado y aprobado tu cuenta, puedes enviar la solicitud de financiaciÃ³n de compra.'),
(435, 218, 1, 'Merchant Signin'),
(436, 218, 2, 'Comerciante Signin'),
(437, 221, 1, 'Bank Name'),
(438, 221, 2, 'Nombre del banco'),
(439, 220, 1, 'Bank Account No'),
(440, 220, 2, 'NÃºmero de Cuenta Bancaria'),
(441, 219, 1, 'Contact Person'),
(442, 219, 2, 'Persona de contacto'),
(443, 222, 1, 'Sector'),
(444, 222, 2, 'Sector'),
(445, 223, 1, 'Merchant Name'),
(446, 223, 2, 'Nombre del establecimiento'),
(447, 224, 1, 'Your merchant account has been successfully created. Please be patient while the admin approves your account. You will be able to login to your account once approved and then you can apply for loans for your customers.'),
(448, 224, 2, 'Tu cuenta como comerciante se ha creado con Ã©xito. Ten paciencia mientras el administrador aprueba la cuenta. PodrÃ¡s iniciar sesiÃ³n en su cuenta una vez que haya sido aprobado y asÃ­ podrÃ¡ solicitar financiar la compra de sus clientes.'),
(449, 225, 1, 'Invalid username or password'),
(450, 225, 2, 'Usuario o contraseÃ±a invalido'),
(451, 226, 1, 'Customer Loans'),
(452, 226, 2, 'PrÃ©stamos concedidos a tus clientes'),
(453, 227, 1, 'My Account'),
(454, 227, 2, 'Mi cuenta'),
(455, 228, 1, 'Applied On'),
(456, 228, 2, 'Aplicado en'),
(457, 229, 1, 'Get Started'),
(458, 229, 2, 'Iniciar sesiÃ³n'),
(459, 240, 1, 'FAQ for investing'),
(460, 240, 2, 'Preguntas frecuentes'),
(461, 239, 1, 'Who Uses'),
(462, 239, 2, 'A quiÃ©n estÃ¡ dirigido'),
(463, 238, 1, 'Risk Management'),
(464, 238, 2, 'GestiÃ³n de riesgos'),
(465, 237, 1, 'Invest'),
(466, 237, 2, 'Invertir'),
(467, 236, 1, 'Conflict Policy'),
(468, 236, 2, 'PolÃ­tica de Conflicto'),
(469, 235, 1, 'Cookies'),
(470, 235, 2, 'Cookies'),
(471, 234, 1, 'Principals'),
(472, 234, 2, 'Principios'),
(473, 233, 1, 'Contact'),
(474, 233, 2, 'Contacto'),
(475, 232, 1, 'Partnership'),
(476, 232, 2, 'Partnership'),
(477, 231, 1, 'Blog'),
(478, 231, 2, 'Blog'),
(479, 230, 1, 'How it Works'),
(480, 230, 2, 'CÃ³mo funciona'),
(481, 241, 1, 'Annual Interest'),
(482, 241, 2, 'InterÃ©s anual'),
(483, 242, 1, 'We can''t take applications over the phone. Spanish residents only. Calls may be monitored or recorded.'),
(484, 242, 2, 'No concedemos prÃ©stamos por telÃ©fono. Servicio para residentes EspaÃ±oles. Las llamadas pueden ser grabadas por cuestiones de calidad.'),
(485, 244, 1, 'for investments'),
(486, 244, 2, 'para inversiones'),
(487, 243, 1, 'for loans'),
(488, 243, 2, 'para prÃ©stamos'),
(489, 254, 1, 'ID proof Attachment (Optional)'),
(490, 254, 2, 'Adjuntar foto DNI (opcional)'),
(491, 253, 1, 'Budget Attachment'),
(492, 253, 2, 'Adjuntar presupuesto'),
(493, 252, 1, 'Merchant Name and Contact Number or Merchant Website'),
(494, 252, 2, 'Nombre del comerciante y nÃºmero de contacto o sitio web del comerciante'),
(495, 251, 1, 'Purpose of the Loan'),
(496, 251, 2, 'Destino del prÃ©stamo'),
(497, 250, 1, 'Merchant ID Number'),
(498, 250, 2, 'NÃºmero de identificaciÃ³n mercantil'),
(499, 249, 1, 'Do you have a merchant id?'),
(500, 249, 2, 'Â¿Tienes la identificaciÃ³n SMARTCREDIT del comerciante?'),
(501, 248, 1, 'Merchant Details'),
(502, 248, 2, 'Detalles del comerciante'),
(503, 247, 1, 'Date of Birth'),
(504, 247, 2, 'Fecha de nacimiento'),
(505, 246, 1, 'No'),
(506, 246, 2, 'No'),
(507, 245, 1, 'Yes'),
(508, 245, 2, 'SÃ­'),
(509, 255, 1, 'Your account has been successfully created. Please be patient while the admin approves your account. You will be able to login to your account once approved.'),
(510, 255, 2, 'Tu cuenta ha sido creada satisfactoriamente. Espera  mientras el administrador la aprueba. PodrÃ¡s iniciar sesiÃ³n en tu cuenta una vez aprobada.'),
(511, 258, 1, 'Remember to pay every day 1 of each month.'),
(512, 258, 2, 'Recuerda pagar cada dÃ­a 1 de cada mes.'),
(513, 257, 1, 'Depending on the bank with which the establishment works, the transfer may take more or less time to become effective.'),
(514, 257, 2, 'Dependiendo del banco con el que trabaje el establecimiento, la transferencia puede tardar mÃ¡s o menos en hacerse efectiva.'),
(515, 256, 1, 'Once the loan is approved, the amount will be sent to the account of the establishment with which you have contracted.'),
(516, 256, 2, 'Una vez aprobado el prÃ©stamo, el importe se enviarÃ¡ a la cuenta del establecimiento con el que ha contratado.'),
(517, 268, 1, 'Information updated successfully'),
(518, 268, 2, 'InformaciÃ³n actualizada con Ã©xito'),
(519, 267, 1, 'Update'),
(520, 267, 2, 'Actualizar'),
(521, 266, 1, 'Account Details'),
(522, 266, 2, 'detalles de la cuenta'),
(523, 265, 1, 'Address'),
(524, 265, 2, 'DirecciÃ³n'),
(525, 264, 1, 'URL'),
(526, 264, 2, 'URL'),
(527, 263, 1, 'Email address verified!'),
(528, 263, 2, 'Â¡Correo electrÃ³nico verificado!'),
(529, 262, 1, 'Provide some more account related information to successfully register your account'),
(530, 262, 2, 'Proporcione mÃ¡s informaciÃ³n relacionada con la cuenta para registrar con Ã©xito su cuenta'),
(531, 261, 1, 'Verify your email'),
(532, 261, 2, 'Verifique su correo electrÃ³nico'),
(533, 260, 1, 'My Loans'),
(534, 260, 2, 'Mis prÃ©stamos'),
(535, 259, 1, 'Enter your credentials'),
(536, 259, 2, 'Ingrese sus credenciales'),
(537, 271, 1, '100% Flexible'),
(538, 271, 2, '100% Flexible'),
(539, 270, 1, 'Telephone'),
(540, 270, 2, 'TelÃ©fono'),
(541, 269, 1, 'Web'),
(542, 269, 2, 'Web'),
(543, 279, 1, 'Your password has been successfully reset. Please'),
(544, 279, 2, 'Su contraseÃ±a ha sido restablecida exitosamente. Por favor'),
(545, 278, 1, 'An email has been sent to your email address with the instructions to reset your password.'),
(546, 278, 2, 'Se ha enviado un correo electrÃ³nico a su direcciÃ³n de correo electrÃ³nico con las instrucciones para restablecer su contraseÃ±a.'),
(547, 277, 1, 'Don''t worry we''ll help you to retrive your password. Enter your registered email address below:'),
(548, 277, 2, 'No se preocupe, lo ayudaremos a recuperar su contraseÃ±a. Ingrese su direcciÃ³n de correo electrÃ³nico registrada a continuaciÃ³n:'),
(549, 276, 1, 'New Password'),
(550, 276, 2, 'Nueva contraseÃ±a'),
(551, 275, 1, 'Please set your new password below'),
(552, 275, 2, 'Por favor, configure su nueva contraseÃ±a a continuaciÃ³n'),
(553, 274, 1, 'Reset Password'),
(554, 274, 2, 'Restablecer la contraseÃ±a'),
(555, 273, 1, 'Don''t worry we''ll help you to retrive your password. Enter your registered email address below:'),
(556, 273, 2, 'No se preocupe, lo ayudaremos a recuperar su contraseÃ±a. Ingrese su direcciÃ³n de correo electrÃ³nico registrada a continuaciÃ³n:'),
(557, 272, 1, 'Forgot Password'),
(558, 272, 2, 'Se te olvidÃ³ tu contraseÃ±a'),
(559, 283, 1, 'Borrower Signin'),
(560, 283, 2, 'Firma del prestatario'),
(561, 282, 1, 'EMI Date'),
(562, 282, 2, 'Fecha de EMI'),
(563, 281, 1, 'EMI Amount'),
(564, 281, 2, 'Importe de EMI'),
(565, 280, 1, 'My Payments'),
(566, 280, 2, 'Mis pagos'),
(567, 284, 1, 'Finance Purchase'),
(568, 284, 2, 'Financiar compra'),
(569, 285, 1, 'Merchants'),
(570, 285, 2, 'comerciantes'),
(571, 286, 1, 'Invest'),
(572, 286, 2, 'Invertir');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `smc_backoffice_loan_applications`
--
ALTER TABLE `smc_backoffice_loan_applications`
  ADD CONSTRAINT `smc_backoffice_loan_applications_ibfk_1` FOREIGN KEY (`borrower_id`) REFERENCES `smc_backoffice_borrowers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `smc_backoffice_loan_documents`
--
ALTER TABLE `smc_backoffice_loan_documents`
  ADD CONSTRAINT `smc_backoffice_loan_documents_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `smc_backoffice_loan_applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `smc_backoffice_loan_payments`
--
ALTER TABLE `smc_backoffice_loan_payments`
  ADD CONSTRAINT `smc_backoffice_loan_payments_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `smc_backoffice_loan_applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `smc_dropdown_values_translations`
--
ALTER TABLE `smc_dropdown_values_translations`
  ADD CONSTRAINT `smc_dropdown_values_translations_ibfk_1` FOREIGN KEY (`value_id`) REFERENCES `smc_dropdown_values` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `smc_page_content`
--
ALTER TABLE `smc_page_content`
  ADD CONSTRAINT `smc_page_content_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `smc_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `smc_page_content_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `smc_languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `smc_term_language`
--
ALTER TABLE `smc_term_language`
  ADD CONSTRAINT `smc_term_language_ibfk_1` FOREIGN KEY (`term_id`) REFERENCES `smc_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `smc_term_language_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `smc_languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
