<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }
}
