<?php


namespace App\Entities;


use CodeIgniter\Entity;

class Book extends Entity
{

    protected $casts = [
        'stock' => 'integer',
    ];

    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function getStatusString(): string
    {
        return $this->attributes['stock'] <= 0 ? 'Tidak tersedia' : 'Tersedia';
    }

}