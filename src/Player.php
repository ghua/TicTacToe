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

    const INITIAL_DEPTH = 0;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var string
     */
    private $side = 'o';

    /**
     * @var Node[]
     */
    private $nodes;

    /**
     * @var int
     */
    private $bestScore;

    /**
     * @var int
     */
    private $currentMoveChoice;

    /**
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
        $this->side = $this->board->getCurrentSide();
    }

    public function chooseBestMove()
    {
        if ($this->board->isUnplayed()) {
            return $this->board->getFreeCorner();
        }

        if ($this->board->isFinalMove()) {
            $availablePositions = $this->board->getAvailablePositions();

            return $availablePositions[0];
        }

        return $this->bestPossibleMove();
    }

    private function bestPossibleMove()
    {
        $this->bestScore = count($this->board->getAvailablePositions()) + 1;
        $bound = count($this->board->getAvailablePositions()) + 1;
        $this->minimax(clone $this->board, self::INITIAL_DEPTH, -$bound, $bound);

        return $this->currentMoveChoice;
    }

    /**
     * @param Board $board
     * @param int   $depth
     * @param int   $lowerBound
     * @param int   $upperBound
     *
     * @return int
     */
    private function minimax($board, $depth, $lowerBound, $upperBound)
    {
        $isGameOver = $board->isGameOver();
        if ($isGameOver) {
            return $this->evaluateState($board, $depth);
        }

        /**
         * @var Node[] $candidateMoveNodes
         */
        $candidateMoveNodes = [];
        $availablePositions = $board->getAvailablePositions();
        for ($n = 0; $n < count($availablePositions); $n++) {
            $move = $availablePositions[$n];
            $childBoard = clone $board;
            $childBoard->move($move);
            $score = $this->minimax($childBoard, $depth + 1, $lowerBound, $upperBound);
            $node = new Node($score, $move);

            if ($board->getCurrentSide() === $this->side) {
                $candidateMoveNodes[] = $node;
                if ($node->getScore() > $lowerBound) {
                    $lowerBound = $node->getScore();
                }
            } else {
                if ($node->getScore() < $upperBound) {
                    $upperBound = $node->getScore();
                }
            }
            if ($upperBound < $lowerBound) {
                break;
            }
        }

        if ($board->getCurrentSide() === $this->side) {
            $candidateScores = [];
            $candidateMoves = [];
            for ($n = 0; $n < count($candidateMoveNodes); $n++) {
                $node = $candidateMoveNodes[$n];
                $candidateMoves[] = $node->getPosition();
                $candidateScores[] = $node->getScore();
            }

            $this->currentMoveChoice = $candidateMoves[array_search(max($candidateScores), $candidateScores)];

            return $lowerBound;
        } else {
            return $upperBound;
        }
    }


    /**
     * @param Board $board
     * @param int   $depth
     *
     * @return int
     */
    private function evaluateState(Board $board, $depth)
    {
        $state = $board->isGameOver();

        if ($state === true) {
            return 0;
        }

        if ($state === $this->side) {
            return $this->bestScore - $depth;
        } else {
            return $depth - $this->bestScore;
        }
    }

}
