-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1:3306
-- Généré le :  Mar 25 Juillet 2017 à 12:51
-- Version du serveur :  5.6.34-log
-- Version de PHP :  7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ocp3_blog`
--
CREATE DATABASE IF NOT EXISTS `ocp3_blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ocp3_blog`;

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE IF NOT EXISTS `billets` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `extrait` text,
  `auteur_id` int(11) NOT NULL,
  `date_publie` datetime NOT NULL,
  `date_modif` datetime DEFAULT NULL,
  `image_id` int(11) NOT NULL,
  `statut` varchar(50) NOT NULL COMMENT 'brouillon, publication, corbeille'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int(11) NOT NULL,
  `billets_id` int(11) NOT NULL,
  `com_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_publie` datetime NOT NULL,
  `approuve` tinyint(1) NOT NULL DEFAULT '0',
  `signalement` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `billet` varchar(255) NOT NULL,
  `vignette` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_create` datetime NOT NULL COMMENT 'date de création du compte',
  `date_birth` date NOT NULL COMMENT 'date de naissance',
  `type_id` int(11) NOT NULL,
  `avatar_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `nom`, `prenom`, `email`, `password`, `date_create`, `date_birth`, `type_id`, `avatar_id`) VALUES
(1, 'Jean-F', '', '', 'jean@forteroche.fr', 'fa7253e5e926652bf8858cd62154b9b6c3d91fd3c7b7e569042f970ddcb9dc7d', '2017-07-25 12:26:31', '0000-00-00', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `membres_reseaux`
--

CREATE TABLE IF NOT EXISTS `membres_reseaux` (
  `id` int(11) NOT NULL,
  `membre_id` int(11) NOT NULL,
  `reseaux_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membres_types`
--

CREATE TABLE IF NOT EXISTS `membres_types` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `membres_types`
--

INSERT INTO `membres_types` (`id`, `type`, `description`) VALUES
(1, 'Administrateur', 'Accès complet à toutes les fonctionnalités du site web.'),
(2, 'Abonné', 'Gestion de ses propres commentaires.');

-- --------------------------------------------------------

--
-- Structure de la table `reseaux_sociaux`
--

CREATE TABLE IF NOT EXISTS `reseaux_sociaux` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `icone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `billets`
--
ALTER TABLE `billets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_auteur` (`auteur_id`),
  ADD KEY `fk_dossier` (`statut`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ind_unq_user` (`email`,`password`);

--
-- Index pour la table `membres_reseaux`
--
ALTER TABLE `membres_reseaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membres_types`
--
ALTER TABLE `membres_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reseaux_sociaux`
--
ALTER TABLE `reseaux_sociaux`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `billets`
--
ALTER TABLE `billets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `membres_reseaux`
--
ALTER TABLE `membres_reseaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `membres_types`
--
ALTER TABLE `membres_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `reseaux_sociaux`
--
ALTER TABLE `reseaux_sociaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `billets`
--
ALTER TABLE `billets`
  ADD CONSTRAINT `fk_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `membres` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
