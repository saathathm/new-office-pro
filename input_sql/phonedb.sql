-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2014 at 04:13 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phonedb`
--
CREATE DATABASE IF NOT EXISTS `phonedb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `phonedb`;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
 `id` int(30) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(60) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `suburb` varchar(60) DEFAULT NULL,
  `state` varchar(60) DEFAULT NULL,
  `zip` int(10) unsigned DEFAULT NULL,
  `mobile` int(10) unsigned DEFAULT NULL,
  `mobile2` int(10) unsigned DEFAULT NULL,
  `home_phone` int(10) unsigned DEFAULT NULL,
  `home_phone2` int(10) unsigned DEFAULT NULL,
  `business_phone` int(10) unsigned DEFAULT NULL,
  `alt_phone` int(10) unsigned DEFAULT NULL,
  `business_name` varchar(30) DEFAULT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `business_zip` int(10) unsigned DEFAULT NULL,
  `import` varchar(100) DEFAULT NULL,
  `output` varchar(100) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(50) DEFAULT NULL,
  `comments` text,
  `constultant` varchar(100) DEFAULT NULL,
  `active` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Truncate table before insert `contacts`
--

TRUNCATE TABLE `contacts`;
-- --------------------------------------------------------

--
-- Table structure for table `dups`
--

CREATE TABLE IF NOT EXISTS `dups` (
  `id` int(30) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(60) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `suburb` varchar(60) DEFAULT NULL,
  `state` varchar(60) DEFAULT NULL,
  `zip` int(10) unsigned DEFAULT NULL,
  `mobile` int(10) unsigned DEFAULT NULL,
  `mobile2` int(10) unsigned DEFAULT NULL,
  `home_phone` int(10) unsigned DEFAULT NULL,
  `home_phone2` int(10) unsigned DEFAULT NULL,
  `business_phone` int(10) unsigned DEFAULT NULL,
  `alt_phone` int(10) unsigned DEFAULT NULL,
  `business_name` varchar(30) DEFAULT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `business_zip` int(10) unsigned DEFAULT NULL,
  `import` varchar(100) DEFAULT NULL,
  `output` varchar(100) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(50) DEFAULT NULL,
  `comments` text,
  `constultant` varchar(100) DEFAULT NULL,
  `active` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Truncate table before insert `dups`
--

TRUNCATE TABLE `dups`;
-- --------------------------------------------------------

--
-- Table structure for table `manual_check`
--

CREATE TABLE IF NOT EXISTS `manual_check` (
  `id` int(30) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(60) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `suburb` varchar(60) DEFAULT NULL,
  `state` varchar(60) DEFAULT NULL,
  `zip` int(10) unsigned DEFAULT NULL,
  `mobile` int(10) unsigned DEFAULT NULL,
  `mobile2` int(10) unsigned DEFAULT NULL,
  `home_phone` int(10) unsigned DEFAULT NULL,
  `home_phone2` int(10) unsigned DEFAULT NULL,
  `business_phone` int(10) unsigned DEFAULT NULL,
  `alt_phone` int(10) unsigned DEFAULT NULL,
  `business_name` varchar(30) DEFAULT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `business_zip` int(10) unsigned DEFAULT NULL,
  `import` varchar(100) DEFAULT NULL,
  `output` varchar(100) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(50) DEFAULT NULL,
  `comments` text,
  `constultant` varchar(100) DEFAULT NULL,
  `active` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Truncate table before insert `manual_check`
--

TRUNCATE TABLE `manual_check`;
-- --------------------------------------------------------

--
-- Table structure for table `thrash`
--

CREATE TABLE IF NOT EXISTS `thrash` (
 `id` int(30) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(60) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `suburb` varchar(60) DEFAULT NULL,
  `state` varchar(60) DEFAULT NULL,
  `zip` int(10) unsigned DEFAULT NULL,
  `mobile` int(10) unsigned DEFAULT NULL,
  `mobile2` int(10) unsigned DEFAULT NULL,
  `home_phone` int(10) unsigned DEFAULT NULL,
  `home_phone2` int(10) unsigned DEFAULT NULL,
  `business_phone` int(10) unsigned DEFAULT NULL,
  `alt_phone` int(10) unsigned DEFAULT NULL,
  `business_name` varchar(30) DEFAULT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `business_zip` int(10) unsigned DEFAULT NULL,
  `import` varchar(100) DEFAULT NULL,
  `output` varchar(100) DEFAULT NULL,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(50) DEFAULT NULL,
  `comments` text,
  `constultant` varchar(100) DEFAULT NULL,
  `active` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Truncate table before insert `thrash`
--

TRUNCATE TABLE `thrash`;
-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passphrase` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Truncate table before insert `user`
--

TRUNCATE TABLE `user`;
--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `passphrase`, `enabled`) VALUES
(1, 'admin', 'admin@ex.com', '21232f297a57a5a743894a0e4a801fc3', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
