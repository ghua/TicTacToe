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

            return $this;
        }

        return false;
    }

}
