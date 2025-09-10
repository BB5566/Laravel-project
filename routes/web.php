<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/students_excel', [StudentController::class, 'excel'])->name('students.excel');
Route::resource('students', StudentController::class);

// Route::get('/', function () {
//     return view('welcome');
// });
