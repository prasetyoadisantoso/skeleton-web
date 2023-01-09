<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('metas')->insert([
            [
                'id' => '3ba81b32-6faa-4d56-8f7b-deb3ee778202',
                "name" => "Home",
                "robot" => "noindex, nofollow",
                "description" => "This is meta description for home",
                "keyword" => "Sample keyword 1, Sample keyword 2, Sample keyword 3",
            ],
            [
                'id' => 'a98dbeb0-0acd-4571-93ef-121983fddf6a',
                "name" => "Blog",
                "robot" => "noindex",
                "description" => "This is meta description for blog",
                "keyword" => "Sample keyword 1, Sample keyword 2, Sample keyword 3",
            ],
            [
                'id' => 'ab113f0b-6608-4f8e-8453-8324aa0bc094',
                "name" => "Product",
                "robot" => "noindex",
                "description" => "This is meta description for product",
                "keyword" => "Sample keyword 1, Sample keyword 2, Sample keyword 3",
            ],
            [
                "id" => "131e6888-e3a8-46cb-b4aa-5a5bc8c892c6",
                "name" => "Contact",
                "robot" => "noindex",
                "description" => "This is meta description for product",
                "keyword" => "Sample keyword 1, Sample keyword 2, Sample keyword 3",
            ],
            [
                "id" => "7f4c4116-dc6f-4d14-acfb-ed6d1ebe33d5",
                "name" => "Address",
                "robot" => "noindex, nofollow",
                "description" => "This is meta description for address",
                "keyword" => "Sample keyword 1, Sample keyword 3",
            ],
        ]);

    }
}
