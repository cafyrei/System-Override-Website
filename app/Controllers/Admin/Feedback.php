<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Pages\FeedbackModel;
use CodeIgniter\HTTP\ResponseInterface;

class Feedback extends BaseController
{
    public function markReviewed(int $id): ResponseInterface
    {
        $model = new FeedbackModel();

        if ($model->find($id) === null) {
            return $this->notFound();
        }

        $model->update($id, ['status' => 'reviewed']);

        return $this->response->setJSON(['success' => true]);
    }

    public function delete(int $id): ResponseInterface
    {
        $model = new FeedbackModel();

        if ($model->find($id) === null) {
            return $this->notFound();
        }

        $model->delete($id);

        return $this->response->setJSON(['success' => true]);
    }

    private function notFound(): ResponseInterface
    {
        return $this->response
            ->setStatusCode(404)
            ->setJSON(['success' => false, 'message' => 'Feedback not found.']);
    }
}
