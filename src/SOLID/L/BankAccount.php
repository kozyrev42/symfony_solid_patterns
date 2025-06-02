<?php

namespace App\SOLID\L;

abstract class BankAccount implements AccountInterface
{
    protected float $balance = 0;

    public function getBalance(): float
    {
        return $this->balance;
    }
}
