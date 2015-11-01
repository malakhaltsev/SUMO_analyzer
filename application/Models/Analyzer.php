<?php

namespace Models;


use Models\Analyzer\ParameterSet;

/**
 * Class Analyzer
 * @package Models
 *
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class Analyzer
{
    /**
     * @var array
     */
    protected $_data = [];

    /**
     * Analyzer constructor.
     * @param $_data
     */
    public function __construct()
    {

    }

    /**
     * @param \SimpleXMLElement $xml
     * @param string $name
     */
    public function addDataset(\SimpleXMLElement $xml, $name)
    {
        // init new DataSet
        $dataSet = new \stdClass();
        $dataSet->name = $name;
        $dataSet->waitSteps = new ParameterSet('Waiting Steps', 10);
        $dataSet->departDelay = new ParameterSet('Departure Delay', 10);
        $dataSet->deprart = new ParameterSet('Departure Time', 10);
        $dataSet->duration = new ParameterSet('Trip Duration', 10);

        // read values
        foreach ($xml as $item) {
            $attribs = $item->attributes();
            $dataSet->waitSteps->addValue(intval($attribs['waitSteps']));
            $dataSet->duration->addValue(intval($attribs['duration']));
            $dataSet->deprart->addValue(intval($attribs['depart']));
            $dataSet->departDelay->addValue(intval($attribs['departDelay']));
        }

        // Save
        array_push($this->_data, $dataSet);
    }

    /**
     *
     */
    public function getResults()
    {
        // map objects to output sections

        $map = ['waitSteps' => 'Waitings Steps',
                'duration' => 'Trip Duration',
                'deprart' => 'Departure Time',
                'departDelay' => 'Deprature Delay'];

        $result = [];
        foreach ($map as $className=>$title){
            $resultItem = new \stdClass();
            $resultItem->title = $title;
            $resultItem->name = $className;
            $sections = [];
            foreach ($this->_data as $dataset) {
                foreach ($dataset->$className->getSorted() as $key => $value) {
                    $key = $key * $dataset->$className->getSectionSize();
                    if (!in_array($key, $sections))
                        array_push($sections, $key);
                }
            }
            sort($sections);
            $resultItem->labels = $sections;
            $resultItem->series = [];
            $resultItem->overall = [];
            $resultItem->legends = [];
            foreach ($this->_data as $dataset) {
                $data = $dataset->$className->getData();
                foreach ($sections as $key) {
                    $key = $key / $dataset->$className->getSectionSize();
                    if (!array_key_exists($key, $data))
                        $data[$key] = 0;
                    else
                        $data[$key] = $data[$key]->getCount();
                }
                ksort($data);
                array_push($resultItem->series, $data);
                array_push($resultItem->overall, $dataset->$className->getOverallParam());
                array_push($resultItem->legends, $dataset->name);
            }

            array_push($result, $resultItem);
        }
        return $result;
    }

}