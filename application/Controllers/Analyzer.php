<?php

namespace Controllers;

use Core;
use Models;

/**
 * Class Analyzer
 * @package Controllers
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class Analyzer extends Core\Controller
{

    /**
     *
     */
    public function _init()
    {

        $this->view->layout->insert("header");
        $this->view->menuId = 'analyzer';
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

    /**
     *
     */
    public function resultsAction()
    {

        // Init errors stack
        $this->view->errors = '';

        $Analyzer = new Models\Analyzer;

        $dataSetNames = $this->request->getPostParam('title');

        // Read data files and add to the model
        foreach ($_FILES['file']['tmp_name'] as $key => $file) {
            if ($file=='')
                continue;
            try {
                $data = file_get_contents($file);
                if ($data!='')
                    $Analyzer->addDataset(new \SimpleXMLElement($data),$dataSetNames[$key]);
            } catch (\Exception $e) {
                // add to errors stack
                $this->view->errors .= 'File ' . $file . " counldn't be parsed<br />";
            }
        }
        $this->view->data = $Analyzer->getResults();

    }

}