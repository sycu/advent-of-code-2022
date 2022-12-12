<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day6A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        return $this->solveForLength($lines, 4);
    }

    protected function solveForLength(array $lines, int $length): string
    {
        foreach ($lines as $line) {
            for ($i = 0; $i < strlen($line); $i++) {
                $part = substr($line, $i, $length);
                $charCounts = count_chars($part, 1);

                if (count($charCounts) === $length) {
                    return (string) ($i + $length);
                }
            }
        }
    }
}
