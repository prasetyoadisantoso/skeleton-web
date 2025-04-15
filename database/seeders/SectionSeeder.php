<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section; // Pastikan namespace model Section benar

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Gunakan updateOrCreate untuk menghindari duplikasi jika seeder dijalankan lagi
        // Kunci unik biasanya 'name'

        // 1. Hero Section
        Section::updateOrCreate(
            ['name' => 'Hero Banner'], // Kolom unik untuk pengecekan
            [
                'layout_type' => '1-column', // Contoh: Lebar penuh
                'is_active' => true,
                // Deskripsi dalam berbagai bahasa
                'description' => [
                    'en' => 'Full width hero section, usually placed at the top of the page, containing a title, subtitle, and call-to-action button.',
                    'id' => 'Bagian hero lebar penuh, biasanya diletakkan di bagian atas halaman, berisi judul, subjudul, dan tombol ajakan bertindak.',
                ],
            ]
        );

        // 2. Features Section (Grid)
        Section::updateOrCreate(
            ['name' => 'Feature List (Grid)'],
            [
                'layout_type' => '4-column', // Contoh: Lebar terbatas
                'is_active' => true,
                'description' => [
                    'en' => 'Section to display key features or services, often arranged in a grid layout (e.g., 3 columns). Components inside might be cards.',
                    'id' => 'Bagian untuk menampilkan fitur atau layanan utama, seringkali disusun dalam tata letak grid (misalnya 3 kolom). Komponen di dalamnya bisa berupa kartu.',
                ],
            ]
        );

        // 3. Call to Action (CTA) Section
        Section::updateOrCreate(
            ['name' => 'Call To Action'],
            [
                'layout_type' => '1-column',
                'is_active' => true,
                'description' => [
                    'en' => 'A prominent section designed to encourage user action, like signing up or contacting.',
                    'id' => 'Bagian mencolok yang dirancang untuk mendorong tindakan pengguna, seperti mendaftar atau menghubungi.',
                ],
            ]
        );

        // 4. Testimonials Section
        Section::updateOrCreate(
            ['name' => 'Testimonials'],
            [
                'layout_type' => '1-column',
                'is_active' => true,
                'description' => [
                    'en' => 'Section to display customer testimonials or quotes, often using a slider or grid.',
                    'id' => 'Bagian untuk menampilkan testimoni atau kutipan pelanggan, seringkali menggunakan slider atau grid.',
                ],
            ]
        );

        // 5. Simple Content Section
        Section::updateOrCreate(
            ['name' => 'Basic Content Row'],
            [
                'layout_type' => '3-column',
                'is_active' => true,
                'description' => [
                    'en' => 'A standard container section for general content components like text blocks or images.',
                    'id' => 'Bagian kontainer standar untuk komponen konten umum seperti blok teks atau gambar.',
                ],
            ]
        );

        // 6. Contact Form Section
        Section::updateOrCreate(
            ['name' => 'Contact Form Section'],
            [
                'layout_type' => '1-column',
                'is_active' => true,
                'description' => [
                    'en' => 'Section specifically designed to hold a contact form component.',
                    'id' => 'Bagian yang dirancang khusus untuk menampung komponen formulir kontak.',
                ],
            ]
        );

         // 7. Custom Layout Example (No Wrapper)
         Section::updateOrCreate(
            ['name' => 'Custom Layout Wrapper'],
            [
                'layout_type' => '12-column',
                'is_active' => true,
                'description' => [
                    'en' => 'A section without an automatic container/row wrapper. Layout is fully controlled by the components within or custom CSS.',
                    'id' => 'Bagian tanpa pembungkus container/row otomatis. Tata letak sepenuhnya dikontrol oleh komponen di dalamnya atau CSS kustom.',
                ],
            ]
        );

        // Tambahkan contoh section lain sesuai kebutuhan...
    }
}
