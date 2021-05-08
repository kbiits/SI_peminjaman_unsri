<?php


namespace App\Controllers;

class Pinjaman extends BaseController
{
    public function index()
    {
        return view('pinjaman/show_pinjaman');
    }
}
