<?php
namespace Astar;

class Node {

    /** @var int */
    protected $id;

    /** @var float */
    protected $x, $y;


    /** @var array */
    protected $data;

    /**
     * @param int $id
     * @param float $x
     * @param float $y
     */
    public function __construct($id, $x, $y)
    {
        $this->id = intval($id);
        $this->x = floatval($x);
        $this->y = floatval($y);
        $this->data = array();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @return float
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $name
     * @return null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefinierte Eigenschaft für __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' Zeile ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
}