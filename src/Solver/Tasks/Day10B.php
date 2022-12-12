<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day10B extends AbstractTask
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

        $image = '';
        $x = 1;
        for ($cycle = 0; $cycle < 240; $cycle++) {
            if ($cycle % 40 === 0) {
                $image .= PHP_EOL;
            }

            $image .= in_array($cycle % 40, [$x - 1, $x, $x + 1]) ? '#' : '.';
            $x += $queue[$cycle];
        }

        return ltrim($image);
    }
}
