<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Canonical;

class CanonicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Canonical::create([
            'name' => 'Index',
            'url' => 'https://example.com/home'
        ]);

        Canonical::create([
            'name' => 'Product',
            'url' => 'https://example.com/product'
        ]);
    }
}
