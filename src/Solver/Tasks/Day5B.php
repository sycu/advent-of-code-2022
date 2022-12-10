<?php

declare(strict_types=1);

namespace Solver\Tasks;

use Solver\AbstractTask;

class Day5B extends AbstractTask
{
    protected function solve(array $lines): string
    {
        $array = array_fill(0, 9, []);
        foreach ($lines as $line) {
            if (preg_match('/^move (\d+) from (\d+) to (\d+)$/', $line, $matches)) {
                [, $n, $f, $t] = $matches;
                $temp = [];
                for ($i = 0; $i < $n; $i++) {
                    $e = array_pop($array[$f - 1]);
                    $temp[] = $e;
                }
                for ($i = 0; $i < $n; $i++) {
                    $e = array_pop($temp);
                    $array[$t - 1][] = $e;
                }
            } elseif ($line !== '' && $line[1] !== '1') {
                foreach (str_split($line, 4) as $i => $part) {
                    $part = trim($part, '[] ');
                    if ($part !== '') {
                        array_unshift($array[$i], $part);
                    }
                }
            }
        }

        $result = '';
        foreach ($array as $a) {
            $result .= array_pop($a);
        }

        return $result;
    }
}
