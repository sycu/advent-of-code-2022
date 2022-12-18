<?php

declare(strict_types=1);

namespace Tasks;

class Day11B extends Day11A
{
    protected function solve(array $lines): string
    {
        return $this->solveForLimitAndDivisor($lines, 10000, 1);
    }
}
