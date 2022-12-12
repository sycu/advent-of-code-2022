<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day8B extends Task
{
    protected function solve(array $lines): string
    {
        $grid = array_map(fn (string $line) => str_split($line), $lines);
        $distances = [];

        for ($y = 0; $y < count($grid); $y++) {
            for ($x = 0; $x < count($grid[$y]); $x++) {
                $distances[] = $this->visibleRange($grid, $x, $y, 1, 0)
                    * $this->visibleRange($grid, $x, $y, -1, 0)
                    * $this->visibleRange($grid, $x, $y, 0, 1)
                    * $this->visibleRange($grid, $x, $y, 0, -1);
            }
        }

        return (string) max($distances);
    }

    private function visibleRange(array $grid, int $x, int $y, int $dx, int $dy): int
    {
        $size = $grid[$y][$x];

        $sum = 0;
        while (true) {
            $x += $dx;
            $y += $dy;

            if (!isset($grid[$y][$x])) {
                return $sum;
            }

            $sum++;

            if ($grid[$y][$x] >= $size) {
                return $sum;
            }
        }
    }
}
