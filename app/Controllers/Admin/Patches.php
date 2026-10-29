<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\UploadStorage;
use App\Models\Pages\PatchModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class Patches extends BaseController
{
    /** Create (no patch_id) or update (patch_id present). */
    public function save(): RedirectResponse
    {
        $model    = new PatchModel();
        $storage  = new UploadStorage();
        $id       = (int) $this->request->getPost('patch_id');
        $existing = $id > 0 ? $model->find($id) : null;
        $back     = redirect()->to(site_url('admin'));

        if ($id > 0 && $existing === null) {
            return $back->with('error', 'That patch no longer exists.');
        }

        $valid = $this->validate([
            'patch_title'       => 'required|max_length[255]',
            'patch_version'     => 'required|regex_match[/^v?\d+\.\d+\.\d+$/]',
            'patch_type'        => 'required|in_list[major,minor,hotfix]',
            'patch_release'     => 'required|valid_date',
            'patch_description' => 'permit_empty|max_length[500]',
            'patch_file'        => UploadStorage::imageRule('patch_file', required: $existing === null),
        ]);

        if (! $valid) {
            return $back->with('errors', $this->validator->getErrors());
        }

        $data = [
            'patch_title'       => trim((string) $this->request->getPost('patch_title')),
            'patch_version'     => $this->request->getPost('patch_version'),
            'patch_type'        => $this->request->getPost('patch_type'),
            'patch_release'     => $this->request->getPost('patch_release'),
            'patch_description' => trim((string) $this->request->getPost('patch_description')),
        ];

        $file = $this->request->getFile('patch_file');

        if ($file !== null && $file->isValid() && ! $file->hasMoved()) {
            $data['patch_path'] = $storage->store($file, 'patches');
        }

        if ($existing !== null) {
            $model->update($id, $data);

            if (isset($data['patch_path'])) {
                $storage->remove($existing['patch_path']);
            }
        } else {
            $model->insert($data);
        }

        return $back->with('success', $existing !== null ? 'Patch updated.' : 'Patch published.');
    }

    public function delete(int $id): ResponseInterface
    {
        $model = new PatchModel();
        $patch = $model->find($id);

        if ($patch === null) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON(['success' => false, 'message' => 'Patch not found.']);
        }

        $model->delete($id);
        (new UploadStorage())->remove($patch['patch_path']);

        return $this->response->setJSON(['success' => true]);
    }
}
