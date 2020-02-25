-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2014 at 02:33 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bookonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,0) NOT NULL,
  `special` tinyint(1) DEFAULT '0',
  `sale_off` int(11) DEFAULT '0',
  `picture` text,
  `created` date DEFAULT '0000-00-00',
  `created_by` varchar(255) DEFAULT NULL,
  `modified` date DEFAULT '0000-00-00',
  `modified_by` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `name`, `description`, `price`, `special`, `sale_off`, `picture`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `category_id`) VALUES
(12, 'UnrealScript Game Programming Cookbook', 'Designed for high-level game programming, UnrealScript is used in tandem with the Unreal Engine to provide a scripting language that is ideal for creating your very own unique gameplay experience. By learning how to replicate some of the advanced techniques used in today''s modern games, you too can take your game to the next level and stand out from the crowd.\r\n\r\nBy providing a series of engaging and practical recipes, this "UnrealScript Game Programming Cookbook" will show you how to leverage the advanced functionality within UDK. You''ll be shown how to implement a wide variety of practical features using the high-level scripting language ranging from designing your own HUD, creating your very own custom tailored weapons, to generating pathfinding solutions, and even meticulously crafting your own AI.', 25000, 0, 20, 'mj5oqp18.jpg', '2013-12-12', 'admin', '2013-12-25', 'admin', 1, 3, 4),
(13, 'Functional Programming in Scala', 'Functional programming (FP) is a programming style emphasizing functions that return consistent and predictable results regardless of a program''s state. As a result, functional code is easier to test and reuse, simpler to parallelize, and less prone to bugs. Scala is an emerging JVM language that offers strong support for FP. Its familiar syntax and transparent interoperability with existing Java libraries make Scala a great place to start learning FP.\r\n\r\nFunctional Programming in Scala is a serious tutorial for programmers looking to learn FP and apply it to the everyday business of coding. The book guides readers from basic techniques to advanced topics in a logical, concise, and clear progression. In it, you''ll find concrete examples and exercises that open up the world of functional programming.', 35000, 0, 3, '7kyub3oi.jpg', '2013-12-12', 'admin', '2013-12-13', 'admin', 1, 1, 3),
(14, 'iOS 7 Programming Fundamentals', 'If you''re getting started with iOS development, or want a firmer grasp of the basics, this practical guide provides a clear view of its fundamental building blocks—Objective-C, Xcode, and Cocoa Touch. You''ll learn object-oriented concepts, understand how to use Apple''s development tools, and discover how Cocoa provides the underlying functionality iOS apps need to have. Dozens of example projects are available at GitHub.\r\n\r\nOnce you master the fundamentals, you''ll be ready to tackle the details of iOS app development with author Matt Neuburg''s companion guide.', 45000, 0, 0, 'm3brd79l.jpg', '2013-12-12', 'admin', '2013-12-12', 'admin', 1, 2, 2),
(15, 'iOS 7 Programming Cookbook', 'Overcome the vexing issues you''re likely to face when creating apps for the iPhone, iPad, or iPod touch. With new and thoroughly revised recipes in this updated cookbook, you''ll quickly learn the steps necessary to work with the iOS 7 SDK, including solutions for bringing real-world physics and movement to your apps with UIKit Dynamics APIs.\r\n\r\nYou''ll learn hundreds of techniques for storing and protecting data, sending and receiving notifications, enhancing and animating graphics, managing files and folders, and many other options. Each recipe includes sample code you can use right away.', 44000, 0, 0, 'qx5m9u6t.jpg', '2013-12-12', 'admin', '2013-12-13', 'admin', 1, 3, 3),
(16, 'Advanced Programming in the UNIX Environment, 3rd Edition', 'For more than twenty years, serious C programmers have relied on one book for practical, in-depth knowledge of the programming interfaces that drive the UNIX and Linux kernels: W. Richard Stevens'' Advanced Programming in the UNIX Environment. Now, once again, Rich''s colleague Steve Rago has thoroughly updated this classic work. The new third edition supports today''s leading platforms, reflects new technical advances and best practices, and aligns with Version 4 of the Single UNIX Specification.\r\n\r\nSteve carefully retains the spirit and approach that have made this book so valuable. Building on Rich''s pioneering work, he begins with files, directories, and processes, carefully laying the groundwork for more advanced techniques, such as signal handling and terminal I/O. He also thoroughly covers threads and multithreaded programming, and socket-based IPC.', 36000, 1, 2, '2yo48fgm.jpg', '2013-12-12', 'admin', '2013-12-13', 'admin', 1, 3, 3),
(17, 'jMonkeyEngine 3.0 Beginner', 'jMonkeyEngine 3.0 is a powerful set of free Java libraries that allows you to unlock your imagination, create 3D games and stunning graphics. Using jMonkeyEngine''s library of time-tested methods, this book will allow you to unlock its potential and make the creation of beautiful interactive 3D environments a breeze.\r\n\r\njMonkeyEngine 3.0 Beginner''s Guide teaches aspiring game developers how to build modern 3D games with Java. This primer on 3D programming is packed with best practices, tips and tricks and loads of example code. Progressing from elementary concepts to advanced effects, budding game developers will have their first game up and running by the end of this book.', 36000, 0, 12, 'cq7k0i4j.jpg', '2013-12-12', 'admin', '2013-12-12', 'admin', 1, 3, 2),
(18, 'Scala Cookbook', 'Save time and trouble when using Scala to build object-oriented, functional, and concurrent applications. With more than 250 ready-to-use recipes and 700 code examples, this comprehensive cookbook covers the most common problems you''ll encounter when using the Scala language, libraries, and tools. It''s ideal not only for experienced Scala developers, but also for programmers learning to use this JVM language.\r\n\r\nAuthor Alvin Alexander (creator of DevDaily.com) provides solutions based on his experience using Scala for highly scalable, component-based applications that support concurrency and distribution.', 46000, 0, 0, 'zpg6a0uw.jpg', '2013-12-12', 'admin', '2013-12-12', 'admin', 1, 10, 4),
(19, 'PostgreSQL Server Programming', 'Learn how to work with PostgreSQL as if you spent the last decade working on it. PostgreSQL is capable of providing you with all of the options that you have in your favourite development language and then extending that right on to the database server. With this knowledge in hand, you will be able to respond to the current demand for advanced PostgreSQL skills in a lucrative and booming market.\r\n\r\nPostgreSQL Server Programming will show you that PostgreSQL is so much more than a database server. In fact, it could even be seen as an application development framework, with the added bonuses of transaction support, massive data storage, journaling, recovery and a host of other features that the PostgreSQL engine provides.', 54000, 0, 5, 'x3et42jv.jpg', '2013-12-12', 'admin', '2013-12-12', 'admin', 1, 3, 2),
(20, 'Programming Drupal 7 Entities', 'Writing code for manipulating Drupal data has never been easier! Learn to dice and serve your data as you slowly peel back the layers of the Drupal entity onion. Next, expose your legacy local and remote data to take full advantage of Drupal''s vast solution space.\r\n\r\nProgramming Drupal 7 Entities is a practical, hands-on guide that provides you with a thorough knowledge of Drupal''s entity paradigm and a number of clear step-by-step exercises, which will help you take advantage of the real power that is available when developing using entities.', 58000, 0, 4, 'zosatu07.jpg', '2013-12-12', 'admin', '2013-12-12', 'admin', 1, 3, 2),
(21, 'Moving from C to C++', 'The author says it best, I hope to move you, a little at a time,from understanding C to the point where C++ becomes your mindset. This remarkable book is designed to streamline the process of learning C++ in a way that discusses programming problems, why they exist, and the approach C++ has taken to solve such problems.\r\n\r\nYou can''t just look at C++ as a collection of features; some of the features make no sense in isolation. You can only use the sum of the parts if you are thinking about design, not simply coding. To understand C++, you must understand the problems with C and with programming in general. This book discusses programming problems, why they are problems, and the approach C++ has taken to solve such problems. Thus, the set of features that I explain in each chapter will be based on the way that I see a particular type of problem being solved in C++.', 36000, 0, 3, '901wh8tx.jpg', '2013-12-12', 'admin', '2013-12-12', 'admin', 1, 3, 2),
(22, 'C Programming for Arduino', 'Physical computing allows us to build interactive physical systems by using software & hardware in order to sense and respond to the real world. C Programming for Arduino will show you how to harness powerful capabilities like sensing, feedbacks, programming and even wiring and developing your own autonomous systems.\r\n\r\nC Programming for Arduino contains everything you need to directly start wiring and coding your own electronic project. You''ll learn C and how to code several types of firmware for your Arduino, and then move on to design small typical systems to understand how handling buttons, leds, LCD, network modules and much more.', 38000, 0, 0, 'siochmyg.jpg', '2013-12-12', 'admin', '2013-12-13', 'admin', 1, 2, 3),
(23, 'Advanced Network Programming - Principles and Techniques', 'The field of network programming is so large, and developing so rapidly, that it can appear almost overwhelming to those new to the discipline.\r\n\r\nAnswering the need for an accessible overview of the field, this text/reference presents a manageable introduction to both the theoretical and practical aspects of computer networks and network programming. Clearly structured and easy to follow, the book describes cutting-edge developments in network architectures, communication protocols, and programming techniques and models, supported by code examples for hands-on practice with creating network-based applications.', 43000, 1, 20, 'vradhky9.jpg', '2013-12-12', 'admin', '2013-12-13', 'admin', 1, 3, 3),
(24, 'Programming Logics', 'This Festschrift volume, published in memory of Harald Ganzinger, contains 17 papers from colleagues all over the world and covers all the fields to which Harald Ganzinger dedicated his work during his academic career.\r\n\r\nThe volume begins with a complete account of Harald Ganzinger''s work and then turns its focus to the research of his former colleagues, students, and friends who pay tribute to him through their writing. Their individual papers span a broad range of topics, including programming language semantics, analysis and verification, first-order and higher-order theorem proving, unification theory, non-classical logics, reasoning modulo theories, and applications of automated reasoning in biology.', 32000, 0, 1, 'sbx52yne.jpg', '2013-12-12', 'admin', '2013-12-12', 'admin', 1, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `left` int(11) NOT NULL,
  `right` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `created_by` varchar(45) NOT NULL,
  `modified` datetime NOT NULL,
  `modified_by` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `status`, `parent`, `level`, `left`, `right`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Root', '', 1, 0, 0, 0, 23, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(2, 'Chuyên ngành', '', 1, 1, 1, 1, 2, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(3, 'Kinh tế', '', 1, 1, 1, 3, 12, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(4, 'Tạp chí', '', 1, 1, 1, 13, 20, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(5, 'Tiếng anh', '', 1, 1, 1, 21, 22, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(6, 'Doanh nhân', '', 1, 3, 2, 4, 5, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(7, 'Khởi nghiệp', '', 1, 3, 2, 6, 7, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(8, 'Lãnh đạo', '', 1, 3, 2, 8, 11, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(9, 'IT', '', 1, 4, 2, 14, 17, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(10, 'Sức khỏe', '', 1, 4, 2, 18, 19, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(11, 'Nhân sự', '', 1, 8, 3, 9, 10, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', ''),
(12, 'Echip', '', 1, 9, 3, 15, 16, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(2, 'Manager', 1, 2, '2013-11-07 00:00:00', 'admin', '2013-12-03 00:00:00', 'admin'),
(3, 'Member', 0, 1, '2013-11-12 00:00:00', 'admin', '2014-02-18 00:00:00', 'admin'),
(1, 'Admin', 1, 3, '2014-12-02 05:54:41', 'admin', '2014-12-03 05:10:41', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `nested`
--

CREATE TABLE IF NOT EXISTS `nested` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `status` tinyint(1) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `left` int(11) NOT NULL,
  `right` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `nested`
--

INSERT INTO `nested` (`id`, `name`, `status`, `parent`, `level`, `left`, `right`) VALUES
(1, 'Root', 1, 0, 0, 0, 15),
(2, 'A', 1, 1, 1, 1, 2),
(3, 'B', 1, 1, 1, 3, 6),
(4, 'C', 1, 1, 1, 7, 8),
(6, 'E', 1, 1, 1, 9, 10),
(7, 'B1', 1, 3, 2, 4, 5),
(8, 'D1', 1, 1, 1, 11, 12),
(9, 'D2', 1, 1, 1, 13, 14);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `sign` text NOT NULL,
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(45) DEFAULT NULL,
  `register_time` datetime DEFAULT '0000-00-00 00:00:00',
  `register_ip` varchar(25) DEFAULT NULL,
  `active_code` varchar(45) NOT NULL,
  `active_time` datetime NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `ordering` int(11) DEFAULT '10',
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `fullname`, `password`, `avatar`, `sign`, `created`, `created_by`, `modified`, `modified_by`, `register_time`, `register_ip`, `active_code`, `active_time`, `status`, `ordering`, `group_id`) VALUES
(1, 'Admin01', 'Admin01@gmail.com', 'Admin 123456', '7c6f3ef49405d8a330aaa19ca0d0f6af', 'user_h6MNE8eQ.jpg', '<p>The HeadScript helper allows you to manage both. The HeadScript helper supports the following methods for setting and adding scripts</p>\r\n', '2014-12-10 08:55:35', 'admin', '2014-12-16 12:08:59', 'admin', '0000-00-00 00:00:00', NULL, '', '0000-00-00 00:00:00', 1, 2, 2),
(2, 'Admin12345', 'Admin12345@gmail.com', 'Admin1234523', '7c6f3ef49405d8a330aaa19ca0d0f6af', 'user_ZMfhibF9.jpg', '<p><span style="color:#B22222;"><u><s><em><strong><span style="background-color:#FFFF00;">Sign</span></strong></em></s></u></span></p>\r\n', '2014-12-13 07:20:03', NULL, '2014-12-26 11:29:35', NULL, '0000-00-00 00:00:00', NULL, '', '0000-00-00 00:00:00', 1, 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
