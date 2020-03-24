-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mar 24 Mars 2020 à 22:21
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
  `id_theme` int(11) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `texte` varchar(100) NOT NULL,
  `interview` tinyint(1) NOT NULL,
  `archive` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `emission`
--

INSERT INTO `emission` (`id_emission`, `id_theme`, `nom`, `texte`, `interview`, `archive`) VALUES
(25, 1, 'Oui-Oui', 'Vas-y', 0, 0),
(26, 1, 'emission des arbres', 'nos amis les arbres', 0, 0),
(27, 2, 'emission municipale', 'nos amis les maires', 0, 0),
(28, 2, 'emission dictateur', 'nos amis les dictateurs', 0, 0),
(29, 3, 'emission de la culture', 'notre amis la culture', 0, 0),
(30, 4, 'emission sur les couteaux', 'nos amis les couteaux', 0, 0),
(31, 4, 'les fourchette', 'nos amis les fourchettes', 0, 0),
(32, 4, 'les cuillère', 'une émission qui vous parlera des cuillère', 0, 0),
(33, 4, 'Mr carotte', 'Mr carotte nous racontera l\'histoire de son plus grand ennemis : Mr Lapin  ', 1, 0);

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

INSERT INTO `podcast` (`id_podcast`, `id_emission`, `image`, `son`, `texte`, `intemporelle`, `archive`, `attente`, `dateArchive`, `dateCreation`) VALUES
(1, 26, 'NULL', '/ProjetRadioGit/ProjetRadioPhp/podcast/Galatee.mp3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.\r\nUt velit mauris, egestas sed, gravida nec, ornare ut, mi. Aenean ut orci vel massa suscipit pulvinar. Nulla sollicitudin. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula. Pellentesque rhoncus nunc et augue. Integer id felis. Curabitur aliquet pellentesque diam. Integer quis metus vitae elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi vel erat non mauris convallis vehicula. Nulla et sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue eu, quam. Mauris ullamcorper felis vitae erat. Proin feugiat, augue non elementum posuere, metus purus iaculis lectus, et tristique ligula justo vitae magna.\r\n\r\nAliquam convallis sollicitudin purus. Praesent aliquam, enim at fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus, felis magna fermentum augue, et ultricies lacus lorem varius purus. Curabitur eu amet.', 0, 0, 0, NULL, '2020-03-19'),
(2, 31, 'NULL', '/ProjetRadioGit/ProjetRadioPhp/podcast/Galatee.mp3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.\r\nUt velit mauris, egestas sed, gravida nec, ornare ut, mi. Aenean ut orci vel massa suscipit pulvinar. Nulla sollicitudin. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula. Pellentesque rhoncus nunc et augue. Integer id felis. Curabitur aliquet pellentesque diam. Integer quis metus vitae elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi vel erat non mauris convallis vehicula. Nulla et sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue eu, quam. Mauris ullamcorper felis vitae erat. Proin feugiat, augue non elementum posuere, metus purus iaculis lectus, et tristique ligula justo vitae magna.\r\n\r\nAliquam convallis sollicitudin purus. Praesent aliquam, enim at fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus, felis magna fermentum augue, et ultricies lacus lorem varius purus. Curabitur eu amet.', 0, 0, 0, NULL, '2020-03-28'),
(3, 25, '/ProjetRadioGit/ProjetRadioPhp/podcast/raw.jpg', '/ProjetRadioGit/ProjetRadioPhp/podcast/Galatee.mp3', 'NULL', 0, 0, 0, NULL, '2020-03-19'),
(4, 27, '/ProjetRadioGit/ProjetRadioPhp/podcast/téléchargement.jpg', '/ProjetRadioGit/ProjetRadioPhp/podcast/Galatee.mp3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.\r\nUt velit mauris, egestas sed, gravida nec, ornare ut, mi. Aenean ut orci vel massa suscipit pulvinar. Nulla sollicitudin. Fusce varius, ligula non tempus aliquam, nunc turpis ullamcorper nibh, in tempus sapien eros vitae ligula. Pellentesque rhoncus nunc et augue. Integer id felis. Curabitur aliquet pellentesque diam. Integer quis metus vitae elit lobortis egestas. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi vel erat non mauris convallis vehicula. Nulla et sapien. Integer tortor tellus, aliquam faucibus, convallis id, congue eu, quam. Mauris ullamcorper felis vitae erat. Proin feugiat, augue non elementum posuere, metus purus iaculis lectus, et tristique ligula justo vitae magna.\r\n\r\nAliquam convallis sollicitudin purus. Praesent aliquam, enim at fermentum mollis, ligula massa adipiscing nisl, ac euismod nibh nisl eu lectus. Fusce vulputate sem at sapien. Vivamus leo. Aliquam euismod libero eu enim. Nulla nec felis sed leo placerat imperdiet. Aenean suscipit nulla in justo. Suspendisse cursus rutrum augue. Nulla tincidunt tincidunt mi. Curabitur iaculis, lorem vel rhoncus faucibus, felis magna fermentum augue, et ultricies lacus lorem varius purus. Curabitur eu amet.', 0, 0, 0, NULL, '2020-03-19'),
(7, 25, '/ProjetRadioGit/ProjetRadioPhp/podcast/raw.jpg', '/ProjetRadioGit/ProjetRadioPhp/podcast/Galatee.mp3', 'NULL', 0, 1, 1, NULL, '2020-03-19');

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
(1, '/ProjetRadioGit/ProjetRadioPhp/images/nature.jpg', 'Nature', 0),
(2, '/ProjetRadioGit/ProjetRadioPhp/images/politique.jpg', 'politique', 0),
(3, '/ProjetRadioGit/ProjetRadioPhp/images/culture.jpg', 'culture', 0),
(4, '/ProjetRadioGit/ProjetRadioPhp/images/cuisine.jpg', 'cuisine', 0);

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
  `clefActivation` varchar(100) NOT NULL,
  `dateSupr` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `mail`, `mdp`, `niveau`, `attente`, `prenom`, `dateNaiss`, `clefActivation`, `dateSupr`) VALUES
(5, 'amsif', 'alex.amsif@iut-rodez.fr', '996fbb1fc8c13fae5628ea5b0368c01e762716ff09aa1f27daa52974e7ccd3f7', 1, 0, 'alex', '2000-06-28', 'eb573aaf29403c2f7da65cd51a2e2b9d', NULL),
(6, 'borgi', 'tatiana.borgi@iut-rodez.fr', 'dc67409635f1a754ea8679220ae3cb604a3c5050320986de0375b583132b1a42', 1, 0, 'tatiana', '2000-07-02', 'e92f308bf4213f5acb36533e1786f7ef', NULL),
(8, 'zenone', 'zenonemathieu@gmail.com', 'be7af5e98ba30dce453ce5ed9aea66ca6cc299dfe322f6edd1631485199c9f5b', 3, 0, 'mathieu', '1999-10-02', '0fd7438014bdd06d8f3259ecc4a6f76b', NULL),
(18, 'zenone', 'mathieu.zenone@iut-rodez.fr', 'be7af5e98ba30dce453ce5ed9aea66ca6cc299dfe322f6edd1631485199c9f5b', 1, 0, 'mathieu', '1999-10-02', '6369204b04233a029689080c44862d69', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `emission`
--
ALTER TABLE `emission`
  ADD PRIMARY KEY (`id_emission`),
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
  MODIFY `id_emission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT pour la table `podcast`
--
ALTER TABLE `podcast`
  MODIFY `id_podcast` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id_theme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `emission`
--
ALTER TABLE `emission`
  ADD CONSTRAINT `fk_thme` FOREIGN KEY (`id_theme`) REFERENCES `theme` (`id_theme`);

--
-- Contraintes pour la table `podcast`
--
ALTER TABLE `podcast`
  ADD CONSTRAINT `FK_emmission` FOREIGN KEY (`id_emission`) REFERENCES `emission` (`id_emission`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
