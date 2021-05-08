<?php

namespace App\Controllers;

use App\Models\Faculty;
use App\Models\Major;
use App\Models\PeminjamanAlatModel;
use App\Models\PeminjamanBukuModel;
use App\Models\PeminjamanLabModel;
use PhpParser\Node\Stmt\Foreach_;

class HomeController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        // If User is Admin
        if (session('user')['role'] == '1') {
            // SQL Injection For Get All Users Data without filter it by nim
            $nim = '1\' OR \'1\' = \'1';
        } else {
            $nim = session('user')['nim'];
        }


        $sql = "SELECT COUNT(pa.dipinjam_pada) AS count_data, \"pa\" AS type, MONTH(pa.dipinjam_pada) AS month FROM peminjaman_alat AS pa WHERE user_nim = '$nim' GROUP BY MONTH(pa.dipinjam_pada)
            UNION ALL
    SELECT COUNT(pb.dipinjam_pada) AS pb_count, \"pb\" AS type, MONTH(pb.dipinjam_pada) AS month FROM peminjaman_buku AS pb WHERE user_nim = '$nim' GROUP BY MONTH(pb.dipinjam_pada)
            UNION ALL
    ( SELECT COUNT(jadwal_lab.tanggal) AS pl_count, \"pl\" AS type, MONTH(jadwal_lab.tanggal) AS month FROM jadwal_lab INNER JOIN peminjaman_lab AS pl ON pl.jadwal_id = jadwal_lab.id WHERE
            pl.user_nim = '$nim' GROUP BY MONTH(jadwal_lab.tanggal)
    )";



        $data = $db->query($sql, null, true)->getResultObject();
        
        $lastMonth = date('n', strtotime('last month'));
        $thisMonth = date('n', strtotime('this month'));
        $persentaseAlat = 0;
        $persentaseBuku = 0;
        $persentaseLab = 0;

        $lastMonthBuku = 0;
        $lastMonthAlat = 0;
        $lastMonthLab = 0;
        $thisMonthBuku = 0;
        $thisMonthAlat = 0;
        $thisMonthLab = 0;
        $newData = [];


        // pa mean peminjaman_alat, pb mean peminjaman_buku, pl mean peminjaman_lab
        foreach ($data as $d) {
            if ($d->type == 'pa' && $d->month == $lastMonth) {
                $lastMonthAlat = (int) $d->count_data;
            }
            if ($d->type == 'pa' && $d->month == $thisMonth) {
                $thisMonthAlat = (int) $d->count_data;
            }

            if ($d->type == 'pb' && $d->month == $lastMonth) {
                $lastMonthBuku = (int) $d->count_data;
            }
            if ($d->type == 'pb' && $d->month == $thisMonth) {
                $thisMonthBuku = (int) $d->count_data;
            }

            if ($d->type == 'pl' && $d->month == $lastMonth) {
                $lastMonthLab = (int) $d->count_data;
            }
            if ($d->type == 'pl' && $d->month == $thisMonth) {
                $thisMonthLab = (int) $d->count_data;
            }

            if (!isset($newData[$d->month])) {
                $newData[$d->month] = $d->count_data;
            } else {
                $newData[$d->month] += $d->count_data;
            }
        }
        $persentaseAlat = ($thisMonthAlat - $lastMonthAlat) / ($lastMonthAlat == 0 ? $thisMonthAlat : $lastMonthAlat) * 100;
        $persentaseBuku = ($thisMonthBuku - $lastMonthBuku) / ($lastMonthBuku == 0 ? $thisMonthBuku : $lastMonthBuku) * 100;
        $persentaseLab = ($thisMonthLab - $lastMonthLab) / ($lastMonthLab == 0 ? $thisMonthLab : $lastMonthLab) * 100;

        // Make $newData to be 12 long array with int 0 as default value 
        for ($i = 1; $i < 13; $i++) {
            if (!isset($newData[$i])) {
                $newData[$i] = 0;
            }
        }

        return view('dashboard/index', [
            // 'user' => $user,
            'count_buku' => $thisMonthBuku,
            'count_alat' => $thisMonthAlat,
            'count_lab' => $thisMonthLab,
            'p_buku' => $persentaseBuku,
            'p_lab' => $persentaseLab,
            'p_alat' => $persentaseAlat,
            'data' => $newData,
        ]);
    }

    public function about()
    {
        $faculties = (new Faculty())->asObject()->findAll();
        $majors = (new Major())->asObject()->findAll();
        $data = [
            'faculties' => $faculties,
            'majors' => $majors,
            'user' => session('user'),
        ];
        return view('profile/profile', $data);
    }

    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();
        session()->remove('user');
        return redirect()->to('/login');
    }
}
