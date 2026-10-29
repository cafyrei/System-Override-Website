<?php

namespace App\Models\Pages;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table = "user_feedback";
    protected $primaryKey = "feedback_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    // The table has created_at but no updated_at column; without this, every
    // insert/update fails with "unknown column updated_at".
    protected $updatedField  = '';

    protected $allowedFields = [
        'username',
        'feedback_type',
        'comment',
        'email',
        'status',
    ];
}
