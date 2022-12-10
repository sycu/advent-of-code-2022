<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day7A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        $dirs = $this->buildDirs($lines);
        $dirs = array_filter($dirs, fn ($d) => $d <= 100000);

        return (string) array_sum($dirs);
    }

    /**
     * @param string[] $lines
     * @return array<string, int>
     */
    protected function buildDirs(array $lines): array
    {
        $dirs = [];
        $path = [];
        foreach ($lines as $line) {
            if ($line === '$ cd ..') {
                array_pop($path);
            } elseif (preg_match('/^\$ cd (.+)$/', $line, $M)) {
                $path[] = $M[1];
            } elseif (preg_match('/^(\d+) (.+)$/', $line, $M)) {
                $P = $path;
                while ($P) {
                    $p = implode('-', $P);
                    $dirs[$p] = ($dirs[$p] ?? 0) + (int) $M[1];
                    array_pop($P);
                }
            }
        }

        return $dirs;
    }
}
