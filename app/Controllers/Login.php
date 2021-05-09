<?php

namespace App\Controllers;

use App\Models\User;

/**
 * Class Login
 * @package App\Controllers
 */
class Login extends BaseController
{
    /**
     * Show Login Form
     *
     * @return string
     */
    public function index(): string
    {
        return view('auth/login');
    }

    /**
     * Attempt User Login
     *
     */
    public function login(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'email_or_nim' => 'required|string|max_length[100]',
            'password' => 'required|string|max_length[100]',
        ];

        $messages = [
            'email_or_nim' => [
                'required' => 'Harap masukkan email atau nim anda',
                'max_length' => 'Email atau nim tidak boleh lebih dari 100 karakter',
            ],
            'password' => [
                'required' => 'Field password tidak boleh kosong',
                'max_length' => 'Field password tidak boleh lebih dari 100 karakter'
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validator', $this->validator);
            return redirect()->back();
        }

        $data = [
            "email_or_nim" => $this->request->getVar('email_or_nim'),
            "password" => $this->request->getVar('password'),
        ];


        $user = new User();
        $user = $user->faculty()->major()->where('email', $data['email_or_nim'])->orWhere('nim', $data['email_or_nim'])->first();
        if ($user) {
            if (password_verify($data['password'], $user['password'])) {
                session()->set('user', $user);
                return redirect()->to('/');
            }
            session()->setFlashdata('wrong-credentials', 'Password yang anda masukkan salah');
            return redirect()->back();
        }
        session()->setFlashdata('wrong-credentials', 'Email atau NIM tidak ditemukan');
        return redirect()->back();
    }
}
