<?php
/**
 * Created by PhpStorm.
 * User: tim.goeller
 * Date: 26.10.2016
 * Time: 11:32
 */

namespace api;


class Stufe
{
    private $name;

    public function setAll($name){
        $this->$name = $name;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Stufe
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}