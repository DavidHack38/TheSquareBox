-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 01 Mai 2017 à 19:56
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
  `code_postal` varchar(255) DEFAULT NULL,
  `dimension` varchar(255) DEFAULT NULL,
  `prix` varchar(255) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `heure` varchar(255) DEFAULT NULL,
  `pic_id_user` varchar(255) DEFAULT NULL,
  `pic_idl` varchar(255) DEFAULT NULL,
  `pic_path` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `informations`
--

INSERT INTO `informations` (`primary_key_pls_ignore`, `id_of_user`, `id_logement`, `adresse1`, `adresse2`, `ville`, `code_postal`, `dimension`, `prix`, `commentaire`, `date`, `heure`, `pic_id_user`, `pic_idl`, `pic_path`) VALUES
(1, 111111, 'Md', '458', 'ghghgh', 'apprieu', '25896', '156', '55', 'srgfdg', '10/02/0255', '12:10', '2', 'Md', 'null'),
(31, 1, 'A4', NULL, NULL, NULL, '38134', '255', '100000', NULL, '11/04/2017', '17:13:01', NULL, NULL, NULL),
(33, 1, 'A6', NULL, NULL, NULL, '99999', '999', '999999', NULL, '11/04/2017', '17:22:20', NULL, NULL, NULL),
(32, 1, 'A5', NULL, NULL, NULL, '33333', '333', '555555', NULL, '11/04/2017', '17:19:28', NULL, NULL, NULL),
(2, 2, 'A1', 'adrtest', '', 'Apprieu', '38140', '75', '100000', 'ma maison', '11/04/2017', '17:24:59', '1', 'A1', NULL),
(3, 60, 'A2', '458', '569', 'poil', '25896', '123', '55', 'srgfdg', '10/02/0255', '12:10', '60', 'A2', NULL),
(34, 1, 'A7', NULL, NULL, NULL, '11111', '111', '111111', NULL, '11/04/2017', '17:25:13', NULL, NULL, NULL),
(30, 1, 'A3', 'HTC', 'VW', 'paris', '2525', '58', '1000000', 'je vous pouvez venir le diapo', '11/04/2017', '16:52:55', '1', 'A3', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id_user` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `motdepasse` text NOT NULL,
  `PIN` int(4) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `heure` varchar(255) DEFAULT NULL,
  `mail_key` varchar(255) DEFAULT NULL,
  `confirm_by_mail` varchar(255) NOT NULL,
  `admin` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id_user`, `pseudo`, `mail`, `motdepasse`, `PIN`, `avatar`, `date`, `heure`, `mail_key`, `confirm_by_mail`, `admin`) VALUES
(1, 'ioio', 'fgfg@oo.ii', '92cfceb39d57d914ed8b14d0e37643de0797ae56', 1111, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'TRUE'),
(2, 'DavidHack38', 'pierro.david038@gmail.com', '00d70c561892a94980befd12a400e26aeb4b8599', 6985, 'DavidHack38.png', NULL, NULL, NULL, 'TRUE', 'TRUE'),
(3, 'Zunkusem', 'jeremi04@hotmail.fr', '6b6277afcb65d33525545904e95c2fa240632660', 8965, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'TRUE'),
(4, 'yolopatalo', 'mailtest@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 5486, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(5, 'test2', 'test2@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 1053, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(6, 'test3', 'yolo@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 4865, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(57, 'test4', 'mty@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 2458, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(58, 'testtest', 'pio@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 4588, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(59, 'testest', 'pioo@oo.ii', 'df5fe22a5f8fb50cc3bd59f34a438bc6dddb52a3', 5866, 'testest.jpeg', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(60, 'mdrr', 'mdp@oo.ii', '00d70c561892a94980befd12a400e26aeb4b8599', 5578, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(61, 'dddd', 'dd@oo.ii', '9c969ddf454079e3d439973bbab63ea6233e4087', 2568, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(62, 'gdfgdf', 'gfff@oo.ii', '00d70c561892a94980befd12a400e26aeb4b8599', 8778, 'default_profil.png', NULL, NULL, NULL, 'TRUE', 'FALSE'),
(111111, 'testing', 'ter@oo.ii', '9c71939f6751fd3c247f1ced403650a4bf23fa53', 5555, 'default_profil.png', '25/04/2017', '12:55:35', NULL, 'TRUE', 'FALSE'),
(111122, 'erer', 'erer@ii.tr', '428598e57095aa7a7637a72bc1c9b557a0723ca3', 1478, 'default_profil.png', '27/04/2017', '17:04:41', 'ukq4tyixoz1d6lb', 'TRUE', 'FALSE'),
(111124, 'nnb', 'nbn@ii.jj', '0ba0ffa01f6be27eb6406bd086e68a8590be1981', 4785, 'default_profil.png', '27/04/2017', '18:13:05', 'h5ux840hwidb4by', 'FALSE', 'FALSE'),
(111127, 'testmail', 'hghghh@oo.jj', '30ae2df4912f1b431cbbb027d7ad6a1395ca5db5', 1478, 'default_profil.png', '27/04/2017', '18:34:03', 'ynchq58lmpwl71m', 'FALSE', 'FALSE'),
(111135, 'iii', 'iii@oo.ll', '186154712b2d5f6791d85b9a0987b98fa231779c', 5744, 'default_profil.png', '30/04/2017', '17:34:29', 'sgd9fzmxfgetgp6', 'FALSE', 'FALSE');

-- --------------------------------------------------------

--
-- Structure de la table `mesures`
--

CREATE TABLE `mesures` (
  `Primary_Key_plz_ignore` int(11) NOT NULL,
  `id_of_user` int(11) NOT NULL,
  `id_logement` varchar(255) NOT NULL,
  `increm_name_backup` int(11) DEFAULT '0',
  `increm_idl` int(11) DEFAULT '1',
  `longueur_salon` varchar(255) DEFAULT NULL,
  `largeur_salon` varchar(255) DEFAULT NULL,
  `surface_salon` varchar(255) DEFAULT NULL,
  `longueur_cuisine` varchar(255) DEFAULT NULL,
  `largeur_cuisine` varchar(255) DEFAULT NULL,
  `surface_cuisine` varchar(255) DEFAULT NULL,
  `longueur_sdb` varchar(255) DEFAULT NULL,
  `largeur_sdb` varchar(255) DEFAULT NULL,
  `surface_sdb` varchar(255) DEFAULT NULL,
  `longueur_chambre` varchar(255) DEFAULT NULL,
  `largeur_chambre` varchar(255) DEFAULT NULL,
  `surface_chambre` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `mesures`
--

INSERT INTO `mesures` (`Primary_Key_plz_ignore`, `id_of_user`, `id_logement`, `increm_name_backup`, `increm_idl`, `longueur_salon`, `largeur_salon`, `surface_salon`, `longueur_cuisine`, `largeur_cuisine`, `surface_cuisine`, `longueur_sdb`, `largeur_sdb`, `surface_sdb`, `longueur_chambre`, `largeur_chambre`, `surface_chambre`) VALUES
(12, 4, 'ard_4', 0, 1, '0.1212', '8.88', '1.08', '0', '0', '0.00', '0', '0', '0.00', '0', '0', '1.08'),
(13, 111111, 'ard_111111', 2, 1, '5.2598', '0.05', '0.26', '0', '0', '0.00', '0', '0', '0.00', '0', '0', '0.26'),
(11, 2, 'ard_2', 0, 1, '5.259', '0.086', '0.45', '0', '0', '0.00', '0', '0', '0.00', '0', '0', '0.45'),
(15, 1, 'ard_1', 1, 1, '5.2579', '5.2578', '27.64', '0.585', '5.873', '7982.2', '8.575', '2.872', '85.7', '7.912', '0.855', '27.64');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`primary_key_pls_ignore`),
  ADD UNIQUE KEY `id_logement` (`id_logement`),
  ADD UNIQUE KEY `id_logement_2` (`id_logement`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `mesures`
--
ALTER TABLE `mesures`
  ADD PRIMARY KEY (`Primary_Key_plz_ignore`),
  ADD UNIQUE KEY `id_logement` (`id_logement`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `informations`
--
ALTER TABLE `informations`
  MODIFY `primary_key_pls_ignore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111136;
--
-- AUTO_INCREMENT pour la table `mesures`
--
ALTER TABLE `mesures`
  MODIFY `Primary_Key_plz_ignore` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
