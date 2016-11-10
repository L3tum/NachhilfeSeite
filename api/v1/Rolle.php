<?php
/**
 * Created by PhpStorm.
 * User: tim.goeller
 * Date: 26.10.2016
 * Time: 11:16
 */

namespace api;


class Rolle
{
    private $name, $beschreibung;

    public function __construct()
    {

    }


    public static function create()
    {
        $instance = new self();
        return $instance;
    }

    /**
     * create Rolle.
     * @param $name
     * @param $beschreibung
     * @return $this
     */
    public function setAll($name, $beschreibung) {

        $this->name = $name;
        $this->beschreibung = $beschreibung;
        return $this;
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
     * @return Rolle
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return Rolle
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }
}