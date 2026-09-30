<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function show($id, $course){
        return "Viewing Student with id ".$id." who does ".$course;
    }
}
