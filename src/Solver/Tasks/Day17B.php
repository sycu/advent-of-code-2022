<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day17B extends Day17A
{
    private const TARGET_ITERATIONS = 1000000000000;
    private const MIN_HEIGHT_TO_FIND_CYCLE = 4; // Minimum cycle, increase it if you have false positives
    private const ENOUGH_ITERATIONS = 10000; // Increase it, if cycle was not found

    protected function solve(array $lines): string
    {
        $wind = $lines[0];

        [$map, $heights] = $this->generateMap(self::ENOUGH_ITERATIONS, $wind);
        $cycleHeight = $this->findCycleHeight($map);

        $iterationsToCycle = $this->findIterationsToLimit($heights, self::ENOUGH_ITERATIONS - $cycleHeight);
        $iterationsAfterCycle = $this->findIterationsToLimit($heights, self::ENOUGH_ITERATIONS);

        $iterationsPerCycle = $iterationsAfterCycle - $iterationsToCycle;

        $targetIterationsAfterCycle = self::TARGET_ITERATIONS - $iterationsToCycle;
        $cyclesNumber = (int) ($targetIterationsAfterCycle / $iterationsPerCycle);
        $iterationsLeft = $targetIterationsAfterCycle % $iterationsPerCycle;

        $heightWithoutCycles = $heights[$iterationsToCycle + $iterationsLeft];

        return (string) ($heightWithoutCycles + $cyclesNumber * $cycleHeight);
    }

    private function findIterationsToLimit(array $heights, int $limit): int
    {
        foreach ($heights as $iteration => $height) {
            if ($height >= $limit) {
                return $iteration;
            }
        }
    }

    private function findCycleHeight(array $map): int
    {
        for ($i = self::MIN_HEIGHT_TO_FIND_CYCLE; $i < count($map) / 2; $i++) {
            $partA = array_slice($map, -$i, $i);
            $partB = array_slice($map, -2 * $i, $i);

            if ($partA === $partB) {
                return $i;
            }
        }
    }
}
