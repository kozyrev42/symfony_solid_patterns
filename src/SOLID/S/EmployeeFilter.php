<?php

namespace App\SOLID\S;

class EmployeeFilter
{
    public function filterByDepartment(array $employees, string $department): array
    {
        return array_filter($employees, fn($emp) => $emp['department'] === $department);
    }
}
