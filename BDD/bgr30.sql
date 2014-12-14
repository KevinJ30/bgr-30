-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 14 Décembre 2014 à 09:11
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `bgr30`
--

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `heure_start` time NOT NULL,
  `heure_end` time NOT NULL,
  `description` text NOT NULL,
  `lieu` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `contact` varchar(255) NOT NULL,
  `adresse` text NOT NULL,
  `mail` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `lien` text NOT NULL,
  `actif` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `events`
--

INSERT INTO `events` (`id`, `title`, `date_start`, `date_end`, `heure_start`, `heure_end`, `description`, `lieu`, `category_id`, `contact`, `adresse`, `mail`, `phone`, `lien`, `actif`) VALUES
(1, 'essai', '2014-12-02', '2014-12-26', '21:02:13', '09:00:00', 'essai d''un évenment.', 'bagnols', 6, 'Kevin', '2, impasse bagnoli', 'kev.joudrier@gmail.com', '0466798757', '', 1),
(2, 'damien', '2014-12-01', '2014-12-01', '08:00:00', '09:00:00', 'essai de damien', 'bagnols', 6, 'kevin', '', 'kev.joudrier@gmail.com', '', '', 1),
(3, 'essai', '2014-12-03', '2014-12-03', '08:50:00', '09:51:00', 'qsdqsdsqd', 'qsdqsdq', 7, 'qsdqsd', 'qsdqsdqsd', 'qsdqsd', 'qsdqsd', 'qsdqsd', 1),
(4, 'essai dimanche', '2014-12-10', '2014-12-10', '08:00:04', '09:00:04', 'qsdqsdsqd', 'qsdqsd', 7, 'qsdsqd', 'qsdsqdsqd', 'kev.joudrier@orange.fr', '0466798757', 'qsdsqd', 1);

-- --------------------------------------------------------

--
-- Structure de la table `events_categories`
--

CREATE TABLE IF NOT EXISTS `events_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `actif` int(11) DEFAULT '1',
  `defaut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `events_categories`
--

INSERT INTO `events_categories` (`id`, `name`, `color`, `actif`, `defaut`) VALUES
(6, 'Kevin', 'rouge', 1, 0),
(7, 'Tournois', 'Bleu', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'image',
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `menus`
--

INSERT INTO `menus` (`id`, `name`, `count`) VALUES
(6, 'essai', 0),
(7, 'essai2', 0);

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created` date NOT NULL,
  `status` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `accueil` int(11) NOT NULL DEFAULT '0',
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `pages`
--

INSERT INTO `pages` (`id`, `title`, `date`, `content`, `status`, `accueil`, `menu_id`) VALUES
(1, 'Accueil', '0000-00-00', 'Bonjour, je vous souhaite la bienvenue sur la page d''accueil du site.\r\n\r\nMerci de me contacter en cas de problèmes avec la page.', 1, 0, 0),
(2, 'qqqq', '0000-00-00', '&lt;p&gt;qqqqqq&lt;/p&gt;', 1, 0, 0),
(3, 'qqqq', '0000-00-00', '&lt;p&gt;qqqqqq&lt;/p&gt;', 1, 0, 0),
(4, 'bbbb', '0000-00-00', '<p>bbbbbb<span style="color: #ff0000;">bbbbbb</span></p>', 1, 0, 6),
(5, 'kevin', '0000-00-00', '<p>Test de l''editeur avec <strong>Joudrier Kevin</strong> devellopeur web depuis plus de 5 ans.</p>', 1, 0, 7),
(6, 'kkk', '0000-00-00', '<p>Kevin test de l''editeur. J''espere que l<span style="color: #ff0000;">e test marche avant de demonter l''ordi.</span></p>', 1, 0, 6),
(7, 'kkkkk', '0000-00-00', '<p><strong>stronsssqsdqsdsqdsq</strong><span style="color: #ff0000;">d</span></p>', 1, 1, 0),
(8, 'Joudrier Kevin', '0000-00-00', '<p>Voici un test de<span style="color: #ff0000;"> l''editeur et de la gestion des pages d''accueil.</span></p>', 1, 1, 0),
(9, 'ZZZZZZZZZZzzzzzzzzzzzZZZZZZZZZZZZZZ', '2014-12-02', '<p>qsdqsdqsdqsdqsdqsdsssssss</p>', 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `pouna`
--

CREATE TABLE IF NOT EXISTS `pouna` (
  `identifiant` int(5) DEFAULT NULL,
  `sexe` varchar(1) DEFAULT NULL,
  `civilite` varchar(4) DEFAULT NULL,
  `nom` varchar(10) DEFAULT NULL,
  `prenom` varchar(15) DEFAULT NULL,
  `dateNaissance` varchar(10) DEFAULT NULL,
  `adresseCourrier-pointRemise` varchar(8) DEFAULT NULL,
  `adresseCourrier-localisation` varchar(36) DEFAULT NULL,
  `adresseCourrier-adresse` varchar(31) DEFAULT NULL,
  `adresseCourrier-distribution` varchar(21) DEFAULT NULL,
  `adresseCourrier-codePostal` int(5) DEFAULT NULL,
  `adresseCourrier-ville` varchar(24) DEFAULT NULL,
  `adresseCourrier-cedex` varchar(10) DEFAULT NULL,
  `adresseCourrier-pays` varchar(6) DEFAULT NULL,
  `mailContact` varchar(27) DEFAULT NULL,
  `telContact` varchar(14) DEFAULT NULL,
  `licence` int(8) DEFAULT NULL,
  `typeLicence` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contient les numéro de licence';

--
-- Contenu de la table `pouna`
--

INSERT INTO `pouna` (`identifiant`, `sexe`, `civilite`, `nom`, `prenom`, `dateNaissance`, `adresseCourrier-pointRemise`, `adresseCourrier-localisation`, `adresseCourrier-adresse`, `adresseCourrier-distribution`, `adresseCourrier-codePostal`, `adresseCourrier-ville`, `adresseCourrier-cedex`, `adresseCourrier-pays`, `mailContact`, `telContact`, `licence`, `typeLicence`) VALUES
(29431, 'H', 'M.', 'ARRACHART', 'Guilhem', '27-03-1979', '', '', '619 Rte de St G', '', 30126, 'Saint-Laurent-des-Arbres', '', 'FRANCE', 'guilhem.arrachart@cea.fr', '0430390894', 6743778, 'Licence Adulte Joueur'),
(29410, 'H', 'M.', 'CASTELLANI', 'R', '15-10-1970', '', '', '31 Rue Andr', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'regis3430@gmail.com', '0684483853', 6834584, 'Licence Adulte Joueur'),
(29423, 'H', 'M.', 'CLEMENT', 'Jean-christophe', '19-04-1968', '', 'R', '85 Avenue Louis Pasteur', '', 30400, 'Villeneuve-l', '', 'FRANCE', 'clement.jcc@orange.fr', '0685932393', 348999, 'Licence Adulte Joueur'),
(29426, 'H', 'M.', 'COLLEVILLE', 'Mickael', '10-02-1990', '', '', '71 rue cdt Vigan Braquet', '', 30130, 'Pont-Saint-Esprit', '', 'FRANCE', 'mica.colleville@gmail.com', '0642756736', 6486035, 'Licence Adulte Joueur'),
(29436, 'H', 'M.', 'DAANEN', 'Valentin', '29-01-2002', '', '', 'CHEMIN DES COMEYRES', '', 30126, 'Tavel', '', 'FRANCE', '', '0466503836', 6885755, 'Licence Jeune Joueur'),
(29440, 'H', 'M.', 'DAANEN', 'Jean-pierre', '01-11-1966', '', '', 'CHEMIN DES COMEYRES', '', 30126, 'Tavel', '', 'FRANCE', 'jpdnn@orange.fr', '0466503836', 486872, 'Licence Adulte Joueur'),
(29446, 'F', 'Mlle', 'DAANEN', 'Alexandra', '02-04-1994', '', '', 'CHEMIN DES COMEYRES', '', 30126, 'Tavel', '', 'FRANCE', 'JPDNN@ORANGE.FR', '0466503836', 509198, 'Licence Adulte Joueur'),
(29418, 'F', 'Mme', 'DAVID', 'Corinne', '07-12-1965', '', '', '81 Route De Bagnols', '', 30150, 'Saint-Geni', '', 'FRANCE', 'corinne.david30@orange.fr', '0466330211', 501889, 'Licence Adulte Joueur'),
(29381, 'F', 'Mme', 'FRAISSE', 'Elodie', '08-03-1983', '', '', '657 chemin de la baraill', '', 30200, 'Sabran', '', 'FRANCE', 'elodiefraisse@hotmail.fr', '0612630116', 6894361, 'Licence Adulte Joueur'),
(29382, 'F', 'Mme', 'GENTY', 'Muriel', '27-04-1971', '', '', '540 Chemin de la grange Soulier', '', 30200, 'V', '', 'FRANCE', 'dr.mu@free.fr', '0466399523', 6858877, 'Licence Adulte Joueur'),
(29383, 'F', 'Mlle', 'GENTY', 'Julia', '19-07-2002', '', '', '540 chemin de la grange soulier', '', 30200, 'V', '', 'FRANCE', 'dr.mu@free.fr', '0466399523', 6880693, 'Licence Jeune Joueur'),
(29384, 'F', 'Mlle', 'GENTY', 'Marion', '20-04-2001', '', '', '540 chemin de la grange soulier', '', 30200, 'V', '', 'FRANCE', 'Dr.mu@free.fr', '0466399523', 6885757, 'Licence Jeune Joueur'),
(19352, 'H', 'M.', 'GIROUD', 'Philippe', '30-12-1968', '', '', '650 Route De Bagnols', 'Les Hors', 30200, 'V', '', 'FRANCE', '', '0466794245', 6706, 'Licence Adulte Non Joueur'),
(19353, 'H', 'M.', 'JOUDRIER', 'Patrick', '02-03-1953', '', '', '21 Allee Du Romarin', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'pat.joudrier@orange.fr', '0466798757', 550061, 'Licence Adulte Non Joueur'),
(29385, 'H', 'M.', 'KUKIELA', 'Przemyslaw', '03-11-1981', '', '', '657 chemin de la Baraill', '', 30200, 'Sabran', '', 'FRANCE', 'piotr.kukiela@hotmail.fr', '0624662042', 6466287, 'Licence Adulte Joueur'),
(29402, 'F', 'Mlle', 'LEFEVRE', 'Karine', '22-01-1978', '', '', '10 Impasse la Ch', 'Mont', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'lefevre.kar@gmail.com', '0623156524', 324598, 'Licence Adulte Joueur'),
(13257, 'F', 'Mlle', 'MERCEILLE', 'Aur', '14-03-1986', '', '', '3, Rue du Casino', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'aurelie.merceille@gmail.com', '0664327952', 6739005, 'Licence Adulte Joueur'),
(17205, 'H', 'M.', 'MONTET', 'Eric', '08-11-1962', '', '', '19 impasse des rouvi', 'quartier le grangette', 30200, 'Saint-Nazaire', '', 'FRANCE', 'eric.montet@aliceadsl.fr', '0950463436', 6489611, 'Licence Adulte Joueur'),
(29386, 'F', 'M.', 'MUYS', 'St', '23-10-1979', '', '', '15 rue bompart', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'muys@voila.fr', '06 68 86 41 51', 6694777, 'Licence Adulte Joueur'),
(29449, 'H', 'M.', 'PEYRIERE', 'Arnaud', '18-10-1977', '', '', '390 chemin du Pas de Gicon', '', 30200, 'Chusclan', '', 'FRANCE', 'arnaud.peyriere@laposte.net', '0466820745', 6683177, 'Licence Adulte Joueur'),
(29478, 'H', 'M.', 'POPEK', 'Erik', '27-12-1999', '', '', 'place du pr', '', 30126, 'Tavel', '', 'FRANCE', 'domaine.mejan@orange.fr', '0466500402', 6817707, 'Licence Jeune Joueur'),
(14786, 'F', 'Mlle', 'QUINQUIS', 'Fanny', '14-08-1985', 'Appt 426', 'Bat D1 - R', '2 Impasse Verlaine', '', 84000, 'Avignon', '', 'FRANCE', 'fanny.quinquis@gmail.com', '0666902216', 6626748, 'Licence Adulte Joueur'),
(29428, 'F', 'Mlle', 'REY', 'Cyrielle', '26-03-1984', '', '', '619 Rte de St G', '', 30126, 'Saint-Laurent-des-Arbres', '', 'FRANCE', 'rey.cyrielle@gmail.com', '0632533507', 6743774, 'Licence Adulte Joueur'),
(13240, 'F', 'Mlle', 'RUSSELLO', 'Emilie', '26-08-1988', '', 'N', 'Chemin du Docteur Rouques', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'emilierussello@hotmail.fr', '', 6694788, 'Licence Adulte Joueur'),
(13241, 'H', 'M.', 'SERVE', 'Guillaume', '26-07-1986', '', '', '3 RUE DU CASINO', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'GUIMSERVE@HOTMAIL.COM', '0618783723', 6672355, 'Licence Adulte Joueur'),
(13242, 'H', 'M.', 'SOULIER', 'Vincent', '28-10-1982', '', 'MAS DE FIGUIERES', 'CHEMIN CLAU DE LA GARDE', '', 30200, 'V', '', 'FRANCE', 'soulier.vincent@voila.fr', '0786270647', 507665, 'Licence Adulte Joueur'),
(13243, 'H', 'M.', 'TOSO', 'Patrice', '05-06-1960', '', '', '13 rue des grillons', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'patrice.toso@orange.fr', '0466897969', 6548617, 'Licence Adulte Joueur'),
(19356, 'H', 'M.', 'VERON', 'Gilles', '12-01-1957', '', '', 'Chemin D Avelan', '', 30330, 'Connaux', '', 'FRANCE', 'gillesveron@wanadoo.fr', '0612376938', 544167, 'Licence Adulte Non Joueur'),
(17175, 'H', 'M.', 'YAYLA', 'Sinan', '01-12-1994', '', '', '71 ter rue de lamargue', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'yayla.sinan25@gmail.com', '0466500039', 6730828, 'Licence Adulte Joueur'),
(17176, 'H', 'M.', 'YAYLA', 'Adnan', '05-06-1997', '', '', '71 ter rue de lamargue', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'yayla.adnan5@gmail.com', '0466500039', 6716712, 'Licence Jeune Joueur'),
(29406, 'H', 'M.', 'YAYLA', 'Mika', '21-09-2000', '', '', '71 ter rue de lamargue', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'yayla.emine@free.fr', '0466500039', 6716724, 'Licence Jeune Joueur'),
(29407, 'H', 'M.', 'YAYLA', 'Ilan', '19-04-2002', '', '', '71 ter rue de lamargue', '', 30200, 'Bagnols-sur-C', '', 'FRANCE', 'yayla.emine@free.fr', '0466500039', 6716714, 'Licence Jeune Joueur');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tmp_password` varchar(255) DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `licence` varchar(255) DEFAULT NULL COMMENT 'Contient le numéro de licence de la personne qui s''inscrit',
  `created` date NOT NULL,
  `permission` varchar(50) NOT NULL DEFAULT 'membre',
  `active` int(11) NOT NULL DEFAULT '0',
  `banned` int(11) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL COMMENT 'Contient le chemin de l''avatar',
  `type_token` varchar(50) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `licence` (`licence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `tmp_password`, `nom`, `prenom`, `mail`, `licence`, `created`, `permission`, `active`, `banned`, `avatar`, `type_token`, `token`) VALUES
(26, 'patricks', '9d85c7b1a73232b326860da3eb2eedc54d250038', NULL, 'Joudrier', 'patrick', 'kev.joudrier@gmail.com', '550061', '2014-10-16', 'membre', 1, 0, NULL, NULL, NULL),
(49, 'KevinJ30', 'bffdb794723a8ddec6aa84090560fd2765736ee1', NULL, 'Joudrier', 'Kevin', '', NULL, '2014-10-24', 'admin', 1, 0, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
