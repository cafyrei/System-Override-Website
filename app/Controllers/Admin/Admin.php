<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Pages\FeedbackModel;
use App\Models\Pages\GalleryModel;

class Admin extends BaseController
{
    public function admin(): string
    {
        $feedbackModel = new FeedbackModel();
        $galleryModel = new GalleryModel();

        $data = [
            'feedbacks_data' => $feedbackModel->findAll(),
            'gallery_data'   => $galleryModel->findAll(),
        ];

        return view('admin/index-admin', $data);
    }

    public function mark_reviewed()
    {
        $data = $this->request->getJSON(true);

        $id = $data['id'];

        $model = new FeedbackModel();

        $model->update($id, [
            'status' => 'reviewed'
        ]);

        return $this->response->setJSON(['success' => true]);
    }

    public function delete_feedback()
    {
        $data = $this->request->getJSON(true);

        $id = $data['id'];

        $model = new FeedbackModel();

        $model->delete($id);

        return $this->response->setJSON(['success' => true]);
    }
}
