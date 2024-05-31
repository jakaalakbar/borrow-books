<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class BorrowControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $mock = [
            [
                "code" => "JK-45",
                "title" => "Harry Potter",
                "author" => "J.K Rowling",
                "stock" => 1,
            ],
            [
                "code" => "SHR-1",
                "title" => "A Study in Scarlet",
                "author" => "Arthur Conan Doyle",
                "stock" => 1,
            ],
            [
                "code" => "TW-11",
                "title" => "Twilight",
                "author" => "Stephenie Meyer",
                "stock" => 1,
            ],
            [
                "code" => "HOB-83",
                "title" => "The Hobbit, or There and Back Again",
                "author" => "J.R.R. Tolkien",
                "stock" => 1,
            ],
            [
                "code" => "NRN-7",
                "title" => "The Lion, the Witch and the Wardrobe",
                "author" => "C.S. Lewis",
                "stock" => 1,
            ],
        ];

        foreach ($mock as $value) {
            Book::create([
                "code" => $value['code'],
                "title" => $value['title'],
                "author" => $value['author'],
                "stock" => $value['stock'],
            ]);
        }

        $mockMember = [
            [
                "code" => "M001",
                "name" => "Angga",
            ],
            [
                "code" => "M002",
                "name" => "Ferry",
            ],
            [
                "code" => "M003",
                "name" => "Putri",
            ],
        ];

        foreach ($mockMember as $value) {
            Member::create([
                "code" => $value['code'],
                "name" => $value['name'],
            ]);
        }
    }

    public function test_borrow_book_success()
    {
        $idBook = 1;
        $response = $this->get('/api/borrow_book/' . $idBook);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_borrow_book_not_found()
    {
        $idBook = 1;
        $response = $this->get('/api/borrow_books/' . $idBook);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_return_book_success()
    {
        $idBook = 1;
        $response = $this->get('/api/return_book/' . $idBook);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_return_book_not_found()
    {
        $idBook = 1;
        $response = $this->get('/api/return_books/' . $idBook);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
