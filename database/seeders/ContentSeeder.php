<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContentText;   // Sesuaikan namespace jika berbeda
use App\Models\ContentImage;  // Sesuaikan namespace jika berbeda
use App\Models\MediaLibrary;  // Import MediaLibrary
use App\Services\Upload;      // Import Upload service
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;     // Import File facade
use Illuminate\Support\Facades\Storage; // Import Storage
use Illuminate\Support\Str; // Import Str untuk path manipulation

class ContentSeeder extends Seeder
{
    protected $uploadService;

    /**
     * Inject Upload service.
     */
    public function __construct(Upload $uploadService) // Inject Upload service
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Kosongkan tabel sebelum seeding (opsional) ---
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ContentText::truncate();
        ContentImage::truncate();
        // Hapus media yang dibuat oleh seeder ini sebelumnya (jika perlu)
        $seededMedia = MediaLibrary::where('information', 'like', '%Seeded Image from Test%')->get();
        $this->command->info('Deleting previously seeded media files...');
        $deletedFilesCount = 0;
        foreach ($seededMedia as $media) {
            if (Storage::disk('public')->exists($media->media_files)) {
                Storage::disk('public')->delete($media->media_files); // Hapus file fisik di public/storage
                $deletedFilesCount++;
            }
            $media->delete(); // Hapus record DB
        }
        if ($deletedFilesCount > 0) {
            $this->command->info("Deleted {$deletedFilesCount} physical media files.");
        }
        $this->command->info('Finished deleting previous media.');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // --- End Kosongkan Tabel ---


        // --- Seed ContentText ---
        // (Bagian ContentText tidak berubah, saya singkat untuk kejelasan)
        $texts = [
            [ 'type' => 'h1', 'content' => ['en' => 'Welcome', 'id' => 'Selamat Datang'] ],
            [ 'type' => 'paragraph', 'content' => ['en' => 'Intro paragraph', 'id' => 'Paragraf pembuka'] ],
            [ 'type' => 'h2', 'content' => ['en' => 'Features', 'id' => 'Fitur'] ],
            [ 'type' => 'paragraph', 'content' => ['en' => 'Feature details', 'id' => 'Detail fitur'] ],
            [ 'type' => 'h3', 'content' => ['en' => 'Subheading', 'id' => 'Sub Judul'] ],
            [ 'type' => 'paragraph', 'content' => ['en' => 'Subtopic details', 'id' => 'Detail sub topik'] ],
        ];
        foreach ($texts as $text) { ContentText::create($text); }
        $this->command->info('ContentText table seeded!');
        // --- End Seed ContentText ---


        // --- Seed ContentImage (Menggunakan MediaLibrary dan gambar dari public/Test/Images) ---
        $source_image_public_path = 'Test/Images/content-image.png'; // Path relatif dari folder public/
        $source_image_full_path = public_path($source_image_public_path); // Path absolut ke file sumber

        // Pastikan file sumber ada di folder public/
        if (!File::exists($source_image_full_path)) {
            $this->command->error("Source image not found in public directory: " . $source_image_public_path);
            $this->command->error("ContentImage seeding skipped.");
            return; // Hentikan seeding ContentImage jika sumber tidak ada
        }

        $target_base_dir = 'assets/Media/Type/Image'; // Direktori target di MediaLibrary (relatif dari public/storage)
        $total_images_to_seed = 10; // Jumlah gambar yang akan dibuat

        $this->command->info("Starting to seed {$total_images_to_seed} ContentImage entries...");

        // Ambil info file sumber sekali saja
        $original_filename = basename($source_image_public_path);
        $filename_base = pathinfo($original_filename, PATHINFO_FILENAME);
        $extension = pathinfo($original_filename, PATHINFO_EXTENSION);

        for ($i = 1; $i <= $total_images_to_seed; $i++) {
            $this->command->info("Processing image {$i}/{$total_images_to_seed}...");

            // Buat data unik untuk setiap iterasi
            $unique_name = "Content Image Seed {$i}";
            $unique_alt_text = [
                'en' => "Alt text for seeded image {$i}",
                'id' => "Teks alt untuk gambar seed {$i}",
            ];
            // Buat caption kadang-kadang null
            $unique_caption = ($i % 5 != 0) ? [
                'en' => "Caption for seeded image {$i}",
                'id' => "Keterangan untuk gambar seed {$i}",
            ] : null;

            // Buat nama file target unik
            $target_filename = Str::slug($unique_name) . '.' . $extension; // e.g., content-image-seed-1.png
            $db_media_path = $target_base_dir . '/' . $target_filename; // Path yang disimpan di DB (relatif dari public/storage)
            $target_storage_path = $db_media_path; // Path relatif dari root disk 'public' (storage/app/public)

            // Path absolut ke file target di public/storage
            $target_full_path = storage_path('app/public/' . $target_storage_path);

            // Salin file dari public/ ke public/storage (simulasi upload)
            // Hanya salin jika file target belum ada
            if (!Storage::disk('public')->exists($target_storage_path)) {
                 // Pastikan direktori target ada
                 Storage::disk('public')->makeDirectory(dirname($target_storage_path));

                 // Salin file dari public/Test/Images/... ke storage/app/public/assets/Media/Type/Image/...
                 File::copy($source_image_full_path, $target_full_path);
                 // $this->command->info("Image copied to: " . $target_storage_path); // Kurangi output

                 // Panggil kompresi setelah file disalin
                 try {
                     // Path untuk CompressionImage harus relatif dari storage/app
                     $path_for_compression = 'public/' . $target_storage_path;
                     $this->uploadService->CompressionImage($path_for_compression, 1000); // Kompresi ke lebar 1000px
                     // $this->command->info("Image compressed: " . $target_storage_path); // Kurangi output
                 } catch (\Exception $e) {
                     $this->command->error("Compression failed for {$target_filename}: " . $e->getMessage());
                     // Hapus file yang gagal dikompresi jika perlu
                     // Storage::disk('public')->delete($target_storage_path);
                     // continue; // Lewati iterasi ini jika kompresi gagal
                 }
            } else {
                 // $this->command->info("Target file already exists, skipping copy: " . $target_storage_path); // Kurangi output
            }


            // 1. Buat entri MediaLibrary
            $media = MediaLibrary::create([
                'title' => $unique_name, // Gunakan nama unik
                'media_files' => $db_media_path, // Path relatif dari public/storage
                'information' => 'Seeded Image from Test', // Info tambahan
                'description' => $unique_caption['en'] ?? $unique_caption['id'] ?? '', // Deskripsi dari caption
            ]);

            // 2. Buat entri ContentImage yang terhubung ke MediaLibrary
            ContentImage::create([
                'name' => $unique_name, // Gunakan nama unik
                'media_library_id' => $media->id, // Hubungkan ke ID MediaLibrary
                'alt_text' => $unique_alt_text, // Gunakan alt text unik
                'caption' => $unique_caption, // Gunakan caption unik
            ]);
        } // End loop for

        $this->command->info("ContentImage table seeded with {$total_images_to_seed} MediaLibrary links!");
        // --- End Seed ContentImage ---
    }
}
