-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 07, 2014 at 12:36 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `WMP14`
--

-- --------------------------------------------------------

--
-- Table structure for table `Candidate`
--

CREATE TABLE `Candidate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `school` varchar(45) NOT NULL,
  `major` varchar(45) NOT NULL,
  `gpa` decimal(10,0) NOT NULL,
  `grad_date` datetime NOT NULL,
  `offer_status` varchar(255) NOT NULL DEFAULT 'None',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=208 ;

--
-- Dumping data for table `Candidate`
--

INSERT INTO `Candidate` (`id`, `name`, `email`, `school`, `major`, `gpa`, `grad_date`, `offer_status`) VALUES
(201, 'Anubhaw Arya', 'arya0@purdue.edu', 'Purdue University', 'Computer Science and Math', 3, '2016-05-20 00:00:00', 'No Offer'),
(202, 'Matt Gotteiner', 'mgottein@purdue.edu', 'Purdue University', 'Computer Science', 4, '2016-05-09 00:00:00', 'Pending'),
(203, 'Dennis', 'DennisJWebster@teleworm.us', 'DePauw', 'Economics', 2, '2014-12-02 00:00:00', 'No Offer'),
(204, 'Bobbie O. Miller', 'BobbieOMiller@teleworm.us', 'DePauw University', 'Literature', 4, '2013-02-03 00:00:00', 'Rejected'),
(205, 'Cynthia M. Barlow', 'CynthiaMBarlow@jourrapide.com', 'University of Illinois', 'Mechanical Engineering', 1, '2015-12-21 00:00:00', 'No Offer'),
(206, 'Bonita A. Shaw', 'BonitaAShaw@jourrapide.com', 'University of Illinois', 'History', 3, '2013-05-31 00:00:00', 'Pending'),
(207, 'Erlinda P. Henriquez', 'ErlindaPHenriquez@jourrapide.com', 'South Harmon Institute of Technology', 'Political Science', 4, '2014-05-21 00:00:00', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE `Event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `location` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Event`
--

INSERT INTO `Event` (`id`, `name`, `location`, `time`, `description`) VALUES
(1, 'Cocktail', 'Chicago, IL', '2014-03-06 00:00:00', 'Cool'),
(2, 'Career Fair', 'Bloomington, IN', '2014-01-23 00:00:00', 'Campus career fair at IU'),
(3, 'Career Fair', 'West Lafayette, IN', '2013-12-01 00:00:00', 'Campus career fair at Purdue'),
(4, 'Reddit Meetup', 'Millenium Park, Chicago, IL', '2013-05-02 00:00:00', 'Redditors of Chicago meet up!'),
(5, 'Retirement Party', 'West Monroe HQ', '2014-03-07 00:00:00', 'Joe''s retirement party'),
(6, 'Birthday Bash', 'Sears Tower, Chicago, IL', '2014-06-21 00:00:00', 'Amy''s 21st Birthday!');

-- --------------------------------------------------------

--
-- Table structure for table `Event_has_Candidate`
--

CREATE TABLE `Event_has_Candidate` (
  `Event_id` int(11) NOT NULL,
  `Candidate_id` int(11) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `attended` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Event_id`,`Candidate_id`),
  KEY `fk_Event_has_Candidate_Candidate1_idx` (`Candidate_id`),
  KEY `fk_Event_has_Candidate_Event_idx` (`Event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Event_has_Candidate`
--

INSERT INTO `Event_has_Candidate` (`Event_id`, `Candidate_id`, `notes`, `attended`) VALUES
(1, 201, 'Cool guy', 1),
(1, 204, 'No ride here', 0),
(1, 205, 'Prospective candidate', 1),
(3, 201, 'Awesome person!', 1),
(4, 201, 'Cool guy', 1),
(4, 204, '', 1),
(4, 205, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Interview`
--

CREATE TABLE `Interview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Interviewer` varchar(45) NOT NULL,
  `Candidate_id` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Interview_Candidate1_idx` (`Candidate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Interview`
--

INSERT INTO `Interview` (`id`, `Interviewer`, `Candidate_id`, `Name`) VALUES
(1, 'Chris MIller', 201, 'Round 1 of intense interviews'),
(2, 'Marshall Bruce Mathers III', 204, 'Rap God');

-- --------------------------------------------------------

--
-- Table structure for table `Notes`
--

CREATE TABLE `Notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` text NOT NULL,
  `interview_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_note_to_candidate_id_idx` (`interview_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Notes`
--

INSERT INTO `Notes` (`id`, `note`, `interview_id`) VALUES
(1, 'Best candidate ever!!!', 1),
(2, 'I''m not afraid, to take a chance.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Question`
--

CREATE TABLE `Question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  `Interview_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Question_Interview1_idx` (`Interview_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Question`
--

INSERT INTO `Question` (`id`, `question`, `answer`, `Interview_id`) VALUES
(1, 'What is wumbology?', 'The study of wumbos.', 1),
(2, 'How many lightbulbs are there in Chicago', 'Too many!', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Event_has_Candidate`
--
ALTER TABLE `Event_has_Candidate`
  ADD CONSTRAINT `fk_Event_has_Candidate_Event` FOREIGN KEY (`Event_id`) REFERENCES `Event` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Event_has_Candidate_Candidate1` FOREIGN KEY (`Candidate_id`) REFERENCES `Candidate` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Interview`
--
ALTER TABLE `Interview`
  ADD CONSTRAINT `fk_Interview_Candidate1` FOREIGN KEY (`Candidate_id`) REFERENCES `Candidate` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Notes`
--
ALTER TABLE `Notes`
  ADD CONSTRAINT `fk_note_to_candidate_id` FOREIGN KEY (`interview_id`) REFERENCES `Interview` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Question`
--
ALTER TABLE `Question`
  ADD CONSTRAINT `fk_Question_Interview1` FOREIGN KEY (`Interview_id`) REFERENCES `Interview` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
