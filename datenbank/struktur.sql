-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Mai 2015 um 11:40
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

CREATE TABLE IF NOT EXISTS `benutzer` (
  `Nickname` varchar(40) COLLATE utf8_german2_ci NOT NULL,
  `Vorname` varchar(40) COLLATE utf8_german2_ci NOT NULL,
  `Nachname` varchar(40) COLLATE utf8_german2_ci NOT NULL,
  `Passwort` varchar(200) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `folgen`
--

CREATE TABLE IF NOT EXISTS `folgen` (
  `Folgender` varchar(40) COLLATE utf8_german2_ci NOT NULL,
  `Gefolgter` varchar(40) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `hashtag`
--

CREATE TABLE IF NOT EXISTS `hashtag` (
`ID` int(11) NOT NULL,
  `Tag` varchar(40) COLLATE utf8_german2_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nachricht`
--

CREATE TABLE IF NOT EXISTS `nachricht` (
`ID` int(11) NOT NULL,
  `Benutzer` varchar(40) COLLATE utf8_german2_ci NOT NULL,
  `Inhalt` text COLLATE utf8_german2_ci NOT NULL,
  `Datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

--
-- Trigger `nachricht`
--
DELIMITER //
CREATE TRIGGER `nachricht_insert_hashtag` AFTER INSERT ON `nachricht`
 FOR EACH ROW BEGIN
SET @REST = NEW.Inhalt;
WHILE @REST LIKE '%#%' DO
	SET @STARTPOS = LOCATE('#', @REST);
    SET @ENDPOS = @STARTPOS + 1;
    WHILE(@ENDPOS <= CHAR_LENGTH(@REST) AND SUBSTRING(@REST, @ENDPOS, 1) REGEXP '[[:alnum:]]') DO
        SET @ENDPOS = @ENDPOS + 1;    
    END WHILE;   
    SET @TAG = SUBSTRING(@REST, @STARTPOS+1, @ENDPOS-@STARTPOS-1);
    SET @REST = SUBSTRING(@REST, @ENDPOS);
    IF NOT EXISTS(SELECT ID FROM hashtag WHERE Tag = @TAG) THEN
      INSERT INTO hashtag(Tag) VALUES(@TAG);    
    END IF;
    SET @ID = (SELECT ID FROM hashtag WHERE Tag = @TAG);  
    INSERT INTO nachricht_hashtag(Nachricht, Hashtag) VALUES(NEW.ID, @ID);
END WHILE;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nachricht_hashtag`
--

CREATE TABLE IF NOT EXISTS `nachricht_hashtag` (
  `Nachricht` int(11) NOT NULL,
  `Hashtag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_german2_ci;

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
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT für Tabelle `nachricht`
--
ALTER TABLE `nachricht`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=84;
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
