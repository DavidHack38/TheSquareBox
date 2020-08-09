-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 02 Avril 2017 à 10:44
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_square_box`
--
CREATE DATABASE IF NOT EXISTS `projet_square_box` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projet_square_box`;

-- --------------------------------------------------------

--
-- Structure de la table `informations`
--

CREATE TABLE `informations` (
  `primary_key_pls_ignore` int(11) NOT NULL,
  `id_of_user` int(11) DEFAULT NULL,
  `id_logement` varchar(255) DEFAULT NULL,
  `adresse1` varchar(255) DEFAULT NULL,
  `adresse2` varchar(255) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `code_postal` int(11) DEFAULT NULL,
  `dimension` int(11) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `heure` varchar(255) DEFAULT NULL,
  `pic_id_user` int(11) DEFAULT NULL,
  `pic_idl` int(11) DEFAULT NULL,
  `pic_path` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `informations`
--

INSERT INTO `informations` (`primary_key_pls_ignore`, `id_of_user`, `id_logement`, `adresse1`, `adresse2`, `ville`, `code_postal`, `dimension`, `prix`, `commentaire`, `date`, `heure`, `pic_id_user`, `pic_idl`, `pic_path`) VALUES
(1, 5, 'Md', '458', '', 'apprieu', 25896, NULL, 55, 'srgfdg', '10/02/0255', '12:10', NULL, NULL, NULL),
(2, 2, 'A1', '458', '4646464646464', 'apprieu', 25896, 123, 55, 'srgfdg', '10/02/0255', '12:10', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id_user` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `motdepasse` text NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `confirm_by_mail` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id_user`, `pseudo`, `mail`, `motdepasse`, `avatar`, `confirm_by_mail`, `admin`) VALUES
(1, 'ioio', 'fgfg@oo.ii', '92cfceb39d57d914ed8b14d0e37643de0797ae56', 'default_profil.png', 'TRUE', 'FALSE'),
(2, 'DavidHack38', 'pierro.david038@gmail.com', '00d70c561892a94980befd12a400e26aeb4b8599', 'DavidHack38.png', 'TRUE', 'TRUE'),
(3, 'Zunkusem', 'jeremi04@hotmail.fr', '6b6277afcb65d33525545904e95c2fa240632660', 'default_profil.png', 'TRUE', 'TRUE'),
(4, 'yolopatalo', 'mailtest@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 'default_profil.png', 'TRUE', 'TRUE'),
(5, 'test2', 'test2@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 'default_profil.png', 'TRUE', 'FALSE'),
(6, 'test3', 'yolo@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 'default_profil.png', 'TRUE', 'FALSE'),
(57, 'test4', 'mty@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 'default_profil.png', 'TRUE', 'FALSE'),
(58, 'testtest', 'pio@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 'default_profil.png', 'TRUE', 'FALSE'),
(59, 'testest', 'pioo@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 'testest.jpeg', 'TRUE', 'FALSE'),
(60, 'mdrr', 'mdp@oo.ii', '00d70c561892a94980befd12a400e26aeb4b8599', 'default_profil.png', 'TRUE', 'FALSE'),
(61, 'dddd', 'dd@oo.ii', '9c969ddf454079e3d439973bbab63ea6233e4087', 'default_profil.png', 'TRUE', 'FALSE'),
(62, 'gdfgdf', 'gfff@oo.ii', '00d70c561892a94980befd12a400e26aeb4b8599', 'default_profil.png', 'TRUE', 'FALSE'),
(63, 'trtr', 'trtr@oo.ii', '70f94d141203bdbfa777dd2e745bca3f6ab80d8f', 'default_profil.png', 'TRUE', 'FALSE');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`primary_key_pls_ignore`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `informations`
--
ALTER TABLE `informations`
  MODIFY `primary_key_pls_ignore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
