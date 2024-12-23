-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : mer. 27 nov. 2024 à 15:24
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
(1, 'Grégory', 'admin@admin.fr', '$2y$10$ydvlBJLRCTgCtX09FQamhuOpQAgLChhCUvxl752GnwaeZDWSYoaV2'),
(3, 'Jonathan', 'jonathan@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$cGdxSy92Tm92ZVdSODliUQ$FMkg7gsYaKDoWdnPt/kBkKerSL/4periVXz26JVMZ9o'),
(4, 'GregTest', 'gregtest@hotmail.fr', '$argon2id$v=19$m=65536,t=4,p=1$Y3U2OURUQXMxTDRYT1N0RQ$ZzXqoC34l2/VrC+ceXUeJrnRNbG2L3hqRKwZKeEoWd8');

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
(7, 'Gestion'),
(8, 'Survie'),
(9, 'Sports'),
(10, 'Battle Royale'),
(11, 'Plates-formes');

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

--
-- Déchargement des données de la table `commentary`
--

INSERT INTO `commentary` (`commentary_id`, `user_id`, `game_id`, `message`) VALUES
(3, 11, 28, 'J\'adore de ouf ça !'),
(5, 11, 28, 'J\'adooooooooooooooooooooooooore'),
(6, 11, 28, 'J\'adore ce jeu');

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `favoris_id` int NOT NULL,
  `user_id` int NOT NULL,
  `game_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `favoris`
--

INSERT INTO `favoris` (`favoris_id`, `user_id`, `game_id`) VALUES
(8, 11, 32),
(9, 11, 31),
(12, 11, 28);

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
(26, 'Grounded', 1, 33, 8, 'img/games/67375dac1d665.jpg', 'Grounded est un jeu de survie en coopération développé par Obsidian Entertainment, dans lequel les joueurs se retrouvent rétrécis à la taille d\'une fourmi et doivent survivre dans un jardin. En tant que miniatures humaines, les joueurs doivent naviguer dans un environnement gigantesque rempli d\'insectes, de plantes et d\'autres dangers naturels.', 'img/games/67375dac205ac.jpg', 'https://www.youtube.com/embed/tK7bc5icNTY?si=ttEUGQqnVCmCT2GB', 'img/games/67375dac21b47.jpg', 'img/games/67375dac24b58.jpg', 'img/games/67375dac304b6.webp', 'img/games/67375dac32d17.webp'),
(27, 'Wwe 2k24', 1, 34, 9, 'img/games/67376feb6fe53.webp', 'WWE 2K24 est un jeu vidéo de simulation de lutte, développé par 2K Games. Il fait partie de la série WWE 2K, qui propose des matchs de catch en 3D réalistes, avec des personnages issus de l’univers de la WWE (World Wrestling Entertainment). Le jeu permet aux joueurs d’incarner leurs superstars préférées, comme Cody Rhodes, Rhea Ripley ou Bianca Belair, et de participer à des affrontements dans différents types de matchs​.', 'img/games/67376feb72cb6.webp', 'https://www.youtube.com/embed/GpuRjErh-e0?si=L4JhzgWzHZDOlxsh', 'img/games/67376feb74c52.webp', 'img/games/67376feb775d5.jpg', 'img/games/67376feb793b9.jpg', 'img/games/67376feb7aba8.jpg'),
(28, 'Combat Arms', 1, 34, 1, 'img/games/673774ce86b29.webp', 'Si tu es un amateur de jeux de tir à la première personne et que tu recherches une expérience intense, rapide et dynamique, Combat Arms est fait pour toi ! Ce jeu multijoueur en ligne t’offre une variété de modes de jeu excitants, comme Capture the Flag, Last Man Standing ou encore Seize and Secure. Chaque match te met dans des situations de combat palpitantes où seul ton talent de tireur et ta stratégie feront la différence.', 'img/games/673774ce89434.jpg', 'https://www.youtube.com/embed/O1CHmlgR3ts?si=0ncmyxkHzMBvzk5n', 'img/games/673774ce8cc46.webp', 'img/games/673774ce8e2ca.webp', 'img/games/673774ce8fa0d.jpg', 'img/games/673774ce911d9.jpg'),
(29, 'Fortnite', 1, 33, 1, 'img/games/673779265cf1b.jpg', 'Fortnite est un jeu de bataille royale qui a conquis des millions de joueurs à travers le monde grâce à son gameplay unique et dynamique. Le principe est simple : 100 joueurs se battent pour être les derniers survivants sur une île. Au fur et à mesure de la partie, une tempête rétrécit la zone de jeu, forçant les joueurs à se rapprocher, ce qui intensifie l\'action.', 'img/games/673779266008d.jpg', 'https://www.youtube.com/embed/1g8QawCVYuM?si=H0ie-zEkxXjLWhkT', 'img/games/6737792661ccf.jpg', 'img/games/6737792664ae5.webp', 'img/games/673779266633d.jpg', 'img/games/6737792668a54.jpg'),
(30, 'ARK: Survival Evolved', 1, 34, 8, 'img/games/67377b4416c13.jpg', 'ARK: Survival Evolved est un jeu d\'aventure et de survie en monde ouvert, où vous vous retrouvez sur une île peuplée de dinosaures et autres créatures préhistoriques. L\'objectif principal est de survivre dans cet environnement hostile en récoltant des ressources, construisant des bases et en apprivoisant des dinosaures pour vous protéger et vous aider à explorer.', 'img/games/67377b4418adc.jpg', 'https://www.youtube.com/embed/FW9vsrPWujI?si=kkM-xzqdmAVCAAyU', 'img/games/67377b441ab0f.jpg', 'img/games/67377b441c828.webp', 'img/games/67377b441e05c.jpg', 'img/games/67377b441fe57.webp'),
(31, 'Fall Guys', 1, 31, 10, 'img/games/67377e0270f72.jpg', 'Fall Guys est un jeu vidéo multijoueur totalement déjanté où l\'objectif est de survivre à des courses d\'obstacles loufoques jusqu\'à la victoire. Vous incarnez des petites créatures appelées \"Fall Guys\", qui s\'affrontent dans des épreuves absurdes où il faut courir, sauter, plonger et parfois attraper d\'autres joueurs pour les éliminer. Le jeu se joue en plusieurs rounds où des dizaines de joueurs se battent pour atteindre la finale, dans des niveaux où la chance et la stratégie jouent un rôle crucial.', 'img/games/67377e027420f.jpg', 'https://www.youtube.com/embed/Wj3dUvGLjNQ?si=yERv0ZaTpNOrgq-v', 'img/games/67377e027562b.jpg', 'img/games/67377e027826f.jpg', 'img/games/67377e0279bd4.jpg', 'img/games/67377e027ca4e.jpg'),
(32, 'Super Mario Party', 1, 31, 11, 'img/games/67378077c1e91.jpg', 'Super Mario Party Jamboree est le jeu parfait pour les amateurs de fun, de compétition et de moments mémorables en famille ou entre amis ! Ce nouvel opus de la célèbre série Mario Party vous plonge dans l\'univers coloré et plein d\'énergie de Mario et de ses amis, avec une grande nouveauté : plus de 110 mini-jeux à découvrir !', 'img/games/67378077c37e6.jpg', 'https://www.youtube.com/embed/sZNeut6RR4I?si=b5uxTtRxltDYujGr', 'img/games/67378077c5096.jpg', 'img/games/67378077c6e2b.jpg', 'img/games/67378077c83d7.jpg', 'img/games/67378077c95c5.jpeg');

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
(66, 28, 7),
(70, 26, 1),
(71, 26, 5),
(72, 26, 6),
(73, 26, 7),
(74, 29, 1),
(75, 29, 5),
(76, 29, 6),
(77, 29, 7),
(78, 30, 1),
(79, 30, 5),
(80, 30, 6),
(81, 30, 7),
(86, 31, 1),
(87, 31, 5),
(88, 31, 6),
(89, 31, 7),
(94, 32, 6),
(100, 27, 1),
(101, 27, 5),
(102, 27, 7);

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
  `lu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`message_id`, `name`, `firstname`, `email`, `object`, `message`, `date_message`, `lu`) VALUES
(7, 'AZFZEF', 'ZEFEZFZEF', 'a@b.c', 'test', 'ezffffffffffffff', '2024-11-11 15:09:39', 'read'),
(8, 'test', 'test', 'test@b.c', 'test', 'test', '2024-11-11 15:10:37', 'read'),
(9, 'test', 'test', 'testouille@hotmail.fr', 'test', 'test', '2024-11-11 15:10:57', 'read'),
(13, 'Yorbourg', 'Steven', 'stev@yourb.com', 'demande', 'bonjour petit soucis avec l\'affichage, quand ça sera réparé ?', '2024-11-12 13:20:40', 'read'),
(14, 'Yorbourg', 'Steven', 'stev@yourb.com', 'demande', 'bonjour petit soucis avec l\'affichage, quand ça sera réparé ?', '2024-11-12 13:20:40', 'read'),
(15, 'boulou', 'le kangou', 'test@bszqefe.fr', 'lol', 'zefzefezfzefzefezfezfezf', '2024-11-12 13:33:36', 'read'),
(17, 'test', 'test', 'test@b.c', 'test', 'zefzefez', '2024-11-12 13:36:36', 'read'),
(18, 'test', 'test', 'test@b.c', 'test', 'zefzefez', '2024-11-12 13:36:36', 'read'),
(19, 'MJ', 'MJ', 'ezf@b.c', 'MJ', 'a', '2024-11-12 13:37:31', 'read'),
(20, 'MJ', 'MJ', 'ezf@b.c', 'MJ', 'a', '2024-11-12 13:37:31', 'read'),
(21, 'Eminem', 'Eminem', 'b@f.c', 'bg', 'vous êtes beaux', '2024-11-12 13:43:24', 'read'),
(22, 'test', 'test', 'efe@b.c', 'esrtf', 'zefregjunfkensfkjnsrdjsedkpozefkprozgoprekmlzefzrgzfefze', '2024-11-12 14:43:24', 'read'),
(25, 'test', 'teazdzef', 'reg@b.c', 'test', 'zefregregreg', '2024-11-12 21:02:00', 'read'),
(30, 'eqfezf', 'zefezfg', 'zef@b.xc', 'ezfezf', 'zefk,rekgre', '2024-11-12 21:47:00', 'read'),
(31, 'Test', 'Testouille', 'a@b.c', 'demande', 'salut à tous je vais bien', '2024-11-15 09:40:13', 'read'),
(32, 'gtest', 'test', 'a@b.c', 'test', 'azfefefefef', '2024-11-15 12:02:49', 'read'),
(33, 'qzfeze', 'regregr', 'a@b.c', 'zdz', 'qdzqfzfzafazfa', '2024-11-18 12:21:37', 'read');

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
(6, 3, 'Grounded', 'Grounded, développé par Obsidian Entertainment, plonge les joueurs dans un monde où l\'ordinaire devient extraordinaire. Le jeu propose une expérience unique en réduisant les joueurs à la taille d\'une fourmi, les propulsant dans un jardin ordinaire qui devient soudainement un terrain de survie immense et dangereux. Le joueur incarne un adolescent miniaturisé, perdu dans ce monde hostile, où chaque brin d\'herbe devient une tour et chaque insecte un géant terrifiant. Cette perspective innovante transforme les environnements du quotidien en un champ de bataille captivant où l\'exploration et l\'ingéniosité sont essentielles pour survivre.', 'Dans Grounded, la survie repose sur la collecte de ressources, la construction de bases, et la confection d’outils et d’armes à partir des matériaux trouvés dans le jardin. Les joueurs doivent affronter des menaces variées, comme des araignées géantes ou des coléoptères, tout en gérant leur faim, leur soif, et leurs limites physiques. Le mode multijoueur coopératif permet à plusieurs amis de s\'allier pour explorer, construire, et combattre ensemble, ajoutant une dimension sociale et stratégique au jeu. En parallèle, le mode histoire propose une quête captivante où l\'on découvre pourquoi les personnages ont été miniaturisés, ajoutant une intrigue supplémentaire au gameplay.', 'L’esthétique de Grounded mélange des graphismes colorés et détaillés, qui rendent le monde miniature vivant et crédible. Le réalisme des insectes et la représentation soignée des objets familiers à une échelle gigantesque ajoutent une touche d’émerveillement. De plus, la bande-son et les effets sonores renforcent l’immersion, entre le bruissement des herbes et les sons intimidants des créatures proches. Que ce soit pour les amateurs de jeux de survie, les passionnés d’exploration, ou ceux à la recherche d’un concept original, Grounded offre une aventure mémorable et palpitante.', 'img/reviews/06b56429f421b2f7d9edb90bb30e42d9.jpg', 'img/reviews/e3f4b20e939b7b4210514ded00f913f9.webp', 'img/reviews/aa0402d1f725193fac523e91b139eb24.jpg', '-Concept innovant\r\n-Graphismes détaillés\r\n-Mode coopératif', '-Difficulté variable\r\n-Problèmes d’IA\r\n-Optimisation variable'),
(7, 3, 'Sea of Thieves', 'Sea of Thieves, développé par Rare, invite les joueurs à incarner des pirates dans un vaste monde ouvert maritime. Ce jeu multijoueur en ligne repose sur l’exploration, les batailles navales, et la recherche de trésors enfouis sur des îles mystérieuses. Que vous voguiez seul ou en équipage, l’expérience est marquée par une liberté totale : les joueurs choisissent leur propre voie, qu’il s’agisse de chasse au trésor, de commerce, ou de piraterie. Chaque session est une aventure unique grâce à la combinaison d’événements aléatoires, d’interactions avec d’autres joueurs, et de quêtes variées.', 'Le cœur du jeu réside dans la navigation et la coopération entre membres d’équipage. Les joueurs doivent collaborer pour manœuvrer leur navire, tirer au canon, et réparer les dégâts, ce qui donne lieu à des moments épiques et souvent hilarants. En plus de son système de progression basé sur la réputation, Sea of Thieves propose des aventures narratives ponctuelles et des saisons avec du contenu mis à jour régulièrement. Le style artistique coloré et la bande-son immersive renforcent l’ambiance d’une époque de piraterie fantaisiste.', 'Si Sea of Thieves brille par son atmosphère et sa créativité, il n’est pas sans défauts. Certains joueurs critiquent un manque de direction pour ceux qui préfèrent des objectifs clairs, tandis que les interactions avec d\'autres joueurs peuvent devenir répétitives ou frustrantes, notamment avec des attaques incessantes. Cependant, pour ceux qui apprécient l’idée d’écrire leur propre histoire de pirate, le jeu offre une expérience inégalée et sans contraintes.', 'img/reviews/63258c77042a24845a8289bc1235fd26.webp', 'img/reviews/ee5f5a817e9fdc91fcd85936a7e55799.jpg', 'img/reviews/d68962a047182d11cf8cbdcbb9e28343.jpg', '-Exploration en monde ouvert\r\n-Graphismes et ambiance\r\n-Coopération unique\r\n-Mises à jour régulières\r\n-Expériences imprévisibles', '-Interactions PvP frustrantes\r\n-Contenu répétitif\r\n-Temps morts\r\n-Départ difficile pour les nouveaux joueurs'),
(8, 3, 'Monster Hunter', 'Monster Hunter: World, développé par Capcom, plonge les joueurs dans un monde ouvert où l\'objectif principal est de traquer et d\'affronter des créatures gigantesques. Le jeu combine exploration, stratégie et combats intenses dans un environnement riche et détaillé. En tant que chasseur, vous devrez utiliser un large éventail d\'armes et de tactiques pour abattre vos ennemis, tout en collectant des matériaux pour améliorer votre équipement et vos capacités. Avec son système de quête ouvert et ses missions de groupe, Monster Hunter: World offre une expérience de jeu variée et engageante.', 'Les batailles contre les monstres sont l\'essence même du jeu, demandant des compétences, de la patience et une excellente gestion de l’environnement. Le monde du jeu est vivant et réactif, avec des écosystèmes complexes et des créatures interagissant de manière dynamique entre elles. Le jeu encourage aussi la coopération entre joueurs, permettant de former des équipes pour affronter des monstres encore plus puissants. Chaque victoire est une célébration de travail d’équipe, de stratégie et de persévérance.', 'Cependant, bien que Monster Hunter: World offre une expérience immersive et palpitante, il n’est pas sans défauts. Sa courbe d\'apprentissage peut être intimidante pour les nouveaux joueurs, et le gameplay peut devenir répétitif à long terme. De plus, bien que les combats soient extrêmement satisfaisants, certains joueurs peuvent trouver le manque de profondeur de l\'histoire un peu décevant.\r\n\r\n', 'img/reviews/7edf54c6ddfa52228140e64a75980556.jpg', 'img/reviews/40b219d2bdc2dda8cf1176a7246eb4fa.webp', 'img/reviews/70c9b31b8200da83a8176cd481e297b8.jpg', '-Monde ouvert et vaste\r\n-Combats dynamiques et stratégiques\r\n-Immersion dans un écosystème vivant\r\n-Système de progression enrichissant\r\n-Contenu varié et multijoueur coopératif', '-Problèmes d’équilibrage pour certains types d’armes\r\n-Quelques bugs et problèmes de connexion en ligne\r\n-Manque d’histoire approfondi'),
(9, 3, 'Hollow Knight', 'Hollow Knight, développé par Team Cherry, est un jeu d\'action-aventure en 2D se déroulant dans le royaume souterrain de Hallownest. Les joueurs incarnent un chevalier sans nom, un insecte en quête de vérité dans un monde magnifique mais dévasté. Ce jeu propose une exploration libre, où chaque recoin cache des secrets à découvrir et des défis à relever. Le gameplay est centré sur les combats fluides et les capacités que l\'on acquiert au fur et à mesure de l\'aventure, tout en affrontant des boss impressionnants et en découvrant une riche mythologie.', 'L’un des points forts de Hollow Knight réside dans sa mécanique d\'exploration ouverte. Les joueurs peuvent s\'aventurer librement dans le monde vaste et interconnecté, mais cela vient avec un défi constant. La difficulté du jeu est présente, non seulement à travers les combats intenses, mais aussi dans les puzzles environnementaux et les ennemis redoutables qui exigent patience et précision. Le monde de Hallownest est d\'une beauté particulière, avec une direction artistique envoûtante et une bande-son émotive qui plonge le joueur dans une atmosphère unique.', 'Cependant, bien que Hollow Knight soit un jeu acclamé par la critique, il comporte quelques inconvénients. La difficulté peut être décourageante pour certains, avec des passages très complexes, et l\'absence d\'indices clairs peut rendre l\'exploration encore plus ardue. La progression peut également sembler lente pour ceux qui cherchent à avancer rapidement, et bien que l\'absence de narration directe soit un choix artistique intéressant, elle peut ne pas convenir à tous les joueurs.', 'img/reviews/860aa20d266c2958e24479ae58b0a1a4.webp', 'img/reviews/73a07adda3ce00598424c33c682a220e.jpg', 'img/reviews/2e49344bb0891ed612c377a6ed0d0a6f.jpg', '-Monde vaste et interconnecté\r\n-Combats fluides et exigeants\r\n-Direction artistique et ambiance immersive\r\n-Contenu riche et varié\r\n-Atmosphère unique', '-Difficulté élevée\r\n-Manque d\'indices pour la progression\r\n-Quelques moments de frustration');

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
(11, 'Wiggle', 'wiggle@hotmail.fr', '$argon2id$v=19$m=65536,t=4,p=1$UjRvbXhTcU4uNXg2Y21DTA$7KTJvJDZNRQ/ABJRKCr0kNQ2JmQu9deZo7sRQzBJ3ZM'),
(12, 'Boulou', 'boulou@hotmail.fr', '$argon2id$v=19$m=65536,t=4,p=1$RVpFTm9lUVpaTkRRSFNPdQ$t8/O+noOvnp4fQKUbusMDprflEyUb7Bb8sUegO3on8w');

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
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `commentary`
--
ALTER TABLE `commentary`
  MODIFY `commentary_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `favoris`
--
ALTER TABLE `favoris`
  MODIFY `favoris_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `gamesplateformes`
--
ALTER TABLE `gamesplateformes`
  MODIFY `gplateforme_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `pegi`
--
ALTER TABLE `pegi`
  MODIFY `pegi_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `plateformes`
--
ALTER TABLE `plateformes`
  MODIFY `plateforme_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
