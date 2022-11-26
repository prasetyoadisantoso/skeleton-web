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
            'name' => 'Whatsapp',
            'url' => 'https://api.whatsapp.com/phone_number'
        ]);

        SocialMedia::create([
            'name' => 'Facebook',
            'url' => 'https://facebook.com/username'
        ]);

        SocialMedia::create([
            'name' => 'Twitter',
            'url' => 'https://twitter.com/username'
        ]);
    }
}
