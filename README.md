# Advent Of Code 2022
Solutions for Advent Of Code 2022 with toolkit

## Setup
```shell
composer install
```

## Run tests and get solutions
You can filter tasks by providing **[FILTER]** argument (regexp)
```shell
php solve.php [FILTER]
```

Examples:
```shell
php solve.php
php solve.php Day5
php solve.php "Day[0-9]{1,2}B"
```

## Generate new task
It will create task data in **tasks/** directory, which you should fill out. Actual code template will be located in **src/Solver/Tasks/**


```shell
php generate.php KEY
```

Examples:
```shell
php generate.php Day5A
```

Files to fill:

| File             | Description                                                                                             | Required |
|------------------|---------------------------------------------------------------------------------------------------------|----------|
| description.txt  | Task description. It is not used anywhere, just for convenience.                                        | No       |
| input.txt        | Input for the actual problem.                                                                           | Yes      |
| output.txt       | Working solution, that you have already submitted. It is used to validate your code during refactoring. | No       |
| test1.input.txt  | Input for a test case. You can have multiple test cases, just add test2.input.txt and so on...          | No       |
| test1.output.txt | Output for a test case. Each test input should have a matching output file to be executed.              | No       |
