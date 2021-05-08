<?php

namespace App\Controllers;

use App\Models\Faculty;
use App\Models\Major;

class UniversityController extends BaseController
{

    public function show_create_faculty_major()
    {
        $faculties = (new Faculty())->asObject()->findAll();
        return view('more_features/form_create_faculty_major', [
            'faculties' => $faculties,
        ]);
    }

    public function store_faculty()
    {
        $rules = [
            'faculty' => 'required|string|min_length[3]|max_length[50]',
        ];
        $messages = [
            'faculty' => [
                'required' => 'Field fakultas tidak boleh kosong',
                'string' => 'Field fakultas harus berupa string',
                'min_length' => 'Field fakultas minimal berisi 3 karakter',
                'max_length' => 'Field fakultas maximal berisi 50 karakter',
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validator', $this->validator);
            return redirect()->back();
        }

        $data = [
            'faculty' => $this->request->getVar('faculty'),
        ];

        $saved = (new Faculty())->save($data);

        if (!$saved) {
            session()->setFlashdata('msg', "Gagal menambahkan fakultas, silahkan coba lagi dalam beberapa saat!");
            return redirect()->back();
        }

        session()->setFlashdata('success', "Berhasil menambahkan fakultas!");
        return redirect()->back();
    }

    public function store_major()
    {
        $rules = [
            'major' => 'required|string|min_length[3]|max_length[50]',
            'faculty_id' => 'required|integer|is_not_unique[faculties.id]',
        ];

        $messages = [
            'major' => [
                'required' => 'Field jurusan tidak boleh kosong',
                'string' => 'Field jurusan harus berupa string',
                'min_length' => 'Field jurusan minimal berisi 3 karakter',
                'max_length' => 'Field jurusan maximal berisi 50 karakter',
            ],
            'faculty_id' => [
                'required' => 'Fakultas tidak boleh kosong',
                'integer' => 'Field fakultas hanya boleh berisi integer',
                'is_not_unique' => 'Fakultas tidak ditemukan',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validator', $this->validator);
            return redirect()->back();
        }

        $data = [
            'major' => $this->request->getVar('major'),
            'faculty_id' => $this->request->getVar('faculty_id'),
        ];


        $saved = (new Major())->save($data);

        if (!$saved) {
            session()->setFlashdata('msg', "Gagal menambahkan jurusan, silahkan coba lagi dalam beberapa saat!");
            return redirect()->back();
        }

        session()->setFlashdata('success', "Berhasil menambahkan jurusan!");
        return redirect()->back();
    }

    public function show()
    {
        $faculties = (new Faculty())->asObject()->orderBy('faculty', 'ASC')->findAll();
        $majors = (new Major())->faculty()->asObject()->orderBy('faculty', 'ASC')->orderBy('major', 'ASC')->findAll();

        return view('more_features/daftar_fakultas_dan_jurusan', [
            'faculties' => $faculties,
            'majors' => $majors,
        ]);
    }

    public function update_faculty($id)
    {
        $rules = [
            'faculty' => 'required|string|min_length[3]|max_length[50]',
        ];
        $messages = [
            'faculty' => [
                'required' => 'Field fakultas tidak boleh kosong',
                'string' => 'Field fakultas harus berupa string',
                'min_length' => 'Field fakultas minimal berisi 3 karakter',
                'max_length' => 'Field fakultas maximal berisi 50 karakter',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validation', $this->validator->getErrors());
            return redirect()->back();
        }

        $updated = (new Faculty())->update($id, [
            'faculty' => $this->request->getVar('faculty'),
        ]);

        if (!$updated) {
            session()->setFlashdata('msg', 'Gagal memperbarui data, silahkan coba lagi!');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil memperbarui data');
        return redirect()->back();

    }

    public function delete_faculty($id)
    {
        $deleted = (new Faculty())->delete($id);

        if (!$deleted) {
            session()->setFlashdata('msg', 'Gagal menghapus data, silahkan coba lagi dalam beberapa saat!');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menghapus data!');
        return redirect()->back();

    }

    public function update_major($id)
    {
        $rules = [
            'major' => 'required|string|min_length[3]|max_length[50]',
            'faculty_id' => 'required|integer|is_not_unique[faculties.id]',
        ];

        $messages = [
            'major' => [
                'required' => 'Field jurusan tidak boleh kosong',
                'string' => 'Field jurusan harus berupa string',
                'min_length' => 'Field jurusan minimal berisi 3 karakter',
                'max_length' => 'Field jurusan maximal berisi 50 karakter',
            ],
            'faculty_id' => [
                'required' => 'Fakultas tidak boleh kosong',
                'integer' => 'Field fakultas hanya boleh berisi integer',
                'is_not_unique' => 'Fakultas tidak ditemukan',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validation', $this->validator->getErrors());
            return redirect()->back();
        }

        $data = [
            'major' => $this->request->getVar('major'),
            'faculty_id' => $this->request->getVar('faculty_id'),
        ];


        $updated = (new Major())->update($id, $data);

        if (!$updated) {
            session()->setFlashdata('msg', "Gagal memperbarui data, silahkan coba lagi dalam beberapa saat!");
            return redirect()->back();
        }

        session()->setFlashdata('success', "Berhasil menambahkan data!");
        return redirect()->back();

    }

    public function delete_major($id)
    {
        $deleted = (new Major())->delete($id);

        if (!$deleted) {
            session()->setFlashdata('msg', 'Gagal menghapus data, silahkan coba lagi dalam beberapa saat!');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menghapus data!');
        return redirect()->back();
    }

}
