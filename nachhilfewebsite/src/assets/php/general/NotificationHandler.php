<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 26.12.2016
 * Time: 17:41
 */
include_once  __DIR__ . "/../dbClasses/Benutzer.php";
include_once  __DIR__ . "/../dbClasses/Anfrage.php";

class NotificationHandler
{

    public function echo_tutiution_requests() {

        /*$stmt = Connection::$PDO->prepare("SELECT * FROM anfrage WHERE verbindung.idNachhilfenehmer = :idAndererBenutzer && verbindung.idNachhilfelehrer = :idBenutzer OR verbindung.idNachhilfelehrer = :idAndererBenutzer && verbindung.idNachhilfenehmer = :idBenutzer");
        $stmt->bindParam(':idAndererBenutzer', $user->idBenutzer);
        $stmt->bindParam(':idBenutzer', $this->idBenutzer);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Verbindung');*/
    }
}