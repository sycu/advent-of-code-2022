<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day15B extends Day15A
{
    private const LIMIT = 4000000;
    private const MULTIPLIER = 4000000;

    protected function solve(array $lines): string
    {
        $A = $B = $signals = [];
        foreach ($lines as $line) {
            preg_match('/x=(.+), y=(.+):.*x=(.+), y=(.+)/', $line, $matches);
            [, $sx, $sy, $bx, $by] = array_map(fn (string $e) => (int) $e, $matches);

            $level = $this->distance($sx, $sy, $bx, $by);
            $signals[] = [$sx, $sy, $level];

            $A[] = $sy - $sx + $level + 1;
            $A[] = $sy - $sx - $level - 1;

            $B[] = $sx + $sy + $level + 1;
            $B[] = $sx + $sy - $level - 1;
        }

        foreach ($A as $a) {
            foreach ($B as $b) {
                $x = (int) (($b - $a) / 2);
                $y = (int) (($a + $b) / 2);
                if (0 <= $x && $x <= self::LIMIT && 0 <= $y && $y <= self::LIMIT) {
                    if (!$this->isCoveredBySignals($x, $y, $signals)) {
                        return (string) (self::MULTIPLIER * $x + $y);
                    }
                }
            }
        }
    }

    private function isCoveredBySignals(int $x, int $y, array $signals): bool
    {
        foreach ($signals as [$sx, $sy, $level]) {
            if ($this->distance($x, $y, $sx, $sy) <= $level) {
                return true;
            }
        }

        return false;
    }
}
