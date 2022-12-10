<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day6B extends Day6A
{
    protected function solve(array $lines): string
    {
        return $this->solveForLength($lines, 14);
    }
}
