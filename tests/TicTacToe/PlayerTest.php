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

    public function testChosePossibleMove()
    {
        $this->assertTrue($this->board->move(4));
        $bestMove = $this->player->chooseBestMove();
        $this->assertEquals(0, $bestMove);
        $this->assertTrue($this->board->move($bestMove));
        $this->assertTrue($this->board->move(2));
        $bestMove = $this->player->chooseBestMove();
        $this->assertEquals(6, $bestMove);
        $this->assertTrue($this->board->move($bestMove));
        $this->assertTrue($this->board->move(3));
        $bestMove = $this->player->chooseBestMove();
        $this->assertEquals(5, $bestMove);
        $this->assertTrue($this->board->move($bestMove));
        $this->assertTrue($this->board->move(1));
        $bestMove = $this->player->chooseBestMove();
        $this->assertEquals(7, $bestMove);
        $this->assertTrue($this->board->move($bestMove));
        $this->assertTrue($this->board->move(8));

        $this->assertTrue($this->board->isGameOver());

        return;
    }

}
