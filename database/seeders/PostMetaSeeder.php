<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Canonical of Post
        DB::table('meta_post')->insert([
            [
                'post_id' => '7b72ae68-4785-4844-868e-7fc0c0517b8c',
                'meta_id' => 'a98dbeb0-0acd-4571-93ef-121983fddf6a',
            ]
        ]);
    }
}
