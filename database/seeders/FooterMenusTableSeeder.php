<?php

namespace Database\Seeders;

use App\Models\Footermenu;
use Illuminate\Database\Seeder;

class FooterMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $privacy = Footermenu::create([
            'name' => 'privacy_policy',
            'label' => 'dummy',
            'url' => '/privacy-policy',
            'order' => 1,
            'is_active' => true,
        ]);

        $privacy->setTranslations('label', [
            'en' => 'Privacy Policy',
            'id' => 'Kebijakan Privasi',
        ]);

        $privacy->save();

        $terms = Footermenu::create([
            'name' => 'terms_and_conditions',
            'label' => "{'en':'Terms and Conditions','id':'Syarat dan Ketentuan'}",
            'url' => '/terms-conditions',
            'order' => 1,
            'is_active' => true,
        ]);

        $terms->setTranslations('label', [
            'en' => 'Terms and Conditions',
            'id' => 'Syarat dan Ketentuan',
        ]);

        $terms->save();
    }
}
