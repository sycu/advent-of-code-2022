<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day12A extends Task
{
    protected function solve(array $lines): string
    {
        $queue = $distances = $heights = $end = [];

        for ($y = 0; $y < count($lines); $y++) {
            for ($x = 0; $x < strlen($lines[$y]); $x++) {
                $distances[$x][$y] = PHP_INT_MAX;
                $char = $lines[$y][$x];
                if ($char === 'S') {
                    $char = 'a';
                    $queue[] = [$x, $y];
                    $distances[$x][$y] = 0;
                } elseif ($char === 'E') {
                    $char = 'z';
                    $end = [$x, $y];
                }

                $heights[$x][$y] = ord($char);
            }
        }

        $directions = [
            [0, 1],
            [0, -1],
            [1, 0],
            [-1, 0],
        ];
        while ([$x, $y] = array_shift($queue)) {
            foreach ($directions as [$dx, $dy]) {
                [$nx, $ny] = [$x + $dx, $y + $dy];
                $nh = $heights[$nx][$ny] ?? null;
                if ($nh && ($nh <= $heights[$x][$y] + 1) && ($distances[$nx][$ny] > $distances[$x][$y] + 1)) {
                    $distances[$nx][$ny] = $distances[$x][$y] + 1;
                    $queue[] = [$nx, $ny];
                }
            }
        }

        return (string) $distances[$end[0]][$end[1]];
    }
}
