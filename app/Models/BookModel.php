<?php

namespace App\Models;


use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = "books";
    protected $allowedFields = ['isbn', 'title', 'category', 'stock'];
    protected $returnType = \App\Entities\Book::class;
    protected $primaryKey = 'isbn';

    protected $validationRules = [
        'isbn' => 'required|string|min_length[13]|max_length[255]',
        'title' => 'required|string|max_length[255]',
        'category' => 'required|string|max_length[255]',
        'stock' => 'integer',
    ];

    protected $validationMessages = [
        'isbn' => [
            'required' => 'ISBN tidak boleh kosong',
            'min_length' => 'Field isbn setidaknya harus berisi 13 karakter',
            'max_length' => 'Field isbn maximal berisi 255 karakter',
        ],
        'title' => [
            'required' => 'Judul tidak boleh kosong',
            'max_length' => 'Field title maximal berisi 255 karakter',
        ],
        'category' => [
            'required' => 'Kategori tidak boleh kosong',
            'max_length' => 'Field cateogry maximal berisi 255 karakter',
        ],
        'stock' => [
            'integer' => 'Field Stock harus berisi integer',
        ],
    ];

}