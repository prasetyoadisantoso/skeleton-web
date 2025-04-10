<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tag of Post
        DB::table('tag_post')->insert([
            [
                'post_id' => '7b72ae68-4785-4844-868e-7fc0c0517b8c',
                'tag_id' => '75a8e077-25d5-43f4-97a2-b353c1c93cef',
            ],

            [
                'post_id' => '7b72ae68-4785-4844-868e-7fc0c0517b8c',
                'tag_id' => 'f87a4490-fd9c-4991-81fe-6fed6310b60f',
            ]
        ]);
    }
}
