<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalLabModel extends Model
{
    protected $table = "jadwal_lab";
    protected $allowedFields = ['tanggal', 'jam_masuk', 'jam_keluar'];

    protected $validationRules = [
        'tanggal' => 'required|valid_date[Y-m-d]',
        'jam_masuk' => 'required|valid_date[H:i]',
        'jam_keluar' => 'required|valid_date[H:i]',
    ];

    protected $validationMessages = [
    ];
}