<?php
namespace Astar;

class ListNode extends Node
{
    /**
     * Path length to this node
     * @var float
     */
    protected $previousCosts;

    /**
     * @var ListNode
     */
    protected $predecessor;

    /**
     * @param int $id
     * @param float $x
     * @param float $y
     * @param float $distance
     */
    public function __construct($id, $x, $y, $distance)
    {
        parent::__construct($id, $x, $y);
        $this->distance = floatval($distance);
        $this->predecessor = null;
    }

    /**
     * @param ListNode $predecessor
     */
    public function setPredecessor(ListNode $predecessor)
    {
        $this->predecessor = $predecessor;
    }

    /**
     * @return ListNode
     */
    public function getPredecessor()
    {
        return $this->predecessor;
    }

    /**
     * @param float $previousCosts
     */
    public function setPreviousCosts($previousCosts)
    {
        $this->previousCosts = $previousCosts;
    }

    /**
     * @return float
     */
    public function getPreviousCosts()
    {
        return $this->previousCosts;
    }
}