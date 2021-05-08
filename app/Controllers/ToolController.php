<?php

namespace App\Controllers;

use App\Models\Faculty;
use App\Models\Major;
use App\Models\PeminjamanAlatModel;
use App\Models\ToolModel;

class ToolController extends BaseController
{

    /**
     * Display all tools
     *
     * @return string
     */
    public function index()
    {
        $majors = (new Major())->asObject()->findAll();
        $faculties = (new Faculty())->asObject()->findAll();
        $tools = (new ToolModel())->major()->faculty()->findAll();
        return view('tools/daftar_tools', [
            'tools' => $tools,
            'faculties' => $faculties,
            'majors' => $majors,
        ]);
    }

    /**
     * Display peminjaman user
     *
     * @return string
     */
    public function show_by_user()
    {
        $user = session('user');
        $peminjamanModel = new PeminjamanAlatModel();
        $dataPinjaman = $peminjamanModel
            ->tool()
            ->where('user_nim', $user['nim'])
            ->where('status', '0', true)
            ->orWhere('status', '2', true)
            ->get()->getResult();
        return view('tools/daftar_tools_pinjaman_saya', [
            'pinjaman' => $dataPinjaman,
        ]);
    }

    /**
     * Pinjam alat
     *
     * @throws \ReflectionException
     */
    public function pinjam($id)
    {
        $user_nim = session('user')['nim'];
        $data = [
            'tools_id' => $id,
            'user_nim' => $user_nim,
            'status' => '0',
            'dipinjam_pada' => date('Y-m-d'),
        ];
        $peminjamanAlatModel = new PeminjamanAlatModel();

        // Cek stok alat
        $alat1 = (new ToolModel())->find($id);
        if ($alat1 && $alat1->stock <= 0) {
            session()->setFlashdata('msg', 'Stock alat habis');
            return redirect()->back();
        }

        // Cek apakah alat sedang dipinjam oleh user atau user sedang menunggu konfirmasi admin terkait pengembalian alatnya
        $check = $peminjamanAlatModel->where('user_nim', $user_nim)->where('tools_id', $id)->asObject()->first();
        if ($check) {
            if ($check->status == '0') {
                session()->setFlashdata('msg', 'Alat tersebut sedang anda pinjam, silahkan kembalikan terlebih dahulu untuk meminjam kembali');
                return redirect()->back();
            } else if ($check->status == '2') {
                session()->setFlashdata('msg', 'Silahkan tunggu konfirmasi admin terkait pengembalian alat sebelum meminjam alat yang sama');
                return redirect()->back();
            }
        }

        // Decrement (Update) stok alat karena alat sedang dipinjam
        $alat = new ToolModel();
        $updated = $alat->update($id, [
            'stock' => ($alat1->stock) - 1,
        ]);
        $created = $peminjamanAlatModel->save($data);
        if ($updated && $created) {
            session()->setFlashdata('success', 'Permintaan pinjaman alat diterima, jangan lupa dikembalikan ya !!!');
            return redirect()->back();
        }
        session()->setFlashdata('msg', 'Gagal memproses pinjaman alat anda, silahkan coba lagi kembali');
        return redirect()->back();
    }

    public function kembalikan($tools_id, $id)
    {
        $user_nim = session('user')['nim'];

        $peminjamanAlatModel = new PeminjamanAlatModel();
        $peminjamanAlat = $peminjamanAlatModel->find($id);

        // Peminjaman tidak ditemukan
        if (!$peminjamanAlat) {
            session()->setFlashdata('msg', 'Data peminjaman tidak ditemukan');
            return redirect()->back();
        }

        // Status peminjaman telah dikembalikan
        if ($peminjamanAlat['status'] != '0') {
            session()->setFlashdata('msg', 'Gagal mengembalikan alat, alat telah dikembalikan sebelumnya');
            return redirect()->back();
        }

        // Update status menjadi menunggu konfirmasi admin
        $peminjamanAlat['status'] = '2';
        $peminjamanAlatId = $peminjamanAlat['id'];
        $peminjamanAlat['dikembalikan_pada'] = date('Y-m-d');
        $updatePeminjaman = $peminjamanAlatModel->builder()->update($peminjamanAlat, "id = $peminjamanAlatId");

        // Increment (Update) stock alat
        $alatModel = new ToolModel();
        $alat = $alatModel->find($tools_id);
        if (!$alat) {
            session()->setFlashdata('msg', 'Alat tidak ditemukan');
            return redirect()->back();
        }
        $alat->stock = $alat->stock++;
        $updateStockAlat = $alatModel->builder()->update($alat->toArray(), "id = $tools_id", 1);

        if ($updatePeminjaman && $updateStockAlat) {
            session()->setFlashdata('warning', 'Berhasil mengembalikan alat, silahkan tunggu konfirmasi admin terkait pengembalian alat tersebut');
            return redirect()->back();
        }

        session()->setFlashdata('msg', 'Gagal memproses pengembalian alat, silahkan coba lagi dalam beberapa saat');
        return redirect()->back();
    }


    /**
     * Menampilkan Riwayat Pinjaman Alat oleh User
     *
     */
    public function history()
    {
        $user_nim = session('user')['nim'];
        $peminjamanAlat = new PeminjamanAlatModel();
        $dataPeminjaman = $peminjamanAlat->where('user_nim', $user_nim)->tool()->asObject()->get()->getResult();
        return view('tools/history_pinjaman_alat_saya', [
            'pinjaman' => $dataPeminjaman,
        ]);

    }

    public function konfirmasi($tool_id, $user_nim)
    {
        $peminjamanAlatModel = new PeminjamanAlatModel();
        $peminjamanAlat = $peminjamanAlatModel->where('user_nim', $user_nim)->where('tools_id', $tool_id)->first();
        if (!$peminjamanAlat) {
            session()->setFlashdata('msg', 'Data pinjaman tidak ditemukan');
            return redirect()->back();
        }
        $peminjamanAlat['status'] = '1';
        $peminjamanAlat['dikonfirmasi_pada'] = date('Y-m-d');
        $peminjamanId = $peminjamanAlat['id'];
        $updated = $peminjamanAlatModel->builder()->update($peminjamanAlat, "id = $peminjamanId", 1);
        if ($updated) {
            session()->setFlashdata('success', 'Pengembalian alat telah berhasil dikonfirmasi');
            return redirect()->back();
        }
        session()->setFlashdata('msg', 'Gagal mengonfirmasi pengembalian alat, silahkan coba lagi dalam beberapa saat');
        return redirect()->back();
    }

    public function show_create_form()
    {
        $majors = (new Major())->asObject()->findAll();
        $faculties = (new Faculty())->asObject()->findAll();
        return view('tools/form_create_tools', [
            'faculties' => $faculties,
            'majors' => $majors,
        ]);
    }

    public function store()
    {
        $toolModel = new ToolModel();
        $rules = $toolModel->getValidationRules();
        $messages = $toolModel->getValidationMessages();

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validator', $this->validator);
            return redirect()->back();
        }

        $data = [
            'name' => $this->request->getVar('name'),
            'faculty_id' => $this->request->getVar('faculty_id'),
            'stock' => $this->request->getVar('stock'),
        ];

        if ($this->request->getVar('major_id') !== 'null') {
            $data['major_id'] = $this->request->getVar('major_id');
        }

        $saved = $toolModel->save($data);
        if (!$saved) {
            session()->setFlashdata('msg', 'Gagal menambahkan alat, silahkan coba lagi');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menambahkan alat');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $toolModel = new ToolModel();
        $deleted = $toolModel->delete($id)->resultID;

        if (!$deleted) {
            session()->setFlashdata('msg', 'Gagal menghapus data, silahkan coba lagi dalam beberapa saat');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Data telah berhasil dihapus');
        return redirect()->back();
    }

    public function update($id)
    {
        $toolModel = new ToolModel();
        $rules = $toolModel->getValidationRules();
        $messages = $toolModel->getValidationMessages();
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validation', $this->validator->getErrors());
            return redirect()->back();
        }

        $data = [
            'name' => $this->request->getVar('name'),
            'faculty_id' => $this->request->getVar('faculty_id'),
            'stock' => $this->request->getVar('stock'),
        ];

        if ($this->request->getVar('major_id') !== 'null') {
            $data['major_id'] = $this->request->getVar('major_id');
        }

        $updated = $toolModel->update($id, $data);
        if (!$updated) {
            session()->setFlashdata('msg', 'Gagal memperbarui data, silahkan coba lagi dalam beberapa saat');
            return redirect()->back();
        }
        session()->setFlashdata('success', 'Data telah berhasil diupdate');
        return redirect()->back();
    }

    public function show_data_konfirmasi()
    {
        $peminjamanAlatModel = new PeminjamanAlatModel();
        $data = $peminjamanAlatModel->tool()->user()->where('status', '2')->get()->getResult();
        return view('tools/daftar_tools_konfirmasi', [
            'pinjaman' => $data,
        ]);
    }

    public function history_all()
    {
        $peminjamanAlatModel = new PeminjamanAlatModel();
        $data = $peminjamanAlatModel->tool()->user()->asObject()->findAll();
        return view('tools/all_history', [
            'pinjaman' => $data,
        ]);
    }

}
