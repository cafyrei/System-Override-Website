<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\PatchModel;

class Patches extends BaseController
{
    public function fetch()
    {
        $patchModel = new PatchModel();

        $data = [
            'patches' => $patchModel->findAll(),
        ];

        return view('pages/patches', $data);
    }
}
