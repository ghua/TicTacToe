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
    private $score = 0;

    /**
     * @var int
     */
    private $position;


    /**
     * @param int    $score
     * @param int    $position
     */
    public function __construct($score, $position)
    {
        $this->score = $score;
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

}
