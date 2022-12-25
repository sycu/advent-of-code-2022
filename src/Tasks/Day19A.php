<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;
use SplQueue;

class Day19A extends Task
{
    /**
     * Resources: o - Ore, c - Clay, b - oBsidian, g - Geode
     *
     * Variables:
     *   x - amount of resource x
     *   X - number of robots x
     *   Xy - cost of resource y to produce robot x
     */
    protected function solve(array $lines): string
    {
        $sum = 0;
        foreach ($lines as $line) {
            preg_match_all('/(\d+)/', $line, $matches);
            [$i, $Oo, $Co, $Bo, $Bc, $Go, $Gb] = array_map(fn (string $el) => (int) $el, $matches[1]);

            $sum += $i * $this->findMaxGeodes(24, $Oo, $Co, $Bo, $Bc, $Go, $Gb);
        }

        return (string) $sum;
    }

    protected function findMaxGeodes(int $limit, int $Oo, int $Co, int $Bo, int $Bc, int $Go, int $Gb): int
    {
        $queue = new SplQueue();
        $queue->push([$limit, 1, 0, 0, 0, 0, 0, 0, 0]);

        $processed = [];
        $maxGeodes = 0;

        $maxOreCost = max($Oo, $Co, $Bo, $Go);

        while (!$queue->isEmpty()) {
            [$limit, $O, $C, $B, $G, $o, $c, $b, $g] = $queue->pop();

            if ($limit < 1) {
                continue;
            }

            // Reduce number of branches by removing excessive resources, which we can't even spend
            $o = min($o, $maxOreCost + ($maxOreCost - $O) * ($limit - 1));
            $c = min($c, $Bc + ($Bc - $C) * ($limit - 1));
            $b = min($b, $Gb + ($Gb - $B) * ($limit - 1));

            $hash = implode('-', [$limit, $O, $C, $B, $G, $o, $c, $b, $g]);
            if (isset($processed[$hash])) {
                continue;
            }

            $processed[$hash] = true;

            // Geode branch - Buy as much as possible
            if ($B > 0) {
                $timeO = ceil(($Go - $o) / $O);
                $timeB = ceil(($Gb - $b) / $B);
                $time = (int) max($timeO, $timeB, 0) + 1;

                $queue->push([$limit - $time, $O, $C, $B, $G + 1, $o + $time * $O - $Go, $c + $time * $C, $b + $time * $B - $Gb, $g + $time * $G]);
            }

            // Obsidian branch - We should buy obsidian robots up to geode obsidian cost, we don't need more
            if ($C > 0 && $B < $Gb) {
                $timeO = ceil(($Bo - $o) / $O);
                $timeC = ceil(($Bc - $c) / $C);
                $time = (int) max($timeO, $timeC, 0) + 1;

                $queue->push([$limit - $time, $O, $C, $B + 1, $G, $o + $time * $O - $Bo, $c + $time * $C - $Bc, $b + $time * $B, $g + $time * $G]);
            }

            // Clay branch - We should buy clay robots up to obsidian clay cost, we don't need more
            if ($C < $Bc) {
                $timeO = ceil(($Co - $o) / $O);
                $time = (int) max($timeO, 0) + 1;

                $queue->push([$limit - $time, $O, $C + 1, $B, $G, $o + $time * $O - $Co, $c + $time * $C, $b + $time * $B, $g + $time * $G]);
            }

            // Ore branch - We should buy ore robots up to max ore cost, we can't spend more in a turn
            if ($O < $maxOreCost) {
                $timeO = ceil(($Oo - $o) / $O);
                $time = (int) max($timeO, 0) + 1;

                $queue->push([$limit - $time, $O + 1, $C, $B, $G, $o + $time * $O - $Oo, $c + $time * $C, $b + $time * $B, $g + $time * $G]);
            }

            // Noop branch - Just collecting resources for the rest of the time
            $maxGeodes = max($maxGeodes, $g + $limit * $G);
        }

        return $maxGeodes;
    }
}
