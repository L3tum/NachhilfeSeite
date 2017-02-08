-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Feb 2017 um 10:47
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
CREATE DATABASE IF NOT EXISTS `nachhilfe` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `nachhilfe`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `anfrage`
--

CREATE TABLE `anfrage` (
  `idSender` int(11) NOT NULL,
  `idEmpfänger` int(11) NOT NULL,
  `idFach` int(11) NOT NULL,
  `idAnfrage` int(11) NOT NULL,
  `kostenfrei` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `anfrage`
--

TRUNCATE TABLE `anfrage`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `angebotenesfach`
--

CREATE TABLE `angebotenesfach` (
  `idBenutzer` int(11) NOT NULL,
  `idFach` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `angebotenesfach`
--

TRUNCATE TABLE `angebotenesfach`;
--
-- Daten für Tabelle `angebotenesfach`
--

INSERT INTO `angebotenesfach` (`idBenutzer`, `idFach`) VALUES
(4, 4),
(4, 2),
(4, 3),
(4, 5),
(2, 4),
(2, 2),
(2, 3),
(2, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `angebotenestufe`
--

CREATE TABLE `angebotenestufe` (
  `idBenutzer` int(11) NOT NULL,
  `idStufe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `angebotenestufe`
--

TRUNCATE TABLE `angebotenestufe`;
--
-- Daten für Tabelle `angebotenestufe`
--

INSERT INTO `angebotenestufe` (`idBenutzer`, `idStufe`) VALUES
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benachrichtigung`
--

CREATE TABLE `benachrichtigung` (
  `idBenutzer` int(11) NOT NULL,
  `titel` varchar(55) COLLATE utf8_bin NOT NULL,
  `inhalt` varchar(300) COLLATE utf8_bin NOT NULL,
  `idBenachrichtigung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `benachrichtigung`
--

TRUNCATE TABLE `benachrichtigung`;
--
-- Daten für Tabelle `benachrichtigung`
--

INSERT INTO `benachrichtigung` (`idBenutzer`, `titel`, `inhalt`, `idBenachrichtigung`) VALUES
(2, 'Eine Stunde wurde gelöscht!', 'Die Stunde am 05.02.2017 12:19:00 mit Megakanzler Plötzwurde gelöscht, da sie nicht akzeptiert oder abgesagt wurde!', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `idBenutzer` int(11) NOT NULL,
  `vorname` varchar(20) COLLATE utf8_bin NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(45) COLLATE utf8_bin NOT NULL,
  `passwort` varchar(200) COLLATE utf8_bin NOT NULL,
  `telefonnummer` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `gesperrt` tinyint(1) DEFAULT NULL,
  `idRolle` int(11) NOT NULL,
  `sessionID` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `emailActivated` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `benutzer`
--

TRUNCATE TABLE `benutzer`;
--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`idBenutzer`, `vorname`, `name`, `email`, `passwort`, `telefonnummer`, `gesperrt`, `idRolle`, `sessionID`, `emailActivated`) VALUES
(2, 'Tom', 'Pauly', 'tomn.pauly@googlemail.com', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '346436436', NULL, 6, '2nhoe2jeop6s5cgge59plf7oo3', 1),
(4, 'Megakanzler', 'Plötz', 'ploetz@hurrdurr.com', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '6666666666', 0, 3, '0', 1),
(5, 'Marten', 'Murten', 'marten@murr.com', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '911', NULL, 5, NULL, 1),
(6, 'Tim', 'Göller', 'holakbar@airlines.net', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '110111112113', 0, 5, '0', 1),
(7, 'The Walking', 'Dad', 'walking@daddy.net', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '66666666', NULL, 5, NULL, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `berechtigung`
--

CREATE TABLE `berechtigung` (
  `idBerechtigung` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `beschreibung` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `berechtigung`
--

TRUNCATE TABLE `berechtigung`;
--
-- Daten für Tabelle `berechtigung`
--

INSERT INTO `berechtigung` (`idBerechtigung`, `name`, `beschreibung`) VALUES
(1, 'administration', 'Administrations Menüpunkt'),
(3, 'termine', 'Termine Menüpunkt'),
(4, 'editEveryUser', NULL),
(5, 'giveClasses', NULL),
(6, 'showCredentials', NULL),
(7, 'takeClasses', NULL),
(8, 'showProfileExtended', NULL),
(9, 'showAllUsers', NULL),
(10, 'showAllRoles', NULL),
(11, 'showUnpaidHours', NULL),
(12, 'showAllConnections', NULL),
(13, 'showAllComplaints', NULL),
(14, 'showPendingHours', NULL),
(15, 'showAllFreeRooms', NULL),
(16, 'showAllTakenRooms', NULL),
(17, 'registerNewUser', NULL),
(18, 'blockUser', NULL),
(20, 'deleteComplaints', NULL),
(21, 'editRole', NULL),
(22, 'viewRole', NULL),
(23, 'deleteRole', NULL),
(24, 'addRole', NULL),
(25, 'unblockUser', NULL),
(26, 'addNewSubject', NULL),
(28, 'editSelfSubjects', NULL),
(29, 'editSelfRole', NULL),
(30, 'editSelfYears', NULL),
(31, 'editSelfQuals', NULL),
(33, 'canReport', NULL),
(34, 'editOtherPasswords', NULL),
(35, 'editOtherEmails', NULL),
(36, 'editOtherTel', NULL),
(37, 'editOtherRole', NULL),
(38, 'editOtherSubjects', NULL),
(39, 'editOtherYears', NULL),
(40, 'editOtherQuals', NULL),
(41, 'canEditName', NULL),
(42, 'deleteSubject', NULL),
(43, 'addNewYear', NULL),
(44, 'deleteYear', NULL),
(45, 'deleteConnection', 'Kann Verbindungen von anderen im Administratoren Bereich löschen'),
(46, 'showAllHours', 'Zeige alle Stunden in Administrator'),
(47, 'getUserPDFReports', 'Get PDF Reports on User''s appointments'),
(48, 'getSelfPDFReports', 'Die PDFs von sich selber generieren'),
(49, 'getOtherPDFReports', 'Die PDFs von anderen generieren'),
(50, 'add_right', 'Eine Berechtigung hinzufügen. NUR FÜR SUPER_ADMINS'),
(51, 'elevated_administrator', 'Dieser Administrator ist ''immun'' gegenüber allen anderen'),
(52, 'execute_sql', 'Kann SQL Befehle in der Datenbank über die Seite ausführen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beschwerde`
--

CREATE TABLE `beschwerde` (
  `idSender` int(11) NOT NULL,
  `idNutzer` int(11) NOT NULL,
  `grund` varchar(500) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `beschwerde`
--

TRUNCATE TABLE `beschwerde`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chatnachricht`
--

CREATE TABLE `chatnachricht` (
  `idSender` int(11) NOT NULL,
  `idEmpfänger` int(11) NOT NULL,
  `inhalt` varchar(500) COLLATE utf8_bin NOT NULL,
  `gelesen` tinyint(1) NOT NULL DEFAULT '0',
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idChatnachricht` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `chatnachricht`
--

TRUNCATE TABLE `chatnachricht`;
-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fach`
--

CREATE TABLE `fach` (
  `idFach` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `fach`
--

TRUNCATE TABLE `fach`;
--
-- Daten für Tabelle `fach`
--

INSERT INTO `fach` (`idFach`, `name`) VALUES
(4, 'Informatik'),
(2, 'Mathe'),
(3, 'Physik'),
(5, 'Politik');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `qualifikation`
--

CREATE TABLE `qualifikation` (
  `idQualifikation` int(11) NOT NULL,
  `idBenutzer` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `beschreibung` varchar(250) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `qualifikation`
--

TRUNCATE TABLE `qualifikation`;
--
-- Daten für Tabelle `qualifikation`
--

INSERT INTO `qualifikation` (`idQualifikation`, `idBenutzer`, `name`, `beschreibung`) VALUES
(1, 2, 'Hallo', 'Hallo');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raum`
--

CREATE TABLE `raum` (
  `raumNummer` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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

CREATE TABLE `rolle` (
  `idRolle` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_bin NOT NULL,
  `beschreibung` varchar(500) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
(5, 'Nachhilfenehmer', 'Nimmt Nachhilfe'),
(6, 'SuperAdministrator', 'Administriert die Administratoren');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rollenberechtigung`
--

CREATE TABLE `rollenberechtigung` (
  `idBerechtigung` int(11) NOT NULL,
  `idRolle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `rollenberechtigung`
--

TRUNCATE TABLE `rollenberechtigung`;
--
-- Daten für Tabelle `rollenberechtigung`
--

INSERT INTO `rollenberechtigung` (`idBerechtigung`, `idRolle`) VALUES
(3, 3),
(5, 3),
(15, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(33, 3),
(3, 5),
(7, 5),
(15, 5),
(33, 5),
(1, 2),
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
(20, 2),
(22, 2),
(25, 2),
(26, 2),
(28, 2),
(30, 2),
(31, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(1, 6),
(3, 6),
(4, 6),
(5, 6),
(6, 6),
(7, 6),
(8, 6),
(9, 6),
(10, 6),
(11, 6),
(12, 6),
(13, 6),
(14, 6),
(15, 6),
(16, 6),
(17, 6),
(18, 6),
(20, 6),
(21, 6),
(22, 6),
(23, 6),
(24, 6),
(25, 6),
(26, 6),
(28, 6),
(29, 6),
(30, 6),
(31, 6),
(33, 6),
(34, 6),
(35, 6),
(36, 6),
(37, 6),
(38, 6),
(39, 6),
(40, 6),
(41, 6),
(42, 6),
(43, 6),
(44, 6),
(45, 6),
(46, 6),
(47, 6),
(48, 6),
(49, 6),
(50, 6),
(51, 6),
(52, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stufe`
--

CREATE TABLE `stufe` (
  `idStufe` int(11) NOT NULL,
  `name` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `stufe`
--

TRUNCATE TABLE `stufe`;
--
-- Daten für Tabelle `stufe`
--

INSERT INTO `stufe` (`idStufe`, `name`) VALUES
(4, '5'),
(5, '6'),
(6, '7'),
(7, '8'),
(8, '9'),
(9, '10');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stunde`
--

CREATE TABLE `stunde` (
  `idStunde` int(11) NOT NULL,
  `raumNummer` varchar(10) COLLATE utf8_bin NOT NULL,
  `idVerbindung` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `kommentar` varchar(500) COLLATE utf8_bin NOT NULL,
  `bestaetigtSchueler` tinyint(1) DEFAULT '0' COMMENT 'bestätigt dass stattgefunden',
  `bestaetigtLehrer` tinyint(1) DEFAULT '0',
  `akzeptiert` tinyint(1) DEFAULT '0',
  `lehrerVorgeschlagen` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `stunde`
--

TRUNCATE TABLE `stunde`;
--
-- Daten für Tabelle `stunde`
--

INSERT INTO `stunde` (`idStunde`, `raumNummer`, `idVerbindung`, `datum`, `kommentar`, `bestaetigtSchueler`, `bestaetigtLehrer`, `akzeptiert`, `lehrerVorgeschlagen`) VALUES
(2, '114', 2, '2017-02-06 14:38:00', '', 0, 0, 0, 1),
(3, '113', 1, '2017-02-02 06:00:00', '', 1, 0, 1, 0),
(4, '114', 1, '2017-02-03 16:00:00', '', 0, 1, 1, 1),
(5, '113', 1, '2017-02-03 10:24:00', '', 1, 1, 1, 1),
(6, '113', 1, '2017-02-16 16:00:00', '', 0, 0, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verbindung`
--

CREATE TABLE `verbindung` (
  `idVerbindung` int(11) NOT NULL,
  `idNachhilfenehmer` int(11) NOT NULL,
  `idNachhilfelehrer` int(11) NOT NULL,
  `idFach` int(11) NOT NULL,
  `kostenfrei` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `verbindung`
--

TRUNCATE TABLE `verbindung`;
--
-- Daten für Tabelle `verbindung`
--

INSERT INTO `verbindung` (`idVerbindung`, `idNachhilfenehmer`, `idNachhilfelehrer`, `idFach`, `kostenfrei`) VALUES
(1, 2, 4, 2, 1),
(2, 2, 4, 3, 0),
(3, 5, 4, 2, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `anfrage`
--
ALTER TABLE `anfrage`
  ADD PRIMARY KEY (`idAnfrage`),
  ADD UNIQUE KEY `idAnfrage_UNIQUE` (`idAnfrage`),
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
  ADD PRIMARY KEY (`idBenachrichtigung`),
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
  ADD PRIMARY KEY (`idChatnachricht`),
  ADD UNIQUE KEY `idChatnachricht_UNIQUE` (`idChatnachricht`),
  ADD KEY `idBenutzer1FK_idx` (`idSender`),
  ADD KEY `idBenutzer2FK_idx` (`idEmpfänger`);

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
-- AUTO_INCREMENT für Tabelle `anfrage`
--
ALTER TABLE `anfrage`
  MODIFY `idAnfrage` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `benachrichtigung`
--
ALTER TABLE `benachrichtigung`
  MODIFY `idBenachrichtigung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `idBenutzer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT für Tabelle `berechtigung`
--
ALTER TABLE `berechtigung`
  MODIFY `idBerechtigung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT für Tabelle `chatnachricht`
--
ALTER TABLE `chatnachricht`
  MODIFY `idChatnachricht` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `fach`
--
ALTER TABLE `fach`
  MODIFY `idFach` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `qualifikation`
--
ALTER TABLE `qualifikation`
  MODIFY `idQualifikation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `rolle`
--
ALTER TABLE `rolle`
  MODIFY `idRolle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `stufe`
--
ALTER TABLE `stufe`
  MODIFY `idStufe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `stunde`
--
ALTER TABLE `stunde`
  MODIFY `idStunde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
  ADD CONSTRAINT `idBenutzer1FKCh` FOREIGN KEY (`idSender`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idBenutzer2FKCh` FOREIGN KEY (`idEmpfänger`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
