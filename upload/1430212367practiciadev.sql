-- phpMyAdmin SQL Dump
-- version 4.3.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2015 at 04:42 AM
-- Server version: 5.6.19-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `practiciadev`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL,
  `studentid` text NOT NULL,
  `teacherid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `assignmentid` int(11) NOT NULL,
  `practiceid` int(11) NOT NULL,
  `ratingid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `exfield1` text NOT NULL,
  `exfield2` text NOT NULL,
  `exfield3` text NOT NULL,
  `activitytype` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('yes','no','delete') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=601 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE IF NOT EXISTS `assignment` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `type_name` varchar(200) NOT NULL,
  `book_id` int(11) NOT NULL,
  `book_name` varchar(200) NOT NULL,
  `start_page` int(11) NOT NULL,
  `end_page` int(11) NOT NULL,
  `associate_event_id` int(11) NOT NULL,
  `associate_event` varchar(255) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=402 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignmenttype`
--

CREATE TABLE IF NOT EXISTS `assignmenttype` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_book`
--

CREATE TABLE IF NOT EXISTS `assignment_book` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_instructions`
--

CREATE TABLE IF NOT EXISTS `assignment_instructions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `youtube_time` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `instruction_type` varchar(50) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `student_group_id` int(11) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1173 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assign_assignment`
--

CREATE TABLE IF NOT EXISTS `assign_assignment` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_group_id` int(11) NOT NULL COMMENT 'student id | group id',
  `assignment_id` int(11) NOT NULL,
  `type` varchar(55) NOT NULL COMMENT 'student | group',
  `mark_as_complete` varchar(25) NOT NULL COMMENT 'yes | no',
  `lock_unlock` varchar(20) NOT NULL COMMENT 'yes | no',
  `status` varchar(20) NOT NULL COMMENT 'yes | no | delete',
  `date` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=601 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE IF NOT EXISTS `award` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `criteria` varchar(255) NOT NULL,
  `criteria_details` text NOT NULL,
  `valid_from` datetime NOT NULL,
  `valid_to` datetime NOT NULL,
  `no_end_date` enum('yes','no') NOT NULL,
  `icon_id` int(11) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `award_icon`
--

CREATE TABLE IF NOT EXISTS `award_icon` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_comment`
--

CREATE TABLE IF NOT EXISTS `blog_comment` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_media`
--

CREATE TABLE IF NOT EXISTS `blog_media` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `type` varchar(55) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(55) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog_post`
--

CREATE TABLE IF NOT EXISTS `blog_post` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `permalink` text NOT NULL,
  `content` longtext NOT NULL,
  `tag` text NOT NULL,
  `type` varchar(15) NOT NULL,
  `ordering` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `assignmentid` int(11) NOT NULL,
  `practiceid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `pause_time` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('yes','no','delete') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comment_upload`
--

CREATE TABLE IF NOT EXISTS `comment_upload` (
  `id` int(11) NOT NULL,
  `commentid` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `replyto` varchar(255) NOT NULL,
  `replyto_name` varchar(255) NOT NULL,
  `cc` varchar(255) NOT NULL,
  `bcc` varchar(200) NOT NULL,
  `details` longtext NOT NULL,
  `variables` text NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `event_date` date NOT NULL,
  `event_time` varchar(200) NOT NULL,
  `address_venue_name` varchar(255) NOT NULL,
  `address_street_number` varchar(50) NOT NULL,
  `address_city` varchar(50) NOT NULL,
  `address_state` varchar(50) NOT NULL,
  `address_country` varchar(200) NOT NULL,
  `address_zip` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `description` text NOT NULL,
  `rating` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grouptbl`
--

CREATE TABLE IF NOT EXISTS `grouptbl` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `like_unlike`
--

CREATE TABLE IF NOT EXISTS `like_unlike` (
  `id` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `practiceid` int(11) NOT NULL,
  `likeunlike` enum('yes','no') NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=277 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pending_upload`
--

CREATE TABLE IF NOT EXISTS `pending_upload` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` enum('no','yes','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=755 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `practice`
--

CREATE TABLE IF NOT EXISTS `practice` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `assignment_type` varchar(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `recording_type` varchar(255) NOT NULL,
  `metroname` varchar(255) NOT NULL,
  `accompaniment` varchar(255) NOT NULL,
  `practice_time` time NOT NULL,
  `parent_approval` varchar(20) NOT NULL DEFAULT 'no',
  `status` enum('yes','no','delete','pending') NOT NULL,
  `date` datetime NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `practice_media`
--

CREATE TABLE IF NOT EXISTS `practice_media` (
  `id` int(11) NOT NULL,
  `practice_id` int(11) NOT NULL,
  `file_type` text NOT NULL,
  `name` text NOT NULL,
  `mark_repeat` text NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ratinggroup`
--

CREATE TABLE IF NOT EXISTS `ratinggroup` (
  `id` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=865 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `studentaward`
--

CREATE TABLE IF NOT EXISTS `studentaward` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `teacherid` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `assignment_type` varchar(20) NOT NULL,
  `awardid` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('yes','no','delete') NOT NULL,
  `practice_date` datetime NOT NULL COMMENT 'award date when student awarded'
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `studentgroup`
--

CREATE TABLE IF NOT EXISTS `studentgroup` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `status` enum('yes','delete','no') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_assign_asso_event`
--

CREATE TABLE IF NOT EXISTS `student_assign_asso_event` (
  `id` int(11) NOT NULL,
  `student_group_id` int(11) NOT NULL,
  `assignmentid` int(11) NOT NULL,
  `eventid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `summary`
--

CREATE TABLE IF NOT EXISTS `summary` (
  `id` int(11) NOT NULL,
  `postid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `status` enum('yes','no','delete') NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_group_student`
--

CREATE TABLE IF NOT EXISTS `teacher_group_student` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `status` enum('yes','delete','no') NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=464 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_student`
--

CREATE TABLE IF NOT EXISTS `teacher_student` (
  `id` int(11) NOT NULL,
  `student_group_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(22) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=312 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL,
  `parent_user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `teacher_email` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(15) NOT NULL,
  `street` varchar(100) NOT NULL,
  `appt` varchar(100) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` varchar(200) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `role` enum('student','teacher','parent','admin') NOT NULL,
  `profilepic` varchar(255) NOT NULL,
  `registrationsource` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` enum('yes','no','delete','pending') NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=413 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_temp`
--

CREATE TABLE IF NOT EXISTS `user_temp` (
  `id` int(11) NOT NULL,
  `firstname` varchar(33) NOT NULL,
  `lastname` varchar(33) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignmenttype`
--
ALTER TABLE `assignmenttype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_book`
--
ALTER TABLE `assignment_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignment_instructions`
--
ALTER TABLE `assignment_instructions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_assignment`
--
ALTER TABLE `assign_assignment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `award`
--
ALTER TABLE `award`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `award_icon`
--
ALTER TABLE `award_icon`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comment`
--
ALTER TABLE `blog_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_media`
--
ALTER TABLE `blog_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_post`
--
ALTER TABLE `blog_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_upload`
--
ALTER TABLE `comment_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_template`
--
ALTER TABLE `email_template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grouptbl`
--
ALTER TABLE `grouptbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `like_unlike`
--
ALTER TABLE `like_unlike`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_upload`
--
ALTER TABLE `pending_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practice`
--
ALTER TABLE `practice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practice_media`
--
ALTER TABLE `practice_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratinggroup`
--
ALTER TABLE `ratinggroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentaward`
--
ALTER TABLE `studentaward`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentgroup`
--
ALTER TABLE `studentgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_assign_asso_event`
--
ALTER TABLE `student_assign_asso_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `summary`
--
ALTER TABLE `summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_group_student`
--
ALTER TABLE `teacher_group_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_student`
--
ALTER TABLE `teacher_student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`), ADD KEY `lastname_2` (`lastname`), ADD KEY `firstname_2` (`firstname`), ADD FULLTEXT KEY `firstname` (`firstname`), ADD FULLTEXT KEY `lastname` (`lastname`);

--
-- Indexes for table `user_temp`
--
ALTER TABLE `user_temp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=601;
--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=402;
--
-- AUTO_INCREMENT for table `assignmenttype`
--
ALTER TABLE `assignmenttype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `assignment_book`
--
ALTER TABLE `assignment_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=206;
--
-- AUTO_INCREMENT for table `assignment_instructions`
--
ALTER TABLE `assignment_instructions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1173;
--
-- AUTO_INCREMENT for table `assign_assignment`
--
ALTER TABLE `assign_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=601;
--
-- AUTO_INCREMENT for table `award`
--
ALTER TABLE `award`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `award_icon`
--
ALTER TABLE `award_icon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `blog_comment`
--
ALTER TABLE `blog_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `blog_media`
--
ALTER TABLE `blog_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `blog_post`
--
ALTER TABLE `blog_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=147;
--
-- AUTO_INCREMENT for table `comment_upload`
--
ALTER TABLE `comment_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `email_template`
--
ALTER TABLE `email_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=247;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `grouptbl`
--
ALTER TABLE `grouptbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=95;
--
-- AUTO_INCREMENT for table `like_unlike`
--
ALTER TABLE `like_unlike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=277;
--
-- AUTO_INCREMENT for table `pending_upload`
--
ALTER TABLE `pending_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=755;
--
-- AUTO_INCREMENT for table `practice`
--
ALTER TABLE `practice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=245;
--
-- AUTO_INCREMENT for table `practice_media`
--
ALTER TABLE `practice_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT for table `ratinggroup`
--
ALTER TABLE `ratinggroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=865;
--
-- AUTO_INCREMENT for table `studentaward`
--
ALTER TABLE `studentaward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT for table `studentgroup`
--
ALTER TABLE `studentgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_assign_asso_event`
--
ALTER TABLE `student_assign_asso_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `summary`
--
ALTER TABLE `summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `teacher_group_student`
--
ALTER TABLE `teacher_group_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=464;
--
-- AUTO_INCREMENT for table `teacher_student`
--
ALTER TABLE `teacher_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=312;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=413;
--
-- AUTO_INCREMENT for table `user_temp`
--
ALTER TABLE `user_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=350;

