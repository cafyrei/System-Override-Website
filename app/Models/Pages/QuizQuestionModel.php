<?php

namespace App\Models\Pages;

use CodeIgniter\Model;

class QuizQuestionModel extends Model
{
    protected $table            = 'quiz_questions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'question',
        'choice_1',
        'choice_2',
        'choice_3',
        'choice_4',
        'correct_choice',
        'is_active',
    ];
}
