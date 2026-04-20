<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;
use app\Models\Pages\GalleryModel;

class Gallery extends BaseController
{
    public function gallery(): string
    {
        $galleryModel = new GalleryModel();

        $galleries = $galleryModel->findAll();


        $data = [
            'galleries' => $galleries
        ];

        return view('pages/gallery', $data);
    }

    
}
