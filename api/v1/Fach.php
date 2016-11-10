<?php
/**
 * Created by PhpStorm.
 * User: tim.goeller
 * Date: 26.10.2016
 * Time: 11:47
 */

namespace api;

//Cameyo ftw

class Fach
{
    private  $fachID, $name;

    /**
     * @return mixed
     */
    public function getFachID()
    {
        return $this->fachID;
    }

    /**
     * @param mixed $fachID
     * @return Fach
     */
    public function setFachID($fachID)
    {
        
        $this->fachID = $fachID;
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
     * @return Fach
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}