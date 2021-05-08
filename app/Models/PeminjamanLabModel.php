<?php

namespace App\Models;


use CodeIgniter\Model;

class PeminjamanLabModel extends Model
{
    protected $table = "peminjaman_lab";
    protected $allowedFields = ['lab_id', 'user_nim', 'jadwal_id'];

    protected $validationRules = [
        'lab_id' => 'required|integer|is_not_unique[labs.id]',
        'user_nim' => 'required|string|is_not_unique[users.nim]',
        'jadwal_id' => 'required|integer|is_not_unique[jadwal_lab.id]',
    ];

    protected $validationMessages = [
        'lab_id' => [
            'required' => 'Lab tidak boleh kosong',
            'is_not_unique' => 'Lab tidak ditemukan',
        ],
        'user_nim' => [
            'required' => 'User tidak boleh kosong',
            'is_not_unique' => 'User tidak ditemukan',
        ],
        'jadwal_id' => [
            'required' => 'Jadwal tidak boleh kosong',
            'is_not_unique' => 'Jadwal tidak ditemukan',
        ],
    ];

    public function lab(): PeminjamanLabModel
    {
        return $this->join('labs', 'peminjaman_lab.lab_id = labs.id', 'innner')
            // Get Faculty
            ->join('faculties as f', 'labs.faculty_id = f.id', 'inner')
            // Get Major -> left Join because major can be null
            ->join('majors as m', 'm.id = labs.major_id', 'left')
            ->select('peminjaman_lab.id, labs.name, f.faculty, m.major');
    }

    public function user(): PeminjamanLabModel
    {
        return $this->select('users.name as user_name, users.email as user_email, users.address as user_address, 
        users.gender as user_gender, fu.faculty as user_faculty, mu.major as user_major')
            ->join('users', 'users.role = \'0\' AND users.nim = peminjaman_lab.user_nim', 'inner')
            ->join('faculties as fu', 'users.faculty_id = fu.id', 'inner')
            ->join('majors as mu', 'mu.id = users.major_id', 'inner');
    }

    public function jadwal(): PeminjamanLabModel
    {
        return $this
            ->join('jadwal_lab', 'jadwal_lab.id = peminjaman_lab.jadwal_id')
            ->select('jadwal_lab.tanggal, jadwal_lab.jam_masuk, jadwal_lab.jam_keluar, peminjaman_lab.*');
    }
}