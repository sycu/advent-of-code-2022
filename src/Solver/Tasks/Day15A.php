<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day15A extends Task
{
    private const ROW = 2000000;

    /**
     * Mark signal coverage for each sensor, but only on the Y level that we are interested in.
     */
    protected function solve(array $lines): string
    {
        $map = [];
        foreach ($lines as $line) {
            preg_match('/x=(.+), y=(.+):.*x=(.+), y=(.+)/', $line, $matches);
            [, $sx, $sy, $bx, $by] = array_map(fn (string $e) => (int) $e, $matches);

            $map[$sx][$sy] = 0;
            $map[$bx][$by] = 0;

            $map = $this->markSignalCoverage($map, $sx, $sy, $this->distance($sx, $sy, $bx, $by));
        }

        return (string) array_sum(array_column($map, self::ROW));
    }

    protected function distance(int $x1, int $y1, int $x2, int $y2): int
    {
        return (int) (abs($x1 - $x2) + abs($y1 - $y2));
    }

    private function markSignalCoverage(array $map, int $sx, int $sy, int $level): array
    {
        $dy = abs(self::ROW - $sy);
        for ($x = $sx - $level + $dy; $x <= $sx + $level - $dy; $x++) {
            $map[$x][self::ROW] ??= 1;
        }

        return $map;
    }
}
