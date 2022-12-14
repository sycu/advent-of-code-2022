<?php

declare(strict_types=1);

namespace Tasks;

class Day7B extends Day7A
{
    protected function solve(array $lines): string
    {
        $dirs = $this->buildDirs($lines);
        $dirs = array_filter($dirs, fn (int $dir) => $dir >= ($dirs['/'] - 40000000));

        return (string) min($dirs);
    }
}
