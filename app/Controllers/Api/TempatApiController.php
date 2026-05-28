<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TempatModel;

class TempatApiController extends BaseController
{
    private float $polmedLng = 98.6549;
    private float $polmedLat = 3.5666;

    public function markers()
    {
        $db = \Config\Database::connect();

        $data = $db->query("
            SELECT
                t.id, t.nama, t.alamat, t.rating, t.foto_url,
                t.harga_min, t.harga_max,
                t.wifi, t.colokan, t.ac, t.parkir, t.mushola,
                t.tempat_tenang, t.jam_buka, t.jam_tutup,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ST_Y(t.geom::geometry) AS latitude,
                ST_X(t.geom::geometry) AS longitude
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON k.id = t.kategori_id
            WHERE t.is_active = true
        ")->getResultArray();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function nearby()
    {
        $radius = (int) ($this->request->getGet('radius') ?? 1000);
        $lat    = (float) ($this->request->getGet('lat') ?? $this->polmedLat);
        $lng    = (float) ($this->request->getGet('lng') ?? $this->polmedLng);

        if ($radius > 5000) $radius = 5000;
        if ($radius < 100)  $radius = 100;

        $db = \Config\Database::connect();

        $data = $db->query("
            SELECT
                t.id, t.nama, t.alamat, t.rating, t.foto_url,
                t.harga_min, t.harga_max,
                t.wifi, t.colokan, t.ac, t.parkir, t.mushola,
                t.tempat_tenang, t.jam_buka, t.jam_tutup,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ST_Y(t.geom::geometry) AS latitude,
                ST_X(t.geom::geometry) AS longitude,
                ROUND(
                    ST_Distance(
                        t.geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                    )
                ) AS jarak_meter
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON k.id = t.kategori_id
            WHERE t.is_active = true
              AND ST_DWithin(
                    t.geom,
                    ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                    ?
              )
            ORDER BY jarak_meter ASC
        ", [
            $lng, $lat,
            $lng, $lat, $radius
        ])->getResultArray();

        return $this->response->setJSON([
            'status' => true,
            'radius' => $radius,
            'start'  => [
                'lat' => $lat,
                'lng' => $lng,
            ],
            'data'   => $data
        ]);
    }

    public function recommendation()
    {
        $need = $this->request->getGet('need') ?? 'nugas';

        $allowed = ['nugas', 'hemat', 'wifi_colokan', 'tenang', 'rame'];
        if (!in_array($need, $allowed)) {
            $need = 'nugas';
        }

        $db = \Config\Database::connect();

        $extraScore = match ($need) {
            'nugas' => "
                + CASE WHEN wifi THEN 20 ELSE 0 END
                + CASE WHEN colokan THEN 20 ELSE 0 END
                + CASE WHEN tempat_tenang THEN 20 ELSE 0 END
                + CASE WHEN cocok_nugas THEN 20 ELSE 0 END
            ",
            'hemat' => "
                + CASE WHEN harga_min <= 15000 THEN 40 ELSE 0 END
                + CASE WHEN harga_max <= 30000 THEN 20 ELSE 0 END
            ",
            'wifi_colokan' => "
                + CASE WHEN wifi THEN 40 ELSE 0 END
                + CASE WHEN colokan THEN 40 ELSE 0 END
            ",
            'tenang' => "
                + CASE WHEN tempat_tenang THEN 50 ELSE 0 END
                + CASE WHEN cocok_nugas THEN 20 ELSE 0 END
            ",
            'rame' => "
                + CASE WHEN cocok_rame THEN 50 ELSE 0 END
            ",
            default => ""
        };

        $result = $db->query("
            SELECT
                t.id, t.nama, t.alamat, t.rating,
                t.harga_min, t.harga_max,
                t.wifi, t.colokan, t.ac, t.parkir, t.mushola,
                t.tempat_tenang, t.cocok_nugas, t.cocok_rame,
                t.foto_url, t.jam_buka, t.jam_tutup,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ST_X(t.geom::geometry) AS longitude,
                ST_Y(t.geom::geometry) AS latitude,
                ROUND(
                    ST_Distance(
                        t.geom,
                        ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                    )
                ) AS jarak_meter,
                (
                    COALESCE(t.rating, 0) * 20
                    + CASE
                        WHEN ST_Distance(t.geom, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography) <= 500 THEN 30
                        WHEN ST_Distance(t.geom, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography) <= 1000 THEN 20
                        WHEN ST_Distance(t.geom, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography) <= 2000 THEN 10
                        ELSE 5
                      END
                    $extraScore
                ) AS skor_rekomendasi
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON k.id = t.kategori_id
            WHERE t.is_active = true
            ORDER BY skor_rekomendasi DESC
            LIMIT 10
        ", [
            $this->polmedLng, $this->polmedLat,
            $this->polmedLng, $this->polmedLat,
            $this->polmedLng, $this->polmedLat,
            $this->polmedLng, $this->polmedLat,
        ])->getResultArray();

        return $this->response->setJSON([
            'status' => true,
            'need'   => $need,
            'data'   => $result
        ]);
    }

    public function statistik()
    {
        $db = \Config\Database::connect();

        $result = $db->query("
            SELECT
                COUNT(*) FILTER (
                    WHERE ST_DWithin(geom, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography, 500)
                ) AS radius_500m,

                COUNT(*) FILTER (
                    WHERE ST_DWithin(geom, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography, 1000)
                ) AS radius_1km,

                COUNT(*) FILTER (
                    WHERE ST_DWithin(geom, ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography, 2000)
                ) AS radius_2km,

                COUNT(*) AS total_semua,
                ROUND(AVG(harga_min)::numeric, 0) AS rata_harga_min,
                ROUND(AVG(rating)::numeric, 1) AS rata_rating
            FROM tempat_nongkrong
            WHERE is_active = true
        ", [
            $this->polmedLng, $this->polmedLat,
            $this->polmedLng, $this->polmedLat,
            $this->polmedLng, $this->polmedLat,
        ])->getRowArray();

        return $this->response->setJSON([
            'status' => true,
            'data'   => $result
        ]);
    }
}