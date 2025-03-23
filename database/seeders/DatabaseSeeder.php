<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            RoleAndPermissionSeeder::class,
            ModelRoleSeeder::class,
            GeneralSeeder::class,
            SocialMediaSeeder::class,
            MetaSeeder::class,
            CanonicalSeeder::class,
            OpengraphSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            TagSeeder::class,
            PostCategorySeeder::class,
            PostTagSeeder::class,
            PostMetaSeeder::class,
            PostOpengraphSeeder::class,
            PostCanonicalSeeder::class,
            CategoryMetaSeeder::class,
            CategoryOpengraphSeeder::class,
            TagMetaSeeder::class,
            TagOpengraphSeeder::class,
            MessageSeeder::class,
            MediaLibraryUserSeeder::class,
            MediaLibraryPostSeeder::class,
        ]);
    }
}
