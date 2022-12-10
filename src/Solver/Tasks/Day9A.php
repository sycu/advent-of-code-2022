<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day9A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        return $this->solveForKnots($lines, 2);
    }

    protected function solveForKnots(array $lines, int $k): string
    {
        $P = array_fill(0, $k, [0, 0]);

        $V = [];
        $D = [
            'U' => [0, -1],
            'D' => [0, 1],
            'L' => [-1, 0],
            'R' => [1, 0],
        ];

        foreach ($lines as $line) {
            [$d, $n] = explode(' ', $line);

            for ($i = 0; $i < $n; $i++) {
                $P[0][0] += $D[$d][0];
                $P[0][1] += $D[$d][1];

                for ($j = 0; $j < $k - 1; $j++) {
                    $mx = $P[$j][0] - $P[$j + 1][0];
                    $my = $P[$j][1] - $P[$j + 1][1];

                    if (abs($mx) > 1 || abs($my) > 1) {
                        $P[$j + 1][0] += $mx <=> 0;
                        $P[$j + 1][1] += $my <=> 0;
                    }
                }

                $V[$P[$k - 1][0] . '-' . $P[$k - 1][1]] = true;
            }
        }

        return (string) count($V);
    }
}
