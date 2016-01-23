<?php
namespace Tvswe\Astar;

class OpenList extends ClosedList
{
    /** @var array[] */
    protected $nodes;

    public function add(Node $node, $lowestCosts = 0) {
        $this->nodes[$node->getId()] = [
            'node' => $this->convertNode($node),
            'lowestCosts' => $lowestCosts,
            'previousCosts' => 0,
            'predecessor' => null
        ];
    }

    /**
     * @return ListNode
     */
    public function removeMin()
    {
        /** @var ListNode[] $nodes */
        $nodes = $this->nodes;

        /** @var ListNode $minNode */
        $minNode = array_pop($nodes);

        /** @var ListNode $currentNode */
        foreach($nodes as $currentNode) {
            if($currentNode['lowestCosts'] < $minNode['lowestCosts']) {
                $minNode = $currentNode;
            }
        }

        /** @var ListNode $node */
        $node = $minNode['node'];
        unset($this->nodes[$node->getId()]);

        return $node;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->nodes);
    }

    /**
     * @param ListNode $node
     * @param float $lowestCosts
     */
    public function setLowestCosts(ListNode $node, $lowestCosts)
    {
        if($this->contains($node)) {
            $this->nodes[$node->getId()]['lowestCosts'] = floatval($lowestCosts);
        }
    }

    /**
     * @param ListNode $node
     * @param float $previousCosts
     */
    public function setPreviousCosts(ListNode $node, $previousCosts)
    {
        if($this->contains($node)) {
            $this->nodes[$node->getId()]['previousCosts'] = floatval($previousCosts);
        }
    }

    /**
     * @param ListNode $node
     * @param ListNode $predecessor
     */
    public function setPredecessor(ListNode $node, ListNode $predecessor)
    {
        if($this->contains($node)) {
            $this->nodes[$node->getId()]['predecessor'] = $predecessor;
        }
    }
}
