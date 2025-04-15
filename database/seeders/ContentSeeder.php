<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\ContentImage;
use App\Models\ContentText;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('component_content_image')->truncate();
        DB::table('component_content_text')->truncate(); // Pastikan truncate pivot text
        Component::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $componentsData = [
            ['name' => 'Hero Banner', 'description' => 'Main banner.', 'is_active' => true],
            ['name' => 'Feature Section', 'description' => 'Features.', 'is_active' => true],
            ['name' => 'Testimonial Slider', 'description' => 'Testimonials.', 'is_active' => false],
            ['name' => 'Image Gallery', 'description' => 'Gallery.', 'is_active' => true],
            ['name' => 'Text Block', 'description' => 'Simple text block.', 'is_active' => true],
        ];

        $imageIds = ContentImage::take(6)->pluck('id');
        $textIds = ContentText::take(6)->pluck('id');

        foreach ($componentsData as $componentData) {
            $component = Component::create($componentData);

            // Attach relasi dengan order
            if ($component->name === 'Hero Banner' && $imageIds->count() >= 1 && $textIds->count() >= 1) {
                $component->contentImages()->attach([$imageIds->get(0) => ['order' => 0]]);
                $component->contentTexts()->attach([$textIds->get(0) => ['order' => 0]]); // <-- Attach text dengan order
            } elseif ($component->name === 'Feature Section' && $imageIds->count() >= 2 && $textIds->count() >= 3) {
                 $component->contentImages()->attach([
                     $imageIds->get(1) => ['order' => 0], $imageIds->get(2) => ['order' => 1]
                 ]);
                 $component->contentTexts()->attach([ // <-- Attach beberapa text dengan order
                     $textIds->get(1) => ['order' => 0], $textIds->get(2) => ['order' => 1], $textIds->get(3) => ['order' => 2]
                 ]);
            } elseif ($component->name === 'Image Gallery' && $imageIds->count() >= 5) {
                 $component->contentImages()->attach([
                     $imageIds->get(3) => ['order' => 0], $imageIds->get(4) => ['order' => 1], $imageIds->get(5) => ['order' => 2]
                 ]);
            } elseif ($component->name === 'Testimonial Slider' && $textIds->count() >= 5) {
                 $component->contentTexts()->attach([
                     $textIds->get(4) => ['order' => 0], $textIds->get(5) => ['order' => 1]
                 ]);
            } elseif ($component->name === 'Text Block' && $textIds->count() >= 1) {
                 $component->contentTexts()->attach([$textIds->get(0) => ['order' => 0]]);
            }
        }

        $this->command->info('Component table seeded with image and text relations!');
    }
}
