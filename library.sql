-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2024 at 03:54 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`id20308759_pfe_library_db`@`%` PROCEDURE `del` ()   BEGIN
    update exemplaire join reservation on reservation.id_exp = exemplaire.id_ex set isissued = 0 where date_demande < DATE_SUB(NOW(), INTERVAL 48 HOUR) and statue_res is null;
    DELETE FROM reservation WHERE date_demande < DATE_SUB(NOW(), INTERVAL 48 HOUR) and statue_res is null;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nom_admin` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenom_admin` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass_admin` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom_admin`, `prenom_admin`, `email`, `pass_admin`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3'),
(2, 'admin2', 'admin2', 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `auteur`
--

CREATE TABLE `auteur` (
  `id_auteur` int(11) NOT NULL,
  `nom_auteur` varchar(30) DEFAULT NULL,
  `prenom_auteur` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auteur`
--

INSERT INTO `auteur` (`id_auteur`, `nom_auteur`, `prenom_auteur`) VALUES
(1, 'Haverbeke', 'Marjin'),
(4, 'Churcher', 'Clare '),
(8, 'Myers', 'Erick');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_cat` int(11) NOT NULL,
  `cat_nom` varchar(20) DEFAULT NULL,
  `image_cat` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_cat`, `cat_nom`, `image_cat`) VALUES
(11, 'Informatique', '529df92113b8f691067cd382be0b174d.jpg'),
(12, 'Physiques', '5d8b0ea769e1286bb02956433ac178b2.jpg'),
(13, 'Mathematiques', '808db45c553395e6b304ff12b95f45ee.jpg'),
(14, 'Economie', '2a683624a8bb9c533304d61556cb7673.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

CREATE TABLE `etudiant` (
  `id_etu` int(11) NOT NULL,
  `CNE` varchar(10) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `status_cmpt` tinyint(1) DEFAULT NULL,
  `id_fil` int(11) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `etudiant`
--

INSERT INTO `etudiant` (`id_etu`, `CNE`, `nom`, `prenom`, `email`, `pass`, `status_cmpt`, `id_fil`, `otp`, `otp_expiry`) VALUES
(2, 'jt102256', 'Igourramen', 'Marouane', 'alielouankrimi@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 1, '21692', '2023-05-15 16:19:38'),
(12, 'D132252275', 'Oubella', 'Abdallah', 'aoubella88@gmail.com', 'e5f874580ceab0457e7b140eb014fd17', 1, 1, NULL, NULL),
(13, 'jt5555', 'ahmed', 'igourramen', 'ahmed@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 3, NULL, NULL),
(14, 'D5555', 'intazga', 'hicham', 'hichamintazga@gmail.com', '25d55ad283aa400af464c76d713c07ad', 1, 1, NULL, NULL),
(16, 'C24680', 'Berrada', 'Youssef', 'youssef.berrada@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 1, NULL, NULL),
(17, 'D13579', 'El Moussaoui', 'Sara', 'sara.elmoussaoui@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 3, NULL, NULL),
(18, 'E97531', 'Mounir', 'Ahmed', 'ahmed.mounir@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 2, NULL, NULL),
(19, 'F86420', 'Khalil', 'Nadia', 'nadia.khalil@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 3, NULL, NULL),
(20, 'G75309', 'Rahmouni', 'Omar', 'omar.rahmouni@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 2, NULL, NULL),
(21, 'H64218', 'Lamrani', 'Amina', 'amina.lamrani@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 1, NULL, NULL),
(22, 'I53127', 'Oulad Ali', 'Hassan', 'hassan.ouladali@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 2, NULL, NULL),
(23, 'J42036', 'Chakir', 'Saida', 'saida.chakir@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 3, NULL, NULL),
(24, 'K13579', 'El Bouzidi', 'Soukaina', 'soukaina.elbouzidi@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 1, NULL, NULL),
(25, 'L97531', 'Moussaoui', 'Reda', 'reda.moussaoui@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 2, NULL, NULL),
(26, 'M86420', 'Kadiri', 'Laila', 'laila.kadiri@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 3, NULL, NULL),
(27, 'N75309', 'Bouchra', 'Fadwa', 'fadwa.bouchra@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 2, NULL, NULL),
(28, 'O64218', 'Sahli', 'Karima', 'karima.sahli@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 1, NULL, NULL),
(29, 'P53127', 'Abdellah', 'Abdelilah', 'abdelilah.abdellah@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 2, NULL, NULL),
(30, 'Q42036', 'Zakaria', 'Aicha', 'aicha.zakaria@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 3, NULL, NULL),
(31, 'R30945', 'Rahimi', 'Hicham', 'hicham.rahimi@example.com', '25d55ad283aa400af464c76d713c07ad', 1, 1, NULL, NULL),
(32, 'cne', 'test', 'tt', 'test@gmail.com', '07da0f1d3bc632b4cc0ee9b9dd139a20', 1, 2, NULL, NULL),
(33, 'JT1022', 'igourramen', 'marwane', 'igourramenmarwane@gmail.com', '3ab36b23c66e715534d8d6aa78f2f942', 1, 2, NULL, NULL),
(34, 'alialiali', 'EL OUANKRIMI', 'Ali', 'alielouankrimi2@gmail.com', 'fa377a1337126da4e11ee722242c7ba9', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exemplaire`
--

CREATE TABLE `exemplaire` (
  `id_ex` varchar(60) NOT NULL,
  `ISBN` varchar(60) NOT NULL,
  `isissued` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `exemplaire`
--

INSERT INTO `exemplaire` (`id_ex`, `ISBN`, `isissued`) VALUES
('1', '1423698521452', 0),
('12', '9780692614914', 0),
('123456', '9781484219553', 1),
('2', '1423698521452', 1),
('45s5q5s4q6qs', '12448635562', 1),
('515dfdf', '2574136585214', 0),
('65456dfg46df', '12448635562', 1),
('6865y4654tyu', '2574136585214', 1),
('h5f6g4h65fg4', '8880692614456', 1),
('LIV-0001', '9781484219553', 1),
('LIV-0002', '9781484219553', 1),
('LIV-0003', '9781484219553', 0),
('LIV-0004', '9781484219553', 0),
('LIV-0005', '9781484219553', 0),
('yj5hg25j6gh', '9780692614914', 0);

-- --------------------------------------------------------

--
-- Table structure for table `favoris`
--

CREATE TABLE `favoris` (
  `CNE` varchar(10) NOT NULL,
  `ISBN` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `favoris`
--

INSERT INTO `favoris` (`CNE`, `ISBN`) VALUES
('D132252275', '1423698521452'),
('D132252275', '2574136585214'),
('jt102256', '1423698521452'),
('jt102256', '2574136585214'),
('jt102256', '9780692614914');

-- --------------------------------------------------------

--
-- Table structure for table `filiere`
--

CREATE TABLE `filiere` (
  `id_fil` int(11) NOT NULL,
  `nom_fil` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `filiere`
--

INSERT INTO `filiere` (`id_fil`, `nom_fil`) VALUES
(1, 'Génie informatique'),
(2, 'Génie éléctrique'),
(3, 'Management des entreprises'),
(4, 'Énergie renouvelable');

-- --------------------------------------------------------

--
-- Table structure for table `livre`
--

CREATE TABLE `livre` (
  `id` int(6) UNSIGNED NOT NULL,
  `ISBN` varchar(60) NOT NULL,
  `id_cat` int(11) DEFAULT NULL,
  `image_livre` varchar(200) DEFAULT NULL,
  `num_page` int(11) DEFAULT NULL,
  `quant` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `id_aut` int(11) DEFAULT NULL,
  `nom_livre` varchar(100) DEFAULT NULL,
  `reserved` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `livre`
--

INSERT INTO `livre` (`id`, `ISBN`, `id_cat`, `image_livre`, `num_page`, `quant`, `description`, `id_aut`, `nom_livre`, `reserved`) VALUES
(7, '5580692614914', 11, '8703f15ee7c4719bc8fa6c5895ce823a.jpg', 125, 4, 'Préparez-vous à tester votre ouverture d\'esprit. Java - Tête la première mélange jeux, images, interviews et vous amène à être actif de différentes manières. Rapide, réel, concret et amusant.', 1, 'Eloquent Javascript', 45),
(8, '9780692614914', 11, 'b6bc68d752d816617a16bc31c2f67fb3.jpg', 200, 2, 'This is a book about Java, programming, and the wonders of the digital. You can read it online here, or buy your own paperback copy.\r\n\r\nWritten by Marijn Haverbeke.\r\n\r\nLicensed under a Creative Commons attribution-noncommercial license. All code in this book may also be considered licensed under an MIT license.\r\n\r\nIllustrations by various artists: Cover and chapter illustrations by Madalina Tantareanu. Pixel art in Chapters 7 and 16 by Antonio Perdomo Pastor. Regular expression diagrams in Chapter 9 generated with regexper.com by Jeff Avallone. Village photograph in Chapter 11 by Fabrice Creuzot. Game concept for Chapter 16 by Thomas Palef.', 1, 'Java For Beginners Guide', 12),
(9, '8880692614456', 11, 'da053032addccbd9a911717d4e5461ec.jpg', 111, 5, 'This is a book about C++, programming, and the wonders of the digital. You can read it online here, or buy your own paperback copy.\r\n\r\nWritten by Marijn Haverbeke.\r\n\r\nLicensed under a Creative Commons attribution-noncommercial license. All code in this book may also be considered licensed under an MIT license.\r\n\r\nIllustrations by various artists: Cover and chapter illustrations by Madalina Tantareanu. Pixel art in Chapters 7 and 16 by Antonio Perdomo Pastor. Regular expression diagrams in Chapter 9 generated with regexper.com by Jeff Avallone. Village photograph in Chapter 11 by Fabrice Creuzot. Game concept for Chapter 16 by Thomas Palef.\r\n', 8, 'C++ For Beginners	', 26),
(10, '9781484219553', 11, 'a8f7c88b8bc45114a95e677e97bbcf3d.jpg', 155, 18, 'Le livre commence par une introduction à la base de données et explique les différents types de données. Il aborde ensuite les requêtes de base telles que la sélection, le tri, le filtrage et la jointure de données à partir de différentes tables.\r\n\r\nLe livre aborde également des concepts plus avancés tels que les sous-requêtes, les fonctions SQL, la création de tables et l\'insertion de données. Les exemples fournis dans le livre sont basés sur la base de données Northwind, qui est largement utilisée dans l\'enseignement de SQL.\r\n\r\nL\'approche pédagogique de l\'auteur est claire et facile à suivre, avec des explications étape par étape et des exercices pratiques à la fin de chaque chapitre. Le livre est également accompagné d\'un fichier de données qui peut être utilisé pour pratiquer les requêtes SQL.', 4, 'Beginning SQL Queries', 106),
(11, '2574136585214', 13, 'cd18609a7bed431a3d97b43b8c356d39.webp', 80, 1, 'Feuilles de préparation innovantes pour aider les étudiants à se souvenir et à appliquer les concepts testés.', 1, 'Better Algebra for all', 162),
(12, '1423698521452', 12, '823f2e6ff9e243d4f4d7399c9cae7e78.jpg', 123, 1, 'An authoritative and unbiased guide to nuclear technology and the controversies that surround it.', 4, 'Nuclear choices', 121),
(16, '12448635562', 14, 'd2f467a23d95e810e10ec78371722f10.jpg', 350, 2, 'Le livre présente des concepts clés tels que la valeur intrinsèque, la marge de sécurité et la diversification. Graham explique comment les investisseurs peuvent utiliser ces concepts pour évaluer des entreprises et prendre des décisions d\'investissement rationnelles.\r\n\r\nL\'une des principales idées du livre est que les investisseurs devraient chercher à acheter des actions à un prix inférieur à leur valeur intrinsèque réelle, afin de s\'assurer une marge de sécurité en cas de baisse du marché. Graham utilise des exemples concrets pour illustrer comment les investisseurs peuvent appliquer cette stratégie dans la pratique.', 1, 'L\'investisseur Intelligent', 13);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id_res` int(11) NOT NULL,
  `id_exp` varchar(60) DEFAULT NULL,
  `CNE` varchar(10) DEFAULT NULL,
  `date_res` timestamp NULL DEFAULT NULL,
  `date_ret` datetime DEFAULT NULL,
  `statue_res` tinyint(1) DEFAULT NULL,
  `date_demande` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id_res`, `id_exp`, `CNE`, `date_res`, `date_ret`, `statue_res`, `date_demande`) VALUES
(115, '1', 'D132252275', NULL, NULL, 0, '2023-03-15 18:42:51'),
(117, 'LIV-0002', 'D132252275', '2023-03-18 00:02:47', '2023-03-20 00:25:28', 1, '2023-03-16 23:23:53'),
(121, '6865y4654tyu', 'jt102256', NULL, NULL, 0, '2023-03-17 19:36:03'),
(123, 'LIV-0002', 'D132252275', '2023-03-20 00:44:28', '2023-03-20 00:49:34', 1, '2023-03-20 00:44:19'),
(124, 'yj5hg25j6gh', 'JT102256', '2023-03-20 00:51:13', '2023-03-20 01:24:23', 1, '2023-03-20 00:51:13'),
(125, 'LIV-0002', 'JT5555', '2023-03-20 01:35:00', '2023-03-20 01:35:24', 1, '2023-03-20 01:35:00'),
(126, 'LIV-0002', 'D132252275', NULL, NULL, 0, '2023-03-20 02:00:27'),
(127, 'yj5hg25j6gh', 'D132252275', '2023-03-20 17:04:39', '2023-03-20 17:05:48', 1, '2023-03-20 17:04:39'),
(129, '45s5q5s4q6qs', 'jt5555', NULL, NULL, 0, '2023-03-21 13:12:25'),
(131, '515dfdf', 'jt5555', '2023-03-24 03:33:46', '2023-04-27 16:00:22', 1, '2023-03-24 03:30:47'),
(133, '1', 'JT5555', '2023-03-24 03:44:05', '2023-10-21 19:36:04', 1, '2023-03-24 03:44:05'),
(137, '65456dfg46df', 'P53127', '2023-04-05 11:11:51', NULL, 1, '2023-04-05 11:11:51'),
(138, '2', 'JT1022', NULL, NULL, 0, '2023-04-05 11:29:11'),
(139, 'LIV-0001', 'JT1022', '2023-04-05 11:31:15', NULL, 1, '2023-04-05 11:29:54'),
(140, '6865y4654tyu', 'alialiali', '2023-04-27 15:59:48', NULL, 1, '2023-04-27 15:59:35'),
(141, 'h5f6g4h65fg4', 'E97531', '2023-10-21 19:40:55', NULL, 1, '2023-10-21 19:40:55'),
(142, '123456', 'JT5555', '2023-11-21 15:22:08', NULL, 1, '2023-11-21 15:22:08'),
(143, 'LIV-0002', 'JT5555', '2023-11-21 15:22:20', NULL, 1, '2023-11-21 15:22:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`id_auteur`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_cat`);

--
-- Indexes for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id_etu`),
  ADD UNIQUE KEY `CNE` (`CNE`),
  ADD KEY `fk_fil` (`id_fil`);

--
-- Indexes for table `exemplaire`
--
ALTER TABLE `exemplaire`
  ADD PRIMARY KEY (`id_ex`,`ISBN`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Indexes for table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`CNE`,`ISBN`),
  ADD UNIQUE KEY `ISBN` (`ISBN`,`CNE`) USING BTREE;

--
-- Indexes for table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`id_fil`);

--
-- Indexes for table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `ISBN` (`ISBN`),
  ADD KEY `id_cat` (`id_cat`),
  ADD KEY `id_aut` (`id_aut`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_res`),
  ADD KEY `fk_res_exp` (`id_exp`),
  ADD KEY `fk_res_etd` (`CNE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `id_auteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_cat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id_etu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `id_fil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `livre`
--
ALTER TABLE `livre`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_res` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `fk_fil` FOREIGN KEY (`id_fil`) REFERENCES `filiere` (`id_fil`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exemplaire`
--
ALTER TABLE `exemplaire`
  ADD CONSTRAINT `fk_exp_liv` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `fk_fav_etd` FOREIGN KEY (`CNE`) REFERENCES `etudiant` (`CNE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fav_liv` FOREIGN KEY (`ISBN`) REFERENCES `livre` (`ISBN`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `fk_liv_cat` FOREIGN KEY (`id_cat`) REFERENCES `categorie` (`id_cat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `livre_ibfk_1` FOREIGN KEY (`id_aut`) REFERENCES `auteur` (`id_auteur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_res_etd` FOREIGN KEY (`CNE`) REFERENCES `etudiant` (`CNE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_res_exp` FOREIGN KEY (`id_exp`) REFERENCES `exemplaire` (`id_ex`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
