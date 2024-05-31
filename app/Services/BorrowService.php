<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Member;

class BorrowService
{
    public function borrow($idBook)
    {
        // Anggota tidak boleh meminjam lebih dari 2 buku
        $member = Member::where('id', 1)->first();
        $books = json_decode($member->books);
        if (!is_null($books) && count($books) >= 2) {
            return "Anda tidak boleh meminjam lebih dari 2 buku";
        }

        // Buku yang dipinjam tidak boleh dipinjam oleh anggota lain
        $book = Book::find($idBook);
        $book->borrow = (bool)$book->borrow;
        if ($book->borrow) {
            return "Buku sudah dipinjam";
        }

        // Buku yang dipinjam tidak boleh kosong
        if ($book->stock == 0) {
            return "Stock buku kosong";
        }

        // Anggota saat ini tidak sedang terkena sanksi


        // $book = Book::find($idBook);

        // Member::where('id', 1)->update(['books' => json_encode($book)]);

        // $book->stock = $book->stock - 1;
        // $book->save();
    }
}
