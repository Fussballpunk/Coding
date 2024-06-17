-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 03. Apr 2024 um 10:40
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `db_3443`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_geschlechter`
--

CREATE TABLE `tbl_geschlechter` (
  `IDGeschlecht` int(10) UNSIGNED NOT NULL,
  `Geschlecht` varchar(16) NOT NULL,
  `Kurzzeichen` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_geschlechter`
--

INSERT INTO `tbl_geschlechter` (`IDGeschlecht`, `Geschlecht`, `Kurzzeichen`) VALUES
(1, 'weiblich', 'w'),
(3, 'divers', 'd'),
(7, 'männlich', 'm');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_staaten`
--

CREATE TABLE `tbl_staaten` (
  `IDStaat` int(10) UNSIGNED NOT NULL,
  `Staat` varchar(64) NOT NULL,
  `Kurzzeichen` varchar(2) NOT NULL,
  `Vorwahl` smallint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_staaten`
--

INSERT INTO `tbl_staaten` (`IDStaat`, `Staat`, `Kurzzeichen`, `Vorwahl`) VALUES
(1, 'Österreich', 'AT', 43),
(2, 'Deutschland', 'DE', 49),
(3, 'Zypern', 'CY', 357),
(4, 'Iran', 'IR', 98),
(5, 'Vereinigte Staaten von Amerika', 'US', 1),
(6, 'Kanada', 'CA', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_telnos`
--

CREATE TABLE `tbl_telnos` (
  `IDTelno` int(10) UNSIGNED NOT NULL,
  `Telno` varchar(32) NOT NULL,
  `FIDUser` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_telnos`
--

INSERT INTO `tbl_telnos` (`IDTelno`, `Telno`, `FIDUser`) VALUES
(1, '0676 1234567', 5),
(2, '05 7000-6564', 9),
(3, '0124 983943', 6),
(4, '+43 549 3982343', 9),
(5, '0039 98473 9436945', 9),
(6, '+43 (0)664 9863493', 5),
(7, '01 49753497-4', 5),
(8, '0073 38764 3964', 14),
(17, '0843 9494735', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tbl_user`
--

CREATE TABLE `tbl_user` (
  `IDUser` int(10) UNSIGNED NOT NULL,
  `Emailadresse` varchar(64) NOT NULL,
  `Passwort` varchar(256) NOT NULL,
  `Vorname` varchar(32) DEFAULT NULL,
  `Nachname` varchar(32) DEFAULT NULL,
  `FIDGeschlecht` int(10) UNSIGNED DEFAULT NULL,
  `GebDatum` date DEFAULT NULL,
  `FIDGebLand` int(10) UNSIGNED DEFAULT NULL,
  `RegZeitpunkt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_user`
--

INSERT INTO `tbl_user` (`IDUser`, `Emailadresse`, `Passwort`, `Vorname`, `Nachname`, `FIDGeschlecht`, `GebDatum`, `FIDGebLand`, `RegZeitpunkt`) VALUES
(4, 'tes3t@test.at', 'test123', NULL, 'Müller', NULL, '1999-02-03', NULL, '2024-03-05 08:29:11'),
(5, 'test4@test.at', 'test9435', 'Sabine', 'Maier', 1, NULL, 2, '2024-03-05 08:29:11'),
(6, 'test5@test.at', '34957jdasf', 'Sandra', 'Maierhofer', 1, '2000-01-01', 1, '2024-03-05 08:33:40'),
(7, 'test6@test.at', 'lskdhflsdaf', 'Sandra', 'Obermaier', 1, NULL, 1, '2024-03-05 08:33:40'),
(8, 'test7@test.at', 'asdf03998', 'Johannes', 'Obermaier', 7, NULL, NULL, '2024-03-05 08:33:40'),
(9, 'test8@test.at', '238sdafdsklh4AA', 'Tobias', NULL, NULL, '1998-03-18', 4, '2024-03-05 08:33:40'),
(10, 'test9@test.at', 'j43SAD333', 'Thomas', 'Maierhofer', 7, '1999-08-15', 4, '2024-03-05 08:33:40'),
(14, 'test23@test.at', 'asdfasdf', 'Sandra', 'Maierhofermüller', 1, NULL, 3, '2024-03-20 09:54:12');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_geschlechter`
--
ALTER TABLE `tbl_geschlechter`
  ADD PRIMARY KEY (`IDGeschlecht`),
  ADD UNIQUE KEY `Geschlecht` (`Geschlecht`),
  ADD UNIQUE KEY `Kurzzeichen` (`Kurzzeichen`);

--
-- Indizes für die Tabelle `tbl_staaten`
--
ALTER TABLE `tbl_staaten`
  ADD PRIMARY KEY (`IDStaat`),
  ADD UNIQUE KEY `Staat` (`Staat`),
  ADD UNIQUE KEY `Kurzzeichen` (`Kurzzeichen`);

--
-- Indizes für die Tabelle `tbl_telnos`
--
ALTER TABLE `tbl_telnos`
  ADD PRIMARY KEY (`IDTelno`),
  ADD KEY `FIDUser` (`FIDUser`);

--
-- Indizes für die Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`IDUser`),
  ADD UNIQUE KEY `Emailadresse` (`Emailadresse`),
  ADD KEY `FIDGeschlecht` (`FIDGeschlecht`),
  ADD KEY `FIDGebLand` (`FIDGebLand`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_geschlechter`
--
ALTER TABLE `tbl_geschlechter`
  MODIFY `IDGeschlecht` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `tbl_staaten`
--
ALTER TABLE `tbl_staaten`
  MODIFY `IDStaat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `tbl_telnos`
--
ALTER TABLE `tbl_telnos`
  MODIFY `IDTelno` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `IDUser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `tbl_telnos`
--
ALTER TABLE `tbl_telnos`
  ADD CONSTRAINT `tbl_telnos_ibfk_1` FOREIGN KEY (`FIDUser`) REFERENCES `tbl_user` (`IDUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `tbl_user_ibfk_1` FOREIGN KEY (`FIDGeschlecht`) REFERENCES `tbl_geschlechter` (`IDGeschlecht`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_user_ibfk_2` FOREIGN KEY (`FIDGebLand`) REFERENCES `tbl_staaten` (`IDStaat`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
