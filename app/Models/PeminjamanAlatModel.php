<?php

namespace App\Models;


use CodeIgniter\Model;

class PeminjamanAlatModel extends Model
{
    protected $table = "peminjaman_alat";
    protected $allowedFields = ['tools_id', 'user_nim', 'status', 'dipinjam_pada', 'dikembalikan_pada', 'dikonfirmasi_oada'];

    protected $validationRules = [
        'tools_id' => 'required|integer|is_not_unique[tools.id]',
        'user_nim' => 'required|string|is_not_unique[users.nim]',
        'status' => 'required|in_list[0,1,2]',
    ];

    protected $validationMessages = [
        'tools_id' => [
            'required' => 'Alat tidak boleh kosong',
            'is_not_unique' => 'Alat tidak ditemukan',
        ],
        'user_nim' => [
            'required' => 'User tidak boleh kosong',
            'is_not_unique' => 'User tidak ditemukan',
        ],
        'status' => [
            'in_list' => 'Status tidak valid',
        ],
    ];

    public function tool(): PeminjamanAlatModel
    {
        return $this->join('tools', 'peminjaman_alat.tools_id = tools.id', 'right')
            // Get Faculty
            ->join('faculties as f', 'tools.faculty_id = f.id', 'inner')
            // Get Major -> left Join because major can be null
            ->join('majors as m', 'm.id = tools.major_id', 'left')
            ->select('peminjaman_alat.*, tools.name, tools.stock, f.faculty, m.major');
    }

    public function user(): PeminjamanAlatModel
    {
        return $this->select('users.name as user_name, users.email as user_email, users.address as user_address, 
        users.gender as user_gender, peminjaman_alat.*, fu.faculty as user_faculty, mu.major as user_major')
            ->join('users', 'users.nim = peminjaman_alat.user_nim AND users.role = \'0\'', 'inner')
            ->join('faculties as fu', 'users.faculty_id = fu.id', 'left')
            ->join('majors as mu', 'users.major_id = mu.id', 'left');
    }
}