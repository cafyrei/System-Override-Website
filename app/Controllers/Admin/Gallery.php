<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\UploadStorage;
use App\Models\Pages\GalleryModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Gallery extends BaseController
{
    /** Create (no gallery_id) or update (gallery_id present). */
    public function save(): RedirectResponse
    {
        $model    = new GalleryModel();
        $storage  = new UploadStorage();
        $id       = (int) $this->request->getPost('gallery_id');
        $existing = $id > 0 ? $model->find($id) : null;
        $back     = redirect()->to(site_url('admin'));

        if ($id > 0 && $existing === null) {
            return $back->with('error', 'That gallery item no longer exists.');
        }

        $valid = $this->validate([
            'caption'     => 'required|min_length[3]|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
            'image'       => UploadStorage::imageRule('image', required: $existing === null),
        ]);

        if (! $valid) {
            return $back->with('errors', $this->validator->getErrors());
        }

        $data = [
            'gallery_title'       => trim((string) $this->request->getPost('caption')),
            'gallery_description' => trim((string) $this->request->getPost('description')),
        ];

        $image = $this->request->getFile('image');

        if ($image !== null && $image->isValid() && ! $image->hasMoved()) {
            $data['image_path'] = $storage->store($image, 'gallery');
        }

        if ($existing !== null) {
            $model->update($id, $data);

            if (isset($data['image_path'])) {
                $storage->remove($existing['image_path']); // replaced: don't leave orphans
            }
        } else {
            $model->insert($data);
        }

        return $back->with('success', $existing !== null ? 'Gallery item updated.' : 'Gallery item added.');
    }

    public function delete(int $id): ResponseInterface
    {
        $model = new GalleryModel();
        $item  = $model->find($id);

        if ($item === null) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['success' => false, 'message' => 'Gallery item not found.']);
        }

        $model->delete($id);
        (new UploadStorage())->remove($item['image_path']);

        return $this->response->setJSON(['success' => true]);
    }
}
