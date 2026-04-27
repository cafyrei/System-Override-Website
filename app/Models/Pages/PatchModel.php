<?php

namespace App\Models\Pages;

use CodeIgniter\Model;

class PatchModel extends Model
{
    protected $table = "game_patches";
    protected $primaryKey = "patch_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';

    protected $allowedFields = [
        'patch_id',
        'patch_path',
        'patch_title',
        'patch_description',
        'patch_version',
        'patch_type',
        'patch_release',
    ];
}
