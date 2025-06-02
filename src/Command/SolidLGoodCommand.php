<?php

namespace App\Command;

use App\SOLID\L\CheckingAccount;
use App\SOLID\L\SavingsAccount;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  Принцип подстановки Барбары Лисков (LSP) говорит,
 *  что подклассы должны полностью сохранять поведение базового класса.
 * 
 *  То есть, если где-то ожидается BankAccount,
 *  мы должны иметь возможность подставить SavingsAccount или CheckingAccount,
 *  и всё продолжит работать без ошибок и сюрпризов.
 * 
 */

 /**
 *  В этой команде мы создаём массив из объектов CheckingAccount и SavingsAccount,
 *  оба реализуют AccountInterface и расширяют BankAccount.
 * 
 *  Мы подставляем оба объекта в один и тот же foreach-цикл, где вызываем одинаковые методы: 
 *  deposit(), withdraw(), getBalance(). Оба класса корректно себя ведут:
 * 
 *  - CheckingAccount позволяет снимать деньги.
 *  - SavingsAccount просто не даёт снимать, но возвращает false (а не выбрасывает исключение).
 * 
 *  Таким образом, мы соблюдаем принцип подстановки Лисков (LSP):
 *  каждый подкласс BankAccount может быть подставлен вместо родителя — и программа работает корректно.
 * 
 *  bin/console solid:good:l
 */
#[AsCommand(
    name: 'solid:good:l',
    description: 'Пример, соблюдающий принцип подстановки Лисков (LSP)',
)]
class SolidLGoodCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $accounts = [
            new CheckingAccount(),
            new SavingsAccount(),
        ];

        foreach ($accounts as $account) {
            $account->deposit(100);

            $class = (new \ReflectionClass($account))->getShortName();
            $output->writeln("$class: баланс после депозита: {$account->getBalance()}");

            $result = $account->withdraw(50)
                ? 'успешно снято'
                : 'снятие не разрешено';

            $output->writeln("$class: попытка снять 50 — $result");
            $output->writeln("$class: итоговый баланс: {$account->getBalance()}");
            $output->writeln('---');
        }

        return Command::SUCCESS;
    }
}
