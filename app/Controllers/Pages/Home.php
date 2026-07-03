<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\FeedbackModel;

class Home extends BaseController
{
    public function index(): string
    {
        $feedbackModel = new FeedbackModel();

        $data['feedbacks'] = $feedbackModel
            ->where('status', 'unread')
            ->orderBy('created_at', 'DESC')
            ->findAll(6);

        return view('index', $data);
    }
}