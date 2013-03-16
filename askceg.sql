-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2013 at 01:52 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

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
(22, 'dgdgg\n', 2, 2011103089, '', 0, '10:08 PM 21-Dec-12'),
(23, 'i didnt even start yet...pls if anyone does complete..\nsend me a link to the h.w!!!', 31, 2011103089, '', 0, '02:21 AM 27-Dec-12'),
(26, 'a js library ', 41, 2011103089, '', 0, '03:35 PM 12-Mar-13'),
(27, 'fsff\nsfsfff', 41, 2011103089, '', 0, '03:36 PM 12-Mar-13'),
(25, 'here is the link to the program solutions\nhttps://accounts.google.com/ServiceLogin?service=mail&passive=true&rm=false&continue=http://mail.google.com/mail/&scc=1&ltmpl=default&ltmplcache=2\n', 31, 2011103085, '', 0, '02:23 AM 27-Dec-12'),
(28, 'ccbcbbcb\ncbbcbcbcbc\ncbcbcbc\ncbcb', 10, 2011103089, '', 0, '11:27 AM 16-Mar-13');

-- --------------------------------------------------------

--
-- Table structure for table `CATEGORY`
--

CREATE TABLE IF NOT EXISTS `CATEGORY` (
  `category_id` int(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) NOT NULL,
  `category_desc` varchar(500) NOT NULL,
  `category_url` varchar(50) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `CATEGORY`
--

INSERT INTO `CATEGORY` (`category_id`, `category_name`, `category_desc`, `category_url`) VALUES
(1, 'cse', 'this is the official askceg page for CSE department.post your questions here for cse teachers to answer', 'cse'),
(2, 'ece', 'all about Entertainment', 'ece'),
(3, 'mechanical engineering', '', 'mechanical-engineering'),
(4, 'civil engineering', '', 'civil-engineering'),
(5, 'eee', '', 'eee'),
(6, 'miscellaneous', '', 'miscellaneous');

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
(31, 2011103085),
(1, 2011103089),
(15, 2011103089),
(4, 2011103085),
(11, 2011103090),
(10, 2011103090),
(3, 2011103089),
(4, 2011103089),
(39, 2011103089),
(38, 2011103089),
(23, 2011103089),
(12, 2011103089),
(11, 2011103089);

-- --------------------------------------------------------

--
-- Table structure for table `GROUPS`
--

CREATE TABLE IF NOT EXISTS `GROUPS` (
  `group_id` int(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(50) NOT NULL,
  `group_desc` text NOT NULL,
  `group_level` varchar(20) NOT NULL,
  `department_id` int(20) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `GROUPS`
--

INSERT INTO `GROUPS` (`group_id`, `group_name`, `group_desc`, `group_level`, `department_id`) VALUES
(1, 'cse ibatch 2nd year', 'After the iPod, came the iPhone... then the iPad, and now it is our very own iBatch! :D\nThis page is a forum on all discussions relating to iBatch. :)', '0', 0),
(2, 'CSE h batch 2nd year', 'dsadwsadfsada\r\nsasadsafdasd\r\nsdfasdsadad', '0', 0),
(7, 'DEPARTMENT OF COMPUTERSCIENCE ', '', '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `GROUPS_HANDLED`
--

CREATE TABLE IF NOT EXISTS `GROUPS_HANDLED` (
  `user_id` int(20) NOT NULL,
  `group_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `PROMOTE`
--

CREATE TABLE IF NOT EXISTS `PROMOTE` (
  `q_id` int(20) NOT NULL,
  `category_id` int(20) NOT NULL,
  `timestamp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p_fb_connect`
--

CREATE TABLE IF NOT EXISTS `p_fb_connect` (
  `email` varchar(100) NOT NULL,
  `fb_user_id` varchar(100) NOT NULL,
  `access_token` varchar(200) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `posted` int(2) NOT NULL DEFAULT '0',
  `error` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `p_fb_details`
--

CREATE TABLE IF NOT EXISTS `p_fb_details` (
  `email` varchar(100) NOT NULL,
  `fb_user_id` varchar(100) NOT NULL,
  `access_token` varchar(200) NOT NULL,
  `seqid` bigint(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seqid`),
  UNIQUE KEY `fb_user_id` (`fb_user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `p_fb_details`
--

INSERT INTO `p_fb_details` (`email`, `fb_user_id`, `access_token`, `seqid`, `timestamp`, `status`) VALUES
('dgr8geek@gmail.com', '100000673452300', 'AAAHIZAS4ZCTI0BABQQNIEWygZBH1juTZB841nnvhzZC6yAC75BMqm3x7fXg6ZCCjIcTTsFZBZA7LRWXnjRxwLk6VBpCjVdAP3PGeBYi2GHoh5ZBizjtZBzvNMv', 38, '2013-03-06 05:34:10', 1),
('vigneshjmsc@gmail.com', 'vigneshjmsc@gmail.com', '', 39, '2013-03-06 05:41:54', 0);

-- --------------------------------------------------------

--
-- Table structure for table `p_pid_email`
--

CREATE TABLE IF NOT EXISTS `p_pid_email` (
  `pid` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `acctype` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_pid_email`
--

INSERT INTO `p_pid_email` (`pid`, `email`, `acctype`, `user_id`) VALUES
('P13FFYO', 'dgr8geek@gmail.com', NULL, '100000673452300');

-- --------------------------------------------------------

--
-- Table structure for table `p_registration_info`
--

CREATE TABLE IF NOT EXISTS `p_registration_info` (
  `pid` varchar(20) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `acctype` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seqid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seqid`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `kid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `p_student_profile`
--

CREATE TABLE IF NOT EXISTS `p_student_profile` (
  `pid` varchar(10) NOT NULL,
  `email` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `college` varchar(200) NOT NULL,
  `degree` varchar(50) NOT NULL,
  `course` varchar(100) NOT NULL,
  `pic_url` varchar(200) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `referral` varchar(100) DEFAULT NULL,
  `complete` int(2) NOT NULL,
  `password` varchar(100) NOT NULL DEFAULT 'ass',
  `isNormalAccount` int(2) NOT NULL,
  `hash` varchar(100) NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `p_student_profile`
--

INSERT INTO `p_student_profile` (`pid`, `email`, `name`, `sex`, `phone`, `college`, `degree`, `course`, `pic_url`, `time`, `referral`, `complete`, `password`, `isNormalAccount`, `hash`) VALUES
('P13FFYX', 'vigneshjmsc@gmail.com', 'asdasd', '', '21313809', 'Others', 'asas', 'sas', '', '2013-03-06 05:41:54', NULL, 1, '123123', 1, ''),
('P13FFYO', 'dgr8geek@gmail.com', 'vignesh', '', '1212', 'Others', 'wdasdad', 'asdasdasd', '', '2013-03-06 05:34:10', NULL, 1, 'ass', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `QUESTION`
--

CREATE TABLE IF NOT EXISTS `QUESTION` (
  `q_id` int(10) NOT NULL AUTO_INCREMENT,
  `q_content` varchar(500) NOT NULL,
  `topic_id` int(10) NOT NULL,
  `posted_by` int(20) NOT NULL,
  `scope` int(20) NOT NULL,
  `timestamp` varchar(20) NOT NULL,
  `q_description` text NOT NULL,
  `views` int(20) NOT NULL,
  `followers` int(20) NOT NULL,
  `url` varchar(400) NOT NULL,
  `anonymous` int(20) NOT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `QUESTION`
--

INSERT INTO `QUESTION` (`q_id`, `q_content`, `topic_id`, `posted_by`, `scope`, `timestamp`, `q_description`, `views`, `followers`, `url`, `anonymous`) VALUES
(2, 'asdasd', 1, 2011103089, 0, '10:53 pm 02 Dec-12 ', 'asdasdasd', 4, 0, 'asdasd', 0),
(3, 'who is obama?', 1, 2011103090, 0, '11:12 pm 02 Dec-12 ', '', 27, 0, 'who-is-obama', 0),
(4, 'what is the rate of iphone 5?', 1, 2011103090, 0, '09:08 PM 06-Dec-12', '', 4, 0, 'what-is-the-rate-of-iphone-5', 0),
(5, 'GJHGJ??', 1, 2011103090, 0, '12:32 PM 11-Dec-12', 'DDDCD', 3, 0, 'GJHGJ', 0),
(6, 'What is Askceg?', 1, 2011103090, 0, '12:36 PM 11-Dec-12', '', 0, 0, 'What-is-Askceg', 0),
(7, 'sdsdsdd', 1, 2011103090, 0, '11:20 AM 15-Dec-12', '', 0, 0, 'sdsdsdd', 0),
(45, 'heeeeeeeyyyyyyyyyyyyyyyyy?', 2, 2011103089, 0, '12:28 PM 16-Mar-13', '', 0, 0, 'heeeeeeeyyyyyyyyyyyyyyyyy', 0),
(10, 'How cool is AskCEG? :D', 1, 2011103053, 0, '09:57 AM 18-Dec-12', '', 5, 0, 'How-cool-is-AskCEG-D', 0),
(11, 'ghikjfkjrf', 2, 2011103090, 0, '05:18 PM 18-Dec-12', '', 0, 0, 'ghikjfkjrf', 0),
(12, 'hey boys ?', 2, 2011103090, 0, '05:19 PM 18-Dec-12', '', 0, 0, 'hey-boys', 0),
(14, 'who is obama?', 1, 2011103089, 0, '11:03 PM 21-Dec-12', '', 0, 0, 'who-is-obama-1356110311', 0),
(15, 'who is obama?', 1, 2011103089, 0, '11:05 PM 21-Dec-12', '', 0, 0, 'who-is-obama-1356110408', 0),
(16, 'how u doing?', 2, 2011103089, 0, '12:29 AM 23-Dec-12', '', 0, 0, 'how-u-doing', 0),
(17, 'when is k13?', 5, 2011103089, 0, '12:32 AM 23-Dec-12', '', 0, 0, 'when-is-k13', 0),
(18, 'sfsfsff', 1, 2011103085, 0, '04:33 PM 23-Dec-12', '', 0, 0, 'sfsfsff', 0),
(20, 'dgdgg', 4, 2011103085, 0, '04:36 PM 23-Dec-12', '', 0, 0, 'dgdgg', 0),
(21, 'who is going to take webtech?', 2, 0, 0, '04:39 PM 23-Dec-12', '', 0, 0, 'who-is-going-to-take-webtech', 1),
(22, 'why is acoe website slow?', 2, 2011103089, 0, '05:17 PM 23-Dec-12', '', 0, 0, 'why-is-acoe-website-slow', 1),
(23, 'heeeeeey!!', 2, 604, 0, '08:50 PM 23-Dec-12', '', 0, 0, 'heeeeeey', 0),
(24, 'testing :D ????', 2, 2011103051, 0, '', '', 0, 0, 'testing', 0),
(25, 'testing radio button', 2, 2011103089, 0, '01:06 PM 26-Dec-12', '', 0, 0, 'testing-radio-button', 0),
(26, 'harry potter?', 2, 2011103089, 0, '01:07 PM 26-Dec-12', '', 0, 0, 'harry-potter', 0),
(27, 'qwert!', 2, 2011103089, 0, '01:30 PM 26-Dec-12', '', 0, 0, 'qwert', 0),
(28, 'svfvzsvzc', 2, 2011103089, 0, '01:33 PM 26-Dec-12', '', 0, 0, 'svfvzsvzc', 0),
(29, 'sss', 2, 2011103089, 0, '01:34 PM 26-Dec-12', '', 0, 0, 'sss', 0),
(30, 'is 4th sem easy?', 2, 2011103090, 1, '01:35 PM 26-Dec-12', '', 0, 0, 'is-4th-sem-easy', 0),
(31, 'did anyone complete the lab work?', 2, 2011103002, 1, '04:46 PM 26-Dec-12', '', 0, 0, 'checking-group-scope', 0),
(43, '##$%^&***^%$#@?', 2, 2011103089, 0, '04:40 PM 12-Mar-13', '', 0, 0, '', 0),
(33, 'fsfssfsf', 2, 2011103089, 0, '01:39 AM 27-Dec-12', '', 0, 0, 'fsfssfsf', 0),
(34, 'hello', 2, 2011103089, 0, '01:40 AM 27-Dec-12', '', 0, 0, 'hello', 0),
(35, 'from a fourth semester perspective,what are the subjects that we should be conceptually strong at for better future prospects or for future studies?\n', 2, 2011103089, 0, '01:46 AM 27-Dec-12', '', 0, 0, 'from-a-fourth-semester-perspective-what-are-the-subjects-that-we-should-be-conceptually-strong-at-for-better-future-prospects-or-for-future-studies', 0),
(36, 'why is CodeIgnitor framework faster than cakephp?', 8, 2011103089, 0, '01:54 AM 27-Dec-12', '', 0, 0, 'why-is-CodeIgnitor-framework-faster-than-cakephp', 0),
(37, ' How to handle StackOverflowError in Java?', 9, 2011103089, 0, '02:11 AM 27-Dec-12', '', 0, 0, 'How-to-handle-StackOverflowError-in-Java', 0),
(38, '\nObjective-C/iOS vs Java - Career Prospects ? (A non-technical queries, well mostly)', 2, 2011103089, 0, '02:14 AM 27-Dec-12', '', 0, 0, '0-votes-0answers-18-views-Objective-C-iOS-vs-Java-Career-Prospects-A-non-technical-queries-well-mostly', 0),
(39, 'fdfdfdfdkflkdlfkd', 2, 2011103089, 0, '12:43 PM 27-Dec-12', '', 0, 0, 'fdfdfdfdkflkdlfkd', 1),
(40, 'what is the difference between java and javascript?', 2, 2011103089, 0, '11:19 PM 29-Dec-12', '', 0, 0, 'what-is-the-difference-between-java-and-javascript', 0),
(41, 'what is jquery?', 2, 2011103089, 0, '03:29 PM 12-Mar-13', '', 0, 0, 'what-is-jquery', 0),
(44, 'dgdggdgg', 2, 2011103089, 0, '03:30 PM 15-Mar-13', '', 0, 0, 'dgdggdgg', 0),
(46, 'fgdgddggdgdgdg', 2, 2011103089, 0, '12:29 PM 16-Mar-13', '', 0, 0, 'fgdgddggdgdgdg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `QUESTION_POST_TO_TEACHER`
--

CREATE TABLE IF NOT EXISTS `QUESTION_POST_TO_TEACHER` (
  `q_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `REQUEST_USER`
--

INSERT INTO `REQUEST_USER` (`user_id`, `request_id`, `user_name`, `group_id`, `password`, `user_level`, `email_id`, `user_year`, `user_degree`, `user_course`) VALUES
(0, 33, 'hjkhhk', 1, '', 0, '', 2, '', ''),
(0, 34, 'vishnu', 0, '', 0, '', 0, '', ''),
(0, 35, 'kannan', 0, '', 0, '', 0, '', ''),
(0, 36, 'kannan', 0, '', 0, '', 0, '', ''),
(2011103089, 37, 'vishnu', 1, '123123', 0, '2011103089', 0, '', ''),
(0, 38, 'sfsfsffsffsf', 0, '', 0, '', 0, '', ''),
(0, 39, 'vishnu', 0, '', 0, '', 0, '', ''),
(0, 40, 'vishnursrr', 0, '', 0, '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `TEACHER_DETAILS`
--

CREATE TABLE IF NOT EXISTS `TEACHER_DETAILS` (
  `user_id` int(20) NOT NULL,
  `graduated_at` varchar(200) NOT NULL,
  `field_of_interest` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TEACHER_DETAILS`
--

INSERT INTO `TEACHER_DETAILS` (`user_id`, `graduated_at`, `field_of_interest`) VALUES
(604, 'MTF college', '');

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
  `topic_image` varchar(40) NOT NULL,
  PRIMARY KEY (`topic_id`),
  UNIQUE KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `TOPIC`
--

INSERT INTO `TOPIC` (`topic_id`, `topic_name`, `topic_desc`, `posted_by`, `category_id`, `timestamp`, `topic_url`, `topic_image`) VALUES
(1, 'computer', '0', 2011103090, 1, '12-10-12', 'computer', ''),
(2, 'ibatch', '0', 0, 5, '', 'ibatch', ''),
(3, 'ibatch boys', '', 0, 1, '', 'ibatch-boys', ''),
(4, 'Movies', 'Contains all questions about movies!', 2011103090, 2, '', 'Movies', ''),
(5, 'battle of brains', '', 0, 3, '', 'battle-of-brains', ''),
(6, 'iphone is cool', '', 604, 4, '09:11 PM 23-Dec-12', 'iphone-is-cool', ''),
(7, 'placement', '', 2011103089, 3, '01:46 AM 27-Dec-12', 'placement', ''),
(8, 'programming', '', 2011103089, 1, '01:47 AM 27-Dec-12', 'programming', ''),
(9, 'JAVA labwork-4th sem', 'this is a askceg page where anyone can post questions related java lab and also post answer', 2011103089, 1, '02:09 AM 27-Dec-12', 'JAVA-labwork-4th-sem', ''),
(10, 'web development', '', 2011103089, 1, '03:31 PM 12-Mar-13', 'web-development', ''),
(11, 'pinaclle', '', 2011103089, 3, '03:30 PM 15-Mar-13', 'pinaclle', '');

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
(8, 2011103053),
(8, 2011103090),
(8, 2011103089),
(9, 2011103051),
(9, 2011103052),
(9, 2011103053),
(9, 2011103054),
(9, 2011103089);

-- --------------------------------------------------------

--
-- Table structure for table `USERS`
--

CREATE TABLE IF NOT EXISTS `USERS` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `reg_no` int(25) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2011103594 ;

--
-- Dumping data for table `USERS`
--

INSERT INTO `USERS` (`user_id`, `reg_no`, `user_name`, `group_id`, `password`, `user_level`, `email_id`, `joined_on`, `user_year`, `user_degree`, `user_course`) VALUES
(2011103089, 2011103089, 'vishnu jayvel', 1, '123123', 1, '', '', 2, 'BE', 'ece'),
(2011103090, 2011103090, 'Narain Sharma', 1, '123123', 1, 'narain@gmail.com', '', 2, 'BE', 'CSE'),
(2011103593, 2011103593, 'Anirudh', 1, '123123', 0, '', '', 0, 'BE', 'CSE'),
(2011103087, 2011103087, 'swetha', 1, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103085, 2011103085, 'adi', 1, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103038, 2011103038, 'Jayashruthi', 1, '123123', 0, '', '', 0, 'BE', 'CSE'),
(2011103051, 2011103051, 'Gopinath', 2, '123123', 1, '', '', 2, 'BE', 'CSE'),
(2011103054, 2011103054, 'Jai Vasanth', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103053, 2011103053, 'Hema Varman', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103050, 2011103050, 'Anudeep Ballu', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103052, 2011103052, 'Harinikesh Suresh', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103055, 2011103055, 'Jayasri ', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103060, 2011103060, 'Vinay Srinivas', 2, '123123', 0, '', '', 2, 'BE', 'CSE'),
(2011103058, 2011103058, 'Prashanth Anantharam', 2, '123123', 0, '', '', 2, 'BE', 'CSE');

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

-- --------------------------------------------------------

--
-- Table structure for table `VOTE`
--

CREATE TABLE IF NOT EXISTS `VOTE` (
  `a_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `vote` int(20) NOT NULL,
  `timestamp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `VOTE`
--

INSERT INTO `VOTE` (`a_id`, `user_id`, `vote`, `timestamp`) VALUES
(15, 2011103089, -1, '04:28 PM 23-Feb-13'),
(27, 2011103089, 1, '03:37 PM 12-Mar-13'),
(26, 2011103089, -1, '03:37 PM 12-Mar-13'),
(28, 2011103089, 1, '11:27 AM 16-Mar-13');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
