<?php

namespace Database\Seeders;

use App\Models\Layout;
use App\Models\Section;
use Illuminate\Database\Seeder;

class LayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data section yang akan dihubungkan ke layout
        // Sesuaikan dengan cara Anda ingin memilih section (misalnya, berdasarkan nama, ID, dll.)
        // Ini contoh: ambil section "Hero Banner" dan "Feature List (Grid)"
        $heroSection = Section::where('name', 'Hero Banner')->first();
        $featureSection = Section::where('name', 'Feature List (Grid)')->first();
        $contactSection = Section::where('name', 'Contact Form Section')->first();

        // Validasi Section
        if (!$heroSection || !$featureSection || !$contactSection) {
            $this->command->info('Beberapa Section tidak ditemukan. Pastikan SectionSeeder sudah dijalankan.');

            return; // Hentikan seeder jika section tidak ditemukan
        }

        // 1. Full-width Layout Example
        $fullWidthLayout = Layout::updateOrCreate(
            ['name' => 'Full-width Default'],
            [
                'type' => 'full-width',
            ]
        );

        // Attach Sections (Hero di bagian atas, lalu FeatureList)
        $fullWidthLayout->sectionsMain()->attach([
            $heroSection->id => ['location' => 'main', 'order' => 0],
            $featureSection->id => ['location' => 'main', 'order' => 1],
            $contactSection->id => ['location' => 'main', 'order' => 2],
        ]);

        // 2. Sidebar Layout Example
        $sidebarLayout = Layout::updateOrCreate(
            ['name' => 'Sidebar Default'],
            [
                'type' => 'sidebar',
            ]
        );

        // Attach Sections (Hero di main, Feature di sidebar)
        $sidebarLayout->sectionsMain()->attach([
            $heroSection->id => ['location' => 'main', 'order' => 0],
        ]);
        $sidebarLayout->sectionsSidebar()->attach([
            $featureSection->id => ['location' => 'sidebar', 'order' => 0],
            $contactSection->id => ['location' => 'sidebar', 'order' => 1],
        ]);

        // Contoh Lain: Full-width dengan hanya Hero Section
        Layout::updateOrCreate(
            ['name' => 'Full-width Hero Only'],
            [
                'type' => 'full-width',
            ]
        )->sectionsMain()->sync([
            $heroSection->id => ['location' => 'main', 'order' => 0],
        ]);
    }
}
