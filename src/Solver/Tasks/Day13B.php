<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day13B extends Day13A
{
    protected function solve(array $lines): string
    {
        $A = ['[[2]]', '[[6]]', ...array_filter($lines)];
        usort($A, fn (string $a, string $b) => $this->compare(eval("return {$a};"), eval("return {$b};")));

        $p = array_search('[[2]]', $A);
        $q = array_search('[[6]]', $A);

        return (string) (($p + 1) * ($q + 1));
    }
}
