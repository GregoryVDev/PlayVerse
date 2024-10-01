-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : mar. 01 oct. 2024 à 10:08
-- Version du serveur : 8.0.37
-- Version de PHP : 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `playverse`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentary`
--

CREATE TABLE `commentary` (
  `commentary_id` int NOT NULL,
  `user_id` int NOT NULL,
  `game_id` int NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `favoris_id` int NOT NULL,
  `user_id` int NOT NULL,
  `game_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `game_id` int NOT NULL,
  `game_title` varchar(255) NOT NULL,
  `admin_id` int NOT NULL,
  `pegi_id` int NOT NULL,
  `category_id` int NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `background` varchar(255) NOT NULL,
  `trailer` varchar(255) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `image4` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `gamesplateformes`
--

CREATE TABLE `gamesplateformes` (
  `gplateforme_id` int NOT NULL,
  `game_id` int NOT NULL,
  `plateforme_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `message_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `object` varchar(255) NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_message` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pegi`
--

CREATE TABLE `pegi` (
  `pegi_id` int NOT NULL,
  `pegi_name` varchar(255) NOT NULL,
  `pegi_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plateformes`
--

CREATE TABLE `plateformes` (
  `plateforme_id` int NOT NULL,
  `plateforme_name` varchar(255) NOT NULL,
  `plateforme_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `game_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `paragraph1` text NOT NULL,
  `paragraph2` text NOT NULL,
  `paragraph3` text NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `high_point` text NOT NULL,
  `weak_point` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Index pour la table `commentary`
--
ALTER TABLE `commentary`
  ADD PRIMARY KEY (`commentary_id`),
  ADD KEY `key_users` (`user_id`),
  ADD KEY `key_game` (`game_id`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`favoris_id`),
  ADD KEY `key_user` (`user_id`),
  ADD KEY `key_games` (`game_id`);

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `key_admin` (`admin_id`),
  ADD KEY `key_pegi` (`pegi_id`),
  ADD KEY `key_category` (`category_id`);

--
-- Index pour la table `gamesplateformes`
--
ALTER TABLE `gamesplateformes`
  ADD PRIMARY KEY (`gplateforme_id`),
  ADD KEY `key_jeux` (`game_id`),
  ADD KEY `key_plateforme` (`plateforme_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`);

--
-- Index pour la table `pegi`
--
ALTER TABLE `pegi`
  ADD PRIMARY KEY (`pegi_id`);

--
-- Index pour la table `plateformes`
--
ALTER TABLE `plateformes`
  ADD PRIMARY KEY (`plateforme_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `key_admins` (`admin_id`),
  ADD KEY `key_jeu` (`game_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentary`
--
ALTER TABLE `commentary`
  MODIFY `commentary_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `favoris`
--
ALTER TABLE `favoris`
  MODIFY `favoris_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `gamesplateformes`
--
ALTER TABLE `gamesplateformes`
  MODIFY `gplateforme_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pegi`
--
ALTER TABLE `pegi`
  MODIFY `pegi_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `plateformes`
--
ALTER TABLE `plateformes`
  MODIFY `plateforme_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentary`
--
ALTER TABLE `commentary`
  ADD CONSTRAINT `key_game` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `key_games` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `key_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_pegi` FOREIGN KEY (`pegi_id`) REFERENCES `pegi` (`pegi_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `gamesplateformes`
--
ALTER TABLE `gamesplateformes`
  ADD CONSTRAINT `key_jeux` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_plateforme` FOREIGN KEY (`plateforme_id`) REFERENCES `plateformes` (`plateforme_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `key_admins` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `key_jeu` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
