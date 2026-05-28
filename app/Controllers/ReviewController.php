<?php

namespace App\Controllers;

use App\Models\ReviewModel;

class ReviewController extends BaseController
{
    public function store($tempatId)
    {
        $reviewModel = new ReviewModel();

        $namaReviewer = trim($this->request->getPost('nama_reviewer'));
        $rating       = (int) $this->request->getPost('rating');
        $komentar     = trim($this->request->getPost('komentar'));

        if ($namaReviewer === '' || $rating < 1 || $rating > 5) {
            return redirect()->to('/tempat/' . $tempatId . '#form-review')
                ->with('error', 'Nama dan rating wajib diisi.')
                ->with('form_nama', $namaReviewer)
                ->with('form_komentar', $komentar);
        }

        $reviewModel->insert([
            'tempat_id'     => $tempatId,
            'nama_reviewer' => $namaReviewer,
            'rating'        => $rating,
            'komentar'      => $komentar,
        ]);

        $this->updateRatingTempat($tempatId);

        return redirect()->to('/tempat/' . $tempatId . '#reviews')
            ->with('success', 'Review berhasil ditambahkan.');
    }

    private function updateRatingTempat($tempatId)
    {
        $db = \Config\Database::connect();

        $db->query("
            UPDATE tempat_nongkrong
            SET 
                rating = COALESCE((
                    SELECT ROUND(AVG(rating)::numeric, 1)
                    FROM review_tempat
                    WHERE tempat_id = ?
                ), 0),
                total_review = (
                    SELECT COUNT(*)
                    FROM review_tempat
                    WHERE tempat_id = ?
                )
            WHERE id = ?
        ", [$tempatId, $tempatId, $tempatId]);
    }
}