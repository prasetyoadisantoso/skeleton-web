<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostOpengraphSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Canonical of Post
        DB::table('opengraph_post')->insert([
            [
                'post_id' => '491c6ec8-b8da-491e-8a4e-49db507933bh',
                'opengraph_id' => '991ac6ae-82a1-4bc9-900b-e219d0b166e0',
            ]
        ]);
    }
}
