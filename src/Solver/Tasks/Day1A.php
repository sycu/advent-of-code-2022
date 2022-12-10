<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day1A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        return (string) max($this->buildArray($lines));
    }

    protected function buildArray(array $lines): array
    {
        $array = [0];
        $i = 0;

        foreach ($lines as $line) {
            if ($line !== '') {
                $array[$i] += $line;
            } else {
                $array[++$i] = 0;
            }
        }

        return $array;
    }
}
