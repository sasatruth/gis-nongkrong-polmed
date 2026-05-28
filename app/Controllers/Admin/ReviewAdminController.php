<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ReviewAdminController extends BaseController
{
    private function guard()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        return null;
    }

    // ─────────────────────────────────────────────────────────────
    // INDEX
    // ─────────────────────────────────────────────────────────────
    public function index()
    {
        if ($r = $this->guard()) return $r;

        $db     = \Config\Database::connect();
        $search = $this->request->getGet('q') ?? '';
        $rating = $this->request->getGet('rating') ?? '';
        $sort   = $this->request->getGet('sort') ?? 'terbaru';

        $where  = 'WHERE 1=1';
        $params = [];

        if ($search) {
            $where .= " AND (r.nama_reviewer ILIKE ? OR r.komentar ILIKE ? OR t.nama ILIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }

        if ($rating && is_numeric($rating)) {
            $where .= " AND r.rating = ?";
            $params[] = (int) $rating;
        }

        $orderBy = match ($sort) {
            'rating_asc'  => 'r.rating ASC, r.created_at DESC',
            'rating_desc' => 'r.rating DESC, r.created_at DESC',
            default       => 'r.created_at DESC',
        };

        $reviews = $db->query("
            SELECT 
                r.id,
                r.nama_reviewer,
                r.rating,
                r.komentar,
                r.created_at,
                r.is_visible,
                t.id AS tempat_id,
                t.nama AS tempat_nama,
                k.nama AS kategori_nama,
                k.icon AS kategori_icon
            FROM review_tempat r
            JOIN tempat_nongkrong t ON t.id = r.tempat_id
            LEFT JOIN kategori_tempat k ON k.id = t.kategori_id
            $where
            ORDER BY $orderBy
        ", $params)->getResultArray();

        $stats = $db->query("
            SELECT
                COUNT(*) AS total,
                ROUND(AVG(rating)::numeric, 2) AS avg_rating,
                COUNT(*) FILTER (WHERE rating = 5) AS bintang5,
                COUNT(*) FILTER (WHERE rating = 4) AS bintang4,
                COUNT(*) FILTER (WHERE rating = 3) AS bintang3,
                COUNT(*) FILTER (WHERE rating <= 2) AS bintang_rendah,
                COUNT(*) FILTER (WHERE is_visible = true) AS tampil,
                COUNT(*) FILTER (WHERE is_visible = false) AS disembunyikan,
                COUNT(*) FILTER (WHERE created_at >= NOW() - INTERVAL '7 days') AS minggu_ini
            FROM review_tempat
        ")->getRowArray();

        return view('admin/review/index', [
            'reviews'      => $reviews,
            'stats'        => $stats,
            'search'       => $search,
            'activeRating' => $rating,
            'activeSort'   => $sort,
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    // TOGGLE VISIBLE
    // ─────────────────────────────────────────────────────────────
    public function toggleVisible($id)
    {
        if ($r = $this->guard()) return $r;

        $db = \Config\Database::connect();

        $review = $db->query("
            SELECT id, is_visible
            FROM review_tempat
            WHERE id = ?
        ", [$id])->getRowArray();

        if (!$review) {
            return redirect()->back()
                ->with('error', 'Review tidak ditemukan.');
        }

        $visible = $review['is_visible'] === true
            || $review['is_visible'] === 't'
            || $review['is_visible'] == 1;

        $newStatus = $visible ? false : true;

        $db->query("
            UPDATE review_tempat
            SET is_visible = ?
            WHERE id = ?
        ", [$newStatus, $id]);

        return redirect()->back()
            ->with('success', 'Status tampil review berhasil diubah.');
    }

    // ─────────────────────────────────────────────────────────────
    // DELETE
    // ─────────────────────────────────────────────────────────────
    public function delete($id)
    {
        if ($r = $this->guard()) return $r;

        $db = \Config\Database::connect();

        $review = $db->query("
            SELECT 
                r.id, 
                r.tempat_id, 
                t.nama AS tempat_nama
            FROM review_tempat r
            JOIN tempat_nongkrong t ON t.id = r.tempat_id
            WHERE r.id = ?
        ", [$id])->getRowArray();

        if (!$review) {
            return redirect()->to('/admin/review')
                ->with('error', 'Review tidak ditemukan.');
        }

        $tempatId = $review['tempat_id'];

        $db->query("
            DELETE FROM review_tempat 
            WHERE id = ?
        ", [$id]);

        $this->syncRatingTempat($tempatId);

        return redirect()->to('/admin/review')
            ->with('success', "Review dari \"{$review['tempat_nama']}\" berhasil dihapus.");
    }

    // ─────────────────────────────────────────────────────────────
    // SYNC RATING TEMPAT
    // ─────────────────────────────────────────────────────────────
    private function syncRatingTempat($tempatId)
    {
        $db = \Config\Database::connect();

        $db->query("
            UPDATE tempat_nongkrong
            SET 
                rating = COALESCE((
                    SELECT ROUND(AVG(rating)::numeric, 1)
                    FROM review_tempat
                    WHERE tempat_id = ?
                    AND is_visible = true
                ), 0),
                total_review = (
                    SELECT COUNT(*)
                    FROM review_tempat
                    WHERE tempat_id = ?
                    AND is_visible = true
                )
            WHERE id = ?
        ", [$tempatId, $tempatId, $tempatId]);
    }
}