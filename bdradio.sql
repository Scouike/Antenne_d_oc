-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 11, 2020 at 03:22 PM
-- Server version: 5.7.11
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdradio`
--

-- --------------------------------------------------------

--
-- Table structure for table `emmission`
--

CREATE TABLE `emmission` (
  `id_emmission` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `texte` varchar(50) NOT NULL,
  `interview` tinyint(1) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `liason`
--

CREATE TABLE `liason` (
  `id_liaison` int(11) NOT NULL,
  `id_emmission` int(11) NOT NULL,
  `id_theme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `podcast`
--

CREATE TABLE `podcast` (
  `id_podcast` int(11) NOT NULL,
  `id_emmission` int(11) NOT NULL,
  `date` varchar(8) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `son` varchar(250) NOT NULL,
  `texte` text,
  `intemporelle` tinyint(1) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `attente` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `theme`
--

CREATE TABLE `theme` (
  `id_theme` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  `titre` varchar(25) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `pseudo` varchar(25) NOT NULL,
  `mail` varchar(35) NOT NULL,
  `mdp` varchar(500) NOT NULL,
  `niveau` int(11) NOT NULL,
  `attente` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `pseudo`, `mail`, `mdp`, `niveau`, `attente`) VALUES
(1, 'matmat', 'zenonemathieu@gmail.com', 'mdp', 2, 0),
(10, 'mathieuZen', 'mathieu.zenone@iut-rodez.fr', 'be7af5e98ba30dce453ce5ed9aea66ca6cc299dfe322f6edd1631485199c9f5b', 1, 0),
(11, 'test', 'test@gamil.com', '07480fb9e85b9396af06f006cf1c95024af2531c65fb505cfbd0add1e2f31573', 1, 0),
(12, 'alex', 'alex@gmail.com', '60dc48c86ade05d1de5a43fe1591fd5e2271dd6fa55e290490b5ecd02b807a9d', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emmission`
--
ALTER TABLE `emmission`
  ADD PRIMARY KEY (`id_emmission`);

--
-- Indexes for table `liason`
--
ALTER TABLE `liason`
  ADD PRIMARY KEY (`id_liaison`),
  ADD KEY `id_emmission` (`id_emmission`),
  ADD KEY `id_theme` (`id_theme`);

--
-- Indexes for table `podcast`
--
ALTER TABLE `podcast`
  ADD PRIMARY KEY (`id_podcast`),
  ADD KEY `id_emmision` (`id_emmission`);

--
-- Indexes for table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id_theme`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emmission`
--
ALTER TABLE `emmission`
  MODIFY `id_emmission` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `liason`
--
ALTER TABLE `liason`
  MODIFY `id_liaison` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `podcast`
--
ALTER TABLE `podcast`
  MODIFY `id_podcast` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `theme`
--
ALTER TABLE `theme`
  MODIFY `id_theme` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `liason`
--
ALTER TABLE `liason`
  ADD CONSTRAINT `FK_emmision` FOREIGN KEY (`id_emmission`) REFERENCES `emmission` (`id_emmission`),
  ADD CONSTRAINT `FK_theme` FOREIGN KEY (`id_theme`) REFERENCES `theme` (`id_theme`);

--
-- Constraints for table `podcast`
--
ALTER TABLE `podcast`
  ADD CONSTRAINT `FK_emmission` FOREIGN KEY (`id_emmission`) REFERENCES `emmission` (`id_emmission`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
