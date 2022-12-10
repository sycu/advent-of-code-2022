<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day9B extends Day9A
{
    protected function solve(array $lines): string
    {
        return $this->solveForKnots($lines, 10);
    }
}
