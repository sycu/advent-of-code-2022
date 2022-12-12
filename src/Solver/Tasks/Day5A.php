<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day5A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        $stacks = array_fill(0, 9, []);
        foreach ($lines as $line) {
            if (preg_match('/^move (\d+) from (\d+) to (\d+)$/', $line, $matches)) {
                [, $number, $from, $to] = $matches;
                for ($i = 0; $i < $number; $i++) {
                    $stacks[$to - 1][] = array_pop($stacks[$from - 1]);
                }
            } elseif ($line !== '' && $line[1] !== '1') {
                foreach (str_split($line, 4) as $i => $part) {
                    $part = trim($part, '[] ');
                    if ($part !== '') {
                        array_unshift($stacks[$i], $part);
                    }
                }
            }
        }

        $result = '';
        foreach ($stacks as $stack) {
            $result .= array_pop($stack);
        }

        return $result;
    }
}
