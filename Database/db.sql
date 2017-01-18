-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Jan 2017 um 00:56
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
  `idAnfrage` int(11) NOT NULL
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
(2, 1),
(2, 2),
(2, 3),
(4, 1);

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
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benachrichtigung`
--

CREATE TABLE `benachrichtigung` (
  `idBenutzer` int(11) NOT NULL,
  `titel` varchar(55) COLLATE utf8_bin NOT NULL,
  `inhalt` varchar(300) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `benachrichtigung`
--

TRUNCATE TABLE `benachrichtigung`;
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
  `emailActivated` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `benutzer`
--

TRUNCATE TABLE `benutzer`;
--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`idBenutzer`, `vorname`, `name`, `email`, `passwort`, `telefonnummer`, `gesperrt`, `idRolle`, `sessionID`, `emailActivated`) VALUES
(2, 'Tom', 'Pauly', 'tomn.pauly@googlemail.com', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '346436436', NULL, 2, '29ttjpoqko049tkrlbc6e2df03', 1),
(4, 'Heiliges Römisches', 'Plötz', 'ploetz@hurrdurr.com', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '6666666666', NULL, 3, '', 1),
(5, 'Marten', 'Murten', 'marten@murr.com', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '911', NULL, 5, NULL, 1),
(6, 'Tim', 'Göller', 'holakbar@airlines.net', 'c3dab9ba2181e1fe531da303b61c6b32ce71ee9d38632a175af79af2ff450ca6', '110111112113', NULL, 5, NULL, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `berechtigung`
--

CREATE TABLE `berechtigung` (
  `idBerechtigung` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
(5, 'giveClasses'),
(6, 'showCredentials'),
(7, 'takeClasses'),
(8, 'showProfileExtended'),
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
(33, 'canReport'),
(34, 'deleteConnection');

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
--
-- Daten für Tabelle `chatnachricht`
--

INSERT INTO `chatnachricht` (`idSender`, `idEmpfänger`, `inhalt`, `gelesen`, `datum`, `idChatnachricht`) VALUES
(2, 4, 'Hi', 1, '2017-01-11 18:21:25', 1),
(4, 2, 'HI :;)', 0, '2017-01-11 18:27:14', 2),
(4, 2, 'WGH', 0, '2017-01-11 18:28:52', 3);

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
(1, 'Deutsch'),
(2, 'Mathe'),
(3, 'Physik');

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
(1, 2, 'Akustischer Guitarist', 'Ich kann Gitarre spielen :)'),
(2, 2, 'Zertifizierter Zertifizierer', 'Zertifiziert'),
(3, 2, 'Bieber 2.Platz', '2. Platz im Informatik-Bieber Wettbewerb'),
(4, 2, 'Bieber 1. Platz', '1. Platz im Mathe-Bieber Wettbewerb'),
(5, 4, 'Blasprinzessin', ':)');

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
(5, 'Nachhilfenehmer', 'Nimmt Nachhilfe');

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
(2, 3),
(3, 3),
(5, 3),
(33, 3),
(2, 5),
(3, 5),
(7, 5),
(33, 5),
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
(34, 2);

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
(1, 'Q1'),
(2, 'Q2'),
(3, '5'),
(4, '6'),
(5, '7'),
(6, '8'),
(7, '9'),
(8, '10'),
(9, 'EF'),
(10, '11'),
(11, '12'),
(12, '13');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stunde`
--

CREATE TABLE `stunde` (
  `idStunde` int(11) NOT NULL,
  `bezahltLehrer` tinyint(1) NOT NULL DEFAULT '0',
  `raumNummer` varchar(10) COLLATE utf8_bin NOT NULL,
  `idVerbindung` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `kommentar` varchar(500) COLLATE utf8_bin NOT NULL,
  `findetStatt` tinyint(1) NOT NULL DEFAULT '1',
  `bestaetigtSchueler` tinyint(1) DEFAULT '0',
  `bestaetigtLehrer` tinyint(1) DEFAULT '0',
  `bezahltAdmin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `stunde`
--

TRUNCATE TABLE `stunde`;
--
-- Daten für Tabelle `stunde`
--

INSERT INTO `stunde` (`idStunde`, `bezahltLehrer`, `raumNummer`, `idVerbindung`, `datum`, `kommentar`, `findetStatt`, `bestaetigtSchueler`, `bestaetigtLehrer`, `bezahltAdmin`) VALUES
(3, 0, '113', 7, '2017-01-13 18:00:00', '', 1, 0, 0, 0),
(4, 0, '113', 7, '2017-01-13 20:00:00', '', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verbindung`
--

CREATE TABLE `verbindung` (
  `idVerbindung` int(11) NOT NULL,
  `idNachhilfenehmer` int(11) NOT NULL,
  `idNachhilfelehrer` int(11) NOT NULL,
  `idFach` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- TRUNCATE Tabelle vor dem Einfügen `verbindung`
--

TRUNCATE TABLE `verbindung`;
--
-- Daten für Tabelle `verbindung`
--

INSERT INTO `verbindung` (`idVerbindung`, `idNachhilfenehmer`, `idNachhilfelehrer`, `idFach`) VALUES
(7, 4, 2, 1);

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
  MODIFY `idAnfrage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `idBenutzer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `berechtigung`
--
ALTER TABLE `berechtigung`
  MODIFY `idBerechtigung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT für Tabelle `chatnachricht`
--
ALTER TABLE `chatnachricht`
  MODIFY `idChatnachricht` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `fach`
--
ALTER TABLE `fach`
  MODIFY `idFach` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `qualifikation`
--
ALTER TABLE `qualifikation`
  MODIFY `idQualifikation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `rolle`
--
ALTER TABLE `rolle`
  MODIFY `idRolle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `stufe`
--
ALTER TABLE `stufe`
  MODIFY `idStufe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT für Tabelle `stunde`
--
ALTER TABLE `stunde`
  MODIFY `idStunde` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `verbindung`
--
ALTER TABLE `verbindung`
  MODIFY `idVerbindung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
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
