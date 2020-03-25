-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 25 Mars 2020 à 17:36
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
(38, 13, 'Les chiens', 'on parle des chiens', 0, 0),
(39, 13, 'Les chats', 'On parle des chats', 0, 0),
(40, 13, 'Mr lapin', 'Mr Lapin nous raconte son histoire', 1, 0),
(41, 14, 'des oeuvre d\'art', 'De l\'Art', 0, 0),
(42, 15, 'Les couteaux', 'les couteaux', 0, 0),
(43, 15, 'Les fourchettes', 'Emission sur les fourchettes', 0, 0),
(44, 16, 'Muscu', 'kjnbgimjbmibhjbjmbjomjbimbpuimbuip', 0, 0),
(45, 16, 'muscuInterview', 'qqqqq', 1, 0),
(46, 13, 'les piaf', 'des piafs', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `podcast`
--

CREATE TABLE `podcast` (
  `id_podcast` int(11) NOT NULL,
  `id_emission` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `son` varchar(250) NOT NULL,
  `texte` text,
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `attente` tinyint(1) NOT NULL DEFAULT '0',
  `dateArchive` varchar(10) DEFAULT NULL,
  `dateCreation` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `podcast`
--

INSERT INTO `podcast` (`id_podcast`, `id_emission`, `id_utilisateur`, `image`, `son`, `texte`, `archive`, `attente`, `dateArchive`, `dateCreation`) VALUES
(1, 41, 8, 'NULL', '/ProjetRadioGit/ProjetRadioPhp/podcast/3225262d2974e10b71d39d8be6684790Artificial_Music_Atmosphere_ft_All_The_Pretty_Lights.mp3', 'NULL', 0, 0, NULL, '2020-03-25'),
(5, 40, 8, '/ProjetRadioGit/ProjetRadioPhp/podcast/8e3c5323c2ae0186e4b5d1355ddb7b99cochonInde.jpg', '/ProjetRadioGit/ProjetRadioPhp/podcast/b3941f267b81386eef6752ce447a6869Niwel_Bad_Love_Vocal_Edit.mp3', 'Le cochon d\'Inde (Cavia porcellus) est un rongeur de taille moyenne, appartenant à la famille des Caviidae et originaire d’Amérique Latine. C\'est l\'espèce domestiquée issue du cobaye sauvage appelé Cavia aperea. D\'abord élevé pour sa chair dans les pays andins, puis comme animal de laboratoire, le cobaye est aussi souvent adopté comme animal de compagnie par ceux qui apprécient son caractère calme et sa facilité d\'élevage.\r\n\r\nL\'espèce a été décrite pour la première fois en 1758.', 0, 0, NULL, '2020-03-25'),
(13, 38, 8, '/ProjetRadioGit/ProjetRadioPhp/podcast/024f1cf4faf64c742f37dd914f0adb3bchien.jpg', '/ProjetRadioGit/ProjetRadioPhp/podcast/0903065d0dc0a9730ab4fb15e51d022eLeGang_AnitaLatina.mp3', 'Le Chien (Canis lupus familiaris) est la sous-espèce domestique de Canis lupus, un mammifère de la famille des Canidés (Canidae), laquelle comprend également le Loup gris et le dingo, chien domestique retourné à l\'état sauvage.\r\n\r\nLe Loup est la première espèce animale à avoir été domestiquée par l\'Homme pour l\'usage de la chasse dans une société humaine paléolithique qui ne maîtrise alors ni l\'agriculture ni l\'élevage. La lignée du chien s\'est différenciée génétiquement de celle du Loup gris il y a environ 100 000 ans1, et les plus anciens restes confirmés de canidé différencié de la lignée du Loup sont vieux, selon les sources, de 33 000 ans2,3 ou de 12 000 ans4, donc antérieurs d\'au moins douze mille ans à ceux de toute autre espèce domestique connue. Depuis la Préhistoire, le chien a accompagné l\'être humain durant toute sa phase de sédentarisation, marquée par l\'apparition des premières civilisations agricoles. C\'est à ce moment qu\'il a acquis la capacité de digérer l\'amidon5, et que ses fonctions d\'auxiliaire d\'Homo sapiens se sont étendues. Ces nouvelles fonctions ont entraîné une différenciation accrue de la sous-espèce et l\'apparition progressive de races canines identifiables. Le chien est aujourd\'hui utilisé à la fois comme animal de travail et comme animal de compagnie. Son instinct de meute, sa domestication précoce et les caractéristiques comportementales qui en découlent lui valent familièrement le surnom de « meilleur ami de l\'Homme »6.\r\n\r\nCette place particulière dans la société humaine a conduit à l\'élaboration d\'une règlementation spécifique. Ainsi, là où les critères de la Fédération cynologique internationale ont une reconnaissance légale, l\'appellation chien de race est conditionnée à l\'enregistrement du chien dans les livres des origines de son pays de naissance7,8. Selon le pays, des vaccins peuvent être obligatoires et certains types de chien, jugés dangereux, sont soumis à des restrictions. Le chien est généralement soumis aux différentes législations sur les carnivores domestiques. C\'est notamment le cas en Europe, où sa circulation est facilitée grâce à l\'instauration du passeport européen pour animal de compagnie.', 0, 0, NULL, '2020-03-25'),
(14, 39, 8, '/ProjetRadioGit/ProjetRadioPhp/podcast/1943e59cf3aae40a48735d0d24acf641chat.jpg', '/ProjetRadioGit/ProjetRadioPhp/podcast/c1ab7c43eb5bdb97067f21b42bf79a7dNiwel_Bad_Love_Vocal_Edit.mp3', 'Le Chat domestique (Felis silvestris catus) est la sous-espèce issue de la domestication du Chat sauvage, mammifère carnivore de la famille des Félidés.\r\n\r\nIl est l’un des principaux animaux de compagnie et compte aujourd’hui une cinquantaine de races différentes reconnues par les instances de certification. Dans de très nombreux pays, le chat entre dans le cadre de la législation sur les carnivores domestiques à l’instar du chien et du furet. Essentiellement territorial, le chat est un prédateur de petites proies comme les rongeurs ou les oiseaux. Les chats ont diverses vocalisations dont les ronronnements, les miaulements, les feulements ou les grognements, bien qu’ils communiquent principalement par des positions faciales et corporelles et des phéromones.\r\n\r\nSelon les résultats de travaux menés en 2006 et 20071, le chat domestique est une sous-espèce du chat sauvage (Felis silvestris) issue d’ancêtres appartenant à la sous-espèce du chat sauvage d’Afrique (Felis silvestris lybica). Les premières domestications auraient eu lieu il y a 8 000 à 10 000 ans au Néolithique dans le Croissant fertile, époque correspondant au début de la culture de céréales et à l’engrangement de réserves susceptibles d’être attaquées par des rongeurs, le chat devenant alors pour l’Homme un auxiliaire utile se prêtant à la domestication.\r\n\r\nTout d’abord vénéré par les Égyptiens, il fut diabolisé en Europe au Moyen Âge et ne retrouva ses lettres de noblesse qu’au xviiie siècle. En Asie, le chat reste synonyme de chance, de richesse ou de longévité. Ce félin a laissé son empreinte dans la culture populaire et artistique, tant au travers d’expressions populaires que de représentations diverses au sein de la littérature, de la peinture ou encore de la musique.', 0, 0, NULL, '2020-03-25'),
(15, 41, 8, 'NULL', '/ProjetRadioGit/ProjetRadioPhp/podcast/f7232588eb544b90b2e239b5392f8466Niwel_Bad_Love_Vocal_Edit.mp3', 'Podcast future', 0, 0, NULL, '2021-03-07'),
(16, 41, 8, 'NULL', '/ProjetRadioGit/ProjetRadioPhp/podcast/b3642131fbfc88131165649000203c59Niwel_Bad_Love_Vocal_Edit.mp3', 'NULL', 0, 0, NULL, '2020-03-27'),
(17, 38, 8, 'NULL', '/ProjetRadioGit/ProjetRadioPhp/podcast/3a9566816ffb5d555efae5a0b3c4a631LeGang_AnitaLatina.mp3', 'NULL', 0, 0, NULL, '2020-03-25'),
(18, 46, 8, '/ProjetRadioGit/ProjetRadioPhp/podcast/d7b8c9889fc4fbe9d28023566d958f79cuicui.jpg', '/ProjetRadioGit/ProjetRadioPhp/podcast/679eed9049a308796f6f7c429fa62da8LeGang_AnitaLatina.mp3', 'Avec une envergure de 80 cm, le Pétrel de Kerguelen est un procellariiforme de taille moyenne. En vol, il montre d\'une part un corps compact et une grosse tête globuleuse car le cou est peu marqué et le front abrupt, et d\'autre part des ailes longues et fines, d\'où une silhouette particulière. Le plumage se caractérise par une teinte sombre générale. Dans de bonnes conditions de lumière, le dessus tend vers le gris argenté avec la queue et la pointe des ailes plus sombres que le reste. Dessous, l\'aspect est ... lire la suite (Rédigé par Quentin Guibert)', 0, 0, NULL, '2020-03-25');

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
(13, '/ProjetRadioGit/ProjetRadioPhp/Theme/b851ca58bb5ba4cfd58e9cbc0dcf3219chatMignon.jpg', 'Animaux', 0),
(14, '/ProjetRadioGit/ProjetRadioPhp/Theme/77cde6175d56d080a251a99f23cbb0beART.jpg', 'Art', 0),
(15, '/ProjetRadioGit/ProjetRadioPhp/Theme/d4482fe812b522895a40f996aacf52b6montagne.jpg', 'Cuisine là', 0),
(16, '/ProjetRadioGit/ProjetRadioPhp/Theme/6d4ce0b6d171f588c823183890863d9aSPORT.jpg', 'Sport', 0);

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
(20, 'mathieu', 'mathieu.zenone@iut-rodez.fr', 'be7af5e98ba30dce453ce5ed9aea66ca6cc299dfe322f6edd1631485199c9f5b', 1, 0, 'Zenone', '1999-10-02', '44dda09081121155399db979dd527d28', NULL);

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
  ADD KEY `id_emmision` (`id_emission`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

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
  MODIFY `id_emission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT pour la table `podcast`
--
ALTER TABLE `podcast`
  MODIFY `id_podcast` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `theme`
--
ALTER TABLE `theme`
  MODIFY `id_theme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
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
  ADD CONSTRAINT `FK_emmission` FOREIGN KEY (`id_emission`) REFERENCES `emission` (`id_emission`),
  ADD CONSTRAINT `FK_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
