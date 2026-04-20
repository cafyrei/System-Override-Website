<?php

namespace App\Controllers\Admin\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\GalleryModel;

class AdminGallery extends BaseController
{
    public function upload()
    {
        $galleryModel = new GalleryModel();

        $rules = [
            'caption' => 'required|min_length[3]|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
            'image' => 'if_exist|is_image[image]|max_size[image,10240]'
        ];

        // if (!$this->validate($rules)) {
        //     return redirect()->back()
        //         ->with('errors', $this->validator->getErrors())
        //         ->withInput();
        // }
        
        if (!$this->validate($rules)) {
            dd($this->validator->getErrors());
        }

        $title = trim($this->request->getPost("caption"));
        $description = trim($this->request->getPost("description"));
        $image = $this->request->getFile("image");

        // No file? Still save without image
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/gallery/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image->move($uploadPath, $newName);
            $imagePath = 'uploads/gallery/' . $newName;
        }

        $galleryModel->save([
            'gallery_title' => $title,
            'gallery_description' => $description,
            'image_path' => $imagePath ?? null
        ]);

        return redirect()->to('/admin')
            ->with('success', 'Gallery uploaded successfully!');
    }
}
