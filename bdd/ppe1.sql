-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 10 mars 2019 à 00:46
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ppe1`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `resSalle`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `resSalle` (IN `deb` DATETIME, IN `fin` DATETIME, IN `info` BOOLEAN, IN `ligue` INT, IN `places` INT, IN `nom` VARCHAR(255) CHARSET utf8, IN `description` TEXT CHARSET utf8)  begin
set @classrooms = (select id
              from classrooms
              where locked_at is null
              and computerized = info
              and number_places >= places
              and id not in (select classrooms.id
                                    from events
                                    join classrooms on events.id_classroom=classrooms.id
                                    where
                                    locked_at is null
                                    and computerized = info
                                    and ( deb between start and end and fin between start and end )
                                    or  ( deb < start and fin > end )
                                    or  ( deb < start and fin between start and end )
                                    or  ( deb between start and end and fin > end))
                                    limit 1);
if ((@classrooms is not null) and (deb<fin)) then
	insert into events (name, start, end, id_league, id_classroom, description)
    values (nom, deb, fin, ligue, @classrooms, description);
    SELECT 1;
ELSE
    SELECT 0;
end if;
if (@classrooms is null ) then
	signal sqlstate '45000' set message_text = 'Reservation impossible pour les critères choisis';
end if;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `classrooms`
--

DROP TABLE IF EXISTS `classrooms`;
CREATE TABLE IF NOT EXISTS `classrooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `number_places` int(11) NOT NULL,
  `computerized` tinyint(1) NOT NULL,
  `locked_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `classrooms`
--

INSERT INTO `classrooms` (`id`, `name`, `number_places`, `computerized`, `locked_at`) VALUES
(1, 'Nikolas', 30, 0, NULL),
(2, 'Aston', 30, 0, NULL),
(3, 'Becquerel', 30, 0, NULL),
(4, 'Bohr', 30, 0, NULL),
(5, 'Carnot', 30, 0, NULL),
(6, 'Copernic', 18, 0, NULL),
(7, 'Curie', 18, 0, NULL),
(8, 'Dirac', 18, 0, NULL),
(9, 'Doppler', 18, 0, NULL),
(10, 'Darwin', 30, 0, '2019-03-09 07:39:22'),
(11, 'Kepler', 18, 1, NULL),
(12, 'Maxwell', 18, 1, NULL),
(13, 'Newton', 18, 1, NULL),
(14, 'Sievert', 18, 1, NULL),
(15, 'Thomson', 18, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT 'Réservation en attente',
  `description` text,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `id_league` int(11) NOT NULL,
  `id_classroom` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_league` (`id_league`),
  KEY `id_classroom` (`id_classroom`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `start`, `end`, `id_league`, `id_classroom`) VALUES
(10, 'yep', NULL, '2019-03-14 09:00:00', '2019-03-14 10:00:00', 1, 2),
(11, 'booked', '', '2019-03-09 00:00:00', '2019-03-09 23:59:00', 3, 11),
(17, 'Test', 'oui', '2019-03-10 00:30:00', '2019-03-10 23:30:00', 1, 1),
(19, '14', '', '2019-03-10 00:00:00', '2019-03-10 23:59:00', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `leagues`
--

DROP TABLE IF EXISTS `leagues`;
CREATE TABLE IF NOT EXISTS `leagues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sport` varchar(50) NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `locket_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `leagues`
--

INSERT INTO `leagues` (`id`, `name`, `sport`, `phone_number`, `locket_at`) VALUES
(0, 'Administrateur', '', '0628521624', NULL),
(1, 'AC Caen', 'basketball', '0230313233', NULL),
(2, 'AC Lisieux', 'basketball', '0231323334', NULL),
(3, 'AC Bayeux', 'basketball', '0232333435', NULL),
(4, 'FC Caen', 'football', '0233343536', NULL),
(5, 'FC Lisieux', 'football', '0234353637', NULL),
(6, 'FC Bayeux', 'football', '0235363738', NULL),
(7, 'RC Caen', 'rugby', '0236373839', NULL),
(8, 'RC Bayeux', 'rugby', '0237383940', NULL),
(9, 'VC Caen', 'volleyball', '0238394041', NULL),
(10, 'VC Bayeux', 'volleyball', '0239404142', NULL),
(11, 'AC Caen', 'basketball', '0230313233', NULL),
(12, 'AC Lisieux', 'basketball', '0231323334', NULL),
(13, 'AC Bayeux', 'basketball', '0232333435', NULL),
(14, 'FC Caen', 'football', '0233343536', NULL),
(15, 'FC Lisieux', 'football', '0234353637', NULL),
(16, 'FC Bayeux', 'football', '0235363738', NULL),
(17, 'RC Caen', 'rugby', '0236373839', NULL),
(18, 'RC Bayeux', 'rugby', '0237383940', NULL),
(19, 'VC Caen', 'volleyball', '0238394041', NULL),
(20, 'VC Bayeux', 'volleyball', '0239404142', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirmation_token` varchar(60) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `reset_token` varchar(60) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL,
  `id_league` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_league` (`id_league`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `confirmation_token`, `confirmed_at`, `reset_token`, `reset_at`, `remember_token`, `locked_at`, `id_league`) VALUES
(1, 'Benjamin', 'benjaminhaise@gmail.com', '$2y$10$FsOOgZgYDa.qZGAsLlUedeQt1L4lUGyLnOEti1p2zz5vTjhTYZZzK', NULL, '2019-02-02 00:00:00', NULL, NULL, 'FwTl8YxyZaBC5URO8XFmE6TCQnAb5NyoB6s5ZrqlYkwub3SsK77EwN5wlytsT3MNjC0Lhlq006fwcSgrAfuOFkwF7c9SIdCXAvQjhRuEBLjrYvhFzQgPPmGtLqwgRPA1PpD9Id1yIrmOiT0tLoBqFxRLUKeKVgtctKs8wSulACds6l0NNw6XlbpRMYXVBqyrOLNTKEL1NvZiS7hmslviN8qHpijRSjc2hGpGH8EqJIBoHVZBR7t8cVXjaKBAamB', NULL, 0),
(2, 'User', 'user@m2n.fr', '$2y$10$/ArgX/XErXbaIwu2XuM6KOHS/LNcwgmz4IfEmO0hHIxXwSjCgHy8S', NULL, '2019-02-02 00:00:00', NULL, NULL, NULL, NULL, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
