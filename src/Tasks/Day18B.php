<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day18B extends Task
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
        $minX = $minY = $minZ = PHP_INT_MAX;
        $maxX = $maxY = $maxZ = 0;

        // Count sides and get min/max coordinates
        foreach ($lines as $line) {
            [$x, $y, $z] = array_map(fn (string $e) => (int) $e, explode(',', $line));

            $minX = min($minX, $x); $minY = min($minY, $y); $minZ = min($minZ, $z);
            $maxX = max($maxX, $x); $maxY = max($maxY, $y); $maxZ = max($maxZ, $z);

            $sum += 6;
            foreach ($directions as [$dx, $dy, $dz]) {
                if ($grid[$x + $dx][$y + $dy][$z + $dz] ?? false) {
                    $sum -= 2;
                }
            }

            $grid[$x][$y][$z] = true;
        }

        // Expand min/max coordinates to have a boundary box
        $minX--; $minY--; $minZ--;
        $maxX++; $maxY++; $maxZ++;

        // Fill everything outside obsidian (within boundaries), so we are left with unreachable cubes
        $queue = [
            [$minX, $minY, $minZ],
        ];
        while ([$x, $y, $z] = array_shift($queue)) {
            if ($x < $minX || $x > $maxX || $y < $minY || $y > $maxY || $z < $minZ || $z > $maxZ) {
                continue;
            }

            if ($grid[$x][$y][$z] ?? false) {
                continue;
            }

            $grid[$x][$y][$z] = true;

            foreach ($directions as [$dx, $dy, $dz]) {
                $queue[] = [$x + $dx, $y + $dy, $z + $dz];
            }
        }

        // Subtract unreachable sides
        for ($x = $minX + 1; $x < $maxX; $x++) {
            for ($y = $minY + 1; $y < $maxY; $y++) {
                for ($z = $minZ + 1; $z < $maxZ; $z++) {
                    if (($grid[$x][$y][$z] ?? false) === false) {
                        foreach ($directions as [$dx, $dy, $dz]) {
                            $sum -= $grid[$x + $dx][$y + $dy][$z + $dz] ?? false;
                        }
                    }
                }
            }
        }

        return (string) $sum;
    }
}
