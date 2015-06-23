<?php


namespace TicTacToe\Tests;

use TicTacToe\Board;

/**
 * Class BoardTest
 *
 * @package TicTacToe\Tests
 *
 * @author  Semyon Velichko <semyon@velichko.net>
 */
class BoardTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Board
     */
    private $board;

    public function setUp()
    {
        $this->board = new Board();
    }

    /**
     * @return array
     */
    public function fieldsProvider()
    {
        return array(
            array(-1, false),
            array(0, true),
            array(1, true),
            array(2, true),
            array(3, true),
            array(4, true),
            array(5, true),
            array(6, true),
            array(7, true),
            array(8, true),
            array(9, false)
        );
    }

    /**
     * @param int     $num
     * @param boolean $isExist
     *
     * @dataProvider fieldsProvider
     */
    public function testGet($num, $isExist)
    {
        $result = $this->board->getField($num);
        if ($isExist) {
            $this->assertTrue($result === 0);
        } else {
            $this->assertFalse($result);
        }
    }

    public function testReverseSide()
    {
        $this->board->setCurrentSide('x');
        $this->board->reverseSide();
        $this->assertEquals('o', $this->board->getCurrentSide());
    }

    public function testAvailablePositions()
    {
        $this->board->setField(0, 'x');
        $this->board->setField(2, 'o');
        $this->board->setField(8, 'x');
        $availablePositions = $this->board->getAvailablePositions();
        $this->assertEquals(array(1, 3, 4, 5, 6, 7), $availablePositions);
    }

    public function testMove()
    {
        $this->assertEquals('x', $this->board->getCurrentSide());
        $this->assertEquals(0, $this->board->getField(3));
        $this->assertNotFalse($this->board->move(3));
        $this->assertEquals('o', $this->board->getCurrentSide());
        $this->assertEquals('x', $this->board->getField(3));
    }

}
