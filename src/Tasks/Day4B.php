<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day4B extends Task
{
    protected function solve(array $lines): string
    {
        $sum = 0;
        foreach ($lines as $line) {
            [$A, $B] = explode(',', $line);
            [$p, $q] = explode('-', $A);
            [$m, $n] = explode('-', $B);

            $sum += ($m <= $q) && ($p <= $n);
        }

        return (string) $sum;
    }
}
