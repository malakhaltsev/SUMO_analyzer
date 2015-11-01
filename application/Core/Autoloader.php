<?php

/**
 * Class Autoloader
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 *
 */
class Autoloader
{

    /**
     * @var
     */
    static protected $base;

    /**
     *
     */
    static function init()
    {

        self::$base = Application_Directory;

    }

    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * @param $class_name
     * @throws Exception
     */
    static public function load($class_name)
    {

        $pathSet = explode("\\", $class_name);

        if (count($pathSet) > 0) {
            if ($pathSet[0] == 'Core') {
                $path = "/Core";
                unset($pathSet[0]);
            } else
                $path = '';

            foreach ($pathSet as $part)
                $path = $path . "/" . ucwords($part);
            $path = $path . ".php";

            if (file_exists(self::$base . $path)) {
                include_once(self::$base . $path);
            } else
                throw new Exception("Cann't find class $class_name");
        } else {
            if (file_exists(self::$base . "/Models/" . $class_name . ".php"))
                include_once(self::$base . "/Models/" . $class_name . ".php");
            else
                throw new Exception("Cann't find class $class_name");
        }

    }

}

Autoloader::init();

/**
 * @param $class_name
 * @throws Exception
 */
function __autoload($class_name)
{

    Autoloader::load($class_name);

}