<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('classrooms')->insert([
        [
            'name' => '7A',
           'slug' => ' 7A',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '7B',
           'slug' => ' 7B',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '7C',
           'slug' => ' 7C',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '8A',
           'slug' => ' 8A',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '8B',
           'slug' => ' 8B',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '8C',
           'slug' => ' 8C',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '8D',
           'slug' => ' 8D',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '9A',
           'slug' => ' 9A',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '9B',
           'slug' => ' 9B',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        [
            'name' => '9C',
           'slug' => ' 9C',
           'created_at' => Carbon::now(),
           'updated_at' => Carbon::now(),
        ],
        ]);
    }
}
