<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day1B extends Day1A
{
    protected function solve(array $lines): string
    {
        $array = $this->buildArray($lines);
        rsort($array);

        return (string) ($array[0] + $array[1] + $array[2]);
    }
}
