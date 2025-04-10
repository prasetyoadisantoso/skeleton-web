<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocialMedia::create([
            'name' => 'Instagram',
            'url' => 'https://www.instagram.com/prasetyowebdeveloper/'
        ]);

        SocialMedia::create([
            'name' => 'Github',
            'url' => 'https://github.com/prasetyoadisantoso/'
        ]);

        SocialMedia::create([
            'name' => 'Gitlab',
            'url' => 'https://gitlab.com/prasetyoadisantoso'
        ]);
    }
}
