<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day4A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        $sum = 0;
        foreach ($lines as $line) {
            [$A, $B] = explode(',', $line);
            [$p, $q] = explode('-', $A);
            [$m, $n] = explode('-', $B);

            $sum += ($p <= $m && $n <= $q) || ($m <= $p && $q <= $n);
        }

        return (string) $sum;
    }
}
