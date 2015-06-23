<?php

namespace TicTacToe;

/**
 * Class Player
 *
 * @package TicTacToe
 *
 * @author  Semyon Velichko <semyon@velichko.net>
 */
class Player
{

    /**
     * @var Board
     */
    private $board;

    /**
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * @param int $position
     *
     * @return Node
     */
    private function setUpNode($position)
    {
        $node = new Node();
        $node->setBoardState($this->board->getFields());
        $node->setStepSide($this->board->getCurrentSide());
        $node->setPosition($position);
        $node->setWeight($this->assessCurrentBoardState());

        return $node;
    }

    /**
     * @param Node $parent
     *
     * @return Node
     */
    private function buildTree(Node $parent)
    {
        $availablePositions = $this->board->getAvailablePositions();
        for ($n = 0; $n < count($availablePositions); $n++) {
            $position = $availablePositions[$n];
            $node = $this->setUpNode($position);
            $this->board->move($position);
            $parent->addChildren($this->buildTree($node));
            $this->board->setFields($node->getBoardState());
            $this->board->setCurrentSide($node->getStepSide());
        }

        return $parent;
    }

    /**
     * @return int
     */
    private function assessCurrentBoardState()
    {
        $score = 0;
        $score += $this->assessPaths(array(array(0, 4, 8), array(2, 4, 6)));
        $score += $this->assessPaths(array(array(0, 1, 2), array(3, 4, 5), array(6, 7, 8)));
        $score += $this->assessPaths(array(array(0, 3, 6), array(1, 4, 7, array(2, 5, 8))));

        return $score;
    }

    /**
     * @param array $paths
     *
     * @return int
     */
    public function assessPaths($paths)
    {
        $score = 0;
        $ideal = str_repeat($this->board->getCurrentSide(), 3);

        for ($w = 0; $w < count($paths); $w++) {
            $path = $paths[$w];
            $result = '';
            for ($n = 0; $n < count($path); $n++) {
                $position = $path[$n];
                $field = $this->board->getField($position);
                $result .= (string) $field;
            }

            if ($result === $ideal) {
                $score += 1;
            }
        }

        return $score;
    }

}
