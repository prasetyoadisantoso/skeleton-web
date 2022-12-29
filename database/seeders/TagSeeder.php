<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main Tags
        DB::table('tags')->insert([
            [
                'id' => '75a8e077-25d5-43f4-97a2-b353c1c93cef',
                'name' => '{"en":"good","id":"bagus"}',
                'slug' => 'good',
            ],
            [
                'id' => 'f87a4490-fd9c-4991-81fe-6fed6310b60f',
                'name' => '{"en":"new","id":"baru"}',
                'slug' => 'new',
            ]
        ]);
    }
}
