<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MeetingType;

class MeetingTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['title' => 'Team Meeting', 'is_active' => true],
            ['title' => 'Project Review', 'is_active' => true],
            ['title' => 'Planning Session', 'is_active' => true],
            ['title' => 'Status Update', 'is_active' => true],
            ['title' => 'Training', 'is_active' => true],
            ['title' => 'Client Meeting', 'is_active' => true],
            ['title' => 'Department Meeting', 'is_active' => true],
        ];

        foreach ($types as $type) {
            MeetingType::create($type);
        }
    }
}
