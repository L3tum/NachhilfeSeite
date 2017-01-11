-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 11. Jan 2017 um 00:46
-- Server-Version: 10.1.19-MariaDB
-- PHP-Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `nachhilfe`
--
CREATE DATABASE IF NOT EXISTS `nachhilfe` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nachhilfe`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `anfrage`
--

DROP TABLE IF EXISTS `anfrage`;
CREATE TABLE `anfrage` (
  `idSender` int(11) DEFAULT NULL,
  `idEmpfänger` int(11) NOT NULL,
  `idFach` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `anfrage`
--

TRUNCATE TABLE `anfrage`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `angebotenesfach`
--

DROP TABLE IF EXISTS `angebotenesfach`;
CREATE TABLE `angebotenesfach` (
  `idBenutzer` int(11) NOT NULL,
  `idFach` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `angebotenesfach`
--

TRUNCATE TABLE `angebotenesfach`;
--
-- Daten für Tabelle `angebotenesfach`
--

INSERT INTO `angebotenesfach` (`idBenutzer`, `idFach`) VALUES
(2, 1),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `angebotenestufe`
--

DROP TABLE IF EXISTS `angebotenestufe`;
CREATE TABLE `angebotenestufe` (
  `idBenutzer` int(11) NOT NULL,
  `idStufe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `angebotenestufe`
--

TRUNCATE TABLE `angebotenestufe`;
--
-- Daten für Tabelle `angebotenestufe`
--

INSERT INTO `angebotenestufe` (`idBenutzer`, `idStufe`) VALUES
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benachrichtigung`
--

DROP TABLE IF EXISTS `benachrichtigung`;
CREATE TABLE `benachrichtigung` (
  `idBenutzer` int(11) NOT NULL,
  `titel` varchar(55) NOT NULL,
  `inhalt` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `benachrichtigung`
--

TRUNCATE TABLE `benachrichtigung`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

DROP TABLE IF EXISTS `benutzer`;
CREATE TABLE `benutzer` (
  `idBenutzer` int(11) NOT NULL,
  `vorname` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(45) NOT NULL,
  `passwort` varchar(200) NOT NULL,
  `telefonnummer` varchar(45) DEFAULT NULL,
  `gesperrt` tinyint(1) DEFAULT NULL,
  `idRolle` int(11) NOT NULL,
  `sessionID` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `benutzer`
--

TRUNCATE TABLE `benutzer`;
--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`idBenutzer`, `vorname`, `name`, `email`, `passwort`, `telefonnummer`, `gesperrt`, `idRolle`, `sessionID`) VALUES
(2, 'Tom', 'Pauly', 'tomn.pauly@googlemail.com', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '346436436', NULL, 2, 'doolfda0sg4mi7kf2vinnm5h25'),
(4, 'Heiliges Römisches', 'Plötz', 'ploetz@hurrdurr.com', '87c45829ec774b2b4d2fc3d59c0d1ebd6a7e40b3372b2e8c86575ec19dbbbd7f', '6666666666', NULL, 3, NULL),
(5, 'Marten', 'Murten', 'marten@murr.com', '4f417650b922599a876fc328698290622a0d6fe0343991204341593f65abad3d', '911', NULL, 5, NULL),
(6, 'Tim', 'Göller', 'holakbar@airlines.net', '5a35da34cf4ec1b8d6318dae75cf56f8a8d6ea1cb3a151e8cb0cc97df9340c69', '110111112113', NULL, 5, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `berechtigung`
--

DROP TABLE IF EXISTS `berechtigung`;
CREATE TABLE `berechtigung` (
  `idBerechtigung` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `berechtigung`
--

TRUNCATE TABLE `berechtigung`;
--
-- Daten für Tabelle `berechtigung`
--

INSERT INTO `berechtigung` (`idBerechtigung`, `name`) VALUES
(1, 'administration'),
(2, 'nachhilfe'),
(3, 'termine'),
(4, 'editEveryUser'),
(5, 'give_classes'),
(6, 'show_credentials'),
(7, 'take_classes'),
(8, 'show_profile_extended'),
(9, 'showAllUsers'),
(10, 'showAllRoles'),
(11, 'showUnpaidHours'),
(12, 'showAllConnections'),
(13, 'showAllComplaints'),
(14, 'showPendingHours'),
(15, 'showAllFreeRooms'),
(16, 'showAllTakenRooms'),
(17, 'registerNewUser'),
(18, 'blockUser'),
(19, 'confirmPaymentAdmin'),
(20, 'deleteComplaints'),
(21, 'editRole'),
(22, 'viewRole'),
(23, 'deleteRole'),
(24, 'addRole'),
(25, 'unblockUser'),
(26, 'addNewSubject'),
(28, 'editSubjects'),
(29, 'editUserRole'),
(30, 'editYears'),
(31, 'editQuals'),
(33, 'canReport');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beschwerde`
--

DROP TABLE IF EXISTS `beschwerde`;
CREATE TABLE `beschwerde` (
  `idSender` int(11) NOT NULL,
  `idNutzer` int(11) NOT NULL,
  `grund` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `beschwerde`
--

TRUNCATE TABLE `beschwerde`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chatnachricht`
--

DROP TABLE IF EXISTS `chatnachricht`;
CREATE TABLE `chatnachricht` (
  `idBenutzer1` int(11) NOT NULL,
  `idBenutzer2` int(11) NOT NULL,
  `titel` varchar(50) NOT NULL,
  `inhalt` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `chatnachricht`
--

TRUNCATE TABLE `chatnachricht`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fach`
--

DROP TABLE IF EXISTS `fach`;
CREATE TABLE `fach` (
  `idFach` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `fach`
--

TRUNCATE TABLE `fach`;
--
-- Daten für Tabelle `fach`
--

INSERT INTO `fach` (`idFach`, `name`) VALUES
(1, 'Deutsch'),
(2, 'Mathe'),
(3, 'Physik');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `qualifikation`
--

DROP TABLE IF EXISTS `qualifikation`;
CREATE TABLE `qualifikation` (
  `idQualifikation` int(11) NOT NULL,
  `idBenutzer` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `beschreibung` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `qualifikation`
--

TRUNCATE TABLE `qualifikation`;
--
-- Daten für Tabelle `qualifikation`
--

INSERT INTO `qualifikation` (`idQualifikation`, `idBenutzer`, `name`, `beschreibung`) VALUES
(1, 2, 'Akustischer Guitarist', 'Ich kann Gitarre spielen :)'),
(2, 2, 'Zertifizierter Zertifizierer', 'Zertifiziert'),
(3, 2, 'Bieber 2.Platz', '2. Platz im Informatik-Bieber Wettbewerb'),
(4, 2, 'Bieber 1. Platz', '1. Platz im Mathe-Bieber Wettbewerb');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raum`
--

DROP TABLE IF EXISTS `raum`;
CREATE TABLE `raum` (
  `raumNummer` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `raum`
--

TRUNCATE TABLE `raum`;
--
-- Daten für Tabelle `raum`
--

INSERT INTO `raum` (`raumNummer`) VALUES
('113'),
('114');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rolle`
--

DROP TABLE IF EXISTS `rolle`;
CREATE TABLE `rolle` (
  `idRolle` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `beschreibung` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `rolle`
--

TRUNCATE TABLE `rolle`;
--
-- Daten für Tabelle `rolle`
--

INSERT INTO `rolle` (`idRolle`, `name`, `beschreibung`) VALUES
(2, 'Administrator', 'Administriert diese Seite, die so unglaublich geil ist'),
(3, 'Nachhilfelehrer', 'Gibt Nachhilfe'),
(5, 'Nachhilfenehmer', 'Nimmt Nachhilfe');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rollenberechtigung`
--

DROP TABLE IF EXISTS `rollenberechtigung`;
CREATE TABLE `rollenberechtigung` (
  `idBerechtigung` int(11) NOT NULL,
  `idRolle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `rollenberechtigung`
--

TRUNCATE TABLE `rollenberechtigung`;
--
-- Daten für Tabelle `rollenberechtigung`
--

INSERT INTO `rollenberechtigung` (`idBerechtigung`, `idRolle`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(33, 2),
(2, 3),
(3, 3),
(5, 3),
(33, 3),
(2, 5),
(3, 5),
(7, 5),
(33, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stufe`
--

DROP TABLE IF EXISTS `stufe`;
CREATE TABLE `stufe` (
  `idStufe` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `stufe`
--

TRUNCATE TABLE `stufe`;
--
-- Daten für Tabelle `stufe`
--

INSERT INTO `stufe` (`idStufe`, `name`) VALUES
(1, 'Q1'),
(2, 'Q2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stunde`
--

DROP TABLE IF EXISTS `stunde`;
CREATE TABLE `stunde` (
  `idStunde` int(11) NOT NULL,
  `bezahltLehrer` tinyint(1) NOT NULL DEFAULT '0',
  `raumNummer` varchar(10) NOT NULL,
  `idVerbindung` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `kommentar` varchar(500) NOT NULL,
  `findetStatt` tinyint(1) NOT NULL DEFAULT '1',
  `bestaetigtSchueler` tinyint(1) DEFAULT '0',
  `bestaetigtLehrer` tinyint(1) DEFAULT '0',
  `bezahltAdmin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `stunde`
--

TRUNCATE TABLE `stunde`;
--
-- Daten für Tabelle `stunde`
--

INSERT INTO `stunde` (`idStunde`, `bezahltLehrer`, `raumNummer`, `idVerbindung`, `datum`, `kommentar`, `findetStatt`, `bestaetigtSchueler`, `bestaetigtLehrer`, `bezahltAdmin`) VALUES
(2, 0, '113', 2, '2017-01-19 00:00:00', '', 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verbindung`
--

DROP TABLE IF EXISTS `verbindung`;
CREATE TABLE `verbindung` (
  `idVerbindung` int(11) NOT NULL,
  `idNachhilfenehmer` int(11) NOT NULL,
  `idNachhilfelehrer` int(11) NOT NULL,
  `idFach` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- TRUNCATE Tabelle vor dem Einfügen `verbindung`
--

TRUNCATE TABLE `verbindung`;
--
-- Daten für Tabelle `verbindung`
--

INSERT INTO `verbindung` (`idVerbindung`, `idNachhilfenehmer`, `idNachhilfelehrer`, `idFach`) VALUES
(2, 2, 4, 1),
(3, 4, 2, 3);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `anfrage`
--
ALTER TABLE `anfrage`
  ADD KEY `idBenutzer1_idx` (`idSender`),
  ADD KEY `idFach_idx` (`idFach`),
  ADD KEY `idBenutzer2FK_idx` (`idEmpfänger`);

--
-- Indizes für die Tabelle `angebotenesfach`
--
ALTER TABLE `angebotenesfach`
  ADD KEY `idBenutzerFKAF` (`idBenutzer`),
  ADD KEY `idFachFKAF` (`idFach`);

--
-- Indizes für die Tabelle `angebotenestufe`
--
ALTER TABLE `angebotenestufe`
  ADD KEY `idBenutzerFK` (`idBenutzer`),
  ADD KEY `idStufeFK` (`idStufe`);

--
-- Indizes für die Tabelle `benachrichtigung`
--
ALTER TABLE `benachrichtigung`
  ADD KEY `idBenutzerFK_idx` (`idBenutzer`);

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`idBenutzer`),
  ADD UNIQUE KEY `idBenutzer_UNIQUE` (`idBenutzer`),
  ADD KEY `idRolle_idx` (`idRolle`);

--
-- Indizes für die Tabelle `berechtigung`
--
ALTER TABLE `berechtigung`
  ADD PRIMARY KEY (`idBerechtigung`),
  ADD UNIQUE KEY `idPermission_UNIQUE` (`idBerechtigung`);

--
-- Indizes für die Tabelle `beschwerde`
--
ALTER TABLE `beschwerde`
  ADD KEY `idBenutzer1_idx` (`idSender`),
  ADD KEY `idBenutzer2FK_idx` (`idNutzer`);

--
-- Indizes für die Tabelle `chatnachricht`
--
ALTER TABLE `chatnachricht`
  ADD KEY `idBenutzer1FK_idx` (`idBenutzer1`),
  ADD KEY `idBenutzer2FK_idx` (`idBenutzer2`);

--
-- Indizes für die Tabelle `fach`
--
ALTER TABLE `fach`
  ADD PRIMARY KEY (`idFach`),
  ADD UNIQUE KEY `idFach_UNIQUE` (`idFach`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indizes für die Tabelle `qualifikation`
--
ALTER TABLE `qualifikation`
  ADD PRIMARY KEY (`idQualifikation`),
  ADD KEY `idBenutzer_idx` (`idBenutzer`);

--
-- Indizes für die Tabelle `raum`
--
ALTER TABLE `raum`
  ADD PRIMARY KEY (`raumNummer`),
  ADD UNIQUE KEY `raumNummer_UNIQUE` (`raumNummer`);

--
-- Indizes für die Tabelle `rolle`
--
ALTER TABLE `rolle`
  ADD PRIMARY KEY (`idRolle`),
  ADD UNIQUE KEY `idRolle_UNIQUE` (`idRolle`);

--
-- Indizes für die Tabelle `rollenberechtigung`
--
ALTER TABLE `rollenberechtigung`
  ADD KEY `idBerechtigungFK` (`idBerechtigung`),
  ADD KEY `idRollefKRB` (`idRolle`);

--
-- Indizes für die Tabelle `stufe`
--
ALTER TABLE `stufe`
  ADD PRIMARY KEY (`idStufe`),
  ADD UNIQUE KEY `idStufe_UNIQUE` (`idStufe`);

--
-- Indizes für die Tabelle `stunde`
--
ALTER TABLE `stunde`
  ADD PRIMARY KEY (`idStunde`),
  ADD UNIQUE KEY `idStunde_UNIQUE` (`idStunde`),
  ADD KEY `raumNummerFK_idx` (`raumNummer`),
  ADD KEY `idVerbindungFK_idx` (`idVerbindung`);

--
-- Indizes für die Tabelle `verbindung`
--
ALTER TABLE `verbindung`
  ADD PRIMARY KEY (`idVerbindung`),
  ADD KEY `idBenutzer1FK_idx` (`idNachhilfenehmer`),
  ADD KEY `idBenutzer2FK_idx` (`idNachhilfelehrer`),
  ADD KEY `idFachFK_idx` (`idFach`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `idBenutzer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `berechtigung`
--
ALTER TABLE `berechtigung`
  MODIFY `idBerechtigung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT für Tabelle `fach`
--
ALTER TABLE `fach`
  MODIFY `idFach` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `qualifikation`
--
ALTER TABLE `qualifikation`
  MODIFY `idQualifikation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `rolle`
--
ALTER TABLE `rolle`
  MODIFY `idRolle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `stufe`
--
ALTER TABLE `stufe`
  MODIFY `idStufe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `stunde`
--
ALTER TABLE `stunde`
  MODIFY `idStunde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `verbindung`
--
ALTER TABLE `verbindung`
  MODIFY `idVerbindung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `anfrage`
--
ALTER TABLE `anfrage`
  ADD CONSTRAINT `idBenutzer1FKAn` FOREIGN KEY (`idSender`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idBenutzer2FKAn` FOREIGN KEY (`idEmpfänger`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFachFKAn` FOREIGN KEY (`idFach`) REFERENCES `fach` (`idFach`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `angebotenesfach`
--
ALTER TABLE `angebotenesfach`
  ADD CONSTRAINT `idBenutzerFKAF` FOREIGN KEY (`idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFachFKAF` FOREIGN KEY (`idFach`) REFERENCES `fach` (`idFach`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `angebotenestufe`
--
ALTER TABLE `angebotenestufe`
  ADD CONSTRAINT `idBenutzerFK` FOREIGN KEY (`idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idStufeFK` FOREIGN KEY (`idStufe`) REFERENCES `stufe` (`idStufe`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `benachrichtigung`
--
ALTER TABLE `benachrichtigung`
  ADD CONSTRAINT `idBenutzerFKBe` FOREIGN KEY (`idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD CONSTRAINT `idRolleFK` FOREIGN KEY (`idRolle`) REFERENCES `rolle` (`idRolle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `beschwerde`
--
ALTER TABLE `beschwerde`
  ADD CONSTRAINT `idBenutzer1FKBes` FOREIGN KEY (`idSender`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idBenutzer2FKBes` FOREIGN KEY (`idNutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `chatnachricht`
--
ALTER TABLE `chatnachricht`
  ADD CONSTRAINT `idBenutzer1FKCh` FOREIGN KEY (`idBenutzer1`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idBenutzer2FKCh` FOREIGN KEY (`idBenutzer2`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `qualifikation`
--
ALTER TABLE `qualifikation`
  ADD CONSTRAINT `idBenutzerQu` FOREIGN KEY (`idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `rollenberechtigung`
--
ALTER TABLE `rollenberechtigung`
  ADD CONSTRAINT `idBerechtigungFK` FOREIGN KEY (`idBerechtigung`) REFERENCES `berechtigung` (`idBerechtigung`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idRollefKRB` FOREIGN KEY (`idRolle`) REFERENCES `rolle` (`idRolle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `stunde`
--
ALTER TABLE `stunde`
  ADD CONSTRAINT `idVerbindungFK` FOREIGN KEY (`idVerbindung`) REFERENCES `verbindung` (`idVerbindung`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `raumNummerFK` FOREIGN KEY (`raumNummer`) REFERENCES `raum` (`raumNummer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `verbindung`
--
ALTER TABLE `verbindung`
  ADD CONSTRAINT `idBenutzer1FK` FOREIGN KEY (`idNachhilfenehmer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idBenutzer2FK` FOREIGN KEY (`idNachhilfelehrer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFachFK` FOREIGN KEY (`idFach`) REFERENCES `fach` (`idFach`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
