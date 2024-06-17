-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 26. Okt 2023 um 14:22
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
-- Datenbank: `db_fullstack_fahrradclub`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_ausfluege`
--

CREATE TABLE `tbl_ausfluege` (
  `IDAusflug` int(10) UNSIGNED NOT NULL,
  `Ausflugstitel` varchar(64) NOT NULL,
  `Beschreibung` text DEFAULT NULL,
  `Beginn` datetime NOT NULL,
  `Ende` datetime NOT NULL,
  `Distanz` smallint(4) UNSIGNED NOT NULL COMMENT 'in ganzen Kilometern'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_fahrradmarken`
--

CREATE TABLE `tbl_fahrradmarken` (
  `IDFahrradmarke` int(10) UNSIGNED NOT NULL,
  `Markenname` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_fahrradmarken`
--

INSERT INTO `tbl_fahrradmarken` (`IDFahrradmarke`, `Markenname`) VALUES
(5, 'Cannondale'),
(8, 'Cube'),
(9, 'Electra'),
(11, 'Ghost'),
(10, 'Giant'),
(6, 'GT'),
(12, 'Haibike'),
(1, 'KTM'),
(13, 'Merida'),
(7, 'Scott'),
(4, 'Simplon'),
(2, 'Specialized'),
(3, 'Trek');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_fahrradtypen`
--

CREATE TABLE `tbl_fahrradtypen` (
  `IDFahrradtyp` int(10) UNSIGNED NOT NULL,
  `Typ` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tbl_fahrradtypen`
--

INSERT INTO `tbl_fahrradtypen` (`IDFahrradtyp`, `Typ`) VALUES
(4, 'BMX'),
(3, 'Citybike'),
(5, 'E-Bike'),
(1, 'Mountainbike (MTB)'),
(2, 'Rennrad');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_fahrraeder`
--

CREATE TABLE `tbl_fahrraeder` (
  `IDFahrrad` int(10) UNSIGNED NOT NULL,
  `FIDMarke` int(10) UNSIGNED NOT NULL,
  `Modell` varchar(64) NOT NULL,
  `FIDFahrradtyp` int(10) UNSIGNED NOT NULL,
  `FIDMitglied` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_gruppen`
--

CREATE TABLE `tbl_gruppen` (
  `IDGruppe` int(10) UNSIGNED NOT NULL,
  `Gruppenname` varchar(64) NOT NULL,
  `Beschreibung` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_mitglieder`
--

CREATE TABLE `tbl_mitglieder` (
  `IDMitglied` int(10) UNSIGNED NOT NULL,
  `Vorname` varchar(32) NOT NULL,
  `Nachname` varchar(32) NOT NULL,
  `Emailadresse` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_mitglieder_ausfluege`
--

CREATE TABLE `tbl_mitglieder_ausfluege` (
  `IDMitgliedAusflug` int(10) UNSIGNED NOT NULL,
  `FIDMitglied` int(10) UNSIGNED NOT NULL,
  `FIDAusflug` int(10) UNSIGNED DEFAULT NULL,
  `Anmeldezeitpunkt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_mitglieder_gruppen`
--

CREATE TABLE `tbl_mitglieder_gruppen` (
  `IDMitgliedGruppe` int(10) UNSIGNED NOT NULL,
  `FIDMitglied` int(10) UNSIGNED NOT NULL,
  `FIDGruppe` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_ausfluege`
--
ALTER TABLE `tbl_ausfluege`
  ADD PRIMARY KEY (`IDAusflug`);

--
-- Indizes für die Tabelle `tbl_fahrradmarken`
--
ALTER TABLE `tbl_fahrradmarken`
  ADD PRIMARY KEY (`IDFahrradmarke`),
  ADD UNIQUE KEY `Markenname` (`Markenname`);

--
-- Indizes für die Tabelle `tbl_fahrradtypen`
--
ALTER TABLE `tbl_fahrradtypen`
  ADD PRIMARY KEY (`IDFahrradtyp`),
  ADD UNIQUE KEY `Bezeichnung` (`Typ`);

--
-- Indizes für die Tabelle `tbl_fahrraeder`
--
ALTER TABLE `tbl_fahrraeder`
  ADD PRIMARY KEY (`IDFahrrad`),
  ADD KEY `FIDMarke` (`FIDMarke`),
  ADD KEY `FIDFahrradtyp` (`FIDFahrradtyp`),
  ADD KEY `FIDMitglied` (`FIDMitglied`);

--
-- Indizes für die Tabelle `tbl_gruppen`
--
ALTER TABLE `tbl_gruppen`
  ADD PRIMARY KEY (`IDGruppe`),
  ADD UNIQUE KEY `Gruppenname` (`Gruppenname`);

--
-- Indizes für die Tabelle `tbl_mitglieder`
--
ALTER TABLE `tbl_mitglieder`
  ADD PRIMARY KEY (`IDMitglied`);

--
-- Indizes für die Tabelle `tbl_mitglieder_ausfluege`
--
ALTER TABLE `tbl_mitglieder_ausfluege`
  ADD PRIMARY KEY (`IDMitgliedAusflug`),
  ADD UNIQUE KEY `FIDMitglied` (`FIDMitglied`,`FIDAusflug`),
  ADD KEY `tbl_mitglieder_ausfluege_ibfk_1` (`FIDAusflug`);

--
-- Indizes für die Tabelle `tbl_mitglieder_gruppen`
--
ALTER TABLE `tbl_mitglieder_gruppen`
  ADD PRIMARY KEY (`IDMitgliedGruppe`),
  ADD UNIQUE KEY `FIDMitglied` (`FIDMitglied`,`FIDGruppe`),
  ADD KEY `tbl_mitglieder_gruppen_ibfk_1` (`FIDGruppe`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_ausfluege`
--
ALTER TABLE `tbl_ausfluege`
  MODIFY `IDAusflug` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_fahrradmarken`
--
ALTER TABLE `tbl_fahrradmarken`
  MODIFY `IDFahrradmarke` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `tbl_fahrradtypen`
--
ALTER TABLE `tbl_fahrradtypen`
  MODIFY `IDFahrradtyp` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `tbl_fahrraeder`
--
ALTER TABLE `tbl_fahrraeder`
  MODIFY `IDFahrrad` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_gruppen`
--
ALTER TABLE `tbl_gruppen`
  MODIFY `IDGruppe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_mitglieder`
--
ALTER TABLE `tbl_mitglieder`
  MODIFY `IDMitglied` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_mitglieder_ausfluege`
--
ALTER TABLE `tbl_mitglieder_ausfluege`
  MODIFY `IDMitgliedAusflug` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tbl_mitglieder_gruppen`
--
ALTER TABLE `tbl_mitglieder_gruppen`
  MODIFY `IDMitgliedGruppe` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_fahrraeder`
--
ALTER TABLE `tbl_fahrraeder`
  ADD CONSTRAINT `tbl_fahrraeder_ibfk_1` FOREIGN KEY (`FIDFahrradtyp`) REFERENCES `tbl_fahrradtypen` (`IDFahrradtyp`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_fahrraeder_ibfk_2` FOREIGN KEY (`FIDMarke`) REFERENCES `tbl_fahrradmarken` (`IDFahrradmarke`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_fahrraeder_ibfk_3` FOREIGN KEY (`FIDMitglied`) REFERENCES `tbl_mitglieder` (`IDMitglied`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_mitglieder_ausfluege`
--
ALTER TABLE `tbl_mitglieder_ausfluege`
  ADD CONSTRAINT `tbl_mitglieder_ausfluege_ibfk_1` FOREIGN KEY (`FIDAusflug`) REFERENCES `tbl_ausfluege` (`IDAusflug`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_mitglieder_ausfluege_ibfk_2` FOREIGN KEY (`FIDMitglied`) REFERENCES `tbl_mitglieder` (`IDMitglied`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_mitglieder_gruppen`
--
ALTER TABLE `tbl_mitglieder_gruppen`
  ADD CONSTRAINT `tbl_mitglieder_gruppen_ibfk_1` FOREIGN KEY (`FIDGruppe`) REFERENCES `tbl_gruppen` (`IDGruppe`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_mitglieder_gruppen_ibfk_2` FOREIGN KEY (`FIDMitglied`) REFERENCES `tbl_mitglieder` (`IDMitglied`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
