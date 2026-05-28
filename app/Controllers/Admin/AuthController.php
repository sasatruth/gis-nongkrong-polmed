<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }

        return view('admin/login');
    }

    public function process()
    {
        $db = \Config\Database::connect();

        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        $admin = $db->query(
            "SELECT * FROM admin_users 
             WHERE username = ? 
             AND is_active = true 
             LIMIT 1",
            [$username]
        )->getRowArray();

        // Login tanpa hash password
        if ($admin && $password === $admin['password_hash']) {

            $db->query(
                "UPDATE admin_users 
                 SET last_login = NOW() 
                 WHERE id = ?",
                [$admin['id']]
            );

            session()->set([
                'admin_logged_in' => true,
                'admin_id'        => $admin['id'],
                'admin_username'  => $admin['username'],
                'admin_nama'      => $admin['nama_lengkap'],
            ]);

            return redirect()->to('/admin');
        }

        return redirect()->back()
            ->with('error', 'Username atau password salah.')
            ->withInput();
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/admin/login');
    }
}