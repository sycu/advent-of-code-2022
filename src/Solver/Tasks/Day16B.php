<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day16B extends Day16A
{
    /**
     * Generate all reachable paths of any length greater than 0, then iterate through all pairs of paths and find those
     * which don't intersect. Most profitable pair is the solution.
     */
    protected function solve(array $lines): string
    {
        [$distances, $rates] = $this->buildDistancesAndRates($lines);

        $paths = [];
        for ($length = 1; $length < count($rates); $length++) {
            $paths = array_merge($paths, $this->generatePathsOfLength($length, 'AA', 26, 0, $rates, $distances, []));
        }

        arsort($paths);

        $sums = [0];
        foreach ($paths as $a => $profitA) {
            foreach ($paths as $b => $profitB) {
                $A = explode(' ', $a);
                $B = explode(' ', $b);

                $sum = $profitA + $profitB;

                if ($sum < max($sums)) {
                    break;
                }

                if (array_intersect($A, $B) === []) {
                    $sums[] = $sum;
                }
            }
        }

        return (string) max($sums);
    }

    private function generatePathsOfLength(int $length, string $position, int $limit, int $profit, array $rates, array $distances, array $path): array
    {
        if (!$rates || $length < 1) {
            return [implode(' ', $path) => $profit];
        }

        $paths = [];
        foreach ($rates as $valve => $rate) {
            $newRates = $rates;
            unset($newRates[$valve]);

            $cost = $distances[$position][$valve] + 1;
            if ($cost < $limit) {
                $limitLeft = $limit - $cost;
                $newProfit = $profit + ($rate * $limitLeft);

                $paths = array_merge($paths, $this->generatePathsOfLength($length - 1, $valve, $limitLeft, $newProfit, $newRates, $distances, [...$path, $valve]));
            }
        }

        return $paths;
    }
}
