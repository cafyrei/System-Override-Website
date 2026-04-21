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

    protected $allowedFields = [
        'username',
        'feedback_type',
        'comment',
        'email',
    ];
}
