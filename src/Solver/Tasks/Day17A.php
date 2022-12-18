<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day17A extends Task
{
    private const MAP_WIDTH = 7;

    protected function solve(array $lines): string
    {
        $wind = $lines[0];
        [$map] = $this->generateMapAndHeights(2022, $wind);

        return (string) count($map);
    }

    protected function generateMapAndHeights(int $iterations, string $wind): array
    {
        $blocks = [
            [
                [1, 1, 1, 1],
            ],
            [
                [0, 1, 0],
                [1, 1, 1],
                [0, 1, 0],
            ],
            [
                [0, 0, 1],
                [0, 0, 1],
                [1, 1, 1],
            ],
            [
                [1],
                [1],
                [1],
                [1],
            ],
            [
                [1, 1],
                [1, 1],
            ],
        ];
        $map = [];
        $heights = [];

        $b = 0;
        $w = 0;
        for ($i = 0; $i < $iterations; $i++) {
            $block = $blocks[$b++ % count($blocks)];
            $heights[$i] = count($map);

            $x = 2;
            $y = count($map) + count($block) + 2;

            $blockPlaced = false;
            while (!$blockPlaced) {
                $dx = $wind[$w++ % strlen($wind)] === '>' ? 1 : -1;

                // Move to the side if possible
                if (!$this->blockHasCollision($map, $block, $x + $dx, $y)) {
                    $x += $dx;
                }

                // Move down if possible, otherwise place block
                if (!$this->blockHasCollision($map, $block, $x, $y - 1)) {
                    $y--;
                } else {
                    $map = $this->placeBlock($map, $block, $x, $y);
                    $blockPlaced = true;
                }
            }
        }

        ksort($map);

        return [$map, $heights];
    }

    private function blockHasCollision(array $map, array $block, int $x, int $y): bool
    {
        for ($q = 0; $q < count($block); $q++) {
            for ($p = 0; $p < count($block[$q]); $p++) {
                // Ground
                if ($y - $q < 0) {
                    return true;
                }

                // Left border
                if ($x + $p < 0) {
                    return true;
                }

                // Right border
                if ($x + $p >= self::MAP_WIDTH) {
                    return true;
                }

                // Collision with other blocks
                if (($map[$y - $q][$x + $p] ?? 0) && ($block[$q][$p] ?? 0)) {
                    return true;
                }
            }
        }

        return false;
    }

    private function placeBlock(array $map, array $block, int $x, int $y): array
    {
        for ($q = 0; $q < count($block); $q++) {
            for ($p = 0; $p < count($block[$q]); $p++) {
                if ($block[$q][$p]) {
                    $map[$y - $q][$x + $p] = $block[$q][$p];
                }
            }
        }

        return $map;
    }
}
