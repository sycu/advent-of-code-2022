<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day2A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        $score = 0;
        foreach ($lines as $line) {
            [$p, $q] = explode(' ', trim($line));

            $P = [
                'A' => ['X' => 3, 'Y' => 6, 'Z' => 0],
                'B' => ['X' => 0, 'Y' => 3, 'Z' => 6],
                'C' => ['X' => 6, 'Y' => 0, 'Z' => 3],
            ];

            $score += $P[$p][$q];
            $score += ['X' => 1, 'Y' => 2, 'Z' => 3][$q];
        }

        return (string) $score;
    }
}
