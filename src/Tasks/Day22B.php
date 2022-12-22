<?php

declare(strict_types=1);

namespace Tasks;

class Day22B extends Day22A
{
    protected function nextPosition(int $x, int $y, int $dx, int $dy, array $map): array
    {
        [$nx, $ny, $ndx, $ndy] = [$x, $y, $dx, $dy];

        do {
            $nx += $ndx;
            $ny += $ndy;

            if (50 <= $nx && $nx < 100 && $ny < 0 && $ndy === -1) {
                [$nx, $ny, $ndx, $ndy] = [0, $nx + 100, 1, 0];
            } elseif ($nx < 0 && 150 <= $ny && $ny < 200 && $ndx === -1) {
                [$nx, $ny, $ndx, $ndy] = [$ny - 100, 0, 0, 1];
            } elseif (100 <= $nx && $nx < 150 && $ny < 0 && $ndy === -1) {
                [$nx, $ny, $ndx, $ndy] = [$nx - 100, 199, $ndx, $ndy];
            } elseif (0 <= $nx && $nx < 50 && $ny >= 200 && $ndy === 1) {
                [$nx, $ny, $ndx, $ndy] = [$nx + 100, 0, $ndx, $ndy];
            } elseif ($nx >= 150 && 0 <= $ny && $ny < 50 && $ndx === 1) {
                [$nx, $ny, $ndx, $ndy] = [99, 149 - $ny, -1, $ndy];
            } elseif ($nx === 100 && 100 <= $ny && $ny < 150 && $ndx === 1) {
                [$nx, $ny, $ndx, $ndy] = [149, 149 - $ny, -1, $ndy];
            } elseif (100 <= $nx && $nx < 150 && $ny === 50 && $ndy === 1) {
                [$nx, $ny, $ndx, $ndy] = [99, $nx - 50, -1, 0];
            } elseif ($nx === 100 && 50 <= $ny && $ny < 100 && $ndx === 1) {
                [$nx, $ny, $ndx, $ndy] = [$ny + 50, 49, 0, -1];
            } elseif (50 <= $nx && $nx < 100 && $ny === 150 && $ndy === 1) {
                [$nx, $ny, $ndx, $ndy] = [49, $nx + 100, -1, 0];
            } elseif ($nx === 50 && 150 <= $ny && $ny < 200 && $ndx === 1) {
                [$nx, $ny, $ndx, $ndy] = [$ny - 100, 149, 0, -1];
            } elseif (0 <= $nx && $nx < 50 && $ny === 99 && $ndy === -1) {
                [$nx, $ny, $ndx, $ndy] = [50, $nx + 50, 1, 0];
            } elseif ($nx === 49 && 50 <= $ny && $ny < 100 && $ndx === -1) {
                [$nx, $ny, $ndx, $ndy] = [$ny - 50, 100, 0, 1];
            } elseif ($nx === 49 && 0 <= $ny && $ny < 50 && $ndx === -1) {
                [$nx, $ny, $ndx, $ndy] = [0, 149 - $ny, 1, $ndy];
            } elseif ($nx < 0 && 100 <= $ny && $ny < 150 && $ndx === -1) {
                [$nx, $ny, $ndx, $ndy] = [50, 149 - $ny, 1, $ndy];
            }
        } while (($map[$ny][$nx] ?? ' ') === ' ');

        if ($map[$ny][$nx] === '.') {
            return [$nx, $ny, $ndx, $ndy];
        }

        return [$x, $y, $dx, $dy];
    }
}
