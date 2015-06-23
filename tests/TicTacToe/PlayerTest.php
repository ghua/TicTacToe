<?php

namespace TicTacToe\Tests;

use TicTacToe\Player;
use TicTacToe\Board;

/**
 * Class PlayerTest
 *
 * @package TicTacToe\Tests
 *
 * @author  Semyon Velichko <semyon@velichko.net>
 */
class PlayerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Board
     */
    private $board;

    /**
     * @var Player
     */
    private $player;

    public function setUp()
    {
        $this->board = new Board();
        $this->player = new Player($this->board);
    }

    /**
     * @return array
     */
    public function pathAndScoreProvider()
    {
        return array(
            array(array('x', 0, 0, 0, 'x', 0, 0, 0, 'x'), array(0, 4, 8), 1),
            array(array(0, 0, 'x', 0, 'x', 0, 'x', 0, 0), array(2, 4, 6), 1),
            array(array('x', 'x', 'x', 0, 0, 0, 0, 0, 0), array(0, 1, 2), 1),
            array(array(0, 0, 0, 'x', 'x', 'x', 0, 0, 0), array(3, 4, 5), 1),
            array(array(0, 0, 0, 0, 0, 0, 'x', 'x', 'x'), array(6, 7, 8), 1),
            array(array('x', 0, 0, 'x', 0, 0, 'x', 0, 0), array(0, 3, 6), 1),
            array(array(0, 'x', 0, 0, 'x', 0, 0, 'x', 0), array(1, 4, 7), 1),
            array(array(0, 0, 'x', 0, 0, 'x', 0, 0, 'x'), array(2, 5, 8), 1),
        );
    }

    /**
     * @param array $state
     * @param array $path
     * @param int   $score
     *
     * @dataProvider pathAndScoreProvider
     */
    public function testAssessPath($state, $path, $score)
    {
        $this->board->setFields($state);
        $result = $this->player->assessPaths(array($path));
        $this->assertEquals($score, $result);
    }

}
