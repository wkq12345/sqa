<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController
{
    public function dashboard()
    {
        return view('student.dashboard');
    }
}
