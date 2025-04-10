<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostCanonicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Canonical of Post
        DB::table('canonical_post')->insert([
            [
                'post_id' => '7b72ae68-4785-4844-868e-7fc0c0517b8c',
                'canonical_id' => '37039e16-12bf-435f-938f-24c6b167d16b',
            ]
        ]);
    }
}
