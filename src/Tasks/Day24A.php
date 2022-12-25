<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;
use SplPriorityQueue;

class Day24A extends Task
{
    protected function solve(array $lines): string
    {
        [$sx, $sy, $ex, $ey, $cols, $rows, $states] = $this->buildMap($lines);

        return (string) $this->findFastestPath(0, $sx, $sy, $ex, $ey, $cols, $rows, $states);
    }

    protected function buildMap(array $lines): array
    {
        $rows = count($lines);
        $cols = strlen($lines[0]);

        [$sx, $sy] = [strpos($lines[0], '.'), 0];
        [$ex, $ey] = [strpos($lines[$rows - 1], '.'), $rows - 1];

        $directions = [
            '<' => [-1, 0],
            '>' => [1, 0],
            '^' => [0, -1],
            'v' => [0, 1],
        ];

        $blizzards = [];
        foreach ($lines as $y => $line) {
            for ($x = 0; $x < strlen($line); $x++) {
                $char = $line[$x];
                if (in_array($char, array_keys($directions))) {
                    $blizzards["{$x} {$y}"][] = [$x, $y, ...$directions[$char]];
                }
            }
        }

        $states = [];
        $lcm = ($cols - 2) * ($rows - 2) / $this->gcd($cols - 2, $rows - 2);
        for ($i = 0; $i < $lcm; $i++) {
            $states[] = $blizzards;
            $blizzards = $this->moveBlizzards($blizzards, $cols, $rows);
        }

        return [$sx, $sy, $ex, $ey, $cols, $rows, $states];
    }

    protected function findFastestPath(int $startTime, int $sx, int $sy, int $ex, int $ey, int $cols, int $rows, array $states): int
    {
        $visited = [];
        $directions = [
            [-1, 0],
            [1, 0],
            [0, -1],
            [0, 1],
            [0, 0],
        ];

        $queue = new SplPriorityQueue();
        $queue->insert([$startTime, $sx, $sy], -$startTime);

        while (!$queue->isEmpty()) {
            [$time, $x, $y] = $queue->current();
            $queue->next();

            $key = "{$time} {$x} {$y}";
            if (isset($visited[$key])) {
                continue;
            }

            $visited[$key] = true;

            if ([$x, $y] === [$ex, $ey]) {
                return $time;
            }

            $nextState = $states[($time + 1) % count($states)];
            foreach ($directions as [$dx, $dy]) {
                if ($this->canMove($x + $dx, $y + $dy, $sx, $sy, $ex, $ey, $cols, $rows, $nextState)) {
                    $queue->insert([$time + 1, $x + $dx, $y + $dy], -($time + 1));
                }
            }
        }
    }

    private function canMove(int $x, int $y, int $sx, int $sy, int $ex, int $ey, int $cols, int $rows, array $blizzards): bool
    {
        if ([$x, $y] === [$sx, $sy] || [$x, $y] === [$ex, $ey]) {
            return true;
        }

        if ($x < 1 || $x > $cols - 2 || $y < 1 || $y > $rows - 2) {
            return false;
        }

        return !isset($blizzards["{$x} {$y}"]);
    }

    private function gcd(int $a, int $b): int
    {
        while ($b !== 0) {
            if ($a > $b) {
                $a -= $b;
            } else {
                $b -= $a;
            }
        }

        return $a;
    }

    private function moveBlizzards(array $blizzards, int $cols, int $rows): array
    {
        $newBlizzards = [];
        foreach ($blizzards as $blizzardsAtPosition) {
            foreach ($blizzardsAtPosition as [$x, $y, $dx, $dy]) {
                $x = ($x + $dx + $cols - 3) % ($cols - 2) + 1;
                $y = ($y + $dy + $rows - 3) % ($rows - 2) + 1;

                $newBlizzards["{$x} {$y}"][] = [$x, $y, $dx, $dy];
            }
        }

        return $newBlizzards;
    }
}
