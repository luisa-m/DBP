-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Mai 2015 um 11:52
-- Server Version: 5.6.21
-- PHP-Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `hausarbeit_twitter`
--

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`Nickname`, `Vorname`, `Nachname`, `Passwort`) VALUES
('kevin', 'Kevin', 'Sanders', '563f29a915b0dda42fff7ad6c90edf6f513ca94e88e2b1eb37745ae163415e9a'),
('koelnziege', 'Lena', 'Peter', '0383bc5714f2eaa3ce62acb638b609d45dc64104fb109805e0e0409f1e458c62'),
('lars', 'Lars', 'Brune', 'a659c5691cd65f0208ba93367bd8aeef92d3b800ca702a8df469b07731283b03'),
('luisa', 'Luisa', 'Milka', '7105478369b6b49234c2195cf6fefec02ac17a18b84dfad4bf41d5a18a19e22e'),
('Testuser', 'Max', 'Mustermann', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),
('tom', 'Tom', 'Tester', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');

--
-- Daten für Tabelle `folgen`
--

INSERT INTO `folgen` (`Folgender`, `Gefolgter`) VALUES
('luisa', 'kevin'),
('Testuser', 'kevin'),
('tom', 'kevin'),
('kevin', 'koelnziege'),
('lars', 'koelnziege'),
('luisa', 'koelnziege'),
('Testuser', 'koelnziege'),
('kevin', 'lars'),
('koelnziege', 'lars'),
('luisa', 'lars'),
('Testuser', 'Lars'),
('tom', 'Lars'),
('koelnziege', 'luisa'),
('lars', 'luisa'),
('tom', 'luisa'),
('Testuser', 'Testuser'),
('tom', 'Testuser'),
('tom', 'tom');

--
-- Daten für Tabelle `hashtag`
--

INSERT INTO `hashtag` (`ID`, `Tag`) VALUES
(8, 'cool '),
(7, 'Datenbankprogrammierung '),
(20, 'dowomerhingehüre'),
(16, 'effzeh '),
(15, 'Endspurt '),
(19, 'erstebundesliga '),
(12, 'Fleißig '),
(6, 'GAD '),
(9, 'Hallo '),
(80, 'Hameln'),
(18, 'klassenerhalt '),
(3, 'Köln '),
(17, 'KOES04 '),
(10, 'Leute'),
(5, 'määh'),
(11, 'Posten '),
(13, 'programmieren '),
(1, 'schönes '),
(22, 'sonnen '),
(14, 'Spaß'),
(78, 'super'),
(4, 'super. '),
(82, 'toll'),
(79, 'Vorstellen'),
(21, 'Weser '),
(2, 'Wetter '),
(81, 'yolo');

--
-- Daten für Tabelle `nachricht`
--

INSERT INTO `nachricht` (`ID`, `Benutzer`, `Inhalt`, `Datum`) VALUES
(1, 'kevin', 'Heute ist #schönes #Wetter !', '2015-05-07 19:30:15'),
(2, 'koelnziege', '#Köln ist #super. #määh', '2015-05-07 19:32:15'),
(3, 'lars', '#GAD rockt', '2015-05-07 19:34:59'),
(6, 'kevin', '#Datenbankprogrammierung ist #cool ', '2015-05-11 15:34:52'),
(7, 'luisa', '#Hallo #Leute', '2015-05-11 21:33:51'),
(10, 'luisa', '#Posten ist #cool ', '2015-05-12 10:42:02'),
(12, 'lars', '#Fleißig am #programmieren für #Datenbankprogrammierung', '2015-05-12 11:04:20'),
(13, 'koelnziege', '#Datenbankprogrammierung macht #Spaß', '2015-05-12 11:05:26'),
(14, 'lars', '#Endspurt #Datenbankprogrammierung', '2015-05-12 12:47:06'),
(15, 'koelnziege', '2:0 Heimsieg für den 1. FC Köln gegen Schalke 04!\r\n#effzeh #KOES04 #klassenerhalt #erstebundesliga #dowomerhingehüre', '2015-05-12 12:48:58'),
(16, 'kevin', 'An der #Weser #sonnen  8-)', '2015-05-12 12:49:49'),
(84, 'kevin', '#Spaß beim #Vorstellen', '2015-05-20 09:30:46'),
(85, 'kevin', 'Früh am Morgen im schönen #Hameln', '2015-05-20 09:33:20'),
(86, 'Testuser', 'Testat #Datenbankprogrammierung #yolo', '2015-05-20 10:24:49'),
(87, 'tom', '#Datenbankprogrammierung ist #toll', '2015-05-20 10:27:34');

--
-- Daten für Tabelle `nachricht_hashtag`
--

INSERT INTO `nachricht_hashtag` (`Nachricht`, `Hashtag`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 5),
(3, 6),
(6, 7),
(12, 7),
(13, 7),
(14, 7),
(86, 7),
(87, 7),
(6, 8),
(10, 8),
(7, 9),
(7, 10),
(10, 11),
(12, 12),
(12, 13),
(13, 14),
(84, 14),
(14, 15),
(15, 16),
(15, 17),
(15, 18),
(15, 19),
(15, 20),
(16, 21),
(16, 22),
(2, 78),
(84, 79),
(85, 80),
(86, 81),
(87, 82);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
