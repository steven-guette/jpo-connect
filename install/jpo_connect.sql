-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 01 juin 2025 à 22:27
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jpo_connect`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_visible` tinyint(1) DEFAULT 1,
  `parent_comment_fk` int(10) UNSIGNED DEFAULT NULL,
  `user_fk` int(10) UNSIGNED NOT NULL,
  `jpo_event_fk` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `content`, `created_at`, `is_visible`, `parent_comment_fk`, `user_fk`, `jpo_event_fk`) VALUES
(4, 'Hâte de découvrir les locaux et l’ambiance !', '2025-06-01 19:53:54', 1, NULL, 8, 25),
(5, 'Est-ce qu’on pourra poser des questions sur les formations ?', '2025-06-01 19:53:54', 1, NULL, 9, 25),
(6, 'J’ai entendu beaucoup de bien de cette école.', '2025-06-01 19:53:54', 1, NULL, 10, 25),
(7, 'Je viendrai avec un ami, c’est possible ?', '2025-06-01 19:53:54', 1, NULL, 11, 25),
(8, 'Aucune réponse.... Super !', '2025-06-01 21:03:07', 1, NULL, 10, 25),
(9, 'Je vous déconseille cette adresse...\n\nSi vous cherchez l\'excellence, allez plutôt sur Cannes !', '2025-06-01 21:32:59', 1, NULL, 8, 26),
(10, 'J\'ai connu mieux mais dans l\'ensemble (à moins que ce soit William sur place) vous devriez passer un bon moment...', '2025-06-01 21:38:37', 1, NULL, 8, 31),
(11, 'Le meilleur campus de La Plateforme_ !\r\n\r\nSi vous recherchez le meilleur pour votre enfant ou pour vous même, cette école est ce qui ce fait de mieux à l\'échelle internationale, toute école confondue...', '2025-06-01 21:40:37', 1, NULL, 8, 40);

-- --------------------------------------------------------

--
-- Structure de la table `content_types`
--

CREATE TABLE `content_types` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `label` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `content_types`
--

INSERT INTO `content_types` (`id`, `label`) VALUES
(1, 'text'),
(2, 'image'),
(3, 'html_block');

-- --------------------------------------------------------

--
-- Structure de la table `editable_contents`
--

CREATE TABLE `editable_contents` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `content_value` text NOT NULL,
  `last_modified` datetime DEFAULT current_timestamp(),
  `modified_by_fk` int(10) UNSIGNED DEFAULT NULL,
  `content_type_fk` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `jpo_events`
--

CREATE TABLE `jpo_events` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `current_registered` int(11) DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL,
  `practical_info` text DEFAULT NULL,
  `status_fk` tinyint(3) UNSIGNED NOT NULL,
  `location_fk` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `jpo_events`
--

INSERT INTO `jpo_events` (`id`, `title`, `description`, `start_datetime`, `end_datetime`, `max_capacity`, `current_registered`, `image_path`, `practical_info`, `status_fk`, `location_fk`) VALUES
(25, '', 'Visite des locaux et échanges avec l\'équipe pédagogique', '2025-06-09 13:00:00', '2025-06-09 17:00:00', 60, 60, 'brignoles.webp', 'Une pièce d\'identité vous sera demandée à l\'accueil.', 1, 5),
(26, '', 'Ateliers immersifs et démonstrations techniques', '2025-06-14 14:00:00', '2025-06-14 18:00:00', 60, 3, 'marseille.jpg', 'Stationnement disponible à proximité.', 1, 1),
(27, '', 'Ateliers immersifs et démonstrations techniques', '2025-06-05 08:00:00', '2025-06-05 12:00:00', 40, 31, 'brignoles.webp', 'Inscription préalable obligatoire via notre site web.', 1, 5),
(28, '', 'Ateliers immersifs et démonstrations techniques', '2025-06-25 10:00:00', '2025-06-25 14:00:00', 30, 3, 'toulon.webp', 'Inscription préalable obligatoire via notre site web.', 1, 6),
(29, '', 'Découverte des projets étudiants', '2025-06-04 11:00:00', '2025-06-04 15:00:00', 40, 14, 'brignoles.webp', 'Inscription préalable obligatoire via notre site web.', 1, 5),
(30, '', 'Présentation des parcours et opportunités', '2025-06-18 15:00:00', '2025-06-18 19:00:00', 50, 21, 'brignoles.webp', 'Inscription préalable obligatoire via notre site web.', 1, 5),
(31, '', 'Rencontres avec nos formateurs et étudiants', '2025-06-11 09:00:00', '2025-06-11 13:00:00', 40, 37, 'martigues.png', 'Stationnement disponible à proximité.', 1, 4),
(32, '', 'Visite des locaux et échanges avec l\'équipe pédagogique', '2025-06-03 15:00:00', '2025-06-03 19:00:00', 60, 8, 'brignoles.webp', 'Du gel hydroalcoolique sera mis à disposition sur place.', 1, 5),
(33, '', 'Ateliers immersifs et démonstrations techniques', '2025-06-05 10:00:00', '2025-06-05 14:00:00', 60, 0, 'martigues.png', 'Inscription préalable obligatoire via notre site web.', 1, 4),
(34, '', 'Présentation des parcours et opportunités', '2025-06-29 11:00:00', '2025-06-29 15:00:00', 60, 25, 'toulon.webp', 'Merci d\'arriver 15 minutes avant le début de la session.', 1, 6),
(35, '', 'Découverte des projets étudiants', '2025-06-07 09:00:00', '2025-06-07 13:00:00', 30, 30, 'marseille.jpg', 'Inscription préalable obligatoire via notre site web.', 1, 1),
(36, '', 'Rencontres avec nos formateurs et étudiants', '2025-06-27 12:00:00', '2025-06-27 16:00:00', 30, 2, 'toulon.webp', 'Une pièce d\'identité vous sera demandée à l\'accueil.', 1, 6),
(37, '', 'Visite des locaux et échanges avec l\'équipe pédagogique', '2025-06-21 09:00:00', '2025-06-21 13:00:00', 40, 16, 'paris.jpg', 'Merci d\'arriver 15 minutes avant le début de la session.', 1, 3),
(38, '', 'Visite des locaux et échanges avec l\'équipe pédagogique', '2025-06-25 11:00:00', '2025-06-25 15:00:00', 60, 16, 'martigues.png', 'Stationnement disponible à proximité.', 1, 4),
(39, '', 'Rencontres avec nos formateurs et étudiants', '2025-06-29 09:00:00', '2025-06-29 13:00:00', 40, 8, 'brignoles.webp', 'Une pièce d\'identité vous sera demandée à l\'accueil.', 1, 5),
(40, '', 'Rencontres avec nos formateurs et étudiants', '2025-06-26 08:00:00', '2025-06-26 12:00:00', 60, 13, 'cannes.webp', 'Stationnement disponible à proximité.', 1, 2),
(41, '', 'Visite des locaux et échanges avec l\'équipe pédagogique', '2025-06-09 15:00:00', '2025-06-09 19:00:00', 60, 11, 'paris.jpg', 'Une pièce d\'identité vous sera demandée à l\'accueil.', 1, 3),
(42, '', 'Rencontres avec nos formateurs et étudiants', '2025-06-20 12:00:00', '2025-06-20 16:00:00', 40, 14, 'toulon.webp', 'Du gel hydroalcoolique sera mis à disposition sur place.', 1, 6),
(43, '', 'Visite des locaux et échanges avec l\'équipe pédagogique', '2025-06-28 12:00:00', '2025-06-28 16:00:00', 30, 4, 'toulon.webp', 'Du gel hydroalcoolique sera mis à disposition sur place.', 1, 6),
(44, '', 'Présentation des parcours et opportunités', '2025-06-27 09:00:00', '2025-06-27 13:00:00', 60, 24, 'marseille.jpg', 'Une pièce d\'identité vous sera demandée à l\'accueil.', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `jpo_statuses`
--

CREATE TABLE `jpo_statuses` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `label` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `jpo_statuses`
--

INSERT INTO `jpo_statuses` (`id`, `label`) VALUES
(1, 'draft'),
(2, 'published'),
(3, 'canceled'),
(4, 'archived');

-- --------------------------------------------------------

--
-- Structure de la table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `city` varchar(100) NOT NULL,
  `street_number` int(11) DEFAULT NULL,
  `street_name` varchar(150) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `gps_coordinates` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `locations`
--

INSERT INTO `locations` (`id`, `city`, `street_number`, `street_name`, `zip_code`, `gps_coordinates`) VALUES
(1, 'Marseille', 8, 'Rue d’Hozier', '13002', '43.30485310684453, 5.3701133683070905'),
(2, 'Cannes', 107, 'Boulevard de la République', '06400', '43.55933381799126, 7.021135541328274'),
(3, 'Paris', 8, 'Terr. Bellini', '92800', '48.88655933817847, 2.251702683899452'),
(4, 'Martigues', NULL, 'Place du 8 mai 1945', '13500', '43.39938929730695, 5.056321412486332'),
(5, 'Brignoles', 47, 'Rue de la République', '83170', '43.407354881655955, 6.055307701845273'),
(6, 'Toulon', 131, 'Avenue Franklin Roosevelt', '83100', '43.120283276759544, 5.939651997134152');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `user_fk` int(10) UNSIGNED NOT NULL,
  `jpo_event_fk` int(10) UNSIGNED NOT NULL,
  `type_fk` tinyint(3) UNSIGNED NOT NULL,
  `status_fk` tinyint(3) UNSIGNED DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `sent_at`, `user_fk`, `jpo_event_fk`, `type_fk`, `status_fk`) VALUES
(4, NULL, 8, 25, 1, 2),
(5, NULL, 8, 25, 1, 2),
(6, NULL, 8, 25, 1, 2),
(7, NULL, 9, 25, 1, 2),
(8, NULL, 11, 25, 1, 2),
(9, NULL, 11, 26, 1, 2),
(10, NULL, 11, 25, 2, 2),
(11, NULL, 11, 27, 1, 2),
(12, NULL, 11, 26, 2, 2),
(13, NULL, 11, 25, 1, 2),
(14, NULL, 11, 27, 2, 2),
(15, NULL, 11, 28, 1, 2),
(16, NULL, 10, 25, 1, 2),
(17, NULL, 10, 34, 1, 2),
(18, NULL, 10, 25, 2, 2),
(19, NULL, 10, 25, 1, 2),
(20, NULL, 8, 31, 1, 2),
(21, NULL, 8, 40, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `notification_statuses`
--

CREATE TABLE `notification_statuses` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `label` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notification_statuses`
--

INSERT INTO `notification_statuses` (`id`, `label`) VALUES
(1, 'sent'),
(2, 'failed');

-- --------------------------------------------------------

--
-- Structure de la table `notification_types`
--

CREATE TABLE `notification_types` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `label` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notification_types`
--

INSERT INTO `notification_types` (`id`, `label`) VALUES
(1, 'confirmation'),
(2, 'cancellation');

-- --------------------------------------------------------

--
-- Structure de la table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp(),
  `canceled` tinyint(1) DEFAULT 0,
  `was_present` tinyint(1) DEFAULT 1,
  `user_fk` int(10) UNSIGNED NOT NULL,
  `jpo_event_fk` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `registrations`
--

INSERT INTO `registrations` (`id`, `updated_at`, `canceled`, `was_present`, `user_fk`, `jpo_event_fk`) VALUES
(8, '2025-06-01 15:11:16', 0, 1, 8, 25),
(9, '2025-06-01 16:40:48', 0, 1, 9, 25),
(10, '2025-06-01 18:35:51', 0, 1, 11, 25),
(11, '2025-06-01 18:04:41', 1, 0, 11, 26),
(12, '2025-06-01 18:36:12', 1, 0, 11, 27),
(13, '2025-06-01 18:37:14', 0, 1, 11, 28),
(14, '2025-06-01 20:31:25', 0, 1, 10, 25),
(15, '2025-06-01 19:08:17', 0, 1, 10, 34),
(16, '2025-06-01 21:33:33', 0, 1, 8, 31),
(17, '2025-06-01 21:39:09', 0, 1, 8, 40);

-- --------------------------------------------------------

--
-- Structure de la table `statistics`
--

CREATE TABLE `statistics` (
  `id` int(10) UNSIGNED NOT NULL,
  `total_registered` int(11) NOT NULL,
  `total_present` int(11) NOT NULL,
  `recorded_at` datetime DEFAULT current_timestamp(),
  `jpo_event_fk` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `social_provider` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `role_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 4,
  `location_fk` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `firstname`, `email`, `password`, `social_provider`, `created_at`, `role_id`, `location_fk`) VALUES
(8, 'Guette', 'Steven', 'steven.guette.pro@laplateforme.io', '$2y$10$RGxNLQBWoZtFmSq1phLWRejEeC2l0H.UqJzOvNz2zHMuzjW.6YJ76', NULL, '2025-05-31 20:46:12', 3, NULL),
(9, 'Rami', 'Thierry', 'thierry.rami.pro@laplateforme.io', '$2y$10$r2vQKQ/FX7STRkCfjPV6POUq7fNVcjmKAHRB9w3LicTip4nRltXou', NULL, '2025-05-30 20:32:20', 2, NULL),
(10, 'Ouattara', 'Aïcha', 'aicha.ouattara.pro@laplateforme.io', '$2y$10$Td.Gx6k8XVnzHHgec1j1YOvYthUOOgCs.OPseLyuzUzgY1/2iQoWO', NULL, '2025-05-30 20:32:54', 1, NULL),
(11, 'Alaria', 'Julien', 'julien.alaria@laplateforme.io', '$2y$10$gLqbwmlD2DtMHM4Y9DQSiOovYyBO.lCHyI0e08QulAFOtQ/zFsMzu', NULL, '2025-05-30 20:34:33', 4, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_comment_fk` (`parent_comment_fk`),
  ADD KEY `idx_user_fk` (`user_fk`),
  ADD KEY `idx_jpo_event_fk` (`jpo_event_fk`);

--
-- Index pour la table `content_types`
--
ALTER TABLE `content_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `editable_contents`
--
ALTER TABLE `editable_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_modified_by_fk` (`modified_by_fk`),
  ADD KEY `idx_content_type_fk` (`content_type_fk`);

--
-- Index pour la table `jpo_events`
--
ALTER TABLE `jpo_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_location_fk` (`location_fk`),
  ADD KEY `idx_status_fk` (`status_fk`);

--
-- Index pour la table `jpo_statuses`
--
ALTER TABLE `jpo_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_fk` (`user_fk`),
  ADD KEY `idx_jpo_event_fk` (`jpo_event_fk`),
  ADD KEY `idx_type_fk` (`type_fk`),
  ADD KEY `idx_status_fk` (`status_fk`);

--
-- Index pour la table `notification_statuses`
--
ALTER TABLE `notification_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_fk` (`user_fk`),
  ADD KEY `idx_jpo_event_fk` (`jpo_event_fk`);

--
-- Index pour la table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_jpo_event_fk` (`jpo_event_fk`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_location_fk` (`location_fk`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `editable_contents`
--
ALTER TABLE `editable_contents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `jpo_events`
--
ALTER TABLE `jpo_events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`parent_comment_fk`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`jpo_event_fk`) REFERENCES `jpo_events` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `editable_contents`
--
ALTER TABLE `editable_contents`
  ADD CONSTRAINT `editable_contents_ibfk_1` FOREIGN KEY (`modified_by_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `editable_contents_ibfk_2` FOREIGN KEY (`content_type_fk`) REFERENCES `content_types` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `jpo_events`
--
ALTER TABLE `jpo_events`
  ADD CONSTRAINT `jpo_events_ibfk_1` FOREIGN KEY (`location_fk`) REFERENCES `locations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jpo_events_ibfk_2` FOREIGN KEY (`status_fk`) REFERENCES `jpo_statuses` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`jpo_event_fk`) REFERENCES `jpo_events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`type_fk`) REFERENCES `notification_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_4` FOREIGN KEY (`status_fk`) REFERENCES `notification_statuses` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`user_fk`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`jpo_event_fk`) REFERENCES `jpo_events` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `statistics`
--
ALTER TABLE `statistics`
  ADD CONSTRAINT `statistics_ibfk_1` FOREIGN KEY (`jpo_event_fk`) REFERENCES `jpo_events` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`location_fk`) REFERENCES `locations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
