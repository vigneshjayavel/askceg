-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2012 at 07:55 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `askceg1`
--

-- --------------------------------------------------------

--
-- Table structure for table `ANSWER`
--

CREATE TABLE IF NOT EXISTS `ANSWER` (
  `a_id` int(20) NOT NULL AUTO_INCREMENT,
  `a_content` varchar(500) NOT NULL,
  `q_id` int(20) NOT NULL,
  `posted_by` int(20) NOT NULL,
  `scope` varchar(20) NOT NULL,
  `vote` int(20) NOT NULL,
  `timestamp` varchar(50) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `ANSWER`
--

INSERT INTO `ANSWER` (`a_id`, `a_content`, `q_id`, `posted_by`, `scope`, `vote`, `timestamp`) VALUES
(1, 'cvcvcbvcv', 1, 2011103089, '', 0, '10:58 pm 02 Dec-12 '),
(2, 'hjhjgjghjj kghjgj gg gjhghjg', 1, 2011103089, '', 0, '10:58 pm 02 Dec-12 '),
(3, 'gdgdgdgdg!!!', 5, 2011103089, '', 0, '12:32 PM 11-Dec-12'),
(4, 'poda naaye\n\n', 1, 2011103089, '', 0, '07:47 PM 12-Dec-12'),
(5, 'dffdf', 1, 2011103089, '', 0, '11:20 AM 15-Dec-12'),
(6, 'fddgdg', 1, 2011103089, '', 0, '11:37 AM 15-Dec-12'),
(7, 'dgdgdgdgggdgd', 1, 2011103089, '', 0, '11:38 AM 15-Dec-12'),
(8, 'sgfsfsff', 3, 2011103090, '', 0, '11:53 AM 15-Dec-12'),
(9, 'sgxxsdgdwgd', 3, 2011103090, '', 0, '11:54 AM 15-Dec-12'),
(10, 'hhhfghghgh', 3, 2011103090, '', 0, '11:54 AM 15-Dec-12'),
(11, 'This is a pretty comprehensive summary of the startups by CEG alumni, although, could be a bit outdated. CEG Alumni Entrepreneur Network - 3rd slide.', 8, 2011103593, '', 0, '03:37 PM 15-Dec-12'),
(14, 'enaku purinjichu purinjichu purinjichu :P', 4, 2011103085, '', 0, '02:33 PM 17-Dec-12'),
(13, 'IIT', 8, 2011103089, '', 0, '10:50 PM 16-Dec-12'),
(15, 'Supercool :D', 10, 2011103090, '', 0, '10:54 PM 20-Dec-12'),
(16, 'ssfsfs', 3, 2011103089, '', 0, '04:57 PM 21-Dec-12'),
(17, 'ssfsfsd', 3, 2011103089, '', 0, '04:58 PM 21-Dec-12'),
(18, 'ssfsfsddfdf', 3, 2011103089, '', 0, '04:59 PM 21-Dec-12'),
(19, 'sfsfff\n', 3, 2011103089, '', 0, '05:00 PM 21-Dec-12'),
(20, 'donno', 4, 2011103089, '', 0, '07:48 PM 21-Dec-12'),
(21, 'dgdgd', 4, 2011103089, '', 0, '09:39 PM 21-Dec-12'),
(22, 'dgdgg\n', 2, 2011103089, '', 0, '10:08 PM 21-Dec-12');

-- --------------------------------------------------------

--
-- Table structure for table `CATEGORY`
--

CREATE TABLE IF NOT EXISTS `CATEGORY` (
  `category_id` int(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `category_desc` varchar(500) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `CATEGORY`
--

INSERT INTO `CATEGORY` (`category_id`, `category_name`, `category_desc`) VALUES
(1, 'education', ''),
(2, 'Entertainment', 'all about Entertainment'),
(3, 'Sports', ''),
(4, 'Technology', ''),
(5, 'Miscellaneous', '');

-- --------------------------------------------------------

--
-- Table structure for table `dummy`
--

CREATE TABLE IF NOT EXISTS `dummy` (
  `id` int(50) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dummy`
--

INSERT INTO `dummy` (`id`, `name`) VALUES
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
  `user_id` int(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `FOLLOWERS`
--

INSERT INTO `FOLLOWERS` (`q_id`, `user_id`) VALUES
(1, 2011103090),
(2, 2011103051),
(2, 2011103090),
(1, 2011103089),
(2, 2011103089),
(1, 2011103089),
(15, 2011103089),
(4, 2011103085),
(11, 2011103090),
(10, 2011103090);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `GROUPS`
--

INSERT INTO `GROUPS` (`group_id`, `group_name`, `group_desc`, `group_level`) VALUES
(1, 'cse ibatch 2nd year', 'After the iPod, came the iPhone... then the iPad, and now it is our very own iBatch! :D\nThis page is a forum on all discussions relating to iBatch. :)', 0),
(2, 'CSE h batch 2nd year', 'dsadwsadfsada\r\nsasadsafdasd\r\nsdfasdsadad', 0);

-- --------------------------------------------------------

--
-- Table structure for table `QUESTION`
--

CREATE TABLE IF NOT EXISTS `QUESTION` (
  `q_id` int(10) NOT NULL AUTO_INCREMENT,
  `q_content` varchar(500) NOT NULL,
  `topic_id` int(10) NOT NULL,
  `posted_by` int(20) NOT NULL,
  `scope` varchar(20) NOT NULL,
  `timestamp` varchar(20) NOT NULL,
  `q_description` text NOT NULL,
  `views` int(20) NOT NULL,
  `followers` int(20) NOT NULL,
  `scope_id` int(20) NOT NULL,
  `url` varchar(400) NOT NULL,
  `anonymous` int(20) NOT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `QUESTION`
--

INSERT INTO `QUESTION` (`q_id`, `q_content`, `topic_id`, `posted_by`, `scope`, `timestamp`, `q_description`, `views`, `followers`, `scope_id`, `url`, `anonymous`) VALUES
(2, 'asdasd', 1, 2011103090, 'group', '10:53 pm 02 Dec-12 ', 'asdasdasd', 4, 0, 1, 'asdasd', 0),
(3, 'who is obama?', 1, 2011103090, 'global', '11:12 pm 02 Dec-12 ', '', 27, 0, 0, 'who-is-obama', 0),
(4, 'what is the rate of iphone 5?', 1, 2011103090, 'year', '09:08 PM 06-Dec-12', '', 4, 0, 0, 'what-is-the-rate-of-iphone-5', 0),
(5, 'GJHGJ??', 1, 2011103090, '', '12:32 PM 11-Dec-12', 'DDDCD', 3, 0, 0, 'GJHGJ', 0),
(6, 'What is Askceg?', 1, 2011103090, 'global', '12:36 PM 11-Dec-12', '', 0, 0, 0, 'What-is-Askceg', 0),
(7, 'sdsdsdd', 1, 2011103090, '', '11:20 AM 15-Dec-12', '', 0, 0, 0, 'sdsdsdd', 0),
(9, 'When is college reopening??', 1, 2011103090, '', '12:04 PM 17-Dec-12', 'I dont want it to reopen at all!!! :P', 3, 0, 0, 'When-is-college-reopening', 0),
(10, 'How cool is AskCEG? :D', 1, 2011103053, '', '09:57 AM 18-Dec-12', '', 5, 0, 0, 'How-cool-is-AskCEG-D', 0),
(11, 'ghikjfkjrf', 2, 2011103090, '', '05:18 PM 18-Dec-12', '', 0, 0, 0, 'ghikjfkjrf', 0),
(12, 'hey boys ?', 2, 2011103090, '', '05:19 PM 18-Dec-12', '', 0, 0, 0, 'hey-boys', 0),
(14, 'who is obama?', 1, 2011103089, '', '11:03 PM 21-Dec-12', '', 0, 0, 0, 'who-is-obama-1356110311', 0),
(15, 'who is obama?', 1, 2011103089, '', '11:05 PM 21-Dec-12', '', 0, 0, 0, 'who-is-obama-1356110408', 0),
(16, 'how u doing?', 3, 2011103089, '', '12:29 AM 23-Dec-12', '', 0, 0, 0, 'how-u-doing', 0),
(17, 'when is k13?', 5, 2011103089, '', '12:32 AM 23-Dec-12', '', 0, 0, 0, 'when-is-k13', 0);

-- --------------------------------------------------------

--
-- Table structure for table `REQUEST_USER`
--

CREATE TABLE IF NOT EXISTS `REQUEST_USER` (
  `user_id` int(20) NOT NULL,
  `request_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `group_id` int(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_level` int(20) NOT NULL DEFAULT '0',
  `email_id` varchar(20) NOT NULL,
  `user_year` int(11) NOT NULL,
  `user_degree` varchar(20) NOT NULL,
  `user_course` varchar(20) NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `REQUEST_USER`
--

INSERT INTO `REQUEST_USER` (`user_id`, `request_id`, `user_name`, `group_id`, `password`, `user_level`, `email_id`, `user_year`, `user_degree`, `user_course`) VALUES
(0, 33, 'hjkhhk', 1, '', 0, '', 2, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `TOPIC`
--

CREATE TABLE IF NOT EXISTS `TOPIC` (
  `topic_id` int(20) NOT NULL AUTO_INCREMENT,
  `topic_name` varchar(50) NOT NULL,
  `topic_desc` text NOT NULL,
  `posted_by` int(50) NOT NULL,
  `category_id` int(20) NOT NULL,
  `timestamp` varchar(50) NOT NULL,
  `topic_url` varchar(200) NOT NULL,
  PRIMARY KEY (`topic_id`),
  UNIQUE KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `TOPIC`
--

INSERT INTO `TOPIC` (`topic_id`, `topic_name`, `topic_desc`, `posted_by`, `category_id`, `timestamp`, `topic_url`) VALUES
(1, 'computer', '0', 2011103090, 1, '12-10-12', 'computer'),
(2, 'ibatch', '0', 0, 5, '', 'ibatch'),
(3, 'ibatch boys', '', 0, 1, '', 'ibatch-boys'),
(4, 'Movies', 'Contains all questions about movies!', 2011103090, 2, '', 'Movies'),
(5, 'battle of brains', '', 0, 3, '', 'battle-of-brains');

-- --------------------------------------------------------

--
-- Table structure for table `TOPIC_DESC_HISTORY`
--

CREATE TABLE IF NOT EXISTS `TOPIC_DESC_HISTORY` (
  `topic_id` int(20) NOT NULL,
  `topic_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TOPIC_FOLLOWERS`
--

CREATE TABLE IF NOT EXISTS `TOPIC_FOLLOWERS` (
  `topic_id` int(20) NOT NULL,
  `follower` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TOPIC_FOLLOWERS`
--

INSERT INTO `TOPIC_FOLLOWERS` (`topic_id`, `follower`) VALUES
(1, 2011103085),
(1, 2011103090),
(1, 2011103089),
(2, 2011103089),
(3, 2011103089);

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
  `user_year` int(20) NOT NULL,
  `user_degree` varchar(20) NOT NULL,
  `user_course` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2011103595 ;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`user_id`, `user_name`, `group_id`, `password`, `user_level`, `email_id`, `joined_on`, `user_year`, `user_degree`, `user_course`) VALUES
(2011103089, 'vishnu', 1, '123123', 1, '', '', 2, '', ''),
(2011103090, 'Narain Sharma', 1, '123123', 1, 'narainthedude@gmail.com', '', 2, 'BE', 'CSE'),
(2011103593, 'Anirudh', 1, '123123', 0, '', '', 0, 'BE', 'CSE'),
(2011103087, 'swetha', 1, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103085, 'adi', 1, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103038, 'Jayashruthi', 1, '123123', 0, '', '', 0, 'BE', 'CSE'),
(2011103051, 'Gopinath', 2, '123123', 1, '', '', 2, 'BE', 'CSE'),
(2011103054, 'Jai Vasanth', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103053, 'Hema Varman', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103050, 'Anudeep Ballu', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103052, 'Harinikesh Suresh', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103055, 'Jayasri ', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103060, 'Vinay Srinivas', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103058, 'Prashanth Anantharam', 2, '123123', 0, '', '', 2, 'BE', 'CSE');

-- --------------------------------------------------------

--
-- Table structure for table `USER_FOLLOWERS`
--

CREATE TABLE IF NOT EXISTS `USER_FOLLOWERS` (
  `user_id` int(20) NOT NULL,
  `follower` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `USER_HISTORY_LOG`
--

CREATE TABLE IF NOT EXISTS `USER_HISTORY_LOG` (
  `user_id` int(20) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_course` varchar(20) NOT NULL,
  `user_degree` varchar(20) NOT NULL,
  `user_year` int(20) NOT NULL,
  `group_id` int(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`,`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
