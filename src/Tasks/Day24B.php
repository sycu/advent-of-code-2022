<?php

declare(strict_types=1);

namespace Tasks;

class Day24B extends Day24A
{
    protected function solve(array $lines): string
    {
        [$start, $end, $cols, $rows, $states] = $this->buildMap($lines);

        $a = $this->findFastestPath(0, $start, $end, $cols, $rows, $states);
        $b = $this->findFastestPath($a, $end, $start, $cols, $rows, $states);
        $c = $this->findFastestPath($b, $start, $end, $cols, $rows, $states);

        return (string) $c;
    }
}
