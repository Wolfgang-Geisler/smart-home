-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Sep 2019 um 17:23
-- Server-Version: 10.1.38-MariaDB
-- PHP-Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `project`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fi`
--

CREATE TABLE `fi` (
  `fiId` int(12) NOT NULL,
  `hersteller` varchar(255) NOT NULL,
  `spannung` int(3) NOT NULL COMMENT 'in Volt',
  `schaltschrankId` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `fi`
--

INSERT INTO `fi` (`fiId`, `hersteller`, `spannung`, `schaltschrankId`) VALUES
(1, 'Fi 1-1', 60, 1),
(2, 'Fi 1-2', 30, 1),
(3, 'Fi 2-1', 20, 2),
(4, 'Fi 2-2', 30, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `gebaeude`
--

CREATE TABLE `gebaeude` (
  `gebaeudeId` int(12) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `projektId` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `gebaeude`
--

INSERT INTO `gebaeude` (`gebaeudeId`, `adresse`, `bezeichnung`, `projektId`) VALUES
(1, 'Adresse 1', 'Gebaeude 1-1', 1),
(2, 'Adresse 2', 'Gebaeude 1-2', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `installation`
--

CREATE TABLE `installation` (
  `installationId` int(12) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `raumId` int(12) NOT NULL,
  `relaisId` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `installation`
--

INSERT INTO `installation` (`installationId`, `bezeichnung`, `raumId`, `relaisId`) VALUES
(1, 'Fernseher', 1, 1),
(2, 'Radio', 1, 2),
(3, 'Licht', 2, 3),
(4, 'DVD Player', 2, 4),
(9, 'test', 1, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projekt`
--

CREATE TABLE `projekt` (
  `projektId` int(12) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `vorname` varchar(255) NOT NULL,
  `nachname` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `notizen` varchar(255) NOT NULL,
  `installation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `projekt`
--

INSERT INTO `projekt` (`projektId`, `bezeichnung`, `vorname`, `nachname`, `adresse`, `notizen`, `installation`) VALUES
(1, 'Projekt 1', 'Max', 'Mustermann', 'Adresse 1', 'Notiz 1', 'Installation 1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raum`
--

CREATE TABLE `raum` (
  `raumId` int(12) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `stockwerkId` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `raum`
--

INSERT INTO `raum` (`raumId`, `bezeichnung`, `stockwerkId`) VALUES
(1, 'Raum 1-1', 1),
(2, 'Raum 1-2', 1),
(3, 'Raum 2-1', 2),
(4, 'Raum 2-2', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `relais`
--

CREATE TABLE `relais` (
  `relaisId` int(12) NOT NULL,
  `sicherungId` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `relais`
--

INSERT INTO `relais` (`relaisId`, `sicherungId`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3),
(5, 4),
(6, 5),
(7, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `schaltschrank`
--

CREATE TABLE `schaltschrank` (
  `schaltschrankId` int(12) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `gebaeudeId` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `schaltschrank`
--

INSERT INTO `schaltschrank` (`schaltschrankId`, `bezeichnung`, `position`, `gebaeudeId`) VALUES
(1, 'Schaltschrank 1', 'Gebaeude 1', 1),
(2, 'Schaltschrank 1', 'Gebaeude 2', 2),
(3, 'Schaltschrank 2', 'Gebaeude 1', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sicherung`
--

CREATE TABLE `sicherung` (
  `sicherungId` int(12) NOT NULL,
  `hersteller` varchar(255) NOT NULL,
  `ausloesestrom` int(2) NOT NULL,
  `spannung` int(3) NOT NULL COMMENT 'in Volt',
  `pole` int(1) NOT NULL,
  `fiId` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `sicherung`
--

INSERT INTO `sicherung` (`sicherungId`, `hersteller`, `ausloesestrom`, `spannung`, `pole`, `fiId`) VALUES
(1, 'Sicherung 1-1', 6, 230, 3, 1),
(2, 'Sicherung 1-2', 13, 400, 2, 1),
(3, 'Sicherung 2-1', 20, 400, 1, 2),
(4, 'Sicherung 2-2', 10, 230, 4, 2),
(5, 'Sicherung 3-1', 13, 230, 2, 3),
(6, 'Sicherung 4-1', 10, 400, 4, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stockwerk`
--

CREATE TABLE `stockwerk` (
  `stockwerkId` int(12) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `gebaeudeId` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `stockwerk`
--

INSERT INTO `stockwerk` (`stockwerkId`, `bezeichnung`, `gebaeudeId`) VALUES
(1, 'Stockwerk 1-1', 1),
(2, 'Stockwerk 1-2', 1),
(4, 'Stockwerk 2-1', 2),
(5, 'Stockwerk 2-2', 2),
(7, 'aaa', 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `fi`
--
ALTER TABLE `fi`
  ADD PRIMARY KEY (`fiId`),
  ADD KEY `schaltschrankId` (`schaltschrankId`);

--
-- Indizes für die Tabelle `gebaeude`
--
ALTER TABLE `gebaeude`
  ADD PRIMARY KEY (`gebaeudeId`),
  ADD KEY `stockwerkId` (`projektId`);

--
-- Indizes für die Tabelle `installation`
--
ALTER TABLE `installation`
  ADD PRIMARY KEY (`installationId`),
  ADD KEY `raumId` (`raumId`);

--
-- Indizes für die Tabelle `projekt`
--
ALTER TABLE `projekt`
  ADD PRIMARY KEY (`projektId`);

--
-- Indizes für die Tabelle `raum`
--
ALTER TABLE `raum`
  ADD PRIMARY KEY (`raumId`),
  ADD KEY `stockwerkId` (`stockwerkId`);

--
-- Indizes für die Tabelle `relais`
--
ALTER TABLE `relais`
  ADD PRIMARY KEY (`relaisId`),
  ADD KEY `sicherungId` (`sicherungId`);

--
-- Indizes für die Tabelle `schaltschrank`
--
ALTER TABLE `schaltschrank`
  ADD PRIMARY KEY (`schaltschrankId`),
  ADD KEY `gebaeudeId` (`gebaeudeId`);

--
-- Indizes für die Tabelle `sicherung`
--
ALTER TABLE `sicherung`
  ADD PRIMARY KEY (`sicherungId`),
  ADD KEY `fiId` (`fiId`);

--
-- Indizes für die Tabelle `stockwerk`
--
ALTER TABLE `stockwerk`
  ADD PRIMARY KEY (`stockwerkId`),
  ADD KEY `gebaeudeId` (`gebaeudeId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `fi`
--
ALTER TABLE `fi`
  MODIFY `fiId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `installation`
--
ALTER TABLE `installation`
  MODIFY `installationId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT für Tabelle `raum`
--
ALTER TABLE `raum`
  MODIFY `raumId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `relais`
--
ALTER TABLE `relais`
  MODIFY `relaisId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `schaltschrank`
--
ALTER TABLE `schaltschrank`
  MODIFY `schaltschrankId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `sicherung`
--
ALTER TABLE `sicherung`
  MODIFY `sicherungId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `stockwerk`
--
ALTER TABLE `stockwerk`
  MODIFY `stockwerkId` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `fi`
--
ALTER TABLE `fi`
  ADD CONSTRAINT `fi_ibfk_1` FOREIGN KEY (`schaltschrankId`) REFERENCES `schaltschrank` (`schaltschrankId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `gebaeude`
--
ALTER TABLE `gebaeude`
  ADD CONSTRAINT `gebaeude_ibfk_1` FOREIGN KEY (`projektId`) REFERENCES `projekt` (`projektId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `installation`
--
ALTER TABLE `installation`
  ADD CONSTRAINT `installation_ibfk_1` FOREIGN KEY (`raumId`) REFERENCES `raum` (`raumId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `raum`
--
ALTER TABLE `raum`
  ADD CONSTRAINT `raum_ibfk_1` FOREIGN KEY (`stockwerkId`) REFERENCES `stockwerk` (`stockwerkId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `relais`
--
ALTER TABLE `relais`
  ADD CONSTRAINT `relais_ibfk_1` FOREIGN KEY (`sicherungId`) REFERENCES `sicherung` (`sicherungId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `schaltschrank`
--
ALTER TABLE `schaltschrank`
  ADD CONSTRAINT `schaltschrank_ibfk_1` FOREIGN KEY (`gebaeudeId`) REFERENCES `gebaeude` (`gebaeudeId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `sicherung`
--
ALTER TABLE `sicherung`
  ADD CONSTRAINT `sicherung_ibfk_1` FOREIGN KEY (`fiId`) REFERENCES `fi` (`fiId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `stockwerk`
--
ALTER TABLE `stockwerk`
  ADD CONSTRAINT `stockwerk_ibfk_1` FOREIGN KEY (`gebaeudeId`) REFERENCES `gebaeude` (`gebaeudeId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
