<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\FeedbackModel;

class About extends BaseController
{
    public function about(): string
    {
        return view('pages/about');
    }
}
