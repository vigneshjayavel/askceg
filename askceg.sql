-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2012 at 07:08 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `askceg`
--

-- --------------------------------------------------------

--
-- Table structure for table `ANSWER`
--

CREATE TABLE IF NOT EXISTS `ANSWER` (
  `a_id` int(20) NOT NULL AUTO_INCREMENT,
  `a_content` varchar(500) NOT NULL,
  `q_id` int(20) NOT NULL,
  `posted_by` varchar(20) NOT NULL,
  `scope` varchar(20) NOT NULL,
  `vote` int(20) NOT NULL,
  `timestamp` varchar(50) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `ANSWER`
--

INSERT INTO `ANSWER` (`a_id`, `a_content`, `q_id`, `posted_by`, `scope`, `vote`, `timestamp`) VALUES
(1, 'cvcvcbvcv', 1, 'vishnu', '', 0, '10:58 pm 02 Dec-12 '),
(2, 'hjhjgjghjj kghjgj gg gjhghjg', 1, 'vishnu', '', 0, '10:58 pm 02 Dec-12 ');

-- --------------------------------------------------------

--
-- Table structure for table `CATEGORY`
--

CREATE TABLE IF NOT EXISTS `CATEGORY` (
  `category_id` int(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `category_desc` varchar(500) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `CATEGORY`
--

INSERT INTO `CATEGORY` (`category_id`, `category_name`, `category_desc`) VALUES
(1, 'education', '');

-- --------------------------------------------------------

--
-- Table structure for table `DUMMY`
--

CREATE TABLE IF NOT EXISTS `DUMMY` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `DUMMY`
--

INSERT INTO `DUMMY` (`id`, `name`) VALUES
(1, 'vishnu'),
(2, 'anto'),
(1, 'vvv'),
(1, 'vvv'),
(1, 'vvv'),
(1, 'vvv'),
(1, 'vvv');

-- --------------------------------------------------------

--
-- Table structure for table `FOLLOWERS`
--

CREATE TABLE IF NOT EXISTS `FOLLOWERS` (
  `q_id` int(20) NOT NULL,
  `user_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `FOLLOWERS`
--

INSERT INTO `FOLLOWERS` (`q_id`, `user_name`) VALUES
(2, 'vishnu');

-- --------------------------------------------------------

--
-- Table structure for table `GROUPS`
--

CREATE TABLE IF NOT EXISTS `GROUPS` (
  `group_id` int(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `group_desc` text NOT NULL,
  `group_level` int(20) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `GROUPS`
--

INSERT INTO `GROUPS` (`group_id`, `group_name`, `group_desc`, `group_level`) VALUES
(1, 'cse ibatch 2nd year', 'After the iPod, came the iPhone... then the iPad, and now it is our very own iBatch! :D\nThis page is a forum on all discussions relating to iBatch. :)', 0);

-- --------------------------------------------------------

--
-- Table structure for table `QUESTION`
--

CREATE TABLE IF NOT EXISTS `QUESTION` (
  `q_id` int(10) NOT NULL AUTO_INCREMENT,
  `q_content` varchar(500) NOT NULL,
  `topic_id` int(10) NOT NULL,
  `posted_by` varchar(20) NOT NULL,
  `scope` varchar(20) NOT NULL,
  `timestamp` varchar(20) NOT NULL,
  `q_description` text NOT NULL,
  `views` int(20) NOT NULL,
  `followers` int(20) NOT NULL,
  `scope_id` int(20) NOT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `QUESTION`
--

INSERT INTO `QUESTION` (`q_id`, `q_content`, `topic_id`, `posted_by`, `scope`, `timestamp`, `q_description`, `views`, `followers`, `scope_id`) VALUES
(1, 'HFFVHVNVVV', 1, 'vishnu', 'group', '10:47 pm 02 Dec-12 ', 'HNBVNV', 5, 0, 1),
(2, 'asdasd', 1, 'vishnu', 'group', '10:53 pm 02 Dec-12 ', 'asdasdasd', 2, 0, 1),
(3, 'who is obama?', 1, 'vishnu', 'global', '11:12 pm 02 Dec-12 ', '', 0, 0, 0),
(4, 'what is the rate of iphone 5?', 1, 'vishnu', '', '09:08 PM 06-Dec-12', '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `TOPIC`
--

CREATE TABLE IF NOT EXISTS `TOPIC` (
  `topic_id` int(20) NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(50) NOT NULL,
  `topic_desc` text NOT NULL,
  `posted_by` varchar(50) NOT NULL,
  `category_id` int(20) NOT NULL,
  `timestamp` varchar(50) NOT NULL,
  `scope` varchar(20) NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `TOPIC`
--

INSERT INTO `TOPIC` (`topic_id`, `topic_name`, `topic_desc`, `posted_by`, `category_id`, `timestamp`, `scope`) VALUES
(1, 'computer', '', '', 1, '', ''),
(2, 'ibatch', '', '', 0, '', ''),
(3, 'ibatch boys', '', '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `group_id` int(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_level` int(20) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `joined_on` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2011103091 ;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`user_id`, `user_name`, `group_id`, `password`, `user_level`, `email_id`, `joined_on`) VALUES
(2011103089, 'vishnu', 1, '123123', 1, '', ''),
(2011103090, 'Narain Sharma', 1, '123123', 0, 'narainthedude@gmail.com', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
