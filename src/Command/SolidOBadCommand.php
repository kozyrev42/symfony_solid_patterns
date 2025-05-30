<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// "Сущности (классы, модули, функции) должны быть открыты для расширения, но закрыты для изменения."
// Это значит, что поведение системы можно расширять, не изменяя уже написанный код.

// анти-пример для принципа открытости/закрытости (Open/Closed Principle, OCP).
// Команда нарушает OCP, потому что при добавлении новой должности (position)
// нам придётся менять метод calculateBonus()

// bin/console solid:bad:o
#[AsCommand(
    name: 'solid:bad:o',
    description: 'Пример нарушения Open/Closed Principle (OCP)'
)]
class SolidOBadCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $employees = [
            ['name' => 'Alice', 'position' => 'manager', 'salary' => 100000],
            ['name' => 'Bob', 'position' => 'developer', 'salary' => 80000],
            ['name' => 'Charlie', 'position' => 'intern', 'salary' => 30000],
        ];

        foreach ($employees as $employee) {
            $bonus = $this->calculateBonus($employee['position'], $employee['salary']);
            $output->writeln(
                sprintf(
                    '%s (%s) получает бонус: %d руб.',
                    $employee['name'],
                    $employee['position'],
                    $bonus
                )
            );
        }

        return Command::SUCCESS;
    }

    private function calculateBonus(string $position, int $salary): int
    {
        if ($position === 'manager') {
            return (int) ($salary * 0.2);
        } elseif ($position === 'developer') {
            return (int) ($salary * 0.15);
        } elseif ($position === 'intern') {
            return (int) ($salary * 0.05);
        } else {
            return 0; // нет бонуса
        }
    }
}
