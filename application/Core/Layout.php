<?php

namespace Core;


/**
 * Class Layout
 * @package Core
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class Layout
{

    /**
     * @var
     */
    protected $_data;
    /**
     * @var bool
     */
    protected $disabled;
    /**
     * @var
     */
    protected $modules;
    /**
     * @var null
     */
    protected $controller;
    /**
     * @var string
     */
    protected $_name;
    /**
     * @var Layout\HeadScript
     */
    public $headScript;

    /**
     * @param null $controller
     * @param string $name
     */
    public function __construct($controller = null, $name = Default_Layout)
    {

        $this->data = [];
        $this->disabled = false;
        $this->_name = $name;
        $this->headScript = new \Core\Layout\HeadScript();
        $this->controller = $controller;

    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {

        $this->_data[$name] = $value;

    }

    /**
     * @param $name
     * @return bool
     */
    public function __get($name)
    {

        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        } else
            return false;

    }

    /**
     * @param $name
     * @param null $file
     * @param null $controller
     */
    public function insert($name, $file = null, $controller = null)
    {

        if ($file == null)
            $file = $name;

        $path = Application_Directory . "/";

        $path = $path . "Views/";
        if ($controller != null) {
            $path = $path . strtolower($controller) . "/";
        }
        $path = $path . strtolower($file) . ".phtml";
        if ($name == 'content')
            if (array_key_exists($name, $this->modules))
                if ($this->modules[$name] != '')
                    return;

        $this->modules[$name] = $path;

    }

    /**
     * @return mixed
     */
    public function getModules()
    {

        return $this->modules;

    }

    /**
     *
     */
    public function enable()
    {

        $this->disabled = false;

    }

    /**
     * @param $name
     */
    public function change($name)
    {

        $this->_name = $name;

    }

    /**
     *
     */
    public function disable()
    {

        $this->disabled = true;

    }

    /**
     * @param $controller
     */
    public function setController($controller)
    {

        $this->controller = $controller;

    }

    /**
     * @return bool
     */
    public function isDisabled()
    {

        return $this->disabled;

    }

    /**
     *
     */
    public function draw()
    {

        include(Application_Directory . "/Layouts/" . strtolower($this->_name) . ".phtml");

    }
}