<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Member;
use Carbon\Carbon;

class BorrowService
{
    public function borrow($idBook)
    {
        $member = Member::where('id', 1)->first();
        $member->sanksi = (bool)$member->sanksi;

        $book = Book::find($idBook);
        $book->borrow = (bool)$book->borrow;

        // Buku yang dipinjam tidak boleh dipinjam oleh anggota lain
        if ($book->borrow) {
            return "Buku sudah dipinjam";
        }

        // Anggota tidak boleh meminjam lebih dari 2 buku
        if (Book::where("id_member", $member->id)->count() >= 2) {
            return "Anggota tidak boleh meminjam lebih dari 2 buku";
        }

        // Buku yang dipinjam tidak boleh kosong
        if ($book->stock == 0) {
            return "Stock buku kosong";
        }

        // Anggota saat ini tidak sedang terkena sanksi
        if ($member->sanksi) {
            return "Anda sedang terkena sanksi, anda tidak dapat meminjam buku";
        }

        // update data book setelah di pinjam oleh member
        $book->stock = $book->stock - 1;
        $book->borrow = true;
        $book->id_member = $member->id;
        $book->borrow_date = now();
        $book->save();
        return $book;
    }

    public function return($idBook)
    {
        $member = Member::where('id', 1)->first();
        $books = Book::where([
            ['id_member', $member->id],
            ['id', $idBook]
        ])->first();

        // Buku yang dikembalikan adalah buku yang telah dipinjam oleh anggota
        if (is_null($books)) {
            return "Anda tidak meminjam buku ini, periksa kembali data buku yang anda pinjam";
        }

        // Jika buku dikembalikan setelah lebih dari 7 hari, anggota akan dikenakan denda. Anggota yang terkena denda tidak dapat meminjam buku selama 3 hari
        $borrowDate = Carbon::parse($books->borrow_date);

        if ($borrowDate->diffInDays(now()) > 7) {
            $member->sanksi = true;
            $member->sanksi_date = Carbon::now()->addDays(3)->toDateString();
            $member->save();
            return "Anda terkena denda, anda tidak dapat meminjam buku selama 3 hari";
        }

        // update data book setelah dikembalikan oleh member
        $books->stock = $books->stock + 1;
        $books->borrow = false;
        $books->id_member = null;
        $books->borrow_date = null;
        $books->save();
        return "buku " . $books->title . " author " . $books->author . " berhasil dikembalikan";
    }
}
