<?php

namespace Models\Analyzer;


/**
 * Class ParameterSet
 * @package Models\Analyzer
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class ParameterSet
{
    /**
     * Sections - array of objects Parameter
     * @var array
     */
    protected $data = [];
    /**
     * Section size
     * @var int
     */
    protected $sectionSize;
    /**
     * Overall data Parameter is used for calculation of overall max, mean, etc
     * @var object of Parameter class
     */
    protected $overallParam;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     * @param int $sectionSize
     */
    public function __construct($name, $sectionSize = 10)
    {
        $this->sectionSize = $sectionSize;
        $this->name = $name;
        $this->overallParam = new Parameter;
    }

    /**
     * @return int
     */
    public function getSectionSize()
    {
        return $this->sectionSize;
    }

    /**
     * @param int $value
     * @param null $section
     */
    public function addValue($value, $section = null)
    {
        if ($section === null)
            $section = intval(round($value / $this->sectionSize));

        if (!array_key_exists($section, $this->data))
            $this->data[$section] = new Parameter;

        $this->data[$section]->addValue($value);
        $this->overallParam->addValue($value);
    }

    /**
     * @return array
     */
    public function getSorted(){

        ksort($this->data);
        return $this->data;

    }

    /**
     * todo: add parameter to fetch data over N
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return object
     */
    public function getOverallParam()
    {
        return $this->overallParam;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}