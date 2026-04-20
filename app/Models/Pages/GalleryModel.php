<?php

namespace App\Models\pages;

use CodeIgniter\Model;

class GalleryModel extends Model
{
    protected $table = "gallery";
    protected $primaryKey = "gallery_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'image_path',
        'gallery_title',
        'gallery_description',
    ];
}
