<?php

namespace App\Models;

use CodeIgniter\Model;

class Major extends Model
{
    protected $table = "majors";
    protected $allowedFields = ['major', 'faculty_id'];

    protected $validationRules = [
        'major' => 'required|string|min_length[3]|max_length[255]',
        'faculty_id' => 'required|integer|is_not_unique[faculties.id]',
    ];

    protected $validationMessages = [
        'major' => [
            'required' => 'Jurusan tidak boleh kosong',
            'min_length' => 'Field Jurusan setidaknya berisi 3 karakter',
            'max_length' => 'Field Jurusan maximal berisi 255 karakter',
        ],
        'faculty_id' => [
            'required' => 'Fakultas tidak boleh kosong',
            'integer' => 'Field fakultas hanya boleh berisi integer',
            'is_not_unique' => 'Fakultas tidak ditemukan',
        ],
    ];

    public function faculty(): Major
    {
        return $this->select('faculties.faculty, majors.*')->join('faculties', 'majors.faculty_id = faculties.id', 'inner');
    }

}