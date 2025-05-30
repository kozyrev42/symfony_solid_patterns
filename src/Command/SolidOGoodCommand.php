<?php

// src/Command/SolidOGoodCommand.php
namespace App\Command;

use App\SOLID\O\Developer;
use App\SOLID\O\Designer;
use App\SOLID\O\Manager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

//  "Сущности (классы, модули, функции) должны быть открыты для расширения, но закрыты для изменения."
//  Это значит, что поведение системы можно расширять, не изменяя уже написанный код.

//  💡 Вывод по принципу O (Open/Closed):
//
//  Класс должен быть открыт для расширения, но закрыт для изменения.
//  Мы можем добавлять новые типы сотрудников (например, Intern),не изменяя существующий код.

//  Это снижает риск ошибок, улучшает масштабируемость,
//  и делает систему гибкой для изменений в будущем.

// bin/console solid:good:o
#[AsCommand(
    name: 'solid:good:o',
    description: 'Пример соблюдения принципа O (Open/Closed)',
)]
class SolidOGoodCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $employees = [
            new Developer(100000),
            new Manager(150000),
            new Designer(120000),
        ];

        // Бизнес-логика которая не будет изменяться, при добавлении новых сотрудников !!!
        foreach ($employees as $employee) {
            $output->writeln(sprintf(
                '%s получает бонус: %.2f',
                // ReflectionClass - это класс PHP, который позволяет получить информацию о классе, методах,  и т.д.
                (new \ReflectionClass($employee))->getShortName(),
                $employee->getBonus()
            ));
        }

        return Command::SUCCESS;
    }
}
