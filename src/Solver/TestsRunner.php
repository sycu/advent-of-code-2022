<?php

declare(strict_types=1);

namespace Solver;

class TestsRunner
{
    private const PROGRESS_LENGTH = 10;
    private const INPUT_PATTERN = '%s/input.txt';
    private const TEST_INPUT_PATTERN = '%s/test%d.input.txt';
    private const TEST_OUTPUT_PATTERN = '%s/test%d.output.txt';

    public function __construct(private readonly ConsoleOutput $output)
    {
    }

    public function run(AbstractTask $task): void
    {
        $failures = $this->runTestsAndGetFailures($task);
        $this->printSolutionAndFailures($task, $failures);
    }

    /**
     * @return string[]
     */
    private function runTestsAndGetFailures(AbstractTask $task): array
    {
        $this->output->write("{$task->key()}:\t");
        $failures = [];
        for ($number = 1; $this->testExists($task, $number); $number++) {
            $output = $task->solveForInputFile(sprintf(self::TEST_INPUT_PATTERN, $task->dataDirectory(), $number));
            $expected = rtrim(file_get_contents(sprintf(self::TEST_OUTPUT_PATTERN, $task->dataDirectory(), $number)));

            if ($output === $expected) {
                $this->output->write('.');
            } else {
                $this->output->write('F');
                $failures[] = "Test case {$number} failed: expected {$expected}, got {$output}";
            }
        }

        $this->output->write(str_repeat(' ', self::PROGRESS_LENGTH - $number + 1));

        return $failures;
    }

    /**
     * @param string[] $failures
     */
    private function printSolutionAndFailures(AbstractTask $task, array $failures): void
    {
        if (!file_exists(sprintf(self::INPUT_PATTERN, $task->dataDirectory()))) {
            $this->output->writeln('Missing input file');

            return;
        }

        $solution = $task->solveForInputFile(sprintf(self::INPUT_PATTERN, $task->dataDirectory()));
        $this->output->write("Solution is {$solution}");
        if ($failures) {
            $this->output->write(', but is probably wrong');
        }

        $this->output->writeln('');
        foreach ($failures as $failure) {
            $this->output->writeln("  {$failure}");
        }
    }

    private function testExists(AbstractTask $task, int $number): bool
    {
        return file_exists(sprintf(self::TEST_INPUT_PATTERN, $task->dataDirectory(), $number))
            && file_exists(sprintf(self::TEST_OUTPUT_PATTERN, $task->dataDirectory(), $number));
    }
}
