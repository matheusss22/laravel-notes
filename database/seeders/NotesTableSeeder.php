<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create notes
        DB::table('notes')->insert([
            [
                'user_id' => 1,
                'title' => 'Nota 1',
                'text' => 'Texto da Nota 1',
                'created_at' => date('y-m-d h:m:s')
            ],
            [
                'user_id' => 1,
                'title' => 'Nota 2',
                'text' => 'Texto da Nota 2',
                'created_at' => date('y-m-d h:m:s')
            ],
            [
                'user_id' => 2,
                'title' => 'Nota 3',
                'text' => 'Texto da Nota 3',
                'created_at' => date('y-m-d h:m:s')
            ]
        ]);
    }
}
