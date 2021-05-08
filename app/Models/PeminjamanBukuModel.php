<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanBukuModel extends Model
{
    protected $table = "peminjaman_buku";
    protected $allowedFields = ['book_isbn', 'user_nim', 'status', 'dipinjam_pada', 'dikembalikan_pada', 'dikonfirmasi_pada'];
    protected $returnType = \App\Entities\PeminjamanBuku::class;

    protected $validationRules = [
        'book_isbn' => 'required|string|is_not_unique[books.isbn]',
        'user_nim' => 'required|string|is_not_unique[users.nim]',
        'status' => 'required|integer|in_list[0,1]'
    ];

    protected $validationMessages = [
        'book_isbn' => [
            'required' => 'ISBN boleh kosong',
            'is_not_unique' => 'Buku tidak ditemukan',
        ],
        'user_nim' => [
            'required' => 'User tidak boleh kosong',
            'is_not_unique' => 'User tidak ditemukan',
        ],
    ];

    public function book(): PeminjamanBukuModel
    {
        return $this->select('b.isbn, b.category, b.title, b.stock as book_stock, peminjaman_buku.*')->join('books as b', 'peminjaman_buku.book_isbn = b.isbn', 'inner');
    }

    public function user(): PeminjamanBukuModel
    {
        return $this->select('users.name as user_name, users.email as user_email, users.address as user_address, 
        users.gender as user_gender, peminjaman_buku.*, fu.faculty as user_faculty, mu.major as user_major')
            ->join('users', 'users.nim = peminjaman_buku.user_nim AND users.role = \'0\'', 'inner')
            ->join('faculties as fu', 'users.faculty_id = fu.id', 'left')
            ->join('majors as mu', 'users.major_id = mu.id', 'left');
    }


}