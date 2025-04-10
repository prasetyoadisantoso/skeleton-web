<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Canonical of Post
        DB::table('meta_category')->insert([
            [
                'category_id' => '7f7acc3e-6061-4d22-ba27-c752128f4cfb',
                'meta_id' => 'f2532093-edd0-4683-81d6-aa68edfdea5b',
            ],
            [
                'category_id' => 'a1557c06-32a2-4797-8656-0c59f37b39a7',
                'meta_id' => 'f2532093-edd0-4683-81d6-aa68edfdea5b',
            ],
            [
                'category_id' => 'b2bf09b5-a424-4cb6-8a9c-7e1eba80589c',
                'meta_id' => 'f2532093-edd0-4683-81d6-aa68edfdea5b',
            ],
            [
                'category_id' => 'f5bdbb48-9f61-4b78-80d4-af02cbd4fda1',
                'meta_id' => 'f2532093-edd0-4683-81d6-aa68edfdea5b',
            ],
        ]);
    }
}
