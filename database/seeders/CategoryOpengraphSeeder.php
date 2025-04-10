<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryOpengraphSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Canonical of Post
        DB::table('opengraph_category')->insert([
            [
                'category_id' => '7f7acc3e-6061-4d22-ba27-c752128f4cfb',
                'opengraph_id' => 'e84b1cdf-3277-4739-9f7d-1dc489a3aaf7',
            ],
            [
                'category_id' => 'a1557c06-32a2-4797-8656-0c59f37b39a7',
                'opengraph_id' => 'e84b1cdf-3277-4739-9f7d-1dc489a3aaf7',
            ],
            [
                'category_id' => 'b2bf09b5-a424-4cb6-8a9c-7e1eba80589c',
                'opengraph_id' => 'e84b1cdf-3277-4739-9f7d-1dc489a3aaf7',
            ],
            [
                'category_id' => 'f5bdbb48-9f61-4b78-80d4-af02cbd4fda1',
                'opengraph_id' => 'e84b1cdf-3277-4739-9f7d-1dc489a3aaf7',
            ],
        ]);
    }
}
