<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Redirect implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        } else {
            if (session()->get('role') === 'admin' && session()->has('just_logged_in')) {
                session()->remove('just_logged_in');
                return redirect()->to('/produk');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu isi apa-apa
    }
}
