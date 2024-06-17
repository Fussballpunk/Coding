-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Mrz 2024 um 12:12
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
-- Tabellenstruktur für Tabelle `tbl_user`
--

CREATE TABLE `tbl_user` (
  `IDUser` int(10) UNSIGNED NOT NULL,
  `Emailadresse` varchar(64) NOT NULL,
  `Passwort` varchar(256) NOT NULL,
  `Vorname` varchar(32) DEFAULT NULL,
  `Nachname` varchar(32) DEFAULT NULL,
  `GebDatum` date DEFAULT NULL,
  `RegZeitpunkt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `tbl_user`
--

INSERT INTO `tbl_user` (`IDUser`, `Emailadresse`, `Passwort`, `Vorname`, `Nachname`, `GebDatum`, `RegZeitpunkt`) VALUES
(4, 'tes3t@test.at', 'test123', NULL, 'Müller', '1999-02-03', '2024-03-05 08:29:11'),
(5, 'test4@test.at', 'test9435', 'Sabine', 'Maier', NULL, '2024-03-05 08:29:11'),
(6, 'test5@test.at', '34957jdasf', 'Sandra', 'Maierhofer', '2000-01-01', '2024-03-05 08:33:40'),
(7, 'test6@test.at', 'lskdhflsdaf', 'Sandra', 'Obermaier', NULL, '2024-03-05 08:33:40'),
(8, 'test7@test.at', 'asdf03998', 'Johannes', 'Obermaier', NULL, '2024-03-05 08:33:40'),
(9, 'test8@test.at', '238sdafdsklh4AA', 'Tobias', NULL, '1998-03-18', '2024-03-05 08:33:40'),
(10, 'test9@test.at', 'j43SAD333', 'Thomas', 'Maierhofer', '1999-08-15', '2024-03-05 08:33:40'),
(14, 'test23@test.at', 'asdfasdf', 'Sandra', 'Maierhofermüller', NULL, '2024-03-20 09:54:12');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`IDUser`),
  ADD UNIQUE KEY `Emailadresse` (`Emailadresse`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `IDUser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
