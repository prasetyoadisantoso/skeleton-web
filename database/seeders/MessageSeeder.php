<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            [
                'id' => 'b8a2e455-adeb-4f2c-aa6d-b870c4a2503e',
                "name" => "Nobody 1",
                "email" => "nobody1@email.com",
                "phone" => "0877555111555",
                "message" => "Sample Text Message 1",
            ],
            [
                'id' => '42dea7dd-2f18-436f-b322-f3cd35466952',
                "name" => "Nobody 2",
                "email" => "nobody2@email.com",
                "phone" => "0811555777555",
                "message" => "Sample Text Message 2",
            ],
        ]);
    }
}
