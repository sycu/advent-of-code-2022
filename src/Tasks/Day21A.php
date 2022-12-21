<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day21A extends Task
{
    protected const SCALE = 20;

    protected function solve(array $lines): string
    {
        [$equations, $numbers] = $this->buildEquationsAndNumbers($lines);
        $numbers = $this->calculateNumbers($equations, $numbers);

        return (string) (int) $numbers['root'];
    }

    protected function buildEquationsAndNumbers(array $lines): array
    {
        $equations = [];
        $numbers = [];
        foreach ($lines as $line) {
            preg_match('/(.+): (.+)/', $line, $lineMatches);
            [, $variable, $expression] = $lineMatches;

            if (preg_match('/(.+) (.+) (.+)/', $expression, $expressionMatches)) {
                [, $left, $operator, $right] = $expressionMatches;
                $equations[$variable] = [$left, $operator, $right];
            } else {
                $numbers[$variable] = $expression;
            }
        }

        return [$equations, $numbers];
    }

    protected function calculateNumbers(array $equations, array $numbers): array
    {
        while ($equations) {
            foreach ($equations as $variable => [$left, $operator, $right]) {
                if (!isset($numbers[$left], $numbers[$right])) {
                    continue;
                }

                $a = $numbers[$left];
                $b = $numbers[$right];

                $result = match ($operator) {
                    '+' => bcadd($a, $b, self::SCALE),
                    '-' => bcsub($a, $b, self::SCALE),
                    '*' => bcmul($a, $b, self::SCALE),
                    '/' => bcdiv($a, $b, self::SCALE),
                };

                $numbers[$variable] = $result;
                unset($equations[$variable]);
            }
        }

        return $numbers;
    }
}
