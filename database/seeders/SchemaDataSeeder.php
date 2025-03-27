<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class SchemaDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh data schema (ganti dengan data yang sesuai)
        $schemas = [
            [
                'id' => (string) Uuid::generate(4),
                'schema_name' => 'Article - New Post',
                'schema_type' => 'Article',
                'schema_content' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Article',
                    'headline' => 'Contoh Judul Artikel',
                    'author' => [
                        '@type' => 'Organization',
                        'name' => 'Nama Organisasi',
                    ],
                    'datePublished' => '2023-10-27',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Uuid::generate(4),
                'schema_name' => 'Article - Old Post',
                'schema_type' => 'Product',
                'schema_content' => json_encode([
                    '@context' => 'https://schema.org',
                    '@type' => 'Product',
                    'name' => 'Contoh Nama Produk',
                    'description' => 'Deskripsi Produk',
                    'image' => 'https://example.com/image.jpg',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('schemadatas')->insert($schemas);
    }
}
