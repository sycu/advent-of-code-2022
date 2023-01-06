<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day15A extends Task
{
    private const ROW = 2000000;

    /**
     * Mark signal coverage for each sensor, but only on the Y level that we are interested in.
     */
    protected function solve(array $lines): string
    {
        $row = [];
        foreach ($lines as $line) {
            preg_match('/x=(.+), y=(.+):.*x=(.+), y=(.+)/', $line, $matches);
            [, $sx, $sy, $bx, $by] = array_map(fn (string $e) => (int) $e, $matches);

            if ($by === self::ROW) {
                $row[$bx] = 0;
            }

            $row = $this->markSignalCoverage($row, $sx, $sy, $this->distance($sx, $sy, $bx, $by));
        }

        return (string) array_sum($row);
    }

    protected function distance(int $x1, int $y1, int $x2, int $y2): int
    {
        return (int) (abs($x1 - $x2) + abs($y1 - $y2));
    }

    private function markSignalCoverage(array $row, int $sx, int $sy, int $level): array
    {
        $dy = abs(self::ROW - $sy);
        for ($x = $sx - $level + $dy; $x <= $sx + $level - $dy; $x++) {
            $row[$x] ??= 1;
        }

        return $row;
    }
}
