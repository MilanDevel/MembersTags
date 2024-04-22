<?php

use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('members', [MemberController::class, 'index']);
Route::get('members/{id}', [MemberController::class, 'show']);
Route::delete('members/{id}', [MemberController::class, 'destroy']);
Route::post('members', [MemberController::class, 'store']);
Route::put('members/{id}', [MemberController::class, 'update']);
Route::post('members/{id}/tags', [MemberController::class, 'storeTag']);
Route::delete('members/{id}/tags/{tid}', [MemberController::class, 'destroyTag']);
