<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  Демонстрация соблюдения Interface Segregation Principle (ISP).
 *  Каждый клиент зависит только от тех методов, которые реально использует.
 * 
 *
 *  Мы разбили «толстый» Worker-интерфейс на три узких —
 *  WorkableInterface, EatableInterface, SleepableInterface.
 *
 *  HumanWorker реализует все три (работает-ест-спит).
 *  RobotWorker реализует только WorkableInterface (только работает).
 *
 *  Клиентские сервисы (WorkService, LunchService, SleepService)
 *  принимают ровно тот интерфейс, который им нужен:
 *     – WorkService → WorkableInterface
 *     – LunchService → EatableInterface
 *     – SleepService → SleepableInterface
 *
 *  Поэтому RobotWorker можно передать в WorkService,
 *  но компилятор (и PHP-IDE) даже не даст передать его в LunchService —
 *  код защищён от ошибок, и принцип ISP соблюдён.
 * 
 *  bin/console solid:good:i
 */
#[AsCommand(
    name: 'solid:good:i',
    description: 'Пример соблюдения Interface Segregation Principle (ISP)'
)]
class SolidIGoodCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $workers = [
            new HumanWorkerGood(),
            new RobotWorkerGood(),
        ];

        $workService  = new WorkService($output);
        $lunchService = new LunchService($output);
        $sleepService = new SleepService($output);

        foreach ($workers as $w) {
            $workService->process($w);
            // передаём только тем сервисам, которые им подходят
            if ($w instanceof EatableInterface) {
                $lunchService->process($w);
            }
            if ($w instanceof SleepableInterface) {
                $sleepService->process($w);
            }
            $output->writeln('---');
        }

        return Command::SUCCESS;
    }
}

// ──────────────────────── Интерфейсы ───────────────────────────
interface WorkableInterface
{
    public function work(): void;
}

interface EatableInterface
{
    public function eat(): void;
}

interface SleepableInterface
{
    public function sleep(): void;
}

// ──────────────────────── Классы‑работники ─────────────────────
class HumanWorkerGood implements WorkableInterface, EatableInterface, SleepableInterface
{
    public function work(): void  { echo "Human is working...\n"; }
    public function eat(): void   { echo "Human is eating...\n"; }
    public function sleep(): void { echo "Human is sleeping...\n"; }
}

class RobotWorkerGood implements WorkableInterface
{
    public function work(): void  { echo "Robot is working...\n"; }
}

// ──────────────────────── Клиентские сервисы ───────────────────
class WorkService
{
    public function __construct(private OutputInterface $out) {}
    public function process(WorkableInterface $w): void
    {
        $w->work();
        $this->out->writeln('Work done');
    }
}

class LunchService
{
    public function __construct(private OutputInterface $out) {}
    public function process(EatableInterface $e): void
    {
        $e->eat();
        $this->out->writeln('Lunch break finished');
    }
}

class SleepService
{
    public function __construct(private OutputInterface $out) {}
    public function process(SleepableInterface $s): void
    {
        $s->sleep();
        $this->out->writeln('Nap over');
    }
}
