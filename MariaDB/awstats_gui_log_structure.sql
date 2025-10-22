-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 21, 2025 at 03:35 PM
-- Server version: 10.6.23-MariaDB
-- PHP Version: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `awstats_gui_log`
--
CREATE DATABASE IF NOT EXISTS `awstats_gui_log` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `awstats_gui_log`;

-- --------------------------------------------------------

--
-- Table structure for table `browsers`
--

CREATE TABLE IF NOT EXISTS `browsers` (
                                          `browser_index` int(11) NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `browser` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `bPages` bigint(16) UNSIGNED NOT NULL,
    `pBPercent` varchar(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `bHits` bigint(32) UNSIGNED NOT NULL,
    `hBPercent` varchar(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    PRIMARY KEY (`browser_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=715 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
                                           `download_index` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `iso` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `subFolder` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `isoPlus` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `extension` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `download` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `dHit` bigint(32) UNSIGNED NOT NULL,
    `dHit206` bigint(32) UNSIGNED NOT NULL,
    `dBandwidth` bigint(32) UNSIGNED NOT NULL,
    PRIMARY KEY (`download_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=66903 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `duration`
--

CREATE TABLE IF NOT EXISTS `duration` (
                                          `duration_index` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `zeroSecThirtySec` int(11) UNSIGNED NOT NULL,
    `zeroSecThirtySecPre` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `thirtySecTwoMin` int(11) UNSIGNED NOT NULL,
    `thirtySecTwoMinPre` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `twoMinFiveMin` int(10) UNSIGNED NOT NULL,
    `twoMinFiveMinPre` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `fiveMinFifthteenMin` int(11) UNSIGNED NOT NULL,
    `fiveMinFifthteenMinPre` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `fifthteenMinThirtyMin` int(11) UNSIGNED NOT NULL,
    `fifthteenMinThirtyMinPre` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `thirtyMinOneHour` int(11) UNSIGNED NOT NULL,
    `thirtyMinOneHourPre` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `oneHourPlus` int(11) UNSIGNED NOT NULL,
    `oneHourPlusPre` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    PRIMARY KEY (`duration_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `filetype`
--

CREATE TABLE IF NOT EXISTS `filetype` (
                                          `fileType_index` int(11) NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `fileType` varchar(12) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `description` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `fTHits` bigint(32) UNSIGNED NOT NULL,
    `hFTPercent` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `fTBandwidth` bigint(32) UNSIGNED NOT NULL,
    `bFTPercent` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    PRIMARY KEY (`fileType_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1809 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `html`
--

CREATE TABLE IF NOT EXISTS `html` (
                                      `file_index` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `iso` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `subFolder` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `isoPlus` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `extension` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `html` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `view` int(11) UNSIGNED NOT NULL,
    PRIMARY KEY (`file_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=60866 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ip`
--

CREATE TABLE IF NOT EXISTS `ip` (
                                    `ip_index` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `ip` varchar(18) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `ipPages` bigint(16) UNSIGNED NOT NULL,
    `ipHits` bigint(32) UNSIGNED NOT NULL,
    `ipBandwidth` bigint(32) UNSIGNED NOT NULL,
    `ipLastVisit` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    PRIMARY KEY (`ip_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=71069 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locales`
--

CREATE TABLE IF NOT EXISTS `locales` (
                                         `locales_index` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `locales` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `cc` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
    `lPages` bigint(16) UNSIGNED NOT NULL,
    `lHits` bigint(32) UNSIGNED NOT NULL,
    `lBandwidth` bigint(32) UNSIGNED NOT NULL,
    PRIMARY KEY (`locales_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=11225 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `os`
--

CREATE TABLE IF NOT EXISTS `os` (
                                    `os_index` int(11) NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `os` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `osPages` bigint(16) UNSIGNED NOT NULL,
    `osPercentOne` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    `osHits` bigint(32) UNSIGNED NOT NULL,
    `osPercentTwo` varchar(7) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
    PRIMARY KEY (`os_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=693 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
                                          `vistor_index` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `month` tinyint(2) UNSIGNED NOT NULL,
    `year` smallint(4) UNSIGNED NOT NULL,
    `uniqueVisitors` int(11) UNSIGNED NOT NULL,
    `numberOfVisits` int(11) UNSIGNED NOT NULL,
    `pages` bigint(16) UNSIGNED NOT NULL,
    `hits` bigint(32) UNSIGNED NOT NULL,
    `bandwidth` bigint(32) UNSIGNED NOT NULL,
    PRIMARY KEY (`vistor_index`),
    KEY `monthYear` (`month`,`year`)
    ) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
