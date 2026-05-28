<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    private float $polmedLng = 98.6549;
    private float $polmedLat = 3.5666;

    public function index()
    {
        $db = \Config\Database::connect();

        // ── Input dari URL ───────────────────────────────────────
        $sort  = $this->request->getGet('sort')   ?? 'rating';
        $katId = $this->request->getGet('kat_id') ?? '';   // '' = semua

        // Whitelist sort
        $orderBy = match ($sort) {
            'terdekat' => 'jarak_meter ASC',
            'hemat'    => 't.harga_min ASC NULLS LAST, jarak_meter ASC',
            default    => 't.rating DESC NULLS LAST, jarak_meter ASC',
        };
        $sort = in_array($sort, ['rating','terdekat','hemat']) ? $sort : 'rating';

        // ── 1. Insight chips ─────────────────────────────────────
        $stats = $db->query("
            SELECT
                COUNT(*) AS total_semua,
                COUNT(*) FILTER (
                    WHERE ST_DWithin(geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography, 1000)
                ) AS radius_1km,
                ROUND(AVG(rating)::numeric, 1)    AS rata_rating,
                ROUND(AVG(harga_min)::numeric, 0) AS rata_harga_min
            FROM tempat_nongkrong
            WHERE is_active = true
        ", [$this->polmedLng, $this->polmedLat])->getRowArray();

        // ── 2. Kategori untuk filter pill ───────────────────────
        $kategoriList = $db->query("
            SELECT k.id, k.nama, k.icon, COUNT(t.id) AS jumlah
            FROM kategori_tempat k
            LEFT JOIN tempat_nongkrong t
                   ON t.kategori_id = k.id AND t.is_active = true
            GROUP BY k.id, k.nama, k.icon
            ORDER BY jumlah DESC
        ")->getResultArray();

        // ── 3. Grid tempat — filter + sort server-side ───────────
        $katWhere  = $katId !== '' ? 'AND t.kategori_id = ?' : '';
        $bindings  = [$this->polmedLng, $this->polmedLat];
        if ($katId !== '') $bindings[] = (int)$katId;

        $semuaTempat = $db->query("
            SELECT
                t.id, t.nama, t.alamat, t.rating,
                t.harga_min, t.harga_max,
                t.wifi, t.colokan, t.ac, t.parkir,
                t.outdoor, t.tempat_tenang,
                t.cocok_nugas, t.cocok_rame,
                t.foto_url, t.jam_buka, t.jam_tutup,
                k.id   AS kategori_id,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ROUND(
                    ST_Distance(t.geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography)
                ) AS jarak_meter
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON t.kategori_id = k.id
            WHERE t.is_active = true $katWhere
            ORDER BY $orderBy
        ", $bindings)->getResultArray();

        // ── 4. Rekomendasi cepat (skor rating + jarak) ──────────
        $rekomendasiCepat = $db->query("
            SELECT
                t.id, t.nama, t.alamat, t.rating,
                t.harga_min, t.harga_max,
                t.wifi, t.colokan, t.parkir,
                t.foto_url, t.jam_buka, t.jam_tutup,
                k.nama AS kategori, k.icon AS kategori_icon,
                ROUND(
                    ST_Distance(t.geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography)
                ) AS jarak_meter
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON t.kategori_id = k.id
            WHERE t.is_active = true
            ORDER BY (
                COALESCE(t.rating, 0) * 20
                + CASE
                    WHEN ST_Distance(t.geom, ST_SetSRID(ST_MakePoint(?,?),4326)::geography) <= 500  THEN 30
                    WHEN ST_Distance(t.geom, ST_SetSRID(ST_MakePoint(?,?),4326)::geography) <= 1000 THEN 20
                    ELSE 10
                  END
            ) DESC
            LIMIT 4
        ", [
            $this->polmedLng, $this->polmedLat,
            $this->polmedLng, $this->polmedLat,
            $this->polmedLng, $this->polmedLat,
        ])->getResultArray();

        return view('home', [
            'stats'            => $stats,
            'kategoriList'     => $kategoriList,
            'semuaTempat'      => $semuaTempat,
            'rekomendasiCepat' => $rekomendasiCepat,
            'sort'             => $sort,
            'activeKatId'      => $katId,
        ]);
    }
}