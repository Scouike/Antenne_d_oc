-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Lun 09 Mars 2020 à 08:21
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdradio`
--

-- --------------------------------------------------------

--
-- Structure de la table `emission`
--

CREATE TABLE `emission` (
  `id_emission` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `texte` varchar(50) NOT NULL,
  `interview` tinyint(1) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `emission`
--

INSERT INTO `emission` (`id_emission`, `nom`, `texte`, `interview`, `archive`) VALUES
(25, 'Oui-Oui', 'Vas-y', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `liason`
--

CREATE TABLE `liason` (
  `id_liaison` int(11) NOT NULL,
  `id_emission` int(11) NOT NULL,
  `id_theme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `liason`
--

INSERT INTO `liason` (`id_liaison`, `id_emission`, `id_theme`) VALUES
(12, 25, 1);

-- --------------------------------------------------------

--
-- Structure de la table `podcast`
--

CREATE TABLE `podcast` (
  `id_podcast` int(11) NOT NULL,
  `id_emission` int(11) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `son` varchar(250) NOT NULL,
  `texte` text,
  `intemporelle` tinyint(1) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `attente` tinyint(1) NOT NULL DEFAULT '0',
  `dateArchive` varchar(10) DEFAULT NULL,
  `dateCreation` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
--
-- Contenu de la table `podcast`
--

-- --------------------------------------------------------

--
-- Structure de la table `theme`
--

CREATE TABLE `theme` (
  `id_theme` int(11) NOT NULL,
  `image` varchar(250) NOT NULL,
  `titre` varchar(25) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `theme`
--

INSERT INTO `theme` (`id_theme`, `image`, `titre`, `archive`) VALUES
(1, '/ProjetRadioGit/ProjetRadioPhp/images/nature.png', 'Nature', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `mail` varchar(35) NOT NULL,
  `mdp` varchar(500) NOT NULL,
  `niveau` int(11) NOT NULL,
  `attente` tinyint(1) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `dateNaiss` varchar(10) NOT NULL,
  `clefActivation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `mail`, `mdp`, `niveau`, `attente`, `prenom`, `dateNaiss`, `clefActivation`) VALUES
(5, 'amsif', 'alex.amsif@iut-rodez.fr', '996fbb1fc8c13fae5628ea5b0368c01e762716ff09aa1f27daa52974e7ccd3f7', 1, 0, 'alex', '2000-06-28', 'eb573aaf29403c2f7da65cd51a2e2b9d'),
(6, 'borgi', 'tatiana.borgi@iut-rodez.fr', 'dc67409635f1a754ea8679220ae3cb604a3c5050320986de0375b583132b1a42', 1, 0, 'tatiana', '2000-07-02', 'e92f308bf4213f5acb36533e1786f7ef'),
(8, 'zenone', 'zenonemathieu@gmail.com', 'be7af5e98ba30dce453ce5ed9aea66ca6cc299dfe322f6edd1631485199c9f5b', 2, 0, 'mathieu', '1999-10-02', '0fd7438014bdd06d8f3259ecc4a6f76b');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `emission`
--
ALTER TABLE `emission`
  ADD PRIMARY KEY (`id_emission`);

--
-- Index pour la table `liason`
--
ALTER TABLE `liason`
  ADD PRIMARY KEY (`id_liaison`),
  ADD KEY `id_emmission` (`id_emission`),
  ADD KEY `id_theme` (`id_theme`);

--
-- Index pour la table `podcast`
--
ALTER TABLE `podcast`
  ADD PRIMARY KEY (`id_podcast`),
  ADD KEY `id_emmision` (`id_emission`);

--
-- Index pour la table `theme`
--
ALTER TABLE `theme`
  ADD PRIMARY KEY (`id_theme`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `emission`
--
ALTER TABLE `emission`
  MODIFY `id_emission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `liason`
--
ALTER TABLE `liason`
  MODIFY `id_liaison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `podcast`
--
ALTER TABLE `podcast`
  MODIFY `id_podcast` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id_theme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `liason`
--
ALTER TABLE `liason`
  ADD CONSTRAINT `FK_emmision` FOREIGN KEY (`id_emission`) REFERENCES `emission` (`id_emission`),
  ADD CONSTRAINT `FK_theme` FOREIGN KEY (`id_theme`) REFERENCES `theme` (`id_theme`);

--
-- Contraintes pour la table `podcast`
--
ALTER TABLE `podcast`
  ADD CONSTRAINT `FK_emmission` FOREIGN KEY (`id_emission`) REFERENCES `emission` (`id_emission`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
