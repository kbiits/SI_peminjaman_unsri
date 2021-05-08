<?php

namespace App\Models;


use CodeIgniter\Model;

class User extends Model
{
    protected $table = "users";
    protected $allowedFields = ['nim', 'name', 'email', 'password', 'address', 'faculty_id', 'major_id', 'avatar', 'role', 'gender'];
    protected $primaryKey = 'nim';

    public function faculty(): User
    {
        return $this->join('faculties', 'faculties.id = users.faculty_id', 'left', true);
    }

    public function major(): User
    {
        return $this->join('majors', 'majors.id = users.major_id', 'left', true);
    }

    public function labs(): User
    {
        return $this->join('labs', 'users.nim = labs.user_nim', 'inner', true);
    }

    public function books(): User
    {
        return $this
            ->join('peminjaman_buku', 'users.nim = peminjaman_buku.user_nim', 'inner')
            ->join('books as b', 'b.isbn = peminjaman_buku.book_isbn', 'inner');
    }

    public function tools(): User
    {
        return $this
            ->join('peminjaman_alat as p_a', 'p_a.user_nim = users.nim', 'inner')
            ->join('tools as t', 'p_a.tools_id = t.id', 'inner');
    }
}