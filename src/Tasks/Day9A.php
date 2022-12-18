<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day9A extends Task
{
    protected function solve(array $lines): string
    {
        return $this->solveForKnots($lines, 2);
    }

    protected function solveForKnots(array $lines, int $knots): string
    {
        $rope = array_fill(0, $knots, [0, 0]);
        $visited = [];
        $directions = [
            'U' => [0, -1],
            'D' => [0, 1],
            'L' => [-1, 0],
            'R' => [1, 0],
        ];

        foreach ($lines as $line) {
            [$direction, $steps] = explode(' ', $line);

            while ($steps--) {
                $rope[0][0] += $directions[$direction][0];
                $rope[0][1] += $directions[$direction][1];

                for ($j = 0; $j < $knots - 1; $j++) {
                    $dx = $rope[$j][0] - $rope[$j + 1][0];
                    $dy = $rope[$j][1] - $rope[$j + 1][1];

                    if (abs($dx) > 1 || abs($dy) > 1) {
                        $rope[$j + 1][0] += $dx <=> 0;
                        $rope[$j + 1][1] += $dy <=> 0;
                    }
                }

                $visited[$rope[$knots - 1][0] . '-' . $rope[$knots - 1][1]] = true;
            }
        }

        return (string) count($visited);
    }
}
