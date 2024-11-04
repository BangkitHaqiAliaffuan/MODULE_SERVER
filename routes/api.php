<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::delete('/course/delete/{id}', [CourseController::class, 'destroy']);
Route::put('/course/update/{id}', [CourseController::class, 'update'])->middleware('auth:sanctum');
Route::post('/register', [UserController::class, 'register']);
Route::get('/logout', [UserController::class, 'logout']);
Route::get('/course', [CourseController::class, 'showPublishedCourses']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/course/create', [CourseController::class, 'create'])->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
