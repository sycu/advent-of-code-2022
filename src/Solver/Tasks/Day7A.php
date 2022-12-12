<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\Task;

class Day7A extends Task
{
    protected function solve(array $lines): string
    {
        $dirs = $this->buildDirs($lines);
        $dirs = array_filter($dirs, fn (int $dir) => $dir <= 100000);

        return (string) array_sum($dirs);
    }

    protected function buildDirs(array $lines): array
    {
        $dirs = [];
        $paths = [];
        foreach ($lines as $line) {
            if ($line === '$ cd ..') {
                array_pop($paths);
            } elseif (preg_match('/^\$ cd (.+)$/', $line, $matches)) {
                $paths[] = $matches[1];
            } elseif (preg_match('/^(\d+) (.+)$/', $line, $matches)) {
                $P = $paths;
                while ($P) {
                    $slug = implode('-', $P);
                    $dirs[$slug] = ($dirs[$slug] ?? 0) + (int) $matches[1];
                    array_pop($P);
                }
            }
        }

        return $dirs;
    }
}
