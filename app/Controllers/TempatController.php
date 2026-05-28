<?php

namespace App\Controllers;

use App\Models\ReviewModel;

class TempatController extends BaseController
{
    private float $polmedLng = 98.6549;
    private float $polmedLat = 3.5666;

    public function detail($id)
    {
        $db = \Config\Database::connect();

        // ── Detail tempat ────────────────────────────────────────
        $tempat = $db->query("
            SELECT
                t.*,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ST_X(t.geom::geometry) AS longitude,
                ST_Y(t.geom::geometry) AS latitude,
                ROUND(
                    ST_Distance(
                        t.geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                    )
                ) AS jarak_meter
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON t.kategori_id = k.id
            WHERE t.id = ? 
              AND t.is_active = true
            LIMIT 1
        ", [
            $this->polmedLng,
            $this->polmedLat,
            $id
        ])->getRowArray();

        if (!$tempat) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(
                'Tempat tidak ditemukan.'
            );
        }

        // ── Review tempat ────────────────────────────────────────
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->getByTempat($id);

        // ── Tempat serupa ────────────────────────────────────────
        $serupa = $db->query("
            SELECT
                t.id,
                t.nama,
                t.alamat,
                t.rating,
                t.harga_min,
                t.harga_max,
                t.foto_url,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ROUND(
                    ST_Distance(
                        t.geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                    )
                ) AS jarak_meter
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON t.kategori_id = k.id
            WHERE t.is_active = true
              AND t.id != ?
              AND t.kategori_id = ?
            ORDER BY jarak_meter ASC, t.rating DESC NULLS LAST
            LIMIT 4
        ", [
            $this->polmedLng,
            $this->polmedLat,
            $id,
            $tempat['kategori_id']
        ])->getResultArray();

        return view('tempat/detail', [
            'tempat'  => $tempat,
            'reviews' => $reviews,
            'serupa'  => $serupa,
        ]);
    }
}