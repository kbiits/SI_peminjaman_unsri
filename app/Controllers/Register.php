<?php

namespace App\Controllers;

use App\Models\Faculty;
use App\Models\Major;
use App\Models\User;

class Register extends BaseController
{
    /**
     * Display Registration Form
     *
     * @return string
     */
    public function index()
    {
        $faculties = (new Faculty())->asObject()->findAll();
        $majors = (new Major())->asObject()->findAll();
        $data = [
            'faculties' => $faculties,
            'majors' => $majors,
        ];
        return view('auth/register', $data);
    }

    /**
     * @throws \ReflectionException
     */
    public function save()
    {
        // Request rules
        $rules = [
            'nim' => 'required|integer|exact_length[14]|is_unique[users.nim]',
            'name' => 'required|alpha_space|max_length[50]',
            'email' => 'required|max_length[100]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]|max_length[100]',
            'password_confirm' => 'matches[password]',
            'address' => 'required|string|max_length[255]',
            'faculty_id' => 'required|integer|is_not_unique[faculties.id]',
            'major_id' => 'required|integer|is_not_unique[majors.id]',
            'gender' => 'required|integer|in_list[1,0]',
            'role' => 'permit_empty|integer|in_list[0]',
        ];

        // Validation Messages
        $messages = [
            'nim' => [
                'required' => 'Field NIM tidak boleh kosong',
                'integer' => 'NIM hanya boleh berisi angka',
                'exact_length' => 'NIM harus berisi 14 karakter',
                'is_unique' => 'Nim anda telah terdaftar, silahkan login atau reset password anda jika anda lupa password',
            ],
            'name' => [
                'required' => 'Field nama tidak boleh kosong',
                'alpha_space' => 'Field nama hanya boleh berisi huruf dan spasi',
                'max_length' => 'Field nama hanya boleh berisi hingga 50 karakter (Termasuk spasi)',
            ],
            'email' => [
                'required' => 'Field email tidak boleh kosong',
                'valid_email' => 'Email tidak valid',
                'is_unique' => 'Email anda telah terdaftar, silahkan login atau reset password anda jika anda lupa password',
                'max_length' => 'Field email tidak boleh lebih dari 100 karakter',
            ],
            'password' => [
                'required' => 'Field password tidak boleh kosong',
                'min_length' => 'Field password setidaknya harus berisi 6 karakter',
                'max_length' => 'Field password tidak boleh lebih dari 100 karakter',
            ],
            'password_confirm' => [
                'matches' => 'Password yang dimasukkan tidak sama',
            ],
            'address' => [
                'required' => 'Field alamat tidak boleh kosong',
                'max_length' => 'Field alamat tidak boleh lebih dari 255 karakter',
            ],
            'faculty_id' => [
                'required' => 'Field fakultas tidak boleh kosong',
                'integer' => 'Field fakultas hanya boleh berisi integer',
                'is_not_unique' => 'Fakultas tidak ditemukan',
            ],
            'major_id' => [
                'required' => 'Field jurusan tidak boleh kosong',
                'integer' => 'Field major hanya boleh berisi integer',
                'is_not_unique' => 'Jurusan tidak ditemukan',
            ],
            'gender' => [
                'required' => 'Field jenis kelamin tidak boleh kosong',
                'integer' => 'Jenis kelamin tidak valid',
                'in_list' => 'Jenis kelamin tidak valid',
            ],
            'role' => [
                'integer' => 'Field role tidak valid',
                'in_list' => 'Field role tidak valid',
            ],
        ];

        if ($this->validate($rules, $messages)) {
            $user = new User();
            $data = [
                'nim' => $this->request->getVar('nim'),
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                'address' => $this->request->getVar('address'),
                'faculty_id' => $this->request->getVar('faculty'),
                'major_id' => $this->request->getVar('major'),
                'gender' => $this->request->getVar('gender'),
                'role' => '0',
            ];

            $saved = $user->db->table('users')->insert($data, true);
            if ($saved->resultID)
                return redirect()->to('/login');
        } else {
            session()->setFlashdata('validator', $this->validator);
        }
        return redirect()->back()->withInput();
    }
}
