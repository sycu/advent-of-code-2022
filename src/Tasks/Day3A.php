<?php

declare(strict_types=1);

namespace Tasks;

use Solver\Task;

class Day3A extends Task
{
    protected function solve(array $lines): string
    {
        $sum = 0;
        $chars = '_abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        foreach ($lines as $line) {
            [$a, $b] = str_split($line, strlen($line) / 2);

            for ($i = 1; $i < strlen($chars); $i++) {
                $char = $chars[$i];
                $count = min(substr_count($a, $char), substr_count($b, $char));
                if ($count > 0) {
                    $sum += strpos($chars, $char);
                }
            }
        }

        return (string) $sum;
    }
}
