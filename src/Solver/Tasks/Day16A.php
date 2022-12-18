<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day16A extends Task
{
    /**
     * Generate all reachable paths and return the most profitable one.
     * We use only those, which have rate > 0 and use rest as a travel cost.
     */
    protected function solve(array $lines): string
    {
        [$distances, $rates] = $this->buildDistancesAndRates($lines);

        // Generate all reachable paths and return the best one.
        return (string) $this->maxProfit('AA', 30, $rates, $distances);
    }

    protected function buildDistancesAndRates(array $lines): array
    {
        $rates = [];
        $graph = [];
        foreach ($lines as $line) {
            preg_match('/^Valve (.+) has flow rate=(.+); tunnels? leads? to valves? (.+)$/', $line, $matches);
            [, $valve, $rate, $pathsString] = $matches;

            $rates[$valve] = (int) $rate;

            $graph[$valve] = [];
            foreach (explode(', ', $pathsString) as $path) {
                $graph[$valve][] = $path;
            }
        }

        $distances =  [];
        foreach ($rates as $valve => $rate) {
            $distances = $this->calculateDistances($valve, $valve, 0, $graph, $distances);
        }

        return [$distances, array_filter($rates)];
    }

    protected function calculateDistances(string $from, string $current, int $depth, array $graph, array $distances): array
    {
        foreach ($graph[$current] as $path) {
            if ($from === $path) {
                continue;
            }

            $distance = $distances[$from][$path] ?? PHP_INT_MAX;
            if ($depth + 1 < $distance) {
                $distances[$from][$path] = $depth + 1;

                $distances = $this->calculateDistances($from, $path, $depth + 1, $graph, $distances);
            }
        }

        return $distances;
    }

    private function maxProfit(string $position, int $limit, array $rates, array $distances): int
    {
        $profits = [0];
        foreach ($rates as $valve => $rate) {
            $newRates = $rates;
            unset($newRates[$valve]);

            $cost = $distances[$position][$valve] + 1;

            if ($cost < $limit) {
                $profits[] = ($rate * ($limit - $cost)) + $this->maxProfit($valve, $limit - $cost, $newRates, $distances);
            }
        }

        return max($profits);
    }
}
