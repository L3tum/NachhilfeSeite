<?php
/**
 * Created by PhpStorm.
 * User: tim.goeller
 * Date: 26.10.2016
 * Time: 11:41
 */

namespace api;


class Verbindung
{
    private $verbindungsID, $benutzerID1, $benutzerID2, $fachID;

    /**
     * Verbindung constructor.
     * @param $verbindungsID
     * @param $benutzerID1
     * @param $benutzerID2
     * @param $fachID
     */
    public function setAll($verbindungsID, $benutzerID1, $benutzerID2, $fachID)
    {
        $this->verbindungsID = $verbindungsID;
        $this->benutzerID1 = $benutzerID1;
        $this->benutzerID2 = $benutzerID2;
        $this->fachID = $fachID;
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
    public function getVerbindungsID()
    {
        return $this->verbindungsID;
    }

    /**
     * @param mixed $verbindungsID
     * @return Verbindung
     */
    public function setVerbindungsID($verbindungsID)
    {
        $this->verbindungsID = $verbindungsID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBenutzerID1()
    {
        return $this->benutzerID1;
    }

    /**
     * @param mixed $benutzerID1
     * @return Verbindung
     */
    public function setBenutzerID1($benutzerID1)
    {
        $this->benutzerID1 = $benutzerID1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBenutzerID2()
    {
        return $this->benutzerID2;
    }

    /**
     * @param mixed $benutzerID2
     * @return Verbindung
     */
    public function setBenutzerID2($benutzerID2)
    {
        $this->benutzerID2 = $benutzerID2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFachID()
    {
        return $this->fachID;
    }

    /**
     * @param mixed $fachID
     * @return Verbindung
     */
    public function setFachID($fachID)
    {
        $this->fachID = $fachID;
        return $this;
    }

}