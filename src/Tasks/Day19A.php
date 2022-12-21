<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

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
        // Using array pointer with unset instead of array_shift/array_pop because it is significantly faster for
        // massive amount of inserts and removals (4 seconds instead of couple of minutes). SplQueue is quite fast as
        // well - just 1 second slower.
        $i = 0;
        $queue = [
            [$limit, 1, 0, 0, 0, 0, 0, 0, 0],
        ];

        $processed = [];
        $maxGeodes = 0;

        $maxOreCost = max($Oo, $Co, $Bo, $Go);

        while (isset($queue[$i])) {
            [$limit, $O, $C, $B, $G, $o, $c, $b, $g] = $queue[$i++];

            // We can cut an extra 0.5 second by not unsetting items at the cost of high memory usage
            unset($queue[$i - 1]);

            $limit--;

            // Reduce number of branches by removing excessive resources, which we can't even spend
            $o = min($o, $maxOreCost + ($maxOreCost - $O) * $limit);
            $c = min($c, $Bc + ($Bc - $C) * $limit);
            $b = min($b, $Gb + ($Gb - $B) * $limit);

            $hash = implode('-', [$limit, $O, $C, $B, $G, $o, $c, $b, $g]);
            if (isset($processed[$hash])) {
                continue;
            }

            $processed[$hash] = true;
            $maxGeodes = max($maxGeodes, $g + $G);

            if ($limit === 0) {
                continue;
            }

            // Geode branch - Buy as much as possible
            if ($o >= $Go && $b >= $Gb) {
                $queue[] = [$limit, $O, $C, $B, $G + 1, $o + $O - $Go, $c + $C, $b + $B - $Gb, $g + $G];
            }

            // Obsidian branch - We should buy obsidian robots up to geode obsidian cost, we don't need more
            if ($o >= $Bo && $c >= $Bc && $B < $Gb) {
                $queue[] = [$limit, $O, $C, $B + 1, $G, $o + $O - $Bo, $c + $C - $Bc, $b + $B, $g + $G];
            }

            // Clay branch - We should buy clay robots up to obsidian clay cost, we don't need more
            if ($o >= $Co && $C < $Bc) {
                $queue[] = [$limit, $O, $C + 1, $B, $G, $o + $O - $Co, $c + $C, $b + $B, $g + $G];
            }

            // Ore branch - We should buy ore robots up to max ore cost, we can't spend more in a turn
            if ($o >= $Oo && $O < $maxOreCost) {
                $queue[] = [$limit, $O + 1, $C, $B, $G, $o + $O - $Oo, $c + $C, $b + $B, $g + $G];
            }

            // Noop branch - No purchase at this time, just collecting resources
            $queue[] = [$limit, $O, $C, $B, $G, $o + $O, $c + $C, $b + $B, $g + $G];
        }

        return $maxGeodes;
    }
}
