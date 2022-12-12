<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day11A extends Task
{
    protected function solve(array $lines): string
    {
        return $this->solveForLimitAndDivisor($lines, 20, 3);
    }

    protected function solveForLimitAndDivisor(array $lines, int $limit, int $divisor): string
    {
        $lines[] = '';
        $swaps = $items = $operations = $divisors = $truthy = $falsy = [];

        foreach (array_chunk($lines, 7) as $chunk) {
            preg_match('/items: (.*)#.*= (.*)#.*by (.*)#.*monkey (.*)#.*monkey (.*)#$/', implode('#', $chunk), $matches);

            $swaps[] = 0;
            $items[] = explode(', ', $matches[1]);
            [, , $operations[], $divisors[], $truthy[], $falsy[]] = $matches;
        }

        while ($limit--) {
            for ($i = 0; $i < count($items); $i++) {
                while ($worry = array_shift($items[$i])) {
                    $worry = (int) ((eval(sprintf('return %s;', strtr($operations[$i], ['old' => $worry]))) % array_product($divisors)) / $divisor);
                    $items[$worry % $divisors[$i] ? $falsy[$i] : $truthy[$i]][] = $worry;
                    $swaps[$i]++;
                }
            }
        }

        rsort($swaps);

        return (string) ($swaps[0] * $swaps[1]);
    }
}
