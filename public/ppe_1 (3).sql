-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 01 mars 2026 à 10:18
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ppe_1`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `nom`, `prenom`, `id_utilisateur`) VALUES
(1, 'Chevalier', 'Alex', 3);

-- --------------------------------------------------------

--
-- Structure de la table `coach`
--

DROP TABLE IF EXISTS `coach`;
CREATE TABLE IF NOT EXISTS `coach` (
  `id_coach` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sport` varchar(50) DEFAULT NULL,
  `id_sport` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_coach`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_sport` (`id_sport`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `coach`
--

INSERT INTO `coach` (`id_coach`, `nom`, `prenom`, `sport`, `id_sport`, `id_utilisateur`) VALUES
(1, 'Albert', 'Claire', 'Entraîneur Football', 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id_joueur` int NOT NULL,
  `id_sport` int NOT NULL,
  `libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_joueur`,`id_sport`),
  KEY `id_sport` (`id_sport`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`id_joueur`, `id_sport`, `libelle`) VALUES
(1, 1, 'Mon sport de prédilection'),
(2, 2, 'Mon sport de raquette'),
(2, 3, 'Pour se défouler'),
(3, 1, NULL),
(3, 2, NULL),
(3, 3, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

DROP TABLE IF EXISTS `joueur`;
CREATE TABLE IF NOT EXISTS `joueur` (
  `id_joueur` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `id_niv` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  PRIMARY KEY (`id_joueur`),
  UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_niv` (`id_niv`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `joueur`
--

INSERT INTO `joueur` (`id_joueur`, `nom`, `prenom`, `tel`, `mail`, `id_niv`, `id_utilisateur`) VALUES
(1, 'Dupont', 'Jean', '0610101010', 'jean.dupont@mail.com', 2, 1),
(2, 'Martin', 'Marie', '0620202020', 'marie.martin@mail.com', 3, 2),
(3, 'esnault', 'alexis', '0646056336', 'alexisesnault11@gmail.com', 1, 16);

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `id_lieu` int NOT NULL AUTO_INCREMENT,
  `rue` varchar(50) DEFAULT NULL,
  `n_rue` int DEFAULT NULL,
  `code_postal` int DEFAULT NULL,
  PRIMARY KEY (`id_lieu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id_lieu`, `rue`, `n_rue`, `code_postal`) VALUES
(1, 'Rue des Sports', 15, 75001),
(2, 'Avenue de la Victoire', 42, 69007),
(3, 'Boulevard de l\'Entraînement', 8, 13008);

-- --------------------------------------------------------

--
-- Structure de la table `match_`
--

DROP TABLE IF EXISTS `match_`;
CREATE TABLE IF NOT EXISTS `match_` (
  `id_match` int NOT NULL AUTO_INCREMENT,
  `libéllé` varchar(50) NOT NULL,
  `descriptif` varchar(50) DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `id_niv` int NOT NULL,
  `id_sport` int NOT NULL,
  `id_lieu` int NOT NULL,
  PRIMARY KEY (`id_match`),
  KEY `id_niv` (`id_niv`),
  KEY `id_sport` (`id_sport`),
  KEY `id_lieu` (`id_lieu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `match_`
--

INSERT INTO `match_` (`id_match`, `libéllé`, `descriptif`, `date_debut`, `date_fin`, `id_niv`, `id_sport`, `id_lieu`) VALUES
(1, 'Foot 5v5 Amical', 'Match de football sans enjeu.', '2025-12-01 19:00:00', '2025-12-01 20:30:00', 2, 1, 1),
(2, 'Tournoi Tennis', 'Simple Hommes - Défi.', '2025-12-05 14:30:00', '2025-12-05 17:00:00', 3, 2, 2),
(3, 'foot 11v11', 'match amical 22 joueur', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

DROP TABLE IF EXISTS `niveau`;
CREATE TABLE IF NOT EXISTS `niveau` (
  `id_niv` int NOT NULL AUTO_INCREMENT,
  `libéllé` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_niv`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`id_niv`, `libéllé`) VALUES
(1, 'Débutant'),
(2, 'Intermédiaire'),
(3, 'Avancé');

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

DROP TABLE IF EXISTS `participe`;
CREATE TABLE IF NOT EXISTS `participe` (
  `id_joueur` int NOT NULL,
  `id_match` int NOT NULL,
  PRIMARY KEY (`id_joueur`,`id_match`),
  KEY `id_match` (`id_match`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `participe`
--

INSERT INTO `participe` (`id_joueur`, `id_match`) VALUES
(1, 1),
(2, 1),
(2, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `sport`
--

DROP TABLE IF EXISTS `sport`;
CREATE TABLE IF NOT EXISTS `sport` (
  `id_sport` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `n_joueur` int NOT NULL,
  `descriptif` text,
  PRIMARY KEY (`id_sport`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `sport`
--

INSERT INTO `sport` (`id_sport`, `nom`, `n_joueur`, `descriptif`) VALUES
(1, 'Football', 22, 'Sport collectif populaire.'),
(2, 'Tennis', 2, 'Sport de raquette individuel.'),
(3, 'Basketball', 10, 'Sport de ballon avec paniers.');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `nom_util` varchar(50) DEFAULT NULL,
  `mdp` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `unicité_nom_util` (`nom_util`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom_util`, `mdp`) VALUES
(1, 'jdupond', 'pass123'),
(2, 'mmartin', 'secure456'),
(3, 'cadmin', 'adminpass'),
(4, 'acoach', 'coachpass'),
(16, 'racharim', 'a');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`id_sport`) REFERENCES `sport` (`id_sport`),
  ADD CONSTRAINT `coach_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `favoris_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id_joueur`),
  ADD CONSTRAINT `favoris_ibfk_2` FOREIGN KEY (`id_sport`) REFERENCES `sport` (`id_sport`);

--
-- Contraintes pour la table `joueur`
--
ALTER TABLE `joueur`
  ADD CONSTRAINT `joueur_ibfk_1` FOREIGN KEY (`id_niv`) REFERENCES `niveau` (`id_niv`),
  ADD CONSTRAINT `joueur_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `match_`
--
ALTER TABLE `match_`
  ADD CONSTRAINT `match__ibfk_1` FOREIGN KEY (`id_niv`) REFERENCES `niveau` (`id_niv`),
  ADD CONSTRAINT `match__ibfk_2` FOREIGN KEY (`id_sport`) REFERENCES `sport` (`id_sport`),
  ADD CONSTRAINT `match__ibfk_3` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id_lieu`);

--
-- Contraintes pour la table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `participe_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `joueur` (`id_joueur`),
  ADD CONSTRAINT `participe_ibfk_2` FOREIGN KEY (`id_match`) REFERENCES `match_` (`id_match`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
