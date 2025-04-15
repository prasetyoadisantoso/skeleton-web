<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\ContentImage; // <-- Tambahkan
use App\Models\ContentText;  // <-- Tetap ada jika masih dipakai
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('component_content_image')->truncate(); // Kosongkan pivot table
        DB::table('component_content_text')->truncate(); // Kosongkan pivot table text jika ada
        Component::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $componentsData = [
            [
                'name' => 'Hero Banner',
                'description' => 'Main banner for the homepage.',
                'is_active' => true,
            ],
            [
                'name' => 'Feature Section',
                'description' => 'Section highlighting key features.',
                'is_active' => true,
            ],
            [
                'name' => 'Testimonial Slider',
                'description' => 'Slider showing customer testimonials.',
                'is_active' => false,
            ],
            [
                'name' => 'Image Gallery',
                'description' => 'A gallery component with multiple images.',
                'is_active' => true,
            ],
        ];

        // Ambil beberapa ID ContentImage dan ContentText (jika ada)
        $imageIds = ContentImage::take(6)->pluck('id'); // Ambil 6 gambar
        $textIds = ContentText::take(5)->pluck('id'); // Ambil 5 text

        foreach ($componentsData as $componentData) {
            $component = Component::create($componentData);

            // Attach relasi dengan order (Contoh)
            if ($component->name === 'Hero Banner' && $imageIds->count() >= 1) {
                // Attach 1 gambar ke Hero Banner
                $component->contentImages()->attach([
                    $imageIds->get(0) => ['order' => 0],
                ]);
                // Attach 1 text jika ada
                if ($textIds->count() >= 1) {
                    $component->contentTexts()->attach($textIds->get(0));
                }
            } elseif ($component->name === 'Feature Section' && $imageIds->count() >= 2 && $textIds->count() >= 2) {
                // Attach 2 gambar ke Feature Section dengan order
                $component->contentImages()->attach([
                    $imageIds->get(1) => ['order' => 0],
                    $imageIds->get(2) => ['order' => 1],
                ]);
                // Attach 2 text jika ada
                $component->contentTexts()->attach($textIds->slice(1, 2)->toArray());
            } elseif ($component->name === 'Image Gallery' && $imageIds->count() >= 5) {
                // Attach 3 gambar ke Image Gallery dengan order
                $component->contentImages()->attach([
                    $imageIds->get(3) => ['order' => 0],
                    $imageIds->get(4) => ['order' => 1],
                    $imageIds->get(5) => ['order' => 2],
                ]);
                // Tidak attach text ke gallery
            }
            // Komponen lain mungkin tidak memiliki relasi awal
        }

        $this->command->info('Component table seeded with relations!');
    }
}
