<?php

namespace App\Controllers\Pages;
use App\Controllers\BaseController;

class Patches extends BaseController
{
    public function index(): string
    {
        return view('pages/patches');
    }
}
