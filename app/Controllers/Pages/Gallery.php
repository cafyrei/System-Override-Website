<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\GalleryModel;

class Gallery extends BaseController
{
    public function fetch()
    {
        $galleryModel = new GalleryModel();

        $data = [
            'galleries' => $galleryModel->findAll(),
        ];

        return view('pages/gallery', $data);
    }    
}
