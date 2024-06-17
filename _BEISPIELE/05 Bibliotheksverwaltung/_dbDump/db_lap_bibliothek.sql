-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 26. Okt 2023 um 12:52
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `db_fullstack_bibliothek`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_ausborgeliste`
--

CREATE TABLE `tbl_ausborgeliste` (
  `IDAusborgeliste` int(10) UNSIGNED NOT NULL,
  `FIDUser` int(10) UNSIGNED NOT NULL,
  `FIDBuch` int(10) UNSIGNED NOT NULL,
  `Beginn` date NOT NULL,
  `Ende` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_ausborgeliste`
--

INSERT INTO `tbl_ausborgeliste` (`IDAusborgeliste`, `FIDUser`, `FIDBuch`, `Beginn`, `Ende`) VALUES
(1, 1, 1, '2020-06-03', NULL),
(2, 1, 2, '2020-06-01', '2020-07-05'),
(3, 3, 2, '2020-05-03', '2020-05-11'),
(4, 2, 5, '2020-06-16', NULL),
(5, 2, 4, '2020-06-16', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_autoren`
--

CREATE TABLE `tbl_autoren` (
  `IDAutor` int(10) UNSIGNED NOT NULL,
  `FIDPerson` int(10) UNSIGNED NOT NULL,
  `Titel` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_autoren`
--

INSERT INTO `tbl_autoren` (`IDAutor`, `FIDPerson`, `Titel`) VALUES
(1, 1, 'Dr.'),
(2, 2, ''),
(3, 6, 'Mag.'),
(4, 7, ''),
(5, 8, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_buecher`
--

CREATE TABLE `tbl_buecher` (
  `IDBuch` int(10) UNSIGNED NOT NULL,
  `Titel` varchar(128) NOT NULL,
  `Erscheinungsdatum` date NOT NULL,
  `Auflage` tinyint(3) UNSIGNED NOT NULL,
  `FIDVerlag` int(10) UNSIGNED NOT NULL,
  `ISBN` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_buecher`
--

INSERT INTO `tbl_buecher` (`IDBuch`, `Titel`, `Erscheinungsdatum`, `Auflage`, `FIDVerlag`, `ISBN`) VALUES
(1, 'PHP & MySQL', '2018-05-12', 1, 1, '3452384023984'),
(2, 'Einführung in Javascript', '2020-07-04', 4, 2, '3948750324'),
(3, 'Grundlagen der Datenbankprogrammierung', '2016-12-12', 3, 1, '34446446'),
(4, 'Adobe Illustrator', '2019-10-17', 3, 3, '346464646'),
(5, 'Adobe Photoshop', '2019-07-08', 4, 3, '098683843434');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_buecher_autoren`
--

CREATE TABLE `tbl_buecher_autoren` (
  `IDBA` int(10) UNSIGNED NOT NULL,
  `FIDAutor` int(10) UNSIGNED NOT NULL,
  `FIDBuch` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_buecher_autoren`
--

INSERT INTO `tbl_buecher_autoren` (`IDBA`, `FIDAutor`, `FIDBuch`) VALUES
(4, 1, 2),
(5, 2, 2),
(7, 2, 3),
(8, 3, 1),
(6, 3, 2),
(9, 3, 3),
(1, 4, 4),
(2, 5, 4),
(3, 5, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_personen`
--

CREATE TABLE `tbl_personen` (
  `IDPerson` int(10) UNSIGNED NOT NULL,
  `Vorname` varchar(32) NOT NULL,
  `Nachname` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_personen`
--

INSERT INTO `tbl_personen` (`IDPerson`, `Vorname`, `Nachname`) VALUES
(1, 'Heinz', 'Fischer'),
(2, 'Klaus-Maria', 'Brandauer'),
(3, 'Uwe', 'Mutz'),
(4, 'Andeas', 'Maierhuber'),
(5, 'Sandra', 'Hinterhofer'),
(6, 'Sabine', 'Maier'),
(7, 'Harald', 'Müller'),
(8, 'Harald', 'Maierhofer');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_staaten`
--

CREATE TABLE `tbl_staaten` (
  `IDStaat` int(10) UNSIGNED NOT NULL,
  `Staat` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_staaten`
--

INSERT INTO `tbl_staaten` (`IDStaat`, `Staat`) VALUES
(2, 'Deutschland'),
(1, 'Österreich');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_user`
--

CREATE TABLE `tbl_user` (
  `IDUser` int(10) UNSIGNED NOT NULL,
  `FIDPerson` int(10) UNSIGNED NOT NULL,
  `Emailadresse` varchar(64) NOT NULL,
  `Adresse` varchar(32) NOT NULL,
  `PLZ` smallint(5) UNSIGNED NOT NULL,
  `Ort` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_user`
--

INSERT INTO `tbl_user` (`IDUser`, `FIDPerson`, `Emailadresse`, `Adresse`, `PLZ`, `Ort`) VALUES
(1, 3, 'uwe.mutz@syne.at', 'Meine Straße 1', 4020, 'Linz'),
(2, 4, 'a.m@test.at', 'Steinweg 7', 4600, 'Wels'),
(3, 5, 'sandra@yahoo.de', 'Hinterhoferstr. 99', 4020, 'Linz');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_verlage`
--

CREATE TABLE `tbl_verlage` (
  `IDVerlag` int(10) UNSIGNED NOT NULL,
  `Verlag` varchar(64) NOT NULL,
  `Ort` varchar(64) NOT NULL,
  `FIDStaat` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_verlage`
--

INSERT INTO `tbl_verlage` (`IDVerlag`, `Verlag`, `Ort`, `FIDStaat`) VALUES
(1, 'Rheinwerk', 'Bonn', 2),
(2, 'Addison-Wesley', 'Berlin', 2),
(3, 'Rheinwerk Design', 'Bonn', 2);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_ausborgeliste`
--
ALTER TABLE `tbl_ausborgeliste`
  ADD PRIMARY KEY (`IDAusborgeliste`),
  ADD UNIQUE KEY `FIDUser` (`FIDUser`,`FIDBuch`,`Beginn`),
  ADD KEY `tbl_ausborgeliste_ibfk_1` (`FIDBuch`);

--
-- Indizes für die Tabelle `tbl_autoren`
--
ALTER TABLE `tbl_autoren`
  ADD PRIMARY KEY (`IDAutor`),
  ADD KEY `FIDPerson` (`FIDPerson`);

--
-- Indizes für die Tabelle `tbl_buecher`
--
ALTER TABLE `tbl_buecher`
  ADD PRIMARY KEY (`IDBuch`),
  ADD KEY `FIDVerlag` (`FIDVerlag`);

--
-- Indizes für die Tabelle `tbl_buecher_autoren`
--
ALTER TABLE `tbl_buecher_autoren`
  ADD PRIMARY KEY (`IDBA`),
  ADD UNIQUE KEY `FIDAutor` (`FIDAutor`,`FIDBuch`),
  ADD KEY `tbl_buecher_autoren_ibfk_2` (`FIDBuch`);

--
-- Indizes für die Tabelle `tbl_personen`
--
ALTER TABLE `tbl_personen`
  ADD PRIMARY KEY (`IDPerson`);

--
-- Indizes für die Tabelle `tbl_staaten`
--
ALTER TABLE `tbl_staaten`
  ADD PRIMARY KEY (`IDStaat`),
  ADD UNIQUE KEY `Staat` (`Staat`);

--
-- Indizes für die Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`IDUser`),
  ADD KEY `FIDPerson` (`FIDPerson`);

--
-- Indizes für die Tabelle `tbl_verlage`
--
ALTER TABLE `tbl_verlage`
  ADD PRIMARY KEY (`IDVerlag`),
  ADD KEY `FIDStaat` (`FIDStaat`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_ausborgeliste`
--
ALTER TABLE `tbl_ausborgeliste`
  MODIFY `IDAusborgeliste` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `tbl_autoren`
--
ALTER TABLE `tbl_autoren`
  MODIFY `IDAutor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `tbl_buecher`
--
ALTER TABLE `tbl_buecher`
  MODIFY `IDBuch` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `tbl_buecher_autoren`
--
ALTER TABLE `tbl_buecher_autoren`
  MODIFY `IDBA` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `tbl_personen`
--
ALTER TABLE `tbl_personen`
  MODIFY `IDPerson` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `tbl_staaten`
--
ALTER TABLE `tbl_staaten`
  MODIFY `IDStaat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `IDUser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `tbl_verlage`
--
ALTER TABLE `tbl_verlage`
  MODIFY `IDVerlag` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_ausborgeliste`
--
ALTER TABLE `tbl_ausborgeliste`
  ADD CONSTRAINT `tbl_ausborgeliste_ibfk_1` FOREIGN KEY (`FIDBuch`) REFERENCES `tbl_buecher` (`IDBuch`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_ausborgeliste_ibfk_2` FOREIGN KEY (`FIDUser`) REFERENCES `tbl_user` (`IDUser`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_autoren`
--
ALTER TABLE `tbl_autoren`
  ADD CONSTRAINT `tbl_autoren_ibfk_1` FOREIGN KEY (`FIDPerson`) REFERENCES `tbl_personen` (`IDPerson`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_buecher`
--
ALTER TABLE `tbl_buecher`
  ADD CONSTRAINT `tbl_buecher_ibfk_1` FOREIGN KEY (`FIDVerlag`) REFERENCES `tbl_verlage` (`IDVerlag`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_buecher_autoren`
--
ALTER TABLE `tbl_buecher_autoren`
  ADD CONSTRAINT `tbl_buecher_autoren_ibfk_1` FOREIGN KEY (`FIDAutor`) REFERENCES `tbl_autoren` (`IDAutor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_buecher_autoren_ibfk_2` FOREIGN KEY (`FIDBuch`) REFERENCES `tbl_buecher` (`IDBuch`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`FIDPerson`) REFERENCES `tbl_personen` (`IDPerson`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_verlage`
--
ALTER TABLE `tbl_verlage`
  ADD CONSTRAINT `tbl_verlage_ibfk_1` FOREIGN KEY (`FIDStaat`) REFERENCES `tbl_staaten` (`IDStaat`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
