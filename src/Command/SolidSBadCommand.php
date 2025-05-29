<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Анти-пример должен иллюстрировать, что один класс/команда делает слишком много вещей сразу — нарушает SRP.
 * 
 * Анти‑пример нарушения S из SOLID: класс делает ВСЁ сразу.
 *  – хранит данные
 *  – фильтрует
 *  – сортирует
 *  – форматирует
 *  – выводит
 * 
 * bin/console solid:bad:s
 */
#[AsCommand(
    name: 'solid:bad:s',
    description: 'Анти‑пример нарушения Single-Responsibility'
)]
class SolidSBadCommand extends Command
{
    /**
     * Захардкоженные «данные» – ответственность №1 (хранение данных)
     */
    private array $users = [
        ['id' => 1, 'name' => 'Alice',   'age' => 22],
        ['id' => 2, 'name' => 'Bob',     'age' => 17],
        ['id' => 3, 'name' => 'Charlie', 'age' => 35],
        ['id' => 4, 'name' => 'Anna',    'age' => 28],
        ['id' => 5, 'name' => 'Dave',    'age' => 42],
    ];

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Ответственность №2 – фильтрация (оставляем 18+)
        $filtered = array_filter($this->users, fn ($u) => $u['age'] >= 18);

        // Ответственность №3 – сортировка по имени
        usort($filtered, fn ($a, $b) => $a['name'] <=> $b['name']);

        // Ответственность №4 – форматирование в ASCII‑таблицу
        $rows = array_map(fn ($u) => sprintf("| %-2d | %-7s | %-3d |", $u['id'], $u['name'], $u['age']), $filtered);
        $header = "+----+---------+-----+\n| ID | Name    | Age |\n+----+---------+-----+";

        // Ответственность №5 – вывод
        $output->writeln($header);
        foreach ($rows as $row) {
            $output->writeln($row);
        }
        $output->writeln("+----+---------+-----+");

        return Command::SUCCESS;
    }
}
