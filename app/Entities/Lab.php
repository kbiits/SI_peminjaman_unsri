<?php


namespace App\Entities;


use CodeIgniter\Entity;

class Lab extends Entity
{

    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    public function getStatusString()
    {
        $status = $this->attributes['status'];
        $result = "";
        if ($status == 0) {
            $result = "Tersedia";
        } else if ($status == 1) {
            $result = "Sedang dipakai";
        } else {
            $result = "Maintenance";
        }
        return $result;
    }

}