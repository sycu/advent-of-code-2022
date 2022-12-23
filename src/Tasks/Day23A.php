<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day23A extends Task
{
    protected function solve(array $lines): string
    {
        $positions = $this->buildPositions($lines);
        for ($i = 0; $i < 10; $i++) {
            [$positions] = $this->changePositions($i, $positions);
        }

        $minX = min(array_column($positions, 0));
        $maxX = max(array_column($positions, 0));
        $minY = min(array_column($positions, 1));
        $maxY = max(array_column($positions, 1));

        $width = $maxX - $minX + 1;
        $height = $maxY - $minY + 1;

        return (string) ($width * $height - count($positions));
    }

    protected function buildPositions(array $lines): array
    {
        $elves = [];
        foreach ($lines as $y => $line) {
            for ($x = 0; $x < strlen($line); $x++) {
                if ($line[$x] === '#') {
                    $elves["{$x}-{$y}"] = [$x, $y];
                }
            }
        }

        return $elves;
    }

    protected function changePositions(int $iteration, array $positions): array
    {
        $directions = [
            [[-1, -1], [0, -1], [1, -1]], // N
            [[-1, 1], [0, 1], [1, 1]], // S
            [[-1, -1], [-1, 0], [-1, 1]], // W
            [[1, -1], [1, 0], [1, 1]], // E
        ];

        $surroundings = [
            [-1, -1],
            [-1, 0],
            [-1, 1],
            [0, -1],
            [0, 1],
            [1, -1],
            [1, 0],
            [1, 1],
        ];

        $swaps = [];
        $collisions = [];
        foreach ($positions as [$x, $y]) {
            $hasNeighbors = false;
            foreach ($surroundings as [$dx, $dy]) {
                [$nx, $ny] = [$x + $dx, $y + $dy];
                $hasNeighbors |= isset($positions["{$nx}-{$ny}"]);
            }

            if (!$hasNeighbors) {
                continue;
            }

            for ($dm = 0; $dm < 4; $dm++) {
                [[$dax, $day], [$dmx, $dmy], [$dcx, $dcy]] = $directions[($iteration + $dm) % 4];
                [$ax, $ay, $mx, $my, $cx, $cy] = [$x + $dax, $y + $day, $x + $dmx, $y + $dmy, $x + $dcx, $y + $dcy];

                if (isset($positions["{$ax}-{$ay}"]) || isset($positions["{$mx}-{$my}"]) || isset($positions["{$cx}-{$cy}"])) {
                    continue;
                }

                if (isset($swaps["{$mx}-{$my}"])) {
                    $collisions[] = [$mx, $my];
                } else {
                    $swaps["{$mx}-{$my}"] = [$x, $y, $mx, $my];
                }

                break;
            }
        }

        foreach ($collisions as [$x, $y]) {
            unset($swaps["{$x}-{$y}"]);
        }

        foreach ($swaps as [$fromX, $fromY, $toX, $toY]) {
            unset($positions["{$fromX}-{$fromY}"]);
            $positions["{$toX}-{$toY}"] = [$toX, $toY];
        }

        return [$positions, count($swaps) > 0];
    }
}
