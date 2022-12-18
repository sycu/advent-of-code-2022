<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day14A extends Task
{
    protected function solve(array $lines): string
    {
        $map = $this->drawPaths($lines, 0, null);

        for ($i = 0; [$px, $py] = $this->nextPlacement($map); $i++) {
            $map[$px][$py] = true;
        }

        return (string) $i;
    }

    protected function drawPaths(array $lines, int $margin, ?int $floorLevel): array
    {
        preg_match_all('/(\d+),(\d+)/', implode(' ', $lines), $matches);
        [, $X, $Y] = $matches;

        $columns = max($X) - min($X) + 2 * $margin;
        $rows = max($Y) + (int) $floorLevel;

        $map = array_fill(min($X) - $margin, $columns + 1, array_fill(0, $rows + 1, false));

        if ($floorLevel !== null) {
            $lines[] = sprintf('%d,%d -> %d,%d', 0, $rows, $columns, $rows);
        }

        foreach ($lines as $line) {
            $points = explode(' -> ', $line);
            [$sx, $sy] = explode(',', array_shift($points));
            $map[$sx][$sy] = true;

            while ($point = array_shift($points)) {
                [$ex, $ey] = explode(',', $point);

                $dx = $ex <=> $sx;
                $dy = $ey <=> $sy;

                while ([$sx, $sy] != [$ex, $ey]) {
                    $map[$sx += $dx][$sy += $dy] = true;
                }
            }
        }

        return $map;
    }

    protected function nextPlacement(array $map): ?array
    {
        $moves = [
            [0, 1],
            [-1, 1],
            [1, 1],
        ];

        $x = 500;
        $y = 0;

        while (isset($map[$x][$y])) {
            foreach ($moves as [$dx, $dy]) {
                if (empty($map[$x + $dx][$y + $dy])) {
                    $x += $dx;
                    $y += $dy;
                    continue 2;
                }
            }

            return [$x, $y];
        }

        return null;
    }
}
