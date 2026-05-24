<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class Learn extends BaseController
{
    public function learn(): string
    {
        return view('pages/learn');
    }
}
