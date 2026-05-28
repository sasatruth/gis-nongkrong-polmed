<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    private float $polmedLng = 98.6549;
    private float $polmedLat = 3.5666;

    public function index()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        $db = \Config\Database::connect();

        // ── 1. Stat utama ─────────────────────────────────────────
        $stats = $db->query("
            SELECT
                COUNT(*) AS total_tempat,
                COUNT(*) FILTER (WHERE is_active = true) AS aktif,
                COUNT(*) FILTER (WHERE is_active = false) AS nonaktif,
                ROUND(AVG(rating)::numeric, 2) AS avg_rating,
                COUNT(*) FILTER (WHERE rating >= 4) AS rating_tinggi,
                COUNT(*) FILTER (WHERE harga_min IS NOT NULL) AS ada_harga,
                COUNT(*) FILTER (WHERE foto_url IS NOT NULL AND foto_url != '') AS ada_foto,
                COUNT(*) FILTER (WHERE geom IS NOT NULL) AS ada_koordinat
            FROM tempat_nongkrong
        ")->getRowArray();

        // ── 2. Total review & kategori ────────────────────────────
        $totalReview = $db->query("
            SELECT COUNT(*) AS total 
            FROM review_tempat
        ")->getRowArray();

        $totalKategori = $db->query("
            SELECT COUNT(*) AS total 
            FROM kategori_tempat
        ")->getRowArray();

        // ── 3. Per kategori ───────────────────────────────────────
        $perKategori = $db->query("
            SELECT 
                k.nama, 
                k.icon,
                COUNT(t.id) AS jumlah,
                COUNT(t.id) FILTER (WHERE t.is_active = true) AS aktif,
                ROUND(AVG(t.rating)::numeric, 1) AS avg_rating
            FROM kategori_tempat k
            LEFT JOIN tempat_nongkrong t 
                ON t.kategori_id = k.id
            GROUP BY k.id, k.nama, k.icon
            ORDER BY jumlah DESC
        ")->getResultArray();

        // ── 4. Distribusi rating ──────────────────────────────────
        $distribusiRating = $db->query("
            SELECT
                COUNT(*) FILTER (WHERE rating >= 4.5) AS bintang5,
                COUNT(*) FILTER (WHERE rating >= 3.5 AND rating < 4.5) AS bintang4,
                COUNT(*) FILTER (WHERE rating >= 2.5 AND rating < 3.5) AS bintang3,
                COUNT(*) FILTER (WHERE rating >= 1.5 AND rating < 2.5) AS bintang2,
                COUNT(*) FILTER (WHERE rating < 1.5 AND rating IS NOT NULL) AS bintang1,
                COUNT(*) FILTER (WHERE rating IS NULL) AS tanpa_rating
            FROM tempat_nongkrong
        ")->getRowArray();

        // ── 5. Statistik fasilitas ────────────────────────────────
        $fasilitas = $db->query("
            SELECT
                COUNT(*) FILTER (WHERE wifi = true) AS wifi,
                COUNT(*) FILTER (WHERE colokan = true) AS colokan,
                COUNT(*) FILTER (WHERE ac = true) AS ac,
                COUNT(*) FILTER (WHERE parkir = true) AS parkir,
                COUNT(*) FILTER (WHERE mushola = true) AS mushola,
                COUNT(*) FILTER (WHERE outdoor = true) AS outdoor,
                COUNT(*) FILTER (WHERE tempat_tenang = true) AS tenang,
                COUNT(*) FILTER (WHERE cocok_nugas = true) AS nugas,
                COUNT(*) FILTER (WHERE cocok_rame = true) AS rame
            FROM tempat_nongkrong
            WHERE is_active = true
        ")->getRowArray();

        // ── 6. Statistik radius GIS ───────────────────────────────
        $radiusStats = $db->query("
            SELECT
                COUNT(*) FILTER (
                    WHERE ST_DWithin(
                        geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                        500
                    )
                ) AS radius_500m,

                COUNT(*) FILTER (
                    WHERE ST_DWithin(
                        geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                        1000
                    )
                ) AS radius_1km,

                COUNT(*) FILTER (
                    WHERE ST_DWithin(
                        geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                        2000
                    )
                ) AS radius_2km,

                COUNT(*) FILTER (WHERE geom IS NOT NULL) AS punya_koordinat,
                COUNT(*) FILTER (WHERE geom IS NULL) AS tanpa_koordinat,

                ROUND(
                    AVG(
                        ST_Distance(
                            geom,
                            ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                        )
                    )::numeric / 1000,
                    2
                ) AS avg_jarak_km

            FROM tempat_nongkrong
            WHERE is_active = true
        ", [
            $this->polmedLng,
            $this->polmedLat,

            $this->polmedLng,
            $this->polmedLat,

            $this->polmedLng,
            $this->polmedLat,

            $this->polmedLng,
            $this->polmedLat,
        ])->getRowArray();

        // ── 7. Recent tempat ──────────────────────────────────────
        $recentTempat = $db->query("
            SELECT 
                t.id, 
                t.nama, 
                t.alamat, 
                t.rating, 
                t.is_active,
                t.created_at, 
                k.nama AS kategori, 
                k.icon AS kategori_icon
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k 
                ON t.kategori_id = k.id
            ORDER BY t.created_at DESC
            LIMIT 6
        ")->getResultArray();

        // ── 8. Review terbaru dari input user asli ────────────────
        $recentReview = $db->query("
            SELECT
                r.id,
                r.nama_reviewer,
                r.rating,
                r.komentar,
                r.created_at,
                r.is_visible,
                t.id AS tempat_id,
                t.nama AS tempat_nama
            FROM review_tempat r
            LEFT JOIN tempat_nongkrong t 
                ON t.id = r.tempat_id
            ORDER BY r.created_at DESC
            LIMIT 5
        ")->getResultArray();

        return view('admin/dashboard', [
            'stats'            => $stats,
            'totalKat'         => $totalKategori['total'] ?? 0,
            'totalReview'      => $totalReview['total'] ?? 0,
            'perKategori'      => $perKategori,
            'distribusiRating' => $distribusiRating,
            'fasilitas'        => $fasilitas,
            'radiusStats'      => $radiusStats,
            'recentTempat'     => $recentTempat,
            'recentReview'     => $recentReview,
            'pageTitle'        => 'Dashboard',
        ]);
    }
}