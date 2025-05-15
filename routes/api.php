<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JournalController;

// Books routes
Route::group(['prefix' => 'books'], function () {
    Route::get('/', [BookController::class, 'index']);
    Route::get('/most-visited', [BookController::class, 'mostVisited']);
    Route::get('/search', [BookController::class, 'search']); // Move search before {id}
    Route::get('/language', [BookController::class, 'filterByLanguage']);
    Route::get('/{id}', [BookController::class, 'show']);
    Route::post('/', [BookController::class, 'store']);
    Route::put('/{id}', [BookController::class, 'update']);
    Route::delete('/{id}', [BookController::class, 'destroy']);
});

// Departments routes
Route::group(['prefix' => 'departments'], function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::get('/{id}', [DepartmentController::class, 'show']);
    Route::get('/{id}/messages', [DepartmentController::class, 'getMessages']);
    Route::post('/', [DepartmentController::class, 'store']);
    Route::put('/{id}', [DepartmentController::class, 'update']);
    Route::delete('/{id}', [DepartmentController::class, 'destroy']);
});

// Messages routes
Route::group(['prefix' => 'messages'], function () {
    Route::get('/', [MessageController::class, 'index']);
    Route::get('/{id}', [MessageController::class, 'show']);
    Route::get('/department/{departmentId}', [MessageController::class, 'getByDepartment']);
    Route::post('/', [MessageController::class, 'store']);
    Route::put('/{id}', [MessageController::class, 'update']);
    Route::delete('/{id}', [MessageController::class, 'destroy']);
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Journals routes
Route::group(['prefix' => 'journals'], function () {
    Route::get('/', [JournalController::class, 'index']);
    Route::get('/search', [JournalController::class, 'search']);
    Route::get('/year', [JournalController::class, 'filterByYear']);
    Route::get('/{id}', [JournalController::class, 'show']);
    Route::post('/', [JournalController::class, 'store']);
    Route::put('/{id}', [JournalController::class, 'update']);
    Route::delete('/{id}', [JournalController::class, 'destroy']);
});

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
