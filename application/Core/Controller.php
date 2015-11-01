<?php

namespace Core;


/**
 * Class Controller
 * @package Core
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class Controller
{

    /**
     * @var View
     */
    public $view;
    /**
     * @var null
     */
    protected $params;
    /**
     * @var null
     */
    protected $_name;
    /**
     * @var null
     */
    protected $action;
    /**
     * @var Request
     */
    protected $request;

    /**
     * @param null $action
     * @param null $params
     * @param null $name
     * @param null $module
     * @param null $lang
     */
    public function __construct($action = null, $params = null, $name = null)
    {
        $this->action = $action;
        $this->params = $params;
        $this->_name = $name;

        $this->view = new View();
        $this->request = new Request();
    }

    /**
     *
     */
    public function _init()
    {

        $this->view->layout->insert("header");
        $this->view->layout->insert("bottom");

        if ($this->request->isAjax()) {
            $this->view->layout->disable();
        }
    }

    /**
     * @return bool
     */
    public function execAction()
    {
        $action = $this->action . "Action";
        if (method_exists($this, $action)) {
            return $this->$action();
        } else {
            //echo "Controller: cann't find action";
            return false;
        }
    }

    /**
     *
     */
    public function drawLayout()
    {
        $this->view->layout->insert("content", $this->action, $this->_name);
        $this->view->draw();
    }

    /**
     * @param $params
     */
    public function setParams($params)
    {
        $this->params = $params;
        $this->request->setParams($params);
        $this->view->setParams($params);
    }

    /**
     * @param $action
     */
    public function setAction($action)
    {
        $this->action = $action;
        $this->view->setAction($action);
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->_name = $name;
        $this->view->setController($name);
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param $url
     * @param null $type
     */
    public function _redirect($url, $type = null)
    {
        if (($this->request->isAjax()) && $type == 'full') {
            echo "<script>window.location.href='$url'</script>";
        } else {
            header("Location: $url");
        }
        $this->view->stop();
    }

}