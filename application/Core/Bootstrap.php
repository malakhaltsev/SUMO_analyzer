<?php

namespace Core;

/**
 * Class Bootstrap
 * @package Core
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class Bootstrap
{

    /**
     * @var
     */
    protected $controller;
    /**
     * @var
     */
    protected $action;
    /**
     * @var
     */
    protected $params;
    /**
     * @var
     */
    protected $controllerObj;

    /**
     *
     */
    public function __construct()
    {

        $this->readparams();

    }

    /**
     * @return mixed
     */
    public function getController()
    {

        return $this->controllerObj;

    }

    /**
     * @return bool
     */
    public function startup()
    {

        session_start();

        $controllerName = "Controllers\\" . $this->controller;
        try {
            $this->controllerObj = new $controllerName;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
        $this->controllerObj->setAction($this->action);
        $this->controllerObj->setParams($this->params);

        $this->controllerObj->setName($this->controller);

        if (method_exists($this, "init")) {
            $this->init();
        }

        if (method_exists($this->controllerObj, "_init")) {
            $this->controllerObj->_init();
        }

        $this->controllerObj->execAction();
        $this->controllerObj->drawLayout();

        return true;
    }

    /**
     *
     */
    private function readparams()
    {

        $request = explode("?", $_SERVER['REQUEST_URI']);
        $request = explode("/", $request[0]);
        $currentKey = 1;

        if ((!array_key_exists($currentKey, $request)) || ($request[$currentKey] == ''))
            $this->controller = Default_Controller;
        else {
            $this->controller = $request[$currentKey];
            $currentKey++;
        }

        if ((!array_key_exists($currentKey, $request)) || ($request[$currentKey] == ''))
            $this->action = Default_Action;
        else {
            $this->action = $request[$currentKey];
            $currentKey++;
        }

        $this->controller = ucfirst($this->controller);
        $this->action = ucfirst($this->action);

        if (array_key_exists(5, $request)) {
            $params = new \stdClass();
            for ($i = 0; $i < $currentKey; $i++)
                unset($request[$i]);
            $name = 1;
            $value = '';
            foreach ($request as $data) {
                if ($name == 1) {
                    if ($data != '') {
                        $value = $data;
                        $name = 0;
                    }
                } else {
                    if ($value != '') {
                        $params->$value = $data;
                        $name = 1;
                    }
                }
            }
            $this->params = $params;
        }

    }

}