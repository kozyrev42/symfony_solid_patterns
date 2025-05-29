<?php

namespace App\SOLID\S;

class EmployeeFormatter
{
    public function format(array $employee): string
    {
        return sprintf("| %-6s | %-6s | %6d |\n", $employee['name'], $employee['department'], $employee['salary']);
    }
}
