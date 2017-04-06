<?php

/**
 * Created by PhpStorm.
 * User: Tim
 * Date: 07.12.2016
 * Time: 22:10
 */

include_once  __DIR__ . "/ConfigStrings.php";

class Route{

    public static $routes = Array();
    public static $routes404 = Array();
    public static $path;

    public static function init(){

        $parsed_url = parse_url($_SERVER['REQUEST_URI']);//URI zerlegen

        if(isset($parsed_url['path'])){

            if($parsed_url['path']  == '/') {

                self::$path = $parsed_url['path'];
            }
            else {
                self::$path = trim($parsed_url['path'],'/');
            }
        }else{
            self::$path = '';
        }


    }

    public static function add($expression,$function,$needsUser = true){

        array_push(self::$routes,Array(
            'expression'=>$expression,
            'function'=>$function,
            'userNeeded' => $needsUser
        ));

    }

    public static function add404($function){

        array_push(self::$routes404,$function);

    }

    public static function run(){



        $route_found = false;

        foreach(self::$routes as $route){

            if(ConfigStrings::get('root')){

                $route['expression'] = ConfigStrings::get('root') . $route['expression'];

            }

            //Add 'find string start' automatically
            $route['expression'] = '^'.$route['expression'];

            //Add 'find string end' automatically
            $route['expression'] = $route['expression'].'$';

            //echo $route['expression'] . "  ";
            //echo self::$path . "  ";
            //check match
            if(preg_match('#'.$route['expression'].'#',self::$path,$matches)){

                //echo $expression;

                array_shift($matches);//Always remove first element. This contains the whole string

                if(ConfigStrings::get('basepath')){

                    array_shift($matches);//Remove Basepath

                }

                if($route['userNeeded'] == true) {
                    if (!Benutzer::get_logged_in_user()) {

                        include "special/welcome.php";
                    }
                    else {
                        call_user_func_array($route['function'], $matches);
                    }
                }


                $route_found = true;

            }

        }

        if(!$route_found){

            foreach(self::$routes404 as $route404){

                call_user_func_array($route404, Array(self::$path));

            }

        }



    }

    public static function redirect_to_root() {
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: "."https://$host$uri/");
        exit();
    }

    public static function get_root(){
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/ajax');
        return self::get_root_http_https($host, $uri);
    }
    public static function get_root_forms(){
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/ajax/Forms');
        return self::get_root_http_https($host, $uri);
    }
    
}