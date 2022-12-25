<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day25 extends Task
{
    protected function solve(array $lines): string
    {
        $snafuDigits = '=-012';

        $sum = 0;
        foreach ($lines as $line) {
            for ($i = 0; $i < strlen($line); $i++) {
                $digit = $line[strlen($line) - $i - 1];
                $digitValue = strpos($snafuDigits, $digit) - 2;
                $sum += $digitValue * 5 ** $i;
            }
        }

        $snafu = '';
        while ($sum > 0) {
            $snafuValue = ($sum + 2) % 5;
            $snafu = $snafuDigits[$snafuValue] . $snafu;
            $sum = (int) (($sum - $snafuValue + 2) / 5);
        }

        return $snafu ?: '0';
    }
}
