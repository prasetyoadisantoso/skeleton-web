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
                'post_id' => '491c6ec8-b8da-491e-8a4e-49db507933bh',
                'meta_id' => '205ef213-12f2-4b20-a0c3-a109328a0a7',
            ]
        ]);
    }
}
