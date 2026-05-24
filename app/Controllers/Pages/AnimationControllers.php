<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class AnimationController extends BaseController
{
    public function cyber_preloader(): string
    {
        return view('partials/cyber-preloader');
    }
}
