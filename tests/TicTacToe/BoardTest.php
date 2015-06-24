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

    /**
     * @return array
     */
    public function pathAndScoreProvider()
    {
        return array(
            array(array('x', 0, 0, 0, 'x', 0, 0, 0, 'x'), array(0, 4, 8), 'x'),
            array(array(0, 0, 'x', 0, 'x', 0, 'x', 0, 0), array(2, 4, 6), 'x'),
            array(array('x', 'x', 'x', 0, 0, 0, 0, 0, 0), array(0, 1, 2), 'x'),
            array(array(0, 0, 0, 'x', 'x', 'x', 0, 0, 0), array(3, 4, 5), 'x'),
            array(array(0, 0, 0, 0, 0, 0, 'x', 'x', 'x'), array(6, 7, 8), 'x'),
            array(array('x', 0, 0, 'x', 0, 0, 'x', 0, 0), array(0, 3, 6), 'x'),
            array(array(0, 'x', 0, 0, 'x', 0, 0, 'x', 0), array(1, 4, 7), 'x'),
            array(array(0, 0, 'x', 0, 0, 'x', 0, 0, 'x'), array(2, 5, 8), 'x'),
            array(array(0, 0, 'o', 0, 0, 'o', 0, 0, 'o'), array(2, 5, 8), 'o'),
            array(array('o', 'x', 'o', 'x', 'o', 'x', 'o', 'x', 'o'), array(2, 5, 8), false),
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
        $result = $this->board->assessPaths(array($path));
        $this->assertEquals($score, $result);
    }

}

