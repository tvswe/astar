<?php
namespace Tvswe\Astar;

final class Astar
{
    /** @var OpenList */
    private static $openList;

    /** @var ClosedList */
    private static $closedList;

    /**
     * @param Node $start
     * @param Node $end
     * @param callable $getSuccessors
     * @return Path
     */
    public static function findPath(Node $start, Node $end, callable $getSuccessors)
    {
        self::$openList = new OpenList();
        self::$closedList = new ClosedList();

        self::$openList->add($start);
        $current = null;

        do {
            /** @var ListNode $current */
            $current = self::$openList->removeMin();

            if($current->getId() === $end->getId()) {
                return new Path($current);
            }

            self::$closedList->add($current);
            self::expandNode($current, $end, $getSuccessors);
        } while(!self::$openList->isEmpty());

        return null;
    }

    /**
     * @param Node $node1
     * @param Node $node2
     * @return float
     */
    public static function getLinearDistance(Node $node1, Node $node2)
    {
        $dist_x = abs($node1->getX() - $node2->getX());
        $dist_y = abs($node1->getY() - $node2->getY());

        return hypot($dist_x, $dist_y);
    }

    /**
     * @param ListNode $node
     * @param Node $target
     * @param callable $getSuccessors
     */
    private static function expandNode(ListNode $node, Node $target, callable $getSuccessors)
    {
        /** @var ListNode[] $successors */
        $successors = call_user_func($getSuccessors, $node);

        /** @var ListNode $successor */
        foreach($successors as $successor) {
            if(self::$closedList->contains($successor)) {
                continue;
            }

//            echo '<pre>';
//            var_dump($successor);
//            echo '</pre>';
//            exit;

            $tentativeCosts = self::$closedList->getPreviousCosts($node) + self::getLinearDistance($node, $successor);

            if(self::$openList->contains($successor) && $tentativeCosts >= self::$openList->getPreviousCosts($successor)) {
                continue;
            }

            $successor->setPredecessor($node);
            $successor->setPreviousCosts($tentativeCosts);

            $lowestCosts = $tentativeCosts + self::getLinearDistance($successor, $target);

            if(self::$openList->contains($successor)) {
                self::$openList->setLowestCosts($successor, $lowestCosts);
            } else {
                self::$openList->add($successor, $lowestCosts);
            }

            self::$openList->setPredecessor($successor, $node);
            self::$openList->setPreviousCosts($successor, $tentativeCosts);
        }
    }
}
