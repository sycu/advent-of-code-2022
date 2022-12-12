<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day2A extends Task
{
    protected function solve(array $lines): string
    {
        $score = 0;
        foreach ($lines as $line) {
            [$opponent, $move] = explode(' ', trim($line));

            $pointsMap = [
                'A' => ['X' => 3, 'Y' => 6, 'Z' => 0],
                'B' => ['X' => 0, 'Y' => 3, 'Z' => 6],
                'C' => ['X' => 6, 'Y' => 0, 'Z' => 3],
            ];

            $score += $pointsMap[$opponent][$move];
            $score += ['X' => 1, 'Y' => 2, 'Z' => 3][$move];
        }

        return (string) $score;
    }
}
