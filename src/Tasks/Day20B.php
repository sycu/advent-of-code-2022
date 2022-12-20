<?php

declare(strict_types=1);

namespace Tasks;

class Day20B extends Day20A
{
    protected function solve(array $lines): string
    {
        $numbers = array_map(fn (string $el) => $el * 811589153, $lines);
        $mixed = $this->mixNumbers($numbers, 10);

        return (string) $this->sumThreeKs($mixed);
    }
}
