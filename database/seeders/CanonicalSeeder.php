<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

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
                'id' => Uuid::generate(4)->string,
                'name' => 'Home',
                'url' => 'https://skeleton-web.prasetyoadisantoso.com/',
            ],
            [
                'id' => Uuid::generate(4)->string,
                'name' => 'Blog',
                'url' => 'https://skeleton-web.prasetyoadisantoso.com/blog',
            ],
            [
                'id' => Uuid::generate(4)->string,
                'name' => 'Contact',
                'url' => 'https://skeleton-web.prasetyoadisantoso.com/contact',
            ],
        ]);
    }
}
