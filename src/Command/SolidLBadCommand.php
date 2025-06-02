<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  Анти-пример нарушения принципа подстановки Барбары Лисков (LSP)
 * 
 * 
 *  Дочерний класс FixedDepositAccount, переопределяет функциональность базового класса.
 *  Клиентский код (выполняется в execute()) ожидает, что любой аккаунт позволит внести/снять деньги.
 *  НЕ должно быть изменения ожидаемого поведения.
 *
 *
 *  Подкласс должен вести себя так,
 *  чтобы его можно было использовать вместо родительского класса,
 *  и при этом ничего не ломалось.
 *
 *
 *  LSP не запрещает переопределять методы.
 *  LSP говорит: "Ты можешь переопределить метод, но не нарушай смысл и ожидания от базового класса"
 *  
 *  
 *  Итог:
 *  LSP : Любой экземпляр подкласса должен без ошибок заменять собой экземпляр базового класса.
 *  То есть клиент­ский код, ожидающий базовый тип, не должен «ломаться», если ему передадут наследника.
 *
 * 
 *  bin/console solid:bad:l
 */

#[AsCommand(
    name: 'solid:bad:l',
    description: 'Анти-пример нарушения принципа подстановки Барбары Лисков (LSP)'
)]
class SolidLBadCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $accounts = [
            new CheckingAccount(1000),
            new FixedDepositAccount(5000),
        ];

        foreach ($accounts as $account) {
            // Клиентский код ожидает, что любой аккаунт позволит внести бонус
            $output->writeln('Попытка начислить бонус 500 на ' . $account::class);

            // в первой итерации всё ок, во второй нет
            // потому deposit() в подклассе FixedDepositAccount переопределен
            $account->deposit(500);
            $output->writeln('Текущий баланс: ' . $account->getBalance());
            $output->writeln('');
        }

        return Command::SUCCESS;
    }
}

// Базовый класс, который предоставляет базовую функциональность.
// Клиентский код ожидает, что любой аккаунт позволит внести бонус.
class CheckingAccount
{
    protected float $balance;

    public function __construct(float $balance)
    {
        $this->balance = $balance;
    }

    // внесение депозита
    public function deposit(float $amount): void
    {
        $this->balance += $amount;
    }

    // вывод средств
    public function withdraw(float $amount): void
    {
        $this->balance -= $amount;
    }

    // получение баланса
    public function getBalance(): float
    {
        return $this->balance;
    }
}

// Подкласс переопределяет функциональность базового класса,
// изменяет ожидаемое поведение!
class FixedDepositAccount extends CheckingAccount
{
    // внесение депозита
    public function deposit(float $amount): void
    {
        throw new \LogicException('Подкласс FixedDepositAccount, переопределяет функциональность базового класса! Депозит не пополнен!');
    }

    // вывод средств
    public function withdraw(float $amount): void
    {
        throw new \LogicException('Снятие средств невозможно до окончания срока.');
    }
}
