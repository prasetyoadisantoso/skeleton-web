<?php

namespace Database\Seeders;

use App\Http\Controllers\Backend\Module\MediaLibrary\MediaLibraryController;
use App\Models\MediaLibrary;
use App\Models\User;
use App\Services\FileManagement;
use App\Services\Upload;
use Illuminate\Database\Seeder;

class MediaLibraryUserSeeder extends Seeder
{
    protected $mediaLibraryController;
    protected $upload;

    public function __construct(MediaLibraryController $mediaLibraryController, Upload $upload)
    {
        $this->mediaLibraryController = $mediaLibraryController;
        $this->upload = $upload;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileManagement = new FileManagement();

        // Get all existing users
        $users = User::all();

        foreach ($users as $user) {
            $imagePath = '';
            $role = $user->getRoleNames()->first();
            switch ($role) {
                case 'superadmin':
                    $imagePath = $fileManagement->GetPathProfileImage('superadmin');
                    break;
                case 'administrator':
                    $imagePath = $fileManagement->GetPathProfileImage('administrator');
                    break;
                case 'editor':
                    $imagePath = $fileManagement->GetPathProfileImage('editor');
                    break;
                case 'customer':
                    $imagePath = $fileManagement->GetPathProfileImage('customer');
                    break;
                case 'guest':
                    $imagePath = $fileManagement->GetPathProfileImage('guest');
                    break;
                default:
                    $imagePath = $fileManagement->GetPathProfileImage('default');
                    break;
            }

            // store user image
            if ($imagePath) {
                $data = $this->upload->UploadUserImageToMediaLibrary($imagePath);
                $mediaLibrary = MediaLibrary::create([
                    'title' => $data['media_name'],
                    'information' => '',
                    'description' => '',
                    'media_files' => $data['media_path'],
                ]);

                $user->medialibraries()->attach($mediaLibrary['id']);
            }
        }
    }
}
