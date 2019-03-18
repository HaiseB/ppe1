-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 26 fév. 2019 à 14:05
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  'tutocalendar'
--

-- --------------------------------------------------------

--
-- Structure de la table 'events'
--

DROP TABLE IF EXISTS 'events';
CREATE TABLE IF NOT EXISTS 'events' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'name' varchar(255) NOT NULL,
  'description' text,
  'start' datetime NOT NULL,
  'end' datetime NOT NULL,
  PRIMARY KEY ('id')
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table 'events'
--

INSERT INTO 'events' ('id', 'name', 'description', 'start', 'end') VALUES
(1, 'Test', '', '2019-02-19 10:00:00', '2019-02-19 12:00:00'),
(2, 'OUI OUI', 'Pour le chien titouan', '2019-02-19 13:00:00', '2019-02-19 17:00:00'),
(3, 'Piscine', '10 longeurs dans le grand bassin', '2019-02-20 12:15:00', '2019-02-20 14:00:00'),
(4, 'Demo', '', '2000-02-27 01:59:00', '2000-02-27 10:00:00'),
(5, 'Demo', '2', '2019-03-03 04:50:00', '2019-03-03 06:04:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
