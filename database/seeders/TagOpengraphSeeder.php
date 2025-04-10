<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagOpengraphSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('opengraph_tag')->insert([
            [
                'tag_id' => '75a8e077-25d5-43f4-97a2-b353c1c93cef',
                'opengraph_id' => 'bb73bcd6-18ad-42ec-9417-89c0f1bf08c0',
            ],
            [
                'tag_id' => 'f87a4490-fd9c-4991-81fe-6fed6310b60f',
                'opengraph_id' => 'bb73bcd6-18ad-42ec-9417-89c0f1bf08c0',
            ],
        ]);
    }
}
