<?php

namespace TicTacToe;

/**
 * Class Board
 *
 * @package TicTacToe
 *
 * @author  Semyon Velichko <semyon@velichko.net>
 */
class Board
{

    /**
     * @var array
     */
    private $fields = array(0, 0, 0, 0, 0, 0, 0, 0, 0);

    /**
     * @var string
     */
    private $currentSide = 'x';

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     *
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param int  $num
     * @param null $value
     *
     * @throws \InvalidArgumentException
     *
     * @return $this
     */
    public function setField($num, $value = null)
    {
        if ($this->validateFieldNum($num)) {
            if ($this->validateFieldValue($value)) {
                $this->fields[$num] = $value;

                return $this;
            } else {
                throw new \InvalidArgumentException('Field value should be "x", "o" or 0');
            }
        } else {
            throw new \InvalidArgumentException('Field number should be between 0 and 8 inclusively');
        }
    }

    /**
     * @param int $num
     *
     * @return bool
     */
    private function validateFieldNum($num)
    {
        return $num >= 0 && $num <= 8;
    }

    /**
     * @param string|int $value
     *
     * @return bool
     */
    private function validateFieldValue($value)
    {
        return in_array($value, array('x', 'o', 0));
    }

    /**
     * @return string
     */
    public function getCurrentSide()
    {
        return $this->currentSide;
    }

    /**
     * @param string $currentSide
     *
     * @return $this;
     */
    public function setCurrentSide($currentSide)
    {
        if (!in_array($currentSide, array('x', 'o'))) {
            throw new \InvalidArgumentException('Current side should be "x" or "o"');
        }

        $this->currentSide = $currentSide;

        return $this;
    }

    /**
     * @return $this
     */
    public function reverseSide()
    {
        $this->setCurrentSide($this->getCurrentSide() === 'x' ? 'o' : 'x');

        return $this;
    }

    /**
     * @param int $num
     *
     * @throws \LogicException
     *
     * @return bool|int|string
     */
    public function getField($num)
    {
        if ($this->validateFieldNum($num)) {
            return $this->fields[$num];
        }

        return false;
    }

    /**
     * @return array
     */
    public function getAvailablePositions()
    {
        return array_keys(
            array_filter($this->getFields(), function ($key, $num) {
                return $this->isAvailablePosition($num);
            }, ARRAY_FILTER_USE_BOTH)
        );
    }

    /**
     * @param $num
     *
     * @return bool
     */
    public function isAvailablePosition($num)
    {
        if ($this->validateFieldNum($num)) {
            return $this->getField($num) === 0;
        }

        return false;
    }

    /**
     * @param $num
     *
     * @return $this|bool
     */
    public function move($num)
    {
        if ($this->isAvailablePosition($num)) {
            $this->setField($num, $this->getCurrentSide());
            $this->reverseSide();

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isUnplayed()
    {
        return count($this->getAvailablePositions()) === 9;
    }

    /**
     * @return bool|int
     */
    public function isFinalMove()
    {
        $availablePositions = $this->getAvailablePositions();

        return count($availablePositions) === 1;
    }

    /**
     * @return bool
     */
    public function getFreeCorner()
    {
        $corners = [0, 2, 6, 8];
        for ($n = 0; $n < count($corners); $n++) {
            if ($this->isAvailablePosition($corners[$n])) {
                return $corners[$n];
            }
        }

        return false;
    }

    /**
     * @return int
     */
    public function isGameOver()
    {
        $availablePositions = $this->getAvailablePositions();
        if (count($availablePositions) === 0) {
            return true;
        }

        return $this->assessPaths(array(
            [0, 4, 8], [2, 4, 6],
            [0, 1, 2], [3, 4, 5], [6, 7, 8],
            [0, 3, 6], [1, 4, 7], [2, 5, 8]
        ));
    }

    /**
     * @param array $paths
     *
     * @return int
     */
    public function assessPaths($paths)
    {
        for ($w = 0; $w < count($paths); $w++) {
            $path = $paths[$w];
            $result = '';
            for ($n = 0; $n < count($path); $n++) {
                $position = $path[$n];
                $field = $this->getField($position);
                $result .= (string) $field;
            }

            if ($result === 'xxx' || $result === 'ooo') {
                return $result[0];
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $return = '';
        for ($n = 0; $n < count($this->fields); $n++) {
            $field = $this->getField($n);
            if ($field) {
                $return .= ' ' . $field . ' ';
            } else {
                $return .= '   ';
            }

            if (!in_array($n, [2, 5, 8])) {
                $return .= "|";
            }
            if (($n+1) % 3 === 0) {
                $return .= "\n";
                if ($n !== 8) {
                    $return .= str_repeat('-', 11) . "\n";
                }
            }
        }

        return $return;
    }

}
