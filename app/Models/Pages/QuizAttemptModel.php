<?php

namespace App\Models\Pages;

use CodeIgniter\Model;

class QuizAttemptModel extends Model
{
    protected $table            = 'quiz_attempts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // the table has no updated_at

    protected $allowedFields = [
        'token',
        'player_name',
        'question_ids',
        'total_questions',
        'current_index',
        'score',
        'total_time_ms',
        'question_served_at_ms',
        'finished',
    ];

    /**
     * Top finished rounds: highest score first, then fastest total time.
     * Exact ties (same score AND same time) share a rank.
     *
     * @return list<array{player_name:string,score:int|string,total_questions:int|string,total_time_ms:int|string,rank:int}>
     */
    public function leaderboard(int $limit): array
    {
        $rows = $this->select('player_name, score, total_questions, total_time_ms')
            ->where('finished', 1)
            ->orderBy('score', 'DESC')
            ->orderBy('total_time_ms', 'ASC')
            ->orderBy('id', 'ASC') // earlier finisher wins an exact tie on screen
            ->findAll($limit);

        $rank = 0;
        $prev = null;

        foreach ($rows as $i => $row) {
            if ($prev === null
                || (int) $row['score'] !== (int) $prev['score']
                || (int) $row['total_time_ms'] !== (int) $prev['total_time_ms']) {
                $rank = $i + 1;
            }

            $rows[$i]['rank'] = $rank;
            $prev             = $row;
        }

        return $rows;
    }
}