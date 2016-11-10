<?php
/**
 * Created by PhpStorm.
 * User: tim.goeller
 * Date: 26.10.2016
 * Time: 11:33
 */

namespace api;


class AngeboteneStufe
{
    private $benutzerID, $stufeID;

    /**
     * AngeboteneStufe constructor.
     * @param $benutzer
     * @param $stufe
     */
    public function setAll($benutzer, $stufe)
    {
        $this->benutzerID = $benutzer;
        $this->stufeID = $stufe;
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
     * @return AngeboteneStufe
     */
    public function setBenutzerID($benutzerID)
    {
        $this->benutzerID = $benutzerID;
        return $this;
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
     * @return AngeboteneStufe
     */
    public function setStufeID($stufeID)
    {
        $this->stufeID = $stufeID;
        return $this;
    }

}