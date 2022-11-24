<?php

namespace Database\Seeders;

use App\Models\Meta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meta::create([
            "name" => "Home",
            "robot" => "noindex, nofollow",
            "description" => "This is meta description for home",
            "keyword" => "Sample keyword 1, Sample keyword 2, Sample keyword 3",
        ]);

        Meta::create([
            "name" => "Product",
            "robot" => "noindex",
            "description" => "This is meta description for product",
            "keyword" => "Sample keyword 1, Sample keyword 2, Sample keyword 3",
        ]);

        Meta::create([
            "name" => "Blog",
            "robot" => "noindex",
            "description" => "This is meta description for blog",
            "keyword" => "Sample keyword 1, Sample keyword 2, Sample keyword 3",
        ]);

        Meta::create([
            "name" => "Contact",
            "robot" => "noindex",
            "description" => "This is meta description for product",
            "keyword" => "Sample keyword 1, Sample keyword 2, Sample keyword 3",
        ]);

        Meta::create([
            "name" => "Address",
            "robot" => "noindex, nofollow",
            "description" => "This is meta description for address",
            "keyword" => "Sample keyword 1, Sample keyword 3",
        ]);

    }
}
