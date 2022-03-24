-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 22 déc. 2021 à 10:34
-- Version du serveur : 5.7.33
-- Version de PHP : 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_2021`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id_article` int(11) NOT NULL,
  `nom_article` varchar(255) NOT NULL,
  `annee` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `suppression` int(11) DEFAULT NULL,
  `id_marque` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_article`, `nom_article`, `annee`, `prix`, `suppression`, `id_marque`, `id_categorie`) VALUES
(1, 'Epic Pro', 2021, 10000, 1, 3, 3),
(2, 'Btwin 350', 2021, 499, NULL, 5, 9),
(3, 'test', 2020, 2000, 1, 2, 6),
(4, 'Stereo 120 HPC SLT', 2021, 4599, NULL, 2, 5),
(5, 'Stance 29', 2020, 2099, NULL, 0, 4),
(6, 'test', 2021, 10, 1, 0, 3),
(7, 'd', 1, 1, 1, 2, 9),
(8, 'd', 1, 1, 1, 4, 5),
(9, 'test', 1, 1, 1, 3, 4),
(10, 'd', 1, 1, 1, 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(10) UNSIGNED NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `suppression` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `categorie`, `suppression`) VALUES
(1, 'VTT de cou', 1),
(2, 'VTT dunhill', 1),
(3, 'Cross Country', NULL),
(4, 'VTT enduro', NULL),
(5, 'VTT de montagne', NULL),
(6, 'VTT électrique', 1),
(7, 'Vélo de course', 1),
(8, 'VTT éléctrique', NULL),
(9, 'VTT de course', NULL),
(10, 'test', 1);

-- --------------------------------------------------------

--
-- Structure de la table `marques`
--

CREATE TABLE `marques` (
  `id_marque` int(11) NOT NULL,
  `marque` varchar(255) NOT NULL,
  `suppression` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `marques`
--

INSERT INTO `marques` (`id_marque`, `marque`, `suppression`) VALUES
(1, 'Spécialized', 1),
(2, 'Cube', 1),
(3, 'Giant', NULL),
(4, 'Kona', NULL),
(5, 'Décathlon', NULL),
(6, 'Spézialized', 1),
(7, 'Cube', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `droits` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_users`, `login`, `password`, `droits`, `email`) VALUES
(1, 'prof', 'd9f02d46be016f1b301f7c02a4b9c4ebe0dde7ef', 2, 'prof@gmail.com'),
(2, 'nicolas', '418d940643b1975d62234ee01246ad4b58904184', 1, 'nicolas@gmail.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_article`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `marques`
--
ALTER TABLE `marques`
  ADD PRIMARY KEY (`id_marque`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `marques`
--
ALTER TABLE `marques`
  MODIFY `id_marque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
