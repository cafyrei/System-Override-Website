<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function admin(): string
    {
        return view('admin/index-admin');
    }
}
