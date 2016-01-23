<?php
namespace Tvswe\Astar;

final class Path implements \ArrayAccess, \Countable, \Iterator {

    /** @var Node[] */
    private $nodes;

    private $length;

    public function __construct(ListNode $lastNode)
    {
        $this->nodes = [$this->convertNode($lastNode)];
        $this->length = $lastNode->getPreviousCosts();

        $node = $lastNode;
        while($node = $node->getPredecessor()) {
            $this->nodes[] = $this->convertNode($node);
        }

        $this->nodes = array_reverse($this->nodes);
    }

    /**
     * @param ListNode $node
     * @return Node
     */
    public function convertNode(ListNode $node)
    {
        return new Node(
            $node->getId(),
            $node->getX(),
            $node->getY()
        );
    }

    /**
     * @param Node $node
     */
    public function addNode(Node $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->nodes[$offset]);
    }

    /**
     * @param int $offset
     * @return Node|null
     */
    public function offsetGet($offset)
    {
        return isset($this->nodes[$offset]) ? $this->nodes[$offset] : null;
    }

    /**
     * @param int $offset
     * @param Node $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->nodes[] = $value;
        } else {
            $this->nodes[$offset] = $value;
        }
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->nodes[$offset]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->nodes);
    }

    /**
     * @return Node
     */
    public function current()
    {
        return current($this->nodes);
    }

    /**
     *
     */
    public function next()
    {
        next($this->nodes);
    }

    /**
     * @return int
     */
    public function key()
    {
        return key($this->nodes);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return (bool) current($this->nodes);
    }

    /**
     *
     */
    public function rewind()
    {
        reset($this->nodes);
    }
}
