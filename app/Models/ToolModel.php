<?php

namespace App\Models;

use CodeIgniter\Model;

class ToolModel extends Model
{
    protected $table = "tools";
    protected $allowedFields = ['name', 'faculty_id', 'major_id', 'stock'];
    protected $returnType = \App\Entities\Tool::class;

    protected $validationRules = [
        'name' => 'required|string|min_length[3]',
        'faculty_id' => 'required|integer|is_not_unique[faculties.id]',
        'stock' => 'integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama Alat tidak boleh kosong',
            'min_length' => 'Nama Alat setidaknya harus berisi 3 karakter',
            'string' => 'Nama Alata harus berisi string',
        ],
        'faculty_id' => [
            'required' => 'Fakultas tidak boleh kosong',
            'integer' => 'Fakultas hanya boleh berisi integer',
        ],
        'major_id' => [
            'required' => 'Jurusan tidak boleh kosong',
            'integer' => 'Jurusan hanya boleh berisi integer',
        ],
        'stock' => [
            'integer' => 'Stock harus berisi angka',
            'greater_than_equal_to' => 'Stock tidak boleh kurang dari 0',
        ],
    ];

    public function faculty(): ToolModel
    {
        return $this->select('tools.*, faculties.faculty,')->join('faculties', 'faculties.id = tools.faculty_id', 'inner');
    }

    public function major(): ToolModel
    {
        return $this->select('tools.*, majors.major')->join('majors', 'majors.id = tools.major_id', 'left');
    }
}