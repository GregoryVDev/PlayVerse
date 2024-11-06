-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : lun. 04 nov. 2024 à 10:03
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
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`admin_id`, `pseudo`, `email`, `pass`) VALUES
(1, 'Administrator', 'admin@admin.fr', '$2y$10$ydvlBJLRCTgCtX09FQamhuOpQAgLChhCUvxl752GnwaeZDWSYoaV2');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'FPS'),
(2, 'MMORPG'),
(6, 'Stratégie'),
(7, 'Gestion');

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
  `jacket` varchar(225) NOT NULL,
  `content` text NOT NULL,
  `background` varchar(255) NOT NULL,
  `trailer` varchar(255) NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `image4` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`game_id`, `game_title`, `admin_id`, `pegi_id`, `category_id`, `jacket`, `content`, `background`, `trailer`, `image1`, `image2`, `image3`, `image4`) VALUES
(15, 'lol', 1, 33, 1, 'img/games/67288d11bef6f.jpg', 'zef', 'img/games/67288d11bc0bf.jpg', 'https://www.youtube.com/watch?v=O1CHmlgR3ts', 'img/games/67288d11c02f2.jpg', 'img/games/67288d11c20ad.jpg', 'img/games/67288d11c3424.jpg', 'img/games/67288d11c5d96.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `gamesplateformes`
--

CREATE TABLE `gamesplateformes` (
  `gplateforme_id` int NOT NULL,
  `game_id` int NOT NULL,
  `plateforme_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `gamesplateformes`
--

INSERT INTO `gamesplateformes` (`gplateforme_id`, `game_id`, `plateforme_id`) VALUES
(20, 15, 5),
(21, 15, 6);

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

--
-- Déchargement des données de la table `pegi`
--

INSERT INTO `pegi` (`pegi_id`, `pegi_name`, `pegi_icon`) VALUES
(31, 'PEGI 3', './img/images/cdc7f756d74f68ee405a9b8b99006a9e.png'),
(32, 'PEGI 7', './img/images/e6db845d063dc25755d3a87b704ec886.png'),
(33, 'PEGI 12', './img/images/526b01ec2f2fe33229fe36d0f249d1c9.png'),
(34, 'PEGI 16', './img/images/15c3aa5b496f9cb289c77f25f33d3031.png'),
(38, 'PEGI 18', './img/images/1327608cefc7b195190cac1b640ef33a.png');

-- --------------------------------------------------------

--
-- Structure de la table `plateformes`
--

CREATE TABLE `plateformes` (
  `plateforme_id` int NOT NULL,
  `plateforme_name` varchar(255) NOT NULL,
  `plateforme_icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `plateformes`
--

INSERT INTO `plateformes` (`plateforme_id`, `plateforme_name`, `plateforme_icon`) VALUES
(1, 'Playstation', './img/images/67bf8d1b15db2a9de462f8f16a56de36.png'),
(5, 'Xbox', './img/images/925ea1b4dd26c3cfea0c0d62b2ef7705.png'),
(6, 'Switch', './img/images/044bc0a4b136c09e425e5d8b91e565a3.png'),
(7, 'PC', './img/images/30bd9c990b7d29144f5d8354108eb1c5.png');

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `review_title` varchar(255) NOT NULL,
  `paragraph1` text NOT NULL,
  `paragraph2` text NOT NULL,
  `paragraph3` text NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `high_point` text NOT NULL,
  `weak_point` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`review_id`, `admin_id`, `review_title`, `paragraph1`, `paragraph2`, `paragraph3`, `image1`, `image2`, `image3`, `high_point`, `weak_point`) VALUES
(1, 1, 'Black Myth Wukong', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime aperiam rerum, tenetur enim eum ullam ratione hic esse placeat rem est modi quos atque veniam! Nulla illo culpa mollitia omnis.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, unde voluptatum maiores minima sequi non quod? Pariatur quae debitis tenetur illum amet asperiores officia eligendi voluptates, cum maiores at corrupti! Facere et at laudantium id officia accusantium, enim non saepe exercitationem. Ipsa quod minima amet, repudiandae a ad sequi beatae nihil molestias veritatis. Excepturi vel modi dolores, ratione magni velit! Recusandae quibusdam provident hic aliquam aspernatur? Sit veritatis eveniet, modi accusamus nemo hic quod vitae, quae sint cupiditate velit eius. Nihil eligendi debitis expedita, architecto consectetur nam minus quidem provident.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, unde voluptatum maiores minima sequi non quod? Pariatur quae debitis tenetur illum amet asperiores officia eligendi voluptates, cum maiores at corrupti! Facere et at laudantium id officia accusantium, enim non saepe exercitationem. Ipsa quod minima amet, repudiandae a ad sequi beatae nihil molestias veritatis.', 'bmw.png', 'bmw.png', 'bmw.png', '- Bon jeu\n- Graphisme\n- Jouabilité', '- Bon jeu\n- Graphisme\n- Jouabilité');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `pseudo`, `email`, `pass`) VALUES
(1, 'Wiggle', 'a@b.c', '$argon2id$v=19$m=65536,t=4,p=1$NHVDWHFScG5YTDB5bjdScw$oD2hUlhrtWdTWy/waiBYgf56zo5xsEJWxHutLyfadNU'),
(2, 'Test', 'testouille@hotmail.fr', '$argon2id$v=19$m=65536,t=4,p=1$LlBabkdrTlk4ZnlaOTJVTA$1Nbda519vmRtc016NX8PResFq8I4no4EP4Jfc9oECSw');

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
  ADD KEY `key_gaming` (`game_id`);

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
  ADD KEY `key_admins` (`admin_id`);

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
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  MODIFY `game_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `gamesplateformes`
--
ALTER TABLE `gamesplateformes`
  MODIFY `gplateforme_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pegi`
--
ALTER TABLE `pegi`
  MODIFY `pegi_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `plateformes`
--
ALTER TABLE `plateformes`
  MODIFY `plateforme_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentary`
--
ALTER TABLE `commentary`
  ADD CONSTRAINT `key_gaming` FOREIGN KEY (`game_id`) REFERENCES `games` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `key_admins` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
