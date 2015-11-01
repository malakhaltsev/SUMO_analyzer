<?php

namespace Controllers;

use Core;

/**
 * Class Index
 * @package Controllers
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class Index extends Core\Controller
{

    /**
     *
     */
    public function _init()
    {

        $this->view->layout->insert("header");
        $this->view->menuId = 'index';
        $this->view->layout->headScript->appendTitle("SUMO-sim RA");

        if ($this->request->isAjax())
            $this->view->layout->disable();

    }

    /**
     *
     */
    public function indexAction()
    {


    }

}