<?php

namespace App\Http\Controllers;

use App\Services\BorrowService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BorrowController extends Controller
{
    protected $borrowService;

    public function __construct(BorrowService $borrowService)
    {
        $this->borrowService = $borrowService;
    }

    public function borrow(Request $request, $idBook)
    {
        $data = $this->borrowService->borrow($idBook);

        return response()->json([
            "code" => Response::HTTP_OK,
            "status" => Response::$statusTexts[Response::HTTP_OK],
            "data" => $data,
        ], Response::HTTP_OK);
    }
}
