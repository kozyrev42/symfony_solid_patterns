<?php

namespace App\SOLID\S;

class EmployeeDataProvider
{
    public function getEmployees(): array
    {
        return [
            ['name' => 'Alice', 'department' => 'IT', 'salary' => 120000],
            ['name' => 'Bob', 'department' => 'HR', 'salary' => 80000],
            ['name' => 'Charlie', 'department' => 'IT', 'salary' => 100000],
        ];
    }
}
