-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 24 mars 2026 à 16:41
-- Version du serveur : 10.11.14-MariaDB-0+deb12u2
-- Version de PHP : 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `c43blindgame`
--

-- --------------------------------------------------------

--
-- Structure de la table `jeu`
--

CREATE TABLE `jeu` (
  `id_partie` int(10) UNSIGNED NOT NULL COMMENT 'Initialise les diférente partie de lancer',
  `mode_de_jeu` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Les différents modes de jeu',
  `difficulty` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Adjuster la difficulté dans les modes',
  `score` int(11) NOT NULL DEFAULT 0 COMMENT 'score du joueur',
  `score_date` date NOT NULL DEFAULT current_timestamp(),
  `id_joueur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `jeu`
--

INSERT INTO `jeu` (`id_partie`, `mode_de_jeu`, `difficulty`, `score`, `score_date`, `id_joueur`) VALUES
(4, 'Survive', 'Easy', 300, '2026-03-19', 2),
(5, 'Survive', 'Medium', 600, '2026-03-24', 2),
(7, 'Survive', 'Medium', 300, '2018-02-06', 2),
(8, 'Survive', 'Easy', 200, '2026-03-24', 2),
(9, 'Survive', 'Easy', 200, '2026-03-24', 2),
(11, 'Survive', 'Easy', 100, '2026-03-24', 2),
(12, 'Survive', 'Easy', 100, '2026-03-24', 3),
(13, 'Time Attack', 'Medium', 600, '2026-03-24', 2),
(14, 'Time Attack', 'Medium', 300, '2026-03-24', 2),
(15, 'Survive', 'Easy', 300, '2026-03-24', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `jeu`
--
ALTER TABLE `jeu`
  ADD UNIQUE KEY `partie` (`id_partie`),
  ADD KEY `id_joueur` (`id_joueur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `jeu`
--
ALTER TABLE `jeu`
  MODIFY `id_partie` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Initialise les diférente partie de lancer', AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `jeu`
--
ALTER TABLE `jeu`
  ADD CONSTRAINT `id_joueur` FOREIGN KEY (`id_joueur`) REFERENCES `compte` (`id_joueur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
