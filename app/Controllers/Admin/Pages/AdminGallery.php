<?php

namespace App\Controllers\Admin\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\GalleryModel;

class AdminGallery extends BaseController
{
    public function upload()
    {
        $galleryModel = new GalleryModel();

        $id = $this->request->getPost('gallery_id');

        $rules = [
            'caption' => 'required|min_length[3]|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
            'image' => 'if_exist|is_image[image]|max_size[image,10240]'
        ];

        if (!$this->validate($rules)) {
            dd($this->validator->getErrors());
        }

        $title = trim($this->request->getPost("caption"));
        $description = trim($this->request->getPost("description"));
        $image = $this->request->getFile("image");

        $data = [
            'gallery_title' => $title,
            'gallery_description' => $description,
        ];

        // HANDLE IMAGE 
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $uploadPath = FCPATH . 'uploads/gallery/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $image->move($uploadPath, $newName);
            $data['image_path'] = 'uploads/gallery/' . $newName;
        }

        // CREATE vs UPDATE
        if ($id) {
            $galleryModel->update($id, $data);
        } else {
            $galleryModel->insert($data);
        }

        return redirect()->to('/admin')
            ->with('success', $id ? 'Gallery updated!' : 'Gallery uploaded!');
    }

    public function delete($id)
    {
        $galleryModel = new GalleryModel();

        $item = $galleryModel->find($id);

        if (!$item) {
            return $this->response->setJSON(['success' => false]);
        }
        
        if (!empty($item['image_path'])) {
            $filePath = FCPATH . $item['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $galleryModel->delete($id);

        return $this->response->setJSON(['success' => true]);
    }
}
