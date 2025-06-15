-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2025 at 09:11 PM
-- Server version: 10.6.22-MariaDB
-- PHP Version: 8.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scripture`
--
CREATE DATABASE IF NOT EXISTS `scripture` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `scripture`;

-- --------------------------------------------------------

--
-- Table structure for table `add_resource`
--

DROP TABLE IF EXISTS `add_resource`;
CREATE TABLE IF NOT EXISTS `add_resource` (
  `add_index` int(11) NOT NULL AUTO_INCREMENT,
  `iso` varchar(3) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `rod` varchar(5) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '00000',
  `var` varchar(1) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `idx` int(11) NOT NULL,
  `type` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `url` varchar(150) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `projectName` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `projectDescription` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `subfolder` varchar(8) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `organization` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `accept` tinyint(1) NOT NULL DEFAULT 0,
  `reject` tinyint(1) NOT NULL DEFAULT 0,
  `wait` tinyint(1) NOT NULL DEFAULT 0,
  `toAdd` tinyint(1) NOT NULL DEFAULT 1,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`add_index`),
  KEY `iso` (`iso`),
  KEY `rod` (`rod`),
  KEY `var` (`var`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alt_lang_names`
--

DROP TABLE IF EXISTS `alt_lang_names`;
CREATE TABLE IF NOT EXISTS `alt_lang_names` (
  `Alt_Lang_Name_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `alt_lang_name` varchar(55) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`Alt_Lang_Name_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buy`
--

DROP TABLE IF EXISTS `buy`;
CREATE TABLE IF NOT EXISTS `buy` (
  `Buy_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `organization` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `buy_what` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `URL` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`Buy_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `CellPhone`
--

DROP TABLE IF EXISTS `CellPhone`;
CREATE TABLE IF NOT EXISTS `CellPhone` (
  `CellPhone_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `Cell_Phone_Title` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Cell_Phone_File` varchar(150) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `optional` varchar(160) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`CellPhone_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `Country_index` int(11) NOT NULL AUTO_INCREMENT,
  `English` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Spanish` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Portuguese` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `French` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Dutch` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `German` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Chinese` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Korean` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Russian` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Arabic` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ISO_Country` varchar(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`Country_index`),
  KEY `ISO_Country` (`ISO_Country`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dialects`
--

DROP TABLE IF EXISTS `dialects`;
CREATE TABLE IF NOT EXISTS `dialects` (
  `dialects_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ROD_Code` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ISO_ROD_index` int(11) NOT NULL,
  `dialect` varchar(50) NOT NULL,
  `LN_English` varchar(50) NOT NULL,
  `multipleCountries` tinyint(1) NOT NULL,
  `countryCodes` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`dialects_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eBible_list`
--

DROP TABLE IF EXISTS `eBible_list`;
CREATE TABLE IF NOT EXISTS `eBible_list` (
  `ISO_ROD_index` int(11) NOT NULL,
  `languageCode` varchar(3) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `translationId` varchar(14) NOT NULL,
  `languageName` varchar(42) DEFAULT NULL,
  `languageNameInEnglish` varchar(42) DEFAULT NULL,
  `dialect` varchar(28) DEFAULT NULL,
  `homeDomain` varchar(20) DEFAULT NULL,
  `title` varchar(142) DEFAULT NULL,
  `description` varchar(313) DEFAULT NULL,
  `Redistributable` varchar(5) DEFAULT NULL,
  `Copyright` varchar(150) DEFAULT NULL,
  `UpdateDate` varchar(10) DEFAULT NULL,
  `publicationURL` varchar(34) DEFAULT NULL,
  `OTbooks` int(2) DEFAULT NULL,
  `OTchapters` int(3) DEFAULT NULL,
  `OTverses` int(5) DEFAULT NULL,
  `NTbooks` int(2) DEFAULT NULL,
  `NTchapters` int(3) DEFAULT NULL,
  `NTverses` int(4) DEFAULT NULL,
  `DCbooks` int(2) DEFAULT NULL,
  `DCchapters` int(3) DEFAULT NULL,
  `DCverses` int(4) DEFAULT NULL,
  `FCBHID` varchar(14) DEFAULT NULL,
  `Certified` varchar(5) DEFAULT NULL,
  `inScript` varchar(100) DEFAULT NULL,
  `swordName` varchar(17) DEFAULT NULL,
  `rodCode` varchar(5) NOT NULL DEFAULT '00000',
  `textDirection` varchar(3) DEFAULT NULL,
  `downloadable` varchar(5) DEFAULT NULL,
  `font` varchar(18) DEFAULT NULL,
  `shortTitle` varchar(200) DEFAULT NULL,
  `PODISBN` varchar(17) DEFAULT NULL,
  `script` varchar(48) DEFAULT NULL,
  `sourceDate` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`translationId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GotoInterest`
--

DROP TABLE IF EXISTS `GotoInterest`;
CREATE TABLE IF NOT EXISTS `GotoInterest` (
  `GotoInterest_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO_ROD_index` int(11) NOT NULL,
  `Goto_ISO_ROD_index` int(11) NOT NULL,
  `Goto_ISO` varchar(3) NOT NULL,
  `Goto_ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Goto_Variant_Code` varchar(1) DEFAULT NULL,
  `Percentage` varchar(10) NOT NULL,
  PRIMARY KEY (`GotoInterest_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interest`
--

DROP TABLE IF EXISTS `interest`;
CREATE TABLE IF NOT EXISTS `interest` (
  `Interest_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) DEFAULT NULL,
  `NoLang` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`Interest_index`),
  UNIQUE KEY `ISO_ROD_index` (`ISO_ROD_index`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `isop`
--

DROP TABLE IF EXISTS `isop`;
CREATE TABLE IF NOT EXISTS `isop` (
  `isop_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `isop` varchar(7) NOT NULL,
  PRIMARY KEY (`isop_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ISO_countries`
--

DROP TABLE IF EXISTS `ISO_countries`;
CREATE TABLE IF NOT EXISTS `ISO_countries` (
  `ISO_Countries_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `ISO_countries` varchar(2) NOT NULL,
  PRIMARY KEY (`ISO_Countries_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ISO_Lang_Countries`
--

DROP TABLE IF EXISTS `ISO_Lang_Countries`;
CREATE TABLE IF NOT EXISTS `ISO_Lang_Countries` (
  `ISO` varchar(3) NOT NULL,
  `ISO_Country` varchar(2) NOT NULL,
  `LangNameType` varchar(2) NOT NULL,
  `LanguageName` varchar(75) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  KEY `ISO` (`ISO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leafletjs_maps`
--

DROP TABLE IF EXISTS `leafletjs_maps`;
CREATE TABLE IF NOT EXISTS `leafletjs_maps` (
  `index_leafletjs` int(11) NOT NULL AUTO_INCREMENT,
  `bookkeeping` varchar(5) DEFAULT NULL,
  `category` varchar(19) DEFAULT NULL,
  `child_dialect_count` int(2) DEFAULT NULL,
  `child_family_count` int(1) DEFAULT NULL,
  `child_language_count` int(1) DEFAULT NULL,
  `description` varchar(10) DEFAULT NULL,
  `family_pk` int(3) DEFAULT NULL,
  `father_pk` int(5) DEFAULT NULL,
  `hid` varchar(3) DEFAULT NULL,
  `rod` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '00000',
  `id` varchar(8) DEFAULT NULL,
  `latitude` text DEFAULT NULL,
  `level` varchar(8) DEFAULT NULL,
  `longitude` text DEFAULT NULL,
  `macroareas` varchar(50) DEFAULT NULL,
  `markup_description` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `newick` varchar(2000) DEFAULT NULL,
  `pk` int(5) DEFAULT NULL,
  `country_code` varchar(2) NOT NULL,
  `country` varchar(50) NOT NULL,
  PRIMARY KEY (`index_leafletjs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `Links_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `company` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '',
  `company_title` varchar(140) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `URL` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `buy` tinyint(1) NOT NULL DEFAULT 0,
  `map` tinyint(1) NOT NULL DEFAULT 0,
  `BibleIs` tinyint(1) NOT NULL DEFAULT 0,
  `BibleIsGospelFilm` tinyint(1) NOT NULL DEFAULT 0,
  `YouVersion` tinyint(1) NOT NULL DEFAULT 0,
  `Bibles_org` tinyint(1) NOT NULL DEFAULT 0,
  `GooglePlay` tinyint(1) NOT NULL DEFAULT 0,
  `GRN` tinyint(1) NOT NULL DEFAULT 0,
  `email` tinyint(1) NOT NULL DEFAULT 0,
  `Kalaam` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Links_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ln`
--

DROP TABLE IF EXISTS `ln`;
CREATE TABLE IF NOT EXISTS `ln` (
  `LN_English_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_English` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_English_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_Arabic`
--

DROP TABLE IF EXISTS `LN_Arabic`;
CREATE TABLE IF NOT EXISTS `LN_Arabic` (
  `LN_Arabic_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ROD_Code` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Variant_Code` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_Arabic` varchar(50) NOT NULL,
  PRIMARY KEY (`LN_Arabic_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_Chinese`
--

DROP TABLE IF EXISTS `LN_Chinese`;
CREATE TABLE IF NOT EXISTS `LN_Chinese` (
  `LN_Chinese_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ROD_Code` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Variant_Code` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_Chinese` varchar(50) NOT NULL,
  PRIMARY KEY (`LN_Chinese_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_Dutch`
--

DROP TABLE IF EXISTS `LN_Dutch`;
CREATE TABLE IF NOT EXISTS `LN_Dutch` (
  `LN_Dutch_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_Dutch` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_Dutch_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_English`
--

DROP TABLE IF EXISTS `LN_English`;
CREATE TABLE IF NOT EXISTS `LN_English` (
  `LN_English_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_English` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_English_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_French`
--

DROP TABLE IF EXISTS `LN_French`;
CREATE TABLE IF NOT EXISTS `LN_French` (
  `LN_French_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_French` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_French_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_German`
--

DROP TABLE IF EXISTS `LN_German`;
CREATE TABLE IF NOT EXISTS `LN_German` (
  `LN_German_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_German` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_German_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_Korean`
--

DROP TABLE IF EXISTS `LN_Korean`;
CREATE TABLE IF NOT EXISTS `LN_Korean` (
  `LN_Korea_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ROD_Code` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Variant_Code` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_Korean` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_Korea_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_Portuguese`
--

DROP TABLE IF EXISTS `LN_Portuguese`;
CREATE TABLE IF NOT EXISTS `LN_Portuguese` (
  `LN_Portuguese_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_Portuguese` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_Portuguese_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_Russian`
--

DROP TABLE IF EXISTS `LN_Russian`;
CREATE TABLE IF NOT EXISTS `LN_Russian` (
  `LN_Russian_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) NOT NULL,
  `LN_Russian` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_Russian_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `LN_Spanish`
--

DROP TABLE IF EXISTS `LN_Spanish`;
CREATE TABLE IF NOT EXISTS `LN_Spanish` (
  `LN_Spanish_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `LN_Spanish` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`LN_Spanish_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nav_ln`
--

DROP TABLE IF EXISTS `nav_ln`;
CREATE TABLE IF NOT EXISTS `nav_ln` (
  `nav_ln_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO_ROD_index` int(11) NOT NULL,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `Def_LN` tinyint(3) NOT NULL DEFAULT 2,
  `LN_English` tinyint(1) NOT NULL DEFAULT 0,
  `LN_Spanish` tinyint(1) NOT NULL DEFAULT 0,
  `LN_Portuguese` tinyint(1) NOT NULL DEFAULT 0,
  `LN_French` tinyint(1) NOT NULL DEFAULT 0,
  `LN_Dutch` tinyint(1) NOT NULL DEFAULT 0,
  `LN_German` tinyint(1) NOT NULL DEFAULT 0,
  `LN_Chinese` tinyint(1) NOT NULL DEFAULT 0,
  `LN_Korean` tinyint(1) NOT NULL DEFAULT 0,
  `LN_Russian` tinyint(1) NOT NULL DEFAULT 0,
  `LN_Arabic` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`nav_ln_index`),
  UNIQUE KEY `ISO_ROD_index` (`ISO_ROD_index`),
  UNIQUE KEY `ISO` (`ISO`,`ROD_Code`,`Variant_Code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `NT_Audio_Media`
--

DROP TABLE IF EXISTS `NT_Audio_Media`;
CREATE TABLE IF NOT EXISTS `NT_Audio_Media` (
  `NT_Audio_Media_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `NT_Audio_Book` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `NT_Audio_Filename` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `NT_Audio_Chapter` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`NT_Audio_Media_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `NT_PDF_Media`
--

DROP TABLE IF EXISTS `NT_PDF_Media`;
CREATE TABLE IF NOT EXISTS `NT_PDF_Media` (
  `NT_PDF_Media_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `NT_PDF` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `NT_PDF_Filename` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`NT_PDF_Media_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_titles`
--

DROP TABLE IF EXISTS `other_titles`;
CREATE TABLE IF NOT EXISTS `other_titles` (
  `Other_Titles_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `other` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `other_title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `other_PDF` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `other_audio` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `download_video` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`Other_Titles_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OT_Audio_Media`
--

DROP TABLE IF EXISTS `OT_Audio_Media`;
CREATE TABLE IF NOT EXISTS `OT_Audio_Media` (
  `OT_Audio_Media_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `OT_Audio_Book` varchar(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `OT_Audio_Filename` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `OT_Audio_Chapter` varchar(3) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`OT_Audio_Media_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `OT_PDF_Media`
--

DROP TABLE IF EXISTS `OT_PDF_Media`;
CREATE TABLE IF NOT EXISTS `OT_PDF_Media` (
  `OT_PDF_Media_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `OT_PDF` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `OT_PDF_Filename` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`OT_PDF_Media_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PlaylistAudio`
--

DROP TABLE IF EXISTS `PlaylistAudio`;
CREATE TABLE IF NOT EXISTS `PlaylistAudio` (
  `PlaylistAudio_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `PlaylistAudioTitle` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `PlaylistAudioFilename` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`PlaylistAudio_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PlaylistVideo`
--

DROP TABLE IF EXISTS `PlaylistVideo`;
CREATE TABLE IF NOT EXISTS `PlaylistVideo` (
  `PlaylistVideo_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `PlaylistVideoTitle` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `PlaylistVideoFilename` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `PlaylistVideoDownload` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`PlaylistVideo_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ROD_Dialect`
--

DROP TABLE IF EXISTS `ROD_Dialect`;
CREATE TABLE IF NOT EXISTS `ROD_Dialect` (
  `ROD_Dialect_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `ISO_country` varchar(2) NOT NULL,
  `language_name` varchar(60) NOT NULL,
  `dialect_name` varchar(60) NOT NULL,
  `location` varchar(60) NOT NULL,
  PRIMARY KEY (`ROD_Dialect_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SAB`
--

DROP TABLE IF EXISTS `SAB`;
CREATE TABLE IF NOT EXISTS `SAB` (
  `SAB_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `Book_Chapter_HTML` varchar(30) NOT NULL,
  `SAB_Book` smallint(3) NOT NULL,
  `SAB_Chapter` smallint(3) NOT NULL,
  `SAB_Audio` tinyint(1) NOT NULL DEFAULT 0,
  `SAB_number` int(11) NOT NULL,
  `SABDate` datetime NOT NULL DEFAULT current_timestamp(),
  `SABSize` int(11) NOT NULL DEFAULT 0,
  `deleteSAB` tinyint(1) NOT NULL DEFAULT 0,
  UNIQUE KEY `SAB_index` (`SAB_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SAB_scriptoria`
--

DROP TABLE IF EXISTS `SAB_scriptoria`;
CREATE TABLE IF NOT EXISTS `SAB_scriptoria` (
  `SAB_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `subfolder` varchar(20) NOT NULL,
  `description` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `pre_scriptoria` varchar(20) NOT NULL,
  `SAB_number` int(11) NOT NULL,
  PRIMARY KEY (`SAB_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Scripture_and_or_Bible`
--

DROP TABLE IF EXISTS `Scripture_and_or_Bible`;
CREATE TABLE IF NOT EXISTS `Scripture_and_or_Bible` (
  `Bible_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `Item` varchar(1) NOT NULL,
  `Scripture_Bible_Filename` varchar(100) NOT NULL,
  `description` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`Bible_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scripture_main`
--

DROP TABLE IF EXISTS `scripture_main`;
CREATE TABLE IF NOT EXISTS `scripture_main` (
  `ISO_ROD_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `OT_PDF` tinyint(1) NOT NULL DEFAULT 0,
  `NT_PDF` tinyint(1) NOT NULL DEFAULT 0,
  `FCBH` tinyint(1) NOT NULL DEFAULT 0,
  `OT_Audio` tinyint(1) NOT NULL DEFAULT 0,
  `NT_Audio` tinyint(1) NOT NULL DEFAULT 0,
  `links` tinyint(1) NOT NULL DEFAULT 0,
  `other_titles` tinyint(1) NOT NULL DEFAULT 0,
  `watch` tinyint(1) NOT NULL DEFAULT 0,
  `buy` tinyint(1) NOT NULL DEFAULT 0,
  `study` tinyint(1) NOT NULL DEFAULT 0,
  `viewer` tinyint(1) NOT NULL DEFAULT 0,
  `CellPhone` tinyint(1) NOT NULL DEFAULT 0,
  `AddNo` tinyint(1) NOT NULL DEFAULT 0,
  `AddTheBibleIn` tinyint(1) NOT NULL DEFAULT 0,
  `AddTheScriptureIn` tinyint(1) NOT NULL DEFAULT 0,
  `BibleIs` tinyint(1) NOT NULL DEFAULT 0,
  `BibleIsGospelFilm` tinyint(1) NOT NULL DEFAULT 0,
  `YouVersion` tinyint(1) NOT NULL DEFAULT 0,
  `Bibles_org` tinyint(1) NOT NULL DEFAULT 0,
  `PlaylistAudio` tinyint(1) NOT NULL DEFAULT 0,
  `PlaylistVideo` tinyint(1) NOT NULL DEFAULT 0,
  `SAB` tinyint(1) NOT NULL DEFAULT 0,
  `eBible` tinyint(1) NOT NULL DEFAULT 0,
  `SILlink` tinyint(1) NOT NULL DEFAULT 1,
  `GRN` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ISO`,`ROD_Code`,`Variant_Code`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `study`
--

DROP TABLE IF EXISTS `study`;
CREATE TABLE IF NOT EXISTS `study` (
  `Study_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `ScriptureDescription` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Testament` varchar(30) NOT NULL DEFAULT 'New Testament',
  `alphabet` varchar(30) NOT NULL DEFAULT 'Standand alphabet',
  `ScriptureURL` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `statement` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `othersiteDescription` varchar(60) NOT NULL,
  `othersiteURL` varchar(100) NOT NULL,
  `DownloadFromWebsite` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Study_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
CREATE TABLE IF NOT EXISTS `translations` (
  `translation_code` varchar(3) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `nav_fileName` varchar(30) DEFAULT NULL,
  `language_code` varchar(2) DEFAULT NULL,
  `google_keboard` varchar(10) DEFAULT NULL,
  `language_direction` varchar(3) DEFAULT NULL,
  `ln_number` int(4) DEFAULT NULL,
  `ln_abbreviation` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`translation_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_arb`
--

DROP TABLE IF EXISTS `translations_arb`;
CREATE TABLE IF NOT EXISTS `translations_arb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_cmn`
--

DROP TABLE IF EXISTS `translations_cmn`;
CREATE TABLE IF NOT EXISTS `translations_cmn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_deu`
--

DROP TABLE IF EXISTS `translations_deu`;
CREATE TABLE IF NOT EXISTS `translations_deu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_eng`
--

DROP TABLE IF EXISTS `translations_eng`;
CREATE TABLE IF NOT EXISTS `translations_eng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  `active` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_fra`
--

DROP TABLE IF EXISTS `translations_fra`;
CREATE TABLE IF NOT EXISTS `translations_fra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_kor`
--

DROP TABLE IF EXISTS `translations_kor`;
CREATE TABLE IF NOT EXISTS `translations_kor` (
  `id` int(11) NOT NULL,
  `phrase` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_nld`
--

DROP TABLE IF EXISTS `translations_nld`;
CREATE TABLE IF NOT EXISTS `translations_nld` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_por`
--

DROP TABLE IF EXISTS `translations_por`;
CREATE TABLE IF NOT EXISTS `translations_por` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_rus`
--

DROP TABLE IF EXISTS `translations_rus`;
CREATE TABLE IF NOT EXISTS `translations_rus` (
  `id` int(3) NOT NULL,
  `phrase` varchar(108) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations_spa`
--

DROP TABLE IF EXISTS `translations_spa`;
CREATE TABLE IF NOT EXISTS `translations_spa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Variants`
--

DROP TABLE IF EXISTS `Variants`;
CREATE TABLE IF NOT EXISTS `Variants` (
  `Variant_index` int(11) NOT NULL AUTO_INCREMENT,
  `Variant_Code` varchar(1) NOT NULL,
  `Variant_Description` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Eng` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Spa` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Por` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Fre` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Dut` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Ger` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Chi` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Kor` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Rus` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `Variant_Ara` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`Variant_index`),
  UNIQUE KEY `Variant_Code` (`Variant_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `viewer`
--

DROP TABLE IF EXISTS `viewer`;
CREATE TABLE IF NOT EXISTS `viewer` (
  `viewer_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL DEFAULT '00000',
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) NOT NULL,
  `viewer_ROD_Variant` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`viewer_index`),
  KEY `ISO` (`ISO`,`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `watch`
--

DROP TABLE IF EXISTS `watch`;
CREATE TABLE IF NOT EXISTS `watch` (
  `Watch_index` int(11) NOT NULL AUTO_INCREMENT,
  `ISO` varchar(3) NOT NULL,
  `ROD_Code` varchar(5) NOT NULL,
  `Variant_Code` varchar(1) NOT NULL,
  `ISO_ROD_index` int(11) DEFAULT NULL,
  `organization` varchar(70) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `watch_what` varchar(140) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `URL` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `JesusFilm` tinyint(1) NOT NULL DEFAULT 0,
  `YouTube` tinyint(1) NOT NULL DEFAULT 0,
  `JesusFilm_id` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`Watch_index`),
  KEY `ISO_ROD_index` (`ISO_ROD_index`),
  KEY `ISO-ROD_Code` (`ROD_Code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
