<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day3B extends AbstractTask
{
    protected function solve(array $lines): string
    {
        $sum = 0;
        $chars = '_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $groups = array_chunk($lines, 3);
        foreach ($groups as [$A, $B, $C]) {
            for ($i = 1; $i < strlen($chars); $i++) {
                $char = $chars[$i];
                if (str_contains($A, $char) && str_contains($B, $char) && str_contains($C, $char)) {
                    $sum += strpos($chars, $char);
                }
            }
        }

        return (string) $sum;
    }
}
