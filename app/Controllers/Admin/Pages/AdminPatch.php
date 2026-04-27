<?php

namespace App\Controllers\Admin\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\PatchModel;

class AdminPatch extends BaseController
{
    public function upload()
    {
        $patchModel = new PatchModel();

        $id = $this->request->getPost('patch_id');

        $rules = [
            'patch_version' => 'required|regex_match[/^v?\d+\.\d+\.\d+$/]',
            'patch_description' => 'permit_empty|max_length[500]',
            'patch_type' => 'required',
            'patch_title' => 'required',
            'patch_release' => 'required|valid_date',
        ];

        if (!$this->validate($rules)) {
            dd($this->validator->getErrors());
        }

        $data = [
            'patch_version' => $this->request->getPost('patch_version'),
            'patch_description' => $this->request->getPost('patch_description'),
            'patch_type' => $this->request->getPost('patch_type'),
            'patch_title' => $this->request->getPost('patch_title'),
            'patch_release' => $this->request->getPost('patch_release'),
        ];

        $file = $this->request->getFile('patch_file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/patches/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $newName);
            $data['patch_path'] = 'uploads/patches/' . $newName;
        }

        if ($id) {
            $patchModel->update($id, $data);
        } else {
            $patchModel->insert($data);
        }

        return redirect()->to('/admin')
            ->with('success', $id ? 'Patch updated!' : 'Patch uploaded!');
    }

    public function delete($id = null)
    {
        $patchModel = new \App\Models\Pages\PatchModel();

        // 1. Check if ID even made it to the function
        if (!$id) {
            return $this->response->setJSON(['success' => false, 'message' => 'No ID was passed to the controller.']);
        }

        // 2. Check if the record exists
        $patch = $patchModel->find($id);
        if (!$patch) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "Patch with ID $id not found in database.",
                'debug_table' => $patchModel->table
            ]);
        }

        // 3. Check for File Deletion errors
        if (!empty($patch['patch_path'])) {
            $filePath = FCPATH . $patch['patch_path'];
            if (file_exists($filePath)) {
                if (!unlink($filePath)) {
                    return $this->response->setJSON(['success' => false, 'message' => 'Database record found, but failed to delete physical file. Check folder permissions.']);
                }
            }
        }

        $patchModel->delete($id);
        return $this->response->setJSON(['success' => true]);
    }
}
