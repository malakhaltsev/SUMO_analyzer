<?php

namespace Core\Layout;


/**
 * Class HeadScript
 * @package Core\Layout
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class HeadScript
{

    /**
     * @var array
     */
    protected $_data;
    /**
     * @var array
     */
    protected $_title;

    /**
     *
     */
    public function __construct()
    {

        $this->_data = array();
        $this->_title = array();

    }

    /**
     * @param $filename
     * @param $type
     */
    public function append($filename, $type)
    {
        $data = false;

        switch ($type) {

            case 'css':
                $data = '<link rel="stylesheet" href="' . $filename . '" type="text/css" />';
                break;

            case 'js':
                $data = '<script type="text/javascript" src="' . $filename . '"></script>';
                break;

        }
        if ($data!==false)
            $this->_data[$filename] = $data;

    }

    /**
     * @param $title
     */
    public function appendTitle($title)
    {

        $this->_title[$title] = $title;

    }

    /**
     * @return string
     */
    public function read()
    {

        $data = '';
        if ($this->_data)
            foreach ($this->_data as $row)
                $data = $data . $row . "\n";
        return $data;

    }

    /**
     * @return string
     */
    public function readTitle()
    {

        $data = '';
        if ($this->_title)
            foreach ($this->_title as $row) {
                $data = $data . $row . " ";
            }
        return "<title>" . $data . "</title>";

    }

}