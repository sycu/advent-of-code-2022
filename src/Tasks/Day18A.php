<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day18A extends Task
{
    protected function solve(array $lines): string
    {
        $directions = [
            [-1, 0, 0],
            [1, 0, 0],
            [0, -1, 0],
            [0, 1, 0],
            [0, 0, -1],
            [0, 0, 1],
        ];

        $sum = 0;
        $grid = [];
        foreach ($lines as $line) {
            [$x, $y, $z] = array_map(fn (string $e) => (int) $e, explode(',', $line));
            $sum += 6;
            foreach ($directions as [$dx, $dy, $dz]) {
                if ($grid[$x + $dx][$y + $dy][$z + $dz] ?? false) {
                    $sum -= 2;
                }
            }

            $grid[$x][$y][$z] = true;
        }

        return (string) $sum;
    }
}
