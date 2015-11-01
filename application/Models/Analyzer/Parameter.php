<?php
/**
 * Created by PhpStorm.
 * User: malakhaltsevpetr
 * Date: 01/11/15
 * Time: 19:50
 */

namespace Models\Analyzer;


/**
 * Class Parameter
 * @package Models\Analyzer
 * @author Petr Malakhaltsev
 * @version 1.0
 */
class Parameter
{
    /**
     * @var array
     */
    protected $_data = [];
    /**
     * @var int
     */
    protected $sum = 0;
    /**
     * @var int
     */
    protected $count = 0;
    /**
     * @var int
     */
    protected $max = null;
    /**
     * @var int
     */
    protected $min = null;

    /**
     * Parameter constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $value
     */
    public function addValue($value)
    {
        array_push($this->_data, $value);
        $this->sum += $value;

        if ($this->max === null)
            $this->max = $value;
        elseif ($this->max < $value)
            $this->max = $value;

        if ($this->min === null)
            $this->min = $value;
        elseif ($this->min > $value)
            $this->min = $value;

        $this->count++;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return null|int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return null|int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param int $precision
     * @return float
     */
    public function getMean($precision = 2)
    {
        return round($this->sum / $this->count, $precision);
    }
}