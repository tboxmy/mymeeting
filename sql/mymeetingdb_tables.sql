-- phpMyAdmin SQL Dump
-- version 3.1.0-beta1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 26, 2009 at 03:53 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6-2ubuntu4.1

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT=0;
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mymeetingdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--
-- Creation: Feb 26, 2009 at 03:48 PM
-- Last update: Feb 26, 2009 at 03:48 PM
--

DROP TABLE IF EXISTS `acos`;
CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) NOT NULL default '0',
  `model` varchar(255) default NULL,
  `foreign_key` int(10) NOT NULL default '0',
  `alias` varchar(255) default NULL,
  `lft` int(10) NOT NULL,
  `rght` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(11) NOT NULL auto_increment,
  `description` text,
  `updated` datetime default NULL,
  `created` datetime default NULL,
  `committee_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--
-- Creation: Feb 26, 2009 at 03:48 PM
-- Last update: Feb 26, 2009 at 03:48 PM
--

DROP TABLE IF EXISTS `aros`;
CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL auto_increment,
  `parent_id` int(10) NOT NULL default '0',
  `model` varchar(255) default NULL,
  `foreign_key` int(10) NOT NULL default '0',
  `alias` varchar(255) default NULL,
  `lft` int(10) NOT NULL,
  `rght` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--
-- Creation: Feb 26, 2009 at 03:48 PM
-- Last update: Feb 26, 2009 at 03:48 PM
--

DROP TABLE IF EXISTS `aros_acos`;
CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL auto_increment,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) default '0',
  `_read` varchar(2) default '0',
  `_update` varchar(2) default '0',
  `_delete` varchar(2) default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(20) default NULL,
  `foreign_key` int(11) NOT NULL,
  `file` varchar(255) default NULL,
  `filename` varchar(255) default NULL,
  `checksum` varchar(255) default NULL,
  `field` varchar(255) default NULL,
  `type` varchar(50) default NULL,
  `size` int(11) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `attendances`;
CREATE TABLE IF NOT EXISTS `attendances` (
  `id` int(11) NOT NULL auto_increment,
  `meeting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `will_attend` int(11) default NULL,
  `attended` int(11) default '0',
  `representative` tinyint(1) default NULL,
  `rep_name` varchar(255) default NULL,
  `excuse` varchar(255) default NULL,
  `created` datetime default NULL,
  `att_updated` datetime default NULL,
  `confirm_date` datetime default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(20) default NULL,
  `foreign_key` int(11) NOT NULL,
  `description` text,
  `user_id` int(11) NOT NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `committees`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `committees`;
CREATE TABLE IF NOT EXISTS `committees` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `short_name` varchar(30) default NULL,
  `meeting_num_template` varchar(30) default NULL,
  `item_name` varchar(30) default NULL,
  `minute_template` text NOT NULL,
  `meeting_title_template` varchar(255) default NULL,
  `parent_id` int(11) default '0',
  `lft` int(11) default '0',
  `rght` int(11) default '0',
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `committeetodos`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `committeetodos`;
CREATE TABLE IF NOT EXISTS `committeetodos` (
  `id` int(11) NOT NULL auto_increment,
  `committee_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) default NULL,
  `priority` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `decisions`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `decisions`;
CREATE TABLE IF NOT EXISTS `decisions` (
  `id` int(11) NOT NULL auto_increment,
  `committee_id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `minute_reference` varchar(20) NOT NULL,
  `description` text,
  `ordering` int(11) default NULL,
  `deadline` date NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `decisions_groups`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `decisions_groups`;
CREATE TABLE IF NOT EXISTS `decisions_groups` (
  `id` int(11) NOT NULL auto_increment,
  `decision_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `decisions_users`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `decisions_users`;
CREATE TABLE IF NOT EXISTS `decisions_users` (
  `id` int(11) NOT NULL auto_increment,
  `decision_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL auto_increment,
  `committee_id` int(11) NOT NULL,
  `name` varchar(30) default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groupstatuses`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `groupstatuses`;
CREATE TABLE IF NOT EXISTS `groupstatuses` (
  `id` int(11) NOT NULL auto_increment,
  `committee_id` int(11) NOT NULL,
  `decision_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `description` text,
  `action_date` date default NULL,
  `closed` tinyint(1) NOT NULL,
  `date_closed` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hashes`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `hashes`;
CREATE TABLE IF NOT EXISTS `hashes` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(30) NOT NULL,
  `foreign_key` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `hash_type` varchar(30) default NULL,
  `hash` varchar(30) NOT NULL,
  `limit` int(11) default NULL,
  `due_date` datetime default NULL,
  `limit_count` int(11) default NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL auto_increment,
  `committee_id` int(11) NOT NULL,
  `name` varchar(150) default NULL,
  `short_name` varchar(30) default NULL,
  `description` text,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 03:52 PM
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL auto_increment,
  `targetid` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `meetings`;
CREATE TABLE IF NOT EXISTS `meetings` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `committee_id` int(11) NOT NULL,
  `meeting_num` varchar(20) default NULL,
  `meeting_title` varchar(1000) default NULL,
  `meeting_date` datetime default NULL,
  `meeting_end_estimate` datetime NOT NULL,
  `meeting_end` datetime NOT NULL,
  `allow_representative` tinyint(1) NOT NULL default '0',
  `venue` varchar(100) default NULL,
  `agenda` text,
  `minutes` text,
  `invite_date` date default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `created` date default NULL,
  `updated` date default NULL,
  `minutes_raw` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `meetingtodos`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `meetingtodos`;
CREATE TABLE IF NOT EXISTS `meetingtodos` (
  `id` int(11) NOT NULL auto_increment,
  `meeting_id` int(11) NOT NULL,
  `name` varchar(100) default NULL,
  `priority` int(11) NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `done` tinyint(1) NOT NULL default '0',
  `date_done` date default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `memberships`;
CREATE TABLE IF NOT EXISTS `memberships` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `committee_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL auto_increment,
  `meeting_id` int(11) NOT NULL,
  `type` varchar(20) default NULL,
  `message_title` varchar(255) default NULL,
  `notification_date` datetime default NULL,
  `notification_sent` tinyint(1) NOT NULL default '0',
  `message` text,
  `to` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--
-- Creation: Feb 26, 2009 at 03:50 PM
-- Last update: Feb 26, 2009 at 03:50 PM
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL auto_increment,
  `setting` varchar(30) default NULL,
  `value` text,
  `group` varchar(30) default NULL,
  `description` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `systemtodos`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `systemtodos`;
CREATE TABLE IF NOT EXISTS `systemtodos` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `priority` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `templates`;
CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(20) default NULL,
  `foreign_key` int(11) NOT NULL,
  `type` varchar(20) default NULL,
  `title` varchar(200) default NULL,
  `description` varchar(500) default NULL,
  `template` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `titles`;
CREATE TABLE IF NOT EXISTS `titles` (
  `id` int(11) NOT NULL auto_increment,
  `short_name` varchar(10) default NULL,
  `long_name` varchar(100) default NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(20) default NULL,
  `password` varchar(200) default NULL,
  `superuser` tinyint(1) NOT NULL default '0',
  `protocol` int(11) NOT NULL,
  `job_title` varchar(50) default NULL,
  `bahagian` varchar(255) default NULL,
  `grade` varchar(30) default NULL,
  `name` varchar(80) default NULL,
  `email` varchar(150) default NULL,
  `telephone` varchar(30) default NULL,
  `mobile` varchar(30) default NULL,
  `fax` varchar(30) default NULL,
  `address` text,
  `title_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `userstatuses`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `userstatuses`;
CREATE TABLE IF NOT EXISTS `userstatuses` (
  `id` int(11) NOT NULL auto_increment,
  `committee_id` int(11) NOT NULL,
  `decision_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `updater` int(11) NOT NULL,
  `description` text,
  `action_date` date default NULL,
  `closed` tinyint(1) NOT NULL,
  `date_closed` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL default '0',
  `deleted_date` datetime default NULL,
  `created` datetime default NULL,
  `updated` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wfmodels`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `wfmodels`;
CREATE TABLE IF NOT EXISTS `wfmodels` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(50) default NULL,
  `committee_id` int(11) NOT NULL,
  `create` varchar(200) default NULL,
  `view` varchar(200) default NULL,
  `edit` varchar(200) default NULL,
  `delete` varchar(200) default NULL,
  `approve` varchar(200) default NULL,
  `disapprove` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wfstatuses`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `wfstatuses`;
CREATE TABLE IF NOT EXISTS `wfstatuses` (
  `id` int(11) NOT NULL auto_increment,
  `model` varchar(50) default NULL,
  `foreign_key` int(11) NOT NULL,
  `workflow_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workflows`
--
-- Creation: Feb 26, 2009 at 01:36 PM
-- Last update: Feb 26, 2009 at 01:36 PM
--

DROP TABLE IF EXISTS `workflows`;
CREATE TABLE IF NOT EXISTS `workflows` (
  `id` int(11) NOT NULL auto_increment,
  `committee_id` int(11) NOT NULL,
  `model` varchar(50) default NULL,
  `level` int(11) NOT NULL,
  `view` varchar(200) default NULL,
  `edit` varchar(200) default NULL,
  `delete` varchar(200) default NULL,
  `approve` varchar(200) default NULL,
  `disapprove` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

SET FOREIGN_KEY_CHECKS=1;

COMMIT;
