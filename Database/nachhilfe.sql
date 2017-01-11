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
--
-- TRUNCATE Tabelle vor dem Einfügen `anfrage`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `angebotenesfach`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `angebotenesfach`
--


INSERT INTO `rolle` (`idRolle`, `name`, `beschreibung`) VALUES
(2, 'Administrator', 'Administriert diese Seite, die so unglaublich geil ist'),
(3, 'Nachhilfelehrer', 'Gibt Nachhilfe'),
(5, 'Nachhilfenehmer', 'Nimmt Nachhilfe');



-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `angebotenestufe`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `angebotenestufe`
--



-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benachrichtigung`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `benachrichtigung`
--
-- ---------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `benutzer`
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
--
-- TRUNCATE Tabelle vor dem Einfügen `berechtigung`
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
(33, 'canReport');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `beschwerde`
--

-- TRUNCATE Tabelle vor dem Einfügen `beschwerde`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chatnachricht`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `chatnachricht`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fach`
--

--
-- TRUNCATE Tabelle vor dem Einfügen `fach`
--

INSERT INTO `fach` (`idFach`, `name`) VALUES
(1, 'Deutsch'),
(2, 'Mathe'),
(3, 'Physik');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `qualifikation`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `qualifikation`
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
--
-- TRUNCATE Tabelle vor dem Einfügen `raum`
--

INSERT INTO `raum` (`raumNummer`) VALUES
('113'),
('114');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rolle`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `rolle`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rollenberechtigung`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `rollenberechtigung`
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
--
-- TRUNCATE Tabelle vor dem Einfügen `stufe`
--

INSERT INTO `stufe` (`idStufe`, `name`) VALUES
(1, 'Q1'),
(2, 'Q2');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stunde`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `stunde`
--



-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verbindung`
--
--
-- TRUNCATE Tabelle vor dem Einfügen `verbindung`
--

INSERT INTO `verbindung` (`idVerbindung`, `idNachhilfenehmer`, `idNachhilfelehrer`, `idFach`) VALUES
(2, 2, 4, 1),
(3, 4, 2, 3);

INSERT INTO `angebotenesfach` (`idBenutzer`, `idFach`) VALUES
(2, 1),
(2, 2),
(2, 3);


INSERT INTO `angebotenestufe` (`idBenutzer`, `idStufe`) VALUES
(2, 1),
(2, 2);


INSERT INTO `stunde` (`idStunde`, `bezahltLehrer`, `raumNummer`, `idVerbindung`, `datum`, `kommentar`, `findetStatt`, `bestaetigtSchueler`, `bestaetigtLehrer`, `bezahltAdmin`) VALUES
(2, 0, '113', 2, '2017-01-19 00:00:00', '', 1, 1, 0, 0);