<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class TempatAdminController extends BaseController
{
    private function guard()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }
        return null;
    }

    public function index()
    {
        if ($r = $this->guard()) return $r;

        $db     = \Config\Database::connect();
        $search = $this->request->getGet('q') ?? '';
        $katId  = $this->request->getGet('kat_id') ?? '';
        $status = $this->request->getGet('status') ?? '';

        $where  = 'WHERE 1=1';
        $params = [];

        if ($search) {
            $where   .= " AND (t.nama ILIKE ? OR t.alamat ILIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        if ($katId) {
            $where   .= " AND t.kategori_id = ?";
            $params[] = (int)$katId;
        }
        if ($status === 'aktif') {
            $where .= " AND t.is_active = true";
        } elseif ($status === 'nonaktif') {
            $where .= " AND t.is_active = false";
        }

        $tempat = $db->query("
            SELECT t.id, t.nama, t.alamat, t.rating,
                   t.harga_min, t.harga_max, t.is_active,
                   t.wifi, t.ac, t.colokan, t.parkir,
                   t.foto_url, t.created_at,
                   k.nama AS kategori, k.icon AS kategori_icon
            FROM tempat_nongkrong t
            LEFT JOIN kategori_tempat k ON t.kategori_id = k.id
            $where
            ORDER BY t.created_at DESC
        ", $params)->getResultArray();

        $kategoriList = $db->query(
            "SELECT id, nama, icon FROM kategori_tempat ORDER BY nama"
        )->getResultArray();

        return view('admin/tempat/index', [
            'tempat'       => $tempat,
            'kategoriList' => $kategoriList,
            'search'       => $search,
            'activeKatId'  => $katId,
            'activeStatus' => $status,
        ]);
    }

    public function create()
    {
        if ($r = $this->guard()) return $r;

        $db           = \Config\Database::connect();
        $kategoriList = $db->query(
            "SELECT id, nama, icon FROM kategori_tempat ORDER BY nama"
        )->getResultArray();

        return view('admin/tempat/form', [
            'tempat'       => null,
            'kategoriList' => $kategoriList,
            'formAction'   => '/admin/tempat/store',
            'pageTitle'    => 'Tambah Tempat',
        ]);
    }

    public function store()
    {
        if ($r = $this->guard()) return $r;

        $db   = \Config\Database::connect();
        $post = $this->request->getPost();

        $bool = fn($k) => isset($post[$k]) && $post[$k] === '1' ? 'true' : 'false';

        $lat = (float)($post['latitude']  ?? 0);
        $lng = (float)($post['longitude'] ?? 0);

        $geomExpr = ($lat && $lng)
            ? "ST_SetSRID(ST_MakePoint($lng, $lat), 4326)::geography"
            : "NULL";

        $db->query("
            INSERT INTO tempat_nongkrong
              (nama, kategori_id, alamat, deskripsi, foto_url,
               harga_min, harga_max, rating,
               jam_buka, jam_tutup, no_telepon, instagram,
               wifi, colokan, ac, parkir, mushola,
               outdoor, tempat_tenang, cocok_nugas, cocok_rame,
               is_active, geom)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,
                    {$bool('wifi')},{$bool('colokan')},{$bool('ac')},
                    {$bool('parkir')},{$bool('mushola')},
                    {$bool('outdoor')},{$bool('tempat_tenang')},
                    {$bool('cocok_nugas')},{$bool('cocok_rame')},
                    {$bool('is_active')},
                    $geomExpr)
        ", [
            $post['nama'],
            $post['kategori_id'] ?: null,
            $post['alamat'],
            $post['deskripsi'],
            $post['foto_url'],
            $post['harga_min'] ?: null,
            $post['harga_max'] ?: null,
            $post['rating']    ?: null,
            $post['jam_buka']  ?: null,
            $post['jam_tutup'] ?: null,
            $post['no_telepon'],
            $post['instagram'],
        ]);

        return redirect()->to('/admin/tempat')
            ->with('success', 'Tempat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if ($r = $this->guard()) return $r;

        $db     = \Config\Database::connect();
        $tempat = $db->query("
            SELECT t.*,
                   ST_X(t.geom::geometry) AS longitude,
                   ST_Y(t.geom::geometry) AS latitude
            FROM tempat_nongkrong t
            WHERE t.id = ?
        ", [$id])->getRowArray();

        if (!$tempat) {
            return redirect()->to('/admin/tempat')
                ->with('error', 'Tempat tidak ditemukan.');
        }

        $kategoriList = $db->query(
            "SELECT id, nama, icon FROM kategori_tempat ORDER BY nama"
        )->getResultArray();

        return view('admin/tempat/form', [
            'tempat'       => $tempat,
            'kategoriList' => $kategoriList,
            'formAction'   => "/admin/tempat/update/$id",
            'pageTitle'    => 'Edit Tempat',
        ]);
    }

    public function update($id)
    {
        if ($r = $this->guard()) return $r;

        $db   = \Config\Database::connect();
        $post = $this->request->getPost();

        $bool = fn($k) => isset($post[$k]) && $post[$k] === '1' ? 'true' : 'false';

        $lat = (float)($post['latitude']  ?? 0);
        $lng = (float)($post['longitude'] ?? 0);

        $geomSet = ($lat && $lng)
            ? ", geom = ST_SetSRID(ST_MakePoint($lng, $lat), 4326)::geography"
            : "";

        $db->query("
            UPDATE tempat_nongkrong SET
                nama          = ?,
                kategori_id   = ?,
                alamat        = ?,
                deskripsi     = ?,
                foto_url      = ?,
                harga_min     = ?,
                harga_max     = ?,
                rating        = ?,
                jam_buka      = ?,
                jam_tutup     = ?,
                no_telepon    = ?,
                instagram     = ?,
                wifi          = {$bool('wifi')},
                colokan       = {$bool('colokan')},
                ac            = {$bool('ac')},
                parkir        = {$bool('parkir')},
                mushola       = {$bool('mushola')},
                outdoor       = {$bool('outdoor')},
                tempat_tenang = {$bool('tempat_tenang')},
                cocok_nugas   = {$bool('cocok_nugas')},
                cocok_rame    = {$bool('cocok_rame')},
                is_active     = {$bool('is_active')}
                $geomSet
            WHERE id = ?
        ", [
            $post['nama'],
            $post['kategori_id'] ?: null,
            $post['alamat'],
            $post['deskripsi'],
            $post['foto_url'],
            $post['harga_min'] ?: null,
            $post['harga_max'] ?: null,
            $post['rating']    ?: null,
            $post['jam_buka']  ?: null,
            $post['jam_tutup'] ?: null,
            $post['no_telepon'],
            $post['instagram'],
            $id,
        ]);

        return redirect()->to('/admin/tempat')
            ->with('success', 'Tempat berhasil diperbarui!');
    }

    public function delete($id)
    {
        if ($r = $this->guard()) return $r;

        $db = \Config\Database::connect();
        $db->query("DELETE FROM tempat_nongkrong WHERE id = ?", [$id]);

        return redirect()->to('/admin/tempat')
            ->with('success', 'Tempat berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        if ($r = $this->guard()) return $r;

        $db = \Config\Database::connect();
        $db->query(
            "UPDATE tempat_nongkrong SET is_active = NOT is_active WHERE id = ?",
            [$id]
        );

        return redirect()->back()
            ->with('success', 'Status berhasil diubah.');
    }
}