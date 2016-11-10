<?php
/**
 * Created by PhpStorm.
 * User: tim.goeller
 * Date: 26.10.2016
 * Time: 11:34
 */

namespace api;


class Stunde
{
    private $stufeID, $verbindungsID, $datum, $beschreibung, $findetStatt, $bestaetigtSchueler, $bestaetigtNachhilfelehrer,
    $bezahltAdmin, $bezahltLehrer, $raumID;

    /**
     * Stunde constructor.
     * @param $stufe
     * @param $verbindung
     * @param $datum
     * @param $beschreibung
     * @param $findetStatt
     * @param $bestaetigtSchueler
     * @param $bestaetigtNachhilfelehrer
     * @param $bezahltAdmin
     * @param $bezahltLehrer
     * @param $raumID
     */
    public function setAll($stufe, $verbindung, $datum, $beschreibung, $findetStatt, $bestaetigtSchueler, $bestaetigtNachhilfelehrer, $bezahltAdmin, $bezahltLehrer, $raumID)
    {
        $this->stufeID = $stufe;
        $this->verbindungsID = $verbindung;
        $this->datum = $datum;
        $this->beschreibung = $beschreibung;
        $this->findetStatt = $findetStatt;
        $this->bestaetigtSchueler = $bestaetigtSchueler;
        $this->bestaetigtNachhilfelehrer = $bestaetigtNachhilfelehrer;
        $this->bezahltAdmin = $bezahltAdmin;
        $this->bezahltLehrer = $bezahltLehrer;
        $this->raumID = $raumID;
        return $this;
    }


    public static function create()
    {
        $instance = new self();
        return $instance;
    }


    /**
     * @return mixed
     */
    public function getStufeID()
    {
        return $this->stufeID;
    }

    /**
     * @param mixed $stufeID
     */
    public function setStufeID($stufeID)
    {
        $this->stufeID = $stufeID;
    }

    /**
     * @return mixed
     */
    public function getVerbindungsID()
    {
        return $this->verbindungsID;
    }

    /**
     * @param mixed $verbindungsID
     */
    public function setVerbindungsID($verbindungsID)
    {
        $this->verbindungsID = $verbindungsID;
    }

    /**
     * @return mixed
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * @param mixed $datum
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    }

    /**
     * @return mixed
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }

    /**
     * @param mixed $beschreibung
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    /**
     * @return mixed
     */
    public function getFindetStatt()
    {
        return $this->findetStatt;
    }

    /**
     * @param mixed $findetStatt
     */
    public function setFindetStatt($findetStatt)
    {
        $this->findetStatt = $findetStatt;
    }

    /**
     * @return mixed
     */
    public function getBestaetigtSchueler()
    {
        return $this->bestaetigtSchueler;
    }

    /**
     * @param mixed $bestaetigtSchueler
     */
    public function setBestaetigtSchueler($bestaetigtSchueler)
    {
        $this->bestaetigtSchueler = $bestaetigtSchueler;
    }

    /**
     * @return mixed
     */
    public function getBestaetigtNachhilfelehrer()
    {
        return $this->bestaetigtNachhilfelehrer;
    }

    /**
     * @param mixed $bestaetigtNachhilfelehrer
     */
    public function setBestaetigtNachhilfelehrer($bestaetigtNachhilfelehrer)
    {
        $this->bestaetigtNachhilfelehrer = $bestaetigtNachhilfelehrer;
    }

    /**
     * @return mixed
     */
    public function getBezahltAdmin()
    {
        return $this->bezahltAdmin;
    }

    /**
     * @param mixed $bezahltAdmin
     */
    public function setBezahltAdmin($bezahltAdmin)
    {
        $this->bezahltAdmin = $bezahltAdmin;
    }

    /**
     * @return mixed
     */
    public function getBezahltLehrer()
    {
        return $this->bezahltLehrer;
    }

    /**
     * @param mixed $bezahltLehrer
     */
    public function setBezahltLehrer($bezahltLehrer)
    {
        $this->bezahltLehrer = $bezahltLehrer;
    }

    /**
     * @return mixed
     */
    public function getRaumID()
    {
        return $this->raumID;
    }

    /**
     * @param mixed $raumID
     */
    public function setRaumID($raumID)
    {
        $this->raumID = $raumID;
    }

}