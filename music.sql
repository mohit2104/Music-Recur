-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 13, 2015 at 12:42 PM
-- Server version: 5.5.43-0ubuntu0.14.10.1
-- PHP Version: 5.5.12-2ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `music`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE IF NOT EXISTS `data` (
`id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `movie` varchar(40) NOT NULL,
  `artist` varchar(40) NOT NULL,
  `link` varchar(100) NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `name`, `movie`, `artist`, `link`, `count`) VALUES
(1, 'Be Intehaan', 'Race 2', 'Atif Aslam', 'songs/Be_Intehaan.mp3', 0),
(2, 'Tum He Ho', 'Aashique 2', 'Arijit Singh', 'songs/Tum_Hi_Ho.mp3', 0),
(3, 'Sunn raha hai', 'Aashique 2', 'Arijit Singh', 'songs/Sunn_Raha_Hai.mp3', 0),
(4, 'jannat', 'Jannat 2', 'kk', 'songs/Jannat-2.mp3', 0),
(6, 'Kabira', 'Yeh Jawani Hai Diwani', 'Arijit Singh', 'songs/kabira.mp3', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
