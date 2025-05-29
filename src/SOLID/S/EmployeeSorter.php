<?php

namespace App\SOLID\S;

class EmployeeSorter
{
    public function sortBySalaryDescending(array $employees): array
    {
        usort($employees, fn($a, $b) => $b['salary'] <=> $a['salary']);
        return $employees;
    }
}
