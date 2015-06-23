<?php


namespace TicTacToe;

/**
 * Class Node
 *
 * @package TicTacToe
 *
 * @author  Semyon Velichko <semyon@velichko.net>
 */
class Node
{

    /**
     * @var int
     */
    private $weight = 0;

    /**
     * @var Node[]
     */
    private $children = array();

    /**
     * @var string
     */
    private $boardState;

    /**
     * @var int
     */
    private $position;

    /**
     * @var string
     */
    private $stepSide;

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     *
     * @return $this;
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Node[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Node[] $children
     *
     * @return $this;
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return string
     */
    public function getBoardState()
    {
        return $this->boardState;
    }

    /**
     * @param string $boardState
     *
     * @return $this;
     */
    public function setBoardState($boardState)
    {
        $this->boardState = $boardState;

        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return $this;
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getStepSide()
    {
        return $this->stepSide;
    }

    /**
     * @param string $stepSide
     *
     * @return $this;
     */
    public function setStepSide($stepSide)
    {
        $this->stepSide = $stepSide;

        return $this;
    }

    /**
     * @param Node $node
     *
     * @return $this
     */
    public function addChildren(Node $node) {
        $this->children[] = $node;

        return $this;
    }

}
