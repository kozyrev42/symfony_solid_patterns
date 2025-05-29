<?php

namespace App\Command;

use App\SOLID\S\EmployeeDataProvider;
use App\SOLID\S\EmployeeFilter;
use App\SOLID\S\EmployeeSorter;
use App\SOLID\S\EmployeeFormatter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// Принцип единственной ответственности (SRP — Single Responsibility Principle) гласит: "Класс должен иметь только одну причину для изменения".

// Антипример: один класс и получает, и фильтрует, и сортирует, и форматирует сотрудников.
// Такой код сложно сопровождать, модифицировать и тестировать.

// Правильный подход (SRP): каждый класс решает одну задачу — получение данных, фильтрация, сортировка, форматирование.
// Это упрощает поддержку, повторное использование и юнит-тестирование.

// bin/console solid:good:s
#[AsCommand(
    name: 'solid:good:s',
    description: 'Пример соблюдения Single Responsibility Principle'
)]
class SolidSGoodCommand extends Command
{
    public function __construct(
        private readonly EmployeeDataProvider $dataProvider,
        private readonly EmployeeFilter $filter,
        private readonly EmployeeSorter $sorter,
        private readonly EmployeeFormatter $formatter
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $employees = $this->dataProvider->getEmployees();
        $filtered = $this->filter->filterByDepartment($employees, 'IT');
        $sorted = $this->sorter->sortBySalaryDescending($filtered);

        foreach ($sorted as $employee) {
            $output->writeln($this->formatter->format($employee));
        }

        return Command::SUCCESS;
    }
}
