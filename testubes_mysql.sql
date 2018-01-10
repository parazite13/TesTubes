-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 10 Janvier 2018 à 10:40
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `testubes`
--
CREATE DATABASE IF NOT EXISTS testubes;
USE testubes;

-- --------------------------------------------------------

--
-- Structure de la table `preferences`
--

CREATE TABLE `preferences` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `titre` int(11) NOT NULL DEFAULT '1',
  `auteur` int(11) NOT NULL DEFAULT '1',
  `vues` int(11) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL DEFAULT '1',
  `description` int(11) NOT NULL DEFAULT '1',
  `duree` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `preferences`
--

INSERT INTO `preferences` (`id`, `id_user`, `titre`, `auteur`, `vues`, `date`, `description`, `duree`) VALUES
(5, 10, 1, 1, 1, 1, 1, 1),
(6, 11, 1, 1, 1, 1, 1, 1),
(7, 12, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `preferences_author`
--

CREATE TABLE `preferences_author` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `titre` tinyint(1) NOT NULL,
  `videos` tinyint(1) NOT NULL,
  `date` tinyint(1) NOT NULL,
  `description` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `preferences_author`
--

INSERT INTO `preferences_author` (`id`, `id_user`, `titre`, `videos`, `date`, `description`) VALUES
(1, 11, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(15) CHARACTER SET utf8 NOT NULL,
  `password` varchar(256) CHARACTER SET utf8 NOT NULL,
  `api_key` varchar(256) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `password`, `api_key`) VALUES
(11, 'Alexandre', '3d65fd70d95a4edfe9555d0ebeca2b17', NULL),
(10, 'Vincent', 'b15ab3f829f0f897fe507ef548741afb', NULL),
(12, 'Admin', 'f6fdffe48c908deb0f4c3bd36c032e72', NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `preferences_author`
--
ALTER TABLE `preferences_author`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `preferences_author`
--
ALTER TABLE `preferences_author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
