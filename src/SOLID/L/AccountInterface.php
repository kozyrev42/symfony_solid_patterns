<?php

namespace App\SOLID\L;

interface AccountInterface
{
    public function deposit(float $amount): void;
    public function withdraw(float $amount): bool;
    public function getBalance(): float;
}
