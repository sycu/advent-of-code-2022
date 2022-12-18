<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day2B extends Task
{
    protected function solve(array $lines): string
    {
        $score = 0;
        foreach ($lines as $line) {
            [$opponent, $result] = explode(' ', trim($line));

            $pointsMap = [
                'A' => ['X' => 3, 'Y' => 6, 'Z' => 0],
                'B' => ['X' => 0, 'Y' => 3, 'Z' => 6],
                'C' => ['X' => 6, 'Y' => 0, 'Z' => 3],
            ];

            $resultsMap = [
                'A' => ['X' => 'Z', 'Y' => 'X', 'Z' => 'Y'],
                'B' => ['X' => 'X', 'Y' => 'Y', 'Z' => 'Z'],
                'C' => ['X' => 'Y', 'Y' => 'Z', 'Z' => 'X'],
            ];

            $move = $resultsMap[$opponent][$result];

            $score += $pointsMap[$opponent][$move];
            $score += ['X' => 1, 'Y' => 2, 'Z' => 3][$move];
        }

        return (string) $score;
    }
}
