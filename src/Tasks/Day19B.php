<?php

declare(strict_types=1);

namespace Tasks;

class Day19B extends Day19A
{
    // All tests take about 60 seconds vs 8 seconds for solution only.
    protected const SOLVER_SKIP_TESTS = false;

    protected function solve(array $lines): string
    {
        $product = 1;
        foreach (array_slice($lines, 0, 3) as $line) {
            preg_match_all('/(\d+)/', $line, $matches);
            [, $Oo, $Co, $Bo, $Bc, $Go, $Gb] = array_map(fn (string $el) => (int) $el, $matches[1]);

            $product *= $this->findMaxGeodes(32, $Oo, $Co, $Bo, $Bc, $Go, $Gb);
        }

        return (string) $product;
    }
}
