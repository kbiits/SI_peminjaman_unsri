<?php

namespace App\Controllers;

use App\Models\Faculty;
use App\Models\JadwalLabModel;
use App\Models\LabModel;
use App\Models\Major;
use App\Models\PeminjamanLabModel;

class LabController extends BaseController
{
    public function index()
    {

        $faculties = (new Faculty())->asObject()->findAll();
        $majors = (new Major())->asObject()->findAll();

        $labs = (new LabModel())->jadwal_peminjaman()->major()->faculty()
            ->orderBy('tanggal', 'ASC')->orderBy('jam_masuk', 'ASC')
            ->findAll();
        $newData = $this->mergeLabData($labs);
        return view('lab/daftar_lab', [
            'labs' => $newData,
            'majors' => $majors,
            'faculties' => $faculties,
        ]);
    }

    public function mergeLabData($data, $id = 'id')
    {
        $newData = array();
        foreach ($data as $d) {
            $newData[$d->$id][] = $d;
        }
        foreach ($newData as $key => $d) {
            $temp = new \StdClass();
            $oldTemp = $d[0];
            $temp->id = $oldTemp->id;
            $temp->name = $oldTemp->name;
            $temp->faculty = $oldTemp->faculty;
            $temp->major = $oldTemp->major;
            if (property_exists($oldTemp, 'status')) {
                $temp->status = $oldTemp->status;
            }
            if (property_exists($oldTemp, 'lab_id')) {
                $temp->lab_id = $oldTemp->lab_id;
            }
            if (isset($oldTemp->status_lab)) {
                $temp->status_lab = $oldTemp->status_lab;
            }
            if (isset($oldTemp->faculty_id)) {
                $temp->faculty_id = $oldTemp->faculty_id;
            }
            if (isset($oldTemp->major_id)) {
                $temp->major_id = $oldTemp->major_id;
            }
            $temp->jadwals = array();
            foreach ($d as $j) {
                $tempJadwal = new \StdClass();
                $tempJadwal->tanggal = $j->tanggal;
                $tempJadwal->jam_masuk = $j->jam_masuk;
                $tempJadwal->jam_keluar = $j->jam_keluar;
                $temp->jadwals[] = $tempJadwal;
            }
            $newData[$key] = $temp;
        }
        return $newData;
    }

    public function show_by_user()
    {
        $user_nim = session('user')['nim'];
        $data = (new PeminjamanLabModel())->lab()->jadwal()->where('user_nim', $user_nim)
            ->where('tanggal >= ', date('Y-m-d'))->where('jam_keluar >=', date('H:i'))
            ->get()->getResult();
        return view('lab/daftar_lab_pinjaman_saya', [
            'pinjaman' => $data,
        ]);
    }

    public function history()
    {
        $user_nim = session('user')['nim'];
        $data = (new PeminjamanLabModel())->lab()->jadwal()->where('user_nim', $user_nim)->get()->getResult();
        $newData = static::mergeLabData($data, 'lab_id');
        return view('lab/history_pemakaian_lab', [
            'pinjaman' => $newData
        ]);
    }

    public function pinjam($lab_id)
    {
        $rules = [
            'tanggal' => 'required|valid_date[Y-m-d]',
            'jam_masuk' => 'required|valid_date[H:i]',
            'jam_keluar' => 'required|valid_date[H:i]',
        ];

        $messages = [
            'tanggal' => [
                'valid_date' => 'Format tanggal tidak valid',
            ],
            'jam_masuk' => [
                'valid_date' => 'Format jam masuk tidak valid',
            ],
            'jam_keluar' => [
                'valid_date' => 'Format jam keluar tidak valid',
            ]
        ];

        if ($this->validate($rules, $messages)) {

            $tanggal = $this->request->getVar('tanggal');
            $jam_masuk = $this->request->getVar('jam_masuk');
            $jam_keluar = $this->request->getVar('jam_keluar');

            if ($jam_masuk >= $jam_keluar) {
                session()->setFlashdata('msg', "Jadwal anda tidak valid");
                return redirect()->back();
            }

            $peminjamanModel = new PeminjamanLabModel();
            $check = $peminjamanModel->where('lab_id', $lab_id)->jadwal()->asArray()->where('jadwal_lab.tanggal', $tanggal)
                ->orderBy('tanggal')->orderBy('jam_masuk')
                ->get()->getResult();
            $newDate = new \StdClass();
            $newDate->tanggal = $tanggal;
            $newDate->jam_masuk = $jam_masuk;
            $newDate->jam_keluar = $jam_keluar;
            $check[] = $newDate;
            $isValidated = static::checkDates($check);
            if ($isValidated) {
                $jadwal = (new JadwalLabModel)->insert($newDate, true);
                if ($jadwal) {
                    $dataPeminjaman = $peminjamanModel->save([
                        'user_nim' => session('user')['nim'],
                        'lab_id' => $lab_id,
                        'jadwal_id' => $jadwal,
                        'status' => '0',
                    ]);

                    if (!$dataPeminjaman) {
                        session()->setFlashdata('msg', "Gagal memproses permintaan anda, silahkan coba lagi");
                        return redirect()->back();
                    }

                    session()->setFlashdata('success', 'Berhasil melakukan reservasi peminjaman lab');
                    return redirect()->back();
                } else {
                    session()->setFlashdata('msg', "Gagal memproses permintaan anda, silahkan coba lagi");
                    return redirect()->back();
                }
            } else {
                session()->setFlashdata('msg', "Jadwal yang anda masukkan bertabrakan dengan jadwal lain, silahkan ganti jadwal anda");
                return redirect()->back();
            }
        } else {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('validation', $errors);
            return redirect()->back();
        }
    }

    public static function checkDates($ranges)
    {
        // Comparison loop is of size n•log(n), not doing any redundant comparisons
        for ($i = 0; $i < sizeof($ranges); $i++) {
            for ($j = $i + 1; $j < sizeof($ranges); $j++) {
                if (static::intersects($ranges[$i], $ranges[$j])) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function intersects($lhs, $rhs)
    {
        // Note that this function allows ranges that "touch",
        // eg. one pair starts at the exact same time that the other ends.
        // Adding less "or equal to" will allow same start date
        return !($lhs->jam_masuk > $rhs->jam_keluar || $lhs->jam_keluar < $rhs->jam_masuk);
    }

    public function show_create_form()
    {
        $faculties = (new Faculty())->asObject()->findAll();
        $majors = (new Major())->asObject()->findAll();
        return view('lab/form_create_labs', [
            'faculties' => $faculties,
            'majors' => $majors,
        ]);
    }

    public function store()
    {
        $labModel = new LabModel();
        $rules = $labModel->getValidationRules();
        $messages = $labModel->getValidationMessages();
        unset($rules['status_lab']);

        if ($this->validate($rules, $messages)) {
            $data = [
                'name' => $this->request->getVar('name'),
                'faculty_id' => $this->request->getVar('faculty_id'),
                'status_lab' => '0',
            ];

            if ($this->request->getVar('major_id') !== 'null') {
                $data['major_id'] = $this->request->getVar('major_id');
            }

            $saved = $labModel->save($data);
            if ($saved) {
                session()->setFlashdata('success', 'Berhasil menambahkan laboratorium');
                return redirect()->back();
            }
            session()->setFlashdata('msg', 'Gagal menambahkan laboratorium, Silahkan coba lagi');
            return redirect()->back();
        } else {
            session()->setFlashdata('validator', $this->validator);
            return redirect()->back();
        }
    }

    public function update($id)
    {
        $labModel = new LabModel();
        $rules = $labModel->getValidationRules();
        $messages = $labModel->getValidationMessages();
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validation', $this->validator->getErrors());
            return redirect()->back();
        }

        $data = [
            'name' => $this->request->getVar('name'),
            'faculty_id' => $this->request->getVar('faculty_id'),
            'status_lab' => $this->request->getVar('status_lab'),
        ];

        if ($this->request->getVar('major_id') !== 'null') {
            $data['major_id'] = $this->request->getVar('major_id');
        }

        $updated = $labModel->update($id, $data);
        if (!$updated) {
            session()->setFlashdata('msg', 'Gagal memperbarui data, silahkan coba lagi dalam beberapa saat');
            return redirect()->back();
        }
        session()->setFlashdata('success', 'Data telah berhasil diupdate');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $labModel = new LabModel();
        $deleted = $labModel->delete($id)->resultID;
        if (!$deleted) {
            session()->setFlashdata('msg', 'Gagal menghapus data, silahkan coba lagi dalam beberapa saat');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Data telah berhasil dihapus');
        return redirect()->back();
    }

    public function history_all()
    {
        $peminjamanLabModel = new PeminjamanLabModel();
        $data = $peminjamanLabModel->user()->lab()->jadwal()->asObject()->orderBy('name')->findAll();
        return view('lab/all_history', [
            'pinjaman' => $data,
        ]);
    }

    public function update_pinjaman($lab_id, $jadwal_id)
    {
        $jadwalModel = new JadwalLabModel();
        $rules = $jadwalModel->getValidationRules();
        $messages = [
            'tanggal' => [
                'valid_date' => 'Format tanggal tidak valid',
            ],
            'jam_masuk' => [
                'valid_date' => 'Format jam masuk tidak valid',
            ],
            'jam_keluar' => [
                'valid_date' => 'Format jam keluar tidak valid',
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validation', $this->validator->getErrors());
            return redirect()->back();
        }

        $data = [
            'tanggal' => $this->request->getVar('tanggal'),
            'jam_masuk' => $this->request->getVar('jam_masuk'),
            'jam_keluar' => $this->request->getVar('jam_keluar'),
        ];

        if ($data['jam_masuk'] > $data['jam_keluar']) {
            session()->setFlashdata('warning', 'Jadwal tidak valid, silahkan ubah jadwal anda');
            return redirect()->back();
        }

        $peminjamanModel = new PeminjamanLabModel();
        $check = $peminjamanModel->where('lab_id', $lab_id)->jadwal()->asObject()->where('jadwal_lab.tanggal', $data['tanggal'])
            ->orderBy('tanggal')->orderBy('jam_masuk')->findAll();
        $is_validated = static::checkDates($check);
        if (!$is_validated) {
            session()->setFlashdata('msg', "Jadwal yang anda masukkan bertabrakan dengan jadwal lain, silahkan ganti jadwal anda");
            return redirect()->back();
        }

        $updated = $jadwalModel->update($jadwal_id, $data);
        if (!$updated) {
            session()->setFlashdata('msg', 'Gagal memperbaru data, silahkan coba lagi dalam beberapa saat!');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil memperbarui data');
        return redirect()->back();
    }

    public function delete_pinjaman($id_jadwal)
    {
        // Delete parent record also delete child record
        $deleted = (new JadwalLabModel())->delete($id_jadwal);

        if (!$deleted) {
            session()->setFlashdata('msg', 'Gagal menghapus data, silahkan coba lagi');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menghapus data!');
        return redirect()->back();
    }
}
