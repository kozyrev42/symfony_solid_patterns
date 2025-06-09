<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * "Клиентский код, не должны зависеть от интерфейсов, который он не используют."
 * 
 * Другими словами — интерфейсы должны быть узкими, специализированными.
 * Лучше много маленьких интерфейсов, чем один гигантский "на все случаи жизни".
 * 
 * bin/console solid:bad:i
*/
#[AsCommand(
    name: 'solid:bad:i',
    description: 'Нарушение принципа Interface Segregation (ISP) — чрезмерный интерфейс'
)]
class SolidIBadCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>--- Human Worker ---</info>');
        $human = new HumanWorker();
        $human->work();
        $human->eat();
        $human->sleep();

        $output->writeln('<info>--- Robot Worker ---</info>');
        $robot = new RobotWorker();
        $robot->work();

        // Следующие методы не нужны роботу, но мы вынуждены их реализовывать
        try {
            $robot->eat();
        } catch (\Exception $e) {
            $output->writeln("<error>Robot can't eat: {$e->getMessage()}</error>");
        }

        try {
            $robot->sleep();
        } catch (\Exception $e) {
            $output->writeln("<error>Robot can't sleep: {$e->getMessage()}</error>");
        }

        return Command::SUCCESS;
    }
}

// Интерфейс WorkerInterface определяет методы, которые должны реализовывать любой работник.
interface WorkerInterface
{
    public function work(): void;
    public function eat(): void;
    public function sleep(): void;
}

class HumanWorker implements WorkerInterface
{
    public function work(): void
    {
        echo "Human is working...\n";
    }

    public function eat(): void
    {
        echo "Human is eating...\n";
    }

    public function sleep(): void
    {
        echo "Human is sleeping...\n";
    }
}

// RobotWorker вынужден реализовывать лишние методы, которые ему не нужны.
// Хотя роботы не едят и не спят, но мы вынуждены их реализовывать,
// Это и есть нарушение ISP.
class RobotWorker implements WorkerInterface
{
    public function work(): void
    {
        echo "Robot is working...\n";
    }

    public function eat(): void
    {
        throw new \RuntimeException('Robots do not eat');
    }

    public function sleep(): void
    {
        throw new \RuntimeException('Robots do not sleep');
    }
}
