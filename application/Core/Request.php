<?php

namespace Core;


/**
 * Class Request
 * @package Core
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class Request
{

    /**
     * @var
     */
    protected $method;
    /**
     * @var null
     */
    protected $params;

    /**
     * @param null $params
     */
    public function __construct($params = null)
    {
        $this->params = $params;
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->method === 'POST';
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
    public function isGet()
    {
        return $this->method === 'GET';
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * @param $name
     * @return bool
     */
    public function getParam($name, $default = null)
    {

        if (isset($this->params->$name)) {
            return $this->params->$name;
        } else {
            if (array_key_exists($name, $_POST)) {
                return $_POST[$name];
            } elseif (array_key_exists($name, $_GET)) {
                return $_GET[$name];
            } else {
                return $default;
            }
        }

    }

    /**
     * @param $name
     * @return bool
     */
    public function getPostParam($name, $default = null)
    {
        return array_key_exists($name, $_POST) ? $_POST[$name] : $default;
    }

}