<?php

namespace App\Models;

use CodeIgniter\Model;

class LabModel extends Model
{
    protected $table = "labs";
    protected $allowedFields = ['name', 'faculty_id', 'major_id', 'user_nim', 'status_lab'];
    protected $returnType = \App\Entities\Lab::class;

    protected $validationRules = [
        'name' => 'required|string|min_length[3]|max_length[50]',
        'faculty_id' => 'required|integer|is_not_unique[faculties.id]',
        'status_lab' => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama Lab tidak boleh kosong',
            'min_length' => 'Field Nama LabModel setidaknya harus berisi 3 karakter',
            'string' => 'Field Nama LabModel harus berisi string',
        ],
        'faculty_id' => [
            'required' => 'Fakultas tidak boleh kosong',
            'integer' => 'Fakultas hanya boleh berisi integer',
            'is_not_unique' => 'Fakultas tidak ditemukan',
        ],
        'status_lab' => [
            'required' => 'Status tidak boleh kosong',
            'in_list' => 'Status invalid',
        ],
    ];

    public function getAllRelations()
    {
        return $this->user()->faculty()->major();
    }

    public function major(): LabModel
    {
        return $this->select('labs.*, majors.major as major')->join('majors', 'majors.id = labs.major_id', 'left');
    }

    public function faculty(): LabModel
    {
        return $this->select('labs.*, faculties.faculty as faculty')->join('faculties', 'faculties.id = labs.faculty_id', 'inner');
    }

    public function jadwal_peminjaman()
    {
        return $this->select('labs.*, peminjaman_lab.jadwal_id, jadwal_lab.tanggal, jadwal_lab.jam_masuk, jadwal_lab.jam_keluar')
            ->join('peminjaman_lab', 'labs.id = peminjaman_lab.lab_id', 'left')
            ->join('jadwal_lab', 'peminjaman_lab.jadwal_id = jadwal_lab.id', 'left');
    }

}