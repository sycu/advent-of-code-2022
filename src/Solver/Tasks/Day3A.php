<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day3A extends AbstractTask
{
    protected function solve(array $lines): string
    {
        $sum = 0;
        $P = '_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        foreach ($lines as $line) {
            [$a, $b] = str_split($line, strlen($line) / 2);

            for ($i = 1; $i < strlen($P); $i++) {
                $char = $P[$i];
                $cnt = min(substr_count($a, $char), substr_count($b, $char));
                if ($cnt > 0) {
                    $sum += strpos($P, $char);
                }
            }
        }

        return (string) $sum;
    }
}
