<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CanonicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('canonicals')->insert([
            [
                'id' => '37039e16-12bf-435f-938f-24c6b167d16b',
                'name' => 'Index',
                'url' => 'https://example.com/home',
            ],
            [
                'id' => '252a4bee-48f4-4977-8806-52db10cdbc7f',
                'name' => 'Blog',
                'url' => 'https://example.com/product',
            ],
        ]);

    }
}
