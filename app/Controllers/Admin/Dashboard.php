<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Pages\FeedbackModel;
use App\Models\Pages\GalleryModel;
use App\Models\Pages\PatchModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        return view('admin/index-admin', [
            'feedbacks_data' => (new FeedbackModel())->orderBy('created_at', 'DESC')->findAll(),
            'gallery_data'   => (new GalleryModel())->findAll(),
            'patches_data'   => (new PatchModel())->orderBy('patch_release', 'DESC')->findAll(),
        ]);
    }
}
