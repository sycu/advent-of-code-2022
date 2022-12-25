<?php

declare(strict_types=1);

namespace Tasks;

class Day24B extends Day24A
{
    protected function solve(array $lines): string
    {
        [$sx, $sy, $ex, $ey, $cols, $rows, $states] = $this->buildMap($lines);

        $a = $this->findFastestPath(0, $sx, $sy, $ex, $ey, $cols, $rows, $states);
        $b = $this->findFastestPath($a, $ex, $ey, $sx, $sy, $cols, $rows, $states);
        $c = $this->findFastestPath($b, $sx, $sy, $ex, $ey, $cols, $rows, $states);

        return (string) $c;
    }
}
