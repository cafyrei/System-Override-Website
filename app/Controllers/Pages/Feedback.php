<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;

class Feedback extends BaseController
{
    public function feedback(): string
    {
        return view('pages/feedback');
    }
}
