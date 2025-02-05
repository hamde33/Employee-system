<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class leave_types extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('leave_types')->insert([
            [
                'leave_type_name' => 'إجازة سنوية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_type_name' => 'إجازة مرضية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_type_name' => 'إجازة أمومة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_type_name' => 'إجازة بدون راتب',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_type_name' => 'إجازة طارئة',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'leave_type_name' => 'إجازة دراسية',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
