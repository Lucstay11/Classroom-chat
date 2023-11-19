-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 19 nov. 2023 à 23:10
-- Version du serveur : 8.0.35-0ubuntu0.22.04.1
-- Version de PHP : 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `chat`
--

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `id` int NOT NULL,
  `id_message` int NOT NULL,
  `id_likeur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message_groupe`
--

CREATE TABLE `message_groupe` (
  `id` int NOT NULL,
  `contenu` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `id_destinateur` int NOT NULL,
  `date_mess` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nb_like` int UNSIGNED NOT NULL,
  `info` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `supprimer` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `setting`
--

CREATE TABLE `setting` (
  `id` int NOT NULL,
  `nom_groupe` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `setting`
--

INSERT INTO `setting` (`id`, `nom_groupe`) VALUES
(0, 'Your Group 🤣');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `statut` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pass` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `etat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pp_img` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ecris` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `last_co` text COLLATE utf8mb4_general_ci NOT NULL,
  `banni` int NOT NULL,
  `banni_groupe` int NOT NULL,
  `raison_banni` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `restreint_groupe` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `statut`, `nom`, `pass`, `etat`, `pp_img`, `ecris`, `last_co`, `banni`, `banni_groupe`, `raison_banni`, `restreint_groupe`) VALUES
(1, 'admin', 'Admin', 'admin', 'deconnecter', 'Database/files/avatar/avatar14.jpg', 'off', 'Sat Oct 28 21:46:31', 0, 0, '', '0');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message_groupe`
--
ALTER TABLE `message_groupe`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT pour la table `message_groupe`
--
ALTER TABLE `message_groupe`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
