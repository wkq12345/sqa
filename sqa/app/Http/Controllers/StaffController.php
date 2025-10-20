<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController
{
    //staff dashboard
    public function dashboard()
    {
        return view('staff.dashboard');
    }
}
