<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day10A extends Task
{
    protected function solve(array $lines): string
    {
        $queue = [];
        foreach ($lines as $line) {
            $queue[] = 0;
            if (preg_match('/^addx (.+)$/', $line, $matches)) {
                $queue[] = $matches[1];
            }
        }

        $strength = 0;
        $x = 1;
        for ($cycle = 1; $cycle <= 220; $cycle++) {
            if ($cycle % 40 === 20) {
                $strength += $cycle * $x;
            }

            $x += $queue[$cycle - 1];
        }

        return (string) $strength;
    }
}
