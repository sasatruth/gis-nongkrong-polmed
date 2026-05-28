<?php

namespace App\Models;

use CodeIgniter\Model;

class TempatModel extends Model
{
    protected $table      = 'tempat_nongkrong';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'nama', 'deskripsi', 'alamat', 'no_telepon', 'instagram',
        'jam_buka', 'jam_tutup', 'harga_min', 'harga_max',
        'rating', 'total_review', 'wifi', 'parkir', 'outdoor',
        'foto_url', 'kategori_id', 'geom', 'is_active',
        'colokan', 'ac', 'mushola', 'tempat_tenang',
        'cocok_nugas', 'cocok_rame'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Ambil semua tempat + nama kategori (JOIN)
    public function getAllWithKategori()
    {
        $db = \Config\Database::connect();
        return $db->query("
            SELECT
                t.id,
                t.nama,
                t.alamat,
                t.rating,
                t.harga_min,
                t.harga_max,
                t.wifi,
                t.parkir,
                t.outdoor,
                t.colokan,
                t.ac,
                t.mushola,
                t.tempat_tenang,
                t.cocok_nugas,
                t.cocok_rame,
                t.foto_url,
                t.jam_buka,
                t.jam_tutup,
                t.is_active,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ST_X(t.geom::geometry) AS longitude,
                ST_Y(t.geom::geometry) AS latitude
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON t.kategori_id = k.id
            WHERE t.is_active = true
        ")->getResultArray();
    }

    // Ambil tempat dalam radius X meter dari titik lon/lat
    public function getNearby($longitude, $latitude, $radius = 1000)
    {
        $db = \Config\Database::connect();
        return $db->query("
            SELECT
                t.id,
                t.nama,
                t.alamat,
                t.rating,
                t.harga_min,
                t.harga_max,
                t.wifi,
                t.parkir,
                t.foto_url,
                t.cocok_nugas,
                t.cocok_rame,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ST_X(t.geom::geometry) AS longitude,
                ST_Y(t.geom::geometry) AS latitude,
                ST_Distance(
                    t.geom,
                    ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography
                ) AS jarak_meter
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON t.kategori_id = k.id
            WHERE t.is_active = true
            AND ST_DWithin(
                t.geom,
                ST_SetSRID(ST_MakePoint(?, ?), 4326)::geography,
                ?
            )
            ORDER BY jarak_meter ASC
        ", [$longitude, $latitude, $longitude, $latitude, $radius])->getResultArray();
    }

    // Ambil detail 1 tempat by ID
    public function getDetail($id)
    {
        $db = \Config\Database::connect();
        return $db->query("
            SELECT
                t.*,
                k.nama AS kategori,
                k.icon AS kategori_icon,
                ST_X(t.geom::geometry) AS longitude,
                ST_Y(t.geom::geometry) AS latitude
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON t.kategori_id = k.id
            WHERE t.id = ?
        ", [$id])->getRow();
    }
}