<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::create(['name' => 'Human Resources', 'description' => 'Handles HR-related tasks.']);
        Department::create(['name' => 'Finance', 'description' => 'Manages financial operations.']);
        Department::create(['name' => 'IT', 'description' => 'Handles technology infrastructure.']);
    }
}