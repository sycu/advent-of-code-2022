<?php

declare(strict_types=1);

namespace Solver;

abstract class AbstractTask
{
    /**
     * @param string[] $lines
     */
    abstract protected function solve(array $lines): string;

    public function solveForInputFile(string $inputFile): string
    {
        return $this->solve(explode(PHP_EOL, rtrim(file_get_contents($inputFile))));
    }

    public function key(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    public function dataDirectory(): string
    {
        return dirname(__FILE__, 3) . "/tasks/{$this->key()}";
    }
}
