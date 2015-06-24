<?php

include_once(__DIR__ . '/vendor/autoload.php');

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use TicTacToe\Board;
use TicTacToe\Player;

$console = new Application();

$command = new \Symfony\Component\Console\Command\Command('play');
$command
    ->setDescription('Tic tac toe game for spotoption')
    ->setHelp('
    Hello!

    This is my board:
     0 | 1 | 2
    -----------
     3 | 4 | 5
    -----------
     6 | 7 | 8
    ')
    ->setCode(function (InputInterface $input, OutputInterface $output) {
        /**
         * @var QuestionHelper $helper
         */
        $helper = $this->getHelper('question');

        $question = new ChoiceQuestion(
            'Please select your side', ['x', 'o'], 0
        );
        $question->setMaxAttempts(2);
        $question->setErrorMessage('Side %s is invalid.');
        $side = $helper->ask($input, $output, $question);

        $board = new Board();
        $player = new Player($board);

        if ($side === 'o') {
            $move = $player->chooseBestMove();
            $board->move($move);
            $output->writeln('My move: ' . $move);
            $output->write((string) $board);
        }

        $question = new ChoiceQuestion(
            'Please select your step', $board->getAvailablePositions(), 9
        );
        $question->setMaxAttempts(2);
        $question->setErrorMessage('Position %s is invalid.');
        while ($board->isGameOver() === false) {
            $output->writeln(str_repeat('*', 30));
            $position = $helper->ask($input, $output, $question);
            if ($board->move((integer) $position)) {
                $output->write((string) $board);
                $output->writeln(str_repeat('*', 30));

                $isGameOver = $board->isGameOver();
                if ($isGameOver === false) {
                    $output->writeln('Thinking...');
                    $move = $player->chooseBestMove();
                    $board->move($move);
                    $output->writeln('My move: ' . $move);
                    $output->write((string) $board);
                } else {
                    if ($isGameOver === $side) {
                        $output->writeln('You WON!');
                    } else {
                        if ($isGameOver === true) {
                            $output->writeln('draw');
                        } else {
                            $output->writeln('You lose :(');
                        }
                    }
                }

            } else {
                $output->writeln('Something going wrong around here');
            }
        }
    });

$console->add($command);

$console->run();

