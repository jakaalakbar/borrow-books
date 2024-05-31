<?php

use App\Http\Controllers\BorrowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(BorrowController::class)->group(function () {
    Route::get('/borrow_book/{id_book}', 'borrowBook');
    Route::get('/return_book/{id_book}', 'returnBook');
    Route::get('/check_book', 'allBook');
    Route::get('/members', 'members');
});
