<?php
/**
 * Created by PhpStorm.
 * User: tim.goeller
 * Date: 26.10.2016
 * Time: 11:06
 */

namespace api;


class Benutzer
{
    private $benutzerID, $vorname, $name, $email, $passwort, $telefonnummer, $gesperrt, $rolle;


    /**
     * Benutzer constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $benutzerID
     * @param $vorname
     * @param $name
     * @param $email
     * @param $passwort
     * @param $telefonnummer
     * @param $gesperrt
     * @param $rolle
     * @return $this
     */

    public function setAll($benutzerID, $vorname, $name, $email, $passwort, $telefonnummer, $gesperrt, $rolle)
    {
        $this->benutzerID = $benutzerID;
        $this->vorname = $vorname;
        $this->name = $name;
        $this->email = $email;
        $this->passwort = $passwort;
        $this->telefonnummer = $telefonnummer;
        $this->gesperrt = $gesperrt;
        $this->rolle = $rolle;

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
    public function getBenutzerID()
    {
        return $this->benutzerID;
    }

    /**
     * @param mixed $benutzerID
     */
    public function setBenutzerID($benutzerID)
    {
        $this->benutzerID = $benutzerID;
    }

    /**
     * @return mixed
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * @param mixed $vorname
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPasswort()
    {
        return $this->passwort;
    }

    /**
     * @param mixed $passwort
     */
    public function setPasswort($passwort)
    {
        $this->passwort = $passwort;
    }

    /**
     * @return mixed
     */
    public function getTelefonnummer()
    {
        return $this->telefonnummer;
    }

    /**
     * @param mixed $telefonnummer
     */
    public function setTelefonnummer($telefonnummer)
    {
        $this->telefonnummer = $telefonnummer;
    }

    /**
     * @return mixed
     */
    public function getGesperrt()
    {
        return $this->gesperrt;
    }

    /**
     * @param mixed $gesperrt
     */
    public function setGesperrt($gesperrt)
    {
        $this->gesperrt = $gesperrt;
    }

    /**
     * @return mixed
     */
    public function getRolle()
    {
        return $this->rolle;
    }

    /**
     * @param mixed $rolle
     */
    public function setRolle($rolle)
    {
        $this->rolle = $rolle;
    }


}