<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main Category
        DB::table('categories')->insert([
            [
                'id' => 'a1557c06-32a2-4797-8656-0c59f37b39a7',
                'name' => '{"en":"Uncategorized","id":"Tidak Ada Kategori"}',
                'slug' => 'uncategorized',
                'parent_id' => ''
            ],
            [
                'id' => '7f7acc3e-6061-4d22-ba27-c752128f4cfb',
                'name' => '{"en":"Sample Category","id":"Contoh Kategori"}',
                'slug' => 'sample-category',
                'parent_id' => ''
            ],
            [
                'id' => 'b2bf09b5-a424-4cb6-8a9c-7e1eba80589c',
                'name' => '{"en":"Parent Category","id":"Kategori Utama"}',
                'slug' => 'parent-category',
                'parent_id' => ''
            ],
            [
                'id' => 'f5bdbb48-9f61-4b78-80d4-af02cbd4fda1',
                'name' => '{"en":"Sub Category","id":"Sub Kategori "}',
                'slug' => 'sub-category',
                'parent_id' => 'b2bf09b5-a424-4cb6-8a9c-7e1eba80589c',
            ],
        ]);

    }
}
