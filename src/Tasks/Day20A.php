<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day20A extends Task
{
    protected function solve(array $lines): string
    {
        $numbers = array_map(fn (string $el) => (int) $el, $lines);
        $mixed = $this->mixNumbers($numbers, 1);

        return (string) $this->sumThreeKs($mixed);
    }

    protected function mixNumbers(array $numbers, int $iterations): array
    {
        $positions = array_combine(array_keys($numbers), array_keys($numbers));
        $count = count($numbers);

        $mixed = $numbers;

        while ($iterations--) {
            foreach ($numbers as $index => $number) {
                $position = array_search($index, $positions);
                $newPosition = ($position + $number) % ($count - 1);
                if ($newPosition === 0) {
                    $newPosition = $count;
                }

                array_splice($mixed, $position, 1);
                array_splice($mixed, $newPosition, 0, $number);

                array_splice($positions, $position, 1);
                array_splice($positions, $newPosition, 0, $index);
            }
        }

        return $mixed;
    }

    protected function sumThreeKs(array $numbers): int
    {
        $zeroPosition = array_search(0, $numbers);
        $count = count($numbers);

        $a = $numbers[($zeroPosition + 1000) % $count];
        $b = $numbers[($zeroPosition + 2000) % $count];
        $c = $numbers[($zeroPosition + 3000) % $count];

        return $a + $b + $c;
    }
}
