<?php

namespace Core;


/**
 * Class View
 * @package Core
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class View
{

    /**
     * @var Layout - Layout object
     */
    public $layout;
    /**
     * @var _data - for _set/_get
     */
    protected $_data;
    /**
     * @var null
     */
    protected $controller;
    /**
     * @var action - current Controller's action
     */
    protected $action;
    /**
     * @var
     */
    protected $params;
    /**
     * @var bool
     */
    protected $_stop;
    /**
     * @var array
     */
    protected $DATE_FORMATS;

    /**
     * @param null $module
     * @param null $controller
     */
    public function __construct($module = null, $controller = null)
    {

        $this->data = array();
        $this->layout = new Layout();
        $this->controller = $controller;
        $this->_stop = false;
        $this->DATE_FORMATS = array(
            'en' => 'Y-m-d',
            'ru' => 'd.m.Y',
            'hu' => 'Y/m/d',
        );

    }

    /**
     *
     */
    public function stop()
    {

        $this->_stop = true;

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
     * @param $controller
     */
    public function setController($controller)
    {

        $this->controller = $controller;
        $this->layout->setController($controller);

    }

    /**
     * @param $action
     */
    public function setAction($action)
    {

        $this->action = $action;

    }

    /**
     * @param $params
     */
    public function setParams($params)
    {

        $this->params = $params;

    }

    /**
     * @return bool
     */
    public function draw()
    {

        if ($this->_stop == true)
            return false;

        foreach ($this->layout->getModules() as $key => $filename) {
            ob_start();

            if (file_exists($filename))
                include $filename;

            $this->layout->$key = ob_get_contents();
            echo $this->layout->$key;
            ob_end_clean();
        }
        if ($this->layout->isDisabled() === false)
            $this->layout->draw();
        else
            echo $this->layout->content;
    }

    /**
     * @param $pararms
     * @param bool|false $clear
     * @return string
     */
    public function url($pararms, $clear = false)
    {

        $url = "/";

        if (array_key_exists("controller", $pararms)) {
            $url = $url . $pararms['controller'] . "/";
            unset($pararms['controller']);
        } else
            $url = $url . strtolower($this->controller) . "/";

        if (array_key_exists("action", $pararms)) {
            $url = $url . $pararms['action'] . "/";
            unset($pararms['action']);
        } else
            $url = $url . strtolower($this->action) . "/";

        foreach ($pararms as $key => $value) {
            if ($value != null)
                $url = $url . "$key/$value/";
        }

        if ($clear == false) {
            if (count($this->params))
                foreach ($this->params as $key => $value) {
                    if (!array_key_exists($key, $pararms))
                        $url = $url . "$key/$value/";
                }
        }

        return $url;

    }
}