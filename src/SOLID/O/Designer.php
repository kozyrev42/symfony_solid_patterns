<?php

namespace App\SOLID\O;

class Designer implements EmployeeInterface
{
    public function __construct(private float $salary) {}

    public function getBonus(): float
    {
        return $this->salary * 0.15;
    }
}
