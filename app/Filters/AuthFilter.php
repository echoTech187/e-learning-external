<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('user_id')) {
            return redirect()->to('/masuk')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Jika ada argument role, cek role user
        if ($arguments !== null) {
            $userRole = session()->get('user_role');
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing after
    }
}
