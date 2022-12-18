<?php

declare(strict_types=1);

namespace Solver\Tasks;

class Day14B extends Day14A
{
    private const MARGIN = 500; // Increase it, if you can't reach the top

    protected function solve(array $lines): string
    {
        $map = $this->drawPaths($lines, self::MARGIN, 2);

        $py = null;
        for ($i = 0; $py !== 0; $i++) {
            [$px, $py] = $this->nextPlacement($map);

            $map[$px][$py] = true;
        }

        return (string) $i;
    }
}
