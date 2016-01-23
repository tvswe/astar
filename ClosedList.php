<?php
namespace Tvswe\Astar;

class ClosedList {

    /** @var Node[] */
    protected $nodes;

    public function __construct()
    {
        $this->nodes = [];
    }

    /**
     * @param Node $node
     * @return ListNode
     */
    protected function convertNode(Node $node)
    {
        if($node instanceof ListNode) {
            return $node;
        }

        $listNode = new ListNode(
            $node->getId(),
            $node->getX(),
            $node->getY(),
            0
        );

        $listNode->setData($node->getData());

        return $listNode;
    }

    /**
     * @param ListNode $node
     */
    public function add(ListNode $node)
    {
        $this->nodes[$node->getId()] = [
            'node' => $node,
            'previousCosts' => $node->getPreviousCosts()
        ];
    }

    /**
     * @param ListNode $node
     * @return bool
     */
    final public function contains(ListNode $node)
    {
        return array_key_exists($node->getId(), $this->nodes);
    }

    /**
     * @param ListNode $node
     */
    public function getPreviousCosts(ListNode $node)
    {
        if($this->contains($node)) {
            return $this->nodes[$node->getId()]['previousCosts'];
        }
    }
}
