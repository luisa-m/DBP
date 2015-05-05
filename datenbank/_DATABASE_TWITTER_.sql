-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Mai 2015 um 20:20
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
CREATE DATABASE IF NOT EXISTS `hausarbeit_twitter` DEFAULT CHARACTER SET utf8 COLLATE utf8_german2_ci;
USE `hausarbeit_twitter`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

DROP TABLE IF EXISTS `benutzer`;
CREATE TABLE IF NOT EXISTS `benutzer` (
  `Nickname` varchar(15) COLLATE utf8_german2_ci NOT NULL,
  `Vorname` text COLLATE utf8_german2_ci NOT NULL,
  `Nachname` text COLLATE utf8_german2_ci NOT NULL,
  `Passwort` varchar(20) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `folgen`
--

DROP TABLE IF EXISTS `folgen`;
CREATE TABLE IF NOT EXISTS `folgen` (
  `Folgender` varchar(15) COLLATE utf8_german2_ci NOT NULL,
  `Gefolgter` varchar(15) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `folgen`:
--   `Folgender`
--       `benutzer` -> `Nickname`
--   `Gefolgter`
--       `benutzer` -> `Nickname`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hashtag`
--

DROP TABLE IF EXISTS `hashtag`;
CREATE TABLE IF NOT EXISTS `hashtag` (
`ID` int(11) NOT NULL,
  `Tag` varchar(15) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nachricht`
--

DROP TABLE IF EXISTS `nachricht`;
CREATE TABLE IF NOT EXISTS `nachricht` (
`ID` int(11) NOT NULL,
  `Benutzer` varchar(15) COLLATE utf8_german2_ci NOT NULL,
  `Inhalt` text COLLATE utf8_german2_ci NOT NULL,
  `Datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `nachricht`:
--   `Benutzer`
--       `benutzer` -> `Nickname`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nachricht_hashtag`
--

DROP TABLE IF EXISTS `nachricht_hashtag`;
CREATE TABLE IF NOT EXISTS `nachricht_hashtag` (
  `Nachricht` int(11) NOT NULL,
  `Hashtag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- RELATIONEN DER TABELLE `nachricht_hashtag`:
--   `Nachricht`
--       `nachricht` -> `ID`
--   `Hashtag`
--       `hashtag` -> `ID`
--

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
 ADD PRIMARY KEY (`Nickname`);

--
-- Indizes für die Tabelle `folgen`
--
ALTER TABLE `folgen`
 ADD PRIMARY KEY (`Folgender`,`Gefolgter`), ADD KEY `Gefolgter` (`Gefolgter`);

--
-- Indizes für die Tabelle `hashtag`
--
ALTER TABLE `hashtag`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `Tag` (`Tag`);

--
-- Indizes für die Tabelle `nachricht`
--
ALTER TABLE `nachricht`
 ADD PRIMARY KEY (`ID`), ADD KEY `Benutzer` (`Benutzer`);

--
-- Indizes für die Tabelle `nachricht_hashtag`
--
ALTER TABLE `nachricht_hashtag`
 ADD PRIMARY KEY (`Nachricht`,`Hashtag`), ADD KEY `Hashtag` (`Hashtag`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `hashtag`
--
ALTER TABLE `hashtag`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `nachricht`
--
ALTER TABLE `nachricht`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `folgen`
--
ALTER TABLE `folgen`
ADD CONSTRAINT `folgen_ibfk_1` FOREIGN KEY (`Folgender`) REFERENCES `benutzer` (`Nickname`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `folgen_ibfk_2` FOREIGN KEY (`Gefolgter`) REFERENCES `benutzer` (`Nickname`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `nachricht`
--
ALTER TABLE `nachricht`
ADD CONSTRAINT `nachricht_ibfk_1` FOREIGN KEY (`Benutzer`) REFERENCES `benutzer` (`Nickname`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `nachricht_hashtag`
--
ALTER TABLE `nachricht_hashtag`
ADD CONSTRAINT `nachricht_hashtag_ibfk_1` FOREIGN KEY (`Nachricht`) REFERENCES `nachricht` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `nachricht_hashtag_ibfk_2` FOREIGN KEY (`Hashtag`) REFERENCES `hashtag` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
