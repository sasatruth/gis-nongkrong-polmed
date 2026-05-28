<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table      = 'review_tempat';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'tempat_id',
        'nama_reviewer',
        'rating',
        'komentar'
    ];

    // Matikan timestamps CI4.
    // created_at biarkan otomatis dari database Supabase/PostgreSQL.
    protected $useTimestamps = false;

    public function getByTempat($tempatId)
    {
        return $this->where('tempat_id', $tempatId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getRataRating($tempatId)
    {
        $db = \Config\Database::connect();

        return $db->query("
            SELECT 
                ROUND(AVG(rating)::numeric, 1) AS rata_rating,
                COUNT(*) AS total
            FROM review_tempat
            WHERE tempat_id = ?
        ", [$tempatId])->getRow();
    }
}