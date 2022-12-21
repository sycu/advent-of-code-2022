<?php

declare(strict_types=1);

namespace Tasks;

class Day21B extends Day21A
{
    /**
     * As the root equation is always linear, we just need to find where this line (based on two points) crosses y = 0
     */
    protected function solve(array $lines): string
    {
        [$equations, $numbers] = $this->buildEquationsAndNumbers($lines);
        $equations['root'][1] = '-';

        $a = $this->solveForHuman('0', $equations, $numbers);
        $b = $this->solveForHuman('1', $equations, $numbers);

        return (string) (int) bcdiv($a, bcsub($a, $b, self::SCALE), self::SCALE);
    }

    private function solveForHuman(string $human, array $equations, array $numbers): string
    {
        $numbers['humn'] = $human;
        $numbers = $this->calculateNumbers($equations, $numbers);

        return $numbers['root'];
    }
}
