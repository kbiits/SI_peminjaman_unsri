<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    /**
     * @throws \ReflectionException
     */
    public function change_avatar($nim)
    {
        $rules = [
            'avatar' => 'uploaded[avatar]|mime_in[avatar,image/png,image/jpg,image/jpeg]|is_image[avatar]|max_size[avatar,2048]',
        ];
        $messages = [
            'avatar' => [
                'uploaded' => 'Hanya boleh mengupload file',
                'mime_in' => 'Foto harus berformat png, jpg atau jpeg',
                'is_image' => 'File yang diupload harus berupa foto',
                'max_size' => 'Foto hanya boleh berukuran maximal 2MB'
            ],
        ];

        if ($this->validate($rules, $messages)) {
            $type = $this->request->getFile('avatar')->getClientExtension();
            $file = $this->request->getFile('avatar')->getRealPath();
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($file));
            $updated = (new User)->update($nim, [
                'avatar' => $base64,
            ]);
            if (!$updated) {
                session()->setFlashdata('msg', 'Gagal memperbarui avatar, silahkan coba lagi');
                return redirect()->back();
            }

            session()->setFlashdata('success', 'Berhasil memperbarui avatar');
            session()->set('user', (new User())->faculty()->major()->find($nim));
        } else {
            session()->setFlashdata('avatarValidator', $this->validator->getErrors());
        }
        return redirect()->back();
    }

    public function update($nim)
    {
        // Request rules
        $rules = [
            'name' => 'required|alpha_space|max_length[50]',
            'email' => "required|max_length[100]|valid_email|is_unique[users.email,nim,$nim]",
            'address' => 'required|string|max_length[255]',
            'faculty' => 'required|integer|is_not_unique[faculties.id]',
            'major' => 'required|integer|is_not_unique[majors.id]',
            'gender' => 'required|integer|in_list[1,0]',
        ];

        // Validation Messages
        $messages = [
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
            'address' => [
                'required' => 'Field alamat tidak boleh kosong',
                'max_length' => 'Field alamat tidak boleh lebih dari 255 karakter',
            ],
            'faculty' => [
                'required' => 'Field fakultas tidak boleh kosong',
                'integer' => 'Field fakultas hanya boleh berisi integer',
                'is_not_unique' => 'Fakultas tidak ditemukan',
            ],
            'major' => [
                'required' => 'Field jurusan tidak boleh kosong',
                'integer' => 'Field major hanya boleh berisi integer',
                'is_not_unique' => 'Jurusan tidak ditemukan',
            ],
            'gender' => [
                'required' => 'Field jenis kelamin tidak boleh kosong',
                'integer' => 'Jenis kelamin tidak valid',
                'in_list' => 'Jenis kelamin tidak valid',
            ],
        ];

        if ($this->validate($rules, $messages)) {
            $data = [
                'name' => $this->request->getVar('name'),
                'email' => $this->request->getVar('email'),
                'address' => $this->request->getVar('address'),
                'faculty_id' => $this->request->getVar('faculty'),
                'major_id' => $this->request->getVar('major'),
                'gender' => $this->request->getVar('gender'),
            ];
            $updated = (new User())->update($nim, $data);
            if (!$updated) {
                session()->setFlashdata('msg', 'Gagal memperbarui data anda, silahkan coba lagi dalam beberapa saat!');
                return redirect()->back()->withInput();
            }
            session()->setFlashdata('success', 'Berhasil memperbarui data anda!');
            session()->set('user', (new User())->faculty()->major()->find($nim));
            return redirect()->back();
        }
        session()->setFlashdata('validator', $this->validator);
        return redirect()->back()->withInput();
    }

    public function show_add_admin()
    {
        return view('more_features/form_create_admin');
    }

    public function store_admin()
    {
        $rules = [
            'nim' => 'required|integer|min_length[14]|max_length[20]|is_unique[users.nim]',
            'name' => 'required|alpha_space|max_length[50]',
            'email' => 'required|max_length[100]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]|max_length[100]',
            'password_confirm' => 'matches[password]',
            'address' => 'required|string|max_length[255]',
            'gender' => 'required|integer|in_list[1,0]',
        ];

        // Validation Messages
        $messages = [
            'nim' => [
                'required' => 'Field NIM tidak boleh kosong',
                'integer' => 'NIM hanya boleh berisi angka',
                'exact_length' => 'NIM harus berisi 14 karakter',
                'min_length' => 'No identitas harus berisi paling sedikit 14 karakter',
                'max_length' => 'No identitas harus berisi paling banyak 20 karakter',
                'is_unique' => 'Nim anda telah terdaftar, silahkan login atau reset password anda jika anda lupa password',
            ],
            'name' => [
                'required' => 'Field nama tidak boleh kosong',
                'alpha_space' => 'Field nama hanya boleh berisi huruf dan spasi',
                'max_length' => 'Field nama hanya boleh berisi hingga 50 karakter (Termasuk spasi)',
            ],
            'email' => [
                'required' => 'Email tidak boleh kosong',
                'valid_email' => 'Email tidak valid',
                'is_unique' => 'Email anda telah terdaftar, silahkan login atau reset password anda jika anda lupa password',
                'max_length' => 'Email tidak boleh lebih dari 100 karakter',
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
            'gender' => [
                'required' => 'Field jenis kelamin tidak boleh kosong',
                'integer' => 'Jenis kelamin tidak valid',
                'in_list' => 'Jenis kelamin tidak valid',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validator', $this->validator);
            return redirect()->back();
        }

        $user = new User();
        $data = [
            'nim' => $this->request->getVar('nim'),
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'address' => $this->request->getVar('address'),
            'gender' => $this->request->getVar('gender'),
            'role' => '1',
        ];

        $saved = $user->db->table('users')->insert($data, true);
        if (!$saved->resultID) {
            session()->setFlashdata('msg', 'Gagal menambahkan admin, silahkan coba lagi!');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menambahkan admin!');
        return redirect()->back();

    }
}
