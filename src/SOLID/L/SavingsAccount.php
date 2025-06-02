<?php

namespace App\SOLID\L;

class SavingsAccount extends BankAccount
{
    public function deposit(float $amount): void
    {
        $this->balance += $amount;
    }

    public function withdraw(float $amount): bool
    {
        // Для сберегательных счетов снятие запрещено — но метод корректно отрабатывает
        return false;
    }
}
