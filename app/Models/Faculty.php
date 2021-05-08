<?php

namespace App\Models;

use CodeIgniter\Model;

class Faculty extends Model
{
    protected $table = "faculties";
    protected $allowedFields = ['faculty'];

    protected $validationRules = [
        'faculty' => 'required|string|max_length[255]',
    ];

    protected $validationMessages = [
        'faculty' => [
            'required' => 'Nama Fakultas tidak boleh kosong',
            'max_length' => 'Field Fakultas maximal berisi 255 karakter',
        ],
    ];

    public function users(): Relation\HasMany
    {
        return $this->hasMany('users', \App\Models\User::class, 'faculty_id', 'id');
    }

    public function majors(): Relation\HasMany
    {
        return $this->hasMany('majors', \App\Models\Major::class, 'faculty_id', 'id');
    }

    public function labs(): Relation\HasMany
    {
        return $this->hasMany('labs', \App\Models\LabModel::class, 'faculty_id', 'id');
    }

    public function tools(): Relation\HasMany
    {
        return $this->hasMany('tools', \App\Models\ToolModel::class, 'faculty_id', 'id');
    }
}