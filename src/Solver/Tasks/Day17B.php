<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day17B extends Day17A
{
    private const TARGET_ITERATIONS = 1000000000000;
    private const ITERATIONS = 10000; // Increase it if cycle was not found
    private const MINIMUM_CYCLE = 4; // Increase it if you have false positives

    protected function solve(array $lines): string
    {
        $wind = $lines[0];

        // Generate map big enough to have cycles
        [$map, $heights] = $this->generateMapAndHeights(self::ITERATIONS, $wind);

        // Find cycle height (in blocks) and iteration number before and after a cycle
        $cycleHeight = $this->findCycleHeight($map);
        $iterationsBeforeCycle = $this->findIterationsToLimit($heights, self::ITERATIONS - $cycleHeight);
        $iterationsAfterCycle = $this->findIterationsToLimit($heights, self::ITERATIONS);
        $iterationsPerCycle = $iterationsAfterCycle - $iterationsBeforeCycle;

        // Find how many cycles are in our target tower
        $targetIterationsAfterCycle = self::TARGET_ITERATIONS - $iterationsBeforeCycle;
        $cyclesNumber = (int) ($targetIterationsAfterCycle / $iterationsPerCycle);

        // Find how many iterations will be left after all the cycles
        $iterationsLeft = $targetIterationsAfterCycle % $iterationsPerCycle;

        // Calculate tower height without cycles
        $heightWithoutCycles = $heights[$iterationsBeforeCycle + $iterationsLeft];

        // Solution is height without cycles + height of all the cycles
        $height = $heightWithoutCycles + $cyclesNumber * $cycleHeight;

        return (string) $height;
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
        for ($i = self::MINIMUM_CYCLE; $i < count($map) / 2; $i++) {
            $partA = array_slice($map, -$i, $i);
            $partB = array_slice($map, -2 * $i, $i);

            if ($partA === $partB) {
                return $i;
            }
        }
    }
}
