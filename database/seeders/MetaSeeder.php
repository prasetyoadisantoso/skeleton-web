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
                "robot" => "index, follow",
                "description" => '{"id":"Kerangka web yang ringan dan mudah digunakan yang dapat digunakan untuk membuat berbagai jenis situs web.","en":"A lightweight and easy-to-use web framework that can be used to create various types of websites."}',
            ],
            [
                'id' => 'a98dbeb0-0acd-4571-93ef-121983fddf6a',
                "name" => "Blog",
                "robot" => "index, follow",
                "description" => '{"en":"Sample blog for Skeleton Web","id":"Contoh blog dari Skeleton Web"}',
            ],
            [
                'id' => 'f2532093-edd0-4683-81d6-aa68edfdea5b',
                "name" => "Blog - Category",
                "robot" => "index, follow",
                "description" => '{"en":"Sample category of blog for Skeleton Web","id":"Contoh kategori blog dari Skeleton Web"}',
            ],
            [
                'id' => '6777397c-b7bd-4ed3-9952-4200818df477',
                "name" => "Blog - Tag",
                "robot" => "index, follow",
                "description" => '{"en":"Sample meta of blog for Skeleton Web - Tag","id":"Contoh meta blog dari Skeleton Web - Tag"}',
            ],
            [
                'id' => '7142afc1-ae27-4224-a100-27bd16ecc3c9',
                "name" => "Blog - Tag",
                "robot" => "index, follow",
                "description" => '{"en":"Sample tag of blog for Skeleton Web","id":"Contoh tag blog dari Skeleton Web"}',
            ],
            [
                "id" => "131e6888-e3a8-46cb-b4aa-5a5bc8c892c6",
                "name" => "Contact",
                "robot" => "index, follow",
                "description" => '{"en":"Sample contact message for Skeleton Web","id":"Contoh pesan kontak dari skeleton web"}',
            ],
        ]);

    }
}
