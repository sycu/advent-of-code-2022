<?php

declare(strict_types=1);

namespace Solver;

class TasksLocator
{
    /**
     * @return AbstractTask[]
     */
    public function find(string $filter): array
    {
        $files = scandir(dirname(__FILE__) . '/Tasks');
        natsort($files);

        $tasks = [];
        foreach ($files as $file) {
            if (preg_match("/^(.*{$filter}.*)\.php$/", $file, $matches)) {
                $tasks[] = new ('\\Solver\\Tasks\\' . $matches[1])();
            }
        }

        return $tasks;
    }
}
