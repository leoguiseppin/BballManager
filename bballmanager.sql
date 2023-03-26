-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 26 mars 2023 à 21:43
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `basketball`
--

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `NumeroLicence` char(10) COLLATE utf8_bin NOT NULL,
  `Nom` varchar(25) COLLATE utf8_bin NOT NULL,
  `Prenom` varchar(25) COLLATE utf8_bin NOT NULL,
  `Photo` varchar(50) COLLATE utf8_bin NOT NULL,
  `DateNaissance` date NOT NULL,
  `Taille` smallint(6) NOT NULL,
  `Poids` smallint(6) NOT NULL,
  `Poste` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`NumeroLicence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`NumeroLicence`, `Nom`, `Prenom`, `Photo`, `DateNaissance`, `Taille`, `Poids`, `Poste`) VALUES
('AI26485874', 'Iguodala', 'Andre', 'andre_iguodala.png', '1984-01-28', 198, 98, 'Ailier'),
('AW26480458', 'Wiggins', 'Andrew', 'andrew_wiggins.png', '1995-02-23', 201, 90, 'Ailier'),
('DD75181271', 'DiVicenzo', 'Donte', 'donte_divicenzo.png', '1997-01-31', 193, 92, 'Arriere'),
('DG26548548', 'Green', 'Draymond', 'draymond_green.png', '1990-03-04', 198, 105, 'Pivot'),
('JG14224512', 'Green', 'JaMychal', 'jamychal_green.png', '1990-06-21', 203, 103, 'Ailier fort'),
('JK13462454', 'Kuminga', 'Jonathan', 'jonathan_kuminga.png', '2002-01-31', 201, 102, 'Ailier'),
('JP27551881', 'Poole', 'Jordan', 'jordan_poole.png', '1999-06-19', 193, 88, 'Arriere'),
('JT14587264', 'Ty', 'Jerome', 'ty_jerome.png', '1997-07-08', 196, 88, 'Meneur'),
('JW23455842', 'James', 'Wiseman', 'james_wiseman.png', '2001-03-31', 213, 109, 'Pivot'),
('KL27154845', 'Looney', 'Kevon', 'kevon_looney.png', '1996-02-06', 206, 101, 'Pivot'),
('KT65487826', 'Thompson', 'Klay', 'klay_thompson.png', '1990-02-08', 198, 98, 'Arriere'),
('MM24725455', 'Moody', 'Moses', 'moses_moody.png', '2002-05-31', 196, 96, 'Arriere'),
('PB25785284', 'Baldwin Jr.', 'Patrick', 'patrick_baldwin.png', '2002-11-18', 206, 100, 'Ailier fort'),
('RR12452457', 'Rollins', 'Ryan', 'ryan_rollins.png', '2002-07-03', 191, 82, 'Arriere'),
('SC14845484', 'Curry', 'Stephen', 'stephen_curry.png', '1988-03-14', 188, 84, 'Meneur');

-- --------------------------------------------------------

--
-- Structure de la table `matchbasketball`
--

DROP TABLE IF EXISTS `matchbasketball`;
CREATE TABLE IF NOT EXISTS `matchbasketball` (
  `Id_MatchBasketball` char(4) COLLATE utf8_bin NOT NULL,
  `DateMatch` date NOT NULL,
  `Heure` time NOT NULL,
  `NomEquipeAdverse` varchar(30) COLLATE utf8_bin NOT NULL,
  `LieuRencontre` varchar(30) COLLATE utf8_bin NOT NULL,
  `PointsGagnes` varchar(3) COLLATE utf8_bin NOT NULL,
  `PointsPerdus` int(3) NOT NULL,
  PRIMARY KEY (`Id_MatchBasketball`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `matchbasketball`
--

INSERT INTO `matchbasketball` (`Id_MatchBasketball`, `DateMatch`, `Heure`, `NomEquipeAdverse`, `LieuRencontre`, `PointsGagnes`, `PointsPerdus`) VALUES
('M001', '2023-01-01', '09:00:00', 'Wizard', 'Toulouse', '102', 88),
('M002', '2023-01-08', '10:00:00', 'Lakers', 'Saint-Martory', '88', 66),
('M003', '2023-01-15', '14:00:00', 'Bulls', 'Chicago', '68', 84);

-- --------------------------------------------------------

--
-- Structure de la table `participer`
--

DROP TABLE IF EXISTS `participer`;
CREATE TABLE IF NOT EXISTS `participer` (
  `Commentaires` varchar(300) COLLATE utf8_bin NOT NULL,
  `Notation` smallint(1) DEFAULT NULL,
  `Statut` varchar(20) COLLATE utf8_bin NOT NULL,
  `Titulaire` varchar(15) COLLATE utf8_bin NOT NULL,
  `MatchGagne` tinyint(1) NOT NULL,
  `NumeroLicence` char(10) COLLATE utf8_bin NOT NULL,
  `Id_MatchBasketball` char(4) COLLATE utf8_bin NOT NULL,
  KEY `NumeroLicence` (`NumeroLicence`),
  KEY `Id_MatchBasketball` (`Id_MatchBasketball`),
  KEY `Id_MatchBasketballl` (`Id_MatchBasketball`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `participer`
--

INSERT INTO `participer` (`Commentaires`, `Notation`, `Statut`, `Titulaire`, `MatchGagne`, `NumeroLicence`, `Id_MatchBasketball`) VALUES
('Le joueur a ete impressionnant sur le terrain aujourdhui, marquant des points cles pour son equipe et defendant avec agressivite. Il a montre une excellente presence athletique et une grande confiance', 4, 'Actif', '1', 1, 'AI26485874', 'M001'),
('Le joueur a ete un veritable atout pour son equipe lors de ce match, menant son equipe a la victoire avec son jeu offensif dynamique et sa defense agressive. Il a montre une grande precision dans ses ', 5, 'Actif', '1', 1, 'DD75181271', 'M001'),
('Le joueur a eu une performance decevante lors de ce match, manquant de nombreux tirs importants et ayant du mal a defendre efficacement. Il semblait manquer de confiance et de concentration, ce qui a ', 2, 'Actif', '1', 1, 'JG14224512', 'M001'),
('Le joueur a ete invisible sur le terrain lors de ce match, il n\'a pas reussi a marquer des points, et sa defense etait deficiente. Il n\'a pas reussi a s\'integrer a l\'equipe, et n\'a pas reussi a contri', 1, 'Actif', '1', 1, 'JK13462454', 'M001'),
('Le joueur a ete incroyable lors de ce match, il a marque des points importants, et il a ete un facteur cle dans la victoire de son equipe. Il a montre une grande agilite et de la creativite dans ses a', 4, 'Actif', '0', 1, 'JP27551881', 'M001'),
('Le joueur a ete exceptionnel lors de ce match, il a marque des points importants, et il a joue un role cle dans la victoire de son equipe. Il a montre une grande intelligence de jeu, et a su prendre l', 5, 'Actif', '1', 1, 'KL27154845', 'M001'),
('Le joueur a eu une performance stable lors de ce match, il a marque des points et a joue correctement en defense. Il a ete capable de s\'adapter aux situations de jeu et a rempli son role dans l\'equipe', 3, 'Actif', '0', 1, 'MM24725455', 'M001'),
('Le joueur a eu une performance moyenne lors de ce match, il a marque des points, mais il n\'a pas ete un facteur decisif dans le jeu. Il s\'est montre efficace en defense mais pas toujours en attaque. I', 3, 'Actif', '0', 1, 'PB25785284', 'M001'),
('Joueur blesse au genoux', NULL, 'Blesse', '0', 1, 'RR12452457', 'M001'),
('Joueur blesse a l\'epaule', 0, 'Blesse', '0', 1, 'AW26480458', 'M001'),
('Le joueur a fait une mauvaise saison il est donc sur le banc c\'est peu probable qu\'il rejoue pour les matchs a veni', 1, 'Actif', '0', 1, 'DG26548548', 'M001'),
('Le joueur a fait une bonne saison mais compte tenu du fait qu\'il est nouveau dans l\'equipe si ne sera pas titulaire avant plusieurs saisons', 4, 'Actif', '0', 1, 'JT14587264', 'M001'),
('Le joueur s\'est blesse la main droite en faisant un dunk un peu trop appuye sur le crane de Lebron James', NULL, 'Blesse', '0', 1, 'JW23455842', 'M001'),
('Le joueur a fait une saison moyenne dans ses points marques comme dans sa possession du ballon il est donc place sur le banc pour les prochaines saisons', 3, 'Actif', '0', 1, 'KT65487826', 'M001'),
('Le joueur a fait une bonne saison mais il est un peu plus fatigue que d\'habitude il est donc place sur le banc', 4, 'Actif', '0', 1, 'SC14845484', 'M001'),
('Le joueur a ete impressionnant sur le terrain aujourdhui, marquant des points cles pour son equipe et defendant avec agressivite. Il a montre une excellente presence athletique et une grande confiance', 4, 'Actif', '1', 1, 'AI26485874', 'M002'),
('Le joueur a ete un veritable atout pour son equipe lors de ce match, menant son equipe a la victoire avec son jeu offensif dynamique et sa defense agressive. Il a montre une grande precision dans ses ', 5, 'Actif', '1', 1, 'DD75181271', 'M002'),
('Le joueur a eu une performance decevante lors de ce match, manquant de nombreux tirs importants et ayant du mal a defendre efficacement. Il semblait manquer de confiance et de concentration, ce qui a ', 2, 'Actif', '1', 1, 'JG14224512', 'M002'),
('Le joueur a ete invisible sur le terrain lors de ce match, il n\'a pas reussi a marquer des points, et sa defense etait deficiente. Il n\'a pas reussi a s\'integrer a l\'equipe, et n\'a pas reussi a contri', 1, 'Actif', '1', 1, 'JK13462454', 'M002'),
('Le joueur a ete incroyable lors de ce match, il a marque des points importants, et il a ete un facteur cle dans la victoire de son equipe. Il a montre une grande agilite et de la creativite dans ses a', 4, 'Actif', '0', 1, 'JP27551881', 'M002'),
('Le joueur a ete exceptionnel lors de ce match, il a marque des points importants, et il a joue un role cle dans la victoire de son equipe. Il a montre une grande intelligence de jeu, et a su prendre l', 5, 'Actif', '1', 1, 'KL27154845', 'M002'),
('Le joueur a eu une performance stable lors de ce match, il a marque des points et a joue correctement en defense. Il a ete capable de s\'adapter aux situations de jeu et a rempli son role dans l\'equipe', 3, 'Actif', '0', 1, 'MM24725455', 'M002'),
('Le joueur a eu une performance moyenne lors de ce match, il a marque des points, mais il n\'a pas ete un facteur decisif dans le jeu. Il s\'est montre efficace en defense mais pas toujours en attaque. I', 3, 'Actif', '0', 1, 'PB25785284', 'M002'),
('Joueur blesse au genoux', NULL, 'Blesse', '0', 1, 'RR12452457', 'M002'),
('Joueur blesse a l\'epaule', 0, 'Blesse', '0', 1, 'AW26480458', 'M002'),
('Le joueur a fait une mauvaise saison il est donc sur le banc c\'est peu probable qu\'il rejoue pour les matchs a veni', 1, 'Actif', '0', 1, 'DG26548548', 'M002'),
('Le joueur a fait une bonne saison mais compte tenu du fait qu\'il est nouveau dans l\'equipe si ne sera pas titulaire avant plusieurs saisons', 4, 'Actif', '0', 1, 'JT14587264', 'M002'),
('Le joueur s\'est blesse la main droite en faisant un dunk un peu trop appuye sur le crane de Lebron James', NULL, 'Blesse', '0', 1, 'JW23455842', 'M002'),
('Le joueur a fait une saison moyenne dans ses points marques comme dans sa possession du ballon il est donc place sur le banc pour les prochaines saisons', 3, 'Actif', '0', 1, 'KT65487826', 'M002'),
('Le joueur a fait une bonne saison mais il est un peu plus fatigue que d\'habitude il est donc place sur le banc', 4, 'Actif', '0', 1, 'SC14845484', 'M002'),
('Le joueur a ete impressionnant sur le terrain aujourdhui, marquant des points cles pour son equipe et defendant avec agressivite. Il a montre une excellente presence athletique et une grande confiance', 4, 'Actif', '1', 0, 'AI26485874', 'M003'),
('Le joueur a ete un veritable atout pour son equipe lors de ce match, menant son equipe a la victoire avec son jeu offensif dynamique et sa defense agressive. Il a montre une grande precision dans ses ', 5, 'Actif', '1', 0, 'DD75181271', 'M003'),
('Le joueur a eu une performance decevante lors de ce match, manquant de nombreux tirs importants et ayant du mal a defendre efficacement. Il semblait manquer de confiance et de concentration, ce qui a ', 2, 'Actif', '1', 0, 'JG14224512', 'M003'),
('Le joueur a ete invisible sur le terrain lors de ce match, il n\'a pas reussi a marquer des points, et sa defense etait deficiente. Il n\'a pas reussi a s\'integrer a l\'equipe, et n\'a pas reussi a contri', 1, 'Actif', '1', 0, 'JK13462454', 'M003'),
('Le joueur a ete incroyable lors de ce match, il a marque des points importants, et il a ete un facteur cle dans la victoire de son equipe. Il a montre une grande agilite et de la creativite dans ses a', 4, 'Actif', '0', 0, 'JP27551881', 'M003'),
('Le joueur a ete exceptionnel lors de ce match, il a marque des points importants, et il a joue un role cle dans la victoire de son equipe. Il a montre une grande intelligence de jeu, et a su prendre l', 5, 'Actif', '1', 0, 'KL27154845', 'M003'),
('Le joueur a eu une performance stable lors de ce match, il a marque des points et a joue correctement en defense. Il a ete capable de s\'adapter aux situations de jeu et a rempli son role dans l\'equipe', 3, 'Actif', '0', 0, 'MM24725455', 'M003'),
('Le joueur a eu une performance moyenne lors de ce match, il a marque des points, mais il n\'a pas ete un facteur decisif dans le jeu. Il s\'est montre efficace en defense mais pas toujours en attaque. I', 3, 'Actif', '0', 0, 'PB25785284', 'M003'),
('Joueur blesse au genoux', NULL, 'Blesse', '0', 0, 'RR12452457', 'M003'),
('Joueur blesse a l\'epaule', 0, 'Blesse', '0', 0, 'AW26480458', 'M003'),
('Le joueur a fait une mauvaise saison il est donc sur le banc c\'est peu probable qu\'il rejoue pour les matchs a veni', 1, 'Actif', '0', 0, 'DG26548548', 'M003'),
('Le joueur a fait une bonne saison mais compte tenu du fait qu\'il est nouveau dans l\'equipe si ne sera pas titulaire avant plusieurs saisons', 4, 'Actif', '0', 0, 'JT14587264', 'M003'),
('Le joueur s\'est blesse la main droite en faisant un dunk un peu trop appuye sur le crane de Lebron James', NULL, 'Blesse', '0', 0, 'JW23455842', 'M003'),
('Le joueur a fait une saison moyenne dans ses points marques comme dans sa possession du ballon il est donc place sur le banc pour les prochaines saisons', 3, 'Actif', '0', 0, 'KT65487826', 'M003'),
('Le joueur a fait une bonne saison mais il est un peu plus fatigue que d\'habitude il est donc place sur le banc', 4, 'Actif', '0', 0, 'SC14845484', 'M003');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `participer`
--
ALTER TABLE `participer`
  ADD CONSTRAINT `participer_ibfk_1` FOREIGN KEY (`NumeroLicence`) REFERENCES `joueur` (`NumeroLicence`),
  ADD CONSTRAINT `participer_ibfk_2` FOREIGN KEY (`Id_MatchBasketball`) REFERENCES `matchbasketball` (`Id_MatchBasketball`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
