<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\FeedbackModel;

class Feedback extends BaseController
{
    public function feedback(): string
    {
        return view('pages/feedback');
    }

    public function send_feedback()
    {
        $model = new FeedbackModel();

        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'feedback_type' => 'required|in_list[suggestion,bug_report]',
            'message' => 'required|max_length[1000]',
            'email' => 'required|valid_email'
        ];

        if ($this->request->getMethod(true) === 'POST') {

            if (!$this->validate($rules)) {
                return redirect()->back()
                    ->with('errors', $this->validator->getErrors())
                    ->withInput();
            }

            $data = [
                'username' => $this->request->getPost('name'),
                'feedback_type' => $this->request->getPost('feedback_type'),
                'comment' => $this->request->getPost('message'),
                'email' => $this->request->getPost('email'),
            ];

            if (!$model->save($data)) {
                return redirect()->back()
                    ->with('errors', $model->errors())
                    ->withInput();
            }

            return redirect()->to('/feedback')->with('success', 'Feedback sent!');
        }

        return view('pages/feedback');
    }
}
