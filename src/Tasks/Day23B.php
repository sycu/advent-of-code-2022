<?php

declare(strict_types=1);

namespace Tasks;

class Day23B extends Day23A
{
    protected function solve(array $lines): string
    {
        $positions = $this->buildPositions($lines);
        $changed = true;
        for ($i = 0; $changed; $i++) {
            [$positions, $changed] = $this->changePositions($i, $positions);
        }

        return (string) $i;
    }
}
