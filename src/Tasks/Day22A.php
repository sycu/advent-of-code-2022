<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day22A extends Task
{
    protected function solve(array $lines): string
    {
        [$map, $moves, $x, $y] = $this->buildMap($lines);

        $direction = 0;
        $directions = [
            [1, 0],
            [0, 1],
            [-1, 0],
            [0, -1],
        ];
        [$dx, $dy] = $directions[$direction];

        foreach ($moves as [$distance, $rotation]) {
            while ($distance--) {
                [$x, $y, $dx, $dy] = $this->nextPosition($x, $y, $dx, $dy, $map);
            }

            $rx = $rotation === 'L' ? -1 : 1;
            $direction = array_search([$dx, $dy], $directions);
            $direction = ($direction + $rx + 4) % 4;
            [$dx, $dy] = $directions[$direction];
        }

        return (string) (1000 * ($y + 1) + 4 * ($x + 1) + $direction);
    }

    protected function nextPosition(int $x, int $y, int $dx, int $dy, array $map): array
    {
        [$nx, $ny] = [$x, $y];

        do {
            $nx = ($nx + $dx + strlen($map[$y])) % strlen($map[$y]);
            $ny = ($ny + $dy + count($map)) % count($map);
        } while (($map[$ny][$nx] ?? ' ') === ' ');

        if ($map[$ny][$nx] === '.') {
            return [$nx, $ny, $dx, $dy];
        }

        return [$x, $y, $dx, $dy];
    }

    private function buildMap(array $lines): array
    {
        $map = [];
        while ($line = array_shift($lines)) {
            $map[] = $line;
        }

        // Adding insignificant R0L move to the end, so each distance has a rotation right after
        preg_match_all('/(\d+)([LR])/', $lines[0] . 'R0L', $matches);
        $moves = array_map(null, $matches[1], $matches[2]);

        $x = strpos($map[0], '.');
        $y = 0;

        return [$map, $moves, $x, $y];
    }
}
