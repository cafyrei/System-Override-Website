<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\FeedbackModel;
use CodeIgniter\HTTP\RedirectResponse;

class Feedback extends BaseController
{
    public function feedback(): string
    {
        return view('pages/feedback');
    }

    public function submit(): RedirectResponse
    {
        $rules = [
            'name'          => 'required|min_length[3]|max_length[50]',
            'feedback_type' => 'required|in_list[suggestion,bug_report]',
            'message'       => 'required|max_length[1000]',
            'email'         => 'required|valid_email|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors())
                ->withInput();
        }

        $saved = (new FeedbackModel())->save([
            'username'      => $this->request->getPost('name'),
            'feedback_type' => $this->request->getPost('feedback_type'),
            'comment'       => $this->request->getPost('message'),
            'email'         => $this->request->getPost('email'),
        ]);

        if (! $saved) {
            return redirect()->back()
                ->with('errors', ['feedback' => 'Could not save your feedback. Please try again.'])
                ->withInput();
        }

        return redirect()->to(site_url('feedback'))->with('success', 'Feedback sent!');
    }
}
