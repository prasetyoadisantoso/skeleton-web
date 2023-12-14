<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagMetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meta_tag')->insert([
            [
                'tag_id' => '75a8e077-25d5-43f4-97a2-b353c1c93cef',
                'meta_id' => '6777397c-b7bd-4ed3-9952-4200818df477',
            ],
            [
                'tag_id' => 'f87a4490-fd9c-4991-81fe-6fed6310b60f',
                'meta_id' => '6777397c-b7bd-4ed3-9952-4200818df477',
            ],
        ]);
    }
}
