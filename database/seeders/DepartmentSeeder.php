<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['C_name' => 'قسم أصول التربية'],
            ['C_name' => 'قسم مناهج وطرق تدريس'],
            ['C_name' => 'قسم علم النفس'],
            ['C_name' => 'قسم تربية مقارنة وإدارة تعليمية'],
            ['C_name' => 'قسم البرنامج الخاص'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
