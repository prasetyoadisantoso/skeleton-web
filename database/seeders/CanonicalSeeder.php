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
                'name' => 'Home',
                'url' => 'https://skeleton-web.prasetyoadisantoso.com/',
            ],
            [
                'id' => '252a4bee-48f4-4977-8806-52db10cdbc7f',
                'name' => 'Blog',
                'url' => 'https://skeleton-web.prasetyoadisantoso.com/blog',
            ],
            [
                'id' => '082c03cb-517f-482e-93ba-f9918d7b033c',
                'name' => 'Contact',
                'url' => 'https://skeleton-web.prasetyoadisantoso.com/contact',
            ],
        ]);

    }
}
