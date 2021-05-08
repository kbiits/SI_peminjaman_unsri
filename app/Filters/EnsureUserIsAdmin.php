<?php


namespace App\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class EnsureUserIsAdmin implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('user')) {
            return redirect()->to('/login');
        }

        // User not an admin, redirect to dashboard
        if (session('user')['role'] != '1') {
            session()->setFlashdata('msg', 'Maaf, anda tidak memiliki hak untuk melakukan aksi tersebut');
            return redirect()->back('/');
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.

    }
}