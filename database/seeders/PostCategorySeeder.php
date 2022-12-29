<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Category of Post
        DB::table('category_post')->insert([
            [
                'post_id' => '7b72ae68-4785-4844-868e-7fc0c0517b8c',
                'category_id' => '7f7acc3e-6061-4d22-ba27-c752128f4cfb',
            ]
        ]);
    }
}
