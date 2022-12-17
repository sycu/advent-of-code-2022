<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day13A extends Task
{
    protected function solve(array $lines): string
    {
        $sum = 0;
        foreach (array_chunk($lines, 3) as $i => [$a, $b]) {
            $A = eval("return {$a};");
            $B = eval("return {$b};");

            if ($this->compare($A, $B) === -1) {
                $sum += $i + 1;
            }
        }

        return (string) $sum;
    }

    protected function compare(array|int $A, array|int $B): int
    {
        if ($A === $B) {
            return 0;
        }

        if (is_int($A) && is_int($B)) {
            return $A <=> $B;
        }

        if (is_int($A)) {
            $A = [$A];
        }

        if (is_int($B)) {
            $B = [$B];
        }

        foreach (array_map(null, $A, $B) as [$a, $b]) {
            $result = $this->compare($a ?? -1, $b ?? -1);
            if ($result !== 0) {
                return $result;
            }
        }

        return 0;
    }
}
