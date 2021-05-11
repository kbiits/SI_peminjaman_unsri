<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\PeminjamanBukuModel;

class BookController extends BaseController
{
    public function index()
    {
        $books = (new BookModel())->orderBy('title')->findAll();
        return view('books/daftar_books', [
            'books' => $books
        ]);
    }

    public function pinjam($isbn)
    {
        $user = session('user');
        $data = [
            'book_isbn' => $isbn,
            'user_nim' => $user['nim'],
            'status' => 0,
            'dipinjam_pada' => date('Y-m-d'),
        ];
        $peminjaman_buku = new PeminjamanBukuModel();

        // Cek stok buku apakah masih tersedia
        $book = (new BookModel())->find($isbn);
        if ($book && $book->stock <= 0) {
            session()->setFlashdata('msg', 'Stock buku habis');
            return redirect()->back();
        }

        // Cek apakah buku sedang dipinjam oleh user atau user sedang menunggu konfirmasi admin terkait pengembalian bukunya
        $check = $peminjaman_buku->where('user_nim', $user['nim'])->where('book_isbn', $isbn)->findAll();
        // Get Last Record
        $check = $check[count($check) - 1];
        if ($check) {
            if ($check->status == 0) {
                session()->setFlashdata('msg', 'Buku tersebut sedang anda pinjam, silahkan kembalikan terlebih dahulu untuk meminjam kembali');
                return redirect()->back();
            } else if ($check->status == 2) {
                session()->setFlashdata('msg', 'Silahkan tunggu konfirmasi admin terkait pengembalian buku sebelum meminjam buku yang sama');
                return redirect()->back();
            }
        }


        // Decrement (Update) stok buku karena sedang dipinjam
        $bookModel = new BookModel();
        $updated = $bookModel->update($isbn, [
            'stock' => ($book->stock - 1),
        ]);
        $created = $peminjaman_buku->save($data);
        if ($updated && $created) {
            session()->setFlashdata('success', 'Permintaan pinjaman buku diterima, jangan lupa dikembalikan ya !!!');
            return redirect()->back();
        }
        session()->setFlashdata('msg', 'Gagal memproses pinjaman buku anda, silahkan coba lagi kembali');
        return redirect()->back();
    }

    public function show_by_user(): string
    {
        $user = session('user');
        $peminjaman_buku = new PeminjamanBukuModel();
        $peminjaman_buku = $peminjaman_buku->where('user_nim', $user['nim'])->where('status', '0')->orWhere('status', '2')->book()->orderBy('title')->findAll();
        return view('books/daftar_buku_pinjaman_saya', [
            'pinjaman' => $peminjaman_buku,
        ]);
    }

    /**
     * @param $isbn
     * @param $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function kembalikan($isbn, $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $user = session('user');

        $peminjamanBukuModel = new PeminjamanBukuModel();
        $peminjamanBuku = $peminjamanBukuModel->find($id);

        // Peminjaman tidak ditemukan
        if (!$peminjamanBuku) {
            session()->setFlashdata('msg', 'Data peminjaman tidak ditemukan');
            return redirect()->back();
        }

        // Status peminjaman telah dikembalikan
        if ($peminjamanBuku->status != 0) {
            session()->setFlashdata('msg', 'Gagal mengembalikan buku, buku telah dikembalikan sebelumnya');
            return redirect()->back();
        }

        // Update status menjadi menunggu konfirmasi admin
        $peminjamanBuku->status = '2';
        $peminjamanBuku->dikembalikan_pada = date('Y-m-d');
        $updatePeminjaman = $peminjamanBukuModel->builder()->update($peminjamanBuku->toArray(), "id = $peminjamanBuku->id");

        // Increment (Update) stock buku
        $bookModel = new BookModel();
        $book = $bookModel->find($isbn);
        if (!$book) {
            session()->setFlashdata('msg', 'Buku tidak ditemukan');
            return redirect()->back();
        }
        $newStock = $book->stock + 1;
        $book->stock = $newStock;
        $updateStockBuku = $bookModel->builder()->update($book->toArray(), "isbn = '$isbn'");

        if ($updatePeminjaman && $updateStockBuku) {
            session()->setFlashdata('warning', 'Berhasil Mengembalikan buku, silahkan tunggu konfirmasi admin terkait pengembalian buku tersebut');
            return redirect()->back();
        }

        session()->setFlashdata('msg', 'Gagal memproses pengembalian buku, silahkan coba lagi dalam beberapa saat');
        return redirect()->back();
    }

    // Admin mengonfirmasi pengembalian buku

    /**
     * @param $isbn
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function konfirmasi($isbn, $peminjaman_id): \CodeIgniter\HTTP\RedirectResponse
    {
        $peminjamanBukuModel = new PeminjamanBukuModel();
        $peminjamanBuku = $peminjamanBukuModel->find($peminjaman_id);
        if (!$peminjamanBuku) {
            session()->setFlashdata('msg', 'Data pinjaman tidak ditemukan');
            return redirect()->back();
        }
        $peminjamanBuku->status = '1';
        $peminjamanBuku->dikonfirmasi_pada = date('Y-m-d');
        $updated = $peminjamanBukuModel->update($peminjaman_id, $peminjamanBuku->toArray());
        if ($updated) {
            session()->setFlashdata('success', 'Pengembalian buku telah berhasil dikonfirmasi');
            return redirect()->back();
        }
        session()->setFlashdata('msg', 'Gagal mengonfirmasi pengembalian buku, silahkan coba lagi dalam beberapa saat');
        return redirect()->back();
    }

    public function history()
    {
        $user = session('user');
        $peminjaman_buku = new PeminjamanBukuModel();
        $peminjaman_buku = $peminjaman_buku->where('user_nim', $user['nim'])->book()->orderBy('title')->findAll();
        return view('books/history_pinjaman_buku_saya', [
            'pinjaman' => $peminjaman_buku,
        ]);
    }

    public function update($book_isbn)
    {
        $bookModel = new BookModel();
        $rules = $bookModel->getValidationRules();
        $messages = $bookModel->getValidationMessages();

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validation', $this->validator->getErrors());
            return redirect()->back();
        }

        $data = [
            'isbn' => $this->request->getVar('isbn'),
            'title' => $this->request->getVar('title'),
            'category' => $this->request->getVar('category'),
            'stock' => $this->request->getVar('stock'),
        ];

        $updated = $bookModel->update($book_isbn, $data);
        if (!$updated) {
            session()->setFlashdata('msg', 'Gagal memperbarui data, silahkan coba lagi dalam beberapa saat!');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil memperbarui data!');
        return redirect()->back();
    }

    public function destroy($book_isbn)
    {
        $deleted = (new BookModel())->delete($book_isbn);
        if (!$deleted) {
            session()->setFlashdata('msg', 'Gagal menghapus data, silahkan coba lagi dalam beberapa saat!');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menghapus data!');
        return redirect()->back();
    }

    public function show_create_form()
    {
        return view('books/form_create_books');
    }

    public function store()
    {
        $bookModel = new BookModel();
        $rules = $bookModel->getValidationRules();
        $messages = $bookModel->getValidationMessages();

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('validator', $this->validator);
            return redirect()->back();
        }

        $data = [
            'isbn' => $this->request->getVar('isbn'),
            'title' => $this->request->getVar('title'),
            'category' => $this->request->getVar('category'),
            'stock' => $this->request->getVar('stock'),
        ];

        $saved = $bookModel->builder()->insert($data, true)->resultID;

        if (!$saved) {
            session()->setFlashdata('msg', 'Gagal menambahkan data, silahkan coba lagi dalam beberapa saat!');
            return redirect()->back();
        }

        session()->setFlashdata('success', 'Berhasil menambahkan data!');
        return redirect()->back();
    }

    public function show_data_konfirmasi()
    {
        $model = new PeminjamanBukuModel();
        $data = $model->book()->user()->where('status', '2')->orderBy('title')->findAll();
        return view('books/daftar_books_konfirmasi', [
            'pinjaman' => $data
        ]);
    }

    public function history_all()
    {
        $model = new PeminjamanBukuModel();
        $data = $model->book()->user()->orderBy('title')->findAll();
        return view('books/all_history', [
            'pinjaman' => $data
        ]);
    }
}
