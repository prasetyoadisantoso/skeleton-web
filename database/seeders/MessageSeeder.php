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
                'read_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id' => '42dea7dd-2f18-436f-b322-f3cd35466952',
                "name" => "Nobody 2",
                "email" => "nobody2@email.com",
                "phone" => "0811555777555",
                "message" => "Sample Text Message 2",
                'read_at' => null,
            ],
            [
                'id' => '850fc901-c6bc-43b3-84d2-927e77762b71',
                "name" => "Somebody 3",
                "email" => "somebody3@email.com",
                "phone" => "0811555333555",
                "message" => "Sample Text Message 3",
                'read_at' => date("Y-m-d H:i:s"),
            ],
            [
                'id' => 'd7b8831c-d9d5-431a-8a41-e98ad5e82c00',
                "name" => "Somebody 4",
                "email" => "somebody4@email.com",
                "phone" => "0811555777111",
                "message" => "I am writing to express my concerns regarding the recent purchase I made from your online store. I ordered a product last week, but unfortunately, it arrived in a damaged condition. The packaging was torn, and the item inside was broken. I was disappointed as I was really looking forward to using it. I believe this may have occurred during the shipping process. I kindly request your assistance in resolving this issue and arranging for a replacement or refund. <br> <br> Furthermore, I would like to commend your customer service representatives who have always been helpful and prompt in their responses. However, this time, I am in urgent need of a solution as I require the product for an upcoming event. I have attached photographs of the damaged item for your reference. Please let me know how we can proceed to ensure a satisfactory resolution. I appreciate your attention to this matter and look forward to hearing back from you soon.",
                'read_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
