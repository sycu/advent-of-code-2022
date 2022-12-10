<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day8A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        $grid = array_map(fn (string $line) => str_split($line), $lines);

        $sum = 0;
        for ($y = 0; $y < count($grid); $y++) {
            for ($x = 0; $x < count($grid[$y]); $x++) {
                $sum += $this->isVisible($grid, $x, $y, 1, 0)
                    || $this->isVisible($grid, $x, $y, -1, 0)
                    || $this->isVisible($grid, $x, $y, 0, 1)
                    || $this->isVisible($grid, $x, $y, 0, -1);
            }
        }

        return (string) $sum;
    }

    private function isVisible(array $A, int $x, int $y, int $dx, int $dy): bool
    {
        $size = $A[$y][$x];

        while (true) {
            $x += $dx;
            $y += $dy;

            if (!isset($A[$y][$x])) {
                return true;
            }

            if ($A[$y][$x] >= $size) {
                return false;
            }
        }
    }
}
