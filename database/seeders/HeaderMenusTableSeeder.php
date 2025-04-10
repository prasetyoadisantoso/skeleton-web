<?php

namespace Database\Seeders;

use App\Models\Headermenu;
use Illuminate\Database\Seeder;

class HeaderMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $home = Headermenu::create([
            'name' => 'home',
            'label' => 'dummy',
            'url' => '/',
            'order' => 1,
            'is_active' => true,
        ]);
        $home->setTranslations('label', [
            'en' => 'Home',
            'id' => 'Beranda',
        ]);
        $home->save();

        $blog = Headermenu::create([
            'name' => 'blog',
            'label' => 'dummy',
            'url' => '/blog',
            'order' => 2,
            'is_active' => true,
        ]);

        $blog->setTranslations('label', [
            'en' => 'Blog',
            'id' => 'Blog',
        ]);
        $blog->save();

        $submenu = Headermenu::create([
            'name' => 'submenu_blog_category',
            'label' => 'dummy',
            'url' => '/blog/category/uncategorized',
            'parent_id' => $blog->id,
            'order' => 1,
            'is_active' => true,
        ]);
        $submenu->setTranslations('label', [
            'en' => 'Uncategorized',
            'id' => 'Tidak Berkategori',
        ]);
        $submenu->save();
        // Tambahkan data menu lainnya sesuai kebutuhan
    }
}
