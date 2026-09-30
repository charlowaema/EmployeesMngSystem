<?php

// Create a StudentController method called show() that receives a student ID and displays: 
// Viewing student with ID: 10 
// Then create the corresponding route /students/10 using a route parameter. 



// 5. Route Parameters 
// Create a route that accepts both: 
//   /students/{id}/courses/{course} 
// For example: /students/15/courses/laravel 
// The controller should receive both $id and $course.

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/students', function(){
return "List Of Students"; //this is a string;
});

Route::get('/students', [StudentController::class, 'index'])->name('students.index');

Route::get('/students/{id}', [StudentController::class, 'show']);


Route::get('/students/{id}/courses/{course}', [StudentController::class, 'show']);

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

